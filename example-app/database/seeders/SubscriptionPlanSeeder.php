<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SubscriptionPlan;
use Carbon\Carbon;
class SubscriptionPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $currentDatetime = Carbon::now()->format("Y-m-d H:i:s");
        SubscriptionPlan::insert([
        ['name' => 'Monthly',
        'trial_days' => 5,
        'stripe_price_id' => 'prod_QgDF3K7NN92aO3',
        'amount' => 12,
        'type' => 0,
        'enabled' => 1,
        'created_at' => $currentDatetime,
        'updated_at' => $currentDatetime
        ],
        ['name' => 'Yearly',
        'trial_days' => 5,
        'stripe_price_id' => 'prod_QgDGnieXqePZqr',
        'amount' => 100,
        'type' => 1,
        'enabled' => 1,
        'created_at' => $currentDatetime,
        'updated_at' => $currentDatetime
        ],
        ['name' => 'Lifetime',
        'trial_days' => 5,
        'stripe_price_id' => 'prod_QgDJgAPbDmQ3hP',
        'amount' => 400,
        'type' => 2,
        'enabled' => 1,
        'created_at' => $currentDatetime,
        'updated_at' => $currentDatetime
        ],
    ]);
    }
}
