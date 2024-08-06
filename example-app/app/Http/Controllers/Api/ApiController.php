<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{
    
 
    //register api post(name,email,phone,password)
     public function register(Request $request)
     {
            // Validation
            $validator = Validator::make($request->all(),[
               'name' => 'required|min:3',
               'email' => 'required|regex:/^.+@.+$/i|email|unique:users',
               'phone' => 'required|min:6',
               'password' => 'required|confirmed|min:5',
               'password_confirmation' => 'required'
           ]);

           if($validator->fails())
        {
            return response()->json($validator->errors());
           
        }
   
           // User model to save user in database
           User::create([
               "name" => $request->name,
               "email" => $request->email,
               "phone" => $request->phone,
               "password" => Hash::make($request->password)
           ]);
   
           return response()->json([
               "status" => true,
               "message" => "User registered successfully",
               "data" => []
           ]);
       }
   
       // Login API - POST (email, password)
       public function login(Request $request)
    {
       // dd('123');
        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required|min:5'
        ]);

        if($validator->fails())
        {
            return response()->json($validator->errors());
        }

        //auth facade
        $token = Auth::attempt(
            ['email' => $request->email ,
            'password' => $request->password,
          ]);

            if(!$token)
            {
               return response()->json([
            'status' => false,
            'success' => false,
            'message' => 'Incorrect Username or Password',
        ]); 
            }

           return $this->respondWithToken($token);

    }

    public function me()
    {
        return response()->json(auth()->user());
    }

    //protected function
    protected function respondWithToken($token)
    {
        return response()->json([
            'status' => true,
            'success' => true,
            'message' => 'user logged in successfully',
            'token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            ]);
    }
       // Profile API - GET (JWT Auth Token)
       public function profile(Request $request){
   
           $userData = auth()->user();
           //$userData = request()->user();
           //dd($request->all());
   
           return response()->json([
               "status" => true,
               "message" => "Profile data",
               "user" => $userData,
               "user_id" => request()->user()->id,
               "email" => request()->user()->email
           ]);
       }
   
       // Refresh Token API - GET (JWT Auth Token)
       public function refreshToken(){
   
           $token = auth()->refresh();
   
           return response()->json([
               "status" => true,
               "message" => "Refresh token",
               "token" => $token,
               "expires_in" => auth()->factory()->getTTL() * 60
           ]);
       }
   
       // Logout API - GET (JWT Auth Token)
       public function logout(){
           
        try {            
            auth()->logout();
            return response()->json([
                'status'=>true,
                'success' => true,
                'message' => 'user logged out'
            ]);
        }
        catch(\Exception $e){
            return response()->json([
                'status'=>false,
                'success' => false,
                'message' => $e->getMessage(),
            ]);
    
        }
       // return $this->refreshToken();
       }
       
}
