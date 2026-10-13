<?php

namespace App;

class DeterministicAnalysisProvider implements AnalysisProvider
{
    /** @param array<string,mixed> $input
     *  @return array<string,mixed>
     */
    public function run(string $module, array $input, int $attempt): array
    {
        $items = [];
        $sources = $input['sources'] ?? [];
        $targetUsers = trim((string) ($input['target_users'] ?? 'Not specified'));
        $objectives = trim((string) ($input['objectives'] ?? 'To be determined'));

        foreach ($sources as $source) {
            $text = (string) $source['original'];
            $meta = $source['metadata'] ?? [];
            $priority = in_array(
                $meta['priority'] ?? '',
                ['Must', 'Should', 'Could', 'Future'],
                true
            ) ? $meta['priority'] : 'Should';

            $role = trim((string) ($meta['role'] ?? ''));
            $feature = trim((string) ($meta['feature'] ?? ''));

            $base = [
                'title' => mb_substr($text, 0, 1000),
                'provenance' => 'AI Inferred',
                'source_ids' => [(int) $source['id']],
                'statements' => [$text],
                'priority' => $priority,
                'scope' => 'unresolved',
                'role' => $role !== '' ? $role : 'Not specified',
                'objective' => $objectives !== '' ? $objectives : 'To be determined',
                'feature' => $feature !== '' ? $feature : 'Unspecified feature',
                'dependencies' => [],
                'notes' => 'Deterministic demo heuristic; validate against the original client evidence.',
            ];

            switch ($module) {
                case 'extraction':
                    $items[] = $base;
                    break;

                case 'classification':
                    $base['category'] = match (true) {
                        (bool) preg_match('/optional|nice to have|maybe/i', $text) => 'Optional',
                        (bool) preg_match('/performance|availability|latency|accessible|scalab|uptime|response time|security/i', $text) => 'Non-Functional',
                        (bool) preg_match('/\b(api|oauth|database|postgresql|mysql|webhook)\b/i', $text) => 'Technical',
                        (bool) preg_match('/revenue|sales target|reduce manual|business goal|reconciliation/i', $text) => 'Business',
                        default => 'Functional',
                    };
                    $base['title'] = 'Candidate '.$base['category'].' requirement';

                    $base['scope'] = preg_match(
                        '/out of scope|exclude|do not include/i',
                        $text
                    )
                        ? 'excluded'
                        : (preg_match('/optional|nice to have|maybe/i', $text)
                            ? 'optional'
                            : 'unresolved');

                    $items[] = $base;
                    break;

                case 'ambiguity_conflicts':
                    $base['title'] = 'Clarify meaning and measurable acceptance criteria';
                    $base['provenance'] = 'Missing';

                    if (preg_match('/unlimited|100%|tomorrow|no cost|zero cost/i', $text)) {
                        $base['title'] = 'Validate feasibility, capacity, uptime, budget and delivery expectations';
                    } elseif (preg_match('/also add|additional scope|after original/i', $text)) {
                        $base['title'] = 'Potential scope change; compare with the approved revision';
                    } elseif (
                        preg_match('/\bmust\b[^.]*\./i', $text)
                        && preg_match('/\bnot\b/i', $text)
                    ) {
                        $base['title'] = 'Potential contradiction within source; obtain client clarification';
                    }

                    $items[] = $base;
                    break;

                case 'security':
                    $base['title'] = preg_match('/pay|card|refund|billing|payment/i', $text)
                        ? 'Validate payment provider, refunds, webhook verification and compliance; never store raw card details'
                        : 'Validate authorization, sensitive data, retention, audit access and integration credentials';

                    if (preg_match('/health|personal data|sensitive|employee/i', $text)) {
                        $base['title'] = 'Validate sensitive-data minimization, access controls and retention';
                    }

                    $base['provenance'] = 'AI Suggested';
                    $base['scope'] = 'optional';
                    $base['notes'] = 'Security recommendation only; technical validation is required.';
                    $items[] = $base;
                    break;

                case 'screens':
                    $roleText = $role !== '' ? $role : $targetUsers;
                    $roles = preg_split('/[,;\n]+/', $roleText) ?: [];
                    $roles = array_values(array_unique(array_filter(
                        array_map('trim', $roles),
                        fn (string $value): bool => $value !== ''
                    )));

                    foreach ($roles as $screenRole) {
                        $screen = $base;
                        $screen['title'] = 'Proposed screen for ' . mb_substr($screenRole, 0, 200);
                        $screen['role'] = mb_substr($screenRole, 0, 5000);
                        $screen['provenance'] = 'AI Suggested';
                        $screen['scope'] = 'optional';
                        $screen['notes'] = 'Suggested screen; validate navigation, permissions and user journeys.';
                        $items[] = $screen;
                    }
                    break;

                case 'modules':
                    $base['title'] = 'Candidate module: ' . ($feature !== '' ? $feature : 'Requirement review');
                    $base['provenance'] = 'AI Suggested';
                    $base['scope'] = 'optional';
                    $base['dependencies'] = ['Client clarification', 'Technical validation'];
                    $base['notes'] = 'Provisional module derived from source evidence; reviewer validation required.';
                    $items[] = $base;
                    break;

                case 'tasks':
                    $base['title'] = 'Define acceptance criteria, validate design, implement and test: '
                        . ($feature !== '' ? $feature : 'Requirement');
                    $base['provenance'] = 'AI Suggested';
                    $base['scope'] = 'optional';
                    $base['dependencies'] = ['Client clarification', 'Technical validation'];
                    $base['notes'] = 'Provisional task; no effort or delivery commitment has been generated.';
                    $items[] = $base;
                    break;

                case 'phases':
                    $base['title'] = $priority === 'Future'
                        ? 'Future backlog; excluded from immediate delivery pending approval'
                        : 'Proposed discovery, implementation and validation phase';
                    $base['provenance'] = 'AI Suggested';
                    $base['scope'] = 'optional';
                    $base['dependencies'] = ['Requirements review', 'Technical validation'];
                    $base['notes'] = 'Provisional phase; timeline requires authorized PM review.';
                    $items[] = $base;
                    break;
            }
        }

        if ($module === 'ambiguity_conflicts') {
            for ($i = 0; $i < count($sources); $i++) {
                for ($j = $i + 1; $j < count($sources); $j++) {
                    $a = $sources[$i];
                    $b = $sources[$j];

                    $negativeA = (bool) preg_match(
                        '/\b(no|not|never|without|exclude)\b/i',
                        $a['original']
                    );
                    $negativeB = (bool) preg_match(
                        '/\b(no|not|never|without|exclude)\b/i',
                        $b['original']
                    );

                    $tokensA = preg_split('/[^a-z0-9]+/', strtolower($a['original'])) ?: [];
                    $tokensB = preg_split('/[^a-z0-9]+/', strtolower($b['original'])) ?: [];

                    $shared = array_filter(
                        array_intersect($tokensA, $tokensB),
                        fn (string $word): bool => strlen($word) > 3
                    );

                    if ($negativeA !== $negativeB && $shared !== []) {
                        $items[] = [
                            'title' => 'Potential contradiction: client resolution required; both original statements retained',
                            'provenance' => 'Missing',
                            'source_ids' => [(int) $a['id'], (int) $b['id']],
                            'statements' => [$a['original'], $b['original']],
                            'priority' => 'Must',
                            'scope' => 'unresolved',
                            'role' => 'Requires client clarification',
                            'objective' => 'Resolve the conflicting source statements',
                            'feature' => 'Conflict review',
                            'dependencies' => [],
                            'notes' => 'Keyword heuristic only; false positives and missed conflicts are possible.',
                        ];
                    }
                }
            }
        }

        if (in_array(
            $module,
            ['business_context', 'missing_information', 'architecture', 'proposal'],
            true
        )) {
            $titles = match ($module) {
                'business_context' => [
                    'Business problem: ' . ($input['business_problem'] ?? 'Not specified'),
                    'Objectives: ' . ($objectives !== '' ? $objectives : 'Not specified'),
                    'Stakeholders and roles to validate: ' . ($targetUsers !== '' ? $targetUsers : 'Not specified'),
                ],
                'missing_information' => [
                    'Who is authorized to approve the final scope and acceptance criteria?',
                    'What budget, target delivery date, integrations, exclusions and data-retention rules has the client confirmed?',
                    'What measurable success criteria, role-specific permissions and non-functional targets must the system satisfy?',
                ],
                'architecture' => [
                    'Suggested Laravel application and relational data model; developer validation required',
                ],
                'proposal' => [
                    'Draft technical approach: validate requirements before design and delivery',
                    'Maintenance terms, third-party costs and client responsibilities require human agreement; pricing not entered',
                ],
                default => [],
            };

            foreach ($titles as $title) {
                $isMissingInformation = $module === 'missing_information';

                $items[] = [
                    'title' => mb_substr($title, 0, 1000),
                    'provenance' => $isMissingInformation ? 'Missing' : 'AI Suggested',
                    'source_ids' => [],
                    'statements' => [],
                    'priority' => 'Should',
                    'scope' => $isMissingInformation ? 'unresolved' : 'optional',
                    'role' => $isMissingInformation
                        ? 'Requires client clarification'
                        : ($module === 'business_context' ? $targetUsers : 'Not specified'),
                    'objective' => $isMissingInformation
                        ? 'To be confirmed with the client'
                        : ($module === 'business_context' ? $objectives : 'To be determined'),
                    'feature' => $module,
                    'dependencies' => [],
                    'notes' => $isMissingInformation
                        ? 'General clarification checklist; not evidence of a confirmed requirement. Obtain the client answer before treating it as settled.'
                        : 'Demo output. Validate with the client and authorized reviewer; no missing answer, price or estimate has been invented.',
                ];
            }
        }

        return [
            'prompt_version' => 'demo-v1',
            'items' => $items,
        ];
    }
}
