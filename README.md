# Codly AI-Powered Business Requirement & Project Analysis System

A Laravel-based business requirements analysis application designed to help reviewers turn project requirements into structured, traceable analysis, clarify ambiguities, review changes, organize proposed implementation work, and prepare provisional project proposals.

The system combines a persisted web workflow, document text extraction, structured analysis contracts, a modular prompt registry, validation, revision handling, and proposal drafting. Its current analysis pipeline uses a deterministic demonstration provider. A production-ready live AI integration has **not** been verified.

> **Project status:** Implementation and verification are in progress. Read the implementation status, known limitations, acceptance matrix, and evaluation plan before treating any capability as production-ready.

---

## Table of Contents

1. [Project Overview](#1-project-overview)
2. [Problem Statement](#2-problem-statement)
3. [Objectives](#3-objectives)
4. [Users and Intended Use](#4-users-and-intended-use)
5. [Features and Implementation Status](#5-features-and-implementation-status)
6. [End-to-End Workflow](#6-end-to-end-workflow)
7. [System Architecture](#7-system-architecture)
8. [Technology Stack](#8-technology-stack)
9. [Repository Structure](#9-repository-structure)
10. [Requirement Analysis Contract](#10-requirement-analysis-contract)
11. [Modular Prompt System](#11-modular-prompt-system)
12. [AI Provider Configuration](#12-ai-provider-configuration)
13. [Document Intake and Text Extraction](#13-document-intake-and-text-extraction)
14. [Revision, Review and Approval](#14-revision-review-and-approval)
15. [Implementation Planning and Proposal Drafting](#15-implementation-planning-and-proposal-drafting)
16. [Data Persistence and Validation](#16-data-persistence-and-validation)
17. [Security and Privacy](#17-security-and-privacy)
18. [Installation and Local Setup](#18-installation-and-local-setup)
19. [Running the Application](#19-running-the-application)
20. [Testing and Verification](#20-testing-and-verification)
21. [Evaluation Strategy](#21-evaluation-strategy)
22. [Known Limitations](#22-known-limitations)
23. [Acceptance Criteria and Outstanding Work](#23-acceptance-criteria-and-outstanding-work)
24. [Troubleshooting](#24-troubleshooting)
25. [Documentation and References](#25-documentation-and-references)
26. [Responsible Use and Project Status](#26-responsible-use-and-project-status)

---

## 1. Project Overview

Codly AI-Powered Business Requirement & Project Analysis System is intended to support the early stages of software project discovery and planning.

Business requirements are often received as incomplete descriptions, informal notes, contradictory statements, or documents containing a mixture of business objectives and technical details. Converting this information into an actionable project scope requires interpretation, clarification, classification, and review.

This application provides a structured workflow for handling that information.

The application is built with Laravel and PHP and uses a relational database to persist the workflow. It includes a deterministic demonstration analysis path, a configurable analysis-provider abstraction, a modular prompt registry, structured-output validation, and a document extraction component.

### What the system is designed to produce

Depending on the information supplied and the workflow stage, the application supports organizing:

- Project and business context.
- Source requirements and their provenance.
- Functional and non-functional requirements.
- Technical and business considerations.
- Missing information, ambiguity, and potential conflicts.
- Scope, dependencies, modules, screens, and implementation phases.
- Tasks and proposed technical approaches.
- Revision history and review decisions.
- Draft project proposals with provisional commercial information.

These outputs are decision-support material. They are not automatically approved business requirements, a guaranteed implementation plan, or a binding commercial offer.

### Current implementation principle

The system must distinguish information explicitly present in the source from interpretations, suggestions, and unresolved questions. Reviewers remain responsible for validating the meaning and feasibility of the resulting analysis.

---

## 2. Problem Statement

Software project requests frequently lack the information needed for reliable estimation and implementation planning.

Common problems include:

- Unclear business goals or success criteria.
- Requirements that omit important details.
- Contradictory or outdated statements.
- Unspecified user roles, permissions, and workflows.
- Missing integrations, data requirements, or dependencies.
- Incomplete security, privacy, and performance expectations.
- Unclear boundaries between included and excluded scope.
- Changes made after an earlier analysis has been reviewed.
- Premature effort estimates or prices presented without sufficient evidence.

The project addresses these problems by providing a persisted workflow for structuring requirements, surfacing review questions, maintaining revisions, organizing implementation work, and preparing provisional proposals.

It does not eliminate the need for business analysis, technical review, client clarification, or commercial approval.

---

## 3. Objectives

The principal objectives are to:

1. Provide a structured, authenticated Laravel application for project analysis.
2. Accept requirement information through supported text and document-intake paths.
3. Preserve source information and connect extracted findings to their supporting sources where available.
4. Validate the structure and permitted fields of analysis results.
5. Organize analysis prompts into independently maintainable modules.
6. Identify missing information, ambiguity, contradictions, risks, and scope questions.
7. Support persisted project revisions and review-related workflow controls.
8. Organize proposed modules, screens, tasks, and implementation phases.
9. Generate draft proposals without falsely implying that estimates or prices have been approved.
10. Provide automated tests and documented evaluation procedures.
11. Make implementation status, technical limitations, and unverified claims explicit.
12. Keep future AI-provider integration configurable rather than assuming that an external model is already operational.

---

## 4. Users and Intended Use

### Intended users

- Business analysts collecting and organizing requirements.
- Project managers preparing project scope and delivery plans.
- Technical reviewers evaluating feasibility and dependencies.
- Developers examining structured requirements and proposed work.
- Authorized reviewers responsible for clarifications, revisions, and proposal approval.

### Intended use

The application is intended to assist with requirement organization and preliminary project planning. A reviewer should verify important statements, assumptions, dependencies, security requirements, effort estimates, and commercial terms before relying on them.

### Out of scope

The application should not be treated as:

- An autonomous replacement for a business analyst or solution architect.
- A guarantee that every requirement has been discovered.
- A validated financial or effort-estimation engine.
- An automatic contract, quotation, or pricing approval system.
- Proof that a project is secure, compliant, deployable, or production-ready.
- Evidence of live AI integration merely because provider-related code exists.

---

## 5. Features and Implementation Status

The following table distinguishes implemented components from capabilities that remain incomplete or unverified.

| Capability | Current status | Important qualification |
|---|---|---|
| Laravel application and persisted workflow | Implemented; see tests | End-to-end production readiness is not established |
| Deterministic demonstration analysis | Implemented | Demonstration output is not equivalent to validated AI analysis |
| Configurable analysis-provider abstraction | Implemented and unit-tested | A working live provider integration is not verified |
| Modular prompt registry | Implemented and unit-tested | Prompt quality still requires evaluation against representative inputs |
| Structured analysis validation | Implemented and unit-tested | Valid structure does not guarantee semantic correctness |
| PDF/DOCX text extraction | Implemented for supported readable documents | End-to-end upload verification remains outstanding |
| Scanned-document OCR | Not implemented | Image-only document text is not extracted by OCR |
| Text provenance and source references | Supported by the analysis contract | Coverage and correctness must be verified for each result |
| Revision and change-related workflow | Implemented in the current workflow | Review the acceptance matrix for exact verified behavior |
| Modules, tasks, screens, and phases | Supported by the analysis workflow | Suggestions require technical review |
| Draft proposal generation | Implemented as a workflow capability | Commercial values and terms remain provisional |
| Automated effort estimation | Not implemented as an approved model | Any effort figures are provisional |
| Approved pricing-rule engine | Not implemented | No price should be represented as automatically approved |
| Human evaluation scenarios | Defined; human-rated results pending | [`docs/evaluation-cases.md`](docs/evaluation-cases.md) contains fictional cases and expected findings; no measured quality score is claimed |
| Live production AI integration | Unverified | Requires authorization, provider configuration, and integration testing |
| Production deployment and business-impact validation | Not established | Requires separate deployment and operational evidence |

For the authoritative acceptance-by-acceptance view, consult [`docs/acceptance-matrix.md`](docs/acceptance-matrix.md).

---

## 6. End-to-End Workflow

The intended workflow is:

1. **Project creation**
   Create a project and establish its initial context.

2. **Requirement intake**
   Supply text, structured requirement information, or a readable PDF/DOCX document through the supported intake form. PDF/DOCX text extraction is implemented; scanned/image-only files and OCR are unsupported.

3. **Source preparation**
   Extract supported document text and associate source information with the analysis workflow.

4. **Analysis execution**
   Run the configured analysis path. The current application pipeline uses deterministic demonstration analysis rather than a verified live AI service.

5. **Structured result validation**
   Check that the result follows the permitted analysis contract, including allowed fields, categories, and validation rules.

6. **Clarification and conflict review**
   Examine missing information, ambiguous statements, potential conflicts, risks, and questions requiring a decision.

7. **Revision and change handling**
   Update the relevant project information and manage the resulting revision. Approval-related behavior should be verified against the current acceptance matrix and automated tests.

8. **Implementation planning**
   Organize proposed modules, screens, tasks, dependencies, and delivery phases.

9. **Proposal preparation**
   Prepare a draft describing scope, technical approach, provisional effort, and any commercial terms entered by an authorized human reviewer.

10. **Human review and decision**
    Verify the source evidence, scope, feasibility, effort, pricing, assumptions, and terms before approving or communicating the proposal.

A successful test of an individual component does not, by itself, prove that the entire workflow operates correctly from initial project creation through final approval.

---

## 7. System Architecture

The project follows a Laravel application structure with separate responsibilities for request handling, workflow orchestration, extraction, analysis-provider behavior, validation, persistence, and presentation.

### Logical architecture

```text
User / Reviewer
      |
      v
Laravel Routes and Controllers
      |
      v
Request Validation and Authorization
      |
      v
Project / Source / Revision Workflow
      |
      +----------------------------+
      |                            |
      v                            v
Document Extraction          Analysis Pipeline
(PDF / DOCX text)                  |
                                   v
                         Analysis Provider Interface
                                   |
                      +------------+-------------+
                      |                          |
                      v                          v
              Deterministic Demo       Configurable Provider
                 (current path)        (live use unverified)
                      |                          |
                      +------------+-------------+
                                   |
                                   v
                         Structured Analysis Result
                                   |
                                   v
                         Analysis Contract Validation
                                   |
                                   v
                       Persisted Review and Revisions
                                   |
                                   v
                 Modules / Tasks / Screens / Phases
                                   |
                                   v
                       Provisional Proposal Draft
                                   |
                                   v
                           Human Review
```

This diagram represents the logical design, not a claim that every external integration or end-to-end transition has been verified.

### Main application responsibilities

- **HTTP layer:** Routes, controllers, form requests, authentication, and request handling.
- **Workflow layer:** Coordinates project analysis, source handling, revisions, and related operations.
- **Document extraction:** Extracts text from supported readable PDF and DOCX documents.
- **Analysis provider:** Supplies the analysis result according to the configured provider implementation.
- **Prompt registry:** Loads and assembles the modular requirement-analysis prompt resources.
- **Validator:** Checks permitted result fields, category values, and other contract constraints.
- **Persistence:** Stores project and workflow data in the configured relational database.
- **Presentation:** Laravel views display the project workflow and its analysis-related information.
- **Automated tests:** Exercise selected contracts, providers, extraction behavior, and workflow scenarios.

### Important architectural distinction

The existence of a configurable provider implementation is not evidence that a live model is connected. The default analysis pipeline uses the deterministic demonstration provider. An optional configurable provider adapter exists, but live provider execution is unverified and must remain disabled until Codly authorizes the service, endpoint, credentials, and data handling.

---

## 8. Technology Stack

| Technology | Role |
|---|---|
| PHP | Application programming language |
| Laravel 13.35.0 | Web application framework |
| MySQL 8.0.46 | Local relational database environment |
| Composer | PHP dependency management |
| PHPUnit | Automated testing |
| Laravel/PHP validation | Request and analysis contract validation |
| Blade | Laravel server-rendered presentation |
| PDF parser dependency | Supported PDF text extraction |
| PHPWord dependency | Supported DOCX text extraction |
| Markdown prompt files | Modular analysis instructions |
| Git | Version control |
| PowerShell | Local Windows development and maintenance commands |

### Verified local environment

The latest project environment recorded for this work is:

- Laravel: `13.35.0`
- PHP CLI: `8.5.0`
- MySQL Server: `8.0.46`
- MySQL Windows service: `MySQL8046`
- Database: `codly_requirement_analyzer`
- Repository branch: `main`

These values describe the development environment recorded during implementation. They are not a guarantee that every machine has identical versions. Confirm installed versions before reproducing the setup.

---

## 9. Repository Structure

The following is a map of the main project areas. Some framework-generated files and implementation details are omitted for readability.

```text
Codly-AI-Requirement-Analyzer/
|
+-- app/
|   +-- AnalysisPipeline.php
|   +-- AnalysisPromptRegistry.php
|   +-- AnalysisValidator.php
|   +-- ConfigurableAiAnalysisProvider.php
|   +-- DocumentExtractor.php
|   +-- Http/
|   |   +-- Controllers/
|   |   |   +-- SourceController.php
|   |   +-- Requests/
|   |       +-- StoreSourceRequest.php
|   +-- Providers/
|       +-- AppServiceProvider.php
|
+-- config/
|   +-- ai_analysis.php
|
+-- resources/
|   +-- prompts/
|   |   +-- requirement-analysis/
|   |       +-- v1/
|   |           +-- README.md
|   |           +-- ambiguity_conflicts.md
|   |           +-- architecture.md
|   |           +-- business_context.md
|   |           +-- classification.md
|   |           +-- extraction.md
|   |           +-- missing_information.md
|   |           +-- modules.md
|   |           +-- phases.md
|   |           +-- proposal.md
|   |           +-- screens.md
|   |           +-- security.md
|   |           +-- tasks.md
|   +-- views/
|       +-- workspace.blade.php
|
+-- routes/
|   +-- web.php
|
+-- database/
|   +-- migrations/
|   +-- factories/
|   +-- seeders/
|
+-- tests/
|   +-- Feature/
|   +-- Unit/
|       +-- AnalysisPromptRegistryTest.php
|       +-- ConfigurableAiAnalysisProviderTest.php
|       +-- DocumentExtractorTest.php
|
+-- docs/
|   +-- acceptance-matrix.md
|   +-- ai-evaluation-plan.md
|   +-- ai-provider-setup.md
|   +-- final-internship-report.md
|   +-- human-evaluation-sheet.md
|
+-- .env.example
+-- .gitignore
+-- artisan
+-- composer.json
+-- composer.lock
+-- README.md
```

The exact directory contents may evolve. Use the files in the current checkout as the source of truth.

### Important implementation files

- `app/AnalysisPipeline.php` — coordinates the analysis workflow.
- `app/AnalysisPromptRegistry.php` — locates and assembles modular prompt resources.
- `app/ConfigurableAiAnalysisProvider.php` — builds the provider-facing analysis request and required output contract.
- `app/AnalysisValidator.php` — validates analysis fields and permitted category values.
- `app/DocumentExtractor.php` — extracts text from supported document formats.
- `app/Http/Controllers/SourceController.php` — handles source-related web requests.
- `app/Http/Requests/StoreSourceRequest.php` — applies source request validation.
- `config/ai_analysis.php` — analysis-related configuration.
- `resources/views/workspace.blade.php` — workspace presentation.
- `tests/` — automated regression and contract tests.
- `docs/` — acceptance, evaluation, provider setup, and report documentation.

---

## 10. Requirement Analysis Contract

The analysis system uses a structured output contract rather than accepting arbitrary, unrestricted result fields.

The contract is intended to make analysis results easier to validate, persist, inspect, and present in the application.

### Requirement categories

The supported category values are:

- `Functional`
- `Non-Functional`
- `Technical`
- `Business`
- `Optional`

The category is represented separately from the requirement statement when applicable. Category values must match the permitted values; an arbitrary category string is not part of the accepted contract.

### Contract and validation principles

The current implementation includes:

- Permitted top-level and item-level fields.
- Structured requirement statements and supporting source information.
- Optional categorization where applicable.
- Validation of category values.
- Rejection of unsupported fields where the relevant validation rules apply.
- Contract tests for representative accepted and rejected structures.

The provider contract includes fields such as `title`, `provenance`, `source_ids`, `statements`, `priority`, `scope`, `role`, `objective`, `feature`, `dependencies`, `notes`, and `category`, subject to the applicable schema and validation rules.

The precise rules in the current source code take precedence over this overview.

### Source evidence and provenance

Analysis should preserve the distinction between:

1. A statement found in the supplied source.
2. A normalized or summarized representation of that statement.
3. An interpretation or proposed recommendation.
4. An assumption that requires confirmation.
5. Information that is missing and must be requested.

A structurally valid result may still contain an incorrect interpretation. Human review and semantic evaluation are necessary to determine whether the result accurately reflects the original requirements.

---

## 11. Modular Prompt System

Prompt resources are organized under:

`resources/prompts/requirement-analysis/v1/`

The registry separates prompt instructions by analytical responsibility so that each module can be maintained and reviewed independently.

| Prompt module | Purpose |
|---|---|
| `extraction.md` | Extract requirement information from supplied material |
| `classification.md` | Organize findings into supported categories |
| `business_context.md` | Capture business goals and context |
| `missing_information.md` | Identify gaps requiring clarification |
| `ambiguity_conflicts.md` | Surface unclear or potentially contradictory statements |
| `architecture.md` | Organize technical architecture considerations |
| `security.md` | Identify security and privacy considerations |
| `modules.md` | Organize proposed application modules |
| `screens.md` | Organize proposed screens and user-facing areas |
| `tasks.md` | Organize proposed implementation tasks |
| `phases.md` | Organize proposed delivery phases |
| `proposal.md` | Structure provisional proposal information |
| `README.md` | Explain the prompt-resource directory |

### Why modular prompts are used

- Individual analytical instructions can be maintained separately.
- Changes are easier to review and attribute to a particular responsibility.
- The prompt registry provides a centralized loading and assembly mechanism.
- Unit tests can check prompt discovery and assembly behavior.
- Prompt versions can be documented as part of evaluation and change management.

### Prompt versioning

The current directory is versioned as `v1`. Changes to prompts can affect output structure, interpretation, and consistency. Prompt changes should therefore be tested and recorded rather than treated as documentation-only edits.

Modularity does not by itself establish analytical accuracy. Each module still requires testing against realistic, representative requirements.

---

## 12. AI Provider Configuration

The application contains a configurable provider abstraction and provider-related configuration. This separates the structure of an analysis request from the implementation that supplies an analysis result.

### Current execution mode

The current analysis pipeline uses the **deterministic demonstration provider**.

This mode supports development and workflow testing without claiming that a live external AI model is connected.

### Configurable provider

`app/ConfigurableAiAnalysisProvider.php` contains the configurable analysis request construction and output-contract instructions. Its configuration is associated with `config/ai_analysis.php`.

The provider implementation and its unit tests establish code-level behavior, not successful communication with a real external model.

### Live integration requirements

Before live AI use can be claimed, the project requires:

1. Explicit authorization from the organization.
2. Approval of the provider and the data that may be sent to it.
3. Configuration through an approved environment or secret-management mechanism.
4. Confirmation of endpoint, authentication, request format, and response format.
5. Timeout and error-handling verification.
6. Validation of returned data against the application's contract.
7. Testing of invalid responses, provider failures, and unavailable services.
8. Privacy and security review.
9. End-to-end integration tests using an authorized environment.
10. Documentation of the tested provider, configuration, and results.

Do not insert personal API keys, company secrets, customer information, or proprietary company data into an unapproved integration.

For configuration-specific instructions, see [`docs/ai-provider-setup.md`](docs/ai-provider-setup.md).

---

## 13. Document Intake and Text Extraction

The document extraction component is implemented for supported readable PDF and DOCX documents.

### Supported extraction

- PDF text extraction, subject to the PDF parser's capabilities and the document's contents.
- DOCX text extraction, subject to the document structure and supported content.
- Extracted text can be used by the surrounding source and analysis workflow.

### Important limitations

- Scanned or image-only PDFs require OCR, which is not implemented.
- Text extraction does not guarantee that tables, columns, page layouts, or complex formatting will be represented perfectly.
- Extracted text may require human inspection before analysis.
- TXT upload, audio/voice ingestion, screenshot interpretation, OCR, and website fetching are not established as supported intake features.
- The extraction component passing a unit test does not prove that every upload, persistence, authorization, and analysis transition works end to end.

### Document and source handling

Source request validation and the source controller participate in the intake path. File handling should be checked against the current application configuration and request-validation rules, including accepted file types and size limits.

Use only documents you are authorized to process. Do not assume that text extraction grants permission to share the content with an external provider.

---

## 14. Revision, Review and Approval

Requirement analysis is iterative. Clarifications or scope changes can make an earlier analysis stale.

The application includes revision-related workflow behavior and tests covering parts of the revision process.

### Review principles

- Keep earlier source and revision information available where the workflow supports it.
- Review the exact revision being considered.
- Treat a changed input as a reason to reconsider affected analysis and approvals.
- Do not silently present an older result as though it reflects newer source information.
- Record relevant reviewer decisions and changes through the implemented workflow.
- Ensure the review interface and backend enforce the same rules.

### Approval limitations

Automated tests can demonstrate that particular revision and approval rules behave as expected in tested scenarios. They do not prove that every role, authorization boundary, or user-interface path has been tested.

The actual implemented approval flow should be checked against:

- The relevant routes and controllers.
- Authorization and policy rules.
- The workspace view.
- The revision workflow feature tests.
- The acceptance matrix.

Approval of an analysis revision is also distinct from approval of a commercial proposal or a production deployment.

---

## 15. Implementation Planning and Proposal Drafting

The analysis workflow supports organizing proposed implementation information into modules, screens, tasks, and delivery phases. It also supports preparing draft project proposals.

These outputs are planning aids and must be reviewed for completeness, feasibility, and consistency with the agreed scope.

### Proposal draft contents

A proposal draft can contain:

- A snapshot of the proposed project scope.
- A suggested technical approach.
- Provisional effort information.
- Optional human-entered price and currency.
- Maintenance terms.
- Third-party costs and the party responsible for paying them.
- Client responsibilities.

### Commercial safeguards

- Missing price information should be displayed as **Not entered**, rather than being invented.
- Supported proposal currencies are `INR`, `USD`, `EUR`, and `GBP`.
- Commercial terms must be supplied and reviewed by an authorized human.
- The application does not automatically negotiate or approve commercial terms.
- There is no approved automated effort-estimation model.
- There is no approved pricing-rule engine.
- Any generated effort figures remain provisional until independently reviewed.
- Third-party costs, assumptions, exclusions, payment arrangements, and client responsibilities require explicit confirmation.

A draft is not a binding quotation, signed contract, or confirmation that the client has accepted the proposed scope.

---

## 16. Data Persistence and Validation

The project uses Laravel's database and model infrastructure with MySQL in the current local environment.

The database stores the records required by the implemented project workflow. The exact schema is defined by the current models and migrations.

### Validation layers

The application uses multiple validation boundaries where applicable:

1. **HTTP request validation** to reject malformed or disallowed user input.
2. **Source-intake validation** to check submitted source information and supported files.
3. **Analysis contract validation** to restrict output fields and allowed category values.
4. **Workflow checks** to protect revision and review transitions.
5. **Database constraints** as defined by the actual migrations and schema.

Validation at one layer does not remove the need for validation at the others.

### Database setup

Use the configured database name and connection values in your local `.env`. For this development environment, the database name is `codly_requirement_analyzer`.

Do not commit real database passwords or other environment-specific secrets.

---

## 17. Security and Privacy

Security is part of the application lifecycle, not a feature that can be established solely by passing unit tests.

### Development safeguards

- Keep real credentials in local environment configuration or an approved secret store.
- Use placeholders in `.env.example`.
- Do not commit `.env`.
- Do not include credentials, personal data, or proprietary company information in logs or reports unnecessarily.
- Restrict source and project access to authorized users.
- Validate submitted input and extracted content.
- Escape user-controlled content when rendering it.
- Apply authorization checks to project, source, revision, and approval operations.
- Treat extracted document text and analysis-provider output as untrusted input.
- Review file-size and content limits before processing uploaded documents.
- Avoid sending private requirements to external providers without explicit organizational approval.

### Security verification still required

A secret-pattern scan is a useful preliminary check, not proof that a repository contains no secrets. Likewise, application-level tests are not a substitute for a security review.

Before public release or deployment, review:

- Authentication and authorization boundaries.
- Cross-project data access.
- File validation and storage behavior.
- Output rendering and injection risks.
- Error messages and logs.
- Dependency vulnerabilities.
- Environment configuration.
- Repository history and tracked files for exposed secrets.
- Provider data handling and retention, if live AI integration is introduced.

---

## 18. Installation and Local Setup

These instructions describe the standard local Laravel setup. Existing project configuration should be preserved where possible; do not overwrite a working environment without a reason.

### Prerequisites

Install or verify:

- PHP compatible with the project's Composer requirements.
- Composer.
- MySQL compatible with the project's database configuration.
- Git.
- Required PHP extensions specified by Composer and Laravel.
- Node.js and npm only if the frontend asset scripts in `package.json` require them.

The recorded local environment uses PHP 8.5.0 and MySQL 8.0.46.

### Step 1: Open the project

```powershell
Set-Location "E:\Codly-AI-Requirement-Analyzer"
```

### Step 2: Verify installed tools

```powershell
php -v
composer --version
php artisan --version
git status --short --branch
```

If dependencies have already been installed, avoid reinstalling them unnecessarily.

### Step 3: Install PHP dependencies if needed

```powershell
composer install
```

Use `composer install` to install the dependency versions recorded in `composer.lock`. Do not run `composer update` merely as a setup step; that can change dependency versions.

### Step 4: Configure the environment if needed

If `.env` does not exist and `.env.example` is available:

```powershell
Copy-Item .env.example .env
```

If `.env` already exists, preserve it and edit only the values that genuinely need to change.

Generate the Laravel application key only when the environment requires one and doing so will not disrupt an existing environment:

```powershell
php artisan key:generate
```

### Step 5: Configure the database

Create the local database if it does not already exist:

```sql
CREATE DATABASE codly_requirement_analyzer;
```

Configure the applicable database connection values in `.env`. Verify that the MySQL service is running and that the configured user has the required privileges.

### Step 6: Apply migrations when appropriate

```powershell
php artisan migrate
```

Review the existing schema and environment before applying migrations to a database containing data. Do not use destructive reset commands against an existing database unless data loss is explicitly intended.

### Step 7: Build frontend assets if required

Inspect `package.json` and its scripts first. If the project uses npm-managed assets, follow the scripts defined there, for example:

```powershell
npm install
npm run build
```

Do not run these commands if the project has no corresponding frontend setup.

---

## 19. Running the Application

From the project root:

```powershell
php artisan serve
```

Use the local URL printed by Laravel in the terminal.

If the application fails to start, inspect the actual error before changing configuration. Avoid clearing caches or regenerating keys as a generic troubleshooting step.

### Useful local commands

```powershell
# Application version
php artisan --version

# Route inspection
php artisan route:list

# Migration status
php artisan migrate:status

# Focused prompt registry test
php artisan test --filter=AnalysisPromptRegistryTest

# Analysis contract tests
php artisan test --filter=AnalysisContractTest

# Provider contract tests
php artisan test --filter=ConfigurableAiAnalysisProviderTest

# Document extraction tests
php artisan test --filter=DocumentExtractorTest

# Revision workflow tests
php artisan test --filter=RevisionWorkflowTest

# Whitespace and patch checks
git diff --check

# Current change summary
git status --short --untracked-files=all
git diff --stat
```

The exact test names and available filters should be confirmed from the current test files.

---

## 20. Testing and Verification

The test suite contains unit and feature tests for selected application contracts and workflow behavior.

### Focused tests verified during implementation

| Test area | Recorded result |
|---|---|
| `AnalysisPromptRegistryTest` | 1 test passed, 14 assertions |
| `AnalysisContractTest` | 9 tests passed, 9 assertions |
| `ConfigurableAiAnalysisProviderTest` | 5 tests passed, 11 assertions |

The recorded full-suite result before later documentation and implementation edits was 57 tests passed and 325 assertions, with one DOCX extraction deprecation notice.

**These are historical results, not a claim that the latest checkout has just passed the complete test suite.** Later changes should be assessed against the current working tree and their relevant tests. A previous full-suite run also encountered a Windows virtual-memory allocation failure, so a failed run must be distinguished from a code assertion failure.

### What these tests establish

The focused results provide evidence about the tested prompt-registry, analysis-contract, and provider behaviors. They do not independently establish:

- Semantic accuracy across real business requirements.
- Live provider connectivity.
- Production security.
- Full upload-to-analysis behavior for every file.
- Correctness of every proposal or estimate.
- Successful deployment in a production environment.

### Recommended verification order

1. Run focused tests for the component being changed.
2. Inspect the resulting test output for failures and warnings.
3. Run related feature tests where the change affects workflow behavior.
4. Run the full suite when resources permit.
5. Record the exact command, result, environment, and any unresolved failure.
6. Update the acceptance matrix only when supported by implementation and test evidence.

---

## 21. Evaluation Strategy

The project has an evaluation plan, but a plan is not evidence that model quality has already been measured.

See [`docs/ai-evaluation-plan.md`](docs/ai-evaluation-plan.md) and [`docs/human-evaluation-sheet.md`](docs/human-evaluation-sheet.md).

### Planned scenario coverage

The evaluation scenarios cover inputs that are:

- Complete.
- Short or underspecified.
- Large.
- Incomplete.
- Contradictory.
- Poorly written.
- Technical or business-oriented.
- Multi-role.
- Payment-related.
- Sensitive-data-related.
- Based on unrealistic expectations.
- Subject to scope creep.

### Software-level evaluation dimensions

**Structural completeness**

Check that the configured modules and required fields exist and validate for supported scenarios.

**Evidence and hallucination safeguards**

Check that original source information is preserved and that invented quotations, fabricated references, and unsupported confirmations are rejected by the applicable safeguards.

**Consistency**

Check revision retention, exact-revision approval behavior, and invalidation of affected approvals after edits.

**Relevance**

Check whether payment, privacy, feasibility, and scope-change scenarios produce appropriate review cues.

**Workflow usefulness**

Check persistence, authorized review, audit history, safe rendering, bounded failure behavior, and proposal-drafting safeguards.

### Human evaluation still required

A meaningful quality evaluation should record, at minimum:

- The input scenario and source material.
- The provider and prompt version used.
- The expected findings or review rubric.
- The generated output.
- Missing, incorrect, unsupported, or contradictory findings.
- Severity and reviewer comments.
- The result and any corrective action.

Until a representative dataset has been evaluated and results documented, no measured AI-quality score or demonstrated business-impact claim should be inferred from the existence of the evaluation plan.

---

## 22. Known Limitations

The following limitations should be considered when reviewing or using the application.

1. **Live AI integration:** Not verified; the current analysis path is deterministic demonstration analysis.
2. **Semantic accuracy:** Passing schema validation does not prove that a requirement has been interpreted correctly.
3. **Document formats:** Readable PDF and DOCX text extraction is implemented; OCR and image-only document interpretation are not.
4. **End-to-end upload behavior:** Complete upload-to-analysis verification remains outstanding.
5. **Human evaluation:** A completed representative evaluation dataset and measured results have not been established.
6. **Effort estimation:** No approved automatic estimation model exists.
7. **Commercial pricing:** No approved pricing-rule engine exists.
8. **Proposal approval:** Generated proposal content remains a draft until reviewed by an authorized person.
9. **External integrations:** Do not assume external services are connected or authorized because a configuration abstraction exists.
10. **Production readiness:** Production deployment, monitoring, operational resilience, and business impact have not been established by the available test results.
11. **Supported input channels:** OCR, voice, screenshot interpretation, TXT upload, and website fetching are not established as implemented capabilities.
12. **Documentation and acceptance:** Final review of the report, acceptance evidence, and reproducible setup instructions remains necessary.

These are explicit project boundaries, not claims that the application is unusable for local development or component testing.

---

## 23. Acceptance Criteria and Outstanding Work

Use [`docs/acceptance-matrix.md`](docs/acceptance-matrix.md) as the detailed checklist for requirement-by-requirement status.

Key outstanding areas include:

- Verify complete source upload and analysis behavior end to end.
- Verify PDF extraction using representative supported documents.
- Confirm that unsupported or malformed documents fail safely.
- Complete an authorized live AI integration only if approved.
- Build and complete a representative human evaluation dataset.
- Record measured evaluation results rather than planned metrics alone.
- Review the final internship report for accuracy and completeness.
- Perform a clean-environment setup walkthrough.
- Review all tracked, untracked, and ignored files before any publication.
- Confirm that `.env.example` contains placeholders rather than real secrets.
- Verify repository visibility and publication readiness separately.
- Obtain explicit approval before publishing or pushing project changes.

Do not mark an item as verified merely because a related class or test exists. Record the actual evidence and any limitations.

---

## 24. Troubleshooting

### Composer dependency installation fails

- Check the PHP version and required extensions.
- Confirm Composer is using the intended PHP executable.
- Read the first meaningful dependency error.
- Preserve `composer.lock` and avoid unnecessary dependency upgrades.

### Database connection fails

- Confirm that the MySQL service is running.
- Check the database name, host, port, username, and password in the local `.env`.
- Verify that the database exists and the configured account has the necessary permissions.
- Do not expose credentials when sharing error logs.

### Prompt registry test fails

- Check that the prompt resources exist under `resources/prompts/requirement-analysis/v1/`.
- Inspect the registry path and configuration.
- Verify that the Markdown files are saved with the intended encoding.
- Run the focused registry test before changing unrelated application files.

### Analysis contract validation fails

- Inspect the exact validation error.
- Confirm that category values use the permitted vocabulary.
- Check that the output uses the expected structure and allowed fields.
- Do not bypass validation just to make a test pass.

### Document extraction fails

- Confirm the file is a supported PDF or DOCX document.
- Check whether the PDF contains selectable text rather than only scanned images.
- Inspect the original document and extracted text.
- Treat layout loss and extraction errors as possible even when the file opens correctly.

### Tests fail because Windows runs out of virtual memory

- Read the actual failure output to distinguish resource exhaustion from an assertion failure.
- Run a focused test to isolate the affected component.
- Close unnecessary memory-intensive applications if appropriate.
- Do not report a test as passed when the process terminated before completing it.

### PowerShell text replacement fails

- Exact-match replacement scripts can fail when punctuation, whitespace, encoding, or line endings differ.
- Inspect the actual file contents before making another targeted replacement.
- For a complete documentation rewrite, replace the intended file as a whole and verify the saved content.

---

## 25. Documentation and References

| Document | Purpose |
|---|---|
| [`docs/acceptance-matrix.md`](docs/acceptance-matrix.md) | Acceptance requirements, status, evidence, and outstanding verification |
| [`docs/ai-evaluation-plan.md`](docs/ai-evaluation-plan.md) | Evaluation design, scenarios, quality dimensions, and exit criteria |
| [`docs/ai-provider-setup.md`](docs/ai-provider-setup.md) | Provider configuration guidance and integration boundaries |
| [`docs/human-evaluation-sheet.md`](docs/human-evaluation-sheet.md) | Structure for recording human evaluation findings |
| [`docs/final-internship-report.md`](docs/final-internship-report.md) | Detailed project report, implementation summary, limitations, and conclusions |
| [`resources/prompts/requirement-analysis/v1/README.md`](resources/prompts/requirement-analysis/v1/README.md) | Modular prompt-resource documentation |

Use source code, migrations, tests, and the acceptance matrix together when investigating whether a capability is implemented and verified. The README is a project overview, not a substitute for the executable implementation.

---

## 26. Responsible Use and Project Status

This project is a development-stage business requirements analysis and planning application. It demonstrates a structured workflow and selected software components, but not a fully validated autonomous business-analysis system.

The most important distinctions are:

- **Implemented** means relevant code exists.
- **Tested** means a specified automated test exercised the behavior.
- **Verified end to end** means the complete relevant workflow was exercised and evidence recorded.
- **Evaluated** means output quality was assessed against a defined rubric or dataset.
- **Production-ready** requires a broader review of security, reliability, operations, integration, and business acceptance.

These terms must not be treated as interchangeable.

The project's next steps are to finish end-to-end verification, complete evaluation with documented evidence, confirm any authorized provider integration, finalize the documentation, and review publication readiness.

No commit, push, external AI connection, or public release should be assumed to have occurred merely because the local README has been updated.

---

**Project:** Codly AI-Powered Business Requirement & Project Analysis System
**Framework:** Laravel 13
**Current analysis mode:** Deterministic demonstration provider
**Documentation status:** Comprehensive overview; update implementation claims as new verification evidence becomes available

## AI Usage Disclosure

Development assistance from AI tools and runtime AI limitations are documented in [AI Usage Disclosure](AI_USAGE.md).
