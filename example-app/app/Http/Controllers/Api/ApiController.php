<?php

namespace App\Http\Controllers\Api;

use Pdf;
use Mail;
use GuzzleHttp;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Api\BaseController;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Exports\CompExport;
use Maatwebsite\Excel\Facades\Excel;

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
            return redirect()->route('register')->withErrors($validator);

            // return response()->json($validator->errors());
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

            //$client_id = config('app.client_id');
            //$client_secret = config('app.client_secret');

            //$user->client_id = $client_id;
            //$user->client_secret = $client_secret;
            //$user->save();

            $user->save();
            return redirect()->back()->with('success', 'user registered successfully');
        } else {
            return redirect()->back()->with('error', 'User not found');
        }
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

    public function me()
    {
        return response()->json(auth()->user());
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

    public function updateProfile(Request $request)
    {
        if (auth()->user()) {
            $validator = Validator::make($request->all(), [
                'id' => 'required',
                'email' => 'required|email',
                'name' => 'required|string|min:5',
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

            return "<h1>email verified successfully <a href='http://165.140.69.88/~plotplaza/checkapi/example-app/public/login2'>Sign in </a></h1>";
        } else {
            return view('404');
        }
    }

    public function loadLogin()
    {
        return view('login2');
    }
    public function loadRegister()
    {
        return view('register');
    }

    public function userLogin(Request $request)
    {
        //dd($request);
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
    }

    public function dashboard()
    {
        return view('dashboard');
    }

    public function loadCompReport()
    {
        return view('compreport');
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
        //dd($apn);
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
            //dd($data);
            $data = isset($data['LitePropertyList']) ? $data['LitePropertyList'][0] : $data['Reports']['0'];
            $dt  = isset($data) ? $data : $data['Data']['SubjectProperty'];
            //$dt = $data;
            //dd($dt);
            $poperty_id = $dt['PropertyId'];
            $getProperty = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $authenticate,
                ],
                'body' => json_encode([
                    'ProductNames' => ['TotalViewReport'],

                    "SearchType" => "PROPERTY",
                    "PropertyId" => $poperty_id
                ]),
            ]);
            $price = json_decode($getProperty->getBody(), true);
            //dd($price);
            //dd($price);
            $maxcount = 1;
            $mainval = $maxcount * 2.00;
            return view('compreport', compact('price', 'maxcount', 'mainval', 'poperty_id'));
        } catch (\Exception $e) {
            //throw new HttpException(500, $e->getMessage());
            $response = $e->getResponse();
            $emsg = $e->getMessage();
            //dd($response);
            $fromserver = 'No records found . or Server error';
            $msg = json_decode($response->getBody()->getContents(), true);
            $error = $msg ? $msg : $fromserver;
            //dd($response['reasonPhrase']);
            return  redirect()->to('compreport')->with('error', $error);
        }
        //dd($data);
    }
    public function export_comp($id) 
    {
        //when stripe payment done then can download report
        return Excel::download(new CompExport($id), 'comp.xlsx');
    }
    public function loadPriceReport()
    {
        return view('priceland');
    }

    public function loadPriceHouseReport()
    {
        return view('pricehouse');
    }


    public function loadPriceResearchReport()
    {
        return view('research');
    }
    public function loadProperty()
    {
        return view('property');
    }


    public function insert_prop_detail()
    {
        //dd('123');

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

        ///////////////////////
        $res = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
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
                                "FilterName": "StateFips",
                                "FilterOperator": "is",
                                "FilterValues": [
                                   1
                                ],
                                "FilterGroup": 1
                            }                              
                        ] //
                    } //
                }',
        ]);
        $de[] = json_decode($res->getBody(), true);
        $res = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
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
                                "FilterName": "StateFips",
                                "FilterOperator": "is",
                                "FilterValues": [
                                   2
                                ],
                                "FilterGroup": 1
                            }                              
                        ] //
                    } //
                }',
        ]);
        $de[] = json_decode($res->getBody(), true);
        /*$res = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
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
                                "FilterName": "StateFips",
                                "FilterOperator": "is",
                                "FilterValues": [
                                   3
                                ],
                                "FilterGroup": 1
                            }                              
                        ] //
                    } //
                }',
        ]);
        $de[] = json_decode($res->getBody(), true);*/
        $res = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
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
                                "FilterName": "StateFips",
                                "FilterOperator": "is",
                                "FilterValues": [
                                   4
                                ],
                                "FilterGroup": 1
                            }                              
                        ] //
                    } //
                }',
        ]);
        $de[] = json_decode($res->getBody(), true);
        $res = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
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
                                "FilterName": "StateFips",
                                "FilterOperator": "is",
                                "FilterValues": [
                                   5
                                ],
                                "FilterGroup": 1
                            }                              
                        ] //
                    } //
                }',
        ]);
        $de[] = json_decode($res->getBody(), true);
        $res = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
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
                                "FilterName": "StateFips",
                                "FilterOperator": "is",
                                "FilterValues": [
                                  6
                                ],
                                "FilterGroup": 1
                            }                              
                        ] //
                    } //
                }',
        ]);
        $de[] = json_decode($res->getBody(), true);
        /* $res = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
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
                                "FilterName": "StateFips",
                                "FilterOperator": "is",
                                "FilterValues": [
                                   7
                                ],
                                "FilterGroup": 1
                            }                              
                        ] //
                    } //
                }',
        ]);
        $de[] = json_decode($res->getBody(), true);*/
        $res = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
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
                                "FilterName": "StateFips",
                                "FilterOperator": "is",
                                "FilterValues": [
                                   8
                                ],
                                "FilterGroup": 1
                            }                              
                        ] //
                    } //
                }',
        ]);
        $de[] = json_decode($res->getBody(), true);
        $res = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
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
                                "FilterName": "StateFips",
                                "FilterOperator": "is",
                                "FilterValues": [
                                   9
                                ],
                                "FilterGroup": 1
                            }                              
                        ] //
                    } //
                }',
        ]);
        $de[] = json_decode($res->getBody(), true);
        $res = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
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
                                "FilterName": "StateFips",
                                "FilterOperator": "is",
                                "FilterValues": [
                                   10
                                ],
                                "FilterGroup": 1
                            }                              
                        ] //
                    } //
                }',
        ]);
        $de[] = json_decode($res->getBody(), true);
        $res = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
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
                                "FilterName": "StateFips",
                                "FilterOperator": "is",
                                "FilterValues": [
                                   11
                                ],
                                "FilterGroup": 1
                            }                              
                        ] //
                    } //
                }',
        ]);
        $de[] = json_decode($res->getBody(), true);
        $res = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
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
                                "FilterName": "StateFips",
                                "FilterOperator": "is",
                                "FilterValues": [
                                   12
                                ],
                                "FilterGroup": 1
                            }                              
                        ] //
                    } //
                }',
        ]);
        $de[] = json_decode($res->getBody(), true);
        $res = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
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
                                "FilterName": "StateFips",
                                "FilterOperator": "is",
                                "FilterValues": [
                                   13
                                ],
                                "FilterGroup": 1
                            }                              
                        ] //
                    } //
                }',
        ]);
        $de[] = json_decode($res->getBody(), true);
        /*$res = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
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
                                "FilterName": "StateFips",
                                "FilterOperator": "is",
                                "FilterValues": [
                                   14
                                ],
                                "FilterGroup": 1
                            }                              
                        ] //
                    } //
                }',
        ]);
        $de[] = json_decode($res->getBody(), true);*/
        $res = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
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
                                "FilterName": "StateFips",
                                "FilterOperator": "is",
                                "FilterValues": [
                                   15
                                ],
                                "FilterGroup": 1
                            }                              
                        ] //
                    } //
                }',
        ]);
        $de[] = json_decode($res->getBody(), true);
        $res = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
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
                                "FilterName": "StateFips",
                                "FilterOperator": "is",
                                "FilterValues": [
                                   16
                                ],
                                "FilterGroup": 1
                            }                              
                        ] //
                    } //
                }',
        ]);
        $de[] = json_decode($res->getBody(), true);
        $res = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
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
                                "FilterName": "StateFips",
                                "FilterOperator": "is",
                                "FilterValues": [
                                   17
                                ],
                                "FilterGroup": 1
                            }                              
                        ] //
                    } //
                }',
        ]);
        $de[] = json_decode($res->getBody(), true);
        $res = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
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
                                "FilterName": "StateFips",
                                "FilterOperator": "is",
                                "FilterValues": [
                                   18
                                ],
                                "FilterGroup": 1
                            }                              
                        ] //
                    } //
                }',
        ]);
        $de[] = json_decode($res->getBody(), true);
        $res = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
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
                                "FilterName": "StateFips",
                                "FilterOperator": "is",
                                "FilterValues": [
                                   19
                                ],
                                "FilterGroup": 1
                            }                              
                        ] //
                    } //
                }',
        ]);
        $de[] = json_decode($res->getBody(), true);
        $res = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
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
                                "FilterName": "StateFips",
                                "FilterOperator": "is",
                                "FilterValues": [
                                   20
                                ],
                                "FilterGroup": 1
                            }                              
                        ] //
                    } //
                }',
        ]);
        $de[] = json_decode($res->getBody(), true);
        $res = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
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
                                "FilterName": "StateFips",
                                "FilterOperator": "is",
                                "FilterValues": [
                                   21
                                ],
                                "FilterGroup": 1
                            }                              
                        ] //
                    } //
                }',
        ]);
        $de[] = json_decode($res->getBody(), true);
        $res = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
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
                                "FilterName": "StateFips",
                                "FilterOperator": "is",
                                "FilterValues": [
                                   22
                                ],
                                "FilterGroup": 1
                            }                              
                        ] //
                    } //
                }',
        ]);
        $de[] = json_decode($res->getBody(), true);
        $res = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
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
                                "FilterName": "StateFips",
                                "FilterOperator": "is",
                                "FilterValues": [
                                   23
                                ],
                                "FilterGroup": 1
                            }                              
                        ] //
                    } //
                }',
        ]);
        $de[] = json_decode($res->getBody(), true);
        $res = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
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
                                "FilterName": "StateFips",
                                "FilterOperator": "is",
                                "FilterValues": [
                                   24
                                ],
                                "FilterGroup": 1
                            }                              
                        ] //
                    } //
                }',
        ]);
        $de[] = json_decode($res->getBody(), true);
        $res = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
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
                                "FilterName": "StateFips",
                                "FilterOperator": "is",
                                "FilterValues": [
                                   25
                                ],
                                "FilterGroup": 1
                            }                              
                        ] //
                    } //
                }',
        ]);
        $de[] = json_decode($res->getBody(), true);
        $res = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
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
                                "FilterName": "StateFips",
                                "FilterOperator": "is",
                                "FilterValues": [
                                   26
                                ],
                                "FilterGroup": 1
                            }                              
                        ] //
                    } //
                }',
        ]);
        $de[] = json_decode($res->getBody(), true);
        $res = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
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
                                "FilterName": "StateFips",
                                "FilterOperator": "is",
                                "FilterValues": [
                                   27
                                ],
                                "FilterGroup": 1
                            }                              
                        ] //
                    } //
                }',
        ]);
        $de[] = json_decode($res->getBody(), true);
        $res = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
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
                                "FilterName": "StateFips",
                                "FilterOperator": "is",
                                "FilterValues": [
                                   28
                                ],
                                "FilterGroup": 1
                            }                              
                        ] //
                    } //
                }',
        ]);
        $de[] = json_decode($res->getBody(), true);
        $res = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
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
                                "FilterName": "StateFips",
                                "FilterOperator": "is",
                                "FilterValues": [
                                   29
                                ],
                                "FilterGroup": 1
                            }                              
                        ] //
                    } //
                }',
        ]);
        $de[] = json_decode($res->getBody(), true);
        $res = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
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
                                "FilterName": "StateFips",
                                "FilterOperator": "is",
                                "FilterValues": [
                                   30
                                ],
                                "FilterGroup": 1
                            }                              
                        ] //
                    } //
                }',
        ]);
        $de[] = json_decode($res->getBody(), true);
        foreach ($de as $d) {
            $l_id[] = $d['LitePropertyList'];
        }
        //dd($l_id);
        for ($i = 0; $i < count($l_id); $i++) {
            //foreach($l_id[$i] )
            $pt_id[] = $l_id[$i];
        }
        foreach ($pt_id as $pd) {
            for ($i = 0; $i < count($pd) - 1; $i++) {
                //foreach($l_id[$i] )
                //(isset($pd[$i])){
                $p_id[] = $pd[$i]['PropertyId'];
                $s_id[] = $pd[$i]['State'];
                $c_id[] = $pd[$i]['County'];
                $z_id[] = $pd[$i]['Zip'];
                $a_id[] = $pd[$i]['Apn'];
                //}
            }
        }
        //dd($p_id);
        DB::table('property_details')->delete();
        $dat = [
            'PropertyId' => $p_id,
            'State' => $s_id,
            'County' => $c_id,
            'Zipcode' => $z_id,
            'Apn' => $a_id,
        ];
        for ($j = 0; $j < count($p_id); $j++) {

            $prop = DB::table('property_details')->insert([
                'property_id' => $dat['PropertyId'][$j],
                'state' => $dat['State'][$j],
                'county' => $dat['County'][$j],
                'zipcode' => $dat['Zipcode'][$j],
                'apn' => $dat['Apn'][$j]
            ]);
        }

        if ($prop) {
            $msg = 'record insert successfully';
            echo $msg;
        } else {
            dd($dat);
        }
    }
    public function GetPriceHouseReport(Request $request)
    {
        //dd($request);
        $my_states_array = [
            'ca' => 6,
            'al' => 1,
            'ak' => 2,
            'az' => 4,
            'ar' => 5,
            'co' => 8,
            'ct' => 9,
            'de' => 10,
            'dc' => 11,
            'fl' => 12,
            'ga' => 13,
            'hi' => 15,
            'id' => 16,
            'il' => 17,
            'in' => 18,
            'ia' => 19,
            'ks' => 20,
            'ky' => 21,
            'ga' => 13,
            'hi' => 15,
            'id' => 16,
            'il' => 17,
            'in' => 18,
            'ia' => 19,
            'ks' => 20,
            'ky' => 21,
            'sc' => 45
        ];
        foreach ($my_states_array as $key => $val) {
            if (ltrim($request['state'], '0') == $key) {
                $st = $val;
            }
        }

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

        $cp = ltrim($request['cp'], '0');


        try {

            ///////////////////////
            //$acre_arr = [0,5,10,15,20,25,30,35,40,45,50,55,60,65,70,75,80,85,90,95,100];
            $acre_arr = [0, 2, 5, 15, 22, 32, 42, 52, 62, 72, 82, 92, 102, 122, 124, 125, 130, 140, 150, 160, 170, 200, 210, 230, 300, 350, 400];

            foreach ($acre_arr as $ac) {
                $dat[] = $ac;
            }

            //now fetching from db 
            //dd($request['state'],$request['county_name']);
            $prop_id = DB::table('property_details')->where([
                'state' => $request['state'],
                'county' => $request['county_name']
            ])->get();
            //dd($prop_id);
            $cnt = count($prop_id);
            $data = json_decode(json_encode($prop_id, true), true);

            if ($cnt > 0) {
                //dd(count($data));
                for ($i = 0; $i < count($data); $i++) {
                    $res = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
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
                                                    ' . $dat[$i] . ',
                                                    ' . $dat[$i + 1] . '
                                                    
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
                    $de[] = json_decode($res->getBody(), true);
                    $getProperty = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
                        'headers' => [
                            'Accept' => 'application/json',
                            'Content-Type' => 'application/json',
                            'Authorization' => 'Bearer ' . $authenticate,
                        ],
                        'body' => json_encode([
                            'ProductNames' => ['TotalViewReport'],

                            "SearchType" => "PROPERTY",
                            "PropertyId" => $data[$i]['property_id']
                        ]),
                    ]);
                    $price[] = json_decode($getProperty->getBody(), true);
                }
                $price = isset($price) ? $price : '';

                //dd($price);
                ///////////////////////////
                $mainval = 1 * 0.1;
                return view('pricehouse', compact('mainval', 'de', 'data', 'price'));
            } else {
                $error = 'Data not found';
                return  redirect()->to('pricehouse')->with('error', $error);
            }
            //dd($price);


        } catch (\Exception $e) {
            //throw new HttpException(500, $e->getMessage());
            //dd($e->getMessage());
            $response = $e->getResponse();
            if ($response) {
                $emsg = 'Data not found';
            } else {
                $emsg = $e->getMessage();
            }

            //dd($response);
            $fromserver = 'No records found . or Server error';
            $msg = json_decode($response->getBody()->getContents(), true);
            $error = isset($emsg) ? $emsg : $fromserver;
            //dd($response['reasonPhrase']);
            return  redirect()->to('pricehouse')->with('error', $error);
        }
    }

    public function GetPriceResearchReport(Request $request)
    {
        //dd($request);
        $my_states_array = [
            'ca' => 6,
            'al' => 1,
            'ak' => 2,
            'az' => 4,
            'ar' => 5,
            'co' => 8,
            'ct' => 9,
            'de' => 10,
            'dc' => 11,
            'fl' => 12,
            'ga' => 13,
            'hi' => 15,
            'id' => 16,
            'il' => 17,
            'in' => 18,
            'ia' => 19,
            'ks' => 20,
            'ky' => 21,
            'sc' => 45
        ];
        foreach ($my_states_array as $key => $val) {
            if (ltrim($request['state'], '0') == $key) {
                $st = $val;
            }
        }

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

        $cp = ltrim($request['cp'], '0');


        try {

            ///////////////////////
            //$acre_arr = [0,5,10,15,20,25,30,35,40,45,50,55,60,65,70,75,80,85,90,95,100];
            $acre_arr = [0, 2, 5, 15, 22, 32, 42, 52, 62, 72, 82, 92, 102, 122, 124, 125, 130, 140, 150, 160, 170];

            foreach ($acre_arr as $ac) {
                $dat[] = $ac;
            }


            $prop_id = DB::table('property_details')->where(
                'state',
                $request['state']
            )->get();
            //dd($prop_id);


            //dd($de);

            //dd($data);
            //dd(str_replace("","",$apn_all[0]));

            $cnt = count($prop_id);
            $data = json_decode(json_encode($prop_id, true), true);
            //dd($data);
            for ($j = 0; $j < count($data); $j++) {
                $zpp = $data[$j]['zipcode'];
                if ($zpp > 0 && $zpp != null) {
                    $zp[] = $data[$j]['zipcode'];
                    $apn[] = $data[$j]['apn'];
                }
            }
            //dd($zp);


            if ($cnt > 0) {
                //dd(count($data));
                for ($i = 0; $i < count($data); $i++) {
                    $zpp = $data[$i]['zipcode'];
                    if ($zpp > 0 && $zpp != null) {
                        //$zp[] = $data[$i]['zipcode'];
                        //$apn[] = $data[$i]['apn'];
                        $getProperty = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
                            'headers' => [
                                'Accept' => 'application/json',
                                'Content-Type' => 'application/json',
                                'Authorization' => 'Bearer ' . $authenticate,
                            ],
                            'body' => '{
            "ProductNames": ["TotalViewReport"],
            "SearchType": "APN",
            "ApnDetail": {
              "APN": "' . $data[$i]['apn'] . '",
              "ZipCode": "' . $data[$i]['zipcode'] . '"
            }
          }',
                        ]);
                        $price[] = json_decode($getProperty->getBody(), true);
                        //dd($price);

                    }
                    //dd($zp);

                }
                //dd($price);
                $price = isset($price) ? $price : '';

                //dd($price);
                ///////////////////////////
                $mainval = 1 * 0.1;
                return view('research', compact('mainval', 'price'));
            } else {
                $error = 'Data not found';
                return  redirect()->to('research')->with('error', $error);
            }
            //dd($price);

        } catch (\Exception $e) {
            //throw new HttpException(500, $e->getMessage());
            //dd($e->getMessage());
            $response = $e->getResponse();
            if ($response) {
                $emsg = 'Data not found';
            } else {
                $emsg = $e->getMessage();
            }

            //dd($response);
            $fromserver = 'No records found . or Server error';
            $msg = json_decode($response->getBody()->getContents(), true);
            $error = isset($emsg) ? $emsg : $fromserver;
            //dd($response['reasonPhrase']);
            return  redirect()->to('research')->with('error', $error);
        }

        //dd($data);
        ///////////////////////////

    }


    public function GetPriceReport(Request $request)
    {
        //dd($request);
        $my_states_array = [
            'ca' => 6,
            'al' => 1,
            'ak' => 2,
            'az' => 4,
            'ar' => 5,
            'co' => 8,
            'ct' => 9,
            'de' => 10,
            'dc' => 11,
            'fl' => 12,
            'ga' => 13,
            'hi' => 15,
            'id' => 16,
            'il' => 17,
            'in' => 18,
            'ia' => 19,
            'ks' => 20,
            'ky' => 21,
            'sc' => 45
        ];
        foreach ($my_states_array as $key => $val) {
            if (ltrim($request['state'], '0') == $key) {
                $st = $val;
            }
        }

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

        $cp = ltrim($request['cp'], '0');


        try {

            ///////////////////////
            $acre_arr = [0, 5, 10, 15, 20, 25, 30, 35, 40, 45, 50, 55, 60, 65, 70, 75, 80, 85, 90, 95, 100];

            foreach ($acre_arr as $ac) {
                $dat[] = $ac;
            }
            //dd($data);
            $prop_id = DB::table('property_details')->where([
                'state' => $request['state'],
                'county' => $request['county_name']
            ])->get();
            //dd($prop_id);
            $cnt = count($prop_id);
            $data = json_decode(json_encode($prop_id, true), true);

            if ($cnt > 0) {
                //dd(count($data));
                for ($i = 0; $i < count($data); $i++) {
                    $res = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
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
                                                    ' . $dat[$i] . ',
                                                    ' . $dat[$i + 1] . '
                                                    
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
                    $de[] = json_decode($res->getBody(), true);
                    $getProperty = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
                        'headers' => [
                            'Accept' => 'application/json',
                            'Content-Type' => 'application/json',
                            'Authorization' => 'Bearer ' . $authenticate,
                        ],
                        'body' => json_encode([
                            'ProductNames' => ['PropertyDetailReport'],

                            "SearchType" => "PROPERTY",
                            "PropertyId" => $data[$i]['property_id']
                        ]),
                    ]);
                    $price[] = json_decode($getProperty->getBody(), true);
                }
                $price = isset($price) ? $price : '';

                //dd($price);
                ///////////////////////////
                $mainval = 1 * 0.1;
                return view('priceland', compact('mainval', 'de', 'data', 'price'));
            } else {
                $error = 'Data not found';
                return  redirect()->to('priceland')->with('error', $error);
            }
            //dd($price);

        } catch (\Exception $e) {
            //throw new HttpException(500, $e->getMessage());
            //dd($e->getMessage());
            $response = $e->getResponse();
            if ($response) {
                $emsg = 'Data not found';
            } else {
                $emsg = $e->getMessage();
            }

            //dd($response);
            $fromserver = 'No records found . or Server error';
            $msg = json_decode($response->getBody()->getContents(), true);
            $error = isset($emsg) ? $emsg : $fromserver;
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
            $request->session()->flush();
            Auth::logout();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false]);
        }
    }
    public function pdf_download2(Request $request)
    {
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

            $salesdata = json_decode($sales->getBody(), true);
            //dd($propertydata);

            if ($salesdata['Reports'][0]['Data']['ComparableCount'] <= 0) {
                $error = 'Records not found';
                return  redirect()->to('compreport')->with('error', $error);
            }
            //dd($salesdata);
            $average_county = $salesdata['Reports'][0]['Data']['ComparablePropertiesSummary']['SaleListedPrice']['Low'];
            //dd($salesdata);

            $sum_sale[0] = $this->getJsonArrayElements($salesdata);
            //dd($sum_sale[0]);
            $price[0] = $this->getPrice($salesdata);
            $mar_pr = $price[0][0][0];
            $add_data[0] = $this->getPropertyData($salesdata);

            $total_rc = count($add_data[0]);

            // dd($add_data[0][0]);
            $zill_acre_avg = (float)($add_data[0][1] / $total_rc);

            $zill_acre_avg_ = (float)($add_data[0][1]);

            $dis_zill = number_format((float)($add_data[0][2] / $total_rc), 2);
            $average_price_river = $sum_sale[0][0];
            //dd($average_price_river);
            // dd($add_data[0][0][0]);

            //$address_property = isset($add_data[0][0][2]) ? $add_data[0][0][2] : $add_data[0][0][1];
            $address_property = isset($add_data[0][0][0]) ? $add_data[0][0][0] : $add_data[0][0][1];
            //dd($ab);
            //get zillow data 
            $zillow_sales = $client->request('GET', 'https://zillow-working-api.p.rapidapi.com/byaddress?propertyaddress=' . $address_property . '', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'x-rapidapi-host' => 'zillow-working-api.p.rapidapi.com',
                    'x-rapidapi-key' => config('app.rapid_key')
                ],
                'body' => json_encode([
                    'propertyaddress' => ''
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
                    'x-rapidapi-host' => 'zillow-com1.p.rapidapi.com',
                    'x-rapidapi-key' => config('app.rapid_key')
                ],
                'body' => json_encode([]),
            ]);
            //zillow sold comps 
            $zillow_sold_comp = $client->request('GET', 'https://zillow-com1.p.rapidapi.com/similarSales?zpid=' . $zpid . '', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'x-rapidapi-host' => 'zillow-com1.p.rapidapi.com',
                    'x-rapidapi-key' => config('app.rapid_key')
                ],
                'body' => json_encode([]),
            ]);
            /////sold comp end
            $city_red = $add_data[0][3][0];
            //dd($city_red);
            $redfin_sales_comp = $client->request('GET', 'https://redfin-com-data.p.rapidapi.com/properties/auto-complete?query=' . $city_red . '&limit=1', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'x-rapidapi-host' => 'redfin-com-data.p.rapidapi.com',
                    'x-rapidapi-key' => config('app.rapid_key')
                ],
                'body' => json_encode([]),
            ]);
            //dd(config('app.rapid_key'));
            $redfin_comp_data = json_decode($redfin_sales_comp->getBody(), true);
            //dd($redfin_comp_data);
            $region_id = $redfin_comp_data['data'][0]['rows'][0]['id'];
            //dd($region_id);
            $redfin_sales_comp = $client->request('GET', 'https://redfin-com-data.p.rapidapi.com/properties/search-sale?regionId=' . $region_id . '&lotSize=10890%2C21780&limit=20', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'x-rapidapi-host' => 'redfin-com-data.p.rapidapi.com',
                    'x-rapidapi-key' => config('app.rapid_key')
                ],
                'body' => json_encode([]),
            ]);

            //redfin sold homes
            $redfin_sold_comp = $client->request('GET', 'https://redfin-com-data.p.rapidapi.com/properties/search-sold?regionId=' . $region_id . '&lotSize=10890%2C21780&limit=20', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'x-rapidapi-host' => 'redfin-com-data.p.rapidapi.com',
                    'x-rapidapi-key' => config('app.rapid_key')
                ],
                'body' => json_encode([]),
            ]);
            //dd($region_id);
            //redfin sold home end
            $redfin_data = json_decode($redfin_sales_comp->getBody(), true);
            //dd($redfin_data);

            //dd($redfin_data);
            $redfin_sold_data = json_decode($redfin_sold_comp->getBody(), true);
            $redcountsold = count($redfin_sold_data);
            //dd($redfin_sold_data);
            //dd($redfin_data);

            //dd($redfin_data);
            $redfin_d = $this->getRedfinData($redfin_data);
            //dd($redfin_d);
            //sold data
            $redfin_sold_d = $this->getRedfinData($redfin_sold_data);
            //dd('123');
            $redfin_d = isset($redfin_d) ? $redfin_d : 0;
            //dd($redfin_d);
            $sum_acre = isset($redfin_d['sum_acre']) ? $redfin_d['sum_acre'] : 0;
            $sum_acre_sold = isset($redfin_sold_d['sum_acre']) ? $redfin_sold_d['sum_acre'] : 0;

            //dd($sum_acre);
            $total_red = isset($redfin_d['p_id']) ? count($redfin_d['p_id']) : 0;
            $total_red_sold = isset($redfin_sold_d['p_id']) ? count($redfin_sold_d['p_id']) : 0;

            $total_prce_sum_red = isset($redfin_d['pr_sum']) ? str_replace(',', '', $redfin_d['pr_sum']) : 0;
            $total_prce_sum_red_sold = isset($redfin_sold_d['pr_sum']) ? str_replace(',', '', $redfin_sold_d['pr_sum']) : 0;

            if ($sum_acre > 0) {
                $av_acr = number_format($sum_acre / $total_red, 2);
                $avg_sc_r = number_format($total_prce_sum_red / $sum_acre, 2);
                $red_av_ac = number_format($redfin_d['price'] / $redfin_d['acre_'], 2);
            };
            //dd($redfin_sold_d['sum_acre']/ count($redfin_sold_d['acre']));
            $acre_not_zero = $redfin_sold_d['sum_acre'] / count($redfin_sold_d['acre']);
            if ($sum_acre_sold > 0) {
                $av_acr_sold = number_format($sum_acre_sold / $total_red_sold, 2);
                $avg_sc_r_sold = number_format($total_prce_sum_red_sold / $sum_acre_sold, 2);
                $red_av_ac_sold = number_format($redfin_sold_d['price'] / $acre_not_zero, 2);
            };
            $av_acre_red = isset($av_acr) ? $av_acr : 0;
            $av_acre_red_sold = isset($av_acr_sold) ? $av_acr_sold : 0;
            //dd($av_acre_red);

            $average_red = isset($redfin_d['pr_sum']) ? number_format($redfin_d['pr_sum'] / $total_red, 2) : 0;
            $average_red_sold = isset($redfin_sold_d['pr_sum']) ? number_format($redfin_sold_d['pr_sum'] / $total_red_sold, 2) : 0;

            $avg_per_acre_red = isset($avg_sc_r) ? $avg_sc_r : 0;
            $avg_per_acre_red_sold = isset($avg_sc_r_sold) ? $avg_sc_r_sold : 0;



            $zillow_comp_data = json_decode($zillow_sales_comp->getBody(), true);
            //dd($zillow_comp_data);
            //
            $zillow_comp_data_sold = json_decode($zillow_sold_comp->getBody(), true);

            //
            //dd($zillow_comp_data);
            $z_D = $this->getZillowData($zillow_comp_data);
            //dd($z_D);
            $z_D_sold = $this->getZillowData($zillow_comp_data_sold);
            
            //dd($z_D_sold['acre_all']);

            $t_c = count($z_D);
            $t_c_sold = count($zillow_comp_data_sold);


            // dd($z_D);
            //dd($z_D_sold);


            $total_rec = count($zillow_comp_data);
            $total_rec_sold = count($zillow_comp_data_sold);
            //dd($zillow_comp_data_sold);

            //$avg_acr_zll = $this->getZillowData($zillow_comp_data);
            $avg_acr_ll = str_replace(',', '', number_format((float)($z_D['sum'] / $total_rec), 2));
            $avg_acr_ll_sold = str_replace(',', '', number_format((float)($z_D_sold['sum'] / $total_rec_sold), 2));

            $avg_acr_ll_ = str_replace(',', '', number_format((float)($z_D['sum']), 2));
            $avg_acr_ll_sold = str_replace(',', '', number_format((float)($z_D_sold['sum']), 2));

            //dd($z_D_sold);
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
            //dd($avr_d);

            $aver_per_ac = number_format((float)($sum_sale[0][0] / $sum_sale[0][1]), 2);
            //avg per acre zillow
            $avg_acre_zll_sold = number_format((float)($z_D_sold['acre_all']) / $t_c_sold, 2);
            //dd($avg_acre_zll_sold);

            $av_per_acre_zill = number_format((float)($avg_acr_ll_ / $zill_acre_avg_), 2);
            $av_per_acre_zill_sold = number_format($avg_acre_zll_sold, 2);

            //dd($city_red);
            $realtor_sales_comp = $client->request('GET', 'https://realtor-search.p.rapidapi.com/properties/search-buy?location=city%3A' . $city_red . '&sortBy=relevance&lotSize=10890%2C21780', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'x-rapidapi-host' => 'realtor-search.p.rapidapi.com',
                    'x-rapidapi-key' => config('app.rapid_key')
                ],
                'body' => json_encode([]),
            ]);
            $realtor_sold_comp = $client->request('GET', 'https://realtor-search.p.rapidapi.com/properties/search-sold?location=city%3A' . $city_red . '&sortBy=relevance&lotSize=10890%2C21780', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'x-rapidapi-host' => 'realtor-search.p.rapidapi.com',
                    'x-rapidapi-key' => config('app.rapid_key')
                ],
                'body' => json_encode([]),
            ]);
            //dd($realtor_sales_comp);

            $realtor = json_decode($realtor_sales_comp->getBody(), true);
            $realtor_sold = json_decode($realtor_sold_comp->getBody(), true);

            //dd($realtor);
            $price_data_real = $this->getRealtorData($realtor);
            $price_data_real_sold = $this->getRealtorData($realtor_sold);
            //dd($this->getRealtorData($realtor));

            $realto_s = isset($realtor['data']['count']) ? $realtor['data']['count'] : 0;
            $realto_s_sold = isset($realtor_sold['data']['count']) ? $realtor_sold['data']['count'] : 0;
            $t_sold = $redcountsold + $t_c_sold + $realto_s_sold;

            //dd($price_data_real);
            $avg_pr_realtor = 0;
            $avg_ac = 0;
            $av_pr_ac_real = 0;
            if ($price_data_real > 0) {
                //dd('inside');

                $avg_pr_realtor = str_replace(',', '', number_format($price_data_real['price_sum'] / $realto_s, 2));
                //dd($avg_pr_realtor);
                $avg_ac = number_format($price_data_real['acre_sum'] / $realto_s, 2);
                $av_pr_ac_real = number_format($avg_pr_realtor / $avg_ac, 2);
            }


            $avg_pr_realtor_sold = 0;
            $avg_ac_sold = 0;
            $av_pr_ac_real_sold = 0;
            if ($price_data_real_sold > 0) {
                //dd('inside');

                $avg_pr_realtor_sold = str_replace(',', '', number_format($price_data_real_sold['price_sum'] / $realto_s_sold, 2));
                //dd($avg_pr_realtor);
                $avg_ac_sold = number_format($price_data_real_sold['acre_sum'] / $realto_s_sold, 2);
                $av_pr_ac_real_sold = number_format($avg_pr_realtor_sold / $avg_ac_sold, 2);
            }

            $data = [
                'sold_comp' => $t_sold,
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
                'href_real' => isset($price_data_real['source_all'][0]) ? $price_data_real['source_all'][0] : 0,
                'list_p_real' => isset($price_data_real['price_all'][0]) ? $price_data_real['price_all'][0] : 0,
                'acre_real' => isset($price_data_real['acre_all'][0]) ? $price_data_real['acre_all'][0] : 0,
                'real_price_per' => isset($price_data_real['price_all'][0]) ? number_format($price_data_real['price_all'][0] / $price_data_real['acre_all'][0], 2) : 0,
                'real_coun' => isset($price_data_real['county_all'][0]) ? $price_data_real['county_all'][0] : 0,
                'real_cty' => isset($price_data_real['city_all'][0]) ? $price_data_real['city_all'][0] : 0,
                'href_real1' => isset($price_data_real['source_all'][1]) ? $price_data_real['source_all'][1] : 0,
                'list_p_real1' => isset($price_data_real['price_all'][1]) ? $price_data_real['price_all'][1] : 0,
                'acre_real1' => isset($price_data_real['acre_all'][1]) ? $price_data_real['acre_all'][1] : 0,
                'real_price_per1' => isset($price_data_real['price_all'][1]) ? number_format($price_data_real['price_all'][1] / $price_data_real['acre_all'][1], 2) : 0,
                'real_coun1' => isset($price_data_real['county_all'][1]) ? $price_data_real['county_all'][1] : 0,
                'real_cty1' => isset($price_data_real['city_all'][1]) ? $price_data_real['city_all'][1] : 0,
                'href_redfin' => isset($redfin_d['source']) ? $redfin_d['source'] : '',
                'list_p_red' => isset($redfin_d['price']) ? $redfin_d['price'] : 0,
                'acre_red' => isset($redfin_d['acre_']) ? $redfin_d['acre_'] : 0,
                'red_price_per' => isset($red_av_ac) ? $red_av_ac : 0,
                'red_coun' => isset($redfin_d['county']) ? $redfin_d['county'] : '',
                'red_cty' => isset($redfin_d['city']) ? $redfin_d['city'] : '',

                'href_redfin_sold' => isset($redfin_sold_d['source']) ? $redfin_sold_d['source'] : '',
                'list_p_red_sold' => isset($redfin_sold_d['price']) ? $redfin_sold_d['price'] : 0,
                'acre_red_sold' => isset($redfin_sold_d['acre_']) ? $redfin_sold_d['acre_'] : 0,
                'red_price_per_sold' => isset($red_av_ac_sold) ? $red_av_ac_sold : 0,
                'red_coun_sold' => isset($redfin_sold_d['county']) ? $redfin_sold_d['county'] : '',
                'red_cty_sold' => isset($redfin_sold_d['city']) ? $redfin_sold_d['city'] : '',

                'href_zll' => $z_D['source_all'][$t_c - 1],
                'list_p_zll' => $z_D['price_all'][$t_c - 1],
                'acre_zll' => $z_D['acre_all'][$t_c - 1],
                'zll_price_per' => number_format($z_D['price_all'][$t_c - 1] / $z_D['acre_all'][$t_c - 1], 2),
                'zll_coun' => $z_D['county_all'][$t_c - 1],
                'zll_cty' => $z_D['city_all'][$t_c - 1],
                'href_zll1' => $z_D['source_all'][$t_c - 2],
                'list_p_zll1' => $z_D['price_all'][$t_c - 2],
                'acre_zll1' => $z_D['acre_all'][$t_c - 2],
                'zll_price_per1' => number_format($z_D['price_all'][$t_c - 2] / $z_D['acre_all'][$t_c - 2], 2),
                'zll_coun1' => $z_D['county_all'][$t_c - 2],
                'zll_cty1' => $z_D['city_all'][$t_c - 2],

                'href_zll_sold' => $z_D_sold['source_all'][$t_c_sold - 1],
                'list_p_zll_sold' => $z_D_sold['price_all'][$t_c_sold - 1],
                'acre_zll_sold' => $av_per_acre_zill_sold,
                'zll_price_per_sold' => number_format($z_D_sold['price_all'][$t_c_sold - 1] / $av_per_acre_zill_sold, 2),
                'zll_coun_sold' => $z_D_sold['county_all'][$t_c_sold - 1],
                'zll_cty_sold' => $z_D_sold['city_all'][$t_c_sold - 1],


                'href_zll1_sold' => $z_D_sold['source_all'][$t_c_sold - 2],
                'list_p_zll1_sold' => $z_D_sold['price_all'][$t_c_sold - 2],
                'acre_zll1_sold' => $av_per_acre_zill_sold,
                'zll_price_per1_sold' => number_format($z_D_sold['price_all'][$t_c_sold - 2] / $av_per_acre_zill_sold, 2),
                'zll_coun1_sold' => $z_D_sold['county_all'][$t_c_sold - 2],
                'zll_cty1_sold' => $z_D_sold['city_all'][$t_c_sold - 2],

                'href_zll2_sold' => $z_D_sold['source_all'][$t_c_sold - 3],
                'list_p_zll2_sold' => $z_D_sold['price_all'][$t_c_sold - 3],
                'acre_zll2_sold' => $av_per_acre_zill_sold,
                'zll_price_per2_sold' => number_format($z_D_sold['price_all'][$t_c_sold - 3] / $av_per_acre_zill_sold, 2),
                'zll_coun2_sold' => $z_D_sold['county_all'][$t_c_sold - 3],
                'zll_cty2_sold' => $z_D_sold['city_all'][$t_c_sold - 3],

                'href_real_sold' => isset($price_data_real_sold['source_all'][0]) ? $price_data_real_sold['source_all'][0] : 0,
                'list_p_real_sold' => isset($price_data_real_sold['price_all'][0]) ? $price_data_real_sold['price_all'][0] : 0,
                'acre_real_sold' => isset($price_data_real_sold['acre_all'][0]) ? $price_data_real_sold['acre_all'][0] : 0,
                'real_price_per_sold' => isset($price_data_real_sold['price_all'][0]) ? number_format($price_data_real_sold['price_all'][0] / $price_data_real_sold['acre_all'][0], 2) : 0,
                'real_coun_sold' => isset($price_data_real_sold['county_all'][0]) ? $price_data_real_sold['county_all'][0] : 0,
                'real_cty_sold' => isset($price_data_real_sold['city_all'][0]) ? $price_data_real_sold['city_all'][0] : 0,


                'href_zll2' => $z_D['source_all'][$t_c - 3],
                'list_p_zll2' => $z_D['price_all'][$t_c - 3],
                'acre_zll2' => $z_D['acre_all'][$t_c - 3],
                'zll_price_per2' => number_format($z_D['price_all'][$t_c - 3] / $z_D['acre_all'][$t_c - 3], 2),
                'zll_coun2' => $z_D['county_all'][$t_c - 3],
                'zll_cty2' => $z_D['city_all'][$t_c - 3],

            ];
            //dd($data);
           // Create a response with the XML content
                $pdf = Pdf::loadView('pdf', $data);
                return $pdf->download('compreport.pdf');
               

        } catch (\Exception $e) {
            //$response = $e->getResponse();
            $emsg = $e->getMessage();
            //dd($emsg);
            $fromserver = isset($response) ? $response : 'No records found . or Server error';
            
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
        //dd($salescomps);
        //echo "Sales Price:\n";
        $sum = 0;
        $sum_acr = 0;
        $sum_d = 0;
        $arr = 0;

        foreach ($salescomps as $salescomp) {
            $sum += $salescomp['LastMarketSaleInformation']['SalePrice'];

            //if(!empty($salescomp['SitusAddress']['City']))
            // {
            $cities[] = $salescomp['SitusAddress']['City'];
           
            $sum_acr += $salescomp['SiteInformation']['Acres'];
            $sum_d += $salescomp['DistanceFromSubject'];

            $arr = [$sum, $sum_acr, $sum_d, $cities];
        }

        return $arr;
    }

    public function xmldownload(Request $request)
    {
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

        $salesdata = json_decode($sales->getBody(), true);
        $salesdata = json_decode($sales->getBody(), true);
        if ($salesdata['Reports'][0]['Data']['ComparableCount'] <= 0) {
            $error = 'Records not found';
            return  redirect()->to('compreport')->with('error', $error);
        }

        $sum_sale[0] = $this->getJsonArrayElements($salesdata);
        //dd($sum_sale[0]);
        $add_data[0] = $this->getPropertyData($salesdata);
          $address_property = isset($add_data[0][0][0]) ? $add_data[0][0][0] : $add_data[0][0][1];
        //dd($ab);
        //get zillow data 
        $zillow_sales = $client->request('GET', 'https://zillow-working-api.p.rapidapi.com/byaddress?propertyaddress=' . $address_property . '', [
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'x-rapidapi-host' => 'zillow-working-api.p.rapidapi.com',
                'x-rapidapi-key' => config('app.rapid_key')
            ],
            'body' => json_encode([
                'propertyaddress' => ''
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
                'x-rapidapi-host' => 'zillow-com1.p.rapidapi.com',
                'x-rapidapi-key' => config('app.rapid_key')
            ],
            'body' => json_encode([]),
        ]);
        
        /////sold comp end
        $city_red = $add_data[0][3][0];
        //dd($city_red);
        $redfin_sales_comp = $client->request('GET', 'https://redfin-com-data.p.rapidapi.com/properties/auto-complete?query=' . $city_red . '&limit=1', [
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'x-rapidapi-host' => 'redfin-com-data.p.rapidapi.com',
                'x-rapidapi-key' => config('app.rapid_key')
            ],
            'body' => json_encode([]),
        ]);
        $redfin_comp_data = json_decode($redfin_sales_comp->getBody(), true);
        //dd($redfin_comp_data);
        $region_id = $redfin_comp_data['data'][0]['rows'][0]['id'];
        //dd($region_id);
        $redfin_sales_comp = $client->request('GET', 'https://redfin-com-data.p.rapidapi.com/properties/search-sale?regionId=' . $region_id . '&lotSize=10890%2C21780&limit=20', [
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'x-rapidapi-host' => 'redfin-com-data.p.rapidapi.com',
                'x-rapidapi-key' => config('app.rapid_key')
            ],
            'body' => json_encode([]),
        ]);
        //dd(config('app.rapid_key'));

        $redfin_data = json_decode($redfin_sales_comp->getBody(), true);

        $zillow_comp_data = json_decode($zillow_sales_comp->getBody(), true);
        //dd($redfin_data);
        $rc = count($redfin_data);
        $zcs = count($zillow_comp_data);
        if($rc < $zcs)
        {
            $count = $rc;
        }

        if($zcs < $rc)
        {
            $count = $zcs;
        }
        //dd($count);
        if (!empty($redfin_data['data']) && !empty($zillow_comp_data)) {
            for ($i = 0; $i < $count; $i++) {
                $redfincor[] = $redfin_data['data'][$i];

                $zillowcor[] = $zillow_comp_data[$i]['longitude'] . ',' . $zillow_comp_data[$i]['latitude'];
            }
           
            $datatree = $propertydata['Reports'][0]['Data']['LocationInformation']['Longitude'] . ',' . $propertydata['Reports'][0]['Data']['LocationInformation']['Latitude'];
            //dd($redfincor);
            for ($i = 0; $i < count($zillowcor); $i++) {
                $zc[] = $zillowcor[$i];
            }
            //dd($redfincor[0]['homeData']['addressInfo']['centroid']['centroid']['longitude']);
            for ($i = 0; $i < count($redfincor); $i++) {
                $rf[] = $redfincor[$i]['homeData']['addressInfo']['centroid']['centroid']['longitude'] . ',' . $redfincor[$i]['homeData']['addressInfo']['centroid']['centroid']['latitude'];
            }
            $getallcordinates['dt'] = $datatree;
            $getallcordinates['zc'] = $zc;

            $getallcordinates['rf'] = $rf;

            // Create the XML content
            $xmlContent = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
            $xmlContent .= '<kml xmlns="http://www.opengis.net/kml/2.2">' . "\n";
            $xmlContent .= '  <Document>' . "\n";
            $xmlContent .= '    <name>Sale Comp</name>' . "\n";

            //dd($markers);
            $xmlContent .= '    <Placemark>' . "\n";
            $xmlContent .= '      <name>This is red marker</name>' . "\n";
            $xmlContent .= '      <description>Ths is main comp</description>' . "\n";
            $xmlContent .= '      <Point>' . "\n";
            $xmlContent .= '        <coordinates>' . $getallcordinates['dt'] . ',0</coordinates>' . "\n";
            $xmlContent .= '      </Point>' . "\n";
            $xmlContent .= '      <Style>' . "\n";
            $xmlContent .= '        <IconStyle>' . "\n";
            $xmlContent .= '          <scale>2.5</scale>' . "\n"; // Adjust the scale here
            $xmlContent .= '          <Icon>' . "\n";
            $xmlContent .= '            <href>http://maps.google.com/mapfiles/kml/paddle/purple-diamond.png</href>' . "\n";
            $xmlContent .= '          </Icon>' . "\n";
            $xmlContent .= '        </IconStyle>' . "\n";
            $xmlContent .= '      </Style>' . "\n";
            $xmlContent .= '    </Placemark>' . "\n";

            for ($i = 0; $i < $count; $i++) {

                //dd($marker);

                $xmlContent .= '    <Placemark>' . "\n";
                $xmlContent .= '      <name>' . htmlentities($zillow_comp_data[$i]['address']['streetAddress']) . '</name>' . "\n";
                $xmlContent .= '      <description>' . $zillow_comp_data[$i]['price'] . '</description>' . "\n";
                $xmlContent .= '      <Point>' . "\n";
                $xmlContent .= '        <coordinates>' . $getallcordinates['zc'][$i] . ',0</coordinates>' . "\n";
                $xmlContent .= '      </Point>' . "\n";
                $xmlContent .= '      <Style>' . "\n";
                $xmlContent .= '        <IconStyle>' . "\n";
                $xmlContent .= '          <scale>1.5</scale>' . "\n"; // Adjust the scale here
                $xmlContent .= '          <Icon>' . "\n";
                $xmlContent .= '            <href>http://maps.google.com/mapfiles/ms/icons/green-dot.png</href>' . "\n";
                $xmlContent .= '          </Icon>' . "\n";
                $xmlContent .= '        </IconStyle>' . "\n";
                $xmlContent .= '      </Style>' . "\n";
                $xmlContent .= '    </Placemark>' . "\n";

                $xmlContent .= '    <Placemark>' . "\n";
                $xmlContent .= '      <name>' . htmlentities($redfin_data['data'][$i]['homeData']['addressInfo']['formattedStreetLine']) . '</name>' . "\n";
                $xmlContent .= '      <description>' . $redfin_data['data'][$i]['homeData']['priceInfo']['amount'] . '</description>' . "\n";
                $xmlContent .= '      <Point>' . "\n";
                $xmlContent .= '        <coordinates>' . $getallcordinates['rf'][$i] . ',0</coordinates>' . "\n";
                $xmlContent .= '      </Point>' . "\n";
                $xmlContent .= '      <Style>' . "\n";
                $xmlContent .= '        <IconStyle>' . "\n";
                $xmlContent .= '          <scale>1.5</scale>' . "\n"; // Adjust the scale here
                $xmlContent .= '          <Icon>' . "\n";
                $xmlContent .= '            <href>http://maps.google.com/mapfiles/ms/icons/yellow-dot.png</href>' . "\n";
                $xmlContent .= '          </Icon>' . "\n";
                $xmlContent .= '        </IconStyle>' . "\n";
                $xmlContent .= '      </Style>' . "\n";
                $xmlContent .= '    </Placemark>' . "\n";
            }

            // foreach ($markers as $marker) {
            //     $xmlContent .= '    <Placemark>' . "\n";
            //     $xmlContent .= '      <name>' . $marker['name'] . '</name>' . "\n";
            //     $xmlContent .= '      <description>' . $marker['description'] . '</description>' . "\n";
            //     $xmlContent .= '      <Point>' . "\n";
            //     $xmlContent .= '        <coordinates>' . $marker['coordinates'] . '</coordinates>' . "\n";
            //     $xmlContent .= '      </Point>' . "\n";
            //     $xmlContent .= '      <Style>' . "\n";
            //     $xmlContent .= '        <IconStyle>' . "\n";
            //     $xmlContent .= '          <scale>1.5</scale>' . "\n"; // Adjust the scale here
            //     $xmlContent .= '          <Icon>' . "\n";
            //     $xmlContent .= '            <href>' . $marker['icon'] . '</href>' . "\n";
            //     $xmlContent .= '          </Icon>' . "\n";
            //     $xmlContent .= '        </IconStyle>' . "\n";
            //     $xmlContent .= '      </Style>' . "\n";
            //     $xmlContent .= '    </Placemark>' . "\n";
            // }


            $xmlContent .= '  </Document>' . "\n";
            $xmlContent .= '</kml>';
            return response($xmlContent)
                ->header('Content-Type', 'application/vnd.google-earth.kml+xml')
                ->header('Content-Disposition', 'attachment; filename="simple_placemark.kml"');
        } else {
            $error = 'sale comp data not found';
            return  redirect()->to('compreport')->with('error', $error);
        }
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

        $arr = 0;
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
                return $ad;
            }
        }
    }
    function getRedfinData($jsonData)
    {
        $data = $jsonData;
        //dd($data);

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
            $pric = isset($redfincomp['homeData']['priceInfo']['amount']) ? $redfincomp['homeData']['priceInfo']['amount'] : 0;
            $price_sum += $pric;
            $sqft = isset($redfincomp['homeData']['lotSize']['amount']) ? $redfincomp['homeData']['lotSize']['amount'] : 0;
            //dd($sqft);

            $acre_ = number_format($sqft / 43560, 2);
            $source = $redfincomp['homeData']['url'];
            $list_price = isset($redfincomp['homeData']['priceInfo']['amount']) ? $redfincomp['homeData']['priceInfo']['amount'] : 0;
            $county = $redfincomp['homeData']['addressInfo']['state'];
            $lat[] = $redfincomp['homeData']['addressInfo']['centroid']['centroid']['latitude'] . ',' . $redfincomp['homeData']['addressInfo']['centroid']['centroid']['longitude'];

            $city = isset($redfincomp['homeData']['addressInfo']['city']) ? $redfincomp['homeData']['addressInfo']['city'] : '';

            $acre[] = number_format($sqft / 43560, 2);
            $acre_sum += number_format($sqft / 43560, 2);
            $redf = [
                'lat' => $lat,
                'data' => $redfincomp,
                'p_id' => $p_id,
                'pr_sum' => $price_sum,
                'pric' => $pric,
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
        $sale_sum = 0;

        foreach ($zillowcomps as $zillowcomp) {
            $price = $zillowcomp['price'];
            $sqft = $zillowcomp['livingArea'];
            $sqft_all[] = $zillowcomp['livingArea'];

            $acre_ = number_format($sqft / 43560, 2);
            $acre_all[] = number_format($sqft / 43560, 2);

            $source = $zillowcomp['zpid'];
            $list_price = $zillowcomp['price'];
            $county = $zillowcomp['address']['state'];
            $city = $zillowcomp['address']['city'];

            $price_all[] = $zillowcomp['price'];
            $source_all[] = $zillowcomp['zpid'];
            $county_all[] = $zillowcomp['address']['state'];
            $city_all[] = $zillowcomp['address']['city'];
            $sum += $price;
            $sale_sum = [
                'sum' => $sum,
                'acre' => $acre_,
                'source' =>  $source,
                'price' => $list_price,
                'county' => $county,
                'city' => $city,
                'county_all' => $county_all,
                'city_all' => $city_all,
                'acre_all' => $acre_all,
                'price_all' => $price_all,
                'source_all' => $source_all,
            ];
        }
        return $sale_sum;
    }

    function getRealtorData($jsonData)
    {
        $data = $jsonData;
        //dd($data);

        if ($data === null) {
            echo "Error decoding JSON data.";
            return;
        }

        // Get states array
        $realtorcomps = $data['data']['results'];
        $sale_sum1 = 0;
        $sum = 0;
        $acre_sum = 0;

        foreach ($realtorcomps as $realtorcomp) {
            //dd($realtorcomp);
            $price = $realtorcomp['list_price'];
            $sum += $price;
            $sqft = isset($realtorcomp['description']['lot_sqft']) ? $realtorcomp['description']['lot_sqft'] : $realtorcomp['description']['sqft'];
            //dd($sqft);
            $acre[] = number_format($sqft / 43560, 2);
            $acre_sum += number_format($sqft / 43560, 2);
            $acre_ = number_format($sqft / 43560, 2);
            $source = $realtorcomp['href'];
            $price_all[] = $realtorcomp['list_price'];
            $source_all[] = $realtorcomp['href'];
            $list_price = $realtorcomp['list_price'];
            //$county = $realtorcomp['location']['county']['name'];
            /* $county_all[] = $realtorcomp['location']['county']['name'];*/
            $city = $realtorcomp['location']['address']['city'];
            $city_all[] = $realtorcomp['location']['address']['city'];
            //dd($realtorcomp['location']['address']);
            //dd($county);
            //dd($county);
            //dd($sum);
            $sale_sum1 = [
                'price_sum' => $sum,
                'pr' => $price,
                'acre_sum' => $acre_sum,
                /*'data' => $realtorcomp,
                'county_all' => $county_all,*/
                'city_all' => $city_all,
                'acre_all' => $acre,
                'price_all' => $price_all,
                'source_all' => $source_all,
                'acre' => $acre_,
                'source' =>  $source,
                'price' => $list_price,
                //'county' => $county,
                'city' => $city
            ];
            //dd($sale_sum);
            //href,list_price,location->county->name,description->lot_sqft,location->address->city
        }
        return $sale_sum1;
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
