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
            'expires_in' => auth()->factory()->getTTL() * 60,
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
            $msg = json_decode($response->getBody()->getContents(), true);

            return  back()->with('error', $msg['Message']);
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
        $cp = $request->cp;

        $info = [$acr1,$acr2];
        $ct = count($info);
        try{
        for ($i = 0; $i < $ct-1; $i++) {
                $numbers = $i;
                $info[] = $numbers;
            //}
        //dd($info);
        //for ($i = 0; $i < sizeof($info) - 1; $i++) {
            // try {

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
                                        ' . $info[$i] . ',
                                        ' . $info[$i + 1] . '
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
                                {

                                    "FilterName": "YearBuilt",

                                    "FilterOperator": "is between",

                                    "FilterValues": ["1800", "2024"],

                                    "FilterGroup": 1

                                },

                                {

                                    "FilterName": "ForSaleListedPrice",

                                    "FilterOperator": "is between",

                                    "FilterValues": ["1", "10000000"],

                                    "FilterGroup": 1

                                }, {

                                    "FilterName": "TotalNumberOfBedrooms",

                                    "FilterOperator": "is between",

                                    "FilterValues": ["1", "2"],

                                    "FilterGroup": 1

                                }, {

                                    "FilterName": "TotalNumberOfbathrooms",

                                    "FilterOperator": "is",

                                    "FilterValues": ["1"],

                                    "FilterGroup": 1

                                },
                            ] //
                        } //
                    }',
            ]);
        }
        $data[] = json_decode($res->getBody(), true);
        //dd($data);

        $maxcount = $data[0]['MaxResultsCount'];
        $acr_range = $acr1 . '-' . $acr2;
       
        $p_id = $data[0]['LitePropertyList'][0]['PropertyId'];
        $loop = $data[0]['LitePropertyList'];
       
        $getProperty = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $authenticate,
            ],
            'body' => json_encode([
                'ProductNames' => ['PropertyDetailReport'],

                "SearchType" => "PROPERTY",
                "PropertyId" => $p_id
            ]),
        ]);
        
        $price = json_decode($getProperty->getBody(), true);
        $sale_price = $price['Reports'][0]['Data']['LastMarketSaleInformation']['SalePrice'];
        $mainval = 1 * 0.01;
        //now get property id sal eprice 
        return view('priceland', compact('maxcount', 'loop','mainval', 'acr_range', 'data', 'sale_price'));
        } catch (\Exception $e) {
            //throw new HttpException(500, $e->getMessage());
            $response = $e->getResponse();
            $msg = json_decode($response->getBody()->getContents(), true);

            return  back()->with('error', $msg['Message']);
        }
    }
    public function loadHome()
    {
        return view('welcome');
    }
    public function Logout()
    {
        auth()->logout();
        return redirect()->to('login2');
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
            // dd($redfin_d);
            $sum_acre = $redfin_d['sum_acre'];
            $total_red = count($redfin_d['p_id']);
            $total_prce_sum_red = str_replace(',', '', $redfin_d['pr_sum']);
            $av_acre_red = number_format($sum_acre / $total_red, 2);
            $average_red = number_format($redfin_d['pr_sum'] / $total_red, 2);
            $avg_per_acre_red = number_format($total_prce_sum_red / $sum_acre, 2);


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
                'geo_adjusted' => $geo_adjust_price
            ];
            $pdf = Pdf::loadView('pdf', $data);
            return $pdf->download('compreport.pdf');
        } catch (\Exception $e) {
            //throw new HttpException(500, $e->getMessage());
            $response = $e->getResponse();
            $fromserver = 'Server error';
            $msg = json_decode($response->getBody()->getContents(), true);
            $error = $msg ? $msg : $fromserver;
            //dd($response['reasonPhrase']);
            return  back()->with('error', $error);
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
            $acre[] = number_format($sqft / 43560, 2);
            $acre_sum += number_format($sqft / 43560, 2);
            $redf = [
                'p_id' => $p_id,
                'pr_sum' => $price_sum,
                'acre' => $acre,
                'sum_acre' => $acre_sum
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
