# AI-Powered Business Requirement & Project Analysis System
## Internship Project Report — Evidence-Based Draft

**Organization:** Codly India Private Limited
**Author:** Astarag Diasi
**Report date:** 13 October 2026
**Status:** Draft for factual review and supervisor approval

> This DRAFT describes implementation and recorded evidence: 26 representative real-Chrome browser checks passed, including readable PDF and DOCX paragraph/table intake through analysis/review; final local regressions passed 79 tests / 566 assertions. It does not claim live AI integration, general semantic accuracy, production deployment or measured business impact. Scanned/image-only PDFs and OCR remain unsupported. Chapter 2 distinguishes specification information from Codly's internal process, which requires supervisor confirmation.

# Chapter 1 — Introduction

The official Codly specification (sections 1–63) and master implementation/compliance plan were read from the supplied Downloads files on 13 October 2026; the remote project handoff is now preserved locally. They define the expected workflow, not evidence of completed implementation. This report remains DRAFT and actual Codly evaluation/approval is PENDING CODLY.

Business requirements may arrive as short messages, notes, structured descriptions or incomplete statements. Turning these inputs into a clear scope requires identifying what is known, what remains unanswered, and which assumptions require confirmation.

The project aims to provide a web-based workspace for collecting requirement information, producing structured analysis, recording review decisions and preparing provisional project and proposal artifacts. The intended approach is AI-assisted rather than fully autonomous: people remain responsible for confirming requirements and approving scope and commercial commitments.

The implementation reviewed for this draft uses Laravel, PHP and MySQL. Its current analysis provider is deterministic and heuristic-based. Therefore, the present system demonstrates workflow and validation behavior rather than a production LLM-powered service.

# Chapter 2 — Existing Process

Company intake channels, authority roles and process metrics require supervisor confirmation; no organizational baseline is invented.

The supplied official specification describes intake through messages, emails, documents, notes and other channels. Its target workflow does not establish measured current departments, tools, approval chains, turnaround times or defect rates. Those company-specific facts require supervisor confirmation.

Before final submission, the supervisor should confirm the actual intake channels, stakeholder roles, current documentation practices, review stages, recurring issues and approval responsibilities. The report should record those confirmed facts and identify the source of each material statement.

The acceptance matrix maps the inspected implementation to the official specification and master plan while retaining coverage gaps. Company process facts and measured impact must not be invented.

# Chapter 3 — Problem Identification

There is no measured before/after productivity or performance baseline. The operator’s 72 passing checkpoint tests measure selected behavior, not semantic truth, human quality or business impact.

Incomplete or ambiguous requirements can leave important questions unresolved. Contradictory statements can cause scope confusion, while unsupported assumptions can be mistaken for client-confirmed decisions. Changes after approval can also make an earlier decision obsolete.

The project addresses these risks through source records, structured findings, provenance labels, revision history, reviewer decisions and checks that prevent approval of stale revisions. These controls help make uncertainty visible; they do not guarantee that every requirement is correctly understood.

Quantified claims about time saved, defect reduction, cost savings or productivity improvements require a separate measured comparison and are not asserted here.

# Chapter 4 — Proposed Solution

The corrective implementation makes DEMO scope, requirement titles, missing questions and planning outputs source-specific within the existing contract. Human decisions and exact-revision gates remain. The fresh local suite at merge `9dbf9738` passed; Linux CI exposed two DOCX MIME validation failures, recorded separately in the execution status.

The proposed workflow is:

1. Authenticate the user and create or open a project workspace.
2. Record project context and submit text, structured information, or a supported readable PDF/DOCX document.
3. Run the available analysis provider and validate its structured output.
4. Inspect findings, source evidence, missing information, ambiguity and scope suggestions.
5. Record human edits, clarifications and review decisions against a specific revision.
6. Require review of the current completed analysis before approval.
7. Generate a proposal draft using human-entered commercial inputs and explicit provisional wording.
8. Preserve revision and audit history as the project changes.

The current implementation provides a deterministic demo for the analysis stage. Integrating a live AI provider requires explicit Codly authorization and approved credentials. Pricing, delivery estimates, scope and external commitments must remain subject to human approval.

