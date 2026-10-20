<?php

return [
    // Enable only after API subscriptions and their request limits are configured.
    'enabled' => env('PRYCD_API_ENABLED', false),
    'key' => env('PRYCD_RAPIDAPI_KEY', env('RAPID_KEY')),
    // One pricing request can price one property; cap below both Basic limits.
    'pricing_request_limit' => (int) env('PRYCD_PRICING_REQUEST_LIMIT', 10),
    'comps_request_limit' => (int) env('PRYCD_COMPS_REQUEST_LIMIT', 10),
    'pricing_initial_usage' => (int) env('PRYCD_PRICING_INITIAL_USAGE', 0),
    'comps_initial_usage' => (int) env('PRYCD_COMPS_INITIAL_USAGE', 0),
    'billing_anchor_day' => (int) env('PRYCD_BILLING_ANCHOR_DAY', 3),
];
