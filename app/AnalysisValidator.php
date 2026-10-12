<?php

namespace App;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AnalysisValidator
{
    /** @param array<string,mixed> $output @param list<array<string,mixed>> $sources @return array<string,mixed> */
    public function validate(array $output, array $sources): array
    {
        if (array_diff(array_keys($output), ['prompt_version', 'items']) !== []) {
            throw ValidationException::withMessages(['output' => 'Unknown structured output keys.']);
        }
        $validated = Validator::make($output, [
            'prompt_version' => 'required|in:demo-v1',
            'items' => 'present|array|max:300',
            'items.*' => 'array:title,provenance,source_ids,statements,priority,scope,role,objective,feature,dependencies,notes',
            'items.*.title' => 'required|string|max:1000',
            'items.*.provenance' => 'required|in:Client Confirmed,AI Inferred,AI Suggested,Missing',
            'items.*.source_ids' => 'present|array',
            'items.*.source_ids.*' => 'integer',
            'items.*.statements' => 'present|array',
            'items.*.statements.*' => 'string|max:50000',
            'items.*.priority' => 'required|in:Must,Should,Could,Future',
            'items.*.scope' => 'required|in:included,excluded,assumption,optional,unresolved',
            'items.*.role' => 'required|string|max:5000',
            'items.*.objective' => 'required|string|max:10000',
            'items.*.feature' => 'required|string|max:500',
            'items.*.dependencies' => 'present|array',
            'items.*.dependencies.*' => 'string|max:500',
            'items.*.notes' => 'required|string|max:2000',
        ])->validate();
        $sourceIds = array_column($sources, 'id');
        $sourceMap = array_column($sources, null, 'id');
        foreach ($validated['items'] as $item) {
            if (array_diff($item['source_ids'], $sourceIds) !== [] || ($item['provenance'] === 'Client Confirmed' && $item['source_ids'] === [])) {
                throw ValidationException::withMessages(['output' => 'Invalid provenance reference.']);
            }
            $evidence = array_intersect_key($sourceMap, array_flip($item['source_ids']));
            if (array_diff($item['statements'], array_column($evidence, 'original')) !== []) {
                throw ValidationException::withMessages(['output' => 'Original statements must match referenced evidence exactly.']);
            }
            if ($item['provenance'] === 'Client Confirmed' && ! array_filter($evidence, fn (array $source): bool => ($source['metadata']['client_confirmed'] ?? false) === true)) {
                throw ValidationException::withMessages(['output' => 'Explicit client confirmation evidence required.']);
            }
        }

        return $validated;
    }
}
