<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use GuzzleHttp;

class PriceHouseExport implements FromArray, WithHeadings
{
    protected $userIds;

    public function __construct(array $userIds)
    {
        $this->userIds = $userIds;
    }

    public function headings(): array
    {
        return [
            'PropertyId',
            'StreetAddress',
            'County',
            'State',
            'OwnerNames',
            'SellerName',
            'BuyerName',
            'SaleDate',
            'RecordingDate',
            'SalePrice',
            'ListingStatus',
            'ListingPrice',
            'ListingSoldPrice',
            'DaysOnMarket',
            'PropertyType',
            'Zoning',
            'YearBuilt',
            'GarageType',
            'LotSizeSqFt',
            'GLAHomeSizeSTD',
            'Basement',
            'Bedrooms',
            'Bathrooms',
            'Pool',
            'Fireplace',
            'Heating',
            'Cooling',
            'Roofing',
            'HomesForSale',
            'HomesForSaleChange',
            'AvgListPrice',
            'AvgListPriceChange',
            'AvgDaysOnMarket',
            'AvgDaysOnMarketChange',
            'AvgListPriceSqft',
            'AvgListPriceSqftChange',
            'NewListingLast30Days',
            'NewListingLast30DaysChange',
            'SalesLast30Days',
            'SalesLast30DaysChange',
            'IsDataAvailable'
        ];
    }

    public function array(): array
    {
        
            // Return the data in an array format
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
      
        $formattedData = [];
        /*$userId = $this->userIds;
        //echo $userId[0];
        $cnt = count($this->userIds);
        for($i=0; $i<$cnt; $i++)
        {
        $getProperty = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $authenticate,
            ],
            'body' => json_encode([
                'ProductNames' => ['TotalViewReport'],

                "SearchType" => "PROPERTY",
                "PropertyId" => $userId[$i]
            ]),
        ]);
        $data[] = json_decode($getProperty->getBody(), true);
    }
    print_r($data);*/
   
        foreach ($this->userIds as $userId) {
            // Replace with your API endpoint
            $getProperty = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $authenticate,
                ],
                'body' => json_encode([
                    'ProductNames' => ['TotalViewReport'],
    
                    "SearchType" => "PROPERTY",
                    "PropertyId" => $userId
                ]),
            ]);
            $data = json_decode($getProperty->getBody(), true);
           // var_dump($data);
//var_dump($data['Reports'][0]["Data"]['SubjectProperty']['PropertyId']);
            //dd($data);
            //print_r($this->userIds);
//print_r(json_encode($data));
            // Process the data if necessary and format it for export
            if (isset($data['Reports']) && is_array($data['Reports']) && !empty($data['Reports'])) {
                $subjectProperty = $data['Reports'][0]['Data']['SubjectProperty'] ?? [];

                $formattedData[] = [
                    $subjectProperty['PropertyId'] ?? null,
                    $subjectProperty['SitusAddress']['StreetAddress'] ?? null,
                    $subjectProperty['SitusAddress']['County'] ?? null,
                    $subjectProperty['SitusAddress']['State'] ?? null,
                    $data['Reports'][0]['Data']['OwnerInformation']['OwnerNames'] ?? null,
                    $data['Reports'][0]['Data']['LastMarketSaleInformation']['SellerName'] ?? null,
                    $data['Reports'][0]['Data']['LastMarketSaleInformation']['BuyerName'] ?? null,
                    $data['Reports'][0]['Data']['LastMarketSaleInformation']['SaleDate'] ?? null,
                    $data['Reports'][0]['Data']['LastMarketSaleInformation']['RecordingDate'] ?? null,
                    $data['Reports'][0]['Data']['LastMarketSaleInformation']['SalePrice'] ?? null,
                    $data['Reports'][0]['Data']['ListingPropertyDetail']['ListingStatus'] ?? null,
                    $subjectProperty['ListingPrice'] ?? null,
                    $subjectProperty['ListingSoldPrice'] ?? null,
                    $subjectProperty['DaysOnMarket'] ?? null,
                    $subjectProperty['PropertyType'] ?? null,
                    $subjectProperty['Zoning'] ?? null,
                    $subjectProperty['YearBuilt'] ?? null,
                    $subjectProperty['GarageType'] ?? null,
                    $subjectProperty['LotSizeSqFt'] ?? null,
                    $subjectProperty['GLAHomeSizeSTD'] ?? null,
                    $subjectProperty['Basement'] ?? null,
                    $subjectProperty['Bedrooms'] ?? null,
                    $subjectProperty['Bathrooms'] ?? null,
                    $subjectProperty['Pool'] ?? null,
                    $subjectProperty['Fireplace'] ?? null,
                    $subjectProperty['Heating'] ?? null,
                    $subjectProperty['Cooling'] ?? null,
                    $subjectProperty['Roofing'] ?? null,
                    $subjectProperty['HomesForSale'] ?? null,
                    $subjectProperty['HomesForSaleChange'] ?? null,
                    $subjectProperty['AvgListPrice'] ?? null,
                    $subjectProperty['AvgListPriceChange'] ?? null,
                    $subjectProperty['AvgDaysOnMarket'] ?? null,
                    $subjectProperty['AvgDaysOnMarketChange'] ?? null,
                    $subjectProperty['AvgListPriceSqft'] ?? null,
                    $subjectProperty['AvgListPriceSqftChange'] ?? null,
                    $subjectProperty['NewListingLast30Days'] ?? null,
                    $subjectProperty['NewListingLast30DaysChange'] ?? null,
                    $subjectProperty['SalesLast30Days'] ?? null,
                    $subjectProperty['SalesLast30DaysChange'] ?? null,
                    $subjectProperty['IsDataAvailable'] ?? null,
                ];
            } else {
                // Handle case where Reports is not structured as expected
                // You might want to log this or set defaults
            }
        }

        return $formattedData;
    }


}
