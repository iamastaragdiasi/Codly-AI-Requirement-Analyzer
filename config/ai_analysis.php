<?php

return [
    /*
     * Keep "demo" as the safe default. Set "openai_compatible" only after
     * Codly approves the provider, endpoint, credentials and data handling.
     */
    'driver' => env('AI_ANALYSIS_DRIVER', 'demo'),
    'endpoint' => env('AI_ANALYSIS_ENDPOINT', ''),
    'api_key' => env('AI_ANALYSIS_API_KEY', ''),
    'model' => env('AI_ANALYSIS_MODEL', ''),
    'timeout' => (int) env('AI_ANALYSIS_TIMEOUT', 45),
];
