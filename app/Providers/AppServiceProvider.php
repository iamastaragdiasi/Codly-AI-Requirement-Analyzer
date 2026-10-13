<?php

namespace App\Providers;

use App\AnalysisProvider;
use App\ConfigurableAiAnalysisProvider;
use App\DeterministicAnalysisProvider;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(AnalysisProvider::class, function ($app): AnalysisProvider {
            if (config('ai_analysis.driver') === 'openai_compatible') {
                return $app->make(ConfigurableAiAnalysisProvider::class);
            }

            return $app->make(DeterministicAnalysisProvider::class);
        });
    }

    public function boot(): void {}
}
