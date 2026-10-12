<?php

namespace App\Http\Controllers;

use App\DocumentExtractor;
use App\Http\Requests\StoreSourceRequest;
use App\Models\Project;
use App\WorkspaceRevision;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;
use RuntimeException;

class SourceController extends Controller
{
    public function store(
        StoreSourceRequest $request,
        Project $project,
        WorkspaceRevision $revisions,
        DocumentExtractor $extractor
    ): RedirectResponse {
        $data = $request->validated();

        $sourceText = $data['original'] ?? null;
        $documentMetadata = [];

        if ($data['kind'] === 'document') {
            $file = $request->file('file');
            $format = strtolower($file->getClientOriginalExtension());

            try {
                $sourceText = $extractor->extract(
                    $file->getRealPath(),
                    $format
                );
            } catch (RuntimeException $exception) {
                throw ValidationException::withMessages([
                    'file' => $exception->getMessage(),
                ]);
            }

            if (mb_strlen($sourceText) > 50000) {
                throw ValidationException::withMessages([
                    'file' => 'Extracted text exceeds the 50,000-character source limit.',
                ]);
            }

            $filename = basename($file->getClientOriginalName());
            $filename = preg_replace('/[\x00-\x1F\x7F]/u', '', $filename) ?? '';

            $documentMetadata = [
                'source_filename' => mb_substr($filename, 0, 255),
                'document_format' => $format,
                'extraction_method' => 'local_pdfparser_phpword',
            ];
        }

        DB::transaction(function () use (
            $request,
            $project,
            $revisions,
            $data,
            $sourceText,
            $documentMetadata
        ): void {
            $locked = Project::whereKey($project->id)
                ->lockForUpdate()
                ->firstOrFail();

            Gate::authorize('contribute', $locked);

            abort_if(
                $locked->sources()->count() >= 100,
                422,
                'MVP limit: 100 sources per project.'
            );

            $total = $locked->sources()
                ->pluck('original')
                ->sum(fn (string $text): int => mb_strlen($text));

            abort_if(
                $total + mb_strlen($sourceText) > 200000,
                422,
                'MVP limit: 200,000 total source characters per project.'
            );

            $locked->sources()->create([
                'user_id' => $request->user()->id,
                'kind' => $data['kind'],
                'original' => $sourceText,
                'metadata' => array_merge([
                    'priority' => $data['priority'],
                    'role' => $data['role'] ?? null,
                    'feature' => $data['feature'] ?? null,
                    'reference' => $data['reference'] ?? null,
                    'client_confirmed' => false,
                ], $documentMetadata),
            ]);

            $revisions->advance(
                $locked,
                $request->user(),
                'source_submitted'
            );
        });

        return redirect()->route('projects.show', $project);
    }
}
