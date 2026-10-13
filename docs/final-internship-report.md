# AI-Powered Business Requirement & Project Analysis System
## Internship Project Report — Evidence-Based Draft

**Organization:** Codly India Private Limited
**Author:** Astarag Diasi
**Report date:** 13 October 2026
**Status:** Draft for factual review and supervisor approval

> This report describes the current inspected implementation and recorded test evidence. It does not claim that live AI integration, complete end-to-end document-upload behaviour, production deployment or business impact has been demonstrated. PDF/DOCX text extraction is implemented for supported, readable documents; scanned/image-only PDFs and OCR remain unsupported. The latest end-to-end upload/analysis verification is still pending. Chapter 2 deliberately distinguishes confirmed project information from Codly's internal process, which must be confirmed by the supervisor.

# Chapter 1 — Introduction

The Codly specification remains authoritative. Approved local specification/handoff evidence is still missing; preserved prior execution records are historical. This report remains DRAFT and actual Codly evaluation/approval is PENDING CODLY.

Business requirements may arrive as short messages, notes, structured descriptions or incomplete statements. Turning these inputs into a clear scope requires identifying what is known, what remains unanswered, and which assumptions require confirmation.

The project aims to provide a web-based workspace for collecting requirement information, producing structured analysis, recording review decisions and preparing provisional project and proposal artifacts. The intended approach is AI-assisted rather than fully autonomous: people remain responsible for confirming requirements and approving scope and commercial commitments.

The implementation reviewed for this draft uses Laravel, PHP and MySQL. Its current analysis provider is deterministic and heuristic-based. Therefore, the present system demonstrates workflow and validation behavior rather than a production LLM-powered service.

# Chapter 2 — Existing Process

Company intake channels, authority roles and process metrics require supervisor confirmation; no organizational baseline is invented.

An approved project specification was not found in this checkout. The task brief describes the intended problem area but does not establish Codly's actual internal process. No unverified claim about current departments, tools, approval chains, turnaround times or defect rates is made in this report.

Before final submission, the supervisor should confirm the actual intake channels, stakeholder roles, current documentation practices, review stages, recurring issues and approval responsibilities. The report should record those confirmed facts and identify the source of each material statement.

Until the specification and process facts are supplied, this draft compares the implementation with the operator’s task brief and records coverage gaps. Self-service completion does not authorize inventing company process facts.

# Chapter 3 — Problem Identification

There is no measured before/after productivity or performance baseline. The operator’s 72 passing checkpoint tests measure selected behavior, not semantic truth, human quality or business impact.

Incomplete or ambiguous requirements can leave important questions unresolved. Contradictory statements can cause scope confusion, while unsupported assumptions can be mistaken for client-confirmed decisions. Changes after approval can also make an earlier decision obsolete.

The project addresses these risks through source records, structured findings, provenance labels, revision history, reviewer decisions and checks that prevent approval of stale revisions. These controls help make uncertainty visible; they do not guarantee that every requirement is correctly understood.

Quantified claims about time saved, defect reduction, cost savings or productivity improvements require a separate measured comparison and are not asserted here.

# Chapter 4 — Proposed Solution

The current pass makes DEMO scope, requirement titles, missing questions and planning outputs source-specific within the existing contract. Human decisions and exact-revision gates remain. Post-edit runtime verification is pending the parent process.

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

Installed metadata/Boost lists Laravel 13.35.0, PHPWord 1.1.0, pdfparser 2.12.5, PHPUnit 12.5.38 and Pint 1.32.1. This pass confirmed response authorization against installed Laravel source and Boost documentation. Shell startup failed; historical MySQL/PHP environment records were not freshly verified.

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

Checkpoint b6ccaf1 already includes DOCX table traversal, archive/content checks, categories, priority labels, scope groups and draft payment/support fields. This pass fixes the source authorization status loss and adds source-specific DEMO scope candidates, descriptive categorized requirements, missing questions, candidate entities/integration review, journey notes and three-stage task dependencies/phase gates. Post-edit regressions await execution.

