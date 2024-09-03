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
use Pdf;
use GuzzleHttp;


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
    
    public function pdf_download2(Request $request)
    {
        //return view('test');
        //dd($request->id);
        $client = new GuzzleHttp\Client();
        $login = $client->request('POST', 'https://dtapiuat.datatree.com:443/api/Login/AuthenticateClient', [
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
        $average_county = $salesdata['Reports'][0]['Data']['ComparablePropertiesSummary']['SalePrice']['Low'];

        $sum_sale[0] = $this->getJsonArrayElements($salesdata);
        $price[0] = $this->getPrice($salesdata);
        $mar_pr = $price[0][0][0];
        $add_data[0] = $this->getPropertyData($salesdata);
        $total_rc = count($add_data[0]);
        //dd($add_data[0]);
        $zill_acre_avg = (float)($add_data[0][1]/$total_rc);
        $zill_acre_avg_ = (float)($add_data[0][1]);

        $dis_zill = number_format((float)($add_data[0][2]/$total_rc),2);

        $average_price_river = $sum_sale[0][0];
        //dd($average_price_river);

        
        //return  $add_data[0][1];

        //get zillow data 
        $zillow_sales = $client->request('GET', 'https://zillow-working-api.p.rapidapi.com/byaddress?propertyaddress='.$add_data[0][0][0].'', [
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
        $zillow_sales_comp = $client->request('GET', 'https://zillow-com1.p.rapidapi.com/similarProperty?zpid='.$zpid.'', [
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

        $redfin_sales_comp = $client->request('GET', 'https://redfin-com-data.p.rapidapi.com/properties/auto-complete?query=mecca'.$zpid.'&limit=1', [
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

        $redfin_comp_data = json_decode($redfin_sales_comp->getBody(), true);
        $region_id = $redfin_comp_data[0]['data'][0]['rows'][0]['id'];
        dd($region_id);

        $zillow_comp_data = json_decode($zillow_sales_comp->getBody(), true);
        //dd($zillow_comp_data);

        $total_rec = count($zillow_comp_data);
        //$avg_acr_zll = $this->getZillowData($zillow_comp_data);
        $avg_acr_ll = str_replace(',','',number_format((float)($this->getZillowData($zillow_comp_data)/$total_rec),2));
        $avg_acr_ll_ = str_replace(',','',number_format((float)($this->getZillowData($zillow_comp_data)),2));
//dd($avg_acr_ll_);
        $salecount =  $salesdata['Reports'][0]['Data']['ComparableCount']; 
        //dd($sum_sale[0][0]);
        $avr_pr = str_replace(',','',number_format((float)($sum_sale[0][0]/$salecount),2));  
        $avr_acr = number_format((float)($sum_sale[0][1]/$salecount),2);
        $county_av = $average_county;
        //dd($county_av);
        $market_av = number_format((float)($county_av/$avr_acr),2);

        $avr_d = number_format((float)($sum_sale[0][2]/$salecount),2);
        //return $avr_acr;
        //dd($sum_sale[0][0],$sum_sale[0][1]);
        $aver_per_ac = number_format((float)($sum_sale[0][0]/$sum_sale[0][1]),2);  
        //avg per acre zillow
         //  dd($avg_acr_ll_,$zill_acre_avg_,$sum_sale[0][1]); 
        $av_per_acre_zill = number_format((float)($avg_acr_ll_/$zill_acre_avg_),2);                              
        //LastMarketSaleInformation['SalePrice']
        $data = [
            'address' => $propertydata['Reports'][0]['Data']['SubjectProperty']['SitusAddress']['StreetAddress'],
            'city' => $propertydata['Reports'][0]['Data']['SubjectProperty']['SitusAddress']['City'],
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
            'mar_pr' => $mar_pr
        ];
        $pdf = Pdf::loadView('pdf', $data);
        return $pdf->download('compreport.pdf');
    }
    // Function to get JSON array elements and their values
function getJsonArrayElements($jsonData) {
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
       
        $arr = [$sum, $sum_acr, $sum_d,$cities];

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

function getPrice($jsonData) {
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
        if(!empty($salescomp['SitusAddress']['City']))
        {
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
        $city = $propertycomp['SitusAddress']['City'];
        //dd($city);
        if(!empty($address))
        {
            $acres = $propertycomp['SiteInformation']['Acres'];
            $distance = $propertycomp['DistanceFromSubject'];
            $sum_d += $distance;
            $sum += $acres;
            $add[] = $propertycomp['SitusAddress']['StreetAddress'];
            $ad = [$add,$sum,$sum_d];
        }
            }
           
    return $ad;
 
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


}
