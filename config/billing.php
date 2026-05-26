<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Activate on Partial Payment
    |--------------------------------------------------------------------------
    |
    | Determines whether subscriptions should be activated when an invoice
    | is partially paid. If false, subscriptions will only activate when
    | the invoice is fully paid.
    |
    */
    'activate_on_partial_payment' => env('BILLING_ACTIVATE_ON_PARTIAL', false),

    /*
    |--------------------------------------------------------------------------
    | Payment Grace Period
    |--------------------------------------------------------------------------
    |
    | Number of days after invoice due date before subscription is suspended
    | for non-payment.
    |
    */
    'payment_grace_period_days' => env('BILLING_GRACE_PERIOD', 7),

    /*
    |--------------------------------------------------------------------------
    | Allow Overpayment
    |--------------------------------------------------------------------------
    |
    | Whether to allow payments that exceed the invoice total amount.
    | Generally should be false to prevent accounting errors.
    |
    */
    'allow_overpayment' => env('BILLING_ALLOW_OVERPAYMENT', false),
];
