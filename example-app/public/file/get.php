<?php
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

?>