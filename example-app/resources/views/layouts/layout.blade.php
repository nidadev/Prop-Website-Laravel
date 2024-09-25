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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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


  <!---->
   <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDUlTRmXjx-f1V0WYh3vJ7BaxbNNzFJVgQ&callback=initMap&v=weekly"
        defer
      ></script>
      <script type="module" src="script2.js"></script>

  <!-- -->
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
        "de":[
  {
    "label": "New Castle County",
    "value": "10003"
  },
  {
    "label": "Kent County",
    "value": "10001"
  },
  {
    "label": "Sussex County",
    "value": "10005"
  }
],
"dc":[
  {
    "label": "District of Columbia",
    "value": "11001"  // Note: There is no official FIPS code for D.C. counties, so this is a placeholder.
  }
],
"ga":[
  {
    "label": "Appling County",
    "value": "13001"
  },
  {
    "label": "Atkinson County",
    "value": "13003"
  },
  {
    "label": "Bacon County",
    "value": "13005"
  },
  {
    "label": "Baker County",
    "value": "13007"
  },
  {
    "label": "Baldwin County",
    "value": "13009"
  },
  {
    "label": "Banks County",
    "value": "13011"
  },
  {
    "label": "Barrow County",
    "value": "13013"
  },
  {
    "label": "Bartow County",
    "value": "13015"
  },
  {
    "label": "Ben Hill County",
    "value": "13017"
  },
  {
    "label": "Berrien County",
    "value": "13019"
  },
  {
    "label": "Bibb County",
    "value": "13021"
  },
  {
    "label": "Bleckley County",
    "value": "13023"
  },
  {
    "label": "Brantley County",
    "value": "13025"
  },
  {
    "label": "Brooks County",
    "value": "13027"
  },
  {
    "label": "Bryan County",
    "value": "13029"
  },
  {
    "label": "Bulloch County",
    "value": "13031"
  },
  {
    "label": "Burke County",
    "value": "13033"
  },
  {
    "label": "Butts County",
    "value": "13035"
  },
  {
    "label": "Calhoun County",
    "value": "13037"
  },
  {
    "label": "Camden County",
    "value": "13039"
  },
  {
    "label": "Candler County",
    "value": "13043"
  },
  {
    "label": "Carroll County",
    "value": "13045"
  },
  {
    "label": "Catoosa County",
    "value": "13047"
  },
  {
    "label": "Charlton County",
    "value": "13049"
  },
  {
    "label": "Chatham County",
    "value": "13051"
  },
  {
    "label": "Chattahoochee County",
    "value": "13053"
  },
  {
    "label": "Cherokee County",
    "value": "13057"
  },
  {
    "label": "Clarke County",
    "value": "13059"
  },
  {
    "label": "Clay County",
    "value": "13061"
  },
  {
    "label": "Clayton County",
    "value": "13063"
  },
  {
    "label": "Clinch County",
    "value": "13065"
  },
  {
    "label": "Cobb County",
    "value": "13067"
  },
  {
    "label": "Coffee County",
    "value": "13069"
  },
  {
    "label": "Colquitt County",
    "value": "13071"
  },
  {
    "label": "Columbia County",
    "value": "13073"
  },
  {
    "label": "Cook County",
    "value": "13075"
  },
  {
    "label": "Coweta County",
    "value": "13077"
  },
  {
    "label": "Crawford County",
    "value": "13079"
  },
  {
    "label": "Crisp County",
    "value": "13081"
  },
  {
    "label": "Dade County",
    "value": "13083"
  },
  {
    "label": "Dawson County",
    "value": "13085"
  },
  {
    "label": "DeKalb County",
    "value": "13087"
  },
  {
    "label": "Decatur County",
    "value": "13089"
  },
  {
    "label": "Dodge County",
    "value": "13091"
  },
  {
    "label": "Dooly County",
    "value": "13093"
  },
  {
    "label": "Dougherty County",
    "value": "13095"
  },
  {
    "label": "Douglas County",
    "value": "13097"
  },
  {
    "label": "Early County",
    "value": "13099"
  },
  {
    "label": "Echols County",
    "value": "13101"
  },
  {
    "label": "Effingham County",
    "value": "13103"
  },
  {
    "label": "Elbert County",
    "value": "13105"
  },
  {
    "label": "Emanuel County",
    "value": "13107"
  },
  {
    "label": "Evans County",
    "value": "13109"
  },
  {
    "label": "Fannin County",
    "value": "13111"
  },
  {
    "label": "Fayette County",
    "value": "13113"
  },
  {
    "label": "Floyd County",
    "value": "13115"
  },
  {
    "label": "Forsyth County",
    "value": "13117"
  },
  {
    "label": "Franklin County",
    "value": "13119"
  },
  {
    "label": "Fulton County",
    "value": "13121"
  },
  {
    "label": "Gilmer County",
    "value": "13123"
  },
  {
    "label": "Glascock County",
    "value": "13125"
  },
  {
    "label": "Glynn County",
    "value": "13127"
  },
  {
    "label": "Gordon County",
    "value": "13129"
  },
  {
    "label": "Grady County",
    "value": "13131"
  },
  {
    "label": "Greene County",
    "value": "13133"
  },
  {
    "label": "Gwinnett County",
    "value": "13135"
  },
  {
    "label": "Habersham County",
    "value": "13137"
  },
  {
    "label": "Hall County",
    "value": "13139"
  },
  {
    "label": "Hancock County",
    "value": "13141"
  },
  {
    "label": "Haralson County",
    "value": "13143"
  },
  {
    "label": "Harris County",
    "value": "13145"
  },
  {
    "label": "Hart County",
    "value": "13147"
  },
  {
    "label": "Heard County",
    "value": "13149"
  },
  {
    "label": "Henry County",
    "value": "13151"
  },
  {
    "label": "Houston County",
    "value": "13153"
  },
  {
    "label": "Irwin County",
    "value": "13155"
  },
  {
    "label": "Jackson County",
    "value": "13157"
  },
  {
    "label": "Jasper County",
    "value": "13159"
  },
  {
    "label": "Jeff Davis County",
    "value": "13161"
  },
  {
    "label": "Jefferson County",
    "value": "13163"
  },
  {
    "label": "Jenkins County",
    "value": "13165"
  },
  {
    "label": "Johnson County",
    "value": "13167"
  },
  {
    "label": "Jones County",
    "value": "13169"
  },
  {
    "label": "Lamar County",
    "value": "13171"
  },
  {
    "label": "Lanier County",
    "value": "13173"
  },
  {
    "label": "Laurens County",
    "value": "13175"
  },
  {
    "label": "Lee County",
    "value": "13177"
  },
  {
    "label": "Liberty County",
    "value": "13179"
  },
  {
    "label": "Lincoln County",
    "value": "13181"
  },
  {
    "label": "Long County",
    "value": "13183"
  },
  {
    "label": "Lowndes County",
    "value": "13185"
  },
  {
    "label": "Lumpkin County",
    "value": "13187"
  },
  {
    "label": "McDuffie County",
    "value": "13189"
  },
  {
    "label": "McIntosh County",
    "value": "13191"
  },
  {
    "label": "Macon County",
    "value": "13193"
  },
  {
    "label": "Madison County",
    "value": "13195"
  },
  {
    "label": "Marion County",
    "value": "13197"
  },
  {
    "label": "Meriwether County",
    "value": "13199"
  },
  {
    "label": "Miller County",
    "value": "13201"
  },
  {
    "label": "Mitchell County",
    "value": "13205"
  },
  {
    "label": "Monroe County",
    "value": "13207"
  },
  {
    "label": "Montgomery County",
    "value": "13209"
  },
  {
    "label": "Morgan County",
    "value": "13211"
  },
  {
    "label": "Murray County",
    "value": "13213"
  },
  {
    "label": "Muscogee County",
    "value": "13215"
  },
  {
    "label": "Newton County",
    "value": "13217"
  },
  {
    "label": "Oconee County",
    "value": "13219"
  },
  {
    "label": "Oglethorpe County",
    "value": "13221"
  },
  {
    "label": "Paulding County",
    "value": "13223"
  },
  {
    "label": "Peach County",
    "value": "13225"
  },
  {
    "label": "Pickens County",
    "value": "13227"
  },
  {
    "label": "Pierce County",
    "value": "13229"
  },
  {
    "label": "Pike County",
    "value": "13231"
  },
  {
    "label": "Polk County",
    "value": "13233"
  },
  {
    "label": "Pulaski County",
    "value": "13235"
  },
  {
    "label": "Putnam County",
    "value": "13237"
  },
  {
    "label": "Quitman County",
    "value": "13239"
  },
  {
    "label": "Rabun County",
    "value": "13241"
  },
  {
    "label": "Randolph County",
    "value": "13243"
  },
  {
    "label": "Richmond County",
    "value": "13245"
  },
  {
    "label": "Rockdale County",
    "value": "13247"
  },
  {
    "label": "Schley County",
    "value": "13249"
  },
  {
    "label": "Seminole County",
    "value": "13251"
  },
  {
    "label": "Spalding County",
    "value": "13253"
  },
  {
    "label": "Stephens County",
    "value": "13255"
  },
  {
    "label": "Stewart County",
    "value": "13257"
  },
  {
    "label": "Sumter County",
    "value": "13259"
  },
  {
    "label": "Talbot County",
    "value": "13261"
  },
  {
    "label": "Taliaferro County",
    "value": "13263"
  },
  {
    "label": "Tattnall County",
    "value": "13265"
  },
  {
    "label": "Taylor County",
    "value": "13267"
  },
  {
    "label": "Terrell County",
    "value": "13269"
  },
  {
    "label": "Thomas County",
    "value": "13271"
  },
  {
    "label": "Tift County",
    "value": "13273"
  },
  {
    "label": "Toombs County",
    "value": "13275"
  },
  {
    "label": "Towns County",
    "value": "13277"
  },
  {
    "label": "Treutlen County",
    "value": "13279"
  },
  {
    "label": "Troup County",
    "value": "13281"
  },
  {
    "label": "Turner County",
    "value": "13283"
  },
  {
    "label": "Twiggs County",
    "value": "13285"
  },
  {
    "label": "Union County",
    "value": "13287"
  },
  {
    "label": "Upson County",
    "value": "13289"
  },
  {
    "label": "Walker County",
    "value": "13291"
  },
  {
    "label": "Walton County",
    "value": "13293"
  },
  {
    "label": "Ware County",
    "value": "13295"
  },
  {
    "label": "Warren County",
    "value": "13297"
  },
  {
    "label": "Washington County",
    "value": "13299"
  },
  {
    "label": "Wayne County",
    "value": "13301"
  },
  {
    "label": "Webster County",
    "value": "13303"
  },
  {
    "label": "Wheeler County",
    "value": "13305"
  },
  {
    "label": "White County",
    "value": "13307"
  },
  {
    "label": "Whitfield County",
    "value": "13309"
  },
  {
    "label": "Wilcox County",
    "value": "13311"
  },
  {
    "label": "Wilkes County",
    "value": "13313"
  },
  {
    "label": "Williamson County",
    "value": "13315"
  },
  {
    "label": "Worth County",
    "value": "13317"
  }
],
"hi":[
  {
    "label": "Hawaii County",
    "value": "15001"
  },
  {
    "label": "Honolulu County",
    "value": "15003"
  },
  {
    "label": "Kalawao County",
    "value": "15005"
  },
  {
    "label": "Kauai County",
    "value": "15007"
  },
  {
    "label": "Maui County",
    "value": "15009"
  }
],
"id" : [
  {
    "label": "Ada County",
    "value": "16001"
  },
  {
    "label": "Adams County",
    "value": "16003"
  },
  {
    "label": "Bannock County",
    "value": "16005"
  },
  {
    "label": "Bear Lake County",
    "value": "16007"
  },
  {
    "label": "Benewah County",
    "value": "16009"
  },
  {
    "label": "Bingham County",
    "value": "16011"
  },
  {
    "label": "Blaine County",
    "value": "16013"
  },
  {
    "label": "Boise County",
    "value": "16015"
  },
  {
    "label": "Bonner County",
    "value": "16017"
  },
  {
    "label": "Bonners Ferry County",
    "value": "16019"
  },
  {
    "label": "Boundary County",
    "value": "16021"
  },
  {
    "label": "Butte County",
    "value": "16023"
  },
  {
    "label": "Camas County",
    "value": "16025"
  },
  {
    "label": "Canyon County",
    "value": "16027"
  },
  {
    "label": "Caribou County",
    "value": "16029"
  },
  {
    "label": "Cassia County",
    "value": "16031"
  },
  {
    "label": "Clark County",
    "value": "16033"
  },
  {
    "label": "Clearwater County",
    "value": "16035"
  },
  {
    "label": "Custer County",
    "value": "16037"
  },
  {
    "label": "Elmore County",
    "value": "16039"
  },
  {
    "label": "Franklin County",
    "value": "16041"
  },
  {
    "label": "Fremont County",
    "value": "16043"
  },
  {
    "label": "Gem County",
    "value": "16045"
  },
  {
    "label": "Gooding County",
    "value": "16047"
  },
  {
    "label": "Idaho County",
    "value": "16049"
  },
  {
    "label": "Jefferson County",
    "value": "16051"
  },
  {
    "label": "Jerome County",
    "value": "16053"
  },
  {
    "label": "Kootenai County",
    "value": "16055"
  },
  {
    "label": "Latah County",
    "value": "16057"
  },
  {
    "label": "Lemhi County",
    "value": "16059"
  },
  {
    "label": "Lewis County",
    "value": "16061"
  },
  {
    "label": "Lincoln County",
    "value": "16063"
  },
  {
    "label": "Madison County",
    "value": "16065"
  },
  {
    "label": "Minidoka County",
    "value": "16067"
  },
  {
    "label": "Nez Perce County",
    "value": "16069"
  },
  {
    "label": "Owyhee County",
    "value": "16071"
  },
  {
    "label": "Payette County",
    "value": "16073"
  },
  {
    "label": "Power County",
    "value": "16075"
  },
  {
    "label": "Shoshone County",
    "value": "16077"
  },
  {
    "label": "Teton County",
    "value": "16079"
  },
  {
    "label": "Twin Falls County",
    "value": "16081"
  },
  {
    "label": "Valley County",
    "value": "16083"
  },
  {
    "label": "Washington County",
    "value": "16085"
  }
],
"il" : [
  {
    "label": "Adams County",
    "value": "17001"
  },
  {
    "label": "Bond County",
    "value": "17003"
  },
  {
    "label": "Boone County",
    "value": "17005"
  },
  {
    "label": "Brown County",
    "value": "17007"
  },
  {
    "label": "Bureau County",
    "value": "17009"
  },
  {
    "label": "Calhoun County",
    "value": "17011"
  },
  {
    "label": "Carroll County",
    "value": "17013"
  },
  {
    "label": "Cass County",
    "value": "17015"
  },
  {
    "label": "Champaign County",
    "value": "17017"
  },
  {
    "label": "Christian County",
    "value": "17019"
  },
  {
    "label": "Clark County",
    "value": "17021"
  },
  {
    "label": "Clay County",
    "value": "17023"
  },
  {
    "label": "Clinton County",
    "value": "17025"
  },
  {
    "label": "Coles County",
    "value": "17027"
  },
  {
    "label": "Cook County",
    "value": "17031"
  },
  {
    "label": "Crawford County",
    "value": "17033"
  },
  {
    "label": "Cumberland County",
    "value": "17035"
  },
  {
    "label": "DeKalb County",
    "value": "17037"
  },
  {
    "label": "Douglas County",
    "value": "17039"
  },
  {
    "label": "DuPage County",
    "value": "17043"
  },
  {
    "label": "Edgar County",
    "value": "17045"
  },
  {
    "label": "Edwards County",
    "value": "17047"
  },
  {
    "label": "Effingham County",
    "value": "17049"
  },
  {
    "label": "Fayette County",
    "value": "17051"
  },
  {
    "label": "Ford County",
    "value": "17053"
  },
  {
    "label": "Franklin County",
    "value": "17055"
  },
  {
    "label": "Fulton County",
    "value": "17057"
  },
  {
    "label": "Gallatin County",
    "value": "17059"
  },
  {
    "label": "Greene County",
    "value": "17061"
  },
  {
    "label": "Grundy County",
    "value": "17063"
  },
  {
    "label": "Hamilton County",
    "value": "17065"
  },
  {
    "label": "Hancock County",
    "value": "17067"
  },
  {
    "label": "Hardin County",
    "value": "17069"
  },
  {
    "label": "Henderson County",
    "value": "17071"
  },
  {
    "label": "Henry County",
    "value": "17073"
  },
  {
    "label": "Iroquois County",
    "value": "17075"
  },
  {
    "label": "Jackson County",
    "value": "17077"
  },
  {
    "label": "Jasper County",
    "value": "17079"
  },
  {
    "label": "Jefferson County",
    "value": "17081"
  },
  {
    "label": "Jersey County",
    "value": "17083"
  },
  {
    "label": "Jo Daviess County",
    "value": "17085"
  },
  {
    "label": "Johnson County",
    "value": "17087"
  },
  {
    "label": "Kane County",
    "value": "17089"
  },
  {
    "label": "Kankakee County",
    "value": "17091"
  },
  {
    "label": "Kendall County",
    "value": "17093"
  },
  {
    "label": "Knox County",
    "value": "17095"
  },
  {
    "label": "LaSalle County",
    "value": "17097"
  },
  {
    "label": "Lake County",
    "value": "17099"
  },
  {
    "label": "Lawrence County",
    "value": "17101"
  },
  {
    "label": "Lee County",
    "value": "17103"
  },
  {
    "label": "Livingston County",
    "value": "17105"
  },
  {
    "label": "Logan County",
    "value": "17107"
  },
  {
    "label": "Macoupin County",
    "value": "17109"
  },
  {
    "label": "Madison County",
    "value": "17111"
  },
  {
    "label": "Marion County",
    "value": "17113"
  },
  {
    "label": "Marshall County",
    "value": "17115"
  },
  {
    "label": "Mason County",
    "value": "17117"
  },
  {
    "label": "Massac County",
    "value": "17119"
  },
  {
    "label": "Menard County",
    "value": "17121"
  },
  {
    "label": "Mercer County",
    "value": "17123"
  },
  {
    "label": "Monroe County",
    "value": "17125"
  },
  {
    "label": "Montgomery County",
    "value": "17127"
  },
  {
    "label": "Morgan County",
    "value": "17129"
  },
  {
    "label": "Moultrie County",
    "value": "17131"
  },
  {
    "label": "Ogle County",
    "value": "17133"
  },
  {
    "label": "Peoria County",
    "value": "17135"
  },
  {
    "label": "Perry County",
    "value": "17137"
  },
  {
    "label": "Piatt County",
    "value": "17139"
  },
  {
    "label": "Pike County",
    "value": "17141"
  },
  {
    "label": "Pope County",
    "value": "17143"
  },
  {
    "label": "Pulaski County",
    "value": "17145"
  },
  {
    "label": "Putnam County",
    "value": "17147"
  },
  {
    "label": "Randolph County",
    "value": "17149"
  },
  {
    "label": "Richland County",
    "value": "17151"
  },
  {
    "label": "Rock Island County",
    "value": "17153"
  },
  {
    "label": "Saline County",
    "value": "17155"
  },
  {
    "label": "Sangamon County",
    "value": "17157"
  },
  {
    "label": "Schuyler County",
    "value": "17159"
  },
  {
    "label": "Scott County",
    "value": "17161"
  },
  {
    "label": "Shelby County",
    "value": "17163"
  },
  {
    "label": "St. Clair County",
    "value": "17165"
  },
  {
    "label": "Stark County",
    "value": "17167"
  },
  {
    "label": "Stephenson County",
    "value": "17169"
  },
  {
    "label": "Tazewell County",
    "value": "17171"
  },
  {
    "label": "Union County",
    "value": "17173"
  },
  {
    "label": "Vermilion County",
    "value": "17175"
  },
  {
    "label": "Wabash County",
    "value": "17177"
  },
  {
    "label": "Warren County",
    "value": "17179"
  },
  {
    "label": "Washington County",
    "value": "17181"
  },
  {
    "label": "Wayne County",
    "value": "17183"
  },
  {
    "label": "White County",
    "value": "17185"
  },
  {
    "label": "Whiteside County",
    "value": "17187"
  },
  {
    "label": "Will County",
    "value": "17189"
  },
  {
    "label": "Williamson County",
    "value": "17191"
  },
  {
    "label": "Winnebago County",
    "value": "17193"
  },
  {
    "label": "Woodford County",
    "value": "17195"
  }
],
"in" : [
  {
    "label": "Adams County",
    "value": "18001"
  },
  {
    "label": "Allen County",
    "value": "18003"
  },
  {
    "label": "Bartholomew County",
    "value": "18005"
  },
  {
    "label": "Benton County",
    "value": "18007"
  },
  {
    "label": "Blackford County",
    "value": "18009"
  },
  {
    "label": "Boone County",
    "value": "18011"
  },
  {
    "label": "Brown County",
    "value": "18013"
  },
  {
    "label": "Carroll County",
    "value": "18015"
  },
  {
    "label": "Cass County",
    "value": "18017"
  },
  {
    "label": "Clark County",
    "value": "18019"
  },
  {
    "label": "Clay County",
    "value": "18021"
  },
  {
    "label": "Clinton County",
    "value": "18023"
  },
  {
    "label": "Crawford County",
    "value": "18025"
  },
  {
    "label": "Daviess County",
    "value": "18027"
  },
  {
    "label": "Dearborn County",
    "value": "18029"
  },
  {
    "label": "Decatur County",
    "value": "18031"
  },
  {
    "label": "DeKalb County",
    "value": "18033"
  },
  {
    "label": "Delaware County",
    "value": "18035"
  },
  {
    "label": "Dubois County",
    "value": "18037"
  },
  {
    "label": "Elkhart County",
    "value": "18039"
  },
  {
    "label": "Fayette County",
    "value": "18041"
  },
  {
    "label": "Floyd County",
    "value": "18043"
  },
  {
    "label": "Fountain County",
    "value": "18045"
  },
  {
    "label": "Franklin County",
    "value": "18047"
  },
  {
    "label": "Fulton County",
    "value": "18049"
  },
  {
    "label": "Gibson County",
    "value": "18051"
  },
  {
    "label": "Grant County",
    "value": "18053"
  },
  {
    "label": "Greene County",
    "value": "18055"
  },
  {
    "label": "Hamilton County",
    "value": "18057"
  },
  {
    "label": "Hancock County",
    "value": "18059"
  },
  {
    "label": "Harrison County",
    "value": "18061"
  },
  {
    "label": "Hendricks County",
    "value": "18063"
  },
  {
    "label": "Henry County",
    "value": "18065"
  },
  {
    "label": "Jackson County",
    "value": "18067"
  },
  {
    "label": "Jasper County",
    "value": "18069"
  },
  {
    "label": "Jay County",
    "value": "18071"
  },
  {
    "label": "Jefferson County",
    "value": "18073"
  },
  {
    "label": "Jennings County",
    "value": "18075"
  },
  {
    "label": "Johnson County",
    "value": "18077"
  },
  {
    "label": "Knox County",
    "value": "18079"
  },
  {
    "label": "Kosciusko County",
    "value": "18081"
  },
  {
    "label": "LaGrange County",
    "value": "18083"
  },
  {
    "label": "Lake County",
    "value": "18085"
  },
  {
    "label": "LaPorte County",
    "value": "18087"
  },
  {
    "label": "Lawrence County",
    "value": "18089"
  },
  {
    "label": "Madison County",
    "value": "18091"
  },
  {
    "label": "Marion County",
    "value": "18093"
  },
  {
    "label": "Marshall County",
    "value": "18095"
  },
  {
    "label": "Martin County",
    "value": "18097"
  },
  {
    "label": "Miami County",
    "value": "18099"
  },
  {
    "label": "Monroe County",
    "value": "18101"
  },
  {
    "label": "Montgomery County",
    "value": "18103"
  },
  {
    "label": "Morgan County",
    "value": "18105"
  },
  {
    "label": "Newton County",
    "value": "18107"
  },
  {
    "label": "Noble County",
    "value": "18109"
  },
  {
    "label": "Ohio County",
    "value": "18111"
  },
  {
    "label": "Orange County",
    "value": "18113"
  },
  {
    "label": "Owen County",
    "value": "18115"
  },
  {
    "label": "Parke County",
    "value": "18117"
  },
  {
    "label": "Perry County",
    "value": "18119"
  },
  {
    "label": "Posey County",
    "value": "18121"
  },
  {
    "label": "Pulaski County",
    "value": "18123"
  },
  {
    "label": "Putnam County",
    "value": "18125"
  },
  {
    "label": "Randolph County",
    "value": "18127"
  },
  {
    "label": "Ripley County",
    "value": "18129"
  },
  {
    "label": "Rush County",
    "value": "18131"
  },
  {
    "label": "St. Joseph County",
    "value": "18133"
  },
  {
    "label": "Starke County",
    "value": "18135"
  },
  {
    "label": "Steuben County",
    "value": "18137"
  },
  {
    "label": "Sullivan County",
    "value": "18139"
  },
  {
    "label": "Switzerland County",
    "value": "18141"
  },
  {
    "label": "Tippecanoe County",
    "value": "18143"
  },
  {
    "label": "Tipton County",
    "value": "18145"
  },
  {
    "label": "Union County",
    "value": "18147"
  },
  {
    "label": "Vanderburgh County",
    "value": "18149"
  },
  {
    "label": "Vermillion County",
    "value": "18151"
  },
  {
    "label": "Vigo County",
    "value": "18153"
  },
  {
    "label": "Wabash County",
    "value": "18155"
  },
  {
    "label": "Warren County",
    "value": "18157"
  },
  {
    "label": "Warrick County",
    "value": "18159"
  },
  {
    "label": "Washington County",
    "value": "18161"
  },
  {
    "label": "Wayne County",
    "value": "18163"
  },
  {
    "label": "Wells County",
    "value": "18165"
  },
  {
    "label": "White County",
    "value": "18167"
  },
  {
    "label": "Whitley County",
    "value": "18169"
  }
],
"ia" : [
  {
    "label": "Adair County",
    "value": "19001"
  },
  {
    "label": "Adams County",
    "value": "19003"
  },
  {
    "label": "Allamakee County",
    "value": "19005"
  },
  {
    "label": "Appanoose County",
    "value": "19007"
  },
  {
    "label": "Audubon County",
    "value": "19009"
  },
  {
    "label": "Benton County",
    "value": "19011"
  },
  {
    "label": "Black Hawk County",
    "value": "19013"
  },
  {
    "label": "Boone County",
    "value": "19015"
  },
  {
    "label": "Bremer County",
    "value": "19017"
  },
  {
    "label": "Buchanan County",
    "value": "19019"
  },
  {
    "label": "Buena Vista County",
    "value": "19021"
  },
  {
    "label": "Butler County",
    "value": "19023"
  },
  {
    "label": "Calhoun County",
    "value": "19025"
  },
  {
    "label": "Carroll County",
    "value": "19027"
  },
  {
    "label": "Cass County",
    "value": "19029"
  },
  {
    "label": "Cedar County",
    "value": "19031"
  },
  {
    "label": "Cerro Gordo County",
    "value": "19033"
  },
  {
    "label": "Cherokee County",
    "value": "19035"
  },
  {
    "label": "Chickasaw County",
    "value": "19037"
  },
  {
    "label": "Clarke County",
    "value": "19039"
  },
  {
    "label": "Clay County",
    "value": "19041"
  },
  {
    "label": "Clayton County",
    "value": "19043"
  },
  {
    "label": "Clinton County",
    "value": "19045"
  },
  {
    "label": "Crawford County",
    "value": "19047"
  },
  {
    "label": "Dallas County",
    "value": "19049"
  },
  {
    "label": "Davis County",
    "value": "19051"
  },
  {
    "label": "Decatur County",
    "value": "19053"
  },
  {
    "label": "Delaware County",
    "value": "19055"
  },
  {
    "label": "Des Moines County",
    "value": "19057"
  },
  {
    "label": "Dickinson County",
    "value": "19059"
  },
  {
    "label": "Dubuque County",
    "value": "19061"
  },
  {
    "label": "Emmet County",
    "value": "19063"
  },
  {
    "label": "Fayette County",
    "value": "19065"
  },
  {
    "label": "Floyd County",
    "value": "19067"
  },
  {
    "label": "Franklin County",
    "value": "19069"
  },
  {
    "label": "Fremont County",
    "value": "19071"
  },
  {
    "label": "Greene County",
    "value": "19073"
  },
  {
    "label": "Grundy County",
    "value": "19075"
  },
  {
    "label": "Guthrie County",
    "value": "19077"
  },
  {
    "label": "Hamilton County",
    "value": "19079"
  },
  {
    "label": "Hancock County",
    "value": "19081"
  },
  {
    "label": "Hardin County",
    "value": "19083"
  },
  {
    "label": "Harrison County",
    "value": "19085"
  },
  {
    "label": "Henry County",
    "value": "19087"
  },
  {
    "label": "Howard County",
    "value": "19089"
  },
  {
    "label": "Humboldt County",
    "value": "19091"
  },
  {
    "label": "Ida County",
    "value": "19093"
  },
  {
    "label": "Iowa County",
    "value": "19095"
  },
  {
    "label": "Jackson County",
    "value": "19097"
  },
  {
    "label": "Jasper County",
    "value": "19099"
  },
  {
    "label": "Jefferson County",
    "value": "19101"
  },
  {
    "label": "Johnson County",
    "value": "19103"
  },
  {
    "label": "Jones County",
    "value": "19105"
  },
  {
    "label": "Keokuk County",
    "value": "19107"
  },
  {
    "label": "Kossuth County",
    "value": "19109"
  },
  {
    "label": "Lee County",
    "value": "19111"
  },
  {
    "label": "Linn County",
    "value": "19113"
  },
  {
    "label": "Louisa County",
    "value": "19115"
  },
  {
    "label": "Lucas County",
    "value": "19117"
  },
  {
    "label": "Lyon County",
    "value": "19119"
  },
  {
    "label": "Madison County",
    "value": "19121"
  },
  {
    "label": "Mahaska County",
    "value": "19123"
  },
  {
    "label": "Marion County",
    "value": "19125"
  },
  {
    "label": "Marshall County",
    "value": "19127"
  },
  {
    "label": "Mills County",
    "value": "19129"
  },
  {
    "label": "Mitchell County",
    "value": "19131"
  },
  {
    "label": "Monona County",
    "value": "19133"
  },
  {
    "label": "Monroe County",
    "value": "19135"
  },
  {
    "label": "Montgomery County",
    "value": "19137"
  },
  {
    "label": "Muscatine County",
    "value": "19139"
  },
  {
    "label": "O'Brien County",
    "value": "19141"
  },
  {
    "label": "Osceola County",
    "value": "19143"
  },
  {
    "label": "Page County",
    "value": "19145"
  },
  {
    "label": "Palo Alto County",
    "value": "19147"
  },
  {
    "label": "Plymouth County",
    "value": "19149"
  },
  {
    "label": "Polk County",
    "value": "19151"
  },
  {
    "label": "Pottawattamie County",
    "value": "19153"
  },
  {
    "label": "Poweshiek County",
    "value": "19155"
  },
  {
    "label": "Ringgold County",
    "value": "19157"
  },
  {
    "label": "Sac County",
    "value": "19159"
  },
  {
    "label": "Scott County",
    "value": "19161"
  },
  {
    "label": "Shelby County",
    "value": "19163"
  },
  {
    "label": "Sioux County",
    "value": "19165"
  },
  {
    "label": "Story County",
    "value": "19167"
  },
  {
    "label": "Tama County",
    "value": "19169"
  },
  {
    "label": "Taylor County",
    "value": "19171"
  },
  {
    "label": "Union County",
    "value": "19173"
  },
  {
    "label": "Wapello County",
    "value": "19175"
  },
  {
    "label": "Warren County",
    "value": "19177"
  },
  {
    "label": "Washington County",
    "value": "19179"
  },
  {
    "label": "Wayne County",
    "value": "19181"
  },
  {
    "label": "Webster County",
    "value": "19183"
  },
  {
    "label": "Winnebago County",
    "value": "19185"
  },
  {
    "label": "Winneshiek County",
    "value": "19187"
  },
  {
    "label": "Woodbury County",
    "value": "19189"
  },
  {
    "label": "Worth County",
    "value": "19191"
  },
  {
    "label": "Wright County",
    "value": "19193"
  }
],
"ks" : [
  {
    "label": "Allen County",
    "value": "20001"
  },
  {
    "label": "Anderson County",
    "value": "20003"
  },
  {
    "label": "Atchison County",
    "value": "20005"
  },
  {
    "label": "Barber County",
    "value": "20007"
  },
  {
    "label": "Barton County",
    "value": "20009"
  },
  {
    "label": "Bourbon County",
    "value": "20011"
  },
  {
    "label": "Brown County",
    "value": "20013"
  },
  {
    "label": "Butler County",
    "value": "20015"
  },
  {
    "label": "Chase County",
    "value": "20017"
  },
  {
    "label": "Chautauqua County",
    "value": "20019"
  },
  {
    "label": "Cherokee County",
    "value": "20021"
  },
  {
    "label": "Cheyenne County",
    "value": "20023"
  },
  {
    "label": "Clark County",
    "value": "20025"
  },
  {
    "label": "Clay County",
    "value": "20027"
  },
  {
    "label": "Cloud County",
    "value": "20029"
  },
  {
    "label": "Coffey County",
    "value": "20031"
  },
  {
    "label": "Comanche County",
    "value": "20033"
  },
  {
    "label": "Cowley County",
    "value": "20035"
  },
  {
    "label": "Crawford County",
    "value": "20037"
  },
  {
    "label": "Decatur County",
    "value": "20039"
  },
  {
    "label": "Dickinson County",
    "value": "20041"
  },
  {
    "label": "Doniphan County",
    "value": "20043"
  },
  {
    "label": "Douglas County",
    "value": "20045"
  },
  {
    "label": "Edwards County",
    "value": "20047"
  },
  {
    "label": "Elk County",
    "value": "20049"
  },
  {
    "label": "Ellis County",
    "value": "20051"
  },
  {
    "label": "Ellsworth County",
    "value": "20053"
  },
  {
    "label": "Finney County",
    "value": "20055"
  },
  {
    "label": "Ford County",
    "value": "20057"
  },
  {
    "label": "Franklin County",
    "value": "20059"
  },
  {
    "label": "Geary County",
    "value": "20061"
  },
  {
    "label": "Gove County",
    "value": "20063"
  },
  {
    "label": "Graham County",
    "value": "20065"
  },
  {
    "label": "Grant County",
    "value": "20067"
  },
  {
    "label": "Gray County",
    "value": "20069"
  },
  {
    "label": "Greeley County",
    "value": "20071"
  },
  {
    "label": "Greenwood County",
    "value": "20073"
  },
  {
    "label": "Hamilton County",
    "value": "20075"
  },
  {
    "label": "Harper County",
    "value": "20077"
  },
  {
    "label": "Harrison County",
    "value": "20079"
  },
  {
    "label": "Jackson County",
    "value": "20081"
  },
  {
    "label": "Jefferson County",
    "value": "20083"
  },
  {
    "label": "Jewell County",
    "value": "20085"
  },
  {
    "label": "Johnson County",
    "value": "20087"
  },
  {
    "label": "Kearny County",
    "value": "20089"
  },
  {
    "label": "Kingman County",
    "value": "20091"
  },
  {
    "label": "Kiowa County",
    "value": "20093"
  },
  {
    "label": "Labette County",
    "value": "20095"
  },
  {
    "label": "Lane County",
    "value": "20097"
  },
  {
    "label": "Leavenworth County",
    "value": "20099"
  },
  {
    "label": "Lincoln County",
    "value": "20101"
  },
  {
    "label": "Linn County",
    "value": "20103"
  },
  {
    "label": "Logan County",
    "value": "20105"
  },
  {
    "label": "Lyon County",
    "value": "20107"
  },
  {
    "label": "Marion County",
    "value": "20109"
  },
  {
    "label": "Marshall County",
    "value": "20111"
  },
  {
    "label": "McPherson County",
    "value": "20113"
  },
  {
    "label": "Meade County",
    "value": "20115"
  },
  {
    "label": "Miami County",
    "value": "20117"
  },
  {
    "label": "Mitchell County",
    "value": "20119"
  },
  {
    "label": "Montgomery County",
    "value": "20121"
  },
  {
    "label": "Morris County",
    "value": "20123"
  },
  {
    "label": "Morton County",
    "value": "20125"
  },
  {
    "label": "Nemaha County",
    "value": "20127"
  },
  {
    "label": "Neosho County",
    "value": "20129"
  },
  {
    "label": "Ness County",
    "value": "20131"
  },
  {
    "label": "Norton County",
    "value": "20133"
  },
  {
    "label": "Osage County",
    "value": "20135"
  },
  {
    "label": "Osborne County",
    "value": "20137"
  },
  {
    "label": "Ottawa County",
    "value": "20139"
  },
  {
    "label": "Pawnee County",
    "value": "20141"
  },
  {
    "label": "Phillips County",
    "value": "20143"
  },
  {
    "label": "Pottawatomie County",
    "value": "20145"
  },
  {
    "label": "Pratt County",
    "value": "20147"
  },
  {
    "label": "Rawlins County",
    "value": "20149"
  },
  {
    "label": "Reno County",
    "value": "20151"
  },
  {
    "label": "Republic County",
    "value": "20153"
  },
  {
    "label": "Rice County",
    "value": "20155"
  },
  {
    "label": "Riley County",
    "value": "20157"
  },
  {
    "label": "Rooks County",
    "value": "20159"
  },
  {
    "label": "Rush County",
    "value": "20161"
  },
  {
    "label": "Russell County",
    "value": "20163"
  },
  {
    "label": "Saline County",
    "value": "20165"
  },
  {
    "label": "Scott County",
    "value": "20167"
  },
  {
    "label": "Sedgwick County",
    "value": "20169"
  },
  {
    "label": "Seward County",
    "value": "20171"
  },
  {
    "label": "Shawnee County",
    "value": "20173"
  },
  {
    "label": "Sheridan County",
    "value": "20175"
  },
  {
    "label": "Sherman County",
    "value": "20177"
  },
  {
    "label": "Smith County",
    "value": "20179"
  },
  {
    "label": "Stafford County",
    "value": "20181"
  },
  {
    "label": "Stanton County",
    "value": "20183"
  },
  {
    "label": "Stevens County",
    "value": "20185"
  },
  {
    "label": "Sumner County",
    "value": "20187"
  },
  {
    "label": "Thomas County",
    "value": "20189"
  },
  {
    "label": "Trego County",
    "value": "20191"
  },
  {
    "label": "Wabaunsee County",
    "value": "20193"
  },
  {
    "label": "Wallace County",
    "value": "20195"
  },
  {
    "label": "Washington County",
    "value": "20197"
  },
  {
    "label": "Wichita County",
    "value": "20199"
  },
  {
    "label": "Wilson County",
    "value": "20201"
  },
  {
    "label": "Woodson County",
    "value": "20203"
  },
  {
    "label": "Wyandotte County",
    "value": "20205"
  }
],
"ky" : [
  {
    "label": "Adair County",
    "value": "21001"
  },
  {
    "label": "Allen County",
    "value": "21003"
  },
  {
    "label": "Anderson County",
    "value": "21005"
  },
  {
    "label": "Bourbon County",
    "value": "21007"
  },
  {
    "label": "Boyd County",
    "value": "21009"
  },
  {
    "label": "Bracken County",
    "value": "21011"
  },
  {
    "label": "Breathitt County",
    "value": "21013"
  },
  {
    "label": "Campbell County",
    "value": "21015"
  },
  {
    "label": "Carter County",
    "value": "21017"
  },
  {
    "label": "Clark County",
    "value": "21019"
  },
  {
    "label": "Clay County",
    "value": "21021"
  },
  {
    "label": "Elliott County",
    "value": "21023"
  },
  {
    "label": "Estill County",
    "value": "21025"
  },
  {
    "label": "Fayette County",
    "value": "21027"
  },
  {
    "label": "Fleming County",
    "value": "21029"
  },
  {
    "label": "Floyd County",
    "value": "21031"
  },
  {
    "label": "Gallatin County",
    "value": "21033"
  },
  {
    "label": "Grant County",
    "value": "21035"
  },
  {
    "label": "Greenup County",
    "value": "21037"
  },
  {
    "label": "Harlan County",
    "value": "21039"
  },
  {
    "label": "Harrison County",
    "value": "21041"
  },
  {
    "label": "Jackson County",
    "value": "21043"
  },
  {
    "label": "Jessamine County",
    "value": "21045"
  },
  {
    "label": "Johnson County",
    "value": "21047"
  },
  {
    "label": "Kenton County",
    "value": "21049"
  },
  {
    "label": "Knott County",
    "value": "21051"
  },
  {
    "label": "Knox County",
    "value": "21053"
  },
  {
    "label": "Laurel County",
    "value": "21055"
  },
  {
    "label": "Lawrence County",
    "value": "21057"
  },
  {
    "label": "Lee County",
    "value": "21059"
  },
  {
    "label": "Leslie County",
    "value": "21061"
  },
  {
    "label": "Letcher County",
    "value": "21063"
  },
  {
    "label": "Lewis County",
    "value": "21065"
  },
  {
    "label": "Lincoln County",
    "value": "21067"
  },
  {
    "label": "Madison County",
    "value": "21069"
  },
  {
    "label": "Magoffin County",
    "value": "21071"
  },
  {
    "label": "Martin County",
    "value": "21073"
  },
  {
    "label": "Menifee County",
    "value": "21075"
  },
  {
    "label": "Morgan County",
    "value": "21077"
  },
  {
    "label": "Montgomery County",
    "value": "21079"
  },
  {
    "label": "Owsley County",
    "value": "21081"
  },
  {
    "label": "Pendleton County",
    "value": "21083"
  },
  {
    "label": "Perry County",
    "value": "21085"
  },
  {
    "label": "Powell County",
    "value": "21087"
  },
  {
    "label": "Robertson County",
    "value": "21089"
  },
  {
    "label": "Rockcastle County",
    "value": "21091"
  },
  {
    "label": "Rowan County",
    "value": "21093"
  },
  {
    "label": "Knox County",
    "value": "21095"
  },
  {
    "label": "Whitley County",
    "value": "21097"
  },
  {
    "label": "Wolfe County",
    "value": "21099"
  },
  {
    "label": "Woodford County",
    "value": "21101"
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
    $("#counties").on("change", function() {
        var selectedLabel = $("#counties option:selected").text();
        $("#county_name").val(selectedLabel);  // Store the selected county label in the hidden input
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