# AI Evaluation Plan

**Project:** Codly AI-Powered Business Requirement & Project Analysis System

**Plan version:** 1.0

**Status:** Planned — evaluation results pending

**Last updated:** 12 October 2026

## 1. Purpose

This plan defines a repeatable method for evaluating the quality, reliability,
evidence traceability, and practical usefulness of the system's requirements
analysis outputs. It separates automated software tests from human evaluation
of analysis quality.

No accuracy, quality score, pass rate, or business-impact claim should be
reported until the relevant evaluation has actually been performed and recorded.

## 2. Evaluation objectives

- Verify that structured outputs comply with the defined analysis contract.
- Assess whether requirements are supported by supplied source evidence.
- Identify missing information, ambiguity, and contradictory statements.
- Assess requirement classification, prioritisation, and scope handling.
- Detect unsupported assumptions, fabricated evidence, and inappropriate
  commercial commitments.
- Verify that malformed AI responses are handled safely.
- Assess usability and the need for human review.
- Document limitations and improvement opportunities.

## 3. Evaluation modes

### 3.1 Automated testing

Use the project's existing Laravel and PHPUnit tests to verify application
behaviour, validation rules, provenance restrictions, source references,
document extraction, provider error handling, and bounded retries.

Automated test results demonstrate only the behaviour covered by those tests.
They do not establish that an AI-generated requirement is factually correct.

### 3.2 Human evaluation

Use `docs/human-evaluation-sheet.md` to record the scenario, expected outcome,
actual output, ratings, observed defects, and reviewer comments.

Reviewers must compare the output against an independently prepared expected
result. The system's own output must not be treated as ground truth.

### 3.3 Provider integration

Live-provider evaluation is pending until Codly approves the provider,
endpoint, credentials, and data-handling arrangements. Do not use personal API
keys, unapproved external services, or confidential client information.

## 4. Test dataset and scenario design

Create a controlled dataset using fictional or explicitly approved,
non-sensitive requirements. Include representative cases from the following
categories:

| ID | Scenario | Evaluation focus |
| --- | --- | --- |
| EVAL-01 | Clear and complete requirements | Faithful extraction and relevance |
| EVAL-02 | Short or underspecified brief | Missing information |
| EVAL-03 | Conflicting source statements | Conflict detection and evidence preservation |
| EVAL-04 | Ambiguous wording | Explicit uncertainty and clarification questions |
| EVAL-05 | Functional requirements | Correct classification and scope |
| EVAL-06 | Non-functional requirements | Quality attributes and measurable criteria |
| EVAL-07 | Multiple user roles | Role and permission distinctions |
| EVAL-08 | Payment or commercial requirements | No invented prices or commitments |
| EVAL-09 | Sensitive information in source text | Appropriate data minimisation and handling |
| EVAL-10 | Unrealistic or unsupported estimates | Uncertainty and human review |
| EVAL-11 | Scope change after review | Revision consistency and stale approval handling |
| EVAL-12 | Malformed provider output | Validation and bounded retry |
| EVAL-13 | Edited requirement after approval | Revision-specific approval integrity |
| EVAL-14 | Unsupported or unavailable information | No fabricated facts or source references |

For each scenario, record a unique identifier, input, independently prepared
expected findings, expected evidence references, expected classification where
applicable, and the evaluation date.

Keep the dataset versioned. Do not report results from an incomplete or
unrecorded dataset as a completed evaluation.

## 5. Quality dimensions

Rate each applicable dimension using the existing evaluation sheet's 1–5
scale or N/A.

- **Accuracy:** Findings agree with the supplied evidence and expected result.
- **Completeness:** Material requirements and relevant gaps are identified.
- **Relevance:** Findings relate to the requested analysis and project context.
- **Hallucination:** Unsupported facts, invented quotations, and fabricated
  commitments are absent.
- **Consistency:** Related findings do not contradict one another without
  identifying the underlying conflict.
- **Structure:** Output follows the required schema and is understandable.
- **Practicality:** Findings and clarification questions support useful next steps.
- **Provenance:** Source references and confirmation status are accurate.
- **Usability:** A reviewer can understand, challenge, and revise the output.

Use the same rating definitions across reviewers. Record N/A where a dimension
cannot reasonably be assessed.

## 6. Quantitative measures

Calculate a measure only when the necessary observations have been collected.

