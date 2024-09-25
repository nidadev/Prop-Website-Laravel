<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubscriptionPlan;
use App\Models\SubscriptionDetail;
use App\Models\CardDetail;
use Stripe\Stripe;
use Stripe\Customer;
use Stripe\StripeClient;
use Illuminate\Support\Facades\Auth;
use App\Helpers\SubscriptionHelper;

class SubscriptionController extends Controller
{
    //
    public function loadSubscription()
    {
        $plans = SubscriptionPlan::where('enabled', 1)->get();
        return view('subscription', compact('plans'));
    }
    public function CreateSubscription(Request $request)
    {
        try {
            $user_id = auth()->user()->id;
            $secretKey = config('app.stripe_secret');
            Stripe::setApiKey($secretKey);
            
            $stripeData = $request->data;
            $subscriptionData = null;

                                    //\Log::info($request->data);


            $stripe = new StripeClient($secretKey);

            $customer = $this->createCustomer($stripeData['id']);

            $customer_id = $customer['id'];
            $subPlan = SubscriptionPlan::where('id', $request->plan_id)->first();

            //start and change subscription conditions
            //check if exist any active current subscription
            $subscriptionDetail = SubscriptionDetail::where(['user_id' => $user_id, 'status' => 'active', 'cancel' => 0])->orderBy('id', 'desc')->first();
            //check if any subscription avaailable of user
            $subscriptionDetailCount = SubscriptionDetail::where(['user_id' =>  $user_id])->orderBy('id', 'desc')->count();
            //start and change subscription conditions end

            //if monthly availabel and change into yearly
            if ($subscriptionDetail && $subscriptionDetail->plan_interval == 'month' && $subPlan->type == 1) {
                SubscriptionHelper::cancel_current_subscription($user_id, $subscriptionDetail);
                $subscriptionData = SubscriptionHelper::start_yearly_subscription($customer_id, $user_id, $subPlan, $stripe);

            }
            //if monthly availabel and change into lifetime
            else if ($subscriptionDetail && $subscriptionDetail->plan_interval == 'month' && $subPlan->type == 2) {
                SubscriptionHelper::cancel_current_subscription($user_id, $subscriptionDetail);

            }
            //if yearly availabel and change into monthly

            else if ($subscriptionDetail && $subscriptionDetail->plan_interval == 'yearly' && $subPlan->type == 0) {
                SubscriptionHelper::cancel_current_subscription($user_id, $subscriptionDetail);
                $subscriptionData = SubscriptionHelper::start_monthly_subscription($customer_id, $user_id, $subPlan, $stripe);


            }

            //if yearly availabel and change into lifetim

            else if ($subscriptionDetail && $subscriptionDetail->plan_interval == 'year' && $subPlan->type == 2) {
            } else { //else not available any plan already
                if ($subscriptionDetailCount == 0) { //new user
                    if ($subPlan->type == 0) {
                        $subscriptionData = SubscriptionHelper::start_monthly_trial_subscription($customer_id, $user_id, $subPlan);
                        //\Log::info($subscriptionData);
                        //monthly trial
                    } else if ($subPlan->type == 1) {
                        $subscriptionData = SubscriptionHelper::start_yearly_trial_subscription($customer_id, $user_id, $subPlan);

                        //yearly
                    } else if ($subPlan->type == 2) {
                        $subscriptionData = SubscriptionHelper::start_lifetime_trial_subscription($customer_id, $user_id, $subPlan);

                        //lifetime
                    }
                } else { //if user all subscriptions canceled

                    if ($subPlan->type == 0) {   //\Log::info($subscriptionData);  //monthly subscription
                        SubscriptionHelper::capture_monthly_pending_fees($customer_id, $user_id, auth()->user()->name , $subPlan, $stripe);
                        //$s = json_decode(json_encode($stripe),true);
                        //\Log::info($s);
                        $subscriptionData = SubscriptionHelper::start_monthly_subscription($customer_id, $user_id, $subPlan, $stripe);
                    } else if ($subPlan->type == 1) { //yearly subscription
                        SubscriptionHelper::capture_yearly_pending_fees($customer_id, $user_id, auth()->user()->name , $subPlan, $stripe);
                        $subscriptionData = SubscriptionHelper::start_yearly_subscription($customer_id, $user_id, $subPlan, $stripe);


                    } else if ($subPlan->type == 2) { //lifetime subscription
                    }
                }
            }

            $this->saveCardDetails($stripeData, $user_id, $customer_id);
            //\Log::info($subscriptionData);
            if ($subscriptionData) {
                return response()->json([
                    'success' => true,
                    'msg' => 'Subscription purchased',
                    //'customer' => $customer
                ]);
            } 
            else {
                return response()->json(['success' => false, 'msg' => 'subscription failed']);
            }
        } catch (\Exception $e) {
            $response = [
                'success' => false,
                'msg' => $e->getMessage()
            ];
            return response()->json($response);
        }
    }
    public function getPlanDetails(request $request)
    {
        try {
            $planData = SubscriptionPlan::where('id', $request->id)->first();
            //agar plan active hai koi bhi to trial days show nahi krayegay
            $haveAnyActivePlan = SubscriptionDetail::where(['user_id' => auth()->user()->id, 'status' => 'active'])->count();
            $msg = '';
            if ($haveAnyActivePlan == 0 && ($planData->trial_days != null && $planData->trial_days != '')) {
                $msg = "You will get " . $planData->trial_days . "trial days and 
            after we will charge" . $planData->amount . "for" . $planData->name . "Subscription Plan";
            } else {
                $msg = "We will charge" . $planData->amount . "for" . $planData->name . "Subscription Plan";
            }
            $response = [
                'success' => true,
                'msg' => $msg,
                'data' => $planData
            ];
            return response()->json($response);
        } catch (\Exception $e) { {
                $response = [
                    'success' => false,
                    //'data' => $result,
                    'msg' => $e->getMessage()
                ];
                return response()->json($response);
            }
        }
    }
    public function createCustomer($token_id)
    {
        $customer = Customer::create([
            'name' => auth()->user()->name,
            'email' => auth()->user()->email,
            'source' => $token_id
        ]);
        return $customer;
    }
    public function saveCardDetails($cardData, $user_id, $customer_id)
    {
        CardDetail::updateOrCreate(
            [
                'user_id' => $user_id,
                'card_no' => $cardData['card']['last4'],

            ],
            [
                'user_id' => $user_id,
                'customer_id' => $customer_id,
                'card_id' => $cardData['card']['id'],
                'name' => $cardData['card']['name'],
                'card_no' => $cardData['card']['last4'],
                'brand' => $cardData['card']['brand'],
                'month' => $cardData['card']['exp_month'],
                'year' => $cardData['card']['exp_year'],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        );
    }
}
