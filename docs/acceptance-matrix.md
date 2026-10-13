# Acceptance Matrix
**Project:** AI-Powered Business Requirement & Project Analysis System
**Organization:** Codly India Private Limited
**Evidence snapshot:** 13 October 2026

## Latest finishing qualification

Supersedes earlier runtime, absent-handoff and publication blockers below while preserving their historical context. Code SHA `9dbf973822b05388fe6066ac9a3fafe22ec81cd0` was normally pushed and independently verified. Fresh local suite: 75 pass / 507 assertions, one PHPWord deprecation; Pint/build passed. GitHub CI test failure is tracked in [execution status](FINAL_EXECUTION_STATUS.md). Automated evidence is not browser or human acceptance.

| Acceptance scope | Current result | Evidence / remaining action |
|---|---|---|
| AC-13, AC-15, AC-23: draft controls, readable PDF/DOCX tables, refusal cases | Verified in HTTP/unit fixtures | Fresh existing DocumentWorkflowTest and DocumentExtractorTest included in suite; negative fixtures are synthetic, not representative encrypted/scanned browser acceptance. |
| AC-24: categories, priority and review correction | Verified in automated scope | AnalysisScenariosTest and revision/security fixtures; human semantic quality pending. |
| AC-20, AC-27: commit identity/publication | Verified for code publication | Normal merge/push, all required ancestors, matching human identity; final documentation SHA recorded in execution status. |
| AC-26: official scope and handoff | Verified by inspection | Full official specification and master plan read locally; remote handoff preserved. Documents not republished. |
| AC-25: detailed semantic design | Partial demo, not complete semantic capability | Source-specific scope/planning, candidate entities/integration questions and journey notes exist; comprehensive business/outcome/relationship design and practical correctness unverified. |
| AC-14, AC-17, AC-18, AC-28 | Blocked by Codly | Approved live AI access, actual human ratings, company facts and supervisor/final business decisions remain pending. |
| All required browser journeys | NOT VERIFIED | No connected browser: login, project creation, text, findings/questions/conflicts/provenance, PDF, DOCX tables, authorization, revision invalidation and proposal gate not executed. Same for malformed/unsupported content and unassigned reviewer browser cases. |
| Actual internship portal submission | NOT VERIFIED | No portal URL/session available; manifest is preparation, not submission. |

### Official specification and master-plan mapping

Portability follow-up: CI confirmed valid DOCX as `application/octet-stream`. The fallback is limited to `.docx` and still requires bounded archive validation and actual readable-text parsing. Valid fallback DOCX, binary non-DOCX/non-PDF refusal and malformed file-array regressions were added; final local suite **79 pass / 560 assertions**, one PHPWord deprecation; Pint passed. Final Linux CI disposition is in the execution status.

| Official sections | Implemented evidence / disposition |
|---|---|
| 1–6, 41–44: intake and workflow | Laravel project/source flow; text/structured/readable PDF/DOCX fixtures. Browser acceptance pending; OCR optional per §42; voice/images/URL intake future scope. |
| 7–12, 31–34: intelligence and provenance | Five categories, four priorities, missing questions, conflicts and validated contracts tested; DEMO heuristics are not general LLM quality. |
| 13–23: planning, dependencies, scope | Candidate journeys/screens/entities/security, source-linked modules/tasks/phases/scope. Technical usefulness and comprehensive modeling require human review. |
| 24–26, 45: proposals and approvals | Nonbinding drafts, human commercial fields, exact-revision review and invalidation exercised in fictional fixtures; no real final proposal approval. |
| 27–29, 46–50: access/privacy/stack | DEMO retained, no personal API/account or training; policy/validation/security regressions. Public publication authorized by user report; production audit remains separate. |
| 30, 35–40: prompts and evaluation | Modular ai-v1 prompts, fictional dataset 1.1 / EVAL-01–16, automated results; human quality ratings blank. |
| 51–53: milestones and deliverables | Source/config/migrations, README architecture/setup/user flow, prompt/evaluation docs, 12-chapter draft and submission manifest; no historical milestone completion dates invented. |
| 54–63: future scope, evaluation and success | Future extensions documented; no training required. Live AI application, measured quality/value and Codly acceptance not established by DEMO tests. |

Master-plan phases 0–8 align with the same implementation, provenance, human-control and disclosure boundaries. Its recorded PHP 8.4.25 baseline and this pass's PHP 8.5.0 describe different environments; neither changes the other's historical record.

## Status definitions

- **Verified:** Supported only within the stated evidence scope (inspection, historical test or recorded observation); it does not mean current complete acceptance.
- **Not Implemented:** The capability is absent from the current implementation.
- **Blocked:** Implementation or verification depends on an outstanding prerequisite.
- **Not Applicable:** The requirement does not apply to this version; justify the decision.

A passing test proves only the behavior exercised by that test. This matrix is a working evidence record, not a claim of complete acceptance.

