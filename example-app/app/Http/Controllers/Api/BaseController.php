<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    //
    public function sendResponse($result,$message)
    {
        $response = [
            'success' => true,
            'data' => $result,
            'message' => $message
        ];
        return response()->json($response,200);
    }

    public function sendError($result,$errorMessage=[],$code=404)
    {
        $response = [
            'success' => false,
            'message' => $errorMessage
        ];
        if(!empty($errorMessage))
        {
            $response['data'] = $errorMessage;
        }
        return response()->json($response,$code);
    }
}
