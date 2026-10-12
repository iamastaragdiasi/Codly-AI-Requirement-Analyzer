# Acceptance Matrix
**Project:** AI-Powered Business Requirement & Project Analysis System
**Organization:** Codly India Private Limited
**Evidence snapshot:** 12 October 2026

## Status definitions

- **Verified:** Supported by implementation inspection and/or an identified passing test.
- **Not Implemented:** The capability is absent from the current implementation.
- **Blocked:** Implementation or verification depends on an outstanding prerequisite.
- **Not Applicable:** The requirement does not apply to this version; justify the decision.

A passing test proves only the behavior exercised by that test. This matrix is a working evidence record, not a claim of complete acceptance.

| ID | Requirement | Status | Current evidence | Gap / acceptance action |
|---|---|---|---|---|
| AC-01 | Authenticated project workspace | Verified | Session controller and authenticated routes; `WorkspaceSecurityTest::test_login_checks_credentials_and_logout_ends_session` | Complete a manual role-based UI walkthrough. |
| AC-02 | Owner/reviewer access boundaries | Verified | `ProjectPolicy`; tests for unassigned reviewers, reviewer actions and project-context edits | Confirm assignment UI and authorization behavior in browser. |
| AC-03 | Text and structured requirement intake | Verified | `SourceController`, `StoreSourceRequest`; intake validation tests | Exercise both input paths manually. |
| AC-04 | Reject empty, oversized and file submissions where unsupported | Verified | `RevisionWorkflowTest::test_empty_oversized_and_file_submissions_are_rejected` | Keep user-facing limitations explicit. |
| AC-05 | Preserve original source evidence | Verified | Analysis scenario and provenance tests | Conduct a manual traceability review with fictional inputs. |
| AC-06 | Structured analysis contract validation | Verified | `AnalysisValidator`; `AnalysisContractTest` and `AnalysisValidationTest` | Add further edge cases if required by acceptance review. |
| AC-07 | Deterministic demo analysis | Verified | `DeterministicAnalysisProvider`; `AnalysisScenariosTest` | Clearly disclose that this is heuristic demo behavior, not a live LLM. |
| AC-08 | Missing-information and ambiguity handling | Verified | Scenario tests for conflicts and reviewable structure | Measure completeness and false positives using a human-rated dataset. |
| AC-09 | Malformed provider output and bounded retry | Verified | Revision workflow tests for malformed output, correction and runtime failure | Record representative failure analysis in the final test report. |
| AC-10 | Revision history and stale-form protection | Verified | `WorkspaceRevision`, context-edit and revision workflow tests | Verify end-to-end behavior in the browser. |
| AC-11 | Human review and revision-specific approval | Verified | `ApprovalController`; revision workflow tests | Verify rejection and changes-requested journeys manually. |
| AC-12 | Review changes and record before/after evidence | Verified | `ArtifactController`; workflow tests | Confirm client-confirmation wording does not imply independent verification. |
| AC-13 | Proposal draft and human-entered commercial fields | Verified | `ProposalController`, `ProposalBuilder`; stale and unapproved proposal tests | Review generated draft against missing-price and provisional-estimate cases. |
| AC-14 | Live approved AI-service integration | Blocked | Current pipeline uses `deterministic-demo`; no live integration verified | Obtain Codly approval and authorized credentials, then implement and test the integration. |
| AC-15 | PDF/DOCX text extraction | Verified (text extraction only) | `DocumentExtractor`; `DocumentExtractorTest` and revision workflow DOCX upload test | Text extraction is implemented. Scanned/image-only PDFs and OCR are unsupported. End-to-end upload verification remains necessary. |
| AC-16 | OCR, audio, screenshot and URL analysis | Not Implemented | Current intake limitations explicitly exclude these capabilities | Treat as future scope unless the approved specification requires them now. |
| AC-17 | Human evaluation dataset and completed rating sheet | Not Implemented | Evaluation dimensions are specified, but no completed human-rating results are evidenced here | Use fictional or approved examples and record actual reviewer ratings. |
| AC-18 | Complete official 12-chapter report | Not Implemented | This report draft is being prepared; final review and factual confirmation remain outstanding | Verify all chapters, references and implementation claims before submission. |
| AC-19 | Technical and user documentation | Verified | README contains setup, operation, limitations and workflow guidance | Perform a clean setup walkthrough and confirm instructions against the final code. |
| AC-20 | Git repository and publication readiness | Partially Verified | Local Git repository exists on `main`; public visibility and secret audit are not verified | Review tracked and untracked files, inspect for secrets, verify remote visibility, and obtain explicit publication approval before publishing. |
| AC-21 | Reviewer-assignment hardening | Verified | Patch applied and full suite passed afterward | Confirm owner and reviewer assignment behavior in a focused feature test and browser walkthrough. |
| AC-22 | Production readiness | Not Implemented | Current evidence establishes a tested development/demo workflow, not production readiness | Complete security, deployment, privacy, backup, monitoring and operational acceptance. |

## Acceptance decision

The current evidence supports a tested development/demo workflow with source traceability, structured validation, revision handling and human review controls. It does not establish full requirement coverage, live AI integration, document extraction, production readiness or business impact.

Final acceptance requires the remaining gaps to be resolved or explicitly approved as out of scope, with evidence retained for every decision.