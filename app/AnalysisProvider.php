<?php

namespace App;

interface AnalysisProvider
{
    /** @param array<string, mixed> $input @return array<string, mixed> */
    public function run(string $module, array $input, int $attempt): array;
}
