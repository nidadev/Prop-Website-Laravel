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
            '#',
            'Name',
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
                'price'        => $price['Reports'][0]['Data'],
            ]
        ];
    }
}
