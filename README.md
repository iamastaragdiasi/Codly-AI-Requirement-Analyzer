# Codly India Private Limited — Requirement Analysis MVP

An authenticated, persisted Laravel workflow: project creation → text/structured intake → local demo analysis → clarification/conflict review → revision approval → modules/tasks/screens/phases → proposal draft. **This is a deterministic workflow demo, not live AI or production acceptance.**

## Inspection and technology

Verified versions: Laravel 13.35.0, PHP CLI 8.4.25, PHPUnit 12.5.38, Pint 1.32.1. The requested PHP 8.5 runtime was not the installed CLI. Composer/JS dependencies were retained. Existing controllers, analysis classes, most models/factories, policies and workspace tests were scaffolds. The welcome route was the only application route.

The already-applied migration 2026_10_12_110634_create_requirement_workspace_tables creates only an ID/timestamps placeholder. It remains unchanged and preserved. New migration 2026_10_12_122256_add_workspace_schema adds projects, sources, analyses, artifacts, approvals, audit_events and a default-false user reviewer flag. No fresh/wipe/reset was used. Rollback refuses populated workspace tables. Use forward fixes for operational installations. An empty-workspace rollback also removes reviewer permissions; operators must record and restore permissions before deliberately performing it.

The directory did not contain a Git repository during implementation. Git diff/status and Pint dirty mode were consequently unavailable.

## Local operation

Keep the existing environment. Use placeholders in .env.example and never copy secrets into reports or Git. No AI key/provider configuration is used.

1. Apply pending additive migrations: php artisan migrate --no-interaction.
2. Provision accounts in an interactive local terminal: php artisan app:create-administrator owner@example.com "Project Owner" and php artisan app:create-administrator reviewer@example.com "Codly Reviewer" --reviewer. Each prompts for a hidden password of at least 12 characters. Non-interactive provisioning is refused. No default account or password is created.
3. Run npm run build and use the existing Laravel development server.
4. Sign in as owner, create a project, assign the reviewer, submit requirements and generate analysis.
5. Sign in as assigned reviewer, edit findings, record evidence for explicit client confirmation, approve a revision and draft the proposal.
6. Check php artisan app:diagnose-database --no-interaction and php artisan migrate:status --no-interaction.

There is no public registration or repository publication.

## Supported intake and limitations

Only text and structured forms work. Originals retain surrounding whitespace; whitespace-only submissions fail. Limits: 50,000 characters per submission, 100 ordinary intake sources per project, 200,000 aggregate ordinary intake characters. Client confirmation evidence is separately limited to 2,000 characters. Repeated review confirmations consume additional storage; operators should limit project growth.

Structured input records role, feature, priority and source reference. Clarification answers require a question/reference identifier. Source identity, submitting user, timestamps, original text and metadata remain available. Sources begin unconfirmed. Project context is user-entered, not automatically client-confirmed.

All file uploads are rejected. PDF/DOCX extraction, TXT uploads, OCR, voice, screenshots and website fetching are **not implemented**. Paste authorized text instead. Do not submit credentials, full card data or unnecessary personal information.

## Provenance, scope and revisions

Findings use exactly one provenance: **Client Confirmed**, **AI Inferred**, **AI Suggested**, **Missing**. Source references must belong to this project. Original statements must exactly match referenced evidence. Client Confirmed requires explicit confirmation evidence recorded by the assigned reviewer. This records a human attestation; it cannot independently verify client authority.

Human approval never changes provenance. Editing confirmed content removes its confirmed label unless fresh explicit confirmation is supplied. Included, excluded, assumption, optional and unresolved scope remain distinct. Must, Should, Could and Future persist. Suggestions begin optional, rather than approved scope.

Content changes advance a project-wide revision. Approval stores reviewer, timestamp, decision, notes and exact revision. Only the latest decision for the current revision counts. Stale forms receive 409. Failed/stale analysis cannot be approved. Transactions lock the project row. Context edits retain before/after artifacts; analysis/review histories are append-only. Adding a source or changing context requires regeneration. Finding reviews copy the existing results into the new revision. Generating analysis conservatively creates a new revision even for identical inputs.

Proposal drafting requires current scope approval and stores the source revision, immutable analysis ID and scope snapshot. Draft creation advances the revision and requires renewed approval. Drafts are never automatically final or client-accepted. There is no publication/final acceptance endpoint.

## Modular analysis contract

AnalysisProvider is the service boundary and is bound only to DeterministicAnalysisProvider. AnalysisPipeline invokes independently callable modules and AnalysisValidator checks each output. No external network call, model training, embeddings or vector database is used.

All modules receive project business problem, objectives, target users and sources with original text/metadata. All return an object with prompt_version "demo-v1" and an items array. Each item contains title, provenance, source_ids, statements, priority, scope, role, objective, feature, dependencies and notes.

