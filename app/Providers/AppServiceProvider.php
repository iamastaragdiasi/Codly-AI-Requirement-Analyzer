<?php

namespace App\Providers;

use App\AnalysisProvider;
use App\DeterministicAnalysisProvider;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(AnalysisProvider::class, DeterministicAnalysisProvider::class);
    }

    public function boot(): void {}
}
