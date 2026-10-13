<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;
use ZipArchive;

class DocumentWorkflowTest extends TestCase
{
    use LazilyRefreshDatabase;

    /** @return array<string, array{string}> */
    public static function formats(): array
    {
        return ['PDF' => ['pdf'], 'DOCX table' => ['docx']];
    }

    #[DataProvider('formats')]
    public function test_document_analysis_review_and_proposal_remain_revision_bound(string $format): void
    {
        config(['ai_analysis.driver' => 'demo']);
        Http::preventStrayRequests();
        $owner = User::factory()->create();
        $reviewer = User::factory()->create(['is_reviewer' => true]);
        $project = Project::factory()->create(['user_id' => $owner->id, 'reviewer_id' => $reviewer->id]);
        $text = 'Customers need order tracking.';
        $path = $this->documentPath($format, $text);

        try {
            $this->actingAs($owner)->post(route('sources.store', $project), [
                'kind' => 'document', 'priority' => 'Must',
                'file' => new UploadedFile($path, 'fictional-requirements.'.$format, null, null, true),
            ])->assertRedirect(route('projects.show', $project));
            $source = $project->sources()->firstOrFail();
            $this->assertSame($text, $source->original);
            $this->assertSame($format, $source->metadata['document_format']);
            $this->assertFalse($source->metadata['client_confirmed']);
            $this->post(route('analysis.store', $project))->assertRedirect();
            $project->refresh();
            $analysis = $project->analyses()->latest('id')->firstOrFail();
            $this->assertSame('complete', $analysis->status);
            $this->assertSame([$source->id], $analysis->results['extraction']['items'][0]['source_ids']);
            $this->assertSame([$text], $analysis->results['extraction']['items'][0]['statements']);

            $this->actingAs($reviewer);
            foreach (['changes_requested', 'rejected'] as $decision) {
                $this->post(route('approvals.store', $project), [
                    'revision' => $project->revision, 'decision' => $decision,
                    'notes' => 'Automated fictional workflow fixture; no human sign-off.',
                ])->assertRedirect();
                $this->assertFalse($project->isApproved());
                $this->post(route('proposal.store', $project), $this->proposalData($project))->assertUnprocessable();
            }
            $this->assertDatabaseCount('artifacts', 0);
            $this->post(route('reviews.store', $project), [
                'revision' => $project->revision, 'module' => 'classification', 'index' => 0,
                'title' => 'Order tracking', 'scope' => 'included', 'priority' => 'Must', 'category' => 'Functional',
                'notes' => 'Candidate deliverable for fixture only.', 'decision' => 'edited',
            ])->assertRedirect();
            $project->refresh();
            $scopeRevision = $project->revision;
            $this->post(route('approvals.store', $project), [
                'revision' => $scopeRevision, 'decision' => 'approved',
                'notes' => 'Automated authorization fixture; not a real acceptance.',
            ])->assertRedirect();
            $this->assertSame('AI Inferred', $project->analyses()->latest('id')->firstOrFail()->results['classification']['items'][0]['provenance']);
            $this->post(route('proposal.store', $project), $this->proposalData($project) + [
                'payment_structure' => 'Not agreed; fictional milestone discussion only.',
                'support' => 'Not agreed; reviewer must define duration.',
            ])->assertRedirect();
            $proposal = $project->artifacts()->where('kind', 'proposal')->firstOrFail()->content;
            $this->assertSame($scopeRevision, $proposal['scope_revision']);
            $this->assertSame('Order tracking', $proposal['deliverables'][0]['title']);
            $this->assertSame('Functional', $proposal['deliverables'][0]['category']);
            $this->assertSame('Not entered', $proposal['pricing']);
            $this->assertNull($proposal['estimate']['effort_hours']);
            $this->assertSame('Not agreed; fictional milestone discussion only.', $proposal['payment_structure']);
            $this->assertSame('Not agreed; reviewer must define duration.', $proposal['support']);
            $this->assertStringContainsString('Nonbinding draft', $proposal['commitment_notice']);
            $this->assertFalse($project->refresh()->isApproved());
            $this->post(route('approvals.store', $project), [
                'revision' => $scopeRevision, 'decision' => 'approved', 'notes' => 'Stale fixture',
            ])->assertConflict();
            $this->assertDatabaseCount('approvals', 3);
            Http::assertNothingSent();
        } finally {
            @unlink($path);
        }
    }

    public function test_renamed_html_and_oversized_uploads_create_no_source_or_revision(): void
    {
        $owner = User::factory()->create();
        $project = Project::factory()->create(['user_id' => $owner->id]);
        $this->actingAs($owner);
        foreach ([
            UploadedFile::fake()->createWithContent('requirements.docx', '<html>Not a document</html>'),
            UploadedFile::fake()->create('requirements.pdf', 10241, 'application/pdf'),
        ] as $file) {
            $this->post(route('sources.store', $project), [
                'kind' => 'document', 'priority' => 'Must', 'file' => $file,
            ])->assertSessionHasErrors('file');
        }
        $this->assertDatabaseCount('sources', 0);
        $this->assertDatabaseCount('audit_events', 0);
        $this->assertSame(1, $project->fresh()->revision);
    }

