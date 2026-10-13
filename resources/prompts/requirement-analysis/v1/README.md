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

## Engineering change record — 2026-10-13

The live modular prompt text and registry version `ai-v1` were not changed. The `demo-v1` identifier remains the deterministic output contract version; it does not identify a live model or imply unchanged heuristic behavior. The working-tree change adds explicit five-way candidate categories to address absent category values, permits reviewer category corrections, and adds source-linked draft scope/payment/support fields. Affected fictional cases include EVAL-01, 05, 06, 07, 11, 13 and 15; five category regressions and document workflow fixtures were prepared. No semantic improvement or rating is claimed.

Actual result: PHP syntax checks and frontend build passed; behavioral tests and Pint are blocked by compatible PHP access. Human reviewer: pending. Before changing prompt text or enabling a live provider, record the authorized provider/model, new prompt version, rationale, comparable dataset results and human decision.
