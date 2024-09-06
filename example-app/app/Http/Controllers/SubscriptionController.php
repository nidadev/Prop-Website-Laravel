<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubscriptionPlan;

class SubscriptionController extends Controller
{
    //
    public function loadSubscription()
    {
        $plans = SubscriptionPlan::where('enabled',1)->get();
        return view('subscription',compact('plans'));
    }
    public function getPlanDetails(request $request)
    {
        try{
            $planDetails = SubscriptionPlan::where('id', $request->id)->first();
            //agar plan active hai koi bhi to trial days show nahi krayegay


        }
        catch (\Exception $e) {
        {
            $response = [
                'success' => false,
                //'data' => $result,
                'message' => $e->getMessage()
            ];
            return response()->json($response);
        }

    }
}
}
