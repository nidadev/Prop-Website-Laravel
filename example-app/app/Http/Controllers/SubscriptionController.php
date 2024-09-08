<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubscriptionPlan;
use App\Models\SubscriptionDetail;

class SubscriptionController extends Controller
{
    //
    public function loadSubscription()
    {
        $plans = SubscriptionPlan::where('enabled', 1)->get();
        return view('subscription', compact('plans'));
    }
    public function getPlanDetails(request $request)
    {
        try {
            $planData = SubscriptionPlan::where('id', $request->id)->first();
            //agar plan active hai koi bhi to trial days show nahi krayegay
            $haveAnyActivePlan = SubscriptionDetail::where(['user_id' => auth()->user()->id, 'status' => 'active'])->count();
            $msg = '';
            if ($haveAnyActivePlan == 0 && ($planData->trial_days != null && $planData->trial_days != '')) {
            $msg = "You will get ".$planData->trial_days."trial days and 
            after we will charge".$planData->amount."for".$planData->name."Subscription Plan";
            
            } else {
                $msg = "We will charge".$planData->amount."for".$planData->name."Subscription Plan";
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
}
