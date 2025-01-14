<?php

namespace App\Console\Commands;

use App\Models\SubscriptionPlan;
use App\Models\SubscriptionDetail;
use Stripe\Stripe;

use Stripe\StripeClient;
use App\Helpers\SubscriptionHelper;

use Illuminate\Console\Command;

class UpdateTrialSubscription extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-trial-subscription';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'update trial user subscription into real subscription';

    /**
     * Execute the console command.
     */

    protected $STRIPE_SECRET_KEY;
    public function __construct()
    {
        $secretKey = env('STRIPE_SECRET');
        $this->STRIPE_SECRET_KEY = $secretKey;

        parent::__construct();
    }

    public function handle()
    {
        //
        $secretKey = $this->STRIPE_SECRET_KEY;
        Stripe::setApiKey($secretKey);
        $stripe = new StripeClient($secretKey);

        //\Log::info($stripe);

        $subscriptionDetails = SubscriptionDetail::with('user')->where([
            'status' => 'active',
            'cancel' => 0
        ])->where('plan_period_end', '<', date("Y-m-d H:i:s"))->whereNotNull('trial_end')->orderBy('id', 'desc')->get();
        //\Log::info(count($subscriptionDetails));

        if (count($subscriptionDetails) > 0) {
            foreach ($subscriptionDetails as $detail) {
                $subPlan = SubscriptionPlan::where('stripe_price_id', $detail->subscription_plan_price_id)->first();
                //\Log::info($subPlan);

                if ($detail->plan_interval == 'month') {
                    SubscriptionHelper::capture_monthly_pending_fees($detail->stripe_customer_id, $detail->user_id, $detail->user->name, $subPlan, $stripe);
                    SubscriptionHelper::renew_monthly_subscription($detail, $detail->user_id, $subPlan, $stripe);
                } else if ($detail->plan_interval == 'year') {
                    SubscriptionHelper::capture_yearly_pending_fees($detail->stripe_customer_id, $detail->user_id, $detail->user->name, $subPlan, $stripe);
                    SubscriptionHelper::renew_yearly_subscription($detail, $detail->user_id, $subPlan, $stripe);
                }
            }
        }
    }
}
