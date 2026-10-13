<?php

namespace Tests\Unit;

use App\AnalysisPromptRegistry;
use PHPUnit\Framework\TestCase;

class AnalysisPromptRegistryTest extends TestCase
{
    public function test_all_pipeline_modules_have_versioned_instructions(): void
    {
        $registry = new AnalysisPromptRegistry;

        $this->assertSame('ai-v1', AnalysisPromptRegistry::VERSION);
        $this->assertSame([
            'business_context', 'extraction', 'classification', 'missing_information',
            'ambiguity_conflicts', 'modules', 'tasks', 'screens', 'phases', 'security',
            'architecture', 'proposal',
        ], $registry->modules());

        foreach ($registry->modules() as $module) {
            $this->assertNotSame('', trim($registry->instructionsFor($module)));
        }
    }
}
