# AI provider configuration

The application uses the deterministic demo provider by default. The configurable HTTP adapter is an integration framework and is not proof that a Codly-approved live AI service is connected.

## Environment variables

```dotenv
AI_ANALYSIS_DRIVER=demo
AI_ANALYSIS_ENDPOINT=
AI_ANALYSIS_API_KEY=
AI_ANALYSIS_MODEL=
AI_ANALYSIS_TIMEOUT=45
```

Keep the driver set to `demo` until Codly approves the provider/service, model, endpoint, credentials, client-data handling and applicable retention terms. Never commit secrets or put credentials in source control.

To enable the adapter after written approval, set `AI_ANALYSIS_DRIVER=openai_compatible` and populate the approved HTTPS chat-completions endpoint, key and model. The endpoint must use HTTPS. This adapter assumes an OpenAI-compatible request/response protocol; do not use it for a different API without adapting and testing the transport.

The provider's automated tests use Laravel HTTP fakes. They do not call a real service and do not establish model quality. Before production use, run approved fictional scenarios, inspect actual structured outputs, record hallucinations/ambiguities and complete the human evaluation sheet. Human review remains mandatory for client confirmation, scope, pricing, timelines and proposal commitments.