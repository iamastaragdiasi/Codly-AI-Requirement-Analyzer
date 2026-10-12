<?php

namespace Tests\Unit;

use App\DocumentExtractor;
use PHPUnit\Framework\TestCase;
use RuntimeException;

class DocumentExtractorTest extends TestCase
{
    public function test_rejects_unsupported_format(): void
    {
        $this->expectException(RuntimeException::class);
        (new DocumentExtractor)->extract(__FILE__, 'txt');
    }

    public function test_rejects_missing_file(): void
    {
        $this->expectException(RuntimeException::class);
        (new DocumentExtractor)->extract(
            sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'missing-document-' . uniqid() . '.pdf',
            'pdf'
        );
    }

    public function test_rejects_empty_or_invalid_pdf(): void
    {
        $path = tempnam(sys_get_temp_dir(), 'codly-');
        self::assertNotFalse($path);

        try {
            file_put_contents($path, 'not a valid PDF');
            $this->expectException(RuntimeException::class);
            (new DocumentExtractor)->extract($path, 'pdf');
        } finally {
            @unlink($path);
        }
    }
    public function test_extracts_text_from_valid_docx(): void
    {
        $path = tempnam(sys_get_temp_dir(), 'codly-docx-');
        self::assertNotFalse($path);

        $docxPath = $path . '.docx';
        @unlink($path);

        try {
            $document = new \PhpOffice\PhpWord\PhpWord();
            $section = $document->addSection();
            $section->addText('Customers need an order tracking dashboard.');

            $writer = \PhpOffice\PhpWord\IOFactory::createWriter(
                $document,
                'Word2007'
            );
            $writer->save($docxPath);

            $text = (new DocumentExtractor())->extract($docxPath, 'docx');

            self::assertStringContainsString(
                'Customers need an order tracking dashboard.',
                $text
            );
        } finally {
            @unlink($docxPath);
        }
    }
    public function test_extracts_text_from_valid_pdf(): void
    {
        $stream = "BT /F1 12 Tf 72 720 Td (PDF requirement extraction works.) Tj ET";

        $objects = [
            '<< /Type /Catalog /Pages 2 0 R >>',
            '<< /Type /Pages /Kids [3 0 R] /Count 1 >>',
            '<< /Type /Page /Parent 2 0 R /MediaBox [0 0 612 792] /Resources << /Font << /F1 5 0 R >> >> /Contents 4 0 R >>',
            "<< /Length " . strlen($stream) . " >>\nstream\n" . $stream . "\nendstream",
            '<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica >>',
        ];

        $pdf = "%PDF-1.4\n";
        $offsets = [0];

        foreach ($objects as $index => $object) {
            $objectNumber = $index + 1;
            $offsets[] = strlen($pdf);
            $pdf .= $objectNumber . " 0 obj\n" . $object . "\nendobj\n";
        }

        $xrefOffset = strlen($pdf);
        $pdf .= "xref\n0 6\n";
        $pdf .= "0000000000 65535 f \n";

        foreach (array_slice($offsets, 1) as $offset) {
            $pdf .= sprintf("%010d 00000 n \n", $offset);
        }

        $pdf .= "trailer\n<< /Size 6 /Root 1 0 R >>\n";
        $pdf .= "startxref\n" . $xrefOffset . "\n%%EOF";

        $path = tempnam(sys_get_temp_dir(), 'codly-pdf-');
        self::assertNotFalse($path);

        try {
            file_put_contents($path, $pdf);

            $text = (new DocumentExtractor())->extract($path, 'pdf');

            self::assertStringContainsString(
                'PDF requirement extraction works.',
                $text
            );
        } finally {
            @unlink($path);
        }
    }
}