Validation checks enums, lengths, references, quotation fidelity and explicit confirmation evidence. Unknown item keys fail. Up to 300 items per module are allowed. Display titles are capped at 1,000 characters; original sources remain intact.

| Module | Purpose / specific inputs | Output | Constraints / failures |
| --- | --- | --- | --- |
| business_context | Problem, objectives, stakeholders/roles | Context summaries for review | User context is not verified client evidence |
| extraction | Original sources | Evidence-preserving candidate findings | Full originals retained; no file interpretation |
| classification | Text, role, feature, priority | Candidate functional/non-functional type and scope | Keyword heuristics miss implicit/mixed requirements |
| missing_information | Context and sources | Questions about authority, acceptance, budget, integrations, privacy and targets | Never supplies missing answers; generic questions may already be answered |
| ambiguity_conflicts | Original statements | Potential conflicts and questions with references | Negation/shared-word cues can miss conflicts or yield false positives |
| modules | Feature, role, objective, priority | Candidate modules | Does not prove complete decomposition |
| tasks | Feature context and requirement | Acceptance/design/implementation/testing tasks | Generic tasks; dependency strings require developer sequencing |
| screens | Source role or target users | Role-labelled proposed screens | Roles split on commas/semicolons/newlines and grouped in UI; no screen designs |
| phases | Priorities | Proposed delivery phases and Future backlog | No dates or delivery commitments |
| security | Payment/sensitive-data wording | Optional review recommendations | No compliance certification or security completeness guarantee |
| architecture | Context | Suggested Laravel/relational design | Developer validation required; no production schema for the client's future product |
| proposal | Context/findings | Drafting guidance | Does not invent price, effort or agreed commercial terms |

All modules use version **demo-v1**. Schema-invalid output gets at most two attempts; attempt number is passed to the adapter. After two invalid responses the module records explicit failure. Runtime failures stop that module immediately. Other modules may finish, but overall status is failed and approval is blocked. Raw outputs, requirement text and exception messages are not logged by the pipeline.

The deterministic adapter replays templates, so retry cannot repair systemic template defects. An authorized future live adapter needs provider/model/cost/retention/data-transfer consent, bounded timeouts, correction prompts and separate live acceptance evaluation. Personal keys must not silently enable data transfers.

## Prompt/template change record

| Version | Change and rationale | Observed effects | Failure cases / further validation |
| --- | --- | --- | --- |
| demo-v1 initial MVP | Conservative local templates, source references, separate scope/provenance, Future retention | Scenario checks verify unchanged sources, modules and priorities | Generic decomposition; no semantic understanding |
| demo-v1 evidence hardening | Exact quotations and explicit confirmation evidence; edited confirmations lose confirmed label | Contract tests reject invented references, quotes and unsupported confirmation | Human evidence can be inaccurate |
| demo-v1 reliability hardening | Bound retries/output/title lengths; normalize browser revision strings | Tests reject malformed output and stale approval; browser-style revisions work | Load and concurrent MySQL requests need further testing |
| demo-v1 targeted heuristics | Payment, privacy, feasibility and potential scope-change cues | Targeted synthetic-input checks verify relevant labels | Review cues only, not an automated semantic change-request detector |

These are deterministic template changes, **not evaluated LLM experiments**. Before adding an LLM prompt, record a new version, exact contract, provider/model/consent, held-out fixture results, regressions and failures.

## Planning and commercial review

Modules/tasks retain objective, role, feature, priority, dependencies and notes; reviewers can edit these. Screens are labelled by role. Architecture/database design is explicitly suggested and requires developer validation.

No numeric effort is generated. Reviewers may enter preliminary hours and rationale. Estimates always show **Provisional — requires authorized technical/PM review**. There is no automatic estimation model or approved pricing-rule engine.

Proposal drafts contain scope snapshot, suggested technical approach, provisional effort, optional human-entered price/currency, maintenance terms, third-party costs/payer and client responsibilities. Missing price shows Not entered. Required commercial terms must be supplied by the reviewer and are not automatically negotiated or approved. Supported currencies: INR, USD, EUR, GBP.

## Evaluation and test procedure

Synthetic scenarios cover complete, short, large, incomplete, contradictory, poorly written, technical, business-oriented, multi-role, payment, sensitive-data, unrealistic-expectation and scope-creep inputs.

Measured software contracts:
- Structural completeness: all configured modules exist and validate for supported scenarios.
- Evidence/hallucination safeguards: originals preserved; invented quotations/references and unsupported confirmation rejected.
- Consistency: Future retained; exact-revision approval and edit invalidation.
- Relevance: targeted payment/privacy/feasibility/scope-change review cues.
- Workflow usefulness: persistence, authorized review, audit history, escaped rendering, bounded failure and draft gating.

