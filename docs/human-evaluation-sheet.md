# Human Evaluation Sheet
**Project:** AI-Powered Business Requirement & Project Analysis System
**Purpose:** Record human evaluation of analysis quality using fictional or explicitly approved data only.

## Instructions

1. Assign each test case an ID and record the exact input or a secure reference to it.
2. Compare output with an independently prepared expected result.
3. Do not treat the system's own output as ground truth.
4. Record missing requirements, unsupported assumptions and unnecessary suggestions.
5. Do not place real client confidential data or credentials in this sheet.
6. Leave ratings blank until an evaluator has actually reviewed the case.

## Rating scale

| Score | Meaning |
|---|---|
| 1 | Unacceptable |
| 2 | Major problems |
| 3 | Partially acceptable; meaningful corrections needed |
| 4 | Good; minor corrections needed |
| 5 | Meets expectations for this test case |
| N/A | Not applicable; explain why |

## Case record

| Field | Entry |
|---|---|
| Evaluation ID | |
| Date | |
| Evaluator role (not sensitive identity details) | |
| Input scenario / dataset ID | |
| Input type | |
| Provider/version | |
| Project revision | |
| Expected result prepared before evaluation? | |
| Output reference | |
| Overall decision | |
| Notes / remediation ticket | |

## Quality ratings

| Dimension | Rating (1–5 or N/A) | Evidence / explanation |
|---|---:|---|
| Accuracy — findings match the input | | |
| Completeness — important requirements are covered | | |
| Relevance — findings are useful for the stated task | | |
| Hallucination — unsupported claims are absent | | |
| Consistency — output does not contradict itself or evidence | | |
| Structure — output follows the required contract | | |
| Practicality — questions and suggestions help a reviewer | | |
| Provenance — source references and labels are appropriate | | |
| Usability — a human can understand and review the output | | |

## Error analysis

| Question | Observations |
|---|---|
| Which expected requirements were missing? | |
| Which findings were incorrect? | |
| Which statements lacked supporting evidence? | |
| Which assumptions were incorrectly presented as facts? | |
| Which suggestions were unnecessary or irrelevant? | |
| Were contradictions preserved for review? | |
| Were unanswered questions clearly identified? | |
| Did any sensitive content appear in logs or output unexpectedly? | |
| What correction is required? | |
| Is the case suitable for regression testing? | |

## Scenario coverage checklist

- [ ] Clear and complete requirement
- [ ] Very short requirement
- [ ] Incomplete requirement with unanswered questions
- [ ] Contradictory statements from separate sources
- [ ] Ambiguous or poorly written input
- [ ] Business-oriented project
- [ ] Technical project
- [ ] Multiple user roles
- [ ] Online payment requirements
- [ ] Sensitive-data/privacy considerations using fictional examples
- [ ] Unrealistic expectations and provisional estimates
- [ ] Scope change after approval
- [ ] Malformed provider output or provider failure
- [ ] Edit after approval requiring reapproval

## Evaluation summary

**Cases evaluated:**
**Cases meeting the evaluator's acceptance criteria:**
**Major failure patterns:**
**Required remediation:**
**Retest completed:**
**Evaluator sign-off:**
**Supervisor review:**

Do not report averages, pass rates or evaluation conclusions until completed rating records exist. This template alone is not evidence of model quality.