<?php

namespace App\Helpers;

use Log;
use App\Models\User;
use App\Models\PendingFee;
use App\Models\SubscriptionPlan;
use App\Models\SubscriptionDetail;
use Stripe\Stripe;
use Stripe\Subscription;

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
                'plan_period_end' => date("Y-m-d H:i:s", $trialDays),
                'trial_end' => $trialDays,
                'status' => 'active',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ];
            $stripeData = SubscriptionDetail::updateOrCreate([
                'user_id' => $user_id,
                'stripe_customer_id' => $customer_id,
                'subscription_plan_price_id' => $subPlan->stripe_price_id

            ], $subscriptionDetailsData);

            User::where('id', $user_id)->update(['is_subscribed' => 1]);
            return $stripeData;
        } catch (\Exception $e) {
            return null;
        }
    }

    public static function start_yearly_trial_subscription($customer_id, $user_id, $subPlan)
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
                'plan_interval' => 'yearly',
                'plan_interval_count' => 1,
                'created' => date("Y-m-d H:i:s"),
                'plan_period_start' => $current_period_start,
                'plan_period_end' => date("Y-m-d H:i:s", $trialDays),
                'trial_end' => $trialDays,
                'status' => 'active',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ];
            $stripeData = SubscriptionDetail::updateOrCreate([
                'user_id' => $user_id,
                'stripe_customer_id' => $customer_id,
                'subscription_plan_price_id' => $subPlan->stripe_price_id

            ], $subscriptionDetailsData);

            User::where('id', $user_id)->update(['is_subscribed' => 1]);
            return $stripeData;
        } catch (\Exception $e) {
            return null;
        }
    }

    public static function start_lifetime_trial_subscription($customer_id, $user_id, $subPlan)
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
                'plan_interval' => 'lifetime',
                'plan_interval_count' => 1,
                'created' => date("Y-m-d H:i:s"),
                'plan_period_start' => $current_period_start,
                'plan_period_end' => date("Y-m-d H:i:s", $trialDays),
                'trial_end' => $trialDays,
                'status' => 'active',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ];
            $stripeData = SubscriptionDetail::updateOrCreate([
                'user_id' => $user_id,
                'stripe_customer_id' => $customer_id,
                'subscription_plan_price_id' => $subPlan->stripe_price_id

            ], $subscriptionDetailsData);

            User::where('id', $user_id)->update(['is_subscribed' => 1]);
            return $stripeData;
        } catch (\Exception $e) {
            return null;
        }
    }

    public static function capture_monthly_pending_fees($customer_id, $user_id, $user_name, $subPlan, $stripe)
    {
        $totalAmount = $subPlan->amount;
        $daysInMonth = date('t');
        $currentDay = date('j');
        //Log::info($daysInMonth);
        //Log::info($currentDay);

        $amountForRestDays = ceil(($daysInMonth - $currentDay) * ($totalAmount / $daysInMonth));
        $stripeChargeData = $stripe->charges->create([
            'amount' => $amountForRestDays * 100,
            'currency' => 'usd',
            'customer' => $customer_id,
            'description' => 'Montly Pending Fees',
            'shipping' => [
                'name' => $user_name,
                'address' => [
                    'line1' => '123 main state',
                    'line2' => 'Apt 1',
                    'city' => 'Anytown',
                    'state' => 'NY',
                    'postal_code' => '12345',
                    'country' => 'US',
                ]
            ]
        ]);
        //Log::info($stripeChargeData);
        if (!empty($stripeChargeData)) {
            $stripeCharge = $stripeChargeData->jsonSerialize();
            $chargeId = $stripeCharge['id'];
            $cusId = $stripeCharge['customer'];
            $pendingFeeData = [
                'user_id' => $user_id,
                'charge_id' => $chargeId,
                'customer_id' => $cusId,
                'amount' => $amountForRestDays,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' =>  date("Y-m-d H:i:s"),
            ];
            PendingFee::insert($pendingFeeData);
        }
    }

    public static function start_monthly_subscription($customer_id, $user_id, $subPlan, $stripe)
    {
        try {
            $stripeData = null;
            $millisecondsDate = strtotime(date("Y-m-") . "01");

            $current_period_start =  date("Y-m-d", strtotime("+1 month", $millisecondsDate)) . ' 00:00:00';
            $current_period_end =  date("Y-m-t", strtotime("+1 month")) . ' 23:59:59';
            //\Log::info($stripe);

            $stripeData =  $stripe->subscriptions->create([
                'customer' => $customer_id,
                'items' => [['price' => $subPlan->stripe_price_id]],
                'billing_cycle_anchor' => strtotime($current_period_start),
                'proration_behavior' => 'none',
            ]);
            $stripeData = $stripeData->jsonSerialize();
            //dd($stripeData);                         
            //\Log::info($stripeData['items']);

            if (!empty($stripeData)) {
                $subscriptionId = $stripeData['id'];
                $customerId = $stripeData['customer'];
                if (!empty($stripeData['items'])) {
                    $planId = $stripeData['items']['data'][0]['plan']['id'];
                } else {
                    $planId = $stripeData['plan']['id'];
                }
                //\Log::info($planId);
                $priceData = $stripe->plans->retrieve($planId, []);
                //\Log::info($priceData);
                $planAmount = ($priceData->amount / 100);
                $planCurrency = $priceData->currency;
                $planInterval = $priceData->interval;
                $planIntervalCount = $priceData->interval_count;

                $created = date("Y-m-d H:i:s", $stripeData['created']);
                $subscriptionDetailsData = [
                    'user_id' => $user_id,
                    'stripe_subscription_id' => $subscriptionId,
                    'stripe_subscription_schedule_id' => "",
                    'stripe_customer_id' => $customerId,
                    'subscription_plan_price_id' => $planId,
                    'plan_amount' => $planAmount,
                    'plan_amount_currency' => $planCurrency,
                    'plan_interval' => $planInterval,
                    'plan_interval_count' => $planIntervalCount,
                    'created' => $created,
                    'plan_period_start' => $current_period_start,
                    'plan_period_end' => $current_period_end,
                    'status' => 'active',
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s")
                ];
                $stripeData = SubscriptionDetail::insert($subscriptionDetailsData);
                User::where('id', $user_id)->update(['is_subscribed' => 1]);
            }

            return $stripeData;
        } catch (\Exception $e) {
            return null;
        }
    }

    public static function capture_yearly_pending_fees($customer_id, $user_id, $user_name, $subPlan, $stripe)
    {
        $totalAmount = $subPlan->amount;
        $monthsInYear = 12;
        $currentMonth = date('m') - 1;
        //Log::info($daysInMonth);
        //Log::info($currentDay);

        $amountForRestMonths = ceil(($monthsInYear - $currentMonth) * ($totalAmount / $monthsInYear));
        $stripeChargeData = $stripe->charges->create([
            'amount' => $amountForRestMonths * 100,
            'currency' => 'usd',
            'customer' => $customer_id,
            'description' => 'Montly Pending Fees',
            'shipping' => [
                'name' => $user_name,
                'address' => [
                    'line1' => '123 main state',
                    'line2' => 'Apt 1',
                    'city' => 'Anytown',
                    'state' => 'NY',
                    'postal_code' => '12345',
                    'country' => 'US',
                ]
            ]
        ]);
        //Log::info($stripeChargeData);
        if (!empty($stripeChargeData)) {
            $stripeCharge = $stripeChargeData->jsonSerialize();
            $chargeId = $stripeCharge['id'];
            $cusId = $stripeCharge['customer'];
            $pendingFeeData = [
                'user_id' => $user_id,
                'charge_id' => $chargeId,
                'customer_id' => $cusId,
                'amount' => $amountForRestMonths,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' =>  date("Y-m-d H:i:s"),
            ];
            PendingFee::insert($pendingFeeData);
        }
    }

    public static function start_yearly_subscription($customer_id, $user_id, $subPlan, $stripe)
    {
        try {
            $stripeData = null;

            $current_period_start =  date("Y-", strtotime("+1 year")) . '01-01 00:00:00';
            $current_period_end =  date("Y-", strtotime("+1 year")) . '12-31 23:59:59';
            //\Log::info($stripe);

            $stripeData =  $stripe->subscriptions->create([
                'customer' => $customer_id,
                'items' => [['price' => $subPlan->stripe_price_id]],
                'billing_cycle_anchor' => strtotime($current_period_start),
                'proration_behavior' => 'none',
            ]);
            $stripeData = $stripeData->jsonSerialize();
            //dd($stripeData);                         
            //\Log::info($stripeData['items']);

            if (!empty($stripeData)) {
                $subscriptionId = $stripeData['id'];
                $customerId = $stripeData['customer'];
                if (!empty($stripeData['items'])) {
                    $planId = $stripeData['items']['data'][0]['plan']['id'];
                } else {
                    $planId = $stripeData['plan']['id'];
                }
                //\Log::info($planId);
                $priceData = $stripe->plans->retrieve($planId, []);
                //\Log::info($priceData);
                $planAmount = ($priceData->amount / 100);
                $planCurrency = $priceData->currency;
                $planInterval = $priceData->interval;
                $planIntervalCount = $priceData->interval_count;

                $created = date("Y-m-d H:i:s", $stripeData['created']);
                $subscriptionDetailsData = [
                    'user_id' => $user_id,
                    'stripe_subscription_id' => $subscriptionId,
                    'stripe_subscription_schedule_id' => "",
                    'stripe_customer_id' => $customerId,
                    'subscription_plan_price_id' => $planId,
                    'plan_amount' => $planAmount,
                    'plan_amount_currency' => $planCurrency,
                    'plan_interval' => $planInterval,
                    'plan_interval_count' => $planIntervalCount,
                    'created' => $created,
                    'plan_period_start' => $current_period_start,
                    'plan_period_end' => $current_period_end,
                    'status' => 'active',
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s")
                ];
                $stripeData = SubscriptionDetail::insert($subscriptionDetailsData);
                User::where('id', $user_id)->update(['is_subscribed' => 1]);
            }

            return $stripeData;
        } catch (\Exception $e) {
            return null;
        }
    }

    public static function cancel_current_subscription($user_id, $subscriptionDetail)
    {
        try {
            $secretKey = config('app.stripe_secret');
            Stripe::setApiKey($secretKey);
            if ($subscriptionDetail->stripe_subscription_id != null && $subscriptionDetail->stripe_subscription_id != '') {
                $subscription = Subscription::retrieve($subscriptionDetail->stripe_subscription_id);
                \Log::info($subscription);
                //cancel the subscription
                $subscription->cancel();
            }
            SubscriptionDetail::where('id', $subscriptionDetail->id)->update([
                'status' => 'cancelled',
                'cancel' => 1,
                'canceled_at' => date("Y-m-d H:i:s")
            ]);
            User::where('id', $user_id)->update(['is_subscribed' => 0]);
        } catch (\Exception $e) {
            return \Log::info($e->getMessage());
        }
    }
}
