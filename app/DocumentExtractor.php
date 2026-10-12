<?php

namespace App;

use PhpOffice\PhpWord\IOFactory;
use RuntimeException;
use Smalot\PdfParser\Parser;
use Throwable;

class DocumentExtractor
{
    public function extract(string $path, string $format): string
    {
        $format = strtolower($format);

        if (!in_array($format, ['pdf', 'docx'], true)) {
            throw new RuntimeException(
                'Unsupported document format. Only PDF and DOCX are supported.'
            );
        }

        if (!is_file($path) || !is_readable($path)) {
            throw new RuntimeException(
                'The uploaded document cannot be read.'
            );
        }

        try {
            $text = match ($format) {
                'pdf' => (new Parser())->parseFile($path)->getText(),
                'docx' => $this->extractDocx($path),
            };
        } catch (Throwable $exception) {
            throw new RuntimeException(
                'The document could not be parsed. Check that it is a valid, readable PDF or DOCX.',
                0,
                $exception
            );
        }

        $text = trim(preg_replace('/\s+/u', ' ', $text) ?? '');

        if ($text === '') {
            throw new RuntimeException(
                'No readable text was found. Scanned PDFs and image-only documents are not supported.'
            );
        }

        return $text;
    }

    private function extractDocx(string $path): string
    {
        $document = IOFactory::load($path);
        $parts = [];

        foreach ($document->getSections() as $section) {
            foreach ($section->getElements() as $element) {
                $this->collectText($element, $parts);
            }
        }

        return implode("\n", $parts);
    }

    private function collectText(object $element, array &$parts): void
    {
        if (method_exists($element, 'getText')) {
            $value = $element->getText();

            if (is_string($value) && trim($value) !== '') {
                $parts[] = $value;
            }
        }

        if (method_exists($element, 'getElements')) {
            foreach ($element->getElements() as $child) {
                if (is_object($child)) {
                    $this->collectText($child, $parts);
                }
            }
        }
    }
}
