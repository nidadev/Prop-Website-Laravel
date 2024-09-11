<?php

namespace App\Helpers;
use App\Models\SubscriptionDetail;
use App\Models\SubscriptionPlan;
use App\Models\User;




class SubscriptionHelper
{
    public static function start_monthly_trial_subscription($customer_id, $user_id, $subPlan)
    {
        try {
            $stripeData = null;
            $current_period_start = date("Y-m-d H:i:s");

            //23.59.59
            $Date = date("Y-m-d 23:59:59");
            $trialDays = strtotime($Date . '+' . $subPlan->trial_days . 'days');
            $subscriptionDetailsData = [
                'user_id' => $user_id,
                'stripe_subscription_id' => NULL,
                'stripe_subscription_schedule_id' => "",
                'stripe_customer_id' => $customer_id,
                'subscription_plan_price_id' => $subPlan->stripe_price_id,
                'plan_amount' => $subPlan->amount,
                'plan_amount_currency' => 'usd',
                'plan_interval' => 'month',
                'plan_interval_count' => 1,
                'created' => date("Y-m-d H:i:s"),
                'plan_period_start' => $current_period_start,
                'plan_period_end' => date("Y-m-d H:i:s",$trialDays),
                'trial_end' => $trialDays,
                'status' => 'active',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ];
            $stripeData = SubscriptionDetail::updateOrCreate([
                'user_id' => $user_id,
                'stripe_customer_id' => $customer_id,
                'subscription_plan_price_id' => $subPlan->stripe_price_id

            ],$subscriptionDetailsData);

            User::where('id', $user_id)->update(['is_subscribed' => 1]);
            return $stripeData;
        } catch (\Exception $e) {
            return null;
        }
    }
}
