
public function GetPriceHouseReport(Request $request)
    {
        //dd($request);
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
            'sc' => 45
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
            $acre_arr = [0,5,10,15,20,25,30,35,40,45,50,55,60,65,70,75,80,85,90,95,100];
           
            foreach($acre_arr as $ac)
            {
                $data[] = $ac;
            }
            //dd($data);
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
                                            '.$data[0].',
                                            '.$data[1].'
                                            
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
                                            "FilterName": "LotAcreage",
                                            "FilterOperator": "is between",
                                            "FilterValues": [
                                                '.$data[1].',
                                                '.$data[2].'
                                                
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
                           $de[] = json_decode($res->getBody(), true);

                           /******************when 10-15 */
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
                                                    '.$data[2].',
                                                    '.$data[3].'
                                                    
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
                               $de[] = json_decode($res->getBody(), true);
                           /**********************10-15 end */
                           /********15-20 */
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
                                                    '.$data[3].',
                                                    '.$data[4].'
                                                    
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
                               $de[] = json_decode($res->getBody(), true);
                           /*************15-20 end */
                           /**************20-25 */
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
                                                    '.$data[4].',
                                                    '.$data[5].'
                                                    
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
                               $de[] = json_decode($res->getBody(), true);
                           /********************20-25 end */
                           /******************25-30 */
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
                                                    '.$data[5].',
                                                    '.$data[6].'
                                                    
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
                               $de[] = json_decode($res->getBody(), true);
                           /********************25-30end */
                           /********30-35 */
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
                                                    '.$data[6].',
                                                    '.$data[7].'
                                                    
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
                               $de[] = json_decode($res->getBody(), true);
                           /**********30-35 end */
                           /************35-40 */
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
                                                    '.$data[7].',
                                                    '.$data[8].'
                                                    
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
                               $de[] = json_decode($res->getBody(), true);
                           /**************35-40 end */
                           /*************40-45 */
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
                                                    '.$data[8].',
                                                    '.$data[9].'
                                                    
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
                               $de[] = json_decode($res->getBody(), true);
                           /********************40-45 end */
                           /******************45-50 */
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
                                                    '.$data[9].',
                                                    '.$data[10].'
                                                    
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
                               $de[] = json_decode($res->getBody(), true);
                           /***************45-50 end */
                           /*************50-55 */
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
                                                    '.$data[10].',
                                                    '.$data[11].'
                                                    
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
                               $de[] = json_decode($res->getBody(), true);
                           /*************50-55 */
                           /*******55-60 */
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
                                                    '.$data[11].',
                                                    '.$data[12].'
                                                    
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
                               $de[] = json_decode($res->getBody(), true);
                           /**********55-60**** */
                           /********60-65 */
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
                                                    '.$data[12].',
                                                    '.$data[13].'
                                                    
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
                               $de[] = json_decode($res->getBody(), true);
                           /************60-65 */
                           /***********65-70 */
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
                                                    '.$data[13].',
                                                    '.$data[14].'
                                                    
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
                               $de[] = json_decode($res->getBody(), true);
                           /****************65-70 */
                           /***********70-75 */
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
                                                    '.$data[14].',
                                                    '.$data[15].'
                                                    
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
                               $de[] = json_decode($res->getBody(), true);
                           /*************70-75 */
                           /***********75-80 */
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
                                                    '.$data[15].',
                                                    '.$data[16].'
                                                    
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
                               $de[] = json_decode($res->getBody(), true);
                           /***********75-80 */
                           /********80-85 */
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
                                                    '.$data[16].',
                                                    '.$data[17].'
                                                    
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
                               $de[] = json_decode($res->getBody(), true);
                           /*********80-85 */
                           /*********85-90 */
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
                                                    '.$data[17].',
                                                    '.$data[18].'
                                                    
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
                               $de[] = json_decode($res->getBody(), true);
                           /****************85-90 */
                           /*********90-95 */
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
                                                    '.$data[18].',
                                                    '.$data[19].'
                                                    
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
                               $de[] = json_decode($res->getBody(), true);
                           /*********90-95 */
                           /********95-100 */
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
                                                    '.$data[19].',
                                                    '.$data[20].'
                                                    
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
                               $de[] = json_decode($res->getBody(), true);
                           /***********95-100 */
               
               //dd($de);
               foreach($de as $d)
               {
                //$pd = isset($d['LitePropertyList'][0]['PropertyId']) ? $d[0]['LitePropertyList'][0]['PropertyId'] : 0;

                $pid[] = $d['LitePropertyList'];
               
               }
               foreach($pid as $pd)
               {
                   $pid_all[] = $pd;
               }
               //dd($pid_all);
               $getProperty = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $authenticate,
                ],
                'body' => json_encode([
                    'ProductNames' => ['TotalViewReport'],

                    "SearchType" => "PROPERTY",
                    "PropertyId" => $pid_all[0][0]['PropertyId']
                ]),
            ]);
            $price[] = json_decode($getProperty->getBody(), true);

            $getProperty = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $authenticate,
                ],
                'body' => json_encode([
                    'ProductNames' => ['TotalViewReport'],

                    "SearchType" => "PROPERTY",
                    "PropertyId" => $pid_all[1][0]['PropertyId']
                ]),
            ]);
            $price[] = json_decode($getProperty->getBody(), true);
            $getProperty = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $authenticate,
                ],
                'body' => json_encode([
                    'ProductNames' => ['TotalViewReport'],

                    "SearchType" => "PROPERTY",
                    "PropertyId" => $pid_all[2][0]['PropertyId']
                ]),
            ]);
            $price[] = json_decode($getProperty->getBody(), true);
            $getProperty = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $authenticate,
                ],
                'body' => json_encode([
                    'ProductNames' => ['TotalViewReport'],

                    "SearchType" => "PROPERTY",
                    "PropertyId" => $pid_all[3][0]['PropertyId']
                ]),
            ]);
            $price[] = json_decode($getProperty->getBody(), true);
            $getProperty = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $authenticate,
                ],
                'body' => json_encode([
                    'ProductNames' => ['TotalViewReport'],

                    "SearchType" => "PROPERTY",
                    "PropertyId" => $pid_all[4][0]['PropertyId']
                ]),
            ]);
            $price[] = json_decode($getProperty->getBody(), true);
            $getProperty = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $authenticate,
                ],
                'body' => json_encode([
                    'ProductNames' => ['TotalViewReport'],

                    "SearchType" => "PROPERTY",
                    "PropertyId" => $pid_all[5][0]['PropertyId']
                ]),
            ]);
            $price[] = json_decode($getProperty->getBody(), true);
            $getProperty = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $authenticate,
                ],
                'body' => json_encode([
                    'ProductNames' => ['TotalViewReport'],

                    "SearchType" => "PROPERTY",
                    "PropertyId" => $pid_all[6][0]['PropertyId']
                ]),
            ]);
            $price[] = json_decode($getProperty->getBody(), true);
            $getProperty = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $authenticate,
                ],
                'body' => json_encode([
                    'ProductNames' => ['TotalViewReport'],

                    "SearchType" => "PROPERTY",
                    "PropertyId" => $pid_all[7][0]['PropertyId']
                ]),
            ]);
            $price[] = json_decode($getProperty->getBody(), true);
            $getProperty = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $authenticate,
                ],
                'body' => json_encode([
                    'ProductNames' => ['TotalViewReport'],

                    "SearchType" => "PROPERTY",
                    "PropertyId" => $pid_all[8][0]['PropertyId']
                ]),
            ]);
            $price[] = json_decode($getProperty->getBody(), true);
            $getProperty = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $authenticate,
                ],
                'body' => json_encode([
                    'ProductNames' => ['TotalViewReport'],

                    "SearchType" => "PROPERTY",
                    "PropertyId" => $pid_all[9][0]['PropertyId']
                ]),
            ]);
            $price[] = json_decode($getProperty->getBody(), true);
            $getProperty = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $authenticate,
                ],
                'body' => json_encode([
                    'ProductNames' => ['TotalViewReport'],

                    "SearchType" => "PROPERTY",
                    "PropertyId" => $pid_all[10][0]['PropertyId']
                ]),
            ]);
            $price[] = json_decode($getProperty->getBody(), true);
            $getProperty = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $authenticate,
                ],
                'body' => json_encode([
                    'ProductNames' => ['TotalViewReport'],

                    "SearchType" => "PROPERTY",
                    "PropertyId" => $pid_all[11][0]['PropertyId']
                ]),
            ]);
            $price[] = json_decode($getProperty->getBody(), true);
            $getProperty = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $authenticate,
                ],
                'body' => json_encode([
                    'ProductNames' => ['TotalViewReport'],

                    "SearchType" => "PROPERTY",
                    "PropertyId" => $pid_all[12][0]['PropertyId']
                ]),
            ]);
            $price[] = json_decode($getProperty->getBody(), true);
            $getProperty = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $authenticate,
                ],
                'body' => json_encode([
                    'ProductNames' => ['TotalViewReport'],

                    "SearchType" => "PROPERTY",
                    "PropertyId" => $pid_all[13][0]['PropertyId']
                ]),
            ]);
            $price[] = json_decode($getProperty->getBody(), true);
            $getProperty = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $authenticate,
                ],
                'body' => json_encode([
                    'ProductNames' => ['TotalViewReport'],

                    "SearchType" => "PROPERTY",
                    "PropertyId" => $pid_all[14][0]['PropertyId']
                ]),
            ]);
            $price[] = json_decode($getProperty->getBody(), true);
            $getProperty = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $authenticate,
                ],
                'body' => json_encode([
                    'ProductNames' => ['TotalViewReport'],

                    "SearchType" => "PROPERTY",
                    "PropertyId" => $pid_all[15][0]['PropertyId']
                ]),
            ]);
            $price[] = json_decode($getProperty->getBody(), true);

            $getProperty = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $authenticate,
                ],
                'body' => json_encode([
                    'ProductNames' => ['TotalViewReport'],

                    "SearchType" => "PROPERTY",
                    "PropertyId" => $pid_all[16][0]['PropertyId']
                ]),
            ]);
            $price[] = json_decode($getProperty->getBody(), true);
            $getProperty = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $authenticate,
                ],
                'body' => json_encode([
                    'ProductNames' => ['TotalViewReport'],

                    "SearchType" => "PROPERTY",
                    "PropertyId" => $pid_all[17][0]['PropertyId']
                ]),
            ]);
            $price[] = json_decode($getProperty->getBody(), true);
            $getProperty = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $authenticate,
                ],
                'body' => json_encode([
                    'ProductNames' => ['TotalViewReport'],

                    "SearchType" => "PROPERTY",
                    "PropertyId" => $pid_all[18][0]['PropertyId']
                ]),
            ]);
            $price[] = json_decode($getProperty->getBody(), true);
            $getProperty = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $authenticate,
                ],
                'body' => json_encode([
                    'ProductNames' => ['TotalViewReport'],

                    "SearchType" => "PROPERTY",
                    "PropertyId" => $pid_all[19][0]['PropertyId']
                ]),
            ]);
            $price[] = json_decode($getProperty->getBody(), true);           
            //dd($pid_all);
            ///////////////////////////
            $mainval = 1 * 0.1;
            return view('pricehouse', compact('mainval','de','price'));

        } catch (\Exception $e) {
            //throw new HttpException(500, $e->getMessage());
            //dd($e->getMessage());
            $response = $e->getResponse();
            $emsg = $e->getMessage();
            //dd($response);
            $fromserver = 'No records found . or Server error';
            $msg = json_decode($response->getBody()->getContents(), true);
            $error = $emsg;
            //dd($response['reasonPhrase']);
            return  redirect()->to('pricehouse')->with('error', $error);
        }
    }


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
                                            ' . $data[0] . ',
                                            ' . $data[1] . '
                                            
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
                                            "FilterName": "LotAcreage",
                                            "FilterOperator": "is between",
                                            "FilterValues": [
                                                ' . $data[1] . ',
                                                ' . $data[2] . '
                                                
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
            $de[] = json_decode($res->getBody(), true);

            /******************when 10-15 */
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
                                                    ' . $data[2] . ',
                                                    ' . $data[3] . '
                                                    
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
            $de[] = json_decode($res->getBody(), true);
            /**********************10-15 end */
            /********15-20 */
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
                                                    ' . $data[3] . ',
                                                    ' . $data[4] . '
                                                    
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
            $de[] = json_decode($res->getBody(), true);
            /*************15-20 end */
            /**************20-25 */
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
                                                    ' . $data[4] . ',
                                                    ' . $data[5] . '
                                                    
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
            $de[] = json_decode($res->getBody(), true);
            /********************20-25 end */
            /******************25-30 */
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
                                                    ' . $data[5] . ',
                                                    ' . $data[6] . '
                                                    
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
            $de[] = json_decode($res->getBody(), true);
            /********************25-30end */
            /********30-35 */
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
                                                    ' . $data[6] . ',
                                                    ' . $data[7] . '
                                                    
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
            $de[] = json_decode($res->getBody(), true);
            /**********30-35 end */
            /************35-40 */
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
                                                    ' . $data[7] . ',
                                                    ' . $data[8] . '
                                                    
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
            $de[] = json_decode($res->getBody(), true);
            /**************35-40 end */
            /*************40-45 */
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
                                                    ' . $data[8] . ',
                                                    ' . $data[9] . '
                                                    
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
            $de[] = json_decode($res->getBody(), true);
            /********************40-45 end */
            /******************45-50 */
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
                                                    ' . $data[9] . ',
                                                    ' . $data[10] . '
                                                    
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
            $de[] = json_decode($res->getBody(), true);
            /***************45-50 end */
            /*************50-55 */
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
                                                    ' . $data[10] . ',
                                                    ' . $data[11] . '
                                                    
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
            $de[] = json_decode($res->getBody(), true);
            /*************50-55 */
            /*******55-60 */
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
                                                    ' . $data[11] . ',
                                                    ' . $data[12] . '
                                                    
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
            $de[] = json_decode($res->getBody(), true);
            /**********55-60**** */
            /********60-65 */
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
                                                    ' . $data[12] . ',
                                                    ' . $data[13] . '
                                                    
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
            $de[] = json_decode($res->getBody(), true);
            /************60-65 */
            /***********65-70 */
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
                                                    ' . $data[13] . ',
                                                    ' . $data[14] . '
                                                    
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
            $de[] = json_decode($res->getBody(), true);
            /****************65-70 */
            /***********70-75 */
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
                                                    ' . $data[14] . ',
                                                    ' . $data[15] . '
                                                    
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
            $de[] = json_decode($res->getBody(), true);
            /*************70-75 */
            /***********75-80 */
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
                                                    ' . $data[15] . ',
                                                    ' . $data[16] . '
                                                    
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
            $de[] = json_decode($res->getBody(), true);
            /***********75-80 */
            /********80-85 */
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
                                                    ' . $data[16] . ',
                                                    ' . $data[17] . '
                                                    
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
            $de[] = json_decode($res->getBody(), true);
            /*********80-85 */
            /*********85-90 */
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
                                                    ' . $data[17] . ',
                                                    ' . $data[18] . '
                                                    
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
            $de[] = json_decode($res->getBody(), true);
            /****************85-90 */
            /*********90-95 */
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
                                                    ' . $data[18] . ',
                                                    ' . $data[19] . '
                                                    
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
            $de[] = json_decode($res->getBody(), true);
            /*********90-95 */
            /********95-100 */
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
                                                    ' . $data[19] . ',
                                                    ' . $data[20] . '
                                                    
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
            $de[] = json_decode($res->getBody(), true);
            /***********95-100 */

            //dd($de);
            foreach ($de as $d) {
                //$pd = isset($d['LitePropertyList'][0]['PropertyId']) ? $d[0]['LitePropertyList'][0]['PropertyId'] : 0;

                $pid[] = $d['LitePropertyList'];
            }
            foreach ($pid as $pd) {
                $pid_all[] = $pd;
            }
            //dd($pid_all);
            $getProperty = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $authenticate,
                ],
                'body' => json_encode([
                    'ProductNames' => ['PropertyDetailReport'],

                    "SearchType" => "PROPERTY",
                    "PropertyId" => $pid_all[0][0]['PropertyId']
                ]),
            ]);
            $price[] = json_decode($getProperty->getBody(), true);

            $getProperty = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $authenticate,
                ],
                'body' => json_encode([
                    'ProductNames' => ['PropertyDetailReport'],

                    "SearchType" => "PROPERTY",
                    "PropertyId" => $pid_all[1][0]['PropertyId']
                ]),
            ]);
            $price[] = json_decode($getProperty->getBody(), true);
            $getProperty = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $authenticate,
                ],
                'body' => json_encode([
                    'ProductNames' => ['PropertyDetailReport'],

                    "SearchType" => "PROPERTY",
                    "PropertyId" => $pid_all[2][0]['PropertyId']
                ]),
            ]);
            $price[] = json_decode($getProperty->getBody(), true);
            $getProperty = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $authenticate,
                ],
                'body' => json_encode([
                    'ProductNames' => ['PropertyDetailReport'],

                    "SearchType" => "PROPERTY",
                    "PropertyId" => $pid_all[3][0]['PropertyId']
                ]),
            ]);
            $price[] = json_decode($getProperty->getBody(), true);
            $getProperty = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $authenticate,
                ],
                'body' => json_encode([
                    'ProductNames' => ['PropertyDetailReport'],

                    "SearchType" => "PROPERTY",
                    "PropertyId" => $pid_all[4][0]['PropertyId']
                ]),
            ]);
            $price[] = json_decode($getProperty->getBody(), true);
            $getProperty = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $authenticate,
                ],
                'body' => json_encode([
                    'ProductNames' => ['PropertyDetailReport'],

                    "SearchType" => "PROPERTY",
                    "PropertyId" => $pid_all[5][0]['PropertyId']
                ]),
            ]);
            $price[] = json_decode($getProperty->getBody(), true);
            $getProperty = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $authenticate,
                ],
                'body' => json_encode([
                    'ProductNames' => ['PropertyDetailReport'],

                    "SearchType" => "PROPERTY",
                    "PropertyId" => $pid_all[6][0]['PropertyId']
                ]),
            ]);
            $price[] = json_decode($getProperty->getBody(), true);
            $getProperty = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $authenticate,
                ],
                'body' => json_encode([
                    'ProductNames' => ['PropertyDetailReport'],

                    "SearchType" => "PROPERTY",
                    "PropertyId" => $pid_all[7][0]['PropertyId']
                ]),
            ]);
            $price[] = json_decode($getProperty->getBody(), true);
            $getProperty = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $authenticate,
                ],
                'body' => json_encode([
                    'ProductNames' => ['PropertyDetailReport'],

                    "SearchType" => "PROPERTY",
                    "PropertyId" => $pid_all[8][0]['PropertyId']
                ]),
            ]);
            $price[] = json_decode($getProperty->getBody(), true);
            $getProperty = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $authenticate,
                ],
                'body' => json_encode([
                    'ProductNames' => ['PropertyDetailReport'],

                    "SearchType" => "PROPERTY",
                    "PropertyId" => $pid_all[9][0]['PropertyId']
                ]),
            ]);
            $price[] = json_decode($getProperty->getBody(), true);
            $getProperty = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $authenticate,
                ],
                'body' => json_encode([
                    'ProductNames' => ['PropertyDetailReport'],

                    "SearchType" => "PROPERTY",
                    "PropertyId" => $pid_all[10][0]['PropertyId']
                ]),
            ]);
            $price[] = json_decode($getProperty->getBody(), true);
            $getProperty = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $authenticate,
                ],
                'body' => json_encode([
                    'ProductNames' => ['PropertyDetailReport'],

                    "SearchType" => "PROPERTY",
                    "PropertyId" => $pid_all[11][0]['PropertyId']
                ]),
            ]);
            $price[] = json_decode($getProperty->getBody(), true);
            $getProperty = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $authenticate,
                ],
                'body' => json_encode([
                    'ProductNames' => ['PropertyDetailReport'],

                    "SearchType" => "PROPERTY",
                    "PropertyId" => $pid_all[12][0]['PropertyId']
                ]),
            ]);
            $price[] = json_decode($getProperty->getBody(), true);
            $getProperty = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $authenticate,
                ],
                'body' => json_encode([
                    'ProductNames' => ['PropertyDetailReport'],

                    "SearchType" => "PROPERTY",
                    "PropertyId" => $pid_all[13][0]['PropertyId']
                ]),
            ]);
            $price[] = json_decode($getProperty->getBody(), true);
            $getProperty = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $authenticate,
                ],
                'body' => json_encode([
                    'ProductNames' => ['PropertyDetailReport'],

                    "SearchType" => "PROPERTY",
                    "PropertyId" => $pid_all[14][0]['PropertyId']
                ]),
            ]);
            $price[] = json_decode($getProperty->getBody(), true);
            $getProperty = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $authenticate,
                ],
                'body' => json_encode([
                    'ProductNames' => ['PropertyDetailReport'],

                    "SearchType" => "PROPERTY",
                    "PropertyId" => $pid_all[15][0]['PropertyId']
                ]),
            ]);
            $price[] = json_decode($getProperty->getBody(), true);

            $getProperty = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $authenticate,
                ],
                'body' => json_encode([
                    'ProductNames' => ['PropertyDetailReport'],

                    "SearchType" => "PROPERTY",
                    "PropertyId" => $pid_all[16][0]['PropertyId']
                ]),
            ]);
            $price[] = json_decode($getProperty->getBody(), true);
            $getProperty = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $authenticate,
                ],
                'body' => json_encode([
                    'ProductNames' => ['PropertyDetailReport'],

                    "SearchType" => "PROPERTY",
                    "PropertyId" => $pid_all[17][0]['PropertyId']
                ]),
            ]);
            $price[] = json_decode($getProperty->getBody(), true);
            $getProperty = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $authenticate,
                ],
                'body' => json_encode([
                    'ProductNames' => ['PropertyDetailReport'],

                    "SearchType" => "PROPERTY",
                    "PropertyId" => $pid_all[18][0]['PropertyId']
                ]),
            ]);
            $price[] = json_decode($getProperty->getBody(), true);
            $getProperty = $client->request('POST', 'https://dtapiuat.datatree.com/api/Report/GetReport', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $authenticate,
                ],
                'body' => json_encode([
                    'ProductNames' => ['PropertyDetailReport'],

                    "SearchType" => "PROPERTY",
                    "PropertyId" => $pid_all[19][0]['PropertyId']
                ]),
            ]);
            $price[] = json_decode($getProperty->getBody(), true);

            
            /*foreach ($data as $d) {
                //$pd = isset($d['LitePropertyList'][0]['PropertyId']) ? $d[0]['LitePropertyList'][0]['PropertyId'] : 0;

                if ($d['zipcode'] > 0 || $d['Zip'] != null) {
                    $pid[] = $d['PropertyId'];
                    $apn[] = $d['Apn'];
                    $county[] = $d['County'];
                    $stt[] = $d['State'];

                    $zip[] = $d['Zip'];
                }
            }
            foreach ($pid as $pd) {
                $pid_all[] = $pd;
            }
            foreach ($stt as $ste) {
                $st_all[] = $ste;
            }
            foreach ($county as $ct) {
                $ct_all[] = $ct;
            }
            foreach ($apn as $ap) {
                //if($d['Zip'] > 0 || $d['Zip'] != null)
                //{
                $apn_all[] = $ap;
                //}
            }
            foreach ($zip as $zp) {

                //if($zp > 0 || $zp != null)
                //{
                $zip_all[] = $zp;
                //}
            }
            //dd($de);
            //dd($pid_all);
            $data1 = [
                'zip' => $zip_all,
                'state' => $st_all,
                'county' => $ct_all,
                'apn' => $apn_all,
                'p_id' => $pid_all
            ];*/

/*********************** */
            