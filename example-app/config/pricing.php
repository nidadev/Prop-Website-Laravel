<?php

// Reference: https://www.prycd.com/plans-pricing, checked 2026-10-04.
return [
    'trial_days' => 14,
    'plans' => [
        'bronze' => ['name' => 'Bronze', 'amount' => 2499, 'interval' => 'month', 'reports' => 0],
        'bronze_plus' => ['name' => 'Bronze Plus', 'amount' => 4999, 'interval' => 'month', 'reports' => 0],
        'gold' => ['name' => 'Gold', 'amount' => 49900, 'interval' => 'year', 'reports' => 20],
    ],
    'services' => ['comp_report' => 200, 'owner_export' => 8, 'list_upload' => 3, 'skip_trace' => 9],
];
