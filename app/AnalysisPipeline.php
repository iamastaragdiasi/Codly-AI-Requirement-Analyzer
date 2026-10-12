<?php

namespace App;

use App\Models\Analysis;
use App\Models\Project;
use Illuminate\Validation\ValidationException;

class AnalysisPipeline
{
    public const MODULES = ['business_context', 'extraction', 'classification', 'missing_information', 'ambiguity_conflicts', 'modules', 'tasks', 'screens', 'phases', 'security', 'architecture', 'proposal'];

    public function __construct(private AnalysisProvider $provider, private AnalysisValidator $validator) {}

    public function analyze(Project $project): Analysis
    {
        $sources = $project->sources()->orderBy('id')->get()->toArray();
        $input = ['sources' => $sources, 'business_problem' => $project->business_problem, 'objectives' => $project->objectives, 'target_users' => $project->target_users];
        $results = [];
        $failures = [];
        foreach (self::MODULES as $module) {
            for ($attempt = 1; $attempt <= 2; $attempt++) {
                try {
                    $results[$module] = $this->validator->validate($this->provider->run($module, $input, $attempt), $sources);
                    break;
                } catch (ValidationException) {
                    if ($attempt === 2) {
                        $failures[$module] = 'Invalid structured output after two attempts.';
                    }
                } catch (\Throwable) {
                    $failures[$module] = 'Module failed. No confidential exception details stored.';
                    break;
                }
            }
        }

        return $project->analyses()->create(['revision' => $project->revision, 'status' => $failures === [] ? 'complete' : 'failed', 'provider' => config('ai_analysis.driver') === 'openai_compatible' ? 'openai-compatible-ai' : 'deterministic-demo', 'results' => $results, 'failures' => $failures]);
    }
}
