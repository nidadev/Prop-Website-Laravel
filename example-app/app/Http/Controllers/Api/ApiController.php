<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Carbon;

class ApiController extends Controller
{


    //register api post(name,email,phone,password)
    public function register(Request $request)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:3',
            'email' => 'required|regex:/^.+@.+$/i|email|unique:users',
            //'phone' => 'required|string|max:15|regex:/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/',
            'password' => 'required|confirmed|min:5',
            'password_confirmation' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }


        // User model to save user in database
        User::create([
            "name" => $request->name,
            "email" => $request->email,
           // "phone" => $request->phone,
            "password" => Hash::make($request->password)
        ]);
        //send verifcation email before register

        $user = User::where('email',$request->email)->get();
            //dd($user);
            if(count($user) > 0)
            {
                $random = Str::random(40);
                $domain = URL::to('/');

                $url = $domain.'/verify-mail/'.$random;
                $data['url'] = $url;

                $data['email'] = $request->email;
                $data['title'] = 'Email Verification';
                $data['body'] = 'Please click here below link to verify your email';
                Mail::send('verifyEmail',[ 'data' => $data],function($message) use ($data){
                    $message->to($data['email'])->subject($data['title']);

                });
                $user = User::find($user[0]['id']);
                $user->remember_token = $random;
                $user->save();


            return response()->json([
                'status' => true,
                'success' => true,
                'message' => 'User registered and verification email send successfully',
            ]);
        }
        else
        {
            return response()->json([
                'status' => false,
                'message' => 'User not found',
            ]);
        }
        /////////////

        /*return response()->json([
            "status" => true,
            "message" => "User registered successfully",
            "data" => []
        ]);*/
    }

    // Login API - POST (email, password)
    public function login(Request $request)
    {
         //dd('123');
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:5'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        //auth facade
        $token = Auth::attempt(
            [
                'email' => $request->email,
                'password' => $request->password,
                'is_verified' => 1,
            ]
        );

        if (!$token) {
            return response()->json([
                'status' => false,
                'success' => false,
                'message' => 'Incorrect Username or Password or Email not verified',
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
    public function profile(Request $request)
    {

        $userData = auth()->user();
        //$userData = request()->user();
        //dd($request->all());

        return response()->json([
            "status" => true,
            "message" => "Profile data",
            "user" => $userData,
            "user_id" => auth()->user()->id,
            "email" => auth()->user()->email
        ]);
    }

    // Refresh Token API - GET (JWT Auth Token)
    public function refreshToken()
    {

        $token = auth()->refresh();

        return response()->json([
            "status" => true,
            "message" => "Refresh token",
            "token" => $token,
            "expires_in" => auth()->factory()->getTTL() * 60
        ]);
    }

    // Logout API - GET (JWT Auth Token)
    public function logout()
    {

        try {
            auth()->logout();
            return response()->json([
                'status' => true,
                'success' => true,
                'message' => 'user logged out'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
        // return $this->refreshToken();
    }
    public function updateProfile(Request $request)
    {
        if (auth()->user()) {
            $validator = Validator::make($request->all(), [
                'id' => 'required',
                'email' => 'required|email',
                'name' => 'required|string|min:5',
                //'phone' => 'required|min:6',
            ]);
            if ($validator->fails()) {
                return response()->json($validator->errors());
            }
            $user = User::find($request->id);
            $user->name = $request->name;
            if($user->email != $request->email)
            {
            $user->is_verified = 0;
            }
            $user->email = $request->email;
            //$user->phone = $request->phone;
           // dd($user->email);
            

            $user->save();
            return response()->json([
                'success' => true,
                'message' => 'User updated successfully',
                'data' => $user
            ]);

        } else {
            return response()->json([
                'success' => false,
                'message' => 'User not authenticated',
            ]);
        }
    }
    //GET 

    public function verifyEmail($email)
    {

        //dd('123');
        if(auth()->user())
        {
            //dd($email);
            $user = User::where('email',$email)->get();
            //dd($user);
            if(count($user) > 0)
            {
                $random = Str::random(40);
                $domain = URL::to('/');

                $url = $domain.'/verify-mail/'.$random;
                $data['url'] = $url;

                $data['email'] = $email;
                $data['title'] = 'Email Verification';
                $data['body'] = 'Please click here below link to verify your email';
                Mail::send('verifyEmail',[ 'data' => $data],function($message) use ($data){
                    $message->to($data['email'])->subject($data['title']);

                });
                $user = User::find($user[0]['id']);
                $user->remember_token = $random;
                $user->save();


            return response()->json([
                'status' => true,
                'success' => true,
                'message' => 'User verification email send successfully',
            ]);
        }
        else
        {
            return response()->json([
                'status' => false,
                'message' => 'User not found',
            ]);
        }
        }
        else
        {
            return response()->json([
                'status' => false,
                'message' => 'User Unauthenticated',
            ]);
        }
    }
    public function verifyEmailToken($token)
    {
        $datetime = Carbon::now()->format('Y-m-d H:i:s');
        $user = User::where('remember_token', $token)->get();
        if(count($user) > 0)
        {
           $user =  User::find($user[0]['id']);
           $user->remember_token = '';
           $user->email_verified_at = $datetime;
           $user->is_verified = 1;
           $user->save();

           return "<h1>email verified successfully <a href='http://165.140.69.88/~plotplaza/checkapi/example-app/public/login'>Sign in </a></h1>";

        }
        else
        {
            return view('404');

        }
    }
}
