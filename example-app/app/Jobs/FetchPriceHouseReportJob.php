<?php

namespace App\Jobs;

use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use App\Models\PriceHouseReport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class FetchPriceHouseReportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $state;
    protected $countyName;
    protected $cp;
    protected $user;

    public function __construct($state, $countyName, $cp)
    {
        $this->state = $state;
        $this->countyName = $countyName;
        $this->cp = ltrim($cp, '0'); // Clean up county code
    }

    public function handle()
    {
        $client = new Client();
        $authenticate = $this->authenticateClient($client);

        $my_states_array = $this->getStateMapping();
        $st = $my_states_array[ltrim($this->state, '0')] ?? null;

        if (is_null($st)) {
            // Handle invalid state code, log the error
            \Log::error("Invalid state code: {$this->state}");
            return;
        }
        // Check if the record already exists in the price_reports table
        $existingReport = PriceHouseReport::where([
            'state' => $this->state,
            'county_name' => $this->countyName,
        ])->first();

        if ($existingReport) {
            // Record already exists, no need to generate job
            \Log::info("Report already exists for state: {$this->state}, county: {$this->countyName}");
            return;
        }

        // Fetch property details
        $prop_id = DB::table('property_details')->where([
            'state' => $this->state,
            'county' => $this->countyName
        ])->get();

        $acre_arr = [0, 5, 10, 15, 20, 25, 30, 35, 40, 45, 50, 55, 60, 65, 70, 75, 80, 85, 90, 95, 100];

        $data = $prop_id->isEmpty()
            ? $this->fetchDefaultData($client, $authenticate, $acre_arr, $st, $this->cp)
            : $this->fetchPropertyData($client, $authenticate, $prop_id, $acre_arr, $st, $this->cp);
        //dd(json_encode($data));
        // Save the results to the database
        $sts = json_encode($data['sts']);
        $de = json_encode($data['de']);

        //$data = json_encode($data['data']);
        $price = json_encode($data['price']);
        //$mainval = json_encode($data['mainval']);
        //$user = $this->user;
        //dd(Auth::user());

        //dd($data['sts']);
        PriceHouseReport::updateOrCreate([
            'user_id' => 1,
            'state' => $this->state,
            'county_name' => $this->countyName,
            'sts' => $sts,
            'de' => $de,
            //'data' => $data,
            'price' => $price,
            //'mainval' => $mainval// Store the fetched data
        ]);
    }

    private function authenticateClient(Client $client)
    {
        $response = $client->post('https://dtapiuat.datatree.com/api/Login/AuthenticateClient', [
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'ClientId' => config('app.client_id'),
                'ClientSecretKey' => config('app.client_secret')
            ]
        ]);

        return json_decode($response->getBody(), true);
    }
    private function getStateMapping()
    {
        return [
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
            // Add other states...
        ];
    }
    private function fetchPropertyData($client, $authenticate, $prop_id, $acre_arr, $st, $cp)
    {
        $de = [];
        $price = [];
        $data = json_decode(json_encode($prop_id), true);

        foreach ($data as $index => $property) {
            $filterValues = $this->buildFilterValues($acre_arr[$index], $acre_arr[$index + 1] ?? 100, $st, $cp);

            // Fetch sales comparables
            $response = $this->fetchReport($client, $authenticate, $filterValues, 'SalesComparables');
            $de[] = json_decode($response->getBody(), true);

            // Fetch property detail report
            $propertyResponse = $this->fetchReport($client, $authenticate, [
                [
                    'FilterName' => 'PropertyId',
                    'FilterOperator' => 'is',
                    'FilterValues' => [$data[$index]['property_id']]
                ]
            ], 'PropertyDetailReport');
            $price[] = json_decode($propertyResponse->getBody(), true);
        }
        $mainval = 1 * 0.1;
        for ($j = 0; $j < count($de); $j++) {
            $dl[] = $de[$j]['LitePropertyList'];
        }
        for ($n = 0; $n < count($dl); $n++) {
            $data1 = [];
            $propid = [];
            $count = [];
            //dd($dl);
            // Loop through each property in the current list
            for ($o = 0; $o < min(25, count($dl)); $o++) {
                $data1[$o] = $dl[$n][$o]['Owner'] ?? 'Unknown Owner';
                $propid[$o] = $dl[$n][$o]['PropertyId'] ?? null;

                // Count the number of owners based on the presence of '/'
                $count[$o] = (strpos($data1[$o], '/') !== false) ? 2 : 1;
            }

            $sum_arr = array_sum($count);

            $sts[] = [
                'res' . $n => $data1,
                'prop' => $propid,
                'count' => $count,
                'sum' => $sum_arr,
            ];
        }

        //dd($data);

        return view('pricehouse', compact('de', 'mainval', 'data', 'price', 'sts'));
    }
    /*private function fetchPropertyData($authenticate, $prop_id)
    {
        // Implement your logic to fetch property data
    }*/

    /*private function fetchDefaultData($authenticate)
    {
        // Implement your logic to fetch default data
    }*/
    private function fetchDefaultData($client, $authenticate, $acre_arr, $st, $cp)
    {
        $de = [];
        $price = [];

        for ($j = 0; $j < count($acre_arr) - 1; $j++) {
            $filterValues = $this->buildFilterValues($acre_arr[$j], $acre_arr[$j + 1], $st, $cp);

            // Fetch sales comparables
            $response = $this->fetchReport($client, $authenticate, $filterValues, 'SalesComparables');
            $de[] = json_decode($response->getBody(), true);

            // Fetch property detail report
            if (!empty($de[$j]['LitePropertyList'])) {
                $propertyId = $de[$j]['LitePropertyList'][0]['PropertyId'];
                $propertyResponse = $this->fetchReport($client, $authenticate, [
                    [
                        'FilterName' => 'PropertyId',
                        'FilterOperator' => 'is',
                        'FilterValues' => [$propertyId]
                    ]
                ], 'PropertyDetailReport');
                $price[] = json_decode($propertyResponse->getBody(), true);
            }
            //dd($de);
        }
        for ($j = 0; $j < count($de); $j++) {
            $dl[] = $de[$j]['LitePropertyList'];
        }
        for ($n = 0; $n < count($dl); $n++) {
            $data1 = [];
            $propid = [];
            $count = [];
            //dd($dl);
            // Loop through each property in the current list
            for ($o = 0; $o < min(25, count($dl)); $o++) {
                $data1[$o] = $dl[$n][$o]['Owner'] ?? 'Unknown Owner';
                $propid[$o] = $dl[$n][$o]['PropertyId'] ?? null;

                // Count the number of owners based on the presence of '/'
                $count[$o] = (strpos($data1[$o], '/') !== false) ? 2 : 1;
            }

            $sum_arr = array_sum($count);

            $sts[] = [
                'res' . $n => $data1,
                'prop' => $propid,
                'count' => $count,
                'sum' => $sum_arr,
            ];
        }
        //dd($sts);

        return view('pricehouse', compact('de', 'price', 'sts'));
    }
    private function buildFilterValues($acreFrom, $acreTo, $st, $cp)
    {
        return [
            [
                'FilterName' => 'LotAcreage',
                'FilterOperator' => 'is between',
                'FilterValues' => [$acreFrom, $acreTo]
            ],
            [
                'FilterName' => 'StateFips',
                'FilterOperator' => 'is',
                'FilterValues' => [$st],
                'FilterGroup' => 1
            ],
            [
                'FilterName' => 'CountyFips',
                'FilterOperator' => 'is',
                'FilterValues' => [$cp],
                'FilterGroup' => 1
            ],
        ];
    }
    private function fetchReport($client, $authenticate, $filterValues, $productName)
    {
        return $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $authenticate,
            ],
            'body' => json_encode([
                'ProductNames' => [$productName],
                'SearchType' => 'Filter',
                'SearchRequest' => [
                    'ReferenceId' => '1',
                    'ProductName' => 'SearchLite',
                    'MaxReturn' => 1,
                    'Filters' => $filterValues,
                ],
            ]),
        ]);
    }

}
