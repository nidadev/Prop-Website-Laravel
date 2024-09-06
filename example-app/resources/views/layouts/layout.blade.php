<!doctype html>
<html lang="en">
<style>
  .incorrect
  {
    color:red;
  }
  .result
  {
    color:green;
  }
  </style>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Trial and Subscription</title>
    <link href="{{ asset('css/global.css') }}" rel="stylesheet">
    <link href="{{ asset('css/contact.css') }}" rel="stylesheet">
    <link href="{{ asset('css/index.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.datatables.net/2.1.5/css/dataTables.dataTables.css" rel="stylesheet" crossorigin="anonymous">
      </head>
  <body>
    @include('layouts.navbar');
    @yield('content')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/2.1.5/js/dataTables.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.2/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
@stack('scripts')
<script>

     $(document).ready(function() {
      //alert('')
        $.noConflict();
        $("#myDataTable4").DataTable();
$('.confirmationBtn').click(function(){
  var planId = $(this).data('id');

  $.ajax({
    type:'POST',
    url:'{{ route("getPlanDetails") }}',
    data:{id:planId, _token: '{{ csrf_token() }}' },
    success:function(response){
      if(response.success)
    {

    }
    else
    {
      alert('something went wrong');
    }
       
    },

  });
});

        /*var countries = [{
                "label": "Alabama",
                "value": "al"
            },
            {
                "label": "Alaska",
                "value": "ak"
            },
            {
                "label": "Arizona",
                "value": "az"
            },
            {
                "label": "Arkansas",
                "value": "ar"
            },
            {
                "label": "California",
                "value": "ca"
            },
            {
                "label": "Colorado",
                "value": "co"
            },
            {
                "label": "Connecticut",
                "value": "ct"
            },
            {
                "label": "Delaware",
                "value": "de"
            },
            {
                "label": "Florida",
                "value": "fl"
            },
            {
                "label": "Georgia",
                "value": "ga"
            },
            {
                "label": "Hawaii",
                "value": "hi"
            },
            {
                "label": "Idaho",
                "value": "id"
            },
            {
                "label": "Illinois",
                "value": "il"
            },
            {
                "label": "Indiana",
                "value": "in"
            },
            {
                "label": "Iowa",
                "value": "ia"
            },
            {
                "label": "Kansas",
                "value": "ks"
            },
            {
                "label": "Kentucky",
                "value": "ky"
            },
            {
                "label": "Louisiana",
                "value": "la"
            },
            {
                "label": "Maine",
                "value": "me"
            },
            {
                "label": "Maryland",
                "value": "md"
            },
            {
                "label": "Massachusetts",
                "value": "ma"
            },
            {
                "label": "Michigan",
                "value": "mi"
            },
            {
                "label": "Minnesota",
                "value": "mn"
            },
            {
                "label": "Mississippi",
                "value": "ms"
            },
            {
                "label": "Missouri",
                "value": "mo"
            },
            {
                "label": "Montana",
                "value": "mt"
            },
            {
                "label": "Nebraska",
                "value": "ne"
            },
            {
                "label": "Nevada",
                "value": "nv"
            },
            {
                "label": "New Hampshire",
                "value": "nh"
            },
            {
                "label": "New Jersey",
                "value": "nj"
            },
            {
                "label": "New Mexico",
                "value": "nm"
            },
            {
                "label": "New York",
                "value": "ny"
            },
            {
                "label": "North Carolina",
                "value": "nc"
            },
            {
                "label": "North Dakota",
                "value": "nd"
            },
            {
                "label": "Ohio",
                "value": "oh"
            },
            {
                "label": "Oklahoma",
                "value": "ok"
            },
            {
                "label": "Oregon",
                "value": "or"
            },
            {
                "label": "Pennsylvania",
                "value": "pa"
            },
            {
                "label": "Rhode Island",
                "value": "ri"
            },
            {
                "label": "South Carolina",
                "value": "sc"
            },
            {
                "label": "South Dakota",
                "value": "sd"
            },
            {
                "label": "Tennessee",
                "value": "tn"
            },
            {
                "label": "Texas",
                "value": "tx"
            },
            {
                "label": "Utah",
                "value": "ut"
            },
            {
                "label": "Vermont",
                "value": "vt"
            },
            {
                "label": "Virginia",
                "value": "va"
            },
            {
                "label": "Washington",
                "value": "wa"
            },
            {
                "label": "West Virginia",
                "value": "wv"
            },
            {
                "label": "Wisconsin",
                "value": "wi"
            },
            {
                "label": "Wyoming",
                "value": "wy"
            }
        ];

        var counties = {
            "al": [{
                    "label": "Autauga",
                    "value": "1001"
                },
                {
                    "label": "Baldwin",
                    "value": "1003"
                },
                {
                    "label": "Barbour",
                    "value": "1005"
                },
                {
                    "label": "Bibb",
                    "value": "1007"
                },
                {
                    "label": "Blount",
                    "value": "1009"
                },
                {
                    "label": "Bullock",
                    "value": "1011"
                },
                {
                    "label": "Chambers",
                    "value": "1013"
                },
                {
                    "label": "Cherokee",
                    "value": "1015"
                },
                {
                    "label": "Chilton",
                    "value": "1017"
                },
                {
                    "label": "Choctaw",
                    "value": "1019"
                },
                {
                    "label": "Clarke",
                    "value": "1021"
                },
                {
                    "label": "Clay",
                    "value": "1023"
                },
                {
                    "label": "Cleburne",
                    "value": "1025"
                },
                {
                    "label": "Coffee",
                    "value": "1027"
                },
                {
                    "label": "Colbert",
                    "value": "1029"
                },
                {
                    "label": "Conecuh",
                    "value": "1031"
                },
                {
                    "label": "Coosa",
                    "value": "1033"
                },
                {
                    "label": "Covington",
                    "value": "1035"
                },
                {
                    "label": "Crenshaw",
                    "value": "1037"
                },
                {
                    "label": "Cullman",
                    "value": "1039"
                },
                {
                    "label": "Dale",
                    "value": "1041"
                },
                {
                    "label": "Dallas",
                    "value": "1043"
                },
                {
                    "label": "DeKalb",
                    "value": "1045"
                },
                {
                    "label": "Elmore",
                    "value": "1047"
                },
                {
                    "label": "Escambia",
                    "value": "1049"
                },
                {
                    "label": "Etowah",
                    "value": "1051"
                },
                {
                    "label": "Fayette",
                    "value": "1053"
                },
                {
                    "label": "Franklin",
                    "value": "1055"
                },
                {
                    "label": "Geneva",
                    "value": "1057"
                },
                {
                    "label": "Greene",
                    "value": "1059"
                },
                {
                    "label": "Hale",
                    "value": "1061"
                },
                {
                    "label": "Henry",
                    "value": "1063"
                },
                {
                    "label": "Houston",
                    "value": "1065"
                },
                {
                    "label": "Jackson",
                    "value": "1067"
                },
                {
                    "label": "Jefferson",
                    "value": "1069"
                },
                {
                    "label": "Lamar",
                    "value": "1071"
                },
                {
                    "label": "Lauderdale",
                    "value": "1073"
                },
                {
                    "label": "Lawrence",
                    "value": "1075"
                },
                {
                    "label": "Lee",
                    "value": "1077"
                },
                {
                    "label": "Limestone",
                    "value": "1079"
                },
                {
                    "label": "Lowndes",
                    "value": "1081"
                },
                {
                    "label": "Macon",
                    "value": "1083"
                },
                {
                    "label": "Madison",
                    "value": "1085"
                },
                {
                    "label": "Marengo",
                    "value": "1087"
                },
                {
                    "label": "Marion",
                    "value": "1089"
                },
                {
                    "label": "Marshall",
                    "value": "1091"
                },
                {
                    "label": "Mobile",
                    "value": "1093"
                },
                {
                    "label": "Monroe",
                    "value": "1095"
                },
                {
                    "label": "Montgomery",
                    "value": "1097"
                },
                {
                    "label": "Morgan",
                    "value": "1099"
                },
                {
                    "label": "Perry",
                    "value": "1101"
                },
                {
                    "label": "Pickens",
                    "value": "1103"
                },
                {
                    "label": "Pike",
                    "value": "1105"
                },
                {
                    "label": "Randolph",
                    "value": "1107"
                },
                {
                    "label": "Russell",
                    "value": "1109"
                },
                {
                    "label": "St. Clair",
                    "value": "1111"
                },
                {
                    "label": "Shelby",
                    "value": "1113"
                },
                {
                    "label": "Sumter",
                    "value": "1115"
                },
                {
                    "label": "Talladega",
                    "value": "1117"
                },
                {
                    "label": "Tallapoosa",
                    "value": "1119"
                },
                {
                    "label": "Tuscaloosa",
                    "value": "1121"
                },
                {
                    "label": "Walker",
                    "value": "1123"
                },
                {
                    "label": "Washington",
                    "value": "1125"
                },
                {
                    "label": "Wilcox",
                    "value": "1127"
                },
                {
                    "label": "Winston",
                    "value": "1129"
                }
                // Add additional counties for Alabama
            ],
            "ak": [{
                    "label": "Aleutians East",
                    "value": "2013"
                },
                {
                    "label": "Aleutians West",
                    "value": "2016"
                },
                {
                    "label": "Anchorage",
                    "value": "2020"
                },
                {
                    "label": "Bethel",
                    "value": "2050"
                },
                {
                    "label": "Bristol Bay",
                    "value": "2060"
                },
                {
                    "label": "Denali",
                    "value": "2070"
                },
                {
                    "label": "Dillingham",
                    "value": "2080"
                },
                {
                    "label": "Haines",
                    "value": "2090"
                },
                {
                    "label": "Hoonah-Angoon",
                    "value": "2095"
                },
                {
                    "label": "Juneau",
                    "value": "2100"
                },
                {
                    "label": "Kenai Peninsula",
                    "value": "2120"
                },
                {
                    "label": "Ketchikan Gateway",
                    "value": "2130"
                },
                {
                    "label": "Kodiak Island",
                    "value": "2140"
                },
                {
                    "label": "Lake and Peninsula",
                    "value": "2150"
                },
                {
                    "label": "Matanuska-Susitna",
                    "value": "2160"
                },
                {
                    "label": "Nome",
                    "value": "2170"
                },
                {
                    "label": "North Slope",
                    "value": "2180"
                },
                {
                    "label": "Northwest Arctic",
                    "value": "2190"
                },
                {
                    "label": "Petersburg",
                    "value": "2200"
                },
                {
                    "label": "Prince of Wales-Hyder",
                    "value": "2210"
                },
                {
                    "label": "Sitka",
                    "value": "2220"
                },
                {
                    "label": "Skagway",
                    "value": "2230"
                },
                {
                    "label": "Southeast Fairbanks",
                    "value": "2240"
                },
                {
                    "label": "Valdez-Cordova",
                    "value": "2250"
                },
                {
                    "label": "Wade Hampton",
                    "value": "2260"
                },
                {
                    "label": "Wrangell",
                    "value": "2270"
                },
                {
                    "label": "Yukon-Koyukuk",
                    "value": "2280"
                }
                // Add additional counties for Alaska
            ],
            "az": [{
                    "label": "Apache",
                    "value": "4001"
                },
                {
                    "label": "Cochise",
                    "value": "4003"
                },
                {
                    "label": "Coconino",
                    "value": "4005"
                },
                {
                    "label": "Gila",
                    "value": "4007"
                },
                {
                    "label": "Graham",
                    "value": "4009"
                },
                {
                    "label": "Greenlee",
                    "value": "4011"
                },
                {
                    "label": "La Paz",
                    "value": "4012"
                },
                {
                    "label": "Maricopa",
                    "value": "4013"
                },
                {
                    "label": "Mohave",
                    "value": "4015"
                },
                {
                    "label": "Navajo",
                    "value": "4017"
                },
                {
                    "label": "Pima",
                    "value": "4019"
                },
                {
                    "label": "Pinal",
                    "value": "4021"
                },
                {
                    "label": "Santa Cruz",
                    "value": "4023"
                },
                {
                    "label": "Yavapai",
                    "value": "4025"
                },
                {
                    "label": "Yuma",
                    "value": "4027"
                }
                // Add additional counties for Arizona
            ],
            "ar": [{
                    "label": "Arkansas",
                    "value": "05001"
                },
                {
                    "label": "Ashley",
                    "value": "05003"
                },
                {
                    "label": "Baxter",
                    "value": "05005"
                },
                {
                    "label": "Benton",
                    "value": "05007"
                },
                {
                    "label": "Boone",
                    "value": "05009"
                }
                // Add additional counties for Arkansas
            ],
            "ca": [{
                    "label": "Alameda",
                    "value": "6001"
                },
                {
                    "label": "Alpine",
                    "value": "6003"
                },
                {
                    "label": "Amador",
                    "value": "6005"
                },
                {
                    "label": "Butte",
                    "value": "6007"
                },
                {
                    "label": "Calaveras",
                    "value": "6009"
                },
                {
                    "label": "Colusa",
                    "value": "6011"
                },
                {
                    "label": "Contra Costa",
                    "value": "6013"
                },
                {
                    "label": "Del Norte",
                    "value": "6015"
                },
                {
                    "label": "El Dorado",
                    "value": "6017"
                },
                {
                    "label": "Fresno",
                    "value": "6019"
                },
                {
                    "label": "Glenn",
                    "value": "6021"
                },
                {
                    "label": "Humboldt",
                    "value": "6023"
                },
                {
                    "label": "Imperial",
                    "value": "6025"
                },
                {
                    "label": "Inyo",
                    "value": "6027"
                },
                {
                    "label": "Kern",
                    "value": "6029"
                },
                {
                    "label": "Kings",
                    "value": "6031"
                },
                {
                    "label": "Lake",
                    "value": "6033"
                },
                {
                    "label": "Lassen",
                    "value": "6035"
                },
                {
                    "label": "Los Angeles",
                    "value": "6037"
                },
                {
                    "label": "Madera",
                    "value": "6039"
                },
                {
                    "label": "Marin",
                    "value": "6041"
                },
                {
                    "label": "Mariposa",
                    "value": "6043"
                },
                {
                    "label": "Mendocino",
                    "value": "6045"
                },
                {
                    "label": "Merced",
                    "value": "6047"
                },
                {
                    "label": "Modoc",
                    "value": "6049"
                },
                {
                    "label": "Mono",
                    "value": "6051"
                },
                {
                    "label": "Monterey",
                    "value": "6053"
                },
                {
                    "label": "Napa",
                    "value": "6055"
                },
                {
                    "label": "Nevada",
                    "value": "6057"
                },
                {
                    "label": "Orange",
                    "value": "6059"
                },
                {
                    "label": "Placer",
                    "value": "6061"
                },
                {
                    "label": "Plumas",
                    "value": "6063"
                },
                {
                    "label": "Riverside",
                    "value": "6065"
                },
                {
                    "label": "Sacramento",
                    "value": "6067"
                },
                {
                    "label": "San Benito",
                    "value": "6069"
                },
                {
                    "label": "San Bernardino",
                    "value": "6071"
                },
                {
                    "label": "San Diego",
                    "value": "6073"
                },
                {
                    "label": "San Francisco",
                    "value": "6075"
                },
                {
                    "label": "San Joaquin",
                    "value": "6077"
                },
                {
                    "label": "San Luis Obispo",
                    "value": "6079"
                },
                {
                    "label": "San Mateo",
                    "value": "6081"
                },
                {
                    "label": "Santa Barbara",
                    "value": "6083"
                },
                {
                    "label": "Santa Clara",
                    "value": "6085"
                },
                {
                    "label": "Santa Cruz",
                    "value": "6087"
                },
                {
                    "label": "Shasta",
                    "value": "6089"
                },
                {
                    "label": "Sierra",
                    "value": "6091"
                },
                {
                    "label": "Siskiyou",
                    "value": "6093"
                },
                {
                    "label": "Solano",
                    "value": "6095"
                },
                {
                    "label": "Sonoma",
                    "value": "6097"
                },
                {
                    "label": "Stanislaus",
                    "value": "6099"
                },
                {
                    "label": "Sutter",
                    "value": "6101"
                },
                {
                    "label": "Tehama",
                    "value": "6103"
                },
                {
                    "label": "Trinity",
                    "value": "6105"
                },
                {
                    "label": "Tulare",
                    "value": "6107"
                },
                {
                    "label": "Tuolumne",
                    "value": "6109"
                },
                {
                    "label": "Ventura",
                    "value": "6111"
                },
                {
                    "label": "Yolo",
                    "value": "6113"
                },
                {
                    "label": "Yuba",
                    "value": "6115"
                }
                // Add additional counties as needed
            ]
        };

        $("#autocomplete").autocomplete({
            source: countries,
            select: function(event, ui) {
                var selectedCountry = ui.item.value;
                var countySelect = $("#counties");

                // Clear existing options
                countySelect.empty();

                // Add a default option
                countySelect.append('<option value="">Select a county</option>');

                // Populate counties based on selected country
                if (counties[selectedCountry]) {
                    $.each(counties[selectedCountry], function(index, county) {
                        countySelect.append(
                            $('<option>').val(county.value).text(county.label)
                        );
                    });
                } else {
                    countySelect.append('<option value="">No counties available</option>');
                }
            }
        });*/
     });
     function toggle(data) {
        if ($('.su').is(':checked')) {
            $("#chk").show();
            $("#amnt").show();
        } else {
            $("#chk").hide();
            $("#amnt").hide();
        }
        var total = 0;
        $('.su:checked').each(function() { // iterate through each checked element.

            total += isNaN(parseFloat($(this).val())) ? 0 : parseFloat($(this).val());
            actual = total;

        });
        $("#total_val").text(actual);

    }
    </script>
  </body>
</html>