    /** @return array<string, array{string, string}> */
    public static function invalidDocuments(): array
    {
        return [
            'malformed PDF' => ['pdf', '%PDF-1.4 invalid'],
            'malformed DOCX' => ['docx', 'not a zip archive'],
            'textless PDF' => ['pdf', 'textless'],
            'encrypted PDF' => ['pdf', 'encrypted'],
            'extracted text limit' => ['docx', 'too much text'],
            'generic ZIP' => ['docx', 'generic zip'],
            'expanded archive limit' => ['docx', 'expanded zip'],
        ];
    }

    #[DataProvider('invalidDocuments')]
    public function test_invalid_documents_fail_without_persisting_evidence(string $format, string $fixture): void
    {
        $owner = User::factory()->create();
        $project = Project::factory()->create(['user_id' => $owner->id]);
        $path = tempnam(sys_get_temp_dir(), 'codly-invalid-');
        $this->assertNotFalse($path);
        if ($fixture === 'textless' || $fixture === 'encrypted') {
            file_put_contents($path, $this->pdf('', $fixture === 'encrypted'));
        } elseif ($fixture === 'too much text') {
            @unlink($path);
            $path = $this->documentPath('docx', str_repeat('x', 50001));
        } elseif ($fixture === 'generic zip' || $fixture === 'expanded zip') {
            $archive = new ZipArchive;
            $this->assertTrue($archive->open($path, ZipArchive::CREATE | ZipArchive::OVERWRITE));
            $archive->addFromString('[Content_Types].xml', '<Types/>');
            if ($fixture === 'expanded zip') {
                $archive->addFromString('word/document.xml', str_repeat('x', 21 * 1024 * 1024));
            }
            $archive->close();
        } else {
            file_put_contents($path, $fixture);
        }

        try {
            $response = $this->actingAs($owner)->post(route('sources.store', $project), [
                'kind' => 'document', 'priority' => 'Must',
                'file' => new UploadedFile($path, 'fictional.'.$format, null, null, true),
            ]);
            $response->assertSessionHasErrors('file');
            $this->assertDatabaseCount('sources', 0);
            $this->assertDatabaseCount('audit_events', 0);
            $this->assertSame(1, $project->fresh()->revision);
        } finally {
            @unlink($path);
        }
    }

    public function test_unassigned_user_cannot_upload_to_another_project(): void
    {
        $project = Project::factory()->create();
        $this->actingAs(User::factory()->create())->post(route('sources.store', $project), [
            'kind' => 'document', 'priority' => 'Must',
            'file' => UploadedFile::fake()->createWithContent('fictional.pdf', $this->pdf('Fictional requirement')),
        ])->assertNotFound();
        $this->assertDatabaseCount('audit_events', 0);
        $this->assertDatabaseCount('artifacts', 0);
        $this->assertDatabaseCount('sources', 0);
        $this->assertSame(1, $project->fresh()->revision);
    }

    /** @return array<string, mixed> */
    private function proposalData(Project $project): array
    {
        return ['revision' => $project->revision, 'maintenance' => 'Not agreed',
            'third_party_costs' => 'Client approval required', 'client_responsibilities' => 'Supply acceptance criteria'];
    }

    private function documentPath(string $format, string $text): string
    {
        $path = tempnam(sys_get_temp_dir(), 'codly-document-');
        $this->assertNotFalse($path);
        if ($format === 'pdf') {
            file_put_contents($path, $this->pdf($text));
        } else {
            $document = new PhpWord;
            $table = $document->addSection()->addTable();
            $table->addRow();
            $table->addCell()->addText($text);
            IOFactory::createWriter($document, 'Word2007')->save($path);
        }

        return $path;
    }

    private function pdf(string $text, bool $encrypted = false): string
    {
        $stream = 'BT /F1 12 Tf 72 720 Td ('.$text.') Tj ET';
        $objects = [
            '<< /Type /Catalog /Pages 2 0 R >>',
            '<< /Type /Pages /Kids [3 0 R] /Count 1 >>',
            '<< /Type /Page /Parent 2 0 R /MediaBox [0 0 612 792] /Resources << /Font << /F1 5 0 R >> >> /Contents 4 0 R >>',
            '<< /Length '.strlen($stream)." >>\nstream\n".$stream."\nendstream",
            '<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica >>',
        ];
        if ($encrypted) {
            $objects[] = '<< /Filter /Standard /V 1 /R 2 /Length 40 >>';
        }
        $pdf = "%PDF-1.4\n";
        $offsets = [];
        foreach ($objects as $index => $object) {
            $offsets[] = strlen($pdf);
            $pdf .= ($index + 1)." 0 obj\n".$object."\nendobj\n";
        }
        $xref = strlen($pdf);
        $pdf .= "xref\n0 ".(count($objects) + 1)."\n0000000000 65535 f \n";
        foreach ($offsets as $offset) {
            $pdf .= sprintf("%010d 00000 n \n", $offset);
        }
        $pdf .= "trailer\n<< /Size ".(count($objects) + 1).' /Root 1 0 R'.($encrypted ? ' /Encrypt 6 0 R' : '')." >>\nstartxref\n".$xref."\n%%EOF";

        return $pdf;
    }
}
