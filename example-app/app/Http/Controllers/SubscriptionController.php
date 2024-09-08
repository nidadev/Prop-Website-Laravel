<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubscriptionPlan;
use App\Models\SubscriptionDetail;
use App\Models\CardDetail;
use Stripe\Stripe;
use Stripe\Customer;
use Illuminate\Support\Facades\Auth;

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
            Stripe::setApiKey(env('STRIPE_SECRET'));
            $stripeData = $request->data;

            $customer = $this->createCustomer($stripeData['id']);


            if ($customer) {

                CardDetail::insert([
                    'user_id' => auth()->user()->id,
                    'customer_id' => $customer['id'],
                    'card_id' => $stripeData['card']['id'],
                    'name' => $stripeData['card']['name'],
                    'card_no' => $stripeData['card']['last4'],
                    'brand' => $stripeData['card']['brand'],
                    'month' => $stripeData['card']['exp_month'],
                    'year' => $stripeData['card']['exp_year'],
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
                return response()->json([
                    'success' => true,
                    'msg' => 'customer created',
                    'customer' => $customer
                ]);
            } else {
                return response()->json(['success' => false, 'msg' => 'customer not created']);
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
}
