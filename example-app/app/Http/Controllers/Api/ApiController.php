<?php

namespace App\Http\Controllers\Api;

use Pdf;
use Mail;
use GuzzleHttp;
use App\Models\User;
use App\Models\Export;
use App\Exports\CompExport;
use App\Jobs\ExportDataJob;
use App\Models\PriceReport;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\PasswordReset;
use Illuminate\Support\Carbon;
use App\Models\PriceHouseReport;
use App\Exports\PriceHouseExport;
use App\Jobs\FetchPriceReportJob;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Jobs\FetchPriceHouseReportJob;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Api\BaseController;
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
            'password' => 'required|confirmed|min:8',
            'password_confirmation' => 'required',
            'agree' => 'required',
        ]);

        if ($validator->fails()) {
            //return redirect()->back()->with(['error' => $validator,
            //'user' => $request]);

            //return redirect()->route('register')->withErrors($validator);

            return redirect()->back()->with([
                'error' => $validator->errors(),
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
                'password_confirmation' => $request->password_confirmation,
            ]);
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
            $data['body'] = 'Please click the link below to verify your email address';
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
            return redirect()->back()->with('success', 'Please check your inbox and verify your email.');
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
        //dd($request);
        // if (auth()->user()) {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'email' => 'required|email',
            'name' => 'required|string|min:5',
        ]);
        if ($validator->fails()) {
            return redirect()->route('dashboard')->withErrors($validator);

            //return response()->json($validator->errors());
        }
        $user = User::find($request->id);
        //dd($user);
        $user->name = $request->name;
        if ($user->email != $request->email) {
            $user->is_verified = 0;
        }
        $user->email = $request->email;
        $user->save();
        return redirect()->back()->with('success', 'user updated successfully');

        /*return response()->json([
                'success' => true,
                'message' => 'User updated successfully',
                'data' => $user
            ]);*/
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
        $domain = URL::to('/');
        $user = User::where('remember_token', $token)->get();
        if (count($user) > 0) {
            $user =  User::find($user[0]['id']);
            $user->remember_token = '';
            $user->email_verified_at = $datetime;
            $user->is_verified = 1;
            $user->save();

            return "<h1>email verified successfully <a href=$domain.'/login'>Sign in </a></h1>";
        } else {
            return view('404');
        }
    }

    public function loadLogin()
    {
        return view('login');
    }

    public function forgetPasswordLoad()
    {
        return view('forget');
    }

    public function resetPasswordLoad(Request $request)
    {
        $resetData = DB::table('password_reset_tokens')->where('token', $request->token)->get();
        $rest = json_decode($resetData,true);
        //dd($rest);
        if (isset($resetData) && count($resetData) > 0) {
            $user = User::where('email', $rest[0]['email'])->get();
            return view('reset', compact('user'));
        } else {
            return view('404');
        }
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
            'password' => 'required|min:8'
        ]);

        if ($validator->fails()) {
            return redirect()->route('userLogin')->withErrors($validator);
        }

        $user = DB::table('users')->where(['email' => $request->email])->get();
        //dd($user);
        $checkempty = json_decode($user, true);
        //dd($checkempty);
        $is_verified = $checkempty[0]['is_verified'];
        if ($is_verified == '0') {
            return redirect()->back()->with('error', 'cant login.User password mismatch or Email is not verified');
        }
        if (!empty($checkempty)) {
            $checkpas = Hash::check($request->password, $checkempty[0]['password']);
            if (Hash::check($request->password, $checkempty[0]['password'])) {
                $token = Auth::attempt($userCredentials);
                $success = $this->respondWithToken2($token);
                if ($success) {
                    return view('dashboard', ['data' => $token]);
                }
            } else {
                return redirect()->back()->with('error', 'cant login.password mismatch');
            }
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
        set_time_limit(300);
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
            $res_ = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
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
            $data = json_decode($res_->getBody(), true);
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
            \Log::error('ExportDataJob failed: ' . $e->getMessage());
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
    public function downloadExport($fileName)
    {
        // Check if the file exists in the storage
        if (!Storage::disk('public')->exists($fileName)) {
            return redirect()->back()->with('error', 'File not found.');
        }

        return response()->download(storage_path("app/public/{$fileName}"));
        //Export::where('file_name', $fileName)->update(['downloaded' => true]);

    }

    public function deletefromStorage()
    {
        $getFiles = Export::where('downloaded', 1)->get();
        $arrayfiles = json_decode(json_encode($getFiles), true);
        foreach ($arrayfiles as $getall) {
            $filepath = 'public/' . $getall['file_name'];
            Storage::delete($filepath);
        }
    }

    public function showExports()
    {
        $exports = auth()->user()->exports; // Assuming you have a relationship set up

        return view('exports', compact('exports'));
    }

    public function contactForm(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'name' => 'required|min:5',
                'phone' => 'required',
                'comment' => 'required'
            ]);
    
            if ($validator->fails()) {
                return redirect()->route('contactForm')->withErrors($validator);
            }
            //$user =  User::where('email', $request->email)->get();
            //if (count($user) > 0) {
                $token = Str::random(40);
                $domain = URL::to('/');
                //$url = $domain . '/reset?token=' . $token;
                //$data['url'] = $url;
                $data['email'] = $request->email;
                $data['name'] = $request->name;
                $data['phone'] = $request->phone;
                $data['comment'] = $request->comment;
                $data['title'] = 'Contact Form';
                $data['body'] = 'We will contact you soon.';
                Mail::send('contactEmail', ['data' => $data], function ($message) use ($data) {
                    $message->to('support@propelyze.com')->subject($data['title']);
                });
                Mail::send('userContactEmail', ['data' => $data], function ($message) use ($data) {
                    $message->to($data['email'])->subject($data['title']);
                });
                

                return back()->with('success', 'Email send successfully');
            //} else {
              //  return back()->with('error', 'email not found');
            //}
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function forgetPassword(Request $request)
    {
        try {
            $user =  User::where('email', $request->email)->get();
            if (count($user) > 0) {
                $token = Str::random(40);
                $domain = URL::to('/');
                $url = $domain . '/reset?token=' . $token;
                $data['url'] = $url;
                $data['email'] = $request->email;
                $data['title'] = 'Reset Password';
                $data['body'] = 'Please click on below link to reset password';
                Mail::send('forgetPasswordMail', ['data' => $data], function ($message) use ($data) {
                    $message->to($data['email'])->subject($data['title']);
                });
                $dateTime = Carbon::now()->format('Y-m-d H:i:s');
                PasswordReset::updateOrCreate(['email' => $request->email], [
                    'email' => $request->email,
                    'token' => $token,
                    'created_at' => $dateTime
                ]);

                return back()->with('success', 'Please check your email to reset your password');
            } else {
                return back()->with('error', 'email not found');
            }
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function resetPassword(Request $request)
    {
        //dd($request);
        $request->validate([
            'password' => 'required|confirmed|min:8',
            'password_confirmation' => 'required',
        ]);
        //dd($request->id);
        $user = DB::table('users')->where('id',$request->id)->get();
        //dd($user);
        $user['password'] = Hash::make($request->password);
        $update = User::where('id',$request->id)->update(['password'=> $user['password']]);
        if(isset($update))
        {
        //DB::table('password_reset_tokens')->where('email',$user[0]->email)->delete();
        return back()->with('success','Password reset successfully');
        }
                //PasswordReset::where('email',$user[0]->email)->delete();


    }
    public function exportPriceHouse(Request $request)
    {
        // Validate incoming request
        /*dd($request);*/
        $validatedData = $request->validate([
            'userIds' => 'required|array',
            //'userIds.*' => 'integer', // Assuming user IDs are integers
        ]);


        // Dispatch the job for exporting
        ExportDataJob::dispatch($validatedData['userIds'], auth()->user());

        return response()->json([
            'message' => 'Your export is being processed. You will be notified through email once it is ready.',
        ]);
        //return redirect()->back()->with('message', 'Your export is being processed. You will be notified once it is ready.');
    }


    public function export_house_comp($ids)
    {
        //dd($ids);
        $convert = json_decode($ids, true);
        //when stripe payment done then can download report
        return Excel::download(new PriceHouseExport($convert), 'comp.xlsx');
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

    public function loadProperty2()
    {
        return view('property2');
    }
    public function insert_prop_detail2()
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
                                   41
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
                                   37
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
                                   38
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
                                   39
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
                                   40
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
                                   42
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
                                   46
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
                                   44
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
                                   45
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
                                   47
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
                                   48
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
                                   49
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
                                   50
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
                                   51
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
                                   53
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
                                   54
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
                                   55
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
                                   56
                                ],
                                "FilterGroup": 1
                            }                              
                        ] //
                    } //
                }',
        ]);
        $de[] = json_decode($res->getBody(), true);
        //dd($de);
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
                                   31
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
                                   32
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
                                   33
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
                                   34
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
                                   35
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
                                   36
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
                                   37
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
                                   38
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
                                   39
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
                                   40
                                ],
                                "FilterGroup": 1
                            }                              
                        ] //
                    } //
                }',
        ]);
        $de[] = json_decode($res->getBody(), true);
        //dd($de);
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
        // dd($request);
        $validatedData = $request->validate([
            'state1' => 'required|string',
            'county_name1' => 'required|string',
            'cp1' => 'required|string'
        ]);
        //dd($validatedData);
        $existingReport = PriceHouseReport::where([
            'state' => $validatedData['state1'],
            'county_name' => $validatedData['county_name1'],
            //'user_id' => $userid, // Assuming you want to check for the specific user
        ])->first();

        if ($existingReport) {
            // Record already exists, handle accordingly
            //dd($existingReport['sts']);
            return redirect()->route('get.house.results')->with(
                [
                    'message' => 'This report already exists. Here are your results.',
                    'existingReport' => $existingReport // Pass the existing report data if needed
                ]
            );
        }


        FetchPriceHouseReportJob::dispatch($validatedData['state1'], $validatedData['county_name1'], $validatedData['cp1']);
        $url = route('pricehouse');
        return redirect()->to($url)->with(
            [
                'message' => 'Your report is being generated. You can check back shortly.',

            ]
        );
    }

    public function GetPriceResearchReport(Request $request)
    {
        //dd($request);
        set_time_limit(520); // Increase the max execution time

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
            'la'   => 22,
            'me'    => 23,
            'md'   => 24,
            'ma' => 25,
            'mi'  => 26,
            'mn'  => 27,
            'ms'  => 28,
            'mo'  => 29,
            'mt'    => 30,
            'ne'    => 31,
            'nv'   => 32,
            'nh'   => 33,
            'nj'   => 34,
            'nm'  => 35,
            'ny'   => 36,
            'nc'   => 37,
            'nd'   => 38,
            'oh'  => 39,
            'ok'   => 40,
            'or'   => 41,
            'pa'    => 42,
            'ri'    => 44,
            'sc' => 45,
            'sd'   => 46,
            'tn'   => 47,
            'tx'   => 48,
            'ut'   => 49,
            'vt'   => 50,
            'va'   => 51,
            'wa'   => 53,
            'wv'  => 54,
            'wi'   => 55,
            'wy'   => 56
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

            $response = $e->getMessage();

            $error = isset($response) ? $response : '';
            //dd($response['reasonPhrase']);
            return  redirect()->to('research')->with('error', $error);
        }

        //dd($data);
        ///////////////////////////

    }

    public function GetPriceReport(Request $request)
    {
        // Validate input
        $validatedData = $request->validate([
            'state' => 'required|string',
            'county_name' => 'required|string',
        ]);
        $userid = auth()->user()->id;

        $existingReport = PriceReport::where([
            'state' => $validatedData['state'],
            'county_name' => $validatedData['county_name'],
            //'user_id' => $userid, // Assuming you want to check for the specific user
        ])->first();

        if ($existingReport) {
            // Record already exists, handle accordingly
            return redirect()->route('get.report.results')->with(
                [
                    'message' => 'This report already exists. Here are your results.',
                    'existingReport' => $existingReport // Pass the existing report data if needed
                ]
            );
        }


        // Dispatch the job
        FetchPriceReportJob::dispatch($validatedData['state'], $validatedData['county_name'], $request['cp'], $userid);
        // Prepare the URL to fetch results
        $url = route('priceland'); // Use named route for better practice        //return '<a href="'.$url.'">Show Results</a>';

        //return Redirect::intended($url);
        return redirect()->to($url)->with(
            [
                'message' => 'Your report is being generated. You can check back shortly.',
            ],
        );
    }


    public function getReportHouseResults(Request $request)
    {
        // Validate input
        //dd($request);
        $report = session()->get('existingReport');
        /*$state = session()->get('state1');
        $county = session()->get('county_name1');

        //dd(session()->get('message'));

        // Fetch the latest report
        $report = PriceHouseReport::where('state', $state)
            ->where('county_name', $county)
            ->latest()
            ->first();

        if (!$report) {
            return redirect()->back()->with('message', 'Getting recods...');
            //return response()->json(['message' => 'Report not available yet.'], 404);
        }*/

        $de = json_decode($report['de'], true);
        $mainval = 0.1;
        $price = json_decode($report['price'], true);
        //dd($price);
        $sts = json_decode($report['sts'], true);
        return view('pricehouse', compact('de', 'mainval', 'price', 'sts'));
    }

    public function getReportResults(Request $request)
    {
        // Validate input
        //dd($request);
        $report = session()->get('existingReport');

        /*$state = session()->get('state');
        $county = session()->get('county');

        // Fetch the latest report
        $report = PriceReport::where('state', $state)
            ->where('county_name', $county)
            ->latest()
            ->first();
        //dd($report);

        if (!$report) {
            return redirect()->back()->with('message', 'Getting recods...');

            //return response()->json(['message' => 'Report not available yet.'], 404);
        }*/

        $de = json_decode($report['de'], true);
        $mainval = 0.1;
        $price = json_decode($report['price'], true);
        //dd($price);
        $sts = json_decode($report['sts'], true);
        return view('priceland', compact('de', 'mainval', 'price', 'sts'));
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
            //return redirect()->route('login')->with('success','logout sucessfully');

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false]);
        }
    }
    public function pdf_download2(Request $request)
    {
        //dd($request->id);
        set_time_limit(520); // Increase the max execution time

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
            //if no record then he should not check pdf 

            if ($salesdata['Reports'][0]['Data']['ComparableCount'] <= 0) {
                $error = 'We are unable to get Comp Records...';
                return  redirect()->to('compreport')->with('error', $error);
            }
            //dd($salesdata);
            $average_county = $salesdata['Reports'][0]['Data']['ComparablePropertiesSummary']['SaleListedPrice']['Low'];
            //dd($salesdata);

            $sum_sale[0] = $this->getJsonArrayElements($salesdata);
            foreach ($sum_sale[0][3] as $x => $y) {
                if ($y != null) {
                    $add_prop[] = $y;
                }
            }
            //dd($add_prop);
            $price[0] = $this->getPrice($salesdata);
            //dd($price[0]);
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

            $zillow_sol = $client->request('GET', 'https://zillow-working-api.p.rapidapi.com/search/byaddress?location=' . $add_prop[0] . '&sortOrder=Newest&listingStatus=Sold', [
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
            $zillow_sol_data = json_decode($zillow_sol->getBody(), true);
            // dd($zillow_sol_data);
            $zpid_sol = $zillow_sol_data['searchResults'][0]['property']['zpid'];
            //dd($zpid_sol);



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
            $zillow_sold_comp = $client->request('GET', 'https://zillow-com1.p.rapidapi.com/similarSales?zpid=' . $zpid_sol . '', [
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
            // dd($redfin_sold_data);
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
            //dd($zillow_sold_comp);

            //
            //dd($zillow_comp_data);
            $z_D = $this->getZillowData($zillow_comp_data);
            //dd($z_D);
            $z_D_sold = $this->getZillowData($zillow_comp_data_sold);

            //dd($z_D_sold['acre_all']);

            $t_c = count($z_D);
            $t_c_sold = count($zillow_comp_data_sold);


            //dd($z_D);
            //dd($z_D_sold);


            $total_rec = count($zillow_comp_data);
            $total_rec_sold = count($zillow_comp_data_sold);
            //dd($zillow_comp_data_sold);
            //$avg_acr_ll_sold = isset($avg_acr_ll_sold) ? $avg_acr_ll_sold : 0;

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
            $city_market_av = number_format((float)($mar_pr / $avr_acr), 2);
            $geo_adjusted_market_av = number_format((float)($geo_adjusted / $avr_acr), 2);
            $avg_price_river_market_av = number_format((float)($average_price_river / $avr_acr), 2);



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
                'city_market_av' => $city_market_av,
                'geo_adjusted_market_av' =>  $geo_adjusted_market_av,
                'average_price_river' => $average_price_river,
                'avg_price_river_market_av' => $avg_price_river_market_av,
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

                'href_zll3_sold' => $z_D_sold['source_all'][$t_c_sold - 4],
                'list_p_zll3_sold' => $z_D_sold['price_all'][$t_c_sold - 4],
                'acre_zll3_sold' => $av_per_acre_zill_sold,
                'zll_price_per3_sold' => number_format($z_D_sold['price_all'][$t_c_sold - 4] / $av_per_acre_zill_sold, 2),
                'zll_coun3_sold' => $z_D_sold['county_all'][$t_c_sold - 4],
                'zll_cty3_sold' => $z_D_sold['city_all'][$t_c_sold - 4],

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


                'href_zll3' => $z_D['source_all'][$t_c - 4],
                'list_p_zll3' => $z_D['price_all'][$t_c - 4],
                'acre_zll3' => $z_D['acre_all'][$t_c - 4],
                'zll_price_per3' => number_format($z_D['price_all'][$t_c - 4] / $z_D['acre_all'][$t_c - 4], 2),
                'zll_coun3' => $z_D['county_all'][$t_c - 4],
                'zll_cty3' => $z_D['city_all'][$t_c - 4],


            ];
            //dd('122');
            /*$data = [
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
                'market_av' => $market_av,
                'city_market_av' => $city_market_av,
                'geo_adjusted_market_av' => $geo_adjusted_market_av,
                'average_price_river' => $average_price_river,
                'avg_price_river_market_av' => $avg_price_river_market_av,
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
               

            ];
            
            foreach (['real', 'red','redfin', 'zll', 'zll_sold', 'real_sold'] as $prefix) {
                for ($i = 0; $i < 5; $i++) {
                    $suffix = $i > 0 ? "_$i" : '';
                    $data["href_{$prefix}{$suffix}"] = isset(${"{$prefix}_d"}['source_all'][$i]) ? ${"{$prefix}_d"}['source_all'][$i] : 0;
                    $data["list_p_{$prefix}{$suffix}"] = isset(${"{$prefix}_d"}['price_all'][$i]) ? ${"{$prefix}_d"}['price_all'][$i] : 0;
                    $data["acre_{$prefix}{$suffix}"] = isset(${"{$prefix}_d"}['acre_all'][$i]) ? ${"{$prefix}_d"}['acre_all'][$i] : 0;
                    $data["{$prefix}_price_per{$suffix}"] = isset(${"{$prefix}_d"}['price_all'][$i]) ? number_format(${"{$prefix}_d"}['price_all'][$i] / ${"{$prefix}_d"}['acre_all'][$i], 2) : 0;
                    $data["{$prefix}_coun{$suffix}"] = isset(${"{$prefix}_d"}['county_all'][$i]) ? ${"{$prefix}_d"}['county_all'][$i] : '';
                    $data["{$prefix}_cty{$suffix}"] = isset(${"{$prefix}_d"}['city_all'][$i]) ? ${"{$prefix}_d"}['city_all'][$i] : '';
                }
            }
            
            // For sold data specifically
            foreach (['real','red_sold', 'zll_sold'] as $prefix) {
                for ($i = 0; $i < 5; $i++) {
                    $suffix = $i > 0 ? "_$i" : '';
                    $data["href_{$prefix}{$suffix}"] = isset(${"{$prefix}_sold_d"}['source_all'][$i]) ? ${"{$prefix}_sold_d"}['source_all'][$i] : 0;
                    $data["list_p_{$prefix}{$suffix}"] = isset(${"{$prefix}_sold_d"}['price_all'][$i]) ? ${"{$prefix}_sold_d"}['price_all'][$i] : 0;
                    $data["acre_{$prefix}{$suffix}"] = isset(${"{$prefix}_sold_d"}['acre_all'][$i]) ? ${"{$prefix}_sold_d"}['acre_all'][$i] : 0;
                    $data["{$prefix}_price_per{$suffix}"] = isset(${"{$prefix}_sold_d"}['price_all'][$i]) ? number_format(${"{$prefix}_sold_d"}['price_all'][$i] / ${"{$prefix}_sold_d"}['acre_all'][$i], 2) : 0;
                    $data["{$prefix}_coun{$suffix}"] = isset(${"{$prefix}_sold_d"}['county_all'][$i]) ? ${"{$prefix}_sold_d"}['county_all'][$i] : '';
                    $data["{$prefix}_cty{$suffix}"] = isset(${"{$prefix}_sold_d"}['city_all'][$i]) ? ${"{$prefix}_sold_d"}['city_all'][$i] : '';
                }
            }*/

            //dd($data);
            // Create a response with the XML content
            $pdf = Pdf::loadView('pdf2', $data);
            return $pdf->download('compreport.pdf');
        } /*catch (\Exception $e) {
            // Log the exception
            \Log::error('PdfDownload failed: ' . $e->getMessage());

            // Optionally throw the exception to trigger a retry
            throw $e;
        }*/ catch (\Exception $e) {
            //$response = $e->getResponse();
            $emsg = $e->getMessage();
            \Log::error('PdfDownload failed: ' . $e->getMessage());
            //dd($emsg);
            $fromserver = isset($response) ? $response : 'No records found . or Server error';

            $error = $emsg;
            //dd($response['reasonPhrase']);
            //return  redirect()->to('compreport')->with('error', $error);
            return  redirect()->to('compreport')->with('error', 'something went wrong');
        }
    }
    // Function to get JSON array elements and their values
    function getJsonArrayElements($jsonData)
    {
        //dd(jsonData)
        try {
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
        } catch (\Exception $e) {
            // Log the exception
            \Log::info('getjsonarray failed: ' . $e->getMessage());

            // Optionally throw the exception to trigger a retry
            throw $e;
        }
    }

    public function xmldownload(Request $request)
    {
        //dd($request->id);
        try {
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
            if ($salesdata['Reports'][0]['Data']['ComparableCount'] <= 0) {
                $error = 'We are unable to get Comp Records...';
                return  redirect()->to('compreport')->with('error', $error);
            }

            $sum_sale[0] = $this->getJsonArrayElements($salesdata);
            foreach ($sum_sale[0][3] as $x => $y) {
                if ($y != null) {
                    $add_prop[] = $y;
                }
            }
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

            $zillow_sol = $client->request('GET', 'https://zillow-working-api.p.rapidapi.com/search/byaddress?location=' . $add_prop[0] . '&sortOrder=Newest&listingStatus=Sold', [
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
            $zillow_sol_data = json_decode($zillow_sol->getBody(), true);
            // dd($zillow_sol_data);
            $zpid_sol = $zillow_sol_data['searchResults'][0]['property']['zpid'];

            $zillow_sold_comp = $client->request('GET', 'https://zillow-com1.p.rapidapi.com/similarSales?zpid=' . $zpid_sol . '', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'x-rapidapi-host' => 'zillow-com1.p.rapidapi.com',
                    'x-rapidapi-key' => config('app.rapid_key')
                ],
                'body' => json_encode([]),
            ]);
            $zillow_comp_data_sold = json_decode($zillow_sold_comp->getBody(), true);

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
            $redfin_sold_data = json_decode($redfin_sold_comp->getBody(), true);
            $zillow_comp_data = json_decode($zillow_sales_comp->getBody(), true);
            // dd($zillow_comp_data);

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

            //dd($realtor_sold);
            //dd($zillow_comp_data_sold);
            //dd($redfin_sold_data);
            //dd($realtor);



            if (!empty($redfin_data['data']) && !empty($zillow_comp_data) && !empty($realtor['data']['results'])) {
                $rc = count($redfin_data['data']);
                //dd($rc);
                $zcs = count($zillow_comp_data);

                $real_c = count($realtor['data']['results']);
                //dd($real_c);
                //dd($zcs);
                $count1 = $rc <= $zcs ? $rc : $zcs;
                $count = $real_c <= $count1 ? $real_c : $count1;
                //dd($real_c);

                //$count = 

                //dd($count);
                for ($i = 0; $i < $count; $i++) {
                    $redfincor[] = $redfin_data['data'][$i];

                    $realtr[] = $realtor['data']['results'][$i];

                    $zillowcor[] = $zillow_comp_data[$i]['longitude'] . ',' . $zillow_comp_data[$i]['latitude'];
                }
                //dd($realtr);
                //dd($realtr[0]['location']['address']['coordinate']['lon']);
                for ($i = 0; $i < count($realtr); $i++) {
                    if ($realtr[$i]['location']['address']['coordinate'] != null) {
                        $real[] = $realtr[$i]['location']['address']['coordinate']['lon'] . ',' . $realtr[$i]['location']['address']['coordinate']['lat'];
                    }
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
                $getallcordinates['rea'] = $real;
                $count_real = count($real);
                $count_zc = count($zillowcor);
                $count_red = count($redfincor);

                $count_1 = $count_red <= $count_zc ? $count_red :  $count_zc;
                $cordinates_count = $count_real <= $count_1 ? $count_real : $count_1;
                //dd($cordinates_count);
                //dd($getallcordinates);

                // Create the XML content
                $xmlContent = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
                $xmlContent .= '<kml xmlns="http://www.opengis.net/kml/2.2">' . "\n";
                $xmlContent .= '  <Document>' . "\n";
                $xmlContent .= '    <name>Sale Comp</name>' . "\n";

                //dd($markers);
                $xmlContent .= '    <Placemark>' . "\n";
                $xmlContent .= '      <name>Ths is main comp</name>' . "\n";
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
                //dd($zillow_comp_data);
                //dd($redfin_data);
                //dd($realtr);
                //dd($realtr[0]['location']['address']['city']);

                if (!empty($redfin_sold_data['data']) && !empty($zillow_comp_data_sold) && !empty($realtor_sold['data']['results'])) {
                    $rc_sold = count($redfin_sold_data['data']);
                    //dd($rc);
                    $zcs_sold = count($zillow_comp_data_sold);

                    $real_c_sold = count($realtor_sold['data']['results']);
                    //dd($real_c);
                    //dd($zcs);
                    $count1_sold = $rc_sold <= $zcs_sold ? $rc_sold : $zcs_sold;
                    $count_sold = $real_c_sold <= $count1_sold ? $real_c_sold : $count1_sold;
                    //dd($real_c);

                    //$count = 

                    //dd($count);
                    for ($i = 0; $i < $count_sold; $i++) {
                        $redfincor_sold[] = $redfin_sold_data['data'][$i];

                        $realtr_sold[] = $realtor_sold['data']['results'][$i];

                        $zillowcor_sold[] = $zillow_comp_data_sold[$i]['longitude'] . ',' . $zillow_comp_data_sold[$i]['latitude'];
                    }
                    //dd($realtr);
                    //dd($realtr[0]['location']['address']['coordinate']['lon']);
                    for ($i = 0; $i < count($realtr_sold); $i++) {
                        if ($realtr_sold[$i]['location']['address']['coordinate'] != null) {
                            $real_sold[] = $realtr_sold[$i]['location']['address']['coordinate']['lon'] . ',' . $realtr_sold[$i]['location']['address']['coordinate']['lat'];
                        }
                    }

                    //$datatree = $propertydata['Reports'][0]['Data']['LocationInformation']['Longitude'] . ',' . $propertydata['Reports'][0]['Data']['LocationInformation']['Latitude'];
                    //dd($redfincor);
                    for ($i = 0; $i < count($zillowcor_sold); $i++) {
                        $zc_sold[] = $zillowcor_sold[$i];
                    }
                    //dd($redfincor[0]['homeData']['addressInfo']['centroid']['centroid']['longitude']);
                    for ($i = 0; $i < count($redfincor_sold); $i++) {
                        $rf_sold[] = $redfincor_sold[$i]['homeData']['addressInfo']['centroid']['centroid']['longitude'] . ',' . $redfincor_sold[$i]['homeData']['addressInfo']['centroid']['centroid']['latitude'];
                    }
                    // $getallcordinates['dt'] = $datatree;
                    $getallcordinates['zc_sold'] = $zc_sold;

                    $getallcordinates['rf_sold'] = $rf_sold;
                    $getallcordinates['rea_sold'] = $real_sold;
                    $count_real_sold = count($real_sold);
                    $count_zc_sold = count($zillowcor_sold);
                    $count_red_sold = count($redfincor_sold);

                    $count_1_sold = $count_red_sold <= $count_zc_sold ? $count_red_sold :  $count_zc_sold;
                    $cordinates_count_sold = $count_real_sold <= $count_1_sold ? $count_real_sold : $count_1_sold;
                    //dd($cordinates_count);
                    //dd($getallcordinates);


                    //dd($zillow_comp_data);
                    //dd($redfin_data);
                    //dd($realtr);
                    //dd($realtr[0]['location']['address']['city']);

                    for ($i = 0; $i < $cordinates_count_sold; $i++) {

                        //dd($marker);
                        //$href= 'https://www.zillow.com/homedetails/18143432_zpid/';

                        $xmlContent .= '    <Placemark>' . "\n";
                        $xmlContent .= '      <name>' . htmlentities($zillow_comp_data_sold[$i]['address']['streetAddress']) . '</name>' . "\n";
                        $xmlContent .= '      <description>' . $zillow_comp_data_sold[$i]['address']['city'] . '<br />' . $zillow_comp_data_sold[$i]['homeStatus'] . '<br /><a href="https://www.zillow.com/homedetails/' . $zillow_comp_data_sold[$i]['zpid'] . '_zpid/">Zillow</a><br />$' . $zillow_comp_data_sold[$i]['price'] . '</description>' . "\n";
                        $xmlContent .= '      <Point>' . "\n";
                        $xmlContent .= '        <coordinates>' . $getallcordinates['zc_sold'][$i] . ',0</coordinates>' . "\n";
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

                        $xmlContent .= '    <Placemark>' . "\n";
                        $xmlContent .= '      <name>' . htmlentities($redfin_sold_data['data'][$i]['homeData']['addressInfo']['formattedStreetLine']) . '</name>' . "\n";
                        $xmlContent .= '      <description>' . $redfin_sold_data['data'][$i]['homeData']['addressInfo']['city'] . '<br /><a href="https://redfin.com' . $redfin_sold_data['data'][$i]['homeData']['url'] . '">RedFin</a><br />$' . $redfin_sold_data['data'][$i]['homeData']['priceInfo']['amount'] . '</description>' . "\n";
                        $xmlContent .= '      <Point>' . "\n";
                        $xmlContent .= '        <coordinates>' . $getallcordinates['rf_sold'][$i] . ',0</coordinates>' . "\n";
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

                        //////////////realtor
                        $xmlContent .= '    <Placemark>' . "\n";
                        $xmlContent .= '      <name>' . htmlentities($realtr_sold[$i]['location']['address']['line']) . '</name>' . "\n";
                        $xmlContent .= '      <description>' . $realtr_sold[$i]['location']['address']['city'] . '<br />' . $realtr_sold[$i]['status'] . '<br /><a href="' . $realtr_sold[$i]['href'] . '">Realtor</a><br />$' . $realtr_sold[$i]['list_price'] . '</description>' . "\n";
                        $xmlContent .= '      <Point>' . "\n";
                        $xmlContent .= '        <coordinates>' . $getallcordinates['rea_sold'][$i] . ',0</coordinates>' . "\n";
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
                }
                //dd($getallcordinates);
                for ($i = 0; $i < $cordinates_count; $i++) {

                    //dd($marker);
                    //$href= 'https://www.zillow.com/homedetails/18143432_zpid/';

                    $xmlContent .= '    <Placemark>' . "\n";
                    $xmlContent .= '      <name>' . htmlentities($zillow_comp_data[$i]['address']['streetAddress']) . '</name>' . "\n";
                    $xmlContent .= '      <description>' . $zillow_comp_data[$i]['address']['city'] . '<br />' . $zillow_comp_data[$i]['homeStatus'] . '<br /><a href="https://www.zillow.com/homedetails/' . $zillow_comp_data[$i]['zpid'] . '_zpid/">Zillow</a><br />$' . $zillow_comp_data[$i]['price'] . '</description>' . "\n";
                    $xmlContent .= '      <Point>' . "\n";
                    $xmlContent .= '        <coordinates>' . $getallcordinates['zc'][$i] . ',0</coordinates>' . "\n";
                    $xmlContent .= '      </Point>' . "\n";
                    $xmlContent .= '      <Style>' . "\n";
                    $xmlContent .= '        <IconStyle>' . "\n";
                    $xmlContent .= '          <scale>1.5</scale>' . "\n"; // Adjust the scale here
                    $xmlContent .= '          <Icon>' . "\n";
                    $xmlContent .= '            <href>http://maps.google.com/mapfiles/ms/icons/red-dot.png</href>' . "\n";
                    $xmlContent .= '          </Icon>' . "\n";
                    $xmlContent .= '        </IconStyle>' . "\n";
                    $xmlContent .= '      </Style>' . "\n";
                    $xmlContent .= '    </Placemark>' . "\n";

                    $xmlContent .= '    <Placemark>' . "\n";
                    $xmlContent .= '      <name>' . htmlentities($redfin_data['data'][$i]['homeData']['addressInfo']['formattedStreetLine']) . '</name>' . "\n";
                    $xmlContent .= '      <description>' . $redfin_data['data'][$i]['homeData']['addressInfo']['city'] . '<br /><a href="https://redfin.com' . $redfin_data['data'][$i]['homeData']['url'] . '">RedFin</a><br />$' . $redfin_data['data'][$i]['homeData']['priceInfo']['amount'] . '</description>' . "\n";
                    $xmlContent .= '      <Point>' . "\n";
                    $xmlContent .= '        <coordinates>' . $getallcordinates['rf'][$i] . ',0</coordinates>' . "\n";
                    $xmlContent .= '      </Point>' . "\n";
                    $xmlContent .= '      <Style>' . "\n";
                    $xmlContent .= '        <IconStyle>' . "\n";
                    $xmlContent .= '          <scale>1.5</scale>' . "\n"; // Adjust the scale here
                    $xmlContent .= '          <Icon>' . "\n";
                    $xmlContent .= '            <href>http://maps.google.com/mapfiles/ms/icons/red-dot.png</href>' . "\n";
                    $xmlContent .= '          </Icon>' . "\n";
                    $xmlContent .= '        </IconStyle>' . "\n";
                    $xmlContent .= '      </Style>' . "\n";
                    $xmlContent .= '    </Placemark>' . "\n";

                    //////////////realtor
                    $xmlContent .= '    <Placemark>' . "\n";
                    $xmlContent .= '      <name>' . htmlentities($realtr[$i]['location']['address']['line']) . '</name>' . "\n";
                    $xmlContent .= '      <description>' . $realtr[$i]['location']['address']['city'] . '<br />' . $realtr[$i]['status'] . '<br /><a href="' . $realtr[$i]['href'] . '">Realtor</a><br />$' . $realtr[$i]['list_price'] . '</description>' . "\n";
                    $xmlContent .= '      <Point>' . "\n";
                    $xmlContent .= '        <coordinates>' . $getallcordinates['rea'][$i] . ',0</coordinates>' . "\n";
                    $xmlContent .= '      </Point>' . "\n";
                    $xmlContent .= '      <Style>' . "\n";
                    $xmlContent .= '        <IconStyle>' . "\n";
                    $xmlContent .= '          <scale>1.5</scale>' . "\n"; // Adjust the scale here
                    $xmlContent .= '          <Icon>' . "\n";
                    $xmlContent .= '            <href>http://maps.google.com/mapfiles/ms/icons/red-dot.png</href>' . "\n";
                    $xmlContent .= '          </Icon>' . "\n";
                    $xmlContent .= '        </IconStyle>' . "\n";
                    $xmlContent .= '      </Style>' . "\n";
                    $xmlContent .= '    </Placemark>' . "\n";
                }

                $xmlContent .= '  </Document>' . "\n";
                $xmlContent .= '</kml>';
                return response($xmlContent)
                    ->header('Content-Type', 'application/vnd.google-earth.kml+xml')
                    ->header('Content-Disposition', 'attachment; filename="comp_placemark.kml"');
            } else {
                $error = 'kml sale comp data not found';
                return  redirect()->to('compreport')->with('error', $error);
            }
        } catch (\Exception $e) {
            // Log the exception
            \Log::error('Xml Download failed: ' . $e->getMessage());

            // Optionally throw the exception to trigger a retry
            throw $e;
        }
    }

    function getPrice($jsonData)
    {
        try {
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
        } catch (\Exception $e) {
            // Log the exception
            \Log::info('getprice failed: ' . $e->getMessage());

            // Optionally throw the exception to trigger a retry
            throw $e;
        }
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
        try {
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
        } catch (\Exception $e) {
            // Log the exception
            \Log::info('redfin failed: ' . $e->getMessage());

            // Optionally throw the exception to trigger a retry
            throw $e;
        }
    }
    function getZillowData($jsonData)
    {
        try {
            $data = $jsonData;
            //dd($data);

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
        } catch (\Exception $e) {
            // Log the exception
            \Log::info('Zillowdata failed: ' . $e->getMessage());

            // Optionally throw the exception to trigger a retry
            throw $e;
        }
    }

    function getRealtorData($jsonData)
    {
        try {
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
        } catch (\Exception $e) {
            // Log the exception
            \Log::info('realtor failed: ' . $e->getMessage());

            // Optionally throw the exception to trigger a retry
            throw $e;
        }
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

    public function AdminPage(Request $request)
    {
        $user = DB::table('users')->where(['usertype' => ''])->get();
        //dd($user);
        $dta = json_decode(json_encode($user), true);
        //dd(request()->py);
        if (request()->py == '1') {
            $payment = DB::table('payments')->get();
            //dd($user);
            $paym = json_decode(json_encode($payment), true);
            ///dd($paym);
            return view('admin', ['paym' => $paym]);
            $dta = '';
        }
        $paym = '';
        return view('admin', ['data' => $dta]);
    }
}
