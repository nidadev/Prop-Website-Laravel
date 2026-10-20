<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BillingAccount extends Model
{
    protected $guarded = [];
    protected function casts(): array { return ['period_end' => 'datetime', 'trial_used' => 'boolean', 'checkout_expires_at' => 'datetime']; }
    public function hasAccess(): bool
    {
        return in_array($this->status, ['active', 'trialing'], true) && $this->period_end && $this->period_end->isFuture();
    }
}
