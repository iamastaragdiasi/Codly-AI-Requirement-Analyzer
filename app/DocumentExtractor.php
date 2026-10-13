<?php

namespace App;

use PhpOffice\PhpWord\IOFactory;
use RuntimeException;
use Smalot\PdfParser\Parser;
use Throwable;
use ZipArchive;

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
        $archive = new ZipArchive;
        if ($archive->open($path) !== true) {
            throw new RuntimeException('Invalid DOCX archive.');
        }

        try {
            if ($archive->locateName('[Content_Types].xml') === false || $archive->locateName('word/document.xml') === false) {
                throw new RuntimeException('The archive is not a DOCX document.');
            }

            $expandedBytes = 0;
            for ($index = 0; $index < $archive->numFiles; $index++) {
                $entry = $archive->statIndex($index);
                if ($entry === false) {
                    throw new RuntimeException('The DOCX archive could not be inspected.');
                }
                $expandedBytes += $entry['size'];
                if ($expandedBytes > 20 * 1024 * 1024) {
                    throw new RuntimeException('DOCX expanded content exceeds the safe extraction limit.');
                }
            }
        } finally {
            $archive->close();
        }

        $document = IOFactory::load($path, 'Word2007');
        $parts = [];

        foreach ($document->getSections() as $section) {
            foreach ($section->getElements() as $element) {
                $this->collectText($element, $parts);
            }
        }

        return implode("\n", $parts);
    }

    /** @param list<string> $parts */
    private function collectText(object $element, array &$parts): void
    {
        if (method_exists($element, 'getText')) {
            $value = $element->getText();

            if (is_string($value) && trim($value) !== '') {
                $parts[] = $value;
            }
        }

        if (method_exists($element, 'getRows')) {
            foreach ($element->getRows() as $row) {
                foreach ($row->getCells() as $cell) {
                    $this->collectText($cell, $parts);
                }
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
