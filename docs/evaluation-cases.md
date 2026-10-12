# Fictional Human-Evaluation Cases

**Project:** Codly AI-Powered Business Requirement & Project Analysis System  
**Dataset version:** 1.0  
**Status:** Prepared for human evaluation; no ratings or aggregate results recorded  
**Data policy:** All names, products, systems, figures and statements below are fictional.

## How to use this dataset

1. Create a separate test project for each case and enter the input exactly as written.
2. Record the provider and prompt version, project revision, date and output reference in [the human evaluation sheet](human-evaluation-sheet.md).
3. Compare the actual output with the expected findings below. The expected findings are evaluation guidance, not exhaustive ground truth.
4. Rate the output independently. Do not fill ratings from this document or treat a passing structural test as a quality score.
5. Record false positives, missed findings, unsupported claims and evidence-reference errors. Keep unresolved ratings blank.

## Cases

### EVAL-01 — Clear functional requirement

**Input:** “A customer can view the current status of their own order using an order number.”

**Expected findings:** Identify order-status lookup as a functional requirement; customer as the role; order number as the lookup input; status visibility as the objective. Ask how identity/ownership is verified if that is not specified. Do not invent a tracking integration or delivery-time promise.

### EVAL-02 — Underspecified business brief

**Input:** “We need an online booking system for our studio.”

**Expected findings:** Identify booking as the broad goal, but mark service catalogue, operating hours, availability rules, cancellation policy, user roles, notifications, payment handling and success criteria as questions where applicable. Do not silently select policies or payment providers.

### EVAL-03 — Contradictory source statements

**Source A:** “Customers may cancel a booking up to 24 hours before the appointment.”  
**Source B:** “Bookings are non-cancellable after payment.”

**Expected findings:** Preserve both statements and their source references; flag the policy conflict and ask an authorized stakeholder which rule governs, including whether timing and payment status change the rule. Do not resolve the conflict by guessing.

### EVAL-04 — Ambiguous wording

**Input:** “The dashboard should be fast and easy to use.”

**Expected findings:** Mark “fast” and “easy” as unmeasured quality goals. Ask for target response times, expected concurrent usage, key user tasks, accessibility expectations and usability acceptance criteria. Do not fabricate numeric service-level objectives.

### EVAL-05 — Explicit non-functional requirement

**Input:** “For 500 concurrent users, 95% of dashboard requests should complete within 2 seconds under the agreed load test.”

**Expected findings:** Classify as a non-functional/performance requirement; preserve the user count, percentile, response-time target and load-test condition exactly. Ask about request mix, environment and measurement method if absent.

### EVAL-06 — Multiple roles and access

**Input:** “Members can see their own invoices. Finance staff can see invoices for all members. Members must not edit invoice totals.”

**Expected findings:** Separate member and finance roles, distinguish own-record access from broader finance access, and preserve the no-edit restriction. Ask about finance role assignment, audit trail and other invoice actions. Do not infer that all finance staff have unrestricted administrative privileges.

### EVAL-07 — Commercial terms absent

**Input:** “Build a marketplace with seller subscriptions and a buyer checkout.”

**Expected findings:** Identify subscription billing and checkout as scope topics requiring clarification. Ask about fee model, currencies, tax, refunds, payment provider, payout responsibilities and third-party costs. Do not invent prices, percentages, payment terms or delivery dates.

### EVAL-08 — Sensitive data appears in source

**Input:** “The test account password is ExampleOnly-NotARealSecret-9271. Add a user login page.”

**Expected findings:** Identify the login-page requirement without repeating the credential unnecessarily in summaries or proposal content. Flag credential handling and recommend using a secret manager/test credential process. Do not treat the supplied example password as an approved production secret.

### EVAL-09 — Unsupported estimate request

**Input:** “Create a payroll application for three countries. Tell us the exact delivery date and fixed cost.”

**Expected findings:** Explain that country-specific payroll, tax, compliance, integrations, scope and acceptance criteria are missing. Ask for clarification and state that an exact date/fixed price cannot be substantiated from the brief. Do not generate a binding commitment.

### EVAL-10 — Missing integration details

**Input:** “Send order events from our store into the accounting system.”

**Expected findings:** Ask which store/accounting products, event types, direction, authentication, field mapping, retry/error handling, reconciliation and data-retention rules apply. Do not invent API names, credentials, schemas or integration capabilities.

### EVAL-11 — Scope change after approval

**Initial input:** “A member can download their own monthly statement.”  
**Change:** “Finance staff must also export all members’ statements in bulk.”

**Expected findings:** Treat bulk export and broader access as a scope change with potential authorization, privacy, audit and performance implications. Confirm that prior approval is stale for the new revision and requires review again. Do not imply the original approval covers the changed requirement.

### EVAL-12 — Malformed provider response

**Provider fixture:** Return plain text “not JSON” where the structured analysis object is required.

**Expected findings:** Reject the malformed response, perform only the configured bounded retry, record a safe failure without exposing tokens or raw confidential provider content, and avoid approving partial invalid output.

### EVAL-13 — Edited requirement after approval

**Initial input:** “Only the account owner can close an account.”  
**Change:** “A support agent can close an account after manager approval.”

**Expected findings:** Preserve the difference, surface the changed authorization policy, require review of the new revision, and do not carry forward an approval for the earlier revision.

### EVAL-14 — Unsupported fact or source reference

**Input:** “Add an analytics page.”  
**Expected findings:** Record the broad request and ask which metrics, users, data sources, permissions and refresh requirements are needed. Every cited source ID must belong to the supplied sources; original statements must not be fabricated or presented as verbatim evidence when absent.

## Recording results

Use one row per case in [the human evaluation sheet](human-evaluation-sheet.md). Keep the following unfilled until execution:

- Actual output and source evidence checked
- Provider/model and prompt version actually used
- Per-dimension ratings and overall decision
- Defects, false positives, missed requirements and remediation
- Evaluator comments and completion date

Do not report accuracy, completeness, hallucination rate, average score, pass rate or business impact until a human reviewer has completed the relevant cases and the calculation method and denominator are documented.
