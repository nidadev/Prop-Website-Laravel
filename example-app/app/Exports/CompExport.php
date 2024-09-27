<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use GuzzleHttp;
use Maatwebsite\Excel\Concerns\WithMapping;

class CompExport implements FromArray, WithHeadings
{
    protected $userId;

    public function __construct($userId)
    {
        $this->userId = $userId;
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
            "Bathrooms" ,
          "Pool" ,
          "Fireplace" ,
          "Heating" ,
          "Cooling" ,
          "Roofing" ,
          "HomesForSale" ,
          "HomesForSaleChange" ,
          "AvgListPrice" ,
          "AvgListPriceChange" ,
          "AvgDaysOnMarket" ,
          "AvgDaysOnMarketChange" ,
          "AvgListPriceSqft" ,
          "AvgListPriceSqftChange" ,
          "NewListingLast30Days" ,
          "NewListingLast30DaysChange" ,
          "SalesLast30Days" ,
          "SalesLast30DaysChange" ,
          "IsDataAvailable"
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
        $getProperty = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $authenticate,
            ],
            'body' => json_encode([
                'ProductNames' => ['TotalViewReport'],

                "SearchType" => "PROPERTY",
                "PropertyId" => $this->userId
            ]),
        ]);
        $price = json_decode($getProperty->getBody(), true);
        //dd($price);
        return [
            [
                'PropertyId'        => $price['Reports'][0]['PropertyId'],
                'StreetAddress'        => $price['Reports'][0]['Data']['SubjectProperty']['SitusAddress']['StreetAddress'],
                'County'        => $price['Reports'][0]['Data']['SubjectProperty']['SitusAddress']['County'],
                'State'        => $price['Reports'][0]['Data']['SubjectProperty']['SitusAddress']['State'],
                'OwnerNames'        => $price['Reports'][0]['Data']['OwnerInformation']['OwnerNames'],
                'SellerName'        => $price['Reports'][0]['Data']['LastMarketSaleInformation']['SellerName'],
                'BuyerName'        => $price['Reports'][0]['Data']['LastMarketSaleInformation']['BuyerName'],
                'SaleDate'        => $price['Reports'][0]['Data']['LastMarketSaleInformation']['SaleDate'],
                'RecordingDate'        => $price['Reports'][0]['Data']['LastMarketSaleInformation']['RecordingDate'],
                'SalePrice'        => $price['Reports'][0]['Data']['LastMarketSaleInformation']['SalePrice'],
                'ListingStatus'        => $price['Reports'][0]['Data']['ListingPropertyDetail']['ListingStatus'],
                'ListingPrice'        => $price['Reports'][0]['Data']['ListingPropertyDetail']['ListingPrice'],
                'ListingSoldPrice'        => $price['Reports'][0]['Data']['ListingPropertyDetail']['ListingSoldPrice'],
                'DaysOnMarket'        => $price['Reports'][0]['Data']['ListingPropertyDetail']['DaysOnMarket'],
                'PropertyType'        => $price['Reports'][0]['Data']['ListingPropertyDetail']['PropertyType'],
                'Zoning'        => $price['Reports'][0]['Data']['ListingPropertyDetail']['Zoning'],
                'YearBuilt'        => $price['Reports'][0]['Data']['ListingPropertyDetail']['YearBuilt'],
                'GarageType'        => $price['Reports'][0]['Data']['ListingPropertyDetail']['GarageType'],
                'LotSizeSqFt'        => $price['Reports'][0]['Data']['ListingPropertyDetail']['LotSizeSqFt'],
                'GLAHomeSizeSTD'        => $price['Reports'][0]['Data']['ListingPropertyDetail']['GLAHomeSizeSTD'],
                'Basement'        => $price['Reports'][0]['Data']['ListingPropertyDetail']['Basement'],
                'Bedrooms'        => $price['Reports'][0]['Data']['ListingPropertyDetail']['Bedrooms'],
                "Bathrooms" => $price['Reports'][0]['Data']['ListingPropertyDetail']['Bathrooms'],
          "Pool" => $price['Reports'][0]['Data']['ListingPropertyDetail']['Pool'],
          "Fireplace" => $price['Reports'][0]['Data']['ListingPropertyDetail']['Fireplace'],
          "Heating" => $price['Reports'][0]['Data']['ListingPropertyDetail']['Heating'],
          "Cooling" => $price['Reports'][0]['Data']['ListingPropertyDetail']['Cooling'],
          "Roofing" => $price['Reports'][0]['Data']['ListingPropertyDetail']['Roofing'],
          "HomesForSale" => $price['Reports'][0]['Data']['MarketTrendData']['ListingDetails']['HomesForSale'],
          "HomesForSaleChange" => $price['Reports'][0]['Data']['MarketTrendData']['ListingDetails']['HomesForSaleChange'],
          "AvgListPrice" => $price['Reports'][0]['Data']['MarketTrendData']['ListingDetails']['AvgListPrice'],
          "AvgListPriceChange" => $price['Reports'][0]['Data']['MarketTrendData']['ListingDetails']['AvgListPriceChange'],
          "AvgDaysOnMarket" => $price['Reports'][0]['Data']['MarketTrendData']['ListingDetails']['AvgDaysOnMarket'] ,
          "AvgDaysOnMarketChange" => $price['Reports'][0]['Data']['MarketTrendData']['ListingDetails']['AvgDaysOnMarketChange'],
          "AvgListPriceSqft" => $price['Reports'][0]['Data']['MarketTrendData']['ListingDetails']['AvgListPriceSqft'],
          "AvgListPriceSqftChange" => $price['Reports'][0]['Data']['MarketTrendData']['ListingDetails']['AvgListPriceSqftChange'] ,
          "NewListingLast30Days" => $price['Reports'][0]['Data']['MarketTrendData']['ListingDetails']['NewListingLast30Days'],
          "NewListingLast30DaysChange" => $price['Reports'][0]['Data']['MarketTrendData']['ListingDetails']['NewListingLast30DaysChange'] ,
          "SalesLast30Days" => $price['Reports'][0]['Data']['MarketTrendData']['ListingDetails']['SalesLast30Days'],
          "SalesLast30DaysChange" => $price['Reports'][0]['Data']['MarketTrendData']['ListingDetails']['SalesLast30DaysChange'],
          "IsDataAvailable" => $price['Reports'][0]['Data']['MarketTrendData']['ListingDetails']['IsDataAvailable']

            ]
        ];
    }
}
