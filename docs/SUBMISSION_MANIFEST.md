# Internship submission manifest — DRAFT

Prepared 13 October 2026 (Asia/Calcutta) for Astarag Diasi, Codly India Private Limited. Preparation is complete; actual portal submission and supervisor acceptance are pending.

Repository: https://github.com/iamastaragdiasi/Codly-AI-Requirement-Analyzer

Verified published application SHA: `9dbf973822b05388fe6066ac9a3fafe22ec81cd0`. Later finishing commits preserve this ancestor. Use `git rev-parse HEAD` and `git ls-remote origin refs/heads/main` to record the final documentation/fix SHA after publication; the final chat handoff supplies that verified SHA. A manifest cannot contain the SHA of its own committing tree. [Execution status](FINAL_EXECUTION_STATUS.md) records publication checkpoints and actual outcomes.

| Submission component | Repository location / purpose |
|---|---|
| Application and safe configuration | `app/`, `routes/`, `config/`, `.env.example`, lockfiles; no populated secrets |
| Database structure | `database/migrations/`, factories and seeders; no private database dump |
| Setup, architecture and user instructions | [README](../README.md), especially sections 7, 18–20 and troubleshooting |
| Demo flow | README section 6 and walkthrough below |
| Modular prompt templates | `resources/prompts/requirement-analysis/v1/`; ai-v1 registry, recorded rationale and limits |
| Fictional dataset | [EVAL-01–16](evaluation-cases.md), version 1.1; generated PDF/DOCX fixtures in existing document tests |
| Automated evidence and failure analysis | [Execution status](FINAL_EXECUTION_STATUS.md); historical and fresh runs kept separate |
| Acceptance and official-scope traceability | [Acceptance matrix](acceptance-matrix.md); automated/browser/human scopes distinguished |
| AI-use disclosure | [Disclosure](AI_USAGE_DISCLOSURE.md); human commit identity does not imply unaided authorship |
| Provider/API integration instructions | [Provider setup](ai-provider-setup.md); DEMO remains default, live access blocked |
| Evaluation method and blank rating register | [Plan](ai-evaluation-plan.md), [human sheet](human-evaluation-sheet.md); no invented scores |
| Final 12-chapter report | [Report](final-internship-report.md), DRAFT until supervisor approval |
| Preserved remote continuation record | [Project handoff](PROJECT_HANDOFF.md) |

## Reproduction and demonstration

Preserve the existing environment. On a separate approved checkout, install locked dependencies with `composer install` and `npm ci`. Copy `.env.example` only if `.env` is absent; generate an application key only for that new environment. Configure an approved local database, inspect `php artisan migrate:status`, and apply pending migrations only to that intended new database. Never use `migrate:fresh` or `db:wipe` on existing data. Keep `AI_ANALYSIS_DRIVER=demo` and provider/key fields empty. Build with `npm run build`. Follow README account setup and local-server instructions; no public deployment is claimed.

Run `php artisan test --compact` with phpunit.xml's isolated SQLite in-memory test configuration. The fresh PHP 8.5 release run reported 75 pass / 507 assertions and one PHPWord deprecation; Pint/build passed. GitHub CI on PHP 8.4 exposed DOCX MIME acceptance failures; use the latest execution disposition before presenting CI as green.

Demonstrate only fictional data: sign in as owner, create a separate project, add EVAL-01 text and conflicting source statements, analyze in DEMO, inspect classification/questions/conflicts/source labels, then upload readable PDF and DOCX table fixtures. Use authorized existing reviewer accounts to request changes/reject/review current scope. Explain stale revision invalidation and proposal refusal until current scope is approved. Any legitimate demo approval is a software demonstration, not company acceptance. Keep draft prices/effort blank and payment/support unresolved unless humans enter fictional terms; never send/finalize a commercial proposal.

## Honest submission limitations

No connected browser was available for this finishing pass: all manual UI cases remain NOT VERIFIED. No portal URL/session was supplied; no internship portal entry or upload occurred. No live deployment URL exists in this evidence. Codly must supply actual human quality review, company-process facts, report approval and authorized AI provider/model/credentials/data handling. DEMO cannot establish general semantic accuracy, business impact or production readiness. OCR, audio/image/URL intake and exact layout/source locations remain unsupported. Proposal pricing/timelines/final commitments remain human decisions.

Tracked files and eight historical commit snapshots had no high-confidence credential-pattern matches; secret-bearing paths, private source documents, uploads, logs and dependencies are excluded. This is a scoped publication review, not a guarantee of complete security. The official specification/compliance originals remain in Downloads and are not included in this public submission.

**History cleanup: DEFERRED.** All Codex conversation/session history remains intact pending actual completion/submission, Codly disposition and additional explicit user deletion confirmation.
