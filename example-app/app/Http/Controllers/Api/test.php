<?php
$acre_arr = [0,5];
for($i=0;$i<count($acre_arr)-1; $i++)
{
$res.$i = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
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
                                        '.$acre_arr[$i].',
                                        '.$acre_arr[$i+1].'
                                        
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
            $d.$i = json_decode($res.$i->getBody(), true);
            $data = [
                'res'.$i => $d.$i,
            ];
            $res = 'res'.$i;
            $pd.$i = isset($data[$res]['LitePropertyList'][0]['PropertyId']) ? $data[$res]['LitePropertyList'][0]['PropertyId'] : 0;
            $p_id = [
                's'.$i => $pd.$i,
            ];
            $se = 's'.$i;
            if ($p_id[$se] != 0) {
                $getProperty.$i = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
                    'headers' => [
                        'Accept' => 'application/json',
                        'Content-Type' => 'application/json',
                        'Authorization' => 'Bearer ' . $authenticate,
                    ],
                    'body' => json_encode([
                        'ProductNames' => ['PropertyDetailReport'],

                        "SearchType" => "PROPERTY",
                        "PropertyId" => $p_id[$se]
                    ]),
                ]);

                $price.$i = json_decode($getProperty.$i->getBody(), true);
            }
            $pr = $price.$i;
            $sp.$i = isset($pr['Reports'][0]['Data']['LastMarketSaleInformation']['SalePrice']) ? $pr['Reports'][0]['Data']['LastMarketSaleInformation']['SalePrice'] : 0;
            $sale_price[] = [
                'p'.$i => $sp.$i];
            }

            /***************************old code */
                  /*$res0 = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
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
            $d0 = json_decode($res0->getBody(), true);
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
            $d1 = json_decode($res1->getBody(), true);

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
                                        10,
                                        15
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
            $d2 = json_decode($res2->getBody(), true);
            $res3 = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
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
                                        15,
                                        20
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
            $d3 = json_decode($res3->getBody(), true);
            $res4 = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
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
                                        20,
                                        25
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
            $d4 = json_decode($res4->getBody(), true);
            $res5 = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
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
                                        25,
                                        30
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
            $d5 = json_decode($res5->getBody(), true);
            $res6 = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
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
                                        30,
                                        35
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
            $d6 = json_decode($res6->getBody(), true);
            $res7 = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
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
                                        35,
                                        40
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
            $d7 = json_decode($res7->getBody(), true);
            $res8 = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
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
                                        40,
                                        45
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
            $d8 = json_decode($res8->getBody(), true);
            $res9 = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
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
                                        45,
                                        50
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
            $d9 = json_decode($res9->getBody(), true);
            $res10 = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
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
                                        50,
                                        55
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
            $d10 = json_decode($res10->getBody(), true);
            $res11 = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
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
                                        55,
                                        60
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
            $d11 = json_decode($res11->getBody(), true);
            $res12 = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
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
                                        60,
                                        65
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
            $d12 = json_decode($res12->getBody(), true);
            $res13 = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
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
                                        65,
                                        70
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
            $d13 = json_decode($res13->getBody(), true);
            $res14 = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
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
                                        70,
                                        75
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
            $d14 = json_decode($res14->getBody(), true);
            $res15 = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
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
                                        75,
                                        80
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
            $d15 = json_decode($res15->getBody(), true);

            $res16 = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
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
                                        80,
                                        85
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
            $d16 = json_decode($res16->getBody(), true);
            $res17 = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
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
                                        85,
                                        90
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
            $d17 = json_decode($res17->getBody(), true);
            $res18 = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
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
                                        90,
                                        95
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
            $d18 = json_decode($res18->getBody(), true);
            //dd($data_st['res1']);
            $data = [
                'res0' => $d0,
                'res1' => $d1,
                'res2' => $d2,
                'res3' => $d3,
                'res4' => $d4,
                'res5' => $d5,
                'res6' => $d6,
                'res7' => $d7,
                'res8' => $d8,
                'res9' => $d9,
                'res10' => $d10,
                'res11' => $d11,
                'res12' => $d12,
                'res13' => $d13,
                'res14' => $d14,
                'res15' => $d15,
                'res16' => $d16,
                'res17' => $d17,
                'res18' => $d18,
            ];
            //dd($data);

            $pd1 = isset($data['res0']['LitePropertyList'][0]['PropertyId']) ? $data['res0']['LitePropertyList'][0]['PropertyId'] : 0;
            $pd2 = isset($data['res1']['LitePropertyList'][0]['PropertyId']) ? $data['res1']['LitePropertyList'][0]['PropertyId'] : 0;
            $pd3 = isset($data['res2']['LitePropertyList'][0]['PropertyId']) ? $data['res2']['LitePropertyList'][0]['PropertyId'] : 0;
            $pd4 = isset($data['res3']['LitePropertyList'][0]['PropertyId']) ? $data['res3']['LitePropertyList'][0]['PropertyId'] : 0;
            $pd5 = isset($data['res4']['LitePropertyList'][0]['PropertyId']) ? $data['res4']['LitePropertyList'][0]['PropertyId'] : 0;
            $pd6 = isset($data['res5']['LitePropertyList'][0]['PropertyId']) ? $data['res5']['LitePropertyList'][0]['PropertyId'] : 0;
            $pd7 = isset($data['res6']['LitePropertyList'][0]['PropertyId']) ? $data['res6']['LitePropertyList'][0]['PropertyId'] : 0;
            $pd8 = isset($data['res7']['LitePropertyList'][0]['PropertyId']) ? $data['res7']['LitePropertyList'][0]['PropertyId'] : 0;
            $pd9 = isset($data['res8']['LitePropertyList'][0]['PropertyId']) ? $data['res8']['LitePropertyList'][0]['PropertyId'] : 0;
            $pd10 = isset($data['res9']['LitePropertyList'][0]['PropertyId']) ? $data['res9']['LitePropertyList'][0]['PropertyId'] : 0;
            $pd11 = isset($data['res10']['LitePropertyList'][0]['PropertyId']) ? $data['res10']['LitePropertyList'][0]['PropertyId'] : 0;
            $pd12 = isset($data['res11']['LitePropertyList'][0]['PropertyId']) ? $data['res11']['LitePropertyList'][0]['PropertyId'] : 0;
            $pd13 = isset($data['res12']['LitePropertyList'][0]['PropertyId']) ? $data['res12']['LitePropertyList'][0]['PropertyId'] : 0;
            $pd14 = isset($data['res13']['LitePropertyList'][0]['PropertyId']) ? $data['res13']['LitePropertyList'][0]['PropertyId'] : 0;
            $pd15 = isset($data['res14']['LitePropertyList'][0]['PropertyId']) ? $data['res14']['LitePropertyList'][0]['PropertyId'] : 0;
            $pd16 = isset($data['res15']['LitePropertyList'][0]['PropertyId']) ? $data['res15']['LitePropertyList'][0]['PropertyId'] : 0;
            $pd17 = isset($data['res16']['LitePropertyList'][0]['PropertyId']) ? $data['res16']['LitePropertyList'][0]['PropertyId'] : 0;
            $pd18 = isset($data['res17']['LitePropertyList'][0]['PropertyId']) ? $data['res17']['LitePropertyList'][0]['PropertyId'] : 0;
            $pd19 = isset($data['res18']['LitePropertyList'][0]['PropertyId']) ? $data['res18']['LitePropertyList'][0]['PropertyId'] : 0;

            $p_id = [
                's1' => $pd1,
                's2' => $pd1,
                's3' => $pd2,
                's4' => $pd3,
                's5' => $pd4,
                's6' => $pd5,
                's7' => $pd6,
                's8' => $pd7,
                's9' => $pd8,
                's10' => $pd9,
                's11' => $pd10,
                's12' => $pd11,
                's13' => $pd12,
                's14' => $pd13,
                's15' => $pd14,
                's16' => $pd15,
                's17' => $pd16,
                's18' => $pd17,
                's19' => $pd18,
                's20' => $pd19
            ];
            //dd($p_id);
            if ($p_id['s1'] != 0) {
                $getProperty0 = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
                    'headers' => [
                        'Accept' => 'application/json',
                        'Content-Type' => 'application/json',
                        'Authorization' => 'Bearer ' . $authenticate,
                    ],
                    'body' => json_encode([
                        'ProductNames' => ['PropertyDetailReport'],

                        "SearchType" => "PROPERTY",
                        "PropertyId" => $p_id['s1']
                    ]),
                ]);

                $price0 = json_decode($getProperty0->getBody(), true);
            }
            if ($p_id['s2'] != 0) {
                $getProperty1 = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
                    'headers' => [
                        'Accept' => 'application/json',
                        'Content-Type' => 'application/json',
                        'Authorization' => 'Bearer ' . $authenticate,
                    ],
                    'body' => json_encode([
                        'ProductNames' => ['PropertyDetailReport'],

                        "SearchType" => "PROPERTY",
                        "PropertyId" => $p_id['s2']
                    ]),
                ]);


                $price1 = json_decode($getProperty1->getBody(), true);
            }
            if ($p_id['s3'] != 0) {
                $getProperty2 = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
                    'headers' => [
                        'Accept' => 'application/json',
                        'Content-Type' => 'application/json',
                        'Authorization' => 'Bearer ' . $authenticate,
                    ],
                    'body' => json_encode([
                        'ProductNames' => ['PropertyDetailReport'],

                        "SearchType" => "PROPERTY",
                        "PropertyId" => $p_id['s3']
                    ]),
                ]);

                $price2 = json_decode($getProperty2->getBody(), true);
            }
            if ($p_id['s4'] != 0) {
                $getProperty3 = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
                    'headers' => [
                        'Accept' => 'application/json',
                        'Content-Type' => 'application/json',
                        'Authorization' => 'Bearer ' . $authenticate,
                    ],
                    'body' => json_encode([
                        'ProductNames' => ['PropertyDetailReport'],

                        "SearchType" => "PROPERTY",
                        "PropertyId" => $p_id['s4']
                    ]),
                ]);

                $price3 = json_decode($getProperty3->getBody(), true);
            }
            if ($p_id['s5'] != 0) {
                $getProperty4 = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
                    'headers' => [
                        'Accept' => 'application/json',
                        'Content-Type' => 'application/json',
                        'Authorization' => 'Bearer ' . $authenticate,
                    ],
                    'body' => json_encode([
                        'ProductNames' => ['PropertyDetailReport'],

                        "SearchType" => "PROPERTY",
                        "PropertyId" => $p_id['s5']
                    ]),
                ]);

                $price4 = json_decode($getProperty4->getBody(), true);
            }
            if ($p_id['s6'] != 0) {
                $getProperty5 = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
                    'headers' => [
                        'Accept' => 'application/json',
                        'Content-Type' => 'application/json',
                        'Authorization' => 'Bearer ' . $authenticate,
                    ],
                    'body' => json_encode([
                        'ProductNames' => ['PropertyDetailReport'],

                        "SearchType" => "PROPERTY",
                        "PropertyId" => $p_id['s6']
                    ]),
                ]);

                $price5 = json_decode($getProperty5->getBody(), true);
            }
            if ($p_id['s7'] != 0) {
                $getProperty6 = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
                    'headers' => [
                        'Accept' => 'application/json',
                        'Content-Type' => 'application/json',
                        'Authorization' => 'Bearer ' . $authenticate,
                    ],
                    'body' => json_encode([
                        'ProductNames' => ['PropertyDetailReport'],

                        "SearchType" => "PROPERTY",
                        "PropertyId" => $p_id['s7']
                    ]),
                ]);

                $price6 = json_decode($getProperty6->getBody(), true);
            }
            if ($p_id['s8'] != 0) {

                $getProperty7 = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
                    'headers' => [
                        'Accept' => 'application/json',
                        'Content-Type' => 'application/json',
                        'Authorization' => 'Bearer ' . $authenticate,
                    ],
                    'body' => json_encode([
                        'ProductNames' => ['PropertyDetailReport'],

                        "SearchType" => "PROPERTY",
                        "PropertyId" => $p_id['s8']
                    ]),
                ]);

                $price7 = json_decode($getProperty7->getBody(), true);
            }
            if ($p_id['s9'] != 0) {
                $getProperty8 = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
                    'headers' => [
                        'Accept' => 'application/json',
                        'Content-Type' => 'application/json',
                        'Authorization' => 'Bearer ' . $authenticate,
                    ],
                    'body' => json_encode([
                        'ProductNames' => ['PropertyDetailReport'],

                        "SearchType" => "PROPERTY",
                        "PropertyId" => $p_id['s9']
                    ]),
                ]);

                $price8 = json_decode($getProperty8->getBody(), true);
            }
            if ($p_id['s10'] != 0) {
                $getProperty9 = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
                    'headers' => [
                        'Accept' => 'application/json',
                        'Content-Type' => 'application/json',
                        'Authorization' => 'Bearer ' . $authenticate,
                    ],
                    'body' => json_encode([
                        'ProductNames' => ['PropertyDetailReport'],

                        "SearchType" => "PROPERTY",
                        "PropertyId" => $p_id['s10']
                    ]),
                ]);

                $price9 = json_decode($getProperty9->getBody(), true);
            }
            if ($p_id['s11'] != 0) {
                $getProperty10 = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
                    'headers' => [
                        'Accept' => 'application/json',
                        'Content-Type' => 'application/json',
                        'Authorization' => 'Bearer ' . $authenticate,
                    ],
                    'body' => json_encode([
                        'ProductNames' => ['PropertyDetailReport'],

                        "SearchType" => "PROPERTY",
                        "PropertyId" => $p_id['s11']
                    ]),
                ]);

                $price10 = json_decode($getProperty10->getBody(), true);
            }
            if ($p_id['s12'] != 0) {
                $getProperty11 = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
                    'headers' => [
                        'Accept' => 'application/json',
                        'Content-Type' => 'application/json',
                        'Authorization' => 'Bearer ' . $authenticate,
                    ],
                    'body' => json_encode([
                        'ProductNames' => ['PropertyDetailReport'],

                        "SearchType" => "PROPERTY",
                        "PropertyId" => $p_id['s12']
                    ]),
                ]);

                $price11 = json_decode($getProperty11->getBody(), true);
            }
            if ($p_id['s13'] != 0) {
                $getProperty12 = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
                    'headers' => [
                        'Accept' => 'application/json',
                        'Content-Type' => 'application/json',
                        'Authorization' => 'Bearer ' . $authenticate,
                    ],
                    'body' => json_encode([
                        'ProductNames' => ['PropertyDetailReport'],

                        "SearchType" => "PROPERTY",
                        "PropertyId" => $p_id['s13']
                    ]),
                ]);

                $price12 = json_decode($getProperty12->getBody(), true);
            }
            if ($p_id['s14'] != 0) {
                $getProperty13 = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
                    'headers' => [
                        'Accept' => 'application/json',
                        'Content-Type' => 'application/json',
                        'Authorization' => 'Bearer ' . $authenticate,
                    ],
                    'body' => json_encode([
                        'ProductNames' => ['PropertyDetailReport'],

                        "SearchType" => "PROPERTY",
                        "PropertyId" => $p_id['s14']
                    ]),
                ]);
                $price13 = json_decode($getProperty13->getBody(), true);
            }
            if ($p_id['s15'] != 0) {

                $getProperty14 = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
                    'headers' => [
                        'Accept' => 'application/json',
                        'Content-Type' => 'application/json',
                        'Authorization' => 'Bearer ' . $authenticate,
                    ],
                    'body' => json_encode([
                        'ProductNames' => ['PropertyDetailReport'],

                        "SearchType" => "PROPERTY",
                        "PropertyId" => $p_id['s15']
                    ]),
                ]);

                $price14 = json_decode($getProperty14->getBody(), true);
            }
            //dd($p_id['s16']);
            if ($p_id['s16'] != 0) {
                $getProperty15 = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
                    'headers' => [
                        'Accept' => 'application/json',
                        'Content-Type' => 'application/json',
                        'Authorization' => 'Bearer ' . $authenticate,
                    ],
                    'body' => json_encode([
                        'ProductNames' => ['PropertyDetailReport'],

                        "SearchType" => "PROPERTY",
                        "PropertyId" => $p_id['s16']
                    ]),
                ]);
                $price15 = json_decode($getProperty15->getBody(), true);
            }
            if ($p_id['s17'] != 0) {

                $getProperty16 = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
                    'headers' => [
                        'Accept' => 'application/json',
                        'Content-Type' => 'application/json',
                        'Authorization' => 'Bearer ' . $authenticate,
                    ],
                    'body' => json_encode([
                        'ProductNames' => ['PropertyDetailReport'],

                        "SearchType" => "PROPERTY",
                        "PropertyId" => $p_id['s17']
                    ]),
                ]);

                $price16 = json_decode($getProperty16->getBody(), true);
            }
            if ($p_id['s18'] != 0) {
                $getProperty17 = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
                    'headers' => [
                        'Accept' => 'application/json',
                        'Content-Type' => 'application/json',
                        'Authorization' => 'Bearer ' . $authenticate,
                    ],
                    'body' => json_encode([
                        'ProductNames' => ['PropertyDetailReport'],

                        "SearchType" => "PROPERTY",
                        "PropertyId" => $p_id['s18']
                    ]),
                ]);
                $price17 = json_decode($getProperty17->getBody(), true);
            }
            if ($p_id['s19'] != 0) {

                $getProperty18 = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
                    'headers' => [
                        'Accept' => 'application/json',
                        'Content-Type' => 'application/json',
                        'Authorization' => 'Bearer ' . $authenticate,
                    ],
                    'body' => json_encode([
                        'ProductNames' => ['PropertyDetailReport'],

                        "SearchType" => "PROPERTY",
                        "PropertyId" => $p_id['s19']
                    ]),
                ]);
                $price18 = json_decode($getProperty18->getBody(), true);
            }
            $sp1 = isset($price0['Reports'][0]['Data']['LastMarketSaleInformation']['SalePrice']) ? $price0['Reports'][0]['Data']['LastMarketSaleInformation']['SalePrice'] : 0;
            $sp2 = isset($price1['Reports'][0]['Data']['LastMarketSaleInformation']['SalePrice']) ? $price1['Reports'][0]['Data']['LastMarketSaleInformation']['SalePrice'] : 0;
            $sp3 = isset($price2['Reports'][0]['Data']['LastMarketSaleInformation']['SalePrice']) ? $price2['Reports'][0]['Data']['LastMarketSaleInformation']['SalePrice'] : 0;
            $sp4 = isset($price3['Reports'][0]['Data']['LastMarketSaleInformation']['SalePrice']) ? $price3['Reports'][0]['Data']['LastMarketSaleInformation']['SalePrice'] : 0;
            $sp5 = isset($price4['Reports'][0]['Data']['LastMarketSaleInformation']['SalePrice']) ? $price4['Reports'][0]['Data']['LastMarketSaleInformation']['SalePrice'] : 0;
            $sp6 = isset($price5['Reports'][0]['Data']['LastMarketSaleInformation']['SalePrice']) ? $price5['Reports'][0]['Data']['LastMarketSaleInformation']['SalePrice'] : 0;
            $sp7 = isset($price6['Reports'][0]['Data']['LastMarketSaleInformation']['SalePrice']) ? $price6['Reports'][0]['Data']['LastMarketSaleInformation']['SalePrice'] : 0;
            $sp8 = isset($price7['Reports'][0]['Data']['LastMarketSaleInformation']['SalePrice']) ? $price7['Reports'][0]['Data']['LastMarketSaleInformation']['SalePrice'] : 0;
            $sp9 = isset($price8['Reports'][0]['Data']['LastMarketSaleInformation']['SalePrice']) ? $price8['Reports'][0]['Data']['LastMarketSaleInformation']['SalePrice'] : 0;
            $sp10 = isset($price9['Reports'][0]['Data']['LastMarketSaleInformation']['SalePrice']) ? $price9['Reports'][0]['Data']['LastMarketSaleInformation']['SalePrice'] : 0;
            $sp11 = isset($price10['Reports'][0]['Data']['LastMarketSaleInformation']['SalePrice']) ? $price10['Reports'][0]['Data']['LastMarketSaleInformation']['SalePrice'] : 0;
            $sp12 = isset($price11['Reports'][0]['Data']['LastMarketSaleInformation']['SalePrice']) ? $price11['Reports'][0]['Data']['LastMarketSaleInformation']['SalePrice'] : 0;
            $sp13 = isset($price12['Reports'][0]['Data']['LastMarketSaleInformation']['SalePrice']) ? $price12['Reports'][0]['Data']['LastMarketSaleInformation']['SalePrice'] : 0;
            $sp14 = isset($price13['Reports'][0]['Data']['LastMarketSaleInformation']['SalePrice']) ? $price13['Reports'][0]['Data']['LastMarketSaleInformation']['SalePrice'] : 0;
            $sp15 = isset($price14['Reports'][0]['Data']['LastMarketSaleInformation']['SalePrice']) ? $price14['Reports'][0]['Data']['LastMarketSaleInformation']['SalePrice'] : 0;
            $sp16 = isset($price15['Reports'][0]['Data']['LastMarketSaleInformation']['SalePrice']) ? $price15['Reports'][0]['Data']['LastMarketSaleInformation']['SalePrice'] : 0;
            $sp17 = isset($price16['Reports'][0]['Data']['LastMarketSaleInformation']['SalePrice']) ? $price16['Reports'][0]['Data']['LastMarketSaleInformation']['SalePrice'] : 0;
            $sp18 = isset($price17['Reports'][0]['Data']['LastMarketSaleInformation']['SalePrice']) ? $price17['Reports'][0]['Data']['LastMarketSaleInformation']['SalePrice'] : 0;
            $sp19 = isset($price18['Reports'][0]['Data']['LastMarketSaleInformation']['SalePrice']) ? $price18['Reports'][0]['Data']['LastMarketSaleInformation']['SalePrice'] : 0;

            $sale_price[] = [
                'p0' => $sp1,
                'p1' => $sp2,
                'p2' => $sp3,
                'p3' => $sp4,
                'p4' => $sp5,
                'p5' => $sp6,
                'p6' => $sp7,
                'p7' => $sp8,
                'p8' => $sp9,
                'p9' => $sp10,
                'p10' => $sp11,
                'p11' => $sp12,
                'p12' => $sp13,
                'p13' => $sp14,
                'p14' => $sp15,
                'p15' => $sp16,
                'p16' => $sp17,
                'p17' => $sp18,
                'p18' => $sp19
            ];*/
            //dd($data);
            /*************************** */


            <!--tbody id="mytable4">
                @if(isset($data))
                <?php //dd($sale_price);
                ?>


                <?php /*for ($i = 0; $i <= count($data) - 1; $i++) {
                  $acre = [0, 5, 10, 15];

                  //$acre = [0, 5, 10, 15, 20, 25, 30, 35, 40, 45, 50, 55, 60, 65, 70, 75, 80, 85, 90, 95];

                  $res = 'res' . $i;
                  $pr = 'p' . $i;
                  $total = $data[$res]['MaxResultsCount'] * $mainval;
                  $maxc = $data[$res]['MaxResultsCount'];
                  //$spr = 'pr'.$maxc;
                  //$pr = $sale_price[0][$spr];

                  $ct = isset($data[$res]['LitePropertyList'][0]['County']) ? $data[$res]['LitePropertyList'][0]['County'] : 0;
                  $st = isset($data[$res]['LitePropertyList'][0]['State']) ? $data[$res]['LitePropertyList'][0]['State'] : 0;
                  
                  $info = ['0-5', '5-10', '10-15', '15-20']; //echo $res; 

                  //$info = ['0-5', '5-10', '10-15', '15-20', '20-25', '25-30', '30-35', '40-45', '45-50', '50-55', '55-60', '60-65', '65-70', '70-75', '75-80', '80-85', '85-90', '90-95', '95-100']; //echo $res; 
                  $price_per_acre = number_format($sale_price[0][$pr] / $acre[$i + 1], 2);
                ?>
                  <tr>
                    <td>{{ $info[$i] }}</td>
                    <td>{{ $data[$res]['MaxResultsCount']}}</td>
                    <td>{{ $st}}</td>

                    <td>{{ $ct}}</td>
                    <td>${{ $sale_price[0][$pr]}}</td>
                    <td>${{ $price_per_acre }}</td>
                    <!--td></td-->

                    <td><input type='checkbox' id='sm' onclick="javascript:toggle('{{ $maxc }}')" ; class='su' value="{{ $total }}" name='sum[]' style='border:14px solid green;width:30px;height:30px;'></td>


                  </tr>
                <?php } */?>
                @endif
              </tbody-->
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
            //insert

            ?>