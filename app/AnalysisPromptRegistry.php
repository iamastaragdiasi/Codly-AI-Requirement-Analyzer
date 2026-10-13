<?php

namespace App;

use InvalidArgumentException;

final class AnalysisPromptRegistry
{
    public const VERSION = 'ai-v1';

    /** @var list<string> */
    private const MODULES = [
        'business_context', 'extraction', 'classification', 'missing_information',
        'ambiguity_conflicts', 'modules', 'tasks', 'screens', 'phases', 'security',
        'architecture', 'proposal',
    ];

    public function instructionsFor(string $module): string
    {
        if (! in_array($module, $this->modules(), true)) {
            throw new InvalidArgumentException('Unsupported analysis module.');
        }

        $path = dirname(__DIR__).DIRECTORY_SEPARATOR.'resources'.DIRECTORY_SEPARATOR.'prompts'.DIRECTORY_SEPARATOR.'requirement-analysis'.DIRECTORY_SEPARATOR.'v1'.DIRECTORY_SEPARATOR.$module.'.md';
        if (! is_file($path)) {
            throw new \RuntimeException('Prompt template is missing for module: '.$module);
        }

        return (string) file_get_contents($path);
    }

    /** @return list<string> */
    public function modules(): array
    {
        return self::MODULES;
    }
}