| ID | Requirement | Status | Current evidence | Gap / acceptance action |
|---|---|---|---|---|
| AC-01 | Authenticated project workspace | Verified | Session controller and authenticated routes; `WorkspaceSecurityTest::test_login_checks_credentials_and_logout_ends_session` | Complete a manual role-based UI walkthrough. |
| AC-02 | Owner/reviewer access boundaries | Verified | `ProjectPolicy`; tests for unassigned reviewers, reviewer actions and project-context edits | Confirm assignment UI and authorization behavior in browser. |
| AC-03 | Text and structured requirement intake | Verified | `SourceController`, `StoreSourceRequest`; intake validation tests | Exercise both input paths manually. |
| AC-04 | Validate empty, oversized and unsupported source submissions | Verified | `RevisionWorkflowTest::test_empty_oversized_and_file_submissions_are_rejected`; `StoreSourceRequest` | Confirm supported PDF/DOCX upload limits and error handling in a browser walkthrough. |
| AC-05 | Preserve original source evidence | Verified | Analysis scenario and provenance tests | Conduct a manual traceability review with fictional inputs. |
| AC-06 | Structured analysis contract validation | Verified | `AnalysisValidator`; `AnalysisContractTest` and `AnalysisValidationTest` | Add further edge cases if required by acceptance review. |
| AC-07 | Deterministic demo analysis | Verified | `DeterministicAnalysisProvider`; `AnalysisScenariosTest` | Clearly disclose that this is heuristic demo behavior, not a live LLM. |
| AC-08 | Missing-information and ambiguity handling | Verified | Scenario tests for conflicts and reviewable structure | Measure completeness and false positives using a human-rated dataset. |
| AC-09 | Malformed provider output and bounded retry | Verified | Revision workflow tests for malformed output, correction and runtime failure | Record representative failure analysis in the final test report. |
| AC-10 | Revision history and stale-form protection | Verified | `WorkspaceRevision`, context-edit and revision workflow tests | Verify end-to-end behavior in the browser. |
| AC-11 | Human review and revision-specific approval | Verified | `ApprovalController`; revision workflow tests | Verify rejection and changes-requested journeys manually. |
| AC-12 | Review changes and record before/after evidence | Verified | `ArtifactController`; workflow tests | Confirm client-confirmation wording does not imply independent verification. |
| AC-13 | Proposal draft and human-entered commercial fields | Blocked | Existing gate tests are historical; payment/support fields and source-linked scope groups added on 2026-10-13 need focused regression execution | Review generated draft against missing-price and provisional-estimate cases. |
| AC-14 | Live approved AI-service integration | Blocked | Current pipeline uses `deterministic-demo`; no live integration verified | Obtain Codly approval and authorized credentials, then implement and test the integration. |
| AC-15 | PDF/DOCX text extraction and upload workflow | Blocked | Historical `DocumentExtractorTest` and DOCX intake tests; new `DocumentWorkflowTest` covers both formats but execution is blocked by PHP runtime access | Complete manual upload-to-analysis walkthrough for both formats; verify malformed, encrypted, oversized, image-only, and text-limit cases. OCR remains unsupported. |
| AC-16 | OCR, audio, screenshot and URL analysis | Not Implemented | Current intake limitations explicitly exclude these capabilities | Treat as future scope unless the approved specification requires them now. |
| AC-17 | Human evaluation dataset and completed rating sheet | Blocked | `docs/evaluation-cases.md` defines fictional scenarios and expected findings; `docs/human-evaluation-sheet.md` is a blank template; no human ratings exist | A human evaluator must run the cases, compare output with expected findings, record ratings and defects, and sign off. No quality score is claimed until this is done. |
| AC-18 | Complete official 12-chapter report | Blocked | docs/final-internship-report.md contains the 12-chapter report draft; final review and factual confirmation remain outstanding | Verify all chapters, references and implementation claims before submission. |
| AC-19 | Technical and user documentation | Verified | README contains setup, operation, limitations and workflow guidance | Perform a clean setup walkthrough and confirm instructions against the final code. |
| AC-20 | Git repository and publication readiness | Blocked | Repository is reportedly public; visibility and Codly publication permission were not verified in this run | Confirm Codly's publication authorization and actual visibility, audit repository history and tracked files for secrets, and review any local untracked files before final submission. |
| AC-21 | Reviewer-assignment hardening | Verified | Existing policy and `WorkspaceSecurityTest` cover reviewer boundaries; historical suite result only | Confirm owner and reviewer assignment behavior in a focused feature test and browser walkthrough. |
| AC-22 | Production readiness | Not Implemented | Current evidence establishes a tested development/demo workflow, not production readiness | Complete security, deployment, privacy, backup, monitoring and operational acceptance. |

## Acceptance decision

The current evidence supports a development/demo workflow with source traceability, structured validation, revision handling, human review controls, and unit-tested PDF/DOCX text extraction. It does not establish full requirement coverage, live AI integration, complete end-to-end upload acceptance, production readiness or business impact.

Final acceptance requires the remaining gaps to be resolved or explicitly approved as out of scope, with evidence retained for every decision.
## Acceptance Audit — 2026-10-13

Evidence basis: historical observations preserved from the user’s local edits and previously reported automated results. They were not independently reproduced in this run. This section does not imply that untested paths
have been verified.

