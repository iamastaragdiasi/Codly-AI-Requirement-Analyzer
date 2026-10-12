<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;

class DiagnoseDatabase extends Command
{
    protected $signature = 'app:diagnose-database';

    protected $description = 'Check workspace tables without reading confidential rows or credentials';

    public function handle(): int
    {
        $missing = [];
        foreach (['projects', 'sources', 'analyses', 'artifacts', 'approvals', 'audit_events'] as $table) {
            if (! Schema::hasTable($table)) {
                $missing[] = $table;
            }
        }
        if ($missing !== []) {
            $this->error('Missing workspace tables: '.implode(', ', $missing));

            return self::FAILURE;
        }
        $this->info('Workspace schema present.');

        return self::SUCCESS;
    }
}
