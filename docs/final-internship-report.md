# AI-Powered Business Requirement & Project Analysis System
## Internship Project Report — Evidence-Based Draft

**Organization:** Codly India Private Limited
**Author:** Astarag Diasi
**Report date:** 12 October 2026
**Status:** Draft for factual review and supervisor approval

> This report describes the current inspected implementation and recorded test evidence. It does not claim that live AI integration, document extraction, production deployment or business impact has been demonstrated. Chapter 2 deliberately distinguishes confirmed project information from Codly's internal process, which must be confirmed by the supervisor.

# Chapter 1 — Introduction

Business requirements may arrive as short messages, notes, structured descriptions or incomplete statements. Turning these inputs into a clear scope requires identifying what is known, what remains unanswered, and which assumptions require confirmation.

The project aims to provide a web-based workspace for collecting requirement information, producing structured analysis, recording review decisions and preparing provisional project and proposal artifacts. The intended approach is AI-assisted rather than fully autonomous: people remain responsible for confirming requirements and approving scope and commercial commitments.

The implementation reviewed for this draft uses Laravel, PHP and MySQL. Its current analysis provider is deterministic and heuristic-based. Therefore, the present system demonstrates workflow and validation behavior rather than a production LLM-powered service.

# Chapter 2 — Existing Process

The approved project specification describes the intended problem area but does not, by itself, establish every detail of Codly's existing internal requirement-analysis process. No unverified claim about current departments, tools, approval chains, turnaround times or defect rates is made in this report.

Before final submission, the supervisor should confirm the actual intake channels, stakeholder roles, current documentation practices, review stages, recurring issues and approval responsibilities. The report should record those confirmed facts and identify the source of each material statement.

Until that confirmation is obtained, the project is evaluated against the approved requirements and its implemented workflow rather than an invented description of company operations.

# Chapter 3 — Problem Identification

Incomplete or ambiguous requirements can leave important questions unresolved. Contradictory statements can cause scope confusion, while unsupported assumptions can be mistaken for client-confirmed decisions. Changes after approval can also make an earlier decision obsolete.

The project addresses these risks through source records, structured findings, provenance labels, revision history, reviewer decisions and checks that prevent approval of stale revisions. These controls help make uncertainty visible; they do not guarantee that every requirement is correctly understood.

Quantified claims about time saved, defect reduction, cost savings or productivity improvements require a separate measured comparison and are not asserted here.

# Chapter 4 — Proposed Solution

The proposed workflow is:

1. Authenticate the user and create or open a project workspace.
2. Record project context and submit text or structured requirement information.
3. Run the available analysis provider and validate its structured output.
4. Inspect findings, source evidence, missing information, ambiguity and scope suggestions.
5. Record human edits, clarifications and review decisions against a specific revision.
6. Require review of the current completed analysis before approval.
7. Generate a proposal draft using human-entered commercial inputs and explicit provisional wording.
8. Preserve revision and audit history as the project changes.

The current implementation provides a deterministic demo for the analysis stage. Integrating a live AI provider requires explicit Codly authorization and approved credentials. Pricing, delivery estimates, scope and external commitments must remain subject to human approval.

# Chapter 5 — Technology

## Implemented technology

- **PHP 8.4.25:** application runtime.
- **Laravel 13.35.0:** routing, request validation, authentication, authorization and application services.
- **MySQL 8.0.46:** relational persistence.
- **Blade and web forms:** workspace and review interface.
- **Automated tests:** Laravel/PHPUnit tests for selected workflow, validation and security behaviors.

These versions and the database connection were recorded as verified during the development audit. The final submission should retain the output of the last successful test run.

## Cost, maintenance and alternatives

The present implementation uses the deterministic provider and does not demonstrate usage charges from a live AI service. Actual operating costs depend on hosting, database operations, backups, maintenance and any subsequently approved provider.

A future live integration should compare approved services against authorized self-hosted alternatives, considering quality, latency, privacy, access control, cost and maintenance. No vendor price or commercial commitment is asserted in this report without an approved source and date.

# Chapter 6 — System Design

The application is organized around controllers, request validation, policies, analysis services, models, revision management and Blade views.

Project access distinguishes the owner from an assigned reviewer. Owner-only project-context changes and reviewer-only decision actions are enforced through authorization checks. Revision-sensitive operations lock the project record within a transaction, compare the submitted revision with the current revision, and reject stale requests.

Requirement sources retain original text. Structured analysis results are validated against an expected contract, including allowed provenance labels and source references. Review operations retain before/after data and create a new revision so earlier approvals cannot silently authorize changed content.

