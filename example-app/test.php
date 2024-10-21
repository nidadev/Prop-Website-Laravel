<?php
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
            //dd($redfin_sold_data);
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
           
            // Create a response with the XML content
            $pdf = Pdf::loadView('pdf2', $data);
            return $pdf->download('compreport.pdf');
        } catch (\Exception $e) {
            //$response = $e->getResponse();
            $emsg = $e->getMessage();
            //dd($emsg);
            $fromserver = isset($response) ? $response : 'No records found . or Server error';

            $error = $emsg;
            //dd($response['reasonPhrase']);
            return  redirect()->to('compreport')->with('error', $error);
        }
    }
    ?>