# Chapter 5 — Technology

Fresh `composer show --direct` confirmed Laravel 13.35.0, PHPWord 1.1.0, pdfparser 2.12.5, PHPUnit 12.5.38 and Pint 1.32.1. The working CLI reported PHP 8.5.0; CI uses PHP 8.4. MySQL 8.0.46 remains a historical local environment record, not a new database verification. No dependency changes or real-data migrations were performed.

## Implemented technology

- **PHP:** application runtime; the recorded local CLI was PHP 8.5.0, while CI is configured for PHP 8.4.
- **Laravel 13.35.0:** routing, request validation, authentication, authorization and application services.
- **MySQL 8.0.46:** relational persistence.
- **Blade and web forms:** workspace and review interface.
- **Automated tests:** Laravel/PHPUnit tests for selected workflow, validation and security behaviors.

These versions and the database connection were recorded as verified during the development audit. The final submission should retain the output of the last successful test run.

## Cost, maintenance and alternatives

The present implementation uses the deterministic provider and does not demonstrate usage charges from a live AI service. Actual operating costs depend on hosting, database operations, backups, maintenance and any subsequently approved provider.

A future live integration should compare approved services against authorized self-hosted alternatives, considering quality, latency, privacy, access control, cost and maintenance. No vendor price or commercial commitment is asserted in this report without an approved source and date.

# Chapter 6 — System Design

Document intake uses temporary upload paths and stores normalized text plus filename/format; original binaries, page locations and exact document layout are not retained. Source authorization now preserves the policy’s 404 denial before validation, while locked-project reauthorization remains. No schema changes or real-data migrations were made.

The application is organized around controllers, request validation, policies, analysis services, models, revision management and Blade views.

Project access distinguishes the owner from an assigned reviewer. Owner-only project-context changes and reviewer-only decision actions are enforced through authorization checks. Revision-sensitive operations lock the project record within a transaction, compare the submitted revision with the current revision, and reject stale requests.

Requirement sources retain original text. Structured analysis results are validated against an expected contract, including allowed provenance labels and source references. Review operations retain before/after data and create a new revision so earlier approvals cannot silently authorize changed content.

Sensitive operational details should not be included in audit messages or user-facing exceptions. The final security review must additionally confirm secret handling, logging, deployment configuration, backup protection and access controls for the actual deployment environment.

# Chapter 7 — Implementation

Checkpoint b6ccaf1 includes DOCX table traversal, archive/content checks, categories, priority labels, scope groups and draft payment/support fields. Corrective commit 60a9cf8 preserves policy denial status and adds source-specific DEMO planning and questions. The merge retains both development commits and the remote handoff; fresh local regressions passed. Browser verification and semantic quality remain separate.

The inspected implementation includes:

- Project creation, listing, viewing and owner-controlled context updates.
- Text and structured source intake with validation and size limits.
- A deterministic analysis provider and structured-output validation.
- Reviewable findings, source provenance and scope classification.
- Reviewer assignment and reviewer-specific authorization.
- Revision advancement, approval decisions and audit records.
- A proposal-drafting workflow for human-entered effort, price, currency, maintenance terms, third-party costs and client responsibilities; drafting remains gated on approval of the current scope.
- Tests covering malformed analysis output, conflicts, provenance, stale revisions, authorization and confidential-content handling.

PDF/DOCX readable-text extraction passed representative real-browser upload-to-analysis checks, including DOCX paragraphs/table cells. Scanned/image-only PDFs, OCR and other excluded media inputs remain unsupported. This is a deterministic DEMO workflow, not a verified live AI platform.

# Chapter 8 — AI Methodology

Codex/OpenAI assisted engineering, review, regression design and documentation, including this follow-up. The human operator authored checkpoint b6ccaf1 and owns subsequent verification/commit. Git authorship does not claim every line was written without AI. See [AI assistance disclosure](AI_USAGE_DISCLOSURE.md). Live prompts ai-v1 are unchanged; demo-v1 remains a heuristic contract identifier. No live call or training occurred.

The current provider is a deterministic keyword/heuristic implementation. Its outputs are generated demo suggestions, not the results of a live language model. Its behavior can be predictable for known patterns but can miss context, produce incomplete findings or misclassify unfamiliar wording.

The analysis contract restricts output keys and provenance values, checks source references, and applies additional validation to client-confirmed statements. The pipeline uses bounded correction attempts for certain validation failures and handles provider failures without intentionally exposing confidential exception content.

The provenance categories are Client Confirmed, AI Inferred, AI Suggested and Missing. A finding should not be labelled client-confirmed without an explicit confirmation action and associated evidence. A reviewer-entered attestation is not independent proof that the client personally supplied the text.

Any future live AI integration must use only Codly-approved services and credentials. It should preserve source evidence, validate structured output, handle provider failure explicitly and require human review of consequential decisions.

# Chapter 9 — Testing

Final real-browser pass: **26 PASS / 0 FAIL / 0 BLOCKED** in installed Chrome 155.0.8059.40 via temporary Playwright 1.64.0, using fictional accounts, fresh SQLite and temporary storage. Login/logout, project/text/PDF/DOCX intake, analysis/classification/priorities/questions/conflicts/provenance, planning/scope, owner/reviewer boundaries, unpriced drafts, revision invalidation and malformed inputs passed. Actual [results and 14 screenshots](browser-acceptance/README.md) are retained. Expected 409/422 workflow refusals initially displayed a generic error; two strengthened regressions reproduced that defect. A narrow plain-text renderer preserves refusal status and displays its reason; affected scenarios passed on retest. Final full suite: **79 pass / 566 assertions**, exit 0, one PHPWord deprecation; Pint passed. Previous 79/560 and other results below are historical and not replaced.

Final portability-fix follow-up: local suite **79 pass / 560 assertions**, exit 0, with one non-failing PHPWord warning; Pint passed. Linux CI diagnosed valid DOCX as generic binary MIME. The fix allows that MIME only for DOCX while retaining package structure, expansion, parsing and text limits; positive and binary/file-array refusal regressions pass. Both Linux PHP 8.4 test and frontend jobs succeeded at normally published fix `9fa6cb967345a9c372a614ae92ac0cb820e8a3cd`. This is automated verification, not browser or company acceptance. Historical failures and counts remain below.

The operator supplied the first full checkpoint-b6ccaf1 result: **72 PASS, one failure, 479 assertions and one deprecation**. The failure expected 404 for an unassigned document uploader but received 403. The established policy hides inaccessible projects; the source Form Request lost that status by converting the response to a boolean. This pass preserves the policy response and retains the 404 test expectation with no-source/no-audit/no-artifact/unchanged-revision assertions.

Historical baseline: 58 tests / 325 assertions; checkpoint b6ccaf1: 72 pass, one failure, 479 assertions; corrective 60a9cf8: operator-reported 74 pass / 507 assertions, one deprecation, Pint 73 files and Vite build pass. Fresh finishing run at merge 9dbf9738: tool-reported 75 pass / 507 assertions, one deprecation, exit 0. Fresh Pint formatting passed without source changes and Vite 8.3.4 build passed. These runs have distinct scopes and are retained in the execution record; no semantic quality score follows from their counts.

A focused fictional planning regression checks source-specific classification, unanswered payment-provider questions, candidate entities, task dependencies, priority, evidence and lack of approval. Existing document workflow fixtures exercise readable PDF/DOCX tables, rejection/changes-requested/approval and nonbinding revision-bound drafts in an isolated test database. Those fixture approvals are not human acceptance.

The focused DocumentExtractorTest diagnostic passed 5 tests / 8 assertions and reproduced the non-failing warning in PHPWord 1.1.0 Style.php:180: “Using null as an array offset is deprecated, use an empty string instead.” The earlier pdfparser inspection hypothesis was not the reproduced cause. No vendor edit, suppression or dependency change was made. GitHub CI at merge 9dbf9738 had 73 passing tests and two DOCX upload MIME failures (471 assertions); final diagnosis/disposition is in the execution status.