| Acceptance item | Status | Evidence / qualification |
|---|---|---|
| Application startup | Verified | Local application previously opened at http://127.0.0.1:8000. |
| Project creation | Verified | Fictional QuickBite Restaurant Ordering Platform created; project ID 2. |
| Requirement intake | Verified | Initial requirement evidence and a payment-related clarification record submitted. |
| Structured analysis | Verified | Deterministic-demo analysis generated; current recorded revision is 7. |
| Analysis content | Verified | Tasks, phases, modules, screens, proposal-related information, security, architecture, classification, ambiguity/conflict, and missing-information findings were present. Semantic accuracy has not been independently evaluated. |
| Missing-information detection | Verified | Missing-information findings appeared in the generated analysis. Representative accuracy remains unevaluated. |
| Reviewer assignment | Verified | Local Reviewer assignment recorded. |
| Reviewer decision history | Verified | `changes_requested` decision recorded for revision 7 and visible in revision history. |
| Stale-analysis protection | Verified | New evidence caused the earlier analysis to become stale; analysis was subsequently regenerated to revision 7. |
| Analysis approval endpoint | Blocked | HTTP 422 reported `Complete analysis of current revision required.` before revision 7 was generated. This earlier response does not establish the current endpoint outcome. |
| Proposal drafting gate | Verified | HTTP 422 reported `Approve current scope before drafting proposal.` The current review decision is `changes_requested`. Do not approve unresolved scope merely to pass acceptance. |
| Proposal generation after legitimate approval | Blocked | No approved current scope or resulting proposal draft has been evidenced. |
| Pricing and effort | Blocked | No finalized proposal price or effort estimate has been recorded. |
| PDF/DOCX intake | Blocked | Homepage wording now aligns with the workspace description and extraction implementation. End-to-end PDF/DOCX acceptance has not been established. |
| Human quality evaluation | Blocked | Evaluation cases exist, but no independently recorded human scores or aggregate quality results are evidenced. |
| Live AI provider | Blocked | Current provider is `deterministic-demo`. No live-model integration or real-model evaluation is claimed. |
| Production security and deployment | Blocked | Automated tests and local browser checks do not establish production readiness. |

### Interpretation and follow-up

- **Expected safeguard, not a defect:** Proposal drafting is blocked while the current scope lacks approval.
- **Historical prerequisite failure:** The earlier HTTP 422 for incomplete current analysis occurred before revision 7 was generated; do not treat it as proof of a current defect.
- **Not yet accepted:** End-to-end PDF/DOCX processing, human evaluation, live AI integration, and production security.
- **Documentation correction completed:** Homepage wording now describes readable PDF/DOCX support and the documented extraction limitations. End-to-end acceptance remains pending.
- **Evidence integrity:** Do not infer semantic accuracy from the presence of structured fields, or infer human evaluation results from automated test success.
- **Workflow integrity:** Preserve the `changes_requested` decision and do not bypass approval requirements.

## Current execution qualification — 2026-10-13

Historical baseline supplied by the operator: **58 tests / 325 assertions** and a passing frontend build. No fresh suite pass is claimed. This run built frontend assets successfully and syntax-checked eight changed PHP files. Focused Laravel tests and Pint could not start on the available PHP 8.2 runtime; installed dependencies require PHP >=8.4.1 and the running PHP 8.5 executable is inaccessible. No browser provider is connected. See [execution status](FINAL_EXECUTION_STATUS.md) for actual commands and blockers.

| ID | Requirement | Status | Evidence | Acceptance action |
|---|---|---|---|---|
| AC-23 | Content-based upload validation, bounded DOCX expansion and table extraction | Blocked | Code added; PHP syntax check passed; new document regression cases prepared | Execute tests with accessible PHP 8.5; run browser cases for both formats. |
| AC-24 | Five explicit categories, review correction and four displayed priority labels | Blocked | Candidate heuristics and category review added; five new category cases | Execute regressions; human-check classification accuracy. |
| AC-25 | Detailed business type, outcomes, journeys, database entities and integration design | Not Implemented | Demo supplies broad context, role-screen suggestions and generic architecture/questions; no dedicated detailed models for these outputs | Agree coverage with official specification and supervisor; do not claim complete semantic MVP coverage. |
| AC-26 | Official specification and authoritative local handoff | Blocked | No local PROJECT_HANDOFF.md or official specification found in scoped repository search | Supply approved documents and reconcile scope. No chat attachment was assumed. |
| AC-27 | Local human-attributed commit | Blocked | Required four GIT_AUTHOR/COMMITTER environment variables are absent; Git index write denied | Operator must supply confirmed variables and authorized Git write access; no identity was overridden. |
| AC-28 | Final proposal, pricing, timeline and supervisor acceptance | Blocked | Draft fields exist; no authorized human approval or signature recorded | Authorized people must review and decide; fixture approvals are software tests only. |

No Not Applicable exclusion is asserted without an approved scope decision. OCR and other unsupported media remain Not Implemented, not silently waived. PDF page numbers, DOCX paragraph locations, binary retention, OCR and layout fidelity are not established. Sources retain normalized extracted text and document filename/format, not the original binary.