The inspected implementation includes:

- Project creation, listing, viewing and owner-controlled context updates.
- Text and structured source intake with validation and size limits.
- A deterministic analysis provider and structured-output validation.
- Reviewable findings, source provenance and scope classification.
- Reviewer assignment and reviewer-specific authorization.
- Revision advancement, approval decisions and audit records.
- A proposal-drafting workflow for human-entered effort, price, currency, maintenance terms, third-party costs and client responsibilities; drafting remains gated on approval of the current scope.
- Tests covering malformed analysis output, conflicts, provenance, stale revisions, authorization and confidential-content handling.

PDF/DOCX text extraction is implemented for supported, readable documents. Scanned or image-only PDFs and OCR remain unsupported, as do the other excluded media inputs. End-to-end upload verification remains outstanding. The current code must not be described as a fully integrated live AI platform.

# Chapter 8 — AI Methodology

Codex/OpenAI assisted engineering, review, regression design and documentation, including this follow-up. The human operator authored checkpoint b6ccaf1 and owns subsequent verification/commit. Git authorship does not claim every line was written without AI. See [AI assistance disclosure](AI_USAGE_DISCLOSURE.md). Live prompts ai-v1 are unchanged; demo-v1 remains a heuristic contract identifier. No live call or training occurred.

The current provider is a deterministic keyword/heuristic implementation. Its outputs are generated demo suggestions, not the results of a live language model. Its behavior can be predictable for known patterns but can miss context, produce incomplete findings or misclassify unfamiliar wording.

The analysis contract restricts output keys and provenance values, checks source references, and applies additional validation to client-confirmed statements. The pipeline uses bounded correction attempts for certain validation failures and handles provider failures without intentionally exposing confidential exception content.

The provenance categories are Client Confirmed, AI Inferred, AI Suggested and Missing. A finding should not be labelled client-confirmed without an explicit confirmation action and associated evidence. A reviewer-entered attestation is not independent proof that the client personally supplied the text.

Any future live AI integration must use only Codly-approved services and credentials. It should preserve source evidence, validate structured output, handle provider failure explicitly and require human review of consequential decisions.

# Chapter 9 — Testing

The operator supplied the first full checkpoint-b6ccaf1 result: **72 PASS, one failure, 479 assertions and one deprecation**. The failure expected 404 for an unassigned document uploader but received 403. The established policy hides inaccessible projects; the source Form Request lost that status by converting the response to a boolean. This pass preserves the policy response and retains the 404 test expectation with no-source/no-audit/no-artifact/unchanged-revision assertions.

The other 72 checkpoint cases previously passed; they are not post-edit evidence. Pint reported 15 style issues across 73 files; parent auto-fix and verification are pending. This pass’s shell failed before startup, so no fresh Laravel test, syntax, build or Pint result is claimed. Earlier build/syntax results remain historical in the preserved execution record.

A focused fictional planning regression checks source-specific classification, unanswered payment-provider questions, candidate entities, task dependencies, priority, evidence and lack of approval. Existing document workflow fixtures exercise readable PDF/DOCX tables, rejection/changes-requested/approval and nonbinding revision-bound drafts in an isolated test database. Those fixture approvals are not human acceptance.

Deprecation inspection located smalot/pdfparser Font::uchr calling mb_convert_encoding with deprecated HTML-ENTITIES encoding at vendor source line 150. The reported single warning’s exact runtime stack is unavailable. Parent must run DocumentExtractorTest with --display-deprecations and --display-phpunit-deprecations to confirm origin; no vendor edit, suppression or unapproved dependency change was made.

Browser inventory returned no connected apps/browsers: browser checks are **NOT TESTED**. Feature HTTP tests do not prove browser rendering, uploads, anti-CSRF or usability. Human evaluation is **PENDING CODLY**, with no ratings or supervisor signature. See [pending verification and manual steps](FINAL_EXECUTION_STATUS.md).