Earlier connected-browser inventory was empty, but the final pass successfully used locally installed Chrome through Playwright under explicit user authorization. Those earlier browser-unavailable reports remain historical in execution status. The representative workflow passed; full production security/usability and semantic quality remain distinct. Human evaluation is PENDING CODLY, with no ratings or supervisor signature.

# Chapter 10 — Limitations

DEMO now provides source-specific scope/planning and candidate entity/integration review, but does not establish comprehensive business-type/outcome modeling, validated journeys or a final entity/integration design. Business type, measurable outcomes, relationships, providers and costs remain missing unless supplied and reviewed. Confidential source text is retained; comprehensive credential redaction is not guaranteed. DOCX headers, footers, text boxes and layout need representative verification.

The current analysis provider is deterministic rather than a live LLM. Its heuristic approach cannot provide general semantic understanding and must not be presented as equivalent to a production AI service.

Representative readable PDF/DOCX intake and workflow passed real-browser checks; all document variants are not thereby accepted. Scanned/image-only PDFs, OCR, audio, screenshot and URL analysis remain unsupported. Existing MySQL authentication returned SQLSTATE 1045 on read-only inspection; acceptance used isolated SQLite and does not certify MySQL concurrency or that local connection. No completed Codly human rating sheet or measured business-impact study exists.

The current test suite does not establish production deployment security, performance under load, backup recovery, availability or complete acceptance of every official requirement. The current application should be treated as a development/demo system until these areas are evaluated.

# Chapter 11 — Future Scope

Final regressions, formatting and representative real-browser acceptance are recorded. Broader document/device/production checks and local MySQL configuration remain separate limitations; no semantic improvement score is claimed. Live AI integration is BLOCKED and actual Codly reviewer evaluation is PENDING CODLY.

Potential future work, subject to supervisor approval, includes:

- Integration with a Codly-approved AI provider.
- End-to-end PDF/DOCX acceptance, additional malformed/encrypted/oversized file cases, and source-location traceability.
- A curated fictional or authorized evaluation dataset and a completed human evaluation sheet.
- Expanded role-based usability and end-to-end acceptance testing.
- Additional observability, operational monitoring, backup/recovery and deployment hardening.
- A measured comparison between manual analysis and the supported workflow.

These items are proposals, not claims about existing functionality. Any external AI integration must follow Codly's authorization, privacy and data-handling requirements.

# Chapter 12 — Conclusion

The finishing pass continued from clean merge 9dbf9738 and published it by normal non-force push under user-reported Codly authorization. Both local development commits and the remote handoff remain in history. Public publication does not authorize live provider access, client-data transfer or deployment; only authorized humans can approve commitments or sign this DRAFT. Codex history remains intact.

The implementation demonstrates a Laravel workspace with structured intake, deterministic analysis, validation, provenance, revision-sensitive review and gated unpriced proposal drafts. Representative Chrome acceptance passed 26 checks; final local regressions passed 79 tests / 566 assertions with one PHPWord deprecation and passing Pint. The existing frontend build passed; final publication/CI is recorded in execution status. These results support a documented demo submission, not production readiness or completed Codly human evaluation.

Live AI integration, completed human quality evaluation, company-process confirmation/report approval and any production deployment review remain outstanding. Representative browser acceptance is now evidenced; actual portal submission remains the user's external action. No business-impact score, signature or final commercial commitment is invented.

Before submission, the author and supervisor should review the acceptance matrix, confirm company-specific facts, inspect the final repository and configuration, verify all reported test results, and approve any outstanding scope exclusions.
## Evidence references

- [Acceptance matrix](acceptance-matrix.md) and [current execution record](FINAL_EXECUTION_STATUS.md)
- [Fictional evaluation cases](evaluation-cases.md) and [blank human evaluation sheet](human-evaluation-sheet.md)
- [Analysis contract validator](../app/AnalysisValidator.php), [revision-bound review](../app/Http/Controllers/ArtifactController.php), [draft builder](../app/ProposalBuilder.php)
- [Prepared document regressions](../tests/Feature/DocumentWorkflowTest.php) and [scenario regressions](../tests/Feature/AnalysisScenariosTest.php)

Supervisor decision/signature/date: **Pending — must be entered by the authorized human.**
