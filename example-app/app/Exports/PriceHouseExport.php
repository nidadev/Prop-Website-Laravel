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
            'APN',
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
            'IsDataAvailable',
            /*'LegalDescription',
            'APN',
            'AlternateAPN',
            'TaxAccountNumber',
            'Subdivision',
            'Latitude',
            'Longitude',
            'CountyFips',
            'TownshipRangeSection',
            'MunicipalityTownship',
            'CensusTract',
            'CensusBlock',
            'TractNumber',
            'LegalBookPage',
            'SchoolDistrict',
            'ElementarySchool',
            'MiddleSchool',
            'HighSchool',
            'CountyUseCode',
            'StateUse',
            'StateUseCode',
            /*'SiteInfluence',
            'NumberOfBuildings',
            'UnitsResidential',
            'UnitsCommercial',
            'WaterType',
            'SewerType',*/
            'Acres',
            'LotArea',
            'LandUse',
            'TaxDataSource',
            'TaxAuthority',
            'PayeeLegacyIdentifier',
            'TaxPaymentStatusDate',
            'TaxPaymentStatusType',
            'TaxID',
            'Address',
            'TaxYear',
            'Exemptions',
            'AssessedValue',
            'PropertyTax',
            'Land',
            'Improvements',
            'SoldHomes',
            'SoldHomesChange',
            'AvgSoldPrice',
            'AvgSoldPriceChange',
            'AvgSqft',
            'AvgSqftChange',
            'AvgSoldPriceSqft',
            'AvgSoldPriceSqftChange',
            'AvgAge',
            'AvgAgeChange',
            'IsDataAvailable',
            'AssessedOwner',
            'VestingName',
            'VestingDescription',
            'EstimatedValueLow',
            'EstimatedValueHigh',
            'LegalDescription'
            /*'LotDepth',
            'UsableLot',
            'FloodZoneCode',
            'FloodMap',
            'FloodMapDate',
            'FloodPanel',
            'CommunityName',
            'CommunityID',
            'InsideSFHA'*/
        ];
    }

    public function array(): array
    {
        set_time_limit(1520);
    
        $context = stream_context_create([
            'http' => [
                'timeout' => 1.0,
                'ignore_errors' => true,
            ]
        ]);
        
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
            //dd($data);
            // Process the data if necessary and format it for export
            if (isset($data['Reports']) && is_array($data['Reports']) && !empty($data['Reports'])) {
                $subjectProperty = $data['Reports'][0]['Data']['SubjectProperty'] ?? [];

                $formattedData[] = [
                    $subjectProperty['PropertyId'] ?? null,
                    $subjectProperty['SitusAddress']['StreetAddress'] ?? null,
                    $subjectProperty['SitusAddress']['County'] ?? null,
                    $subjectProperty['SitusAddress']['State'] ?? null,
                    $subjectProperty['SitusAddress']['APN'] ?? null,

                    $data['Reports'][0]['Data']['OwnerInformation']['OwnerNames'] ?? null,
                    $data['Reports'][0]['Data']['LastMarketSaleInformation']['SellerName'] ?? null,
                    $data['Reports'][0]['Data']['LastMarketSaleInformation']['BuyerName'] ?? null,
                    $data['Reports'][0]['Data']['LastMarketSaleInformation']['SaleDate'] ?? null,
                    $data['Reports'][0]['Data']['LastMarketSaleInformation']['RecordingDate'] ?? null,
                    $data['Reports'][0]['Data']['LastMarketSaleInformation']['SalePrice'] ?? null,
                    $data['Reports'][0]['Data']['ListingPropertyDetail']['ListingStatus'] ?? null,
                    $data['Reports'][0]['Data']['ListingPropertyDetail']['ListingPrice'] ?? null,
                    $data['Reports'][0]['Data']['ListingPropertyDetail']['ListingSoldPrice'] ?? null,
                    $data['Reports'][0]['Data']['ListingPropertyDetail']['DaysOnMarket'] ?? null,
                    $data['Reports'][0]['Data']['ListingPropertyDetail']['PropertyType'] ?? null,
                    $data['Reports'][0]['Data']['ListingPropertyDetail']['Zoning'] ?? null,
                    $data['Reports'][0]['Data']['ListingPropertyDetail']['YearBuilt'] ?? null,
                    $data['Reports'][0]['Data']['ListingPropertyDetail']['GarageType'] ?? null,
                    $data['Reports'][0]['Data']['ListingPropertyDetail']['LotSizeSqFt'] ?? null,
                    $data['Reports'][0]['Data']['ListingPropertyDetail']['GLAHomeSizeSTD'] ?? null,
                    $data['Reports'][0]['Data']['ListingPropertyDetail']['Basement'] ?? null,
                    $data['Reports'][0]['Data']['ListingPropertyDetail']['Bedrooms'] ?? null,
                    $data['Reports'][0]['Data']['ListingPropertyDetail']['Bathrooms'] ?? null,
                    $data['Reports'][0]['Data']['ListingPropertyDetail']['Pool'] ?? null,
                    $data['Reports'][0]['Data']['ListingPropertyDetail']['Fireplace'] ?? null,
                    $data['Reports'][0]['Data']['ListingPropertyDetail']['Heating'] ?? null,
                    $data['Reports'][0]['Data']['ListingPropertyDetail']['Cooling'] ?? null,
                    $data['Reports'][0]['Data']['ListingPropertyDetail']['Roofing'] ?? null,
                    $data['Reports'][0]['Data']['MarketTrendData']['ListingDetails']['HomesForSale'] ?? null,
                    $data['Reports'][0]['Data']['MarketTrendData']['ListingDetails']['HomesForSaleChange'] ?? null,
                    $data['Reports'][0]['Data']['MarketTrendData']['ListingDetails']['AvgListPrice'] ?? null,
                    $data['Reports'][0]['Data']['MarketTrendData']['ListingDetails']['AvgListPriceChange'] ?? null,
                    $data['Reports'][0]['Data']['MarketTrendData']['ListingDetails']['AvgDaysOnMarket'] ?? null,
                    $data['Reports'][0]['Data']['MarketTrendData']['ListingDetails']['AvgDaysOnMarketChange'] ?? null,
                    $data['Reports'][0]['Data']['MarketTrendData']['ListingDetails']['AvgListPriceSqft'] ?? null,
                    $data['Reports'][0]['Data']['MarketTrendData']['ListingDetails']['AvgListPriceSqftChange'] ?? null,
                    $data['Reports'][0]['Data']['MarketTrendData']['ListingDetails']['NewListingLast30Days'] ?? null,
                    $data['Reports'][0]['Data']['MarketTrendData']['ListingDetails']['NewListingLast30DaysChange'] ?? null,
                    $data['Reports'][0]['Data']['MarketTrendData']['ListingDetails']['SalesLast30Days'] ?? null,
                    $data['Reports'][0]['Data']['MarketTrendData']['ListingDetails']['SalesLast30DaysChange'] ?? null,
                    $data['Reports'][0]['Data']['MarketTrendData']['ListingDetails']['IsDataAvailable'] ?? null,
                    /*$data['Reports'][0]['Data']['LocationInformation']['LegalDescription'] ?? null,
                    $data['Reports'][0]['Data']['LocationInformation']['APN'] ?? null,
                    $data['Reports'][0]['Data']['LocationInformation']['AlternateAPN'] ?? null,
                    $data['Reports'][0]['Data']['LocationInformation']['TaxAccountNumber'] ?? null,
                    $data['Reports'][0]['Data']['LocationInformation']['Subdivision'] ?? null,
                    $data['Reports'][0]['Data']['LocationInformation']['Latitude'] ?? null,
                    $data['Reports'][0]['Data']['LocationInformation']['Longitude'] ?? null,
                    $data['Reports'][0]['Data']['LocationInformation']['CountyFips'] ?? null,
                    $data['Reports'][0]['Data']['LocationInformation']['TownshipRangeSection'] ?? null,
                    $data['Reports'][0]['Data']['LocationInformation']['MunicipalityTownship'] ?? null,
                    $data['Reports'][0]['Data']['LocationInformation']['CensusTract'] ?? null,
                    $data['Reports'][0]['Data']['LocationInformation']['CensusBlock'] ?? null,
                    $data['Reports'][0]['Data']['LocationInformation']['TractNumber'] ?? null,
                    $data['Reports'][0]['Data']['LocationInformation']['LegalBookPage'] ?? null,
                    $data['Reports'][0]['Data']['LocationInformation']['SchoolDistrict'] ?? null,
                    $data['Reports'][0]['Data']['LocationInformation']['ElementarySchool'] ?? null,
                    $data['Reports'][0]['Data']['LocationInformation']['MiddleSchool'] ?? null,
                    $data['Reports'][0]['Data']['LocationInformation']['HighSchool'] ?? null,
                    $data['Reports'][0]['Data']['SiteInformation']['CountyUseCode'] ?? null,
                    $data['Reports'][0]['Data']['SiteInformation']['StateUse'] ?? null,
                    $data['Reports'][0]['Data']['SiteInformation']['StateUseCode'] ?? null,

                    /*$data['Reports'][0]['Data']['PropertyDetailData']['SiteInformation']['SiteInfluence'] ?? null,
                    $data['Reports'][0]['Data']['SiteInformation']['NumberOfBuildings'] ?? null,
                    $data['Reports'][0]['Data']['SiteInformation']['UnitsResidential'] ?? null,
                    $data['Reports'][0]['Data']['SiteInformation']['UnitsCommercial'] ?? null,
                    $data['Reports'][0]['Data']['SiteInformation']['WaterType'] ?? null,
                    $data['Reports'][0]['Data']['SiteInformation']['SewerType'] ?? null,*/
                    $data['Reports'][0]['Data']['PropertyDetailData']['SiteInformation']['Acres'] ?? null,
                    $data['Reports'][0]['Data']['PropertyDetailData']['SiteInformation']['LotArea'] ?? null,
                    $data['Reports'][0]['Data']['PropertyDetailData']['SiteInformation']['LandUse'] ?? null,
                    $data['Reports'][0]['Data']['TaxStatusData']['TaxDataSource'] ?? null,
                    $data['Reports'][0]['Data']['TaxStatusData']['TaxAuthority']['Name'] ?? null,
                    $data['Reports'][0]['Data']['TaxStatusData']['TaxAuthority']['PayeeLegacyIdentifier'] ?? null,
                    $data['Reports'][0]['Data']['TaxStatusData']['TaxAuthority']['TaxPaymentStatusDate'] ?? null,
                    $data['Reports'][0]['Data']['TaxStatusData']['TaxAuthority']['TaxPaymentStatusType'] ?? null,
                    $data['Reports'][0]['Data']['TaxStatusData']['TaxAuthority']['TaxID'] ?? null,
                    $data['Reports'][0]['Data']['TaxStatusData']['TaxAuthority']['Address'] ?? null,
                    $data['Reports'][0]['Data']['TaxStatusData']['Taxes']['TaxYear'] ?? null,
                    $data['Reports'][0]['Data']['TaxStatusData']['Taxes']['Exemptions'] ?? null,
                    $data['Reports'][0]['Data']['TaxStatusData']['Taxes']['AssessedValue'] ?? null,
                    $data['Reports'][0]['Data']['TaxStatusData']['Taxes']['PropertyTax'] ?? null,
                    $data['Reports'][0]['Data']['TaxStatusData']['Taxes']['Land'] ?? null,
                    $data['Reports'][0]['Data']['TaxStatusData']['Taxes']['Improvements'] ?? null,
                    $data['Reports'][0]['Data']['MarketTrendData']['SalesDetails']['SoldHomes'] ?? null,
                    $data['Reports'][0]['Data']['MarketTrendData']['SalesDetails']['SoldHomesChange'] ?? null,
                    $data['Reports'][0]['Data']['MarketTrendData']['SalesDetails']['AvgSoldPrice'] ?? null,
                    $data['Reports'][0]['Data']['MarketTrendData']['SalesDetails']['AvgSoldPriceChange'] ?? null,
                    $data['Reports'][0]['Data']['MarketTrendData']['SalesDetails']['AvgSqft'] ?? null,
                    $data['Reports'][0]['Data']['MarketTrendData']['SalesDetails']['AvgSqftChange'] ?? null,
                    $data['Reports'][0]['Data']['MarketTrendData']['SalesDetails']['AvgSoldPriceSqft'] ?? null,
                    $data['Reports'][0]['Data']['MarketTrendData']['SalesDetails']['AvgSoldPriceSqftChange'] ?? null,
                    $data['Reports'][0]['Data']['MarketTrendData']['SalesDetails']['AvgAge'] ?? null,
                    $data['Reports'][0]['Data']['MarketTrendData']['SalesDetails']['AvgAgeChange'] ?? null,
                    $data['Reports'][0]['Data']['MarketTrendData']['SalesDetails']['IsDataAvailable'] ?? null,
                    $data['Reports'][0]['Data']['LegalAndVestingData']['AssessedOwner'] ?? null,
                    $data['Reports'][0]['Data']['LegalAndVestingData']['VestingName'] ?? null,
                    $data['Reports'][0]['Data']['LegalAndVestingData']['VestingDescription'] ?? null,
                    $data['Reports'][0]['Data']['LegalAndVestingData']['EstimatedValueHigh'] ?? null,
                    $data['Reports'][0]['Data']['LegalAndVestingData']['LegalDescription'] ?? null,

                    
                    
                    /*$data['Reports'][0]['Data']['SiteInformation']['LotDepth'] ?? null,
                    $data['Reports'][0]['Data']['SiteInformation']['UsableLot'] ?? null,
                    $data['Reports'][0]['Data']['SiteInformation']['FloodZoneCode'] ?? null,
                    $data['Reports'][0]['Data']['SiteInformation']['FloodMap'] ?? null,
                    $data['Reports'][0]['Data']['SiteInformation']['FloodMapDate'] ?? null,
                    $data['Reports'][0]['Data']['SiteInformation']['FloodPanel'] ?? null,
                    $data['Reports'][0]['Data']['SiteInformation']['CommunityName'] ?? null,
                    $data['Reports'][0]['Data']['SiteInformation']['CommunityID'] ?? null,
                    $data['Reports'][0]['Data']['SiteInformation']['InsideSFHA'] ?? null,*/
                                ];
            } else {
                // Handle case where Reports is not structured as expected
                // You might want to log this or set defaults
            }
        }

        return $formattedData;
    }


}