# Chapter 10 — Limitations

DEMO now provides source-specific scope/planning and candidate entity/integration review, but does not establish comprehensive business-type/outcome modeling, validated journeys or a final entity/integration design. Business type, measurable outcomes, relationships, providers and costs remain missing unless supplied and reviewed. Confidential source text is retained; comprehensive credential redaction is not guaranteed. DOCX headers, footers, text boxes and layout need representative verification.

The current analysis provider is deterministic rather than a live LLM. Its heuristic approach cannot provide general semantic understanding and must not be presented as equivalent to a production AI service.

Readable PDF/DOCX text extraction and a document-upload workflow are implemented in the current branch, but full end-to-end acceptance for both formats remains pending. Scanned/image-only PDFs, OCR, audio, screenshot and URL analysis are not part of the current implemented intake. A completed human evaluation sheet and measured business-impact study have not been evidenced in this draft.

The current test suite does not establish production deployment security, performance under load, backup recovery, availability or complete acceptance of every official requirement. The current application should be treated as a development/demo system until these areas are evaluated.

# Chapter 11 — Future Scope

The parent process must run focused regressions, final tests/Pint and the exact deprecation diagnostic, then append results. Manual/browser acceptance and official scope reconciliation remain. No semantic improvement score is claimed. Live AI integration is BLOCKED and actual reviewer evaluation is PENDING CODLY; both are deliberately excluded from self-service work while retained in governance.

Potential future work, subject to supervisor approval, includes:

- Integration with a Codly-approved AI provider.
- End-to-end PDF/DOCX acceptance, additional malformed/encrypted/oversized file cases, and source-location traceability.
- A curated fictional or authorized evaluation dataset and a completed human evaluation sheet.
- Expanded role-based usability and end-to-end acceptance testing.
- Additional observability, operational monitoring, backup/recovery and deployment hardening.
- A measured comparison between manual analysis and the supported workflow.

These items are proposals, not claims about existing functionality. Any external AI integration must follow Codly's authorization, privacy and data-handling requirements.

# Chapter 12 — Conclusion

This pass did not stage, commit, push or rewrite history, as instructed. Starting HEAD is human checkpoint b6ccaf1; the parent operator will verify and commit. Live provider access, client-data transfer, public release and deployment require Codly authorization; only authorized humans can approve commitments or sign this DRAFT.

The inspected implementation demonstrates a Laravel-based requirement-analysis workspace with structured intake, deterministic analysis, validation, provenance handling, revision-sensitive review, approval records and a proposal-drafting workflow gated on approval of the current scope. PDF/DOCX text extraction is implemented. The operator’s checkpoint evidence is 72 passing tests, one failure, 479 assertions and one deprecation. The known denial-status fix and semantic regressions await parent verification; no post-edit suite or Pint pass is claimed. These checks support a development/demo milestone, not production readiness or completed human evaluation.

The evidence supports a development/demo milestone, not a claim of complete acceptance or production readiness. Live AI integration, end-to-end document-upload verification, completed human evaluation results, company-process confirmation and final deployment review remain outstanding or require additional evidence.

Before submission, the author and supervisor should review the acceptance matrix, confirm company-specific facts, inspect the final repository and configuration, verify all reported test results, and approve any outstanding scope exclusions.
## Evidence references

- [Acceptance matrix](acceptance-matrix.md) and [current execution record](FINAL_EXECUTION_STATUS.md)
- [Fictional evaluation cases](evaluation-cases.md) and [blank human evaluation sheet](human-evaluation-sheet.md)
- [Analysis contract validator](../app/AnalysisValidator.php), [revision-bound review](../app/Http/Controllers/ArtifactController.php), [draft builder](../app/ProposalBuilder.php)
- [Prepared document regressions](../tests/Feature/DocumentWorkflowTest.php) and [scenario regressions](../tests/Feature/AnalysisScenariosTest.php)

Supervisor decision/signature/date: **Pending — must be entered by the authorized human.**
