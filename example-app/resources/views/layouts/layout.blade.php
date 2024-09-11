<!doctype html>
<html lang="en">
<style>
  .incorrect {
    color: red;
  }

  .result {
    color: green;
  }

  #myDataTable4_wrapper,
  .work_h2i {
    font-size: 12px;
  }

  .loader {
    border: 16px solid #f3f3f3;
    border-radius: 50%;
    border-top: 16px solid #3498db;
    width: 120px;
    height: 120px;
    -webkit-animation: spin 2s linear infinite;
    /* Safari */
    animation: spin 2s linear infinite;
    margin: 0 auto;
  }

  /* Safari */
  @-webkit-keyframes spin {
    0% {
      -webkit-transform: rotate(0deg);
    }

    100% {
      -webkit-transform: rotate(360deg);
    }
  }

  @keyframes spin {
    0% {
      transform: rotate(0deg);
    }

    100% {
      transform: rotate(360deg);
    }
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
  <!-- autocomplete-->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
  <!-- subscrip-->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>

</head>

<body>
  @include('layouts.navbar');
  @yield('content')

  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script src="https://cdn.datatables.net/2.1.5/js/dataTables.js"></script>
  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.2/moment.min.js"></script>
  <script src="https://cdn.jsdelivr.net/gh/xcash/bootstrap-autocomplete@v2.3.7/dist/latest/bootstrap-autocomplete.min.js"></script>

  @stack('scripts')

  <script>
    $(document).ready(function() {
      //alert('')
      $.noConflict();
      $('.logoutUser').click(function() {
        $.ajax({
          type: 'POST',
          url: '{{ route("logout") }}',
          data: {
            _token: '{{ csrf_token() }}'
          },
          success: function(response) {
            if (response.success) {
              location.reload();
            } else {
              alert('some wrong');
            }

          }
        });
      });
      $(".run").click(function() { //alert('')
        $('.loader').show();
        $('.sm-txt').show();
      });
      $("#myDataTable4").DataTable();




    });
    $(document).ready(function() {
      $.noConflict();
      var countries = [{
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
        ],
        "fl": [{
            "label": "Alachua County",
            "value": "12001"
          },
          {
            "label": "Baker County",
            "value": "12003"
          },
          {
            "label": "Bay County",
            "value": "12005"
          },
          {
            "label": "Bradford County",
            "value": "12007"
          },
          {
            "label": "Brevard County",
            "value": "12009"
          },
          {
            "label": "Broward County",
            "value": "12011"
          },
          {
            "label": "Calhoun County",
            "value": "12013"
          },
          {
            "label": "Charlotte County",
            "value": "12015"
          },
          {
            "label": "Citrus County",
            "value": "12017"
          },
          {
            "label": "Clay County",
            "value": "12019"
          },
          {
            "label": "Collier County",
            "value": "12021"
          },
          {
            "label": "Columbia County",
            "value": "12023"
          },
          {
            "label": "DeSoto County",
            "value": "12027"
          },
          {
            "label": "Dixie County",
            "value": "12029"
          },
          {
            "label": "Duval County",
            "value": "12031"
          },
          {
            "label": "Escambia County",
            "value": "12033"
          },
          {
            "label": "Flagler County",
            "value": "12035"
          },
          {
            "label": "Franklin County",
            "value": "12037"
          },
          {
            "label": "Gadsden County",
            "value": "12039"
          },
          {
            "label": "Gilchrist County",
            "value": "12041"
          },
          {
            "label": "Glades County",
            "value": "12043"
          },
          {
            "label": "Gulf County",
            "value": "12045"
          },
          {
            "label": "Hamilton County",
            "value": "12047"
          },
          {
            "label": "Hardee County",
            "value": "12049"
          },
          {
            "label": "Hendry County",
            "value": "12051"
          },
          {
            "label": "Hernando County",
            "value": "12053"
          },
          {
            "label": "Highlands County",
            "value": "12055"
          },
          {
            "label": "Hillsborough County",
            "value": "12057"
          },
          {
            "label": "Holmes County",
            "value": "12059"
          },
          {
            "label": "Indian River County",
            "value": "12061"
          },
          {
            "label": "Jackson County",
            "value": "12063"
          },
          {
            "label": "Jefferson County",
            "value": "12065"
          },
          {
            "label": "Lafayette County",
            "value": "12067"
          },
          {
            "label": "Lake County",
            "value": "12069"
          },
          {
            "label": "Lee County",
            "value": "12071"
          },
          {
            "label": "Leon County",
            "value": "12073"
          },
          {
            "label": "Levy County",
            "value": "12075"
          },
          {
            "label": "Liberty County",
            "value": "12077"
          },
          {
            "label": "Madison County",
            "value": "12079"
          },
          {
            "label": "Manatee County",
            "value": "12081"
          },
          {
            "label": "Marion County",
            "value": "12083"
          },
          {
            "label": "Martin County",
            "value": "12085"
          },
          {
            "label": "Miami-Dade County",
            "value": "12086"
          },
          {
            "label": "Monroe County",
            "value": "12087"
          },
          {
            "label": "Nassau County",
            "value": "12089"
          },
          {
            "label": "Okaloosa County",
            "value": "12091"
          },
          {
            "label": "Okeechobee County",
            "value": "12093"
          },
          {
            "label": "Orange County",
            "value": "12095"
          },
          {
            "label": "Osceola County",
            "value": "12097"
          },
          {
            "label": "Palm Beach County",
            "value": "12099"
          },
          {
            "label": "Pasco County",
            "value": "12101"
          },
          {
            "label": "Pinellas County",
            "value": "12103"
          },
          {
            "label": "Polk County",
            "value": "12105"
          },
          {
            "label": "Putnam County",
            "value": "12107"
          },
          {
            "label": "Santa Rosa County",
            "value": "12113"
          },
          {
            "label": "Sarasota County",
            "value": "12115"
          },
          {
            "label": "Seminole County",
            "value": "12117"
          },
          {
            "label": "Sumter County",
            "value": "12119"
          },
          {
            "label": "Taylor County",
            "value": "12121"
          },
          {
            "label": "Union County",
            "value": "12123"
          },
          {
            "label": "Volusia County",
            "value": "12127"
          },
          {
            "label": "Wakulla County",
            "value": "12129"
          },
          {
            "label": "Walton County",
            "value": "12131"
          },
          {
            "label": "Washington County",
            "value": "12133"
          }
        ],
        "co": [{
            "label": "Adams County",
            "value": "08001"
          },
          {
            "label": "Alamosa County",
            "value": "08003"
          },
          {
            "label": "Arapahoe County",
            "value": "08005"
          },
          {
            "label": "Archuleta County",
            "value": "08007"
          },
          {
            "label": "Baca County",
            "value": "08009"
          },
          {
            "label": "Bent County",
            "value": "08011"
          },
          {
            "label": "Boulder County",
            "value": "08013"
          },
          {
            "label": "Chaffee County",
            "value": "08015"
          },
          {
            "label": "Cheyenne County",
            "value": "08017"
          },
          {
            "label": "Clear Creek County",
            "value": "08019"
          },
          {
            "label": "Conejos County",
            "value": "08021"
          },
          {
            "label": "Costilla County",
            "value": "08023"
          },
          {
            "label": "Crowley County",
            "value": "08025"
          },
          {
            "label": "Custer County",
            "value": "08027"
          },
          {
            "label": "Delta County",
            "value": "08029"
          },
          {
            "label": "Denver County",
            "value": "08031"
          },
          {
            "label": "Dolores County",
            "value": "08033"
          },
          {
            "label": "Douglas County",
            "value": "08035"
          },
          {
            "label": "Eagle County",
            "value": "08037"
          },
          {
            "label": "Elbert County",
            "value": "08039"
          },
          {
            "label": "El Paso County",
            "value": "08041"
          },
          {
            "label": "Fremont County",
            "value": "08043"
          },
          {
            "label": "Garfield County",
            "value": "08045"
          },
          {
            "label": "Gilpin County",
            "value": "08047"
          },
          {
            "label": "Grand County",
            "value": "08049"
          },
          {
            "label": "Gunnison County",
            "value": "08051"
          },
          {
            "label": "Huerfano County",
            "value": "08053"
          },
          {
            "label": "Jackson County",
            "value": "08055"
          },
          {
            "label": "Jefferson County",
            "value": "08057"
          },
          {
            "label": "Kiowa County",
            "value": "08059"
          },
          {
            "label": "Kit Carson County",
            "value": "08061"
          },
          {
            "label": "Lake County",
            "value": "08063"
          },
          {
            "label": "La Plata County",
            "value": "08065"
          },
          {
            "label": "Larimer County",
            "value": "08067"
          },
          {
            "label": "Las Animas County",
            "value": "08069"
          },
          {
            "label": "Lincoln County",
            "value": "08071"
          },
          {
            "label": "Logan County",
            "value": "08073"
          },
          {
            "label": "Mesa County",
            "value": "08075"
          },
          {
            "label": "Mineral County",
            "value": "08077"
          },
          {
            "label": "Moffat County",
            "value": "08079"
          },
          {
            "label": "Montezuma County",
            "value": "08081"
          },
          {
            "label": "Montrose County",
            "value": "08083"
          },
          {
            "label": "Morgan County",
            "value": "08085"
          },
          {
            "label": "Otero County",
            "value": "08087"
          },
          {
            "label": "Ouray County",
            "value": "08089"
          },
          {
            "label": "Park County",
            "value": "08091"
          },
          {
            "label": "Phillips County",
            "value": "08093"
          },
          {
            "label": "Pitkin County",
            "value": "08095"
          },
          {
            "label": "Prowers County",
            "value": "08097"
          },
          {
            "label": "Pueblo County",
            "value": "08099"
          },
          {
            "label": "Rio Grande County",
            "value": "08101"
          },
          {
            "label": "Routt County",
            "value": "08103"
          },
          {
            "label": "Saguache County",
            "value": "08105"
          },
          {
            "label": "San Juan County",
            "value": "08107"
          },
          {
            "label": "San Miguel County",
            "value": "08109"
          },
          {
            "label": "Sedgwick County",
            "value": "08111"
          },
          {
            "label": "Summit County",
            "value": "08113"
          },
          {
            "label": "Teller County",
            "value": "08115"
          },
          {
            "label": "Washington County",
            "value": "08117"
          },
          {
            "label": "Weld County",
            "value": "08119"
          },
          {
            "label": "Yuma County",
            "value": "08121"
          }
        ],
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
      });
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
        actual = total.toFixed(2);

      });
      $("#total_val").text(actual);

    }
  </script>