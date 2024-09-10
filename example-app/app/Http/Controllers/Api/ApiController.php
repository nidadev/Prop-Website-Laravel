<?php

namespace App\Http\Controllers\Api;

use Pdf;
use Mail;
use GuzzleHttp;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\BaseController as ControllersBaseController;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ApiController extends BaseController
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

        $user = User::where('email', $request->email)->get();
        //dd($user);
        if (count($user) > 0) {
            $random = Str::random(40);
            $domain = URL::to('/');

            $url = $domain . '/verify-mail/' . $random;
            $data['url'] = $url;

            $data['email'] = $request->email;
            $data['title'] = 'Email Verification';
            $data['body'] = 'Please click here below link to verify your email';
            Mail::send('verifyEmail', ['data' => $data], function ($message) use ($data) {
                $message->to($data['email'])->subject($data['title']);
            });
            $user = User::find($user[0]['id']);
            $user->remember_token = $random;

            //set client id and secret

            $client_id = config('app.client_id');
            $client_secret = config('app.client_secret');

            $user->client_id = $client_id;
            $user->client_secret = $client_secret;
            //$user->save();

            $user->save();


            return response()->json([
                'status' => true,
                'success' => true,
                'message' => 'User registered and verification email send successfully',
            ]);
        } else {
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
    //research 
    public function research(Request $request)
    {

        if (auth()->user()) {

            $userData = auth()->user();
            return response()->json([
                'status' => true,
                'message' => 'data is received',
                'data' => $userData
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'data is not received'
            ]);
        }

        //if authenticate token can fetch records

        //else not
    }
    //
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

        //get user 
        $user = User::where('email', $request->email)->first();

        if (!$token) {
            return response()->json([
                'status' => false,
                'success' => false,
                'message' => 'Incorrect Username or Password or Email not verified',
            ]);
        }

        return $this->respondWithToken($token, $user);
    }

    public function me()
    {
        return response()->json(auth()->user());
    }

    //protected function
    protected function respondWithToken($token, $user)
    {
        return response()->json([
            'status' => true,
            'success' => true,
            'message' => 'user logged in successfully',
            'token' => $token,
            'user' => $user,
            'token_type' => 'Bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
        ]);
    }

    protected function respondWithToken2($token)
    {
        return response()->json([
            'status' => true,
            'success' => true,
            'message' => 'user logged in successfully',
            'token' => $token,
            'token_type' => 'Bearer',
            //'expires_in' => auth()->factory()->getTTL() * 60,
        ]);
    }
    // Profile API - GET (JWT Auth Token)
    public function profile(Request $request)
    {

        return response()->json([
            "status" => true,
            "message" => "Profile data",
            "user_id" => auth()->user()->id,
            "name" => auth()->user()->name,
            "email" => auth()->user()->email,
            "is_verified" => auth()->user()->is_verified,
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
    /*public function logout()
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
    }*/
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
            if ($user->email != $request->email) {
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
        if (auth()->user()) {
            //dd($email);
            $user = User::where('email', $email)->get();
            //dd($user);
            if (count($user) > 0) {
                $random = Str::random(40);
                $domain = URL::to('/');

                $url = $domain . '/verify-mail/' . $random;
                $data['url'] = $url;

                $data['email'] = $email;
                $data['title'] = 'Email Verification';
                $data['body'] = 'Please click here below link to verify your email';
                Mail::send('verifyEmail', ['data' => $data], function ($message) use ($data) {
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
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'User not found',
                ]);
            }
        } else {
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
        if (count($user) > 0) {
            $user =  User::find($user[0]['id']);
            $user->remember_token = '';
            $user->email_verified_at = $datetime;
            $user->is_verified = 1;
            $user->save();

            return "<h1>email verified successfully <a href='http://165.140.69.88/~plotplaza/checkapi/example-app/public/login'>Sign in </a></h1>";
        } else {
            return view('404');
        }
    }

    public function loadLogin()
    {
        return view('login2');
    }

    public function userLogin(Request $request)
    {
        dd($request);
        $userCredentials = $request->only('email', 'password');
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:5'
        ]);

        if ($validator->fails()) {
            //$error[] = $this->sendError('error',$validator->errors());
            return redirect()->route('userLogin')->withErrors($validator);
            //return  back()->with('error', $error);
        }
        $token = Auth::attempt($userCredentials);
        if (!$token) {
            return back()->with('error', 'User password mismatch');
        }
        $success = $this->respondWithToken2($token);
        if ($success) {
            return view('dashboard', ['data' => $token]);
        }
        //return redirect()->route('userLogin')->withErrors('uSer password mismatch');
    }

    public function dashboard()
    {
        return view('dashboard');
    }

    public function loadCompReport()
    {
        return view('compreport2');
    }

    public function GetCompReport(Request $request)
    {
        //dd($request);
        $client = new GuzzleHttp\Client();
        $login = $client->request('POST', 'https://dtapiuat.datatree.com/api/Login/AuthenticateClient', [
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',

            ],
            'body' => json_encode([
                'ClientId' => config('app.client_id'),
                'ClientSecretKey' => config('app.client_secret')
            ])
        ]);
        $authenticate = json_decode($login->getBody(), true);
        //dd($authenticate);
        $apn = $request->apn;
        try {
            $res = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $authenticate,
                ],
                'body' => '{
                "ProductNames" : ["PropertyDetailReport"],
                "SearchType": "Filter",
                "SearchRequest": {
                    "ReferenceId": "1",
                    "ProductName": "SearchLite",
                    "MaxReturn": "1",
                    "Filters": [{
                        "FilterName": "ApnRange",
                        "FilterOperator": "starts with",
                        "FilterValues": [
                            "' . $apn . '"
                        ]
                    }]
                },
            }',
            ]);
            $data = json_decode($res->getBody(), true);
            $dt[] = $data['Reports']['0'];
            $poperty_id = $data['Reports']['0']['PropertyId'];
            //dd();
            $maxcount = 1;
            $mainval = $maxcount * 0.02;
            //dd($dt);
            //echo '$("#mytable4").append("<tr><td>'.$data['Reports'][0]['PropertyId'].'</td></tr>")';

            //return $this->getCompData($data);

            return view('compreport2', compact('dt', 'maxcount', 'mainval', 'poperty_id'));
        } catch (\Exception $e) {
            //throw new HttpException(500, $e->getMessage());
            $response = $e->getResponse();
            $emsg = $e->getMessage();
            //dd($response);
            $fromserver = 'No records found . or Server error';
            $msg = json_decode($response->getBody()->getContents(), true);
            $error = $msg ? $msg : $fromserver;
            //dd($response['reasonPhrase']);
            return  redirect()->to('compreport2')->with('error', $error);
        }
        //dd($data);
    }

    public function loadPriceReport()
    {
        return view('priceland');
    }

    public function GetPriceReport(Request $request)
    {
        //dd($request);
        $client = new GuzzleHttp\Client();
        $login = $client->request('POST', 'https://dtapiuat.datatree.com/api/Login/AuthenticateClient', [
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',

            ],
            'body' => json_encode([
                'ClientId' => config('app.client_id'),
                'ClientSecretKey' => config('app.client_secret')
            ])
        ]);
        $authenticate = json_decode($login->getBody(), true);
        //dd($authenticate);
        $st = $request->state;
        $acr1 = $request->acr1;
        $acr2 = $request->acr2;
        $avg_acr = $acr1 + $acr2 / 2;
        $cp = $request->cp;

        //$info = [$acr1,$acr2];

        try {
            $res0 = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $authenticate,
                ],
                'body' => '{
                        "ProductNames": [
                            "SalesComparables"
                        ],
                        "SearchType": "Filter",
            
                        "SearchRequest": {
                            "ReferenceId": "1",
                            "ProductName": "SearchLite",
                            "MaxReturn": "1",
                            "Filters": [
                             
                                {
                                    "FilterName": "LotAcreage",
                                    "FilterOperator": "is between",
                                    "FilterValues": [
                                        0,
                                        5
                                    ]
                                },
                                {
                                    "FilterName": "StateFips",
                                    "FilterOperator": "is",
                                    "FilterValues": [
                                        "' . $st . '"
                                    ],
                                    "FilterGroup": 1
                                },
                                {
                                    "FilterName": "CountyFips",
                                    "FilterOperator": "is",
                                    "FilterValues": [
                                        ' . $cp . '
                                    ],
                                    "FilterGroup": 1
                                },
                                {
                                    "FilterName": "SalePrice",
            
                                    "FilterOperator": "is between",
            
                                    "FilterValues": ["1", "10000000"],
            
                                    "FilterGroup": 1
            
                                },
                                
                            ] //
                        } //
                    }',
            ]);
            $d0 = json_decode($res0->getBody(), true);
            $res1 = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $authenticate,
                ],
                'body' => '{
                        "ProductNames": [
                            "SalesComparables"
                        ],
                        "SearchType": "Filter",
            
                        "SearchRequest": {
                            "ReferenceId": "1",
                            "ProductName": "SearchLite",
                            "MaxReturn": "1",
                            "Filters": [
                             
                                {
                                    "FilterName": "LotAcreage",
                                    "FilterOperator": "is between",
                                    "FilterValues": [
                                        5,
                                        10
                                    ]
                                },
                                {
                                    "FilterName": "StateFips",
                                    "FilterOperator": "is",
                                    "FilterValues": [
                                        "' . $st . '"
                                    ],
                                    "FilterGroup": 1
                                },
                                {
                                    "FilterName": "CountyFips",
                                    "FilterOperator": "is",
                                    "FilterValues": [
                                        ' . $cp . '
                                    ],
                                    "FilterGroup": 1
                                },
                                {
                                    "FilterName": "SalePrice",
            
                                    "FilterOperator": "is between",
            
                                    "FilterValues": ["1", "10000000"],
            
                                    "FilterGroup": 1
            
                                },
                                
                            ] //
                        } //
                    }',
            ]);
            $d1 = json_decode($res1->getBody(), true);

            $res2 = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $authenticate,
                ],
                'body' => '{
                        "ProductNames": [
                            "SalesComparables"
                        ],
                        "SearchType": "Filter",
            
                        "SearchRequest": {
                            "ReferenceId": "1",
                            "ProductName": "SearchLite",
                            "MaxReturn": "1",
                            "Filters": [
                             
                                {
                                    "FilterName": "LotAcreage",
                                    "FilterOperator": "is between",
                                    "FilterValues": [
                                        10,
                                        15
                                    ]
                                },
                                {
                                    "FilterName": "StateFips",
                                    "FilterOperator": "is",
                                    "FilterValues": [
                                        "' . $st . '"
                                    ],
                                    "FilterGroup": 1
                                },
                                {
                                    "FilterName": "CountyFips",
                                    "FilterOperator": "is",
                                    "FilterValues": [
                                        ' . $cp . '
                                    ],
                                    "FilterGroup": 1
                                },
                                {
                                    "FilterName": "SalePrice",
            
                                    "FilterOperator": "is between",
            
                                    "FilterValues": ["1", "10000000"],
            
                                    "FilterGroup": 1
            
                                },
                                
                            ] //
                        } //
                    }',
            ]);
            $d2 = json_decode($res2->getBody(), true);
            $res3 = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $authenticate,
                ],
                'body' => '{
                        "ProductNames": [
                            "SalesComparables"
                        ],
                        "SearchType": "Filter",
            
                        "SearchRequest": {
                            "ReferenceId": "1",
                            "ProductName": "SearchLite",
                            "MaxReturn": "1",
                            "Filters": [
                             
                                {
                                    "FilterName": "LotAcreage",
                                    "FilterOperator": "is between",
                                    "FilterValues": [
                                        15,
                                        20
                                    ]
                                },
                                {
                                    "FilterName": "StateFips",
                                    "FilterOperator": "is",
                                    "FilterValues": [
                                        "' . $st . '"
                                    ],
                                    "FilterGroup": 1
                                },
                                {
                                    "FilterName": "CountyFips",
                                    "FilterOperator": "is",
                                    "FilterValues": [
                                        ' . $cp . '
                                    ],
                                    "FilterGroup": 1
                                },
                                {
                                    "FilterName": "SalePrice",
            
                                    "FilterOperator": "is between",
            
                                    "FilterValues": ["1", "10000000"],
            
                                    "FilterGroup": 1
            
                                },
                                
                            ] //
                        } //
                    }',
            ]);
            $d3 = json_decode($res3->getBody(), true);
            $res4 = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $authenticate,
                ],
                'body' => '{
                        "ProductNames": [
                            "SalesComparables"
                        ],
                        "SearchType": "Filter",
            
                        "SearchRequest": {
                            "ReferenceId": "1",
                            "ProductName": "SearchLite",
                            "MaxReturn": "1",
                            "Filters": [
                             
                                {
                                    "FilterName": "LotAcreage",
                                    "FilterOperator": "is between",
                                    "FilterValues": [
                                        20,
                                        25
                                    ]
                                },
                                {
                                    "FilterName": "StateFips",
                                    "FilterOperator": "is",
                                    "FilterValues": [
                                        "' . $st . '"
                                    ],
                                    "FilterGroup": 1
                                },
                                {
                                    "FilterName": "CountyFips",
                                    "FilterOperator": "is",
                                    "FilterValues": [
                                        ' . $cp . '
                                    ],
                                    "FilterGroup": 1
                                },
                                {
                                    "FilterName": "SalePrice",
            
                                    "FilterOperator": "is between",
            
                                    "FilterValues": ["1", "10000000"],
            
                                    "FilterGroup": 1
            
                                },
                                
                            ] //
                        } //
                    }',
            ]);
            $d4 = json_decode($res4->getBody(), true);
            $res5 = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $authenticate,
                ],
                'body' => '{
                        "ProductNames": [
                            "SalesComparables"
                        ],
                        "SearchType": "Filter",
            
                        "SearchRequest": {
                            "ReferenceId": "1",
                            "ProductName": "SearchLite",
                            "MaxReturn": "1",
                            "Filters": [
                             
                                {
                                    "FilterName": "LotAcreage",
                                    "FilterOperator": "is between",
                                    "FilterValues": [
                                        25,
                                        30
                                    ]
                                },
                                {
                                    "FilterName": "StateFips",
                                    "FilterOperator": "is",
                                    "FilterValues": [
                                        "' . $st . '"
                                    ],
                                    "FilterGroup": 1
                                },
                                {
                                    "FilterName": "CountyFips",
                                    "FilterOperator": "is",
                                    "FilterValues": [
                                        ' . $cp . '
                                    ],
                                    "FilterGroup": 1
                                },
                                {
                                    "FilterName": "SalePrice",
            
                                    "FilterOperator": "is between",
            
                                    "FilterValues": ["1", "10000000"],
            
                                    "FilterGroup": 1
            
                                },
                                
                            ] //
                        } //
                    }',
            ]);
            $d5 = json_decode($res5->getBody(), true);
            $res6 = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $authenticate,
                ],
                'body' => '{
                        "ProductNames": [
                            "SalesComparables"
                        ],
                        "SearchType": "Filter",
            
                        "SearchRequest": {
                            "ReferenceId": "1",
                            "ProductName": "SearchLite",
                            "MaxReturn": "1",
                            "Filters": [
                             
                                {
                                    "FilterName": "LotAcreage",
                                    "FilterOperator": "is between",
                                    "FilterValues": [
                                        30,
                                        35
                                    ]
                                },
                                {
                                    "FilterName": "StateFips",
                                    "FilterOperator": "is",
                                    "FilterValues": [
                                        "' . $st . '"
                                    ],
                                    "FilterGroup": 1
                                },
                                {
                                    "FilterName": "CountyFips",
                                    "FilterOperator": "is",
                                    "FilterValues": [
                                        ' . $cp . '
                                    ],
                                    "FilterGroup": 1
                                },
                                {
                                    "FilterName": "SalePrice",
            
                                    "FilterOperator": "is between",
            
                                    "FilterValues": ["1", "10000000"],
            
                                    "FilterGroup": 1
            
                                },
                                
                            ] //
                        } //
                    }',
            ]);
            $d6 = json_decode($res6->getBody(), true);
            $res7 = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $authenticate,
                ],
                'body' => '{
                        "ProductNames": [
                            "SalesComparables"
                        ],
                        "SearchType": "Filter",
            
                        "SearchRequest": {
                            "ReferenceId": "1",
                            "ProductName": "SearchLite",
                            "MaxReturn": "1",
                            "Filters": [
                             
                                {
                                    "FilterName": "LotAcreage",
                                    "FilterOperator": "is between",
                                    "FilterValues": [
                                        35,
                                        40
                                    ]
                                },
                                {
                                    "FilterName": "StateFips",
                                    "FilterOperator": "is",
                                    "FilterValues": [
                                        "' . $st . '"
                                    ],
                                    "FilterGroup": 1
                                },
                                {
                                    "FilterName": "CountyFips",
                                    "FilterOperator": "is",
                                    "FilterValues": [
                                        ' . $cp . '
                                    ],
                                    "FilterGroup": 1
                                },
                                {
                                    "FilterName": "SalePrice",
            
                                    "FilterOperator": "is between",
            
                                    "FilterValues": ["1", "10000000"],
            
                                    "FilterGroup": 1
            
                                },
                                
                            ] //
                        } //
                    }',
            ]);
            $d7 = json_decode($res7->getBody(), true);
            $res8 = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $authenticate,
                ],
                'body' => '{
                        "ProductNames": [
                            "SalesComparables"
                        ],
                        "SearchType": "Filter",
            
                        "SearchRequest": {
                            "ReferenceId": "1",
                            "ProductName": "SearchLite",
                            "MaxReturn": "1",
                            "Filters": [
                             
                                {
                                    "FilterName": "LotAcreage",
                                    "FilterOperator": "is between",
                                    "FilterValues": [
                                        40,
                                        45
                                    ]
                                },
                                {
                                    "FilterName": "StateFips",
                                    "FilterOperator": "is",
                                    "FilterValues": [
                                        "' . $st . '"
                                    ],
                                    "FilterGroup": 1
                                },
                                {
                                    "FilterName": "CountyFips",
                                    "FilterOperator": "is",
                                    "FilterValues": [
                                        ' . $cp . '
                                    ],
                                    "FilterGroup": 1
                                },
                                {
                                    "FilterName": "SalePrice",
            
                                    "FilterOperator": "is between",
            
                                    "FilterValues": ["1", "10000000"],
            
                                    "FilterGroup": 1
            
                                },
                                
                            ] //
                        } //
                    }',
            ]);
            $d8 = json_decode($res8->getBody(), true);
            $res9 = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $authenticate,
                ],
                'body' => '{
                        "ProductNames": [
                            "SalesComparables"
                        ],
                        "SearchType": "Filter",
            
                        "SearchRequest": {
                            "ReferenceId": "1",
                            "ProductName": "SearchLite",
                            "MaxReturn": "1",
                            "Filters": [
                             
                                {
                                    "FilterName": "LotAcreage",
                                    "FilterOperator": "is between",
                                    "FilterValues": [
                                        45,
                                        50
                                    ]
                                },
                                {
                                    "FilterName": "StateFips",
                                    "FilterOperator": "is",
                                    "FilterValues": [
                                        "' . $st . '"
                                    ],
                                    "FilterGroup": 1
                                },
                                {
                                    "FilterName": "CountyFips",
                                    "FilterOperator": "is",
                                    "FilterValues": [
                                        ' . $cp . '
                                    ],
                                    "FilterGroup": 1
                                },
                                {
                                    "FilterName": "SalePrice",
            
                                    "FilterOperator": "is between",
            
                                    "FilterValues": ["1", "10000000"],
            
                                    "FilterGroup": 1
            
                                },
                                
                            ] //
                        } //
                    }',
            ]);
            $d9 = json_decode($res9->getBody(), true);
            $res10 = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $authenticate,
                ],
                'body' => '{
                        "ProductNames": [
                            "SalesComparables"
                        ],
                        "SearchType": "Filter",
            
                        "SearchRequest": {
                            "ReferenceId": "1",
                            "ProductName": "SearchLite",
                            "MaxReturn": "1",
                            "Filters": [
                             
                                {
                                    "FilterName": "LotAcreage",
                                    "FilterOperator": "is between",
                                    "FilterValues": [
                                        50,
                                        55
                                    ]
                                },
                                {
                                    "FilterName": "StateFips",
                                    "FilterOperator": "is",
                                    "FilterValues": [
                                        "' . $st . '"
                                    ],
                                    "FilterGroup": 1
                                },
                                {
                                    "FilterName": "CountyFips",
                                    "FilterOperator": "is",
                                    "FilterValues": [
                                        ' . $cp . '
                                    ],
                                    "FilterGroup": 1
                                },
                                {
                                    "FilterName": "SalePrice",
            
                                    "FilterOperator": "is between",
            
                                    "FilterValues": ["1", "10000000"],
            
                                    "FilterGroup": 1
            
                                },
                                
                            ] //
                        } //
                    }',
            ]);
            $d10 = json_decode($res10->getBody(), true);
            $res11 = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $authenticate,
                ],
                'body' => '{
                        "ProductNames": [
                            "SalesComparables"
                        ],
                        "SearchType": "Filter",
            
                        "SearchRequest": {
                            "ReferenceId": "1",
                            "ProductName": "SearchLite",
                            "MaxReturn": "1",
                            "Filters": [
                             
                                {
                                    "FilterName": "LotAcreage",
                                    "FilterOperator": "is between",
                                    "FilterValues": [
                                        55,
                                        60
                                    ]
                                },
                                {
                                    "FilterName": "StateFips",
                                    "FilterOperator": "is",
                                    "FilterValues": [
                                        "' . $st . '"
                                    ],
                                    "FilterGroup": 1
                                },
                                {
                                    "FilterName": "CountyFips",
                                    "FilterOperator": "is",
                                    "FilterValues": [
                                        ' . $cp . '
                                    ],
                                    "FilterGroup": 1
                                },
                                {
                                    "FilterName": "SalePrice",
            
                                    "FilterOperator": "is between",
            
                                    "FilterValues": ["1", "10000000"],
            
                                    "FilterGroup": 1
            
                                },
                                
                            ] //
                        } //
                    }',
            ]);
            $d11 = json_decode($res11->getBody(), true);
            $res12 = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $authenticate,
                ],
                'body' => '{
                        "ProductNames": [
                            "SalesComparables"
                        ],
                        "SearchType": "Filter",
            
                        "SearchRequest": {
                            "ReferenceId": "1",
                            "ProductName": "SearchLite",
                            "MaxReturn": "1",
                            "Filters": [
                             
                                {
                                    "FilterName": "LotAcreage",
                                    "FilterOperator": "is between",
                                    "FilterValues": [
                                        60,
                                        65
                                    ]
                                },
                                {
                                    "FilterName": "StateFips",
                                    "FilterOperator": "is",
                                    "FilterValues": [
                                        "' . $st . '"
                                    ],
                                    "FilterGroup": 1
                                },
                                {
                                    "FilterName": "CountyFips",
                                    "FilterOperator": "is",
                                    "FilterValues": [
                                        ' . $cp . '
                                    ],
                                    "FilterGroup": 1
                                },
                                {
                                    "FilterName": "SalePrice",
            
                                    "FilterOperator": "is between",
            
                                    "FilterValues": ["1", "10000000"],
            
                                    "FilterGroup": 1
            
                                },
                                
                            ] //
                        } //
                    }',
            ]);
            $d12 = json_decode($res12->getBody(), true);
            $res13 = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $authenticate,
                ],
                'body' => '{
                        "ProductNames": [
                            "SalesComparables"
                        ],
                        "SearchType": "Filter",
            
                        "SearchRequest": {
                            "ReferenceId": "1",
                            "ProductName": "SearchLite",
                            "MaxReturn": "1",
                            "Filters": [
                             
                                {
                                    "FilterName": "LotAcreage",
                                    "FilterOperator": "is between",
                                    "FilterValues": [
                                        65,
                                        70
                                    ]
                                },
                                {
                                    "FilterName": "StateFips",
                                    "FilterOperator": "is",
                                    "FilterValues": [
                                        "' . $st . '"
                                    ],
                                    "FilterGroup": 1
                                },
                                {
                                    "FilterName": "CountyFips",
                                    "FilterOperator": "is",
                                    "FilterValues": [
                                        ' . $cp . '
                                    ],
                                    "FilterGroup": 1
                                },
                                {
                                    "FilterName": "SalePrice",
            
                                    "FilterOperator": "is between",
            
                                    "FilterValues": ["1", "10000000"],
            
                                    "FilterGroup": 1
            
                                },
                                
                            ] //
                        } //
                    }',
            ]);
            $d13 = json_decode($res13->getBody(), true);
            $res14 = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $authenticate,
                ],
                'body' => '{
                        "ProductNames": [
                            "SalesComparables"
                        ],
                        "SearchType": "Filter",
            
                        "SearchRequest": {
                            "ReferenceId": "1",
                            "ProductName": "SearchLite",
                            "MaxReturn": "1",
                            "Filters": [
                             
                                {
                                    "FilterName": "LotAcreage",
                                    "FilterOperator": "is between",
                                    "FilterValues": [
                                        70,
                                        75
                                    ]
                                },
                                {
                                    "FilterName": "StateFips",
                                    "FilterOperator": "is",
                                    "FilterValues": [
                                        "' . $st . '"
                                    ],
                                    "FilterGroup": 1
                                },
                                {
                                    "FilterName": "CountyFips",
                                    "FilterOperator": "is",
                                    "FilterValues": [
                                        ' . $cp . '
                                    ],
                                    "FilterGroup": 1
                                },
                                {
                                    "FilterName": "SalePrice",
            
                                    "FilterOperator": "is between",
            
                                    "FilterValues": ["1", "10000000"],
            
                                    "FilterGroup": 1
            
                                },
                                
                            ] //
                        } //
                    }',
            ]);
            $d14 = json_decode($res14->getBody(), true);
            $res15 = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $authenticate,
                ],
                'body' => '{
                        "ProductNames": [
                            "SalesComparables"
                        ],
                        "SearchType": "Filter",
            
                        "SearchRequest": {
                            "ReferenceId": "1",
                            "ProductName": "SearchLite",
                            "MaxReturn": "1",
                            "Filters": [
                             
                                {
                                    "FilterName": "LotAcreage",
                                    "FilterOperator": "is between",
                                    "FilterValues": [
                                        75,
                                        80
                                    ]
                                },
                                {
                                    "FilterName": "StateFips",
                                    "FilterOperator": "is",
                                    "FilterValues": [
                                        "' . $st . '"
                                    ],
                                    "FilterGroup": 1
                                },
                                {
                                    "FilterName": "CountyFips",
                                    "FilterOperator": "is",
                                    "FilterValues": [
                                        ' . $cp . '
                                    ],
                                    "FilterGroup": 1
                                },
                                {
                                    "FilterName": "SalePrice",
            
                                    "FilterOperator": "is between",
            
                                    "FilterValues": ["1", "10000000"],
            
                                    "FilterGroup": 1
            
                                },
                                
                            ] //
                        } //
                    }',
            ]);
            $d15 = json_decode($res15->getBody(), true);

            $res16 = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $authenticate,
                ],
                'body' => '{
                        "ProductNames": [
                            "SalesComparables"
                        ],
                        "SearchType": "Filter",
            
                        "SearchRequest": {
                            "ReferenceId": "1",
                            "ProductName": "SearchLite",
                            "MaxReturn": "1",
                            "Filters": [
                             
                                {
                                    "FilterName": "LotAcreage",
                                    "FilterOperator": "is between",
                                    "FilterValues": [
                                        80,
                                        85
                                    ]
                                },
                                {
                                    "FilterName": "StateFips",
                                    "FilterOperator": "is",
                                    "FilterValues": [
                                        "' . $st . '"
                                    ],
                                    "FilterGroup": 1
                                },
                                {
                                    "FilterName": "CountyFips",
                                    "FilterOperator": "is",
                                    "FilterValues": [
                                        ' . $cp . '
                                    ],
                                    "FilterGroup": 1
                                },
                                {
                                    "FilterName": "SalePrice",
            
                                    "FilterOperator": "is between",
            
                                    "FilterValues": ["1", "10000000"],
            
                                    "FilterGroup": 1
            
                                },
                                
                            ] //
                        } //
                    }',
            ]);
            $d16 = json_decode($res16->getBody(), true);
            $res17 = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $authenticate,
                ],
                'body' => '{
                        "ProductNames": [
                            "SalesComparables"
                        ],
                        "SearchType": "Filter",
            
                        "SearchRequest": {
                            "ReferenceId": "1",
                            "ProductName": "SearchLite",
                            "MaxReturn": "1",
                            "Filters": [
                             
                                {
                                    "FilterName": "LotAcreage",
                                    "FilterOperator": "is between",
                                    "FilterValues": [
                                        85,
                                        90
                                    ]
                                },
                                {
                                    "FilterName": "StateFips",
                                    "FilterOperator": "is",
                                    "FilterValues": [
                                        "' . $st . '"
                                    ],
                                    "FilterGroup": 1
                                },
                                {
                                    "FilterName": "CountyFips",
                                    "FilterOperator": "is",
                                    "FilterValues": [
                                        ' . $cp . '
                                    ],
                                    "FilterGroup": 1
                                },
                                {
                                    "FilterName": "SalePrice",
            
                                    "FilterOperator": "is between",
            
                                    "FilterValues": ["1", "10000000"],
            
                                    "FilterGroup": 1
            
                                },
                                
                            ] //
                        } //
                    }',
            ]);
            $d17 = json_decode($res17->getBody(), true);
            $res18 = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $authenticate,
                ],
                'body' => '{
                        "ProductNames": [
                            "SalesComparables"
                        ],
                        "SearchType": "Filter",
            
                        "SearchRequest": {
                            "ReferenceId": "1",
                            "ProductName": "SearchLite",
                            "MaxReturn": "1",
                            "Filters": [
                             
                                {
                                    "FilterName": "LotAcreage",
                                    "FilterOperator": "is between",
                                    "FilterValues": [
                                        90,
                                        95
                                    ]
                                },
                                {
                                    "FilterName": "StateFips",
                                    "FilterOperator": "is",
                                    "FilterValues": [
                                        "' . $st . '"
                                    ],
                                    "FilterGroup": 1
                                },
                                {
                                    "FilterName": "CountyFips",
                                    "FilterOperator": "is",
                                    "FilterValues": [
                                        ' . $cp . '
                                    ],
                                    "FilterGroup": 1
                                },
                                {
                                    "FilterName": "SalePrice",
            
                                    "FilterOperator": "is between",
            
                                    "FilterValues": ["1", "10000000"],
            
                                    "FilterGroup": 1
            
                                },
                                
                            ] //
                        } //
                    }',
            ]);
            $d18 = json_decode($res18->getBody(), true);
            //dd($data_st['res1']);
            $data = [
                'res0' => $d0,
                'res1' => $d1,
                'res2' => $d2,
                'res3' => $d3,
                'res4' => $d4,
                'res5' => $d5,
                'res6' => $d6,
                'res7' => $d7,
                'res8' => $d8,
                'res9' => $d9,
                'res10' => $d10,
                'res11' => $d11,
                'res12' => $d12,
                'res13' => $d13,
                'res14' => $d14,
                'res15' => $d15,
                'res16' => $d16,
                'res17' => $d17,
                'res18' => $d18,
            ];
            //dd($data);

            //$maxcount = $data[0]['MaxResultsCount'];
            //$acr_range = $acr1 . '-' . $acr2;
            //$acr_range = $info[$i] . '-' . $info[$i+1];
            $pd1 = isset($data['res0']['LitePropertyList'][0]['PropertyId']) ? $data['res0']['LitePropertyList'][0]['PropertyId'] : 0;
            $pd2 = isset($data['res1']['LitePropertyList'][0]['PropertyId']) ? $data['res1']['LitePropertyList'][0]['PropertyId'] : 0;
            $pd3 = isset($data['res2']['LitePropertyList'][0]['PropertyId']) ? $data['res2']['LitePropertyList'][0]['PropertyId'] : 0;
            $pd4 = isset($data['res3']['LitePropertyList'][0]['PropertyId']) ? $data['res3']['LitePropertyList'][0]['PropertyId'] : 0;
            $pd5 = isset($data['res4']['LitePropertyList'][0]['PropertyId']) ? $data['res4']['LitePropertyList'][0]['PropertyId'] : 0;
            $pd6 = isset($data['res5']['LitePropertyList'][0]['PropertyId']) ? $data['res5']['LitePropertyList'][0]['PropertyId'] : 0;
            $pd7 = isset($data['res6']['LitePropertyList'][0]['PropertyId']) ? $data['res6']['LitePropertyList'][0]['PropertyId'] : 0;
            $pd8 = isset($data['res7']['LitePropertyList'][0]['PropertyId']) ? $data['res7']['LitePropertyList'][0]['PropertyId'] : 0;
            $pd9 = isset($data['res8']['LitePropertyList'][0]['PropertyId']) ? $data['res8']['LitePropertyList'][0]['PropertyId'] : 0;
            $pd10 = isset($data['res9']['LitePropertyList'][0]['PropertyId']) ? $data['res9']['LitePropertyList'][0]['PropertyId'] : 0;
            $pd11 = isset($data['res10']['LitePropertyList'][0]['PropertyId']) ? $data['res10']['LitePropertyList'][0]['PropertyId'] : 0;
            $pd12 = isset($data['res11']['LitePropertyList'][0]['PropertyId']) ? $data['res11']['LitePropertyList'][0]['PropertyId'] : 0;
            $pd13 = isset($data['res12']['LitePropertyList'][0]['PropertyId']) ? $data['res12']['LitePropertyList'][0]['PropertyId'] : 0;
            $pd14 = isset($data['res13']['LitePropertyList'][0]['PropertyId']) ? $data['res13']['LitePropertyList'][0]['PropertyId'] : 0;
            $pd15 = isset($data['res14']['LitePropertyList'][0]['PropertyId']) ? $data['res14']['LitePropertyList'][0]['PropertyId'] : 0;
            $pd16 = isset($data['res15']['LitePropertyList'][0]['PropertyId']) ? $data['res15']['LitePropertyList'][0]['PropertyId'] : 0;
            $pd17 = isset($data['res16']['LitePropertyList'][0]['PropertyId']) ? $data['res16']['LitePropertyList'][0]['PropertyId'] : 0;
            $pd18 = isset($data['res17']['LitePropertyList'][0]['PropertyId']) ? $data['res17']['LitePropertyList'][0]['PropertyId'] : 0;
            $pd19 = isset($data['res18']['LitePropertyList'][0]['PropertyId']) ? $data['res18']['LitePropertyList'][0]['PropertyId'] : 0;

            $p_id = [
                's1' => $pd1,
                's2' => $pd1,
                's3' => $pd2,
                's4' => $pd3,
                's5' => $pd4,
                's6' => $pd5,
                's7' => $pd6,
                's8' => $pd7,
                's9' => $pd8,
                's10' => $pd9,
                's11' => $pd10,
                's12' => $pd11,
                's13' => $pd12,
                's14' => $pd13,
                's15' => $pd14,
                's16' => $pd15,
                's17' => $pd16,
                's18' => $pd17,
                's19' => $pd18,
                's20' => $pd19
            ];
            //dd($p_id);
            //$loop = $data[0]['LitePropertyList'];
            if ($p_id['s1'] != 0) {
                $getProperty0 = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
                    'headers' => [
                        'Accept' => 'application/json',
                        'Content-Type' => 'application/json',
                        'Authorization' => 'Bearer ' . $authenticate,
                    ],
                    'body' => json_encode([
                        'ProductNames' => ['PropertyDetailReport'],

                        "SearchType" => "PROPERTY",
                        "PropertyId" => $p_id['s1']
                    ]),
                ]);

                $price0 = json_decode($getProperty0->getBody(), true);
            }
            if ($p_id['s2'] != 0) {
                $getProperty1 = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
                    'headers' => [
                        'Accept' => 'application/json',
                        'Content-Type' => 'application/json',
                        'Authorization' => 'Bearer ' . $authenticate,
                    ],
                    'body' => json_encode([
                        'ProductNames' => ['PropertyDetailReport'],

                        "SearchType" => "PROPERTY",
                        "PropertyId" => $p_id['s2']
                    ]),
                ]);


                $price1 = json_decode($getProperty1->getBody(), true);
            }
            if ($p_id['s3'] != 0) {
                $getProperty2 = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
                    'headers' => [
                        'Accept' => 'application/json',
                        'Content-Type' => 'application/json',
                        'Authorization' => 'Bearer ' . $authenticate,
                    ],
                    'body' => json_encode([
                        'ProductNames' => ['PropertyDetailReport'],

                        "SearchType" => "PROPERTY",
                        "PropertyId" => $p_id['s3']
                    ]),
                ]);

                $price2 = json_decode($getProperty2->getBody(), true);
            }
            if ($p_id['s4'] != 0) {
                $getProperty3 = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
                    'headers' => [
                        'Accept' => 'application/json',
                        'Content-Type' => 'application/json',
                        'Authorization' => 'Bearer ' . $authenticate,
                    ],
                    'body' => json_encode([
                        'ProductNames' => ['PropertyDetailReport'],

                        "SearchType" => "PROPERTY",
                        "PropertyId" => $p_id['s4']
                    ]),
                ]);

                $price3 = json_decode($getProperty3->getBody(), true);
            }
            if ($p_id['s5'] != 0) {
                $getProperty4 = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
                    'headers' => [
                        'Accept' => 'application/json',
                        'Content-Type' => 'application/json',
                        'Authorization' => 'Bearer ' . $authenticate,
                    ],
                    'body' => json_encode([
                        'ProductNames' => ['PropertyDetailReport'],

                        "SearchType" => "PROPERTY",
                        "PropertyId" => $p_id['s5']
                    ]),
                ]);

                $price4 = json_decode($getProperty4->getBody(), true);
            }
            if ($p_id['s6'] != 0) {
                $getProperty5 = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
                    'headers' => [
                        'Accept' => 'application/json',
                        'Content-Type' => 'application/json',
                        'Authorization' => 'Bearer ' . $authenticate,
                    ],
                    'body' => json_encode([
                        'ProductNames' => ['PropertyDetailReport'],

                        "SearchType" => "PROPERTY",
                        "PropertyId" => $p_id['s6']
                    ]),
                ]);

                $price5 = json_decode($getProperty5->getBody(), true);
            }
            if ($p_id['s7'] != 0) {
                $getProperty6 = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
                    'headers' => [
                        'Accept' => 'application/json',
                        'Content-Type' => 'application/json',
                        'Authorization' => 'Bearer ' . $authenticate,
                    ],
                    'body' => json_encode([
                        'ProductNames' => ['PropertyDetailReport'],

                        "SearchType" => "PROPERTY",
                        "PropertyId" => $p_id['s7']
                    ]),
                ]);

                $price6 = json_decode($getProperty6->getBody(), true);
            }
            if ($p_id['s8'] != 0) {

                $getProperty7 = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
                    'headers' => [
                        'Accept' => 'application/json',
                        'Content-Type' => 'application/json',
                        'Authorization' => 'Bearer ' . $authenticate,
                    ],
                    'body' => json_encode([
                        'ProductNames' => ['PropertyDetailReport'],

                        "SearchType" => "PROPERTY",
                        "PropertyId" => $p_id['s8']
                    ]),
                ]);

                $price7 = json_decode($getProperty7->getBody(), true);
            }
            if ($p_id['s9'] != 0) {
                $getProperty8 = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
                    'headers' => [
                        'Accept' => 'application/json',
                        'Content-Type' => 'application/json',
                        'Authorization' => 'Bearer ' . $authenticate,
                    ],
                    'body' => json_encode([
                        'ProductNames' => ['PropertyDetailReport'],

                        "SearchType" => "PROPERTY",
                        "PropertyId" => $p_id['s9']
                    ]),
                ]);

                $price8 = json_decode($getProperty8->getBody(), true);
            }
            if ($p_id['s10'] != 0) {
                $getProperty9 = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
                    'headers' => [
                        'Accept' => 'application/json',
                        'Content-Type' => 'application/json',
                        'Authorization' => 'Bearer ' . $authenticate,
                    ],
                    'body' => json_encode([
                        'ProductNames' => ['PropertyDetailReport'],

                        "SearchType" => "PROPERTY",
                        "PropertyId" => $p_id['s10']
                    ]),
                ]);

                $price9 = json_decode($getProperty9->getBody(), true);
            }
            if ($p_id['s11'] != 0) {
                $getProperty10 = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
                    'headers' => [
                        'Accept' => 'application/json',
                        'Content-Type' => 'application/json',
                        'Authorization' => 'Bearer ' . $authenticate,
                    ],
                    'body' => json_encode([
                        'ProductNames' => ['PropertyDetailReport'],

                        "SearchType" => "PROPERTY",
                        "PropertyId" => $p_id['s11']
                    ]),
                ]);

                $price10 = json_decode($getProperty10->getBody(), true);
            }
            if ($p_id['s12'] != 0) {
                $getProperty11 = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
                    'headers' => [
                        'Accept' => 'application/json',
                        'Content-Type' => 'application/json',
                        'Authorization' => 'Bearer ' . $authenticate,
                    ],
                    'body' => json_encode([
                        'ProductNames' => ['PropertyDetailReport'],

                        "SearchType" => "PROPERTY",
                        "PropertyId" => $p_id['s12']
                    ]),
                ]);

                $price11 = json_decode($getProperty11->getBody(), true);
            }
            if ($p_id['s13'] != 0) {
                $getProperty12 = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
                    'headers' => [
                        'Accept' => 'application/json',
                        'Content-Type' => 'application/json',
                        'Authorization' => 'Bearer ' . $authenticate,
                    ],
                    'body' => json_encode([
                        'ProductNames' => ['PropertyDetailReport'],

                        "SearchType" => "PROPERTY",
                        "PropertyId" => $p_id['s13']
                    ]),
                ]);

                $price12 = json_decode($getProperty12->getBody(), true);
            }
            if ($p_id['s14'] != 0) {
                $getProperty13 = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
                    'headers' => [
                        'Accept' => 'application/json',
                        'Content-Type' => 'application/json',
                        'Authorization' => 'Bearer ' . $authenticate,
                    ],
                    'body' => json_encode([
                        'ProductNames' => ['PropertyDetailReport'],

                        "SearchType" => "PROPERTY",
                        "PropertyId" => $p_id['s14']
                    ]),
                ]);
                $price13 = json_decode($getProperty13->getBody(), true);
            }
            if ($p_id['s15'] != 0) {

                $getProperty14 = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
                    'headers' => [
                        'Accept' => 'application/json',
                        'Content-Type' => 'application/json',
                        'Authorization' => 'Bearer ' . $authenticate,
                    ],
                    'body' => json_encode([
                        'ProductNames' => ['PropertyDetailReport'],

                        "SearchType" => "PROPERTY",
                        "PropertyId" => $p_id['s15']
                    ]),
                ]);

                $price14 = json_decode($getProperty14->getBody(), true);
            }
            //dd($p_id['s16']);
            if ($p_id['s16'] != 0) {
                $getProperty15 = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
                    'headers' => [
                        'Accept' => 'application/json',
                        'Content-Type' => 'application/json',
                        'Authorization' => 'Bearer ' . $authenticate,
                    ],
                    'body' => json_encode([
                        'ProductNames' => ['PropertyDetailReport'],

                        "SearchType" => "PROPERTY",
                        "PropertyId" => $p_id['s16']
                    ]),
                ]);
                $price15 = json_decode($getProperty15->getBody(), true);
            }
            if ($p_id['s17'] != 0) {

                $getProperty16 = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
                    'headers' => [
                        'Accept' => 'application/json',
                        'Content-Type' => 'application/json',
                        'Authorization' => 'Bearer ' . $authenticate,
                    ],
                    'body' => json_encode([
                        'ProductNames' => ['PropertyDetailReport'],

                        "SearchType" => "PROPERTY",
                        "PropertyId" => $p_id['s17']
                    ]),
                ]);

                $price16 = json_decode($getProperty16->getBody(), true);
            }
            if ($p_id['s18'] != 0) {
                $getProperty17 = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
                    'headers' => [
                        'Accept' => 'application/json',
                        'Content-Type' => 'application/json',
                        'Authorization' => 'Bearer ' . $authenticate,
                    ],
                    'body' => json_encode([
                        'ProductNames' => ['PropertyDetailReport'],

                        "SearchType" => "PROPERTY",
                        "PropertyId" => $p_id['s18']
                    ]),
                ]);
                $price17 = json_decode($getProperty17->getBody(), true);
            }
            if ($p_id['s19'] != 0) {

                $getProperty18 = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
                    'headers' => [
                        'Accept' => 'application/json',
                        'Content-Type' => 'application/json',
                        'Authorization' => 'Bearer ' . $authenticate,
                    ],
                    'body' => json_encode([
                        'ProductNames' => ['PropertyDetailReport'],

                        "SearchType" => "PROPERTY",
                        "PropertyId" => $p_id['s19']
                    ]),
                ]);
                $price18 = json_decode($getProperty18->getBody(), true);
            }
            $sp1 = isset($price0['Reports'][0]['Data']['LastMarketSaleInformation']['SalePrice']) ? $price0['Reports'][0]['Data']['LastMarketSaleInformation']['SalePrice'] : 0;
            $sp2 = isset($price1['Reports'][0]['Data']['LastMarketSaleInformation']['SalePrice']) ? $price1['Reports'][0]['Data']['LastMarketSaleInformation']['SalePrice'] : 0;
            $sp3 = isset($price2['Reports'][0]['Data']['LastMarketSaleInformation']['SalePrice']) ? $price2['Reports'][0]['Data']['LastMarketSaleInformation']['SalePrice'] : 0;
            $sp4 = isset($price3['Reports'][0]['Data']['LastMarketSaleInformation']['SalePrice']) ? $price3['Reports'][0]['Data']['LastMarketSaleInformation']['SalePrice'] : 0;
            $sp5 = isset($price4['Reports'][0]['Data']['LastMarketSaleInformation']['SalePrice']) ? $price4['Reports'][0]['Data']['LastMarketSaleInformation']['SalePrice'] : 0;
            $sp6 = isset($price5['Reports'][0]['Data']['LastMarketSaleInformation']['SalePrice']) ? $price5['Reports'][0]['Data']['LastMarketSaleInformation']['SalePrice'] : 0;
            $sp7 = isset($price6['Reports'][0]['Data']['LastMarketSaleInformation']['SalePrice']) ? $price6['Reports'][0]['Data']['LastMarketSaleInformation']['SalePrice'] : 0;
            $sp8 = isset($price7['Reports'][0]['Data']['LastMarketSaleInformation']['SalePrice']) ? $price7['Reports'][0]['Data']['LastMarketSaleInformation']['SalePrice'] : 0;
            $sp9 = isset($price8['Reports'][0]['Data']['LastMarketSaleInformation']['SalePrice']) ? $price8['Reports'][0]['Data']['LastMarketSaleInformation']['SalePrice'] : 0;
            $sp10 = isset($price9['Reports'][0]['Data']['LastMarketSaleInformation']['SalePrice']) ? $price9['Reports'][0]['Data']['LastMarketSaleInformation']['SalePrice'] : 0;
            $sp11 = isset($price10['Reports'][0]['Data']['LastMarketSaleInformation']['SalePrice']) ? $price10['Reports'][0]['Data']['LastMarketSaleInformation']['SalePrice'] : 0;
            $sp12 = isset($price11['Reports'][0]['Data']['LastMarketSaleInformation']['SalePrice']) ? $price11['Reports'][0]['Data']['LastMarketSaleInformation']['SalePrice'] : 0;
            $sp13 = isset($price12['Reports'][0]['Data']['LastMarketSaleInformation']['SalePrice']) ? $price12['Reports'][0]['Data']['LastMarketSaleInformation']['SalePrice'] : 0;
            $sp14 = isset($price13['Reports'][0]['Data']['LastMarketSaleInformation']['SalePrice']) ? $price13['Reports'][0]['Data']['LastMarketSaleInformation']['SalePrice'] : 0;
            $sp15 = isset($price14['Reports'][0]['Data']['LastMarketSaleInformation']['SalePrice']) ? $price14['Reports'][0]['Data']['LastMarketSaleInformation']['SalePrice'] : 0;
            $sp16 = isset($price15['Reports'][0]['Data']['LastMarketSaleInformation']['SalePrice']) ? $price15['Reports'][0]['Data']['LastMarketSaleInformation']['SalePrice'] : 0;
            $sp17 = isset($price16['Reports'][0]['Data']['LastMarketSaleInformation']['SalePrice']) ? $price16['Reports'][0]['Data']['LastMarketSaleInformation']['SalePrice'] : 0;
            $sp18 = isset($price17['Reports'][0]['Data']['LastMarketSaleInformation']['SalePrice']) ? $price17['Reports'][0]['Data']['LastMarketSaleInformation']['SalePrice'] : 0;
            $sp19 = isset($price18['Reports'][0]['Data']['LastMarketSaleInformation']['SalePrice']) ? $price18['Reports'][0]['Data']['LastMarketSaleInformation']['SalePrice'] : 0;

            $sale_price[] = [
                'p0' => $sp1,
                'p1' => $sp2,
                'p2' => $sp3,
                'p3' => $sp4,
                'p4' => $sp5,
                'p5' => $sp6,
                'p6' => $sp7,
                'p7' => $sp8,
                'p8' => $sp9,
                'p9' => $sp10,
                'p10' => $sp11,
                'p11' => $sp12,
                'p12' => $sp13,
                'p13' => $sp14,
                'p14' => $sp15,
                'p15' => $sp16,
                'p16' => $sp17,
                'p17' => $sp18,
                'p18' => $sp19
            ];
            //dd($data);
            $mainval = 1 * 0.01;

            //now get property id sal eprice 
            return view('priceland', compact('mainval', 'data', 'sale_price'));
        } catch (\Exception $e) {
            //throw new HttpException(500, $e->getMessage());
            //dd($e->getMessage());
            $response = $e->getResponse();
            $emsg = $e->getMessage();
            //dd($response);
            $fromserver = 'No records found . or Server error';
            $msg = json_decode($response->getBody()->getContents(), true);
            $error = $msg ? $msg : $fromserver;
            //dd($response['reasonPhrase']);
            return  redirect()->to('priceland')->with('error', $error);
        }
    }
    public function loadHome()
    {
        return view('welcome');
    }
    public function Logout(Request $request)
    {
        try {
            //$request->session()->flush();
            Auth::logout();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false]);
        }
        //return redirect()->to('login2');
    }
    public function pdf_download2(Request $request)
    {
        //return view('test');
        //dd($request->id);
        $client = new GuzzleHttp\Client();
        $login = $client->request('POST', 'https://dtapiuat.datatree.com/api/Login/AuthenticateClient', [
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',

            ],
            'body' => json_encode([
                'ClientId' => config('app.client_id'),
                'ClientSecretKey' => config('app.client_secret')
            ])
        ]);
        $authenticate = json_decode($login->getBody(), true);
        //dd($authenticate);
        try {
            $res = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $authenticate,
                ],
                'body' => json_encode([
                    'ProductNames' => ['PropertyDetailReport'],

                    "SearchType" => "PROPERTY",
                    "PropertyId" => $request->id
                ]),
            ]);
            //get sales comparable
            $sales = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $authenticate,
                ],
                'body' => json_encode([
                    'ProductNames' => ['SalesComparables'],

                    "SearchType" => "PROPERTY",
                    "PropertyId" => $request->id
                ]),
            ]);

            $propertydata = json_decode($res->getBody(), true);
            //dd($propertydata);

            $salesdata = json_decode($sales->getBody(), true);
            $average_county = $salesdata['Reports'][0]['Data']['ComparablePropertiesSummary']['SaleListedPrice']['Low'];
            //dd($salesdata);

            $sum_sale[0] = $this->getJsonArrayElements($salesdata);
            $price[0] = $this->getPrice($salesdata);
            $mar_pr = $price[0][0][0];
            $add_data[0] = $this->getPropertyData($salesdata);
            $total_rc = count($add_data[0]);
            //dd($add_data[0]);
            $zill_acre_avg = (float)($add_data[0][1] / $total_rc);
            $zill_acre_avg_ = (float)($add_data[0][1]);

            $dis_zill = number_format((float)($add_data[0][2] / $total_rc), 2);

            $average_price_river = $sum_sale[0][0];
            //dd($average_price_river);


            //return  $add_data[0][1];

            //get zillow data 
            $zillow_sales = $client->request('GET', 'https://zillow-working-api.p.rapidapi.com/byaddress?propertyaddress=' . $add_data[0][0][0] . '', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    //'Authorization' => 'Bearer ' . $authenticate,
                    'x-rapidapi-host' => 'zillow-working-api.p.rapidapi.com',
                    'x-rapidapi-key' => config('app.rapid_key')
                ],
                'body' => json_encode([
                    'propertyaddress' => '2762 DOWNING Street, Jacksonville, FL 32205'
                ]),
            ]);
            $zillow_data = json_decode($zillow_sales->getBody(), true);
            //dd($zillow_data);
            $zpid = $zillow_data['PropertyZPID'];
            //dd($zpid);

            //get zillow data 
            $zillow_sales_comp = $client->request('GET', 'https://zillow-com1.p.rapidapi.com/similarProperty?zpid=' . $zpid . '', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    //'Authorization' => 'Bearer ' . $authenticate,
                    'x-rapidapi-host' => 'zillow-com1.p.rapidapi.com',
                    'x-rapidapi-key' => config('app.rapid_key')
                ],
                'body' => json_encode([
                    //'propertyaddress' => '2762 DOWNING Street, Jacksonville, FL 32205'
                ]),
            ]);
            $city_red = $add_data[0][3][0];
            //dd($city_red);
            $redfin_sales_comp = $client->request('GET', 'https://redfin-com-data.p.rapidapi.com/properties/auto-complete?query=' . $city_red . '&limit=1', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    //'Authorization' => 'Bearer ' . $authenticate,
                    'x-rapidapi-host' => 'redfin-com-data.p.rapidapi.com',
                    'x-rapidapi-key' => config('app.rapid_key')
                ],
                'body' => json_encode([
                    //'propertyaddress' => '2762 DOWNING Street, Jacksonville, FL 32205'
                ]),
            ]);
            //dd(config('app.rapid_key'));
            $redfin_comp_data = json_decode($redfin_sales_comp->getBody(), true);
            //dd($redfin_comp_data);
            $region_id = $redfin_comp_data['data'][0]['rows'][0]['id'];
            //dd($region_id);
            $redfin_sales_comp = $client->request('GET', 'https://redfin-com-data.p.rapidapi.com/properties/search-sale?regionId=' . $region_id . '&lotSize=10890%2C21780', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    //'Authorization' => 'Bearer ' . $authenticate,
                    'x-rapidapi-host' => 'redfin-com-data.p.rapidapi.com',
                    'x-rapidapi-key' => config('app.rapid_key')
                ],
                'body' => json_encode([
                    //'propertyaddress' => '2762 DOWNING Street, Jacksonville, FL 32205'
                ]),
            ]);
            $redfin_data = json_decode($redfin_sales_comp->getBody(), true);
            //dd($redfin_data);
            $redfin_d = $this->getRedfinData($redfin_data);
            $redfin_d = isset($redfin_d) ? $redfin_d : 0;
            //dd($redfin_d);
            $sum_acre = isset($redfin_d['sum_acre']) ? $redfin_d['sum_acre'] : 0;
            //dd($sum_acre);
            $total_red = isset($redfin_d['p_id']) ? count($redfin_d['p_id']) : 0;
            $total_prce_sum_red = isset($redfin_d['pr_sum']) ? str_replace(',', '', $redfin_d['pr_sum']) : 0;
            if ($sum_acre > 0) {
                $av_acr = number_format($sum_acre / $total_red, 2);
                $avg_sc_r = number_format($total_prce_sum_red / $sum_acre, 2);
                $red_av_ac = number_format($redfin_d['price']/$redfin_d['acre_'],2);
            };

            $av_acre_red = isset($av_acr) ? $av_acr : 0;
            $average_red = isset($redfin_d['pr_sum']) ? number_format($redfin_d['pr_sum'] / $total_red, 2) : 0;

            $avg_per_acre_red = isset($avg_sc_r) ? $avg_sc_r : 0;


            $zillow_comp_data = json_decode($zillow_sales_comp->getBody(), true);
            //dd($zillow_comp_data);

            $total_rec = count($zillow_comp_data);
            //$avg_acr_zll = $this->getZillowData($zillow_comp_data);
            $avg_acr_ll = str_replace(',', '', number_format((float)($this->getZillowData($zillow_comp_data) / $total_rec), 2));
            $avg_acr_ll_ = str_replace(',', '', number_format((float)($this->getZillowData($zillow_comp_data)), 2));
            //dd($avg_acr_ll_);
            $salecount =  $salesdata['Reports'][0]['Data']['ComparableCount'];
            //dd($sum_sale[0][0]);
            $avr_pr = str_replace(',', '', number_format((float)($sum_sale[0][0] / $salecount), 2));
            $geo_adjusted = ($avr_pr * 0.05) - ($avr_pr * 0.03) + ($avr_pr * 0.02) - ($avr_pr * 0.01);
            $geo_adjust_price = $avr_pr + $geo_adjusted;
            $avr_acr = number_format((float)($sum_sale[0][1] / $salecount), 2);
            $county_av = $average_county;
            //dd($county_av);
            $market_av = number_format((float)($county_av / $avr_acr), 2);

            $avr_d = number_format((float)($sum_sale[0][2] / $salecount), 2);
            //return $avr_acr;
            //dd($sum_sale[0][0],$sum_sale[0][1]);
            $aver_per_ac = number_format((float)($sum_sale[0][0] / $sum_sale[0][1]), 2);
            //avg per acre zillow
            //  dd($avg_acr_ll_,$zill_acre_avg_,$sum_sale[0][1]); 
            $av_per_acre_zill = number_format((float)($avg_acr_ll_ / $zill_acre_avg_), 2);
            //dd($city_red);
            $realtor_sales_comp = $client->request('GET', 'https://us-real-estate-listings.p.rapidapi.com/for-sale?location=' . $city_red . '"&offset=0&limit=50&sort=relevance&days_on=1&expand_search_radius=1', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    //'Authorization' => 'Bearer ' . $authenticate,
                    'x-rapidapi-host' => 'us-real-estate-listings.p.rapidapi.com',
                    'x-rapidapi-key' => config('app.rapid_key')
                ],
                'body' => json_encode([
                    //'propertyaddress' => '2762 DOWNING Street, Jacksonville, FL 32205'
                ]),
            ]);

            $realtor = json_decode($realtor_sales_comp->getBody(), true);
            $price_data_real = $this->getRealtorData($realtor);
            $realto_s = isset($realtor['totalResultCount']) ? $realtor['totalResultCount'] : 0;
            //dd($price_data_real);
            if ($realtor['totalResultCount'] > 0) {
                $avg_pr_realtor = str_replace(',', '', number_format($price_data_real['price_sum'] / $realto_s, 2));
                //dd($avg_pr_realtor);
                $avg_ac = number_format($price_data_real['acre_sum'] / $realto_s, 2);
                $av_pr_ac_real = number_format($avg_pr_realtor / $avg_ac, 2);
            }
            //dd($realtor);
            //LastMarketSaleInformation['SalePrice']
            $data = [
                'address' => $propertydata['Reports'][0]['Data']['SubjectProperty']['SitusAddress']['StreetAddress'],
                'city' => $city_red,
                'state' => $propertydata['Reports'][0]['Data']['SubjectProperty']['SitusAddress']['State'],
                'county' => $propertydata['Reports'][0]['Data']['SubjectProperty']['SitusAddress']['County'],
                'apn' => $propertydata['Reports'][0]['Data']['SubjectProperty']['SitusAddress']['APN'],
                'lat' => $propertydata['Reports'][0]['Data']['LocationInformation']['Latitude'],
                'long' => $propertydata['Reports'][0]['Data']['LocationInformation']['Longitude'],
                'owner_f' => $propertydata['Reports'][0]['Data']['OwnerInformation']['Owner1FullName'],
                'owner_l' => $propertydata['Reports'][0]['Data']['OwnerInformation']['Owner1FullName'],
                'mailing' => $propertydata['Reports'][0]['Data']['OwnerInformation']['MailingAddress']['StreetAddress'],
                'zip' => $propertydata['Reports'][0]['Data']['OwnerInformation']['MailingAddress']['Zip9'],
                'sub_d' => $propertydata['Reports'][0]['Data']['LocationInformation']['Subdivision'],
                'assesd_val' => $propertydata['Reports'][0]['Data']['TaxInformation']['AssessedValue'],
                'mar_v' => $propertydata['Reports'][0]['Data']['TaxInformation']['MarketValue'],
                'sal_d' => $propertydata['Reports'][0]['Data']['PriorSaleInformation']['PriorSaleDate'],
                'land_u' => $propertydata['Reports'][0]['Data']['SiteInformation']['LandUse'],
                'county_p' => $propertydata['Reports'][0]['Data']['TaxInformation']['MarketValue'],
                'mar_ac' => $propertydata['Reports'][0]['Data']['TaxInformation']['MarketLandValue'],
                'salecount' => $salecount,
                'avg_pr' => $avr_pr,
                'avr_acr' => $avr_acr,
                'aver_per_ac' => $aver_per_ac,
                'avr_d' => $avr_d,
                'logo' => public_path('img/logo.png'),
                'image' => public_path('img/th.jpg'),
                'zillow' => $avg_acr_ll,
                'av_per_acre_zill' => $av_per_acre_zill,
                'total_rec' => $total_rec,
                'zill_acre_avg' => $zill_acre_avg,
                'dis_zill' => $dis_zill,
                'county_av' => $average_county,
                'market_av'  => $market_av,
                'average_price_river' => $average_price_river,
                'mar_pr' => $mar_pr,
                'total_red' => $total_red,
                'average_red' => $average_red,
                'av_acre_red' => $av_acre_red,
                'avg_per_acre_red' => $avg_per_acre_red,
                'geo_adjusted' => $geo_adjust_price,
                'realto_s' => $realto_s,
                'avg_pr_realtor' => $avg_pr_realtor,
                'avg_ac' => $avg_ac,
                'av_pr_ac_real' => $av_pr_ac_real,
                'href_real' => $price_data_real['source'],
                'list_p_real' => $price_data_real['price'],
                'acre_real' => $price_data_real['acre'],
                'real_price_per' => number_format($price_data_real['price']/$price_data_real['acre'],2),
                'real_coun' => $price_data_real['county'],
                'real_cty' => $price_data_real['city'],
                'href_redfin' => isset($redfin_d['source']) ? $redfin_d['source'] : '',
                'list_p_red' => isset($redfin_d['price']) ? $redfin_d['price'] : 0,
                'acre_red' => isset($redfin_d['acre_']) ? $redfin_d['acre_'] : 0,
                'red_price_per' => isset($red_av_ac) ? $red_av_ac : 0,
                'red_coun' => isset($redfin_d['county']) ? $redfin_d['county'] : '',
                'red_cty' => isset($redfin_d['city']) ? $redfin_d['city'] : '',

            ];
            //dd($data);
            $pdf = Pdf::loadView('pdf', $data);
            return $pdf->download('compreport.pdf');
        } catch (\Exception $e) {
            //$response = $e->getResponse();
            $emsg = $e->getMessage();
            //dd($emsg);
            $fromserver = isset($response) ? $response : 'No records found . or Server error';
            //$msg = json_decode($response->getBody()->getContents(), true);
            //$error = $msg ? $msg : $emsg;
            $error = $emsg;
            //dd($response['reasonPhrase']);
            return  redirect()->to('compreport')->with('error', $error);
        }
    }
    // Function to get JSON array elements and their values
    function getJsonArrayElements($jsonData)
    {
        //dd(jsonData)
        // Decode JSON data into a PHP associative array
        $data = $jsonData;

        if ($data === null) {
            echo "Error decoding JSON data.";
            return;
        }

        // Get states array
        $salescomps = $data['Reports'][0]['Data']['ComparableProperties'];
        //echo "Sales Price:\n";
        $sum = 0;
        $sum_acr = 0;
        $sum_d = 0;


        foreach ($salescomps as $salescomp) {
            $sum += $salescomp['LastMarketSaleInformation']['SalePrice'];

            //if(!empty($salescomp['SitusAddress']['City']))
            // {
            $cities[] = $salescomp['SitusAddress']['City'];
            //$arr = [$cities];
            //}
            //$city = $cities;
            $sum_acr += $salescomp['SiteInformation']['Acres'];
            $sum_d += $salescomp['DistanceFromSubject'];

            $arr = [$sum, $sum_acr, $sum_d, $cities];
        }
        /*foreach ($salescomps as $salescomp) {
        if(!empty($salescomp['SitusAddress']['City']))
        {
        $price = $salescomp['LastMarketSaleInformation']['SalePrice'];
        $arr = [$price];
        }
    }*/

        return $arr;
    }

    function getPrice($jsonData)
    {
        //dd(jsonData)
        // Decode JSON data into a PHP associative array
        $data = $jsonData;

        if ($data === null) {
            echo "Error decoding JSON data.";
            return;
        }

        // Get states array
        $salescomps = $data['Reports'][0]['Data']['ComparableProperties'];


        foreach ($salescomps as $salescomp) {
            if (!empty($salescomp['SitusAddress']['City'])) {
                $price[] = $salescomp['LastMarketSaleInformation']['SalePrice'];
                $arr = [$price];
            }
        }

        return $arr;
    }
    function getPropertyData($jsonData)
    {
        $data = $jsonData;

        if ($data === null) {
            echo "Error decoding JSON data.";
            return;
        }

        // Get states array
        $propertycomps = $data['Reports'][0]['Data']['ComparableProperties'];
        $sum = 0;
        $sum_d = 0;

        foreach ($propertycomps as $propertycomp) {
            $address = $propertycomp['SitusAddress']['StreetAddress'];

            //dd($city);
            if (!empty($address)) {
                $acres = $propertycomp['SiteInformation']['Acres'];
                $distance = $propertycomp['DistanceFromSubject'];
                $sum_d += $distance;
                $sum += $acres;
                $add[] = $propertycomp['SitusAddress']['StreetAddress'];
                $city[] = $propertycomp['SitusAddress']['City'];
                $ad = [$add, $sum, $sum_d, $city];
            }
        }

        return $ad;
    }
    function getRedfinData($jsonData)
    {
        $data = $jsonData;

        if ($data === null) {
            echo "Error decoding JSON data.";
            return;
        }

        // Get states array
        $redfincomps = $data['data'];
        $sum = 0;
        $price_sum = 0;
        $acre_sum = 0;
        $redf = [];

        foreach ($redfincomps as $redfincomp) {
            $p_id[] = $redfincomp['homeData']['propertyId'];
            $price_sum += $redfincomp['homeData']['priceInfo']['amount'];
            $sqft = $redfincomp['homeData']['lotSize']['amount'];

            $acre_ = number_format($sqft / 43560, 2);
            $source = $redfincomp['homeData']['url'];
            $list_price = $redfincomp['homeData']['priceInfo']['amount'];
            $county = $redfincomp['homeData']['addressInfo']['state'];
            $city = $redfincomp['homeData']['addressInfo']['city'];

            $acre[] = number_format($sqft / 43560, 2);
            $acre_sum += number_format($sqft / 43560, 2);
            $redf = [
                'p_id' => $p_id,
                'pr_sum' => $price_sum,
                'acre' => $acre,
                'sum_acre' => $acre_sum,
                'acre_' => $acre_,
                'source' =>  $source,
                'price' => $list_price,
                'county' => $county,
                'city' => $city
            ];
        }
        return $redf;
    }
    function getZillowData($jsonData)
    {
        $data = $jsonData;

        if ($data === null) {
            echo "Error decoding JSON data.";
            return;
        }

        // Get states array
        $zillowcomps = $data;
        $sum = 0;

        foreach ($zillowcomps as $zillowcomp) {
            $price = $zillowcomp['price'];
            $sum += $price;
            $sale_sum = $sum;
        }
        return $sale_sum;
    }

    function getRealtorData($jsonData)
    {
        $data = $jsonData;

        if ($data === null) {
            echo "Error decoding JSON data.";
            return;
        }

        // Get states array
        $realtorcomps = $data['listings'];
        $sale_sum = 0;
        $sum = 0;
        $acre_sum = 0;

        foreach ($realtorcomps as $realtorcomp) {
            $price = $realtorcomp['list_price'];
            $sum += $price;
            $sqft = isset($realtorcomp['description']['lot_sqft']) ? $realtorcomp['description']['lot_sqft'] : 0;
            $acre[] = number_format($sqft / 43560, 2);
            $acre_sum += number_format($sqft / 43560, 2);
            $acre_ = number_format($sqft / 43560, 2);
            $source = $realtorcomp['href'];
            $list_price = $realtorcomp['list_price'];
            $county = $realtorcomp['location']['county']['name'];
            $city = $realtorcomp['location']['address']['city'];


            $sale_sum = [
                'price_sum' => $sum,
                'acre_sum' => $acre_sum,
                'data' => $realtorcomp,
                'acre' => $acre_,
                'source' =>  $source,
                'price' => $list_price,
                'county' => $county,
                'city' => $city
            ];
            //href,list_price,location->county->name,description->lot_sqft,location->address->city
        }
        return $sale_sum;
    }

    public function getCompData($jsonData)
    {
        $data = $jsonData;

        if ($data === null) {
            echo "Error decoding JSON data.";
            return;
        }

        // Get states array
        $getcompdatas = $data['Reports'][0];
        $sum = 0;

        //foreach ($getcompdatas as $getcompdata) {
        $p_id = $getcompdatas['PropertyId'];
        echo '$("#mytable4").append("<tr><td>' . $p_id . '</td></tr>")';
        // }
        //return $tabledata;
    }
}
