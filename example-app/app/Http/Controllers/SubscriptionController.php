<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubscriptionPlan;
use App\Models\SubscriptionDetail;
use App\Models\CardDetail;
use Stripe\Stripe;
use Stripe\Customer;
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
            $secretKey = env('STRIPE_SECRET');
            Stripe::setApiKey($secretKey);
            $stripeData = $request->data;

            $customer = $this->createCustomer($stripeData['id']);
            
            $customer_id = $customer['id'];
            $subPlan = SubscriptionPlan::where('id', $request->plan_id)->first();
            if($subPlan->type == 0)
            {
                $subscriptionData = SubscriptionHelper::start_monthly_trial_subscription($customer_id,$user_id,$subPlan);
                //\Log::info($subscriptionData);
                //monthly trial
            }
            else if($subPlan->type == 1) 
            {
                $subscriptionData = SubscriptionHelper::start_yearly_trial_subscription($customer_id,$user_id,$subPlan);

//yearly
            }
            else if($subPlan->type == 2) 
            {
                $subscriptionData = SubscriptionHelper::start_lifetime_trial_subscription($customer_id,$user_id,$subPlan);

//lifetime
            }
            $this->saveCardDetails($stripeData, $user_id, $customer_id);


            if ($subscriptionData) {

                
                return response()->json([
                    'success' => true,
                    'msg' => 'Subscription purchased',
                    //'customer' => $customer
                ]);
            } else {
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
        CardDetail::updateOrCreate([
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
        ]);

    }
}