- **Scenario completion rate:** Scenarios completed divided by scenarios planned.
- **Requirement precision:** Correct identified requirements divided by all
  requirements identified, using independently labelled expected results.
- **Requirement recall:** Correctly identified expected requirements divided by
  all expected requirements in the evaluation set.
- **Unsupported-claim rate:** Unsupported factual claims divided by all factual
  claims reviewed.
- **Evidence traceability rate:** Findings with valid, correctly matched evidence
  references divided by findings requiring source evidence.
- **Schema compliance rate:** Outputs conforming to the required contract divided
  by outputs evaluated.
- **Reviewer agreement:** Agreement between independent reviewers on comparable
  labels or ratings, with the method documented.

Define matching rules, denominators, exclusions, and treatment of N/A before
calculating these measures. Report the sample size and relevant limitations
alongside every result. Do not interpret an empty or missing result as zero.

## 7. Human review procedure

1. Select a documented scenario and its expected result.
2. Run the scenario using the identified application and prompt version.
3. Preserve the input, output, run date, and relevant non-sensitive metadata.
4. Compare findings against the independent expected result.
5. Check source IDs, exact source statements, provenance, priority, scope,
   category where applicable, dependencies, and notes.
6. Record unsupported assumptions, omissions, conflicts, and unnecessary
   suggestions.
7. Complete the evaluation sheet and explain each material rating.
8. Have a second reviewer independently assess a subset when feasible.
9. Resolve disagreements explicitly and retain the original observations.
10. Record defects and retest them after a documented change.

Human review is mandatory for consequential decisions. An AI suggestion or
human review must not be represented as client confirmation.

## 8. Security and privacy checks

- Use fictional or approved non-sensitive data.
- Treat supplied source text as untrusted input.
- Check that source references point only to supplied sources.
- Verify that client-confirmed provenance requires explicit confirmation
  evidence.
- Check that provider errors do not disclose confidential response bodies.
- Verify HTTPS and approved provider configuration before live integration.
- Do not put API keys, credentials, or confidential source text in evaluation
  reports, source control, or test fixtures.
- Record security findings and unresolved risks separately from quality ratings.

## 9. Prompt and model version tracking

For every evaluation run, record when available:

- Application revision or Git commit.
- Prompt registry version.
- Analysis module.
- Provider and model identifier, where approved and available.
- Dataset and scenario-set version.
- Evaluation date and reviewer.
- Relevant configuration changes.
- Output and defect references.

When prompts, provider settings, validation rules, or models change, rerun the
affected scenarios and compare results against the previous recorded baseline.
Do not claim improvement unless comparable measurements support it.

## 10. Defect severity and reporting

Classify observed defects consistently:

- **Critical:** Material security or privacy exposure, or a failure that
  invalidates a consequential decision.
- **High:** Fabricated evidence, false client confirmation, or a major
  requirement omission that could materially mislead a reviewer.
- **Medium:** Significant classification, completeness, consistency, or
  usability defect.
- **Low:** Minor formatting, wording, or non-material presentation issue.

Document the observed behaviour, expected behaviour, reproduction scenario,
severity, corrective action, owner if assigned, and retest result.

Severity assignments must be justified by the actual observed impact.

## 11. Acceptance and exit criteria

Evaluation is complete only when:

- The planned scenarios and actual completion count are recorded.
- Required automated tests have documented results.
- Human evaluation records contain actual observations and ratings.
- Material defects and unresolved risks are listed.
- Any quantitative measures include definitions, sample sizes, and results.
- Provider integration claims are limited to what has actually been verified.
- The report distinguishes implemented functionality from planned or blocked work.

No numerical quality threshold is asserted by this plan. Acceptance thresholds
must be agreed with the project supervisor or authorised stakeholders before
using them to claim success.

## 12. Current status and limitations

At the time this plan was prepared, the project has automated contract and
provider tests. A human evaluation sheet exists as a template. A completed,
independently reviewed evaluation dataset and measured AI-quality results have
not been established by this document.

Live approved-provider integration remains unverified. The deterministic demo
provider and automated tests must not be presented as proof of live AI quality
or real-world business impact.

Update this section only when new evidence is collected and verified.

## 13. Related project documents

- `docs/acceptance-matrix.md` — acceptance criteria and implementation status.
- `docs/human-evaluation-sheet.md` — per-scenario evaluation record.
- `docs/ai-provider-setup.md` — provider configuration guidance.
- `docs/final-internship-report.md` — final project report.
