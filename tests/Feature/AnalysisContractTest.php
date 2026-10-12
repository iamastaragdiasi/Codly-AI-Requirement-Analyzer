<?php

namespace Tests\Feature;

use App\AnalysisValidator;
use App\DeterministicAnalysisProvider;
use Illuminate\Validation\ValidationException;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class AnalysisContractTest extends TestCase
{
    /** @return array<string,array{string}> */
    public static function invalidOutputs(): array
    {
        return ['unknown provenance' => ['provenance'], 'unknown priority' => ['priority'], 'unknown scope' => ['scope'], 'invented source' => ['source_ids'], 'invented quote' => ['statements'], 'false client confirmation' => ['confirmation'], 'unknown output key' => ['extra'], 'unknown prompt' => ['prompt_version'], 'missing field' => ['notes']];
    }

    #[DataProvider('invalidOutputs')]
    public function test_rejects_malformed_or_unsubstantiated_findings(string $field): void
    {
        $sources = [['id' => 1, 'original' => 'Users order products', 'metadata' => ['priority' => 'Must', 'role' => 'Customer', 'feature' => 'Orders', 'client_confirmed' => false]]];
        $output = (new DeterministicAnalysisProvider)->run('extraction', ['sources' => $sources, 'business_problem' => 'Manual orders', 'objectives' => 'Reduce delays', 'target_users' => 'Customer'], 1);
        if ($field === 'extra') {
            $output['unexpected'] = 'invalid';
        } elseif ($field === 'prompt_version') {
            $output['prompt_version'] = 'unknown';
        } elseif ($field === 'confirmation') {
            $output['items'][0]['provenance'] = 'Client Confirmed';
        } elseif ($field === 'notes') {
            unset($output['items'][0]['notes']);
        } else {
            $output['items'][0][$field] = match ($field) {
                'source_ids' => [999], 'statements' => ['Invented statement'], default => 'Invalid'
            };
        }
        $this->expectException(ValidationException::class);
        (new AnalysisValidator)->validate($output, $sources);
    }
}
