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
use App\Models\Payment;

class SubscriptionController extends Controller
{
    //

    public function stripe(Request $request)
    {
        //dd($request);
        // Set your secret key. Remember to switch to your live secret key in production.
        // See your keys here: https://dashboard.stripe.com/apikeys
        $stripe = new \Stripe\StripeClient(config('app.stripe_secret'));
        $exp_data_download = $request->exp_data_download;
        //dd($request);

        $response = $stripe->checkout->sessions->create([
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => ['name' => $request->product_name],
                        'unit_amount' => $request->price*100,
                        'tax_behavior' => 'exclusive',
                    ],
                    'adjustable_quantity' => [
                        'enabled' => true,
                        'minimum' => 1,
                        'maximum' => 10,
                    ],
                    'quantity' => 1,
                ],
            ],
            'automatic_tax' => ['enabled' => true],
            'mode' => 'payment',
            'success_url' => route('success').'?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('cancel'),
        ]);
        //dd($response);
        if(isset($response->id) && $response->id!= '')
        {
            session()->put('product_name',$request->product_name);
            session()->put('quantity',$request->quantity);
            session()->put('price',$request->price);
            session()->put('exp_data_download',$request->exp_data_download);
            session()->put('pdf_check',$request->pdf_check);

            return redirect($response->url);
        }
        else
        {
            return redirect()->route('cancel');

        }
    }

    public function success(Request $request)
    {
       //dd($request);
        if(isset($request->session_id))
        {
            $stripe = new \Stripe\StripeClient(config('app.stripe_secret'));

            $response = $stripe->checkout->sessions->retrieve($request->session_id); 
            //dd($response);
            $payment = new Payment();
            $payment->payment_id = $response->id;
            $payment->product_name = session()->get('product_name');

            $payment->quantity = session()->get('quantity');
            $payment->amount = session()->get('price');
            $pdf_check = session()->get('pdf_check');
            $payment->currency = $response->currency;
            $payment->payer_name = $response->customer_details->name;
            $payment->payer_email = $response->customer_details->email;
            $payment->payment_status = $response->status;
            $payment->payment_method = 'Stripe';

            $payment->created_at = date("Y-m-d H:i:s");
            $payment->updated_at = date("Y-m-d H:i:s");
            $payment->user_id = auth()->user()->id;
            $payment->save();
            //
           // dd($request);
            $val_ids = session()->get('exp_data_download')[0];
            return view('payment_success',['data' => $val_ids, 'pdf_check' => $pdf_check]);
            //['data' => $val_ids]

            //return 'Payemnt is successfull'.'<button type="button" class="button" style="border:none;"><a href="http://localhost:8000/export_price/['.$val_ids.']")}}">Export</a></button>';

            session()->forget('product_name');
            session()->forget('quantity');

            session()->forget('price');

        }
        else
        {
            return redirect()->route('cancel');

        }
        //return 'Success';
        //return view('success');

    }
    public function cancel()
    {
        return 'This is cancel';
        //return view('cancel');

    }
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

            \Log::info($stripeData);


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
                        \Log::info($subscriptionData);
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
                        SubscriptionHelper::capture_monthly_pending_fees($customer_id, $user_id, auth()->user()->name, $subPlan, $stripe);
                        //$s = json_decode(json_encode($stripe),true);
                        //\Log::info($s);
                        $subscriptionData = SubscriptionHelper::start_monthly_subscription($customer_id, $user_id, $subPlan, $stripe);
                    } else if ($subPlan->type == 1) { //yearly subscription
                        SubscriptionHelper::capture_yearly_pending_fees($customer_id, $user_id, auth()->user()->name, $subPlan, $stripe);
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

    public function CancelSubscription()
    {
        try {
            $user_id = auth()->user()->id;
            $subscriptionDetail = SubscriptionDetail::where(['user_id' => $user_id, 'status' => 'active', 'cancel' => 0])->orderBy('id', 'desc')->first();

            SubscriptionHelper::cancel_current_subscription($user_id, $subscriptionDetail);
            $response = [
                'success' => true,
                //'data' => $result,
                'msg' => 'Subscription Canceled'
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

    public function webhookSubscription(Request $request)
    {

        $endpoint_secret = env('STRIPE_WEBHOOK');

        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $event = null;

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload,
                $sig_header,
                $endpoint_secret
            );
        } catch (\UnexpectedValueException $e) {
            // Invalid payload
            http_response_code(400);
            exit();
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            http_response_code(400);
            exit();
        }
        switch ($event->type) {
            case 'customer.subscription.deleted':
                $subscription = $event->data->object;
                SubscriptionDetail::where('stripe_subscription_id', $subscription->id)->update([
                    'cancel' => 1,
                    'canceled_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
                break;
            case 'customer.subscription.paused':
                $subscription = $event->data->object;
                SubscriptionDetail::where('stripe_subscription_id', $subscription->id)->update([
                    'cancel' => 1,
                    'canceled_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
                break;

            case 'customer.subscription.resumed':
                $subscription = $event->data->object;
                SubscriptionDetail::where('stripe_subscription_id', $subscription->id)->update([
                    'cancel' => 1,
                    'canceled_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
                break;
            case 'invoice.payment_succeeded':
                $stripeSubscriptionId = $event->data->object->subscription;
                if ($stripeSubscriptionId) {
                    $stripeSubscription = $this->findSubscription($stripeSubscriptionId);
                    $this->handleSubscriptionPaid($stripeSubscription);
                }
                break;
            case 'subscription_schedule.aborted':
                $subscriptionSchedule = $event->data->object;
                SubscriptionDetail::where('stripe_subscription_id', $subscriptionSchedule->id)->update([
                    'cancel' => 1,
                    'canceled_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
                break;
            case 'subscription_schedule.canceled':
                $subscriptionSchedule = $event->data->object;
                SubscriptionDetail::where('stripe_subscription_id', $subscriptionSchedule->id)->update([
                    'cancel' => 1,
                    'canceled_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
                break;
                // ... handle other event types
            default:
                echo 'Received unknown event type ' . $event->type;
        }
    }
    public function findSubscription($stripeSubscriptionId)
    {

        $secretKey = config('app.stripe_secret');
        Stripe::setApiKey($secretKey);
        return \Stripe\Subscription::retrieve($stripeSubscriptionId);
    }

    public function handleSubscriptionPaid($stripeSubscription)
    {
        $newPeriodEnd = $stripeSubscription->current_period_end;
        $subscriptionDetail = SubscriptionDetail::where('stripe_subscription_id', $stripeSubscription->id)->first();
        if ($subscriptionDetail) {
            $secretKey = config('app.stripe_secret');
            Stripe::setApiKey($secretKey);
            $user_id = $subscriptionDetail->user_id;
            if ($stripeSubscription->id == $subscriptionDetail->stripe_subscription_id) {
                $isRenewal = $newPeriodEnd > strtotime($subscriptionDetail->plan_period_end);
                if ($isRenewal) {
                    $apiError = '';
                    try {
                        $stripeSubscription =  \Stripe\Subscription::retrieve($subscriptionDetail->stripe_subscription_id);
                    } catch (\Exception $e) {
                        $apiError = $e->getMessage();
                    }

                    if (empty($apiError) && $stripeSubscription) {
                        $subscriptionData = $stripeSubscription->jsonSerialize();
                        SubscriptionDetail::where('user_id', $user_id)->update([
                            'stripe_subscription_id' => $stripeSubscription->id,
                            'plan_interval_count' => $stripeSubscription['plan']['interval_count'],
                            'plan_period_end' => date('Y-m-d H:i:s', $stripeSubscription->current_period_end),
                        ]);
                    } else {
                        \Log::info($apiError);
                    }
                }
            }
        }
    }
}
