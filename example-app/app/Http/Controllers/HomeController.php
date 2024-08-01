<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    public function register(Request $request)
     {
            // Validation
            $request->validate([
               "name" => "required|string",
               "phone" => 'required',
               "email" => "required|string|email|unique:users",
               "password" => "required|confirmed" // password_confirmation
           ]);
   
           // User model to save user in database
           User::create([
               "name" => $request->name,
               "email" => $request->email,
               "phone" => $request->phone,
               "password" => bcrypt($request->password)
           ]);
           return response()->json([
            "status" => true,
            "message" => "User registered successfully",
            //"data" => []
        ]);
   
    }

}
