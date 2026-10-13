# Real-browser acceptance evidence

Executed 13 October 2026 (Asia/Calcutta) using installed Google Chrome 155.0.8059.40, headless, controlled by Playwright 1.64.0 installed only in a temporary directory. All data/accounts are fictional; the server used loopback, a fresh temporary SQLite database and temporary storage. Existing .env and database data were preserved. No project dependency was added.

**Final result: 26 PASS, 0 FAIL, 0 BLOCKED** within the scenarios below. No unexpected HTTP 5xx response or browser page error was observed. This is representative software workflow acceptance, not a Codly human rating, client approval, live AI test or production certification.

Baseline: published a22ecb1d3a8a9959a49f9a353d12c2be7352d3ba. Unaffected scenarios ran on this baseline; proposal/review/revision/refusal paths were retested after the narrow bootstrap/app.php refusal-message patch. Final automated regression: 79 pass / 566 assertions, one non-failing PHPWord warning; Pint passed.

| ID | Requested scenario | Actual result | Observation |
|---|---|---|---|
| 1 | Application loads | PASS | Installed Chrome 155.0.8059.40 loaded the real loopback Laravel login page. |
| 2 | Login and logout | PASS | Fictional owner authenticated, signed out and authenticated again in Chrome. |
| 3 | Project creation | PASS | Project created through the browser form; project ID 1. |
| 4 | Text requirement submission | PASS | Five fictional text sources persisted through UI submission. |
| 5 | Readable PDF upload/extraction | PASS | Readable PDF uploaded and extracted original text/format displayed. |
| 6 | DOCX table upload/extraction | PASS | DOCX paragraph and table-cell text persisted with unconfirmed document metadata. |
| 7 | Analysis execution | PASS | DEMO analysis completed through UI with all module sections present. |
| 8 | Functional/non-functional classification | PASS | Functional and Non-Functional candidate categories displayed. |
| 9 | Requirement priorities displayed | PASS | Must Have and Should Have labels preserve submitted priority. |
| 10 | Missing information identified | PASS | Missing-provenance findings displayed for underspecified inputs. |
| 11 | Clarification questions shown | PASS | Concrete payment/general clarification questions displayed; answers not invented. |
| 12 | Ambiguity flagged | PASS | Heuristic ambiguity/measurement clarification shown for vague requirement. |
| 13 | Contradictions flagged | PASS | Contradiction between registration/no-registration statements flagged without selecting a policy. |
| 14 | Source evidence/provenance retained | PASS | Original wording/source IDs and inferred provenance retained. |
| 15 | Modules generated | PASS | Source-linked suggested modules displayed. |
| 16 | Tasks/dependencies generated | PASS | Developer tasks and source-specific dependency gates displayed. |
| 17 | Phases/scope generated | PASS | Provisional discovery/implementation/acceptance sequence, dependency gates and unresolved scope displayed. Initial harness expected a literal Phase heading; corrected to actual product contract without changing application. |
| 18 | Proposal draft generated | PASS | Proposal artifact generated only after current scope fixture approval. |
| 19 | No invented/approved pricing | PASS | No price/numeric effort invented; draft remains nonbinding and requires renewed approval. |
| 20 | Unauthorized project refusal | PASS | Unassigned fictional user receives 404 on project browser navigation. |
| 21 | Owner/reviewer permissions | PASS | Owner cannot approve; assigned reviewer context-edit submission refused with policy-prescribed 404. |
| 22 | Authorized human review controls | PASS | Assigned reviewer records changes-requested and finding edit; unapproved proposal is refused. Fixture actions are not Codly evaluation. |
| 23 | Revision history recorded | PASS | Revision/decision/audit history displayed after source, analysis and review operations. |
| 24 | Edit invalidates approval | PASS | Owner context edit advances revision, invalidates approval, marks analysis stale; old approval request receives 409. |
| 25 | Invalid uploads/malformed inputs rejected | PASS | Malformed PDF, unsupported image upload and whitespace-only text refused; visible errors and unchanged revision. |
| 26 | No unexpected fatal errors | PASS | No unexpected HTTP 5xx response or browser page error recorded across three contexts. |

## Evidence and failure disposition

[Final machine-readable results](browser-results.json) contain each result, browser/runtime scope, screenshot names and error arrays. Browser authorization/stale-form checks include normal authenticated browser-originated POST requests with CSRF tokens, alongside visible UI interactions. No credentials, keys, cookies, .env, private database or server logs are included.

Earlier records are preserved: [first UI attempt](browser-first-ui-attempt.json), [permission harness attempt](browser-permission-harness-attempt.json), [confirmed refusal-message defect](browser-confirmed-refusal-defect.json). Literal Phase wording and 403-versus-policy-404 were harness expectation errors; they were corrected without application changes. A server lifecycle issue was corrected before the successful UI run. The actual application defect was generic 409/422 workflow error rendering with debug disabled; two regressions reproduced it, the renderer was corrected and the affected browser scenarios passed on retest.

Automated fictional approvals in these records exercise code paths only. The human evaluation sheet remains blank; company evaluation, company-process confirmation/report approval and authorized live AI access remain pending. The existing MySQL configuration returned SQLSTATE 1045 on read-only inspection; this SQLite run does not repair or certify it. Encrypted/scanned/complex documents, production locking, load, backup recovery, broader browsers/devices and semantic completeness are not established by this run.

## Safe screenshots

- [01-login.png](01-login.png)
- [02-project-created.png](02-project-created.png)
- [03-document-sources.png](03-document-sources.png)
- [04-classification.png](04-classification.png)
- [05-missing-questions.png](05-missing-questions.png)
- [06-conflict.png](06-conflict.png)
- [11-phases.png](11-phases.png)
- [07-outsider-404.png](07-outsider-404.png)
- [08-proposal-draft.png](08-proposal-draft.png)
- [09-revision-invalidated.png](09-revision-invalidated.png)
- [10-invalid-upload.png](10-invalid-upload.png)
- [12-docx-table-evidence.png](12-docx-table-evidence.png)
- [13-provisional-commercial-fields.png](13-provisional-commercial-fields.png)
- [14-actionable-refusal.png](14-actionable-refusal.png)
