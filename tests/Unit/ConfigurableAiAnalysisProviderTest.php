<?php

namespace Tests\Unit;

use App\AnalysisPromptRegistry;
use App\ConfigurableAiAnalysisProvider;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;
use RuntimeException;
use Tests\TestCase;

class ConfigurableAiAnalysisProviderTest extends TestCase
{
    private string $endpoint = 'https://approved.example.test/v1/chat/completions';

    protected function setUp(): void
    {
        parent::setUp();

        config([
            'ai_analysis.endpoint' => $this->endpoint,
            'ai_analysis.api_key' => 'test-token',
            'ai_analysis.model' => 'test-model',
            'ai_analysis.timeout' => 10,
        ]);
    }

    public function test_it_parses_a_successful_structured_response(): void
    {
        $item = [
            'title' => 'Example requirement',
            'provenance' => 'AI Inferred',
            'source_ids' => [],
            'statements' => [],
            'priority' => 'Should',
            'scope' => 'optional',
            'role' => '',
            'objective' => '',
            'feature' => 'Example',
            'dependencies' => [],
            'notes' => 'Requires human review.',
        ];

        $content = json_encode([
            'prompt_version' => 'ai-v1',
            'items' => [$item],
        ], JSON_THROW_ON_ERROR);

        Http::fake([
            $this->endpoint => Http::response([
                'choices' => [
                    ['message' => ['content' => $content]],
                ],
            ], 200),
        ]);

        $provider = new ConfigurableAiAnalysisProvider(
            new AnalysisPromptRegistry
        );

        $result = $provider->run('extraction', ['sources' => []], 1);

        $this->assertSame('ai-v1', $result['prompt_version']);
        $this->assertSame('Example requirement', $result['items'][0]['title']);

        Http::assertSent(function (Request $request): bool {
            return $request->url() === $this->endpoint
                && $request->hasHeader('Authorization', 'Bearer test-token')
                && $request['model'] === 'test-model';
        });
    }

    public function test_it_fails_when_required_configuration_is_missing(): void
    {
        config(['ai_analysis.api_key' => '']);

        $provider = new ConfigurableAiAnalysisProvider(
            new AnalysisPromptRegistry
        );

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Approved AI provider is not configured.');

        $provider->run('extraction', ['sources' => []], 1);
    }

    public function test_http_failure_does_not_expose_provider_response_body(): void
    {
        Http::fake([
            $this->endpoint => Http::response([
                'error' => ['message' => 'SENSITIVE RESPONSE BODY'],
            ], 500),
        ]);

        $provider = new ConfigurableAiAnalysisProvider(
            new AnalysisPromptRegistry
        );

        try {
            $provider->run('extraction', ['sources' => []], 1);
            $this->fail('Expected provider failure was not raised.');
        } catch (RuntimeException $exception) {
            $this->assertSame(
                'Approved AI provider returned HTTP status 500.',
                $exception->getMessage()
            );
            $this->assertStringNotContainsString(
                'SENSITIVE RESPONSE BODY',
                $exception->getMessage()
            );
        }
    }

    public function test_it_rejects_non_https_endpoint_before_sending_data(): void
    {
        config(['ai_analysis.endpoint' => 'http://insecure.example.test/chat/completions']);

        $provider = new ConfigurableAiAnalysisProvider(
            new AnalysisPromptRegistry
        );

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage(
            'Approved AI provider endpoint must be a valid HTTPS URL.'
        );

        $provider->run('extraction', ['sources' => []], 1);
    }

    public function test_malformed_json_raises_validation_exception_for_bounded_retry(): void
    {
        Http::fake([
            $this->endpoint => Http::response([
                'choices' => [
                    ['message' => ['content' => 'not valid JSON']],
                ],
            ], 200),
        ]);

        $provider = new ConfigurableAiAnalysisProvider(
            new AnalysisPromptRegistry
        );

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The AI provider returned malformed JSON.');

        $provider->run('extraction', ['sources' => []], 1);
    }
}
