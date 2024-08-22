<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'trial_days',
        'stripe_price_id',
        'amount',
        'type',
        'enabled',
        'created_at',
        'updated_at'

    ];
}
