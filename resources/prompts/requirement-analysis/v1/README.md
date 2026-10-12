# Requirement-analysis prompt version 1

The runtime prompt instructions are maintained in `App\AnalysisPromptRegistry` with version `ai-v1`.

Modules:
- business_context
- extraction
- classification
- missing_information
- ambiguity_conflicts
- modules
- tasks
- screens
- phases
- security
- architecture
- proposal

## Change-control record

Version: `ai-v1`
Status: initial implementation; not yet evaluated against an approved live AI service.
Safety rules: preserve source evidence; do not invent source IDs or original statements; do not convert suggestions to client-confirmed facts; do not invent pricing or committed timelines; require human review for consequential decisions.

Before changing prompts, record the reason, affected scenarios, expected improvement, actual test results, regressions and reviewer.