Sensitive operational details should not be included in audit messages or user-facing exceptions. The final security review must additionally confirm secret handling, logging, deployment configuration, backup protection and access controls for the actual deployment environment.

# Chapter 7 — Implementation

The inspected implementation includes:

- Project creation, listing, viewing and owner-controlled context updates.
- Text and structured source intake with validation and size limits.
- A deterministic analysis provider and structured-output validation.
- Reviewable findings, source provenance and scope classification.
- Reviewer assignment and reviewer-specific authorization.
- Revision advancement, approval decisions and audit records.
- Proposal drafting with human-entered effort, price, currency, maintenance terms, third-party costs and client responsibilities.
- Tests covering malformed analysis output, conflicts, provenance, stale revisions, authorization and confidential-content handling.

PDF/DOCX extraction and other excluded media inputs are not implemented. The current code must not be described as a fully integrated live AI platform.

# Chapter 8 — AI Methodology

The current provider is a deterministic keyword/heuristic implementation. Its outputs are generated demo suggestions, not the results of a live language model. Its behavior can be predictable for known patterns but can miss context, produce incomplete findings or misclassify unfamiliar wording.

The analysis contract restricts output keys and provenance values, checks source references, and applies additional validation to client-confirmed statements. The pipeline uses bounded correction attempts for certain validation failures and handles provider failures without intentionally exposing confidential exception content.

The provenance categories are Client Confirmed, AI Inferred, AI Suggested and Missing. A finding should not be labelled client-confirmed without an explicit confirmation action and associated evidence. A reviewer-entered attestation is not independent proof that the client personally supplied the text.

Any future live AI integration must use only Codly-approved services and credentials. It should preserve source evidence, validate structured output, handle provider failure explicitly and require human review of consequential decisions.

# Chapter 9 — Testing

The latest recorded successful run reported **46 tests passed and 283 assertions** in approximately 2.80 seconds. The run followed repair of a PHP file encoding issue that had temporarily caused a namespace-declaration fatal error.

Recorded test coverage includes:

- Malformed or unsupported structured analysis output.
- Analysis scenarios and conflicting sources.
- Provenance and evidence validation.
- Stale proposal submission and proposals without current approval.
- Unauthorized or unassigned reviewer access.
- Empty, oversized and unsupported file submissions.
- Explicit client confirmation and changed confirmed content.
- Confidential content escaping and bounded failure handling.
- Revision history, stale forms, login/logout and database failure handling.

These results are evidence for the exercised tests only. They are not proof of complete feature coverage, production readiness or correct results for every possible requirement. The final submission should preserve the actual test output and document failures, limitations and any additional manual tests performed.

# Chapter 10 — Limitations

The current analysis provider is deterministic rather than a live LLM. Its heuristic approach cannot provide general semantic understanding and must not be presented as equivalent to a production AI service.

Document upload and extraction are unsupported. OCR, audio, screenshot and URL analysis are not part of the current implemented intake. A completed human evaluation sheet and measured business-impact study have not been evidenced in this draft.

The current test suite does not establish production deployment security, performance under load, backup recovery, availability or complete acceptance of every official requirement. The current application should be treated as a development/demo system until these areas are evaluated.

# Chapter 11 — Future Scope

Potential future work, subject to supervisor approval, includes:

- Integration with a Codly-approved AI provider.
- PDF/DOCX extraction with validation and source-location traceability.
- A curated fictional or authorized evaluation dataset and a completed human evaluation sheet.
- Expanded role-based usability and end-to-end acceptance testing.
- Additional observability, operational monitoring, backup/recovery and deployment hardening.
- A measured comparison between manual analysis and the supported workflow.

These items are proposals, not claims about existing functionality. Any external AI integration must follow Codly's authorization, privacy and data-handling requirements.

# Chapter 12 — Conclusion

The inspected implementation demonstrates a Laravel-based requirement-analysis workspace with structured intake, deterministic analysis, validation, provenance handling, revision-sensitive review, approval records and provisional proposal generation. The latest recorded automated run passed 46 tests with 283 assertions.

The evidence supports a development/demo milestone, not a claim of complete acceptance or production readiness. Live AI integration, document extraction, human evaluation results, company-process confirmation and final deployment review remain outstanding or require additional evidence.

Before submission, the author and supervisor should review the acceptance matrix, confirm company-specific facts, inspect the final repository and configuration, verify all reported test results, and approve any outstanding scope exclusions.