These are binary software checks, **not semantic accuracy percentages or measured business impact**. Practical usefulness, decomposition quality, false-conflict rate, estimate accuracy and client satisfaction require an authorized human evaluation. Use consented held-out requirements, two reviewers, agreed rubric and disagreement adjudication before publishing quality claims.

Default CLI PHP lacks SQLite. Load installed bundled extensions in the same PHPUnit process:

~~~powershell
php -d extension=pdo_sqlite -d extension=sqlite3 vendor/phpunit/phpunit/phpunit
~~~

Tests use SQLite :memory: and do not operate on existing MySQL data. Artisan test starts a child PHP process which does not inherit these extension flags. Initial Artisan tests failed at driver setup; direct PHPUnit resolved this without changing machine configuration.

Final executed verification on 2026-10-12: **43 tests passed, 277 assertions** using direct PHPUnit and SQLite memory. The additive migration, migration status, workspace schema diagnostic, route listing, Blade compilation and npm production build succeeded. Before/after counts for users and the original placeholder table remained unchanged. The existing font plugin emitted a non-fatal optional-fontaine warning; no dependency was added.

Run php vendor/bin/pint --dirty --format agent when Git exists. Without Git, format changed application/test paths using php vendor/bin/pint --format agent followed by the paths. Also run npm run build, Blade view cache, route list, migration status and schema diagnostics.

## Codly human-review checklist

- [ ] Confirm project access, assigned reviewer authority and exact current revision.
- [ ] Match client-confirmed findings to evidence; distinguish inferred/suggested/missing.
- [ ] Validate business problem, objectives, stakeholders, roles and acceptance criteria.
- [ ] Resolve missing information and conflicting originals with referenced client answers.
- [ ] Confirm included/excluded scope, assumptions, optional items and Future backlog.
- [ ] Review modules/tasks/screens by role, priorities, dependencies and phases.
- [ ] Obtain developer validation of architecture, database suggestions and feasibility.
- [ ] Review authorization, payments/refunds, sensitive data, retention and transfer authority.
- [ ] Obtain authorized technical/PM review of preliminary effort/rationale.
- [ ] Obtain commercial review of price, maintenance, third-party payer and client duties.
- [ ] Record identity, notes, decision and revision; renew approval after content changes.
- [ ] Keep limitations visible; arrange separate client acceptance outside this MVP.

## Costs, maintenance, security and alternatives

Laravel, Eloquent, Blade, existing Vite/Tailwind pipeline and PHPUnit were reused. New styling uses ordinary CSS in the established stylesheet. No dependency changes were made. MySQL stores application data; SQLite isolates tests.

No paid AI service was invoked. The demo adapter has no API/token charge. Infrastructure, staff, hosting, payment processors and eventual provider costs are unknown and require human quotation. Existing Vite font assets are built by the already-installed plugin.

Maintenance includes dependency/security updates, backups/restoration checks, account reviews, retention policies, template versions and scenario regressions. Alternatives are an authorized hosted LLM (usage and transfer costs), local model (hardware/operations burden), or manual Codly analysis (staff effort). None is selected or priced without authorization.

Use separate migration and runtime database accounts. The runtime account should have only necessary application CRUD privileges, without DDL/drop/grant permissions. Existing database grants have not been certified. Before production, use HTTPS, secure cookies, debug disabled, backups and reviewed operational controls. At-rest field encryption, MFA and external identity are not implemented.

Workspace QueryException handling emits a generic event and SQLSTATE and returns a generic error, avoiding SQL parameter logging/rendering. .env variants and credentials remain ignored.

## Optional future capabilities — not implemented

OCR, voice transcription, screenshots, PDF/DOCX extraction, website URL analysis with SSRF protection, semantic change-request detection, authorized live AI, pricing rules, client signature/acceptance, calibrated estimation, generated schema/screens, visual planning, exports, team memberships, notifications and granular approvals.

## Twelve-chapter final report outline

1. Introduction: Codly context, business problem, objectives and boundaries.
2. Requirements and stakeholder/user-role study with source traceability.
3. Existing-system inspection, gap analysis and feasibility.
4. Technology/provider alternatives, authorization and cost assumptions.
5. Architecture, data model, access control and revision design.
6. Intake, metadata, validation and supported formats.
7. Analysis modules, schemas, prompt versions and failure handling.
8. Human clarification, conflict review, provenance and scope governance.
9. Modules/tasks/screens/phases and provisional estimation.
10. Proposal drafting, human pricing and commercial review.
11. Evaluation methods, executed results, failure cases and limitations.
12. Maintenance, risks, conclusions and optional roadmap.

Populate results only from executed checks and consented evaluation. Do not invent accuracy, savings, ROI or client outcomes.
