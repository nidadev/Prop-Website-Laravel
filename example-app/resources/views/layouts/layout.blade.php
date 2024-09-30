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
            "label": "Alachua",
            "value": "12001"
          },
          {
            "label": "Baker",
            "value": "12003"
          },
          {
            "label": "Bay",
            "value": "12005"
          },
          {
            "label": "Bradford",
            "value": "12007"
          },
          {
            "label": "Brevard",
            "value": "12009"
          },
          {
            "label": "Broward",
            "value": "12011"
          },
          {
            "label": "Calhoun",
            "value": "12013"
          },
          {
            "label": "Charlotte",
            "value": "12015"
          },
          {
            "label": "Citrus",
            "value": "12017"
          },
          {
            "label": "Clay",
            "value": "12019"
          },
          {
            "label": "Collier",
            "value": "12021"
          },
          {
            "label": "Columbia",
            "value": "12023"
          },
          {
            "label": "DeSoto",
            "value": "12027"
          },
          {
            "label": "Dixie",
            "value": "12029"
          },
          {
            "label": "Duval",
            "value": "12031"
          },
          {
            "label": "Escambia",
            "value": "12033"
          },
          {
            "label": "Flagler",
            "value": "12035"
          },
          {
            "label": "Franklin",
            "value": "12037"
          },
          {
            "label": "Gadsden",
            "value": "12039"
          },
          {
            "label": "Gilchrist",
            "value": "12041"
          },
          {
            "label": "Glades",
            "value": "12043"
          },
          {
            "label": "Gulf",
            "value": "12045"
          },
          {
            "label": "Hamilton",
            "value": "12047"
          },
          {
            "label": "Hardee",
            "value": "12049"
          },
          {
            "label": "Hendry",
            "value": "12051"
          },
          {
            "label": "Hernando",
            "value": "12053"
          },
          {
            "label": "Highlands",
            "value": "12055"
          },
          {
            "label": "Hillsborough",
            "value": "12057"
          },
          {
            "label": "Holmes",
            "value": "12059"
          },
          {
            "label": "Indian River",
            "value": "12061"
          },
          {
            "label": "Jackson",
            "value": "12063"
          },
          {
            "label": "Jefferson",
            "value": "12065"
          },
          {
            "label": "Lafayette",
            "value": "12067"
          },
          {
            "label": "Lake",
            "value": "12069"
          },
          {
            "label": "Lee",
            "value": "12071"
          },
          {
            "label": "Leon",
            "value": "12073"
          },
          {
            "label": "Levy",
            "value": "12075"
          },
          {
            "label": "Liberty",
            "value": "12077"
          },
          {
            "label": "Madison",
            "value": "12079"
          },
          {
            "label": "Manatee",
            "value": "12081"
          },
          {
            "label": "Marion",
            "value": "12083"
          },
          {
            "label": "Martin",
            "value": "12085"
          },
          {
            "label": "Miami-Dade",
            "value": "12086"
          },
          {
            "label": "Monroe",
            "value": "12087"
          },
          {
            "label": "Nassau",
            "value": "12089"
          },
          {
            "label": "Okaloosa",
            "value": "12091"
          },
          {
            "label": "Okeechobee",
            "value": "12093"
          },
          {
            "label": "Orange",
            "value": "12095"
          },
          {
            "label": "Osceola",
            "value": "12097"
          },
          {
            "label": "Palm Beach",
            "value": "12099"
          },
          {
            "label": "Pasco",
            "value": "12101"
          },
          {
            "label": "Pinellas",
            "value": "12103"
          },
          {
            "label": "Polk",
            "value": "12105"
          },
          {
            "label": "Putnam",
            "value": "12107"
          },
          {
            "label": "Santa Rosa",
            "value": "12113"
          },
          {
            "label": "Sarasota",
            "value": "12115"
          },
          {
            "label": "Seminole",
            "value": "12117"
          },
          {
            "label": "Sumter",
            "value": "12119"
          },
          {
            "label": "Taylor",
            "value": "12121"
          },
          {
            "label": "Union",
            "value": "12123"
          },
          {
            "label": "Volusia",
            "value": "12127"
          },
          {
            "label": "Wakulla",
            "value": "12129"
          },
          {
            "label": "Walton",
            "value": "12131"
          },
          {
            "label": "Washington",
            "value": "12133"
          }
        ],
        "co": [{
            "label": "Adams",
            "value": "08001"
          },
          {
            "label": "Alamosa",
            "value": "08003"
          },
          {
            "label": "Arapahoe",
            "value": "08005"
          },
          {
            "label": "Archuleta",
            "value": "08007"
          },
          {
            "label": "Baca",
            "value": "08009"
          },
          {
            "label": "Bent",
            "value": "08011"
          },
          {
            "label": "Boulder",
            "value": "08013"
          },
          {
            "label": "Chaffee",
            "value": "08015"
          },
          {
            "label": "Cheyenne",
            "value": "08017"
          },
          {
            "label": "Clear Creek",
            "value": "08019"
          },
          {
            "label": "Conejos",
            "value": "08021"
          },
          {
            "label": "Costilla",
            "value": "08023"
          },
          {
            "label": "Crowley",
            "value": "08025"
          },
          {
            "label": "Custer",
            "value": "08027"
          },
          {
            "label": "Delta",
            "value": "08029"
          },
          {
            "label": "Denver",
            "value": "08031"
          },
          {
            "label": "Dolores",
            "value": "08033"
          },
          {
            "label": "Douglas",
            "value": "08035"
          },
          {
            "label": "Eagle",
            "value": "08037"
          },
          {
            "label": "Elbert",
            "value": "08039"
          },
          {
            "label": "El Paso",
            "value": "08041"
          },
          {
            "label": "Fremont",
            "value": "08043"
          },
          {
            "label": "Garfield",
            "value": "08045"
          },
          {
            "label": "Gilpin",
            "value": "08047"
          },
          {
            "label": "Grand",
            "value": "08049"
          },
          {
            "label": "Gunnison",
            "value": "08051"
          },
          {
            "label": "Huerfano",
            "value": "08053"
          },
          {
            "label": "Jackson",
            "value": "08055"
          },
          {
            "label": "Jefferson",
            "value": "08057"
          },
          {
            "label": "Kiowa",
            "value": "08059"
          },
          {
            "label": "Kit Carson",
            "value": "08061"
          },
          {
            "label": "Lake",
            "value": "08063"
          },
          {
            "label": "La Plata",
            "value": "08065"
          },
          {
            "label": "Larimer",
            "value": "08067"
          },
          {
            "label": "Las Animas",
            "value": "08069"
          },
          {
            "label": "Lincoln",
            "value": "08071"
          },
          {
            "label": "Logan",
            "value": "08073"
          },
          {
            "label": "Mesa",
            "value": "08075"
          },
          {
            "label": "Mineral",
            "value": "08077"
          },
          {
            "label": "Moffat",
            "value": "08079"
          },
          {
            "label": "Montezuma",
            "value": "08081"
          },
          {
            "label": "Montrose",
            "value": "08083"
          },
          {
            "label": "Morgan",
            "value": "08085"
          },
          {
            "label": "Otero",
            "value": "08087"
          },
          {
            "label": "Ouray",
            "value": "08089"
          },
          {
            "label": "Park",
            "value": "08091"
          },
          {
            "label": "Phillips",
            "value": "08093"
          },
          {
            "label": "Pitkin",
            "value": "08095"
          },
          {
            "label": "Prowers",
            "value": "08097"
          },
          {
            "label": "Pueblo",
            "value": "08099"
          },
          {
            "label": "Rio Grande",
            "value": "08101"
          },
          {
            "label": "Routt",
            "value": "08103"
          },
          {
            "label": "Saguache",
            "value": "08105"
          },
          {
            "label": "San Juan",
            "value": "08107"
          },
          {
            "label": "San Miguel",
            "value": "08109"
          },
          {
            "label": "Sedgwick",
            "value": "08111"
          },
          {
            "label": "Summit",
            "value": "08113"
          },
          {
            "label": "Teller",
            "value": "08115"
          },
          {
            "label": "Washington",
            "value": "08117"
          },
          {
            "label": "Weld",
            "value": "08119"
          },
          {
            "label": "Yuma",
            "value": "08121"
          }
        ],
        "de":[
  {
    "label": "New Castle",
    "value": "10003"
  },
  {
    "label": "Kent",
    "value": "10001"
  },
  {
    "label": "Sussex",
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
    "label": "Appling",
    "value": "13001"
  },
  {
    "label": "Atkinson",
    "value": "13003"
  },
  {
    "label": "Bacon",
    "value": "13005"
  },
  {
    "label": "Baker",
    "value": "13007"
  },
  {
    "label": "Baldwin",
    "value": "13009"
  },
  {
    "label": "Banks",
    "value": "13011"
  },
  {
    "label": "Barrow",
    "value": "13013"
  },
  {
    "label": "Bartow",
    "value": "13015"
  },
  {
    "label": "Ben Hill",
    "value": "13017"
  },
  {
    "label": "Berrien",
    "value": "13019"
  },
  {
    "label": "Bibb",
    "value": "13021"
  },
  {
    "label": "Bleckley",
    "value": "13023"
  },
  {
    "label": "Brantley",
    "value": "13025"
  },
  {
    "label": "Brooks",
    "value": "13027"
  },
  {
    "label": "Bryan",
    "value": "13029"
  },
  {
    "label": "Bulloch",
    "value": "13031"
  },
  {
    "label": "Burke",
    "value": "13033"
  },
  {
    "label": "Butts",
    "value": "13035"
  },
  {
    "label": "Calhoun",
    "value": "13037"
  },
  {
    "label": "Camden",
    "value": "13039"
  },
  {
    "label": "Candler",
    "value": "13043"
  },
  {
    "label": "Carroll",
    "value": "13045"
  },
  {
    "label": "Catoosa",
    "value": "13047"
  },
  {
    "label": "Charlton",
    "value": "13049"
  },
  {
    "label": "Chatham",
    "value": "13051"
  },
  {
    "label": "Chattahoochee",
    "value": "13053"
  },
  {
    "label": "Cherokee",
    "value": "13057"
  },
  {
    "label": "Clarke",
    "value": "13059"
  },
  {
    "label": "Clay",
    "value": "13061"
  },
  {
    "label": "Clayton",
    "value": "13063"
  },
  {
    "label": "Clinch",
    "value": "13065"
  },
  {
    "label": "Cobb",
    "value": "13067"
  },
  {
    "label": "Coffee",
    "value": "13069"
  },
  {
    "label": "Colquitt",
    "value": "13071"
  },
  {
    "label": "Columbia",
    "value": "13073"
  },
  {
    "label": "Cook",
    "value": "13075"
  },
  {
    "label": "Coweta",
    "value": "13077"
  },
  {
    "label": "Crawford",
    "value": "13079"
  },
  {
    "label": "Crisp",
    "value": "13081"
  },
  {
    "label": "Dade",
    "value": "13083"
  },
  {
    "label": "Dawson",
    "value": "13085"
  },
  {
    "label": "DeKalb",
    "value": "13087"
  },
  {
    "label": "Decatur",
    "value": "13089"
  },
  {
    "label": "Dodge",
    "value": "13091"
  },
  {
    "label": "Dooly",
    "value": "13093"
  },
  {
    "label": "Dougherty",
    "value": "13095"
  },
  {
    "label": "Douglas",
    "value": "13097"
  },
  {
    "label": "Early",
    "value": "13099"
  },
  {
    "label": "Echols",
    "value": "13101"
  },
  {
    "label": "Effingham",
    "value": "13103"
  },
  {
    "label": "Elbert",
    "value": "13105"
  },
  {
    "label": "Emanuel",
    "value": "13107"
  },
  {
    "label": "Evans",
    "value": "13109"
  },
  {
    "label": "Fannin",
    "value": "13111"
  },
  {
    "label": "Fayette",
    "value": "13113"
  },
  {
    "label": "Floyd",
    "value": "13115"
  },
  {
    "label": "Forsyth",
    "value": "13117"
  },
  {
    "label": "Franklin",
    "value": "13119"
  },
  {
    "label": "Fulton",
    "value": "13121"
  },
  {
    "label": "Gilmer",
    "value": "13123"
  },
  {
    "label": "Glascock",
    "value": "13125"
  },
  {
    "label": "Glynn",
    "value": "13127"
  },
  {
    "label": "Gordon",
    "value": "13129"
  },
  {
    "label": "Grady",
    "value": "13131"
  },
  {
    "label": "Greene",
    "value": "13133"
  },
  {
    "label": "Gwinnett",
    "value": "13135"
  },
  {
    "label": "Habersham",
    "value": "13137"
  },
  {
    "label": "Hall",
    "value": "13139"
  },
  {
    "label": "Hancock",
    "value": "13141"
  },
  {
    "label": "Haralson",
    "value": "13143"
  },
  {
    "label": "Harris",
    "value": "13145"
  },
  {
    "label": "Hart",
    "value": "13147"
  },
  {
    "label": "Heard",
    "value": "13149"
  },
  {
    "label": "Henry",
    "value": "13151"
  },
  {
    "label": "Houston",
    "value": "13153"
  },
  {
    "label": "Irwin",
    "value": "13155"
  },
  {
    "label": "Jackson",
    "value": "13157"
  },
  {
    "label": "Jasper",
    "value": "13159"
  },
  {
    "label": "Jeff Davis",
    "value": "13161"
  },
  {
    "label": "Jefferson",
    "value": "13163"
  },
  {
    "label": "Jenkins",
    "value": "13165"
  },
  {
    "label": "Johnson",
    "value": "13167"
  },
  {
    "label": "Jones",
    "value": "13169"
  },
  {
    "label": "Lamar",
    "value": "13171"
  },
  {
    "label": "Lanier",
    "value": "13173"
  },
  {
    "label": "Laurens",
    "value": "13175"
  },
  {
    "label": "Lee",
    "value": "13177"
  },
  {
    "label": "Liberty",
    "value": "13179"
  },
  {
    "label": "Lincoln",
    "value": "13181"
  },
  {
    "label": "Long",
    "value": "13183"
  },
  {
    "label": "Lowndes",
    "value": "13185"
  },
  {
    "label": "Lumpkin",
    "value": "13187"
  },
  {
    "label": "McDuffie",
    "value": "13189"
  },
  {
    "label": "McIntosh",
    "value": "13191"
  },
  {
    "label": "Macon",
    "value": "13193"
  },
  {
    "label": "Madison",
    "value": "13195"
  },
  {
    "label": "Marion",
    "value": "13197"
  },
  {
    "label": "Meriwether",
    "value": "13199"
  },
  {
    "label": "Miller",
    "value": "13201"
  },
  {
    "label": "Mitchell",
    "value": "13205"
  },
  {
    "label": "Monroe",
    "value": "13207"
  },
  {
    "label": "Montgomery",
    "value": "13209"
  },
  {
    "label": "Morgan",
    "value": "13211"
  },
  {
    "label": "Murray",
    "value": "13213"
  },
  {
    "label": "Muscogee",
    "value": "13215"
  },
  {
    "label": "Newton",
    "value": "13217"
  },
  {
    "label": "Oconee",
    "value": "13219"
  },
  {
    "label": "Oglethorpe",
    "value": "13221"
  },
  {
    "label": "Paulding",
    "value": "13223"
  },
  {
    "label": "Peach",
    "value": "13225"
  },
  {
    "label": "Pickens",
    "value": "13227"
  },
  {
    "label": "Pierce",
    "value": "13229"
  },
  {
    "label": "Pike",
    "value": "13231"
  },
  {
    "label": "Polk",
    "value": "13233"
  },
  {
    "label": "Pulaski",
    "value": "13235"
  },
  {
    "label": "Putnam",
    "value": "13237"
  },
  {
    "label": "Quitman",
    "value": "13239"
  },
  {
    "label": "Rabun",
    "value": "13241"
  },
  {
    "label": "Randolph",
    "value": "13243"
  },
  {
    "label": "Richmond",
    "value": "13245"
  },
  {
    "label": "Rockdale",
    "value": "13247"
  },
  {
    "label": "Schley",
    "value": "13249"
  },
  {
    "label": "Seminole",
    "value": "13251"
  },
  {
    "label": "Spalding",
    "value": "13253"
  },
  {
    "label": "Stephens",
    "value": "13255"
  },
  {
    "label": "Stewart",
    "value": "13257"
  },
  {
    "label": "Sumter",
    "value": "13259"
  },
  {
    "label": "Talbot",
    "value": "13261"
  },
  {
    "label": "Taliaferro",
    "value": "13263"
  },
  {
    "label": "Tattnall",
    "value": "13265"
  },
  {
    "label": "Taylor",
    "value": "13267"
  },
  {
    "label": "Terrell",
    "value": "13269"
  },
  {
    "label": "Thomas",
    "value": "13271"
  },
  {
    "label": "Tift",
    "value": "13273"
  },
  {
    "label": "Toombs",
    "value": "13275"
  },
  {
    "label": "Towns",
    "value": "13277"
  },
  {
    "label": "Treutlen",
    "value": "13279"
  },
  {
    "label": "Troup",
    "value": "13281"
  },
  {
    "label": "Turner",
    "value": "13283"
  },
  {
    "label": "Twiggs",
    "value": "13285"
  },
  {
    "label": "Union",
    "value": "13287"
  },
  {
    "label": "Upson",
    "value": "13289"
  },
  {
    "label": "Walker",
    "value": "13291"
  },
  {
    "label": "Walton",
    "value": "13293"
  },
  {
    "label": "Ware",
    "value": "13295"
  },
  {
    "label": "Warren",
    "value": "13297"
  },
  {
    "label": "Washington",
    "value": "13299"
  },
  {
    "label": "Wayne",
    "value": "13301"
  },
  {
    "label": "Webster",
    "value": "13303"
  },
  {
    "label": "Wheeler",
    "value": "13305"
  },
  {
    "label": "White",
    "value": "13307"
  },
  {
    "label": "Whitfield",
    "value": "13309"
  },
  {
    "label": "Wilcox",
    "value": "13311"
  },
  {
    "label": "Wilkes",
    "value": "13313"
  },
  {
    "label": "Williamson",
    "value": "13315"
  },
  {
    "label": "Worth",
    "value": "13317"
  }
],
"hi":[
  {
    "label": "Hawaii",
    "value": "15001"
  },
  {
    "label": "Honolulu",
    "value": "15003"
  },
  {
    "label": "Kalawao",
    "value": "15005"
  },
  {
    "label": "Kauai",
    "value": "15007"
  },
  {
    "label": "Maui",
    "value": "15009"
  }
],
"id" : [
  {
    "label": "Ada",
    "value": "16001"
  },
  {
    "label": "Adams",
    "value": "16003"
  },
  {
    "label": "Bannock",
    "value": "16005"
  },
  {
    "label": "Bear Lake",
    "value": "16007"
  },
  {
    "label": "Benewah",
    "value": "16009"
  },
  {
    "label": "Bingham",
    "value": "16011"
  },
  {
    "label": "Blaine",
    "value": "16013"
  },
  {
    "label": "Boise",
    "value": "16015"
  },
  {
    "label": "Bonner",
    "value": "16017"
  },
  {
    "label": "Bonners Ferry",
    "value": "16019"
  },
  {
    "label": "Boundary",
    "value": "16021"
  },
  {
    "label": "Butte",
    "value": "16023"
  },
  {
    "label": "Camas",
    "value": "16025"
  },
  {
    "label": "Canyon",
    "value": "16027"
  },
  {
    "label": "Caribou",
    "value": "16029"
  },
  {
    "label": "Cassia",
    "value": "16031"
  },
  {
    "label": "Clark",
    "value": "16033"
  },
  {
    "label": "Clearwater",
    "value": "16035"
  },
  {
    "label": "Custer",
    "value": "16037"
  },
  {
    "label": "Elmore",
    "value": "16039"
  },
  {
    "label": "Franklin",
    "value": "16041"
  },
  {
    "label": "Fremont",
    "value": "16043"
  },
  {
    "label": "Gem",
    "value": "16045"
  },
  {
    "label": "Gooding",
    "value": "16047"
  },
  {
    "label": "Idaho",
    "value": "16049"
  },
  {
    "label": "Jefferson",
    "value": "16051"
  },
  {
    "label": "Jerome",
    "value": "16053"
  },
  {
    "label": "Kootenai",
    "value": "16055"
  },
  {
    "label": "Latah",
    "value": "16057"
  },
  {
    "label": "Lemhi",
    "value": "16059"
  },
  {
    "label": "Lewis",
    "value": "16061"
  },
  {
    "label": "Lincoln",
    "value": "16063"
  },
  {
    "label": "Madison",
    "value": "16065"
  },
  {
    "label": "Minidoka",
    "value": "16067"
  },
  {
    "label": "Nez Perce",
    "value": "16069"
  },
  {
    "label": "Owyhee",
    "value": "16071"
  },
  {
    "label": "Payette",
    "value": "16073"
  },
  {
    "label": "Power",
    "value": "16075"
  },
  {
    "label": "Shoshone",
    "value": "16077"
  },
  {
    "label": "Teton",
    "value": "16079"
  },
  {
    "label": "Twin Falls",
    "value": "16081"
  },
  {
    "label": "Valley",
    "value": "16083"
  },
  {
    "label": "Washington",
    "value": "16085"
  }
],
"il" : [
  {
    "label": "Adams",
    "value": "17001"
  },
  {
    "label": "Bond",
    "value": "17003"
  },
  {
    "label": "Boone",
    "value": "17005"
  },
  {
    "label": "Brown",
    "value": "17007"
  },
  {
    "label": "Bureau",
    "value": "17009"
  },
  {
    "label": "Calhoun",
    "value": "17011"
  },
  {
    "label": "Carroll",
    "value": "17013"
  },
  {
    "label": "Cass",
    "value": "17015"
  },
  {
    "label": "Champaign",
    "value": "17017"
  },
  {
    "label": "Christian",
    "value": "17019"
  },
  {
    "label": "Clark",
    "value": "17021"
  },
  {
    "label": "Clay",
    "value": "17023"
  },
  {
    "label": "Clinton",
    "value": "17025"
  },
  {
    "label": "Coles",
    "value": "17027"
  },
  {
    "label": "Cook",
    "value": "17031"
  },
  {
    "label": "Crawford",
    "value": "17033"
  },
  {
    "label": "Cumberland",
    "value": "17035"
  },
  {
    "label": "DeKalb",
    "value": "17037"
  },
  {
    "label": "Douglas",
    "value": "17039"
  },
  {
    "label": "DuPage",
    "value": "17043"
  },
  {
    "label": "Edgar",
    "value": "17045"
  },
  {
    "label": "Edwards",
    "value": "17047"
  },
  {
    "label": "Effingham",
    "value": "17049"
  },
  {
    "label": "Fayette",
    "value": "17051"
  },
  {
    "label": "Ford",
    "value": "17053"
  },
  {
    "label": "Franklin",
    "value": "17055"
  },
  {
    "label": "Fulton",
    "value": "17057"
  },
  {
    "label": "Gallatin",
    "value": "17059"
  },
  {
    "label": "Greene",
    "value": "17061"
  },
  {
    "label": "Grundy",
    "value": "17063"
  },
  {
    "label": "Hamilton",
    "value": "17065"
  },
  {
    "label": "Hancock",
    "value": "17067"
  },
  {
    "label": "Hardin",
    "value": "17069"
  },
  {
    "label": "Henderson",
    "value": "17071"
  },
  {
    "label": "Henry",
    "value": "17073"
  },
  {
    "label": "Iroquois",
    "value": "17075"
  },
  {
    "label": "Jackson",
    "value": "17077"
  },
  {
    "label": "Jasper",
    "value": "17079"
  },
  {
    "label": "Jefferson",
    "value": "17081"
  },
  {
    "label": "Jersey",
    "value": "17083"
  },
  {
    "label": "Jo Daviess",
    "value": "17085"
  },
  {
    "label": "Johnson",
    "value": "17087"
  },
  {
    "label": "Kane",
    "value": "17089"
  },
  {
    "label": "Kankakee",
    "value": "17091"
  },
  {
    "label": "Kendall",
    "value": "17093"
  },
  {
    "label": "Knox",
    "value": "17095"
  },
  {
    "label": "LaSalle",
    "value": "17097"
  },
  {
    "label": "Lake",
    "value": "17099"
  },
  {
    "label": "Lawrence",
    "value": "17101"
  },
  {
    "label": "Lee",
    "value": "17103"
  },
  {
    "label": "Livingston",
    "value": "17105"
  },
  {
    "label": "Logan",
    "value": "17107"
  },
  {
    "label": "Macoupin",
    "value": "17109"
  },
  {
    "label": "Madison",
    "value": "17111"
  },
  {
    "label": "Marion",
    "value": "17113"
  },
  {
    "label": "Marshall",
    "value": "17115"
  },
  {
    "label": "Mason",
    "value": "17117"
  },
  {
    "label": "Massac",
    "value": "17119"
  },
  {
    "label": "Menard",
    "value": "17121"
  },
  {
    "label": "Mercer",
    "value": "17123"
  },
  {
    "label": "Monroe",
    "value": "17125"
  },
  {
    "label": "Montgomery",
    "value": "17127"
  },
  {
    "label": "Morgan",
    "value": "17129"
  },
  {
    "label": "Moultrie",
    "value": "17131"
  },
  {
    "label": "Ogle",
    "value": "17133"
  },
  {
    "label": "Peoria",
    "value": "17135"
  },
  {
    "label": "Perry",
    "value": "17137"
  },
  {
    "label": "Piatt",
    "value": "17139"
  },
  {
    "label": "Pike",
    "value": "17141"
  },
  {
    "label": "Pope",
    "value": "17143"
  },
  {
    "label": "Pulaski",
    "value": "17145"
  },
  {
    "label": "Putnam",
    "value": "17147"
  },
  {
    "label": "Randolph",
    "value": "17149"
  },
  {
    "label": "Richland",
    "value": "17151"
  },
  {
    "label": "Rock Island",
    "value": "17153"
  },
  {
    "label": "Saline",
    "value": "17155"
  },
  {
    "label": "Sangamon",
    "value": "17157"
  },
  {
    "label": "Schuyler",
    "value": "17159"
  },
  {
    "label": "Scott",
    "value": "17161"
  },
  {
    "label": "Shelby",
    "value": "17163"
  },
  {
    "label": "St. Clair",
    "value": "17165"
  },
  {
    "label": "Stark",
    "value": "17167"
  },
  {
    "label": "Stephenson",
    "value": "17169"
  },
  {
    "label": "Tazewell",
    "value": "17171"
  },
  {
    "label": "Union",
    "value": "17173"
  },
  {
    "label": "Vermilion",
    "value": "17175"
  },
  {
    "label": "Wabash",
    "value": "17177"
  },
  {
    "label": "Warren",
    "value": "17179"
  },
  {
    "label": "Washington",
    "value": "17181"
  },
  {
    "label": "Wayne",
    "value": "17183"
  },
  {
    "label": "White",
    "value": "17185"
  },
  {
    "label": "Whiteside",
    "value": "17187"
  },
  {
    "label": "Will",
    "value": "17189"
  },
  {
    "label": "Williamson",
    "value": "17191"
  },
  {
    "label": "Winnebago",
    "value": "17193"
  },
  {
    "label": "Woodford",
    "value": "17195"
  }
],
"in" : [
  {
    "label": "Adams",
    "value": "18001"
  },
  {
    "label": "Allen",
    "value": "18003"
  },
  {
    "label": "Bartholomew",
    "value": "18005"
  },
  {
    "label": "Benton",
    "value": "18007"
  },
  {
    "label": "Blackford",
    "value": "18009"
  },
  {
    "label": "Boone",
    "value": "18011"
  },
  {
    "label": "Brown",
    "value": "18013"
  },
  {
    "label": "Carroll",
    "value": "18015"
  },
  {
    "label": "Cass",
    "value": "18017"
  },
  {
    "label": "Clark",
    "value": "18019"
  },
  {
    "label": "Clay",
    "value": "18021"
  },
  {
    "label": "Clinton",
    "value": "18023"
  },
  {
    "label": "Crawford",
    "value": "18025"
  },
  {
    "label": "Daviess",
    "value": "18027"
  },
  {
    "label": "Dearborn",
    "value": "18029"
  },
  {
    "label": "Decatur",
    "value": "18031"
  },
  {
    "label": "DeKalb",
    "value": "18033"
  },
  {
    "label": "Delaware",
    "value": "18035"
  },
  {
    "label": "Dubois",
    "value": "18037"
  },
  {
    "label": "Elkhart",
    "value": "18039"
  },
  {
    "label": "Fayette",
    "value": "18041"
  },
  {
    "label": "Floyd",
    "value": "18043"
  },
  {
    "label": "Fountain",
    "value": "18045"
  },
  {
    "label": "Franklin",
    "value": "18047"
  },
  {
    "label": "Fulton",
    "value": "18049"
  },
  {
    "label": "Gibson",
    "value": "18051"
  },
  {
    "label": "Grant",
    "value": "18053"
  },
  {
    "label": "Greene",
    "value": "18055"
  },
  {
    "label": "Hamilton",
    "value": "18057"
  },
  {
    "label": "Hancock",
    "value": "18059"
  },
  {
    "label": "Harrison",
    "value": "18061"
  },
  {
    "label": "Hendricks",
    "value": "18063"
  },
  {
    "label": "Henry",
    "value": "18065"
  },
  {
    "label": "Jackson",
    "value": "18067"
  },
  {
    "label": "Jasper",
    "value": "18069"
  },
  {
    "label": "Jay",
    "value": "18071"
  },
  {
    "label": "Jefferson",
    "value": "18073"
  },
  {
    "label": "Jennings",
    "value": "18075"
  },
  {
    "label": "Johnson",
    "value": "18077"
  },
  {
    "label": "Knox",
    "value": "18079"
  },
  {
    "label": "Kosciusko",
    "value": "18081"
  },
  {
    "label": "LaGrange",
    "value": "18083"
  },
  {
    "label": "Lake",
    "value": "18085"
  },
  {
    "label": "LaPorte",
    "value": "18087"
  },
  {
    "label": "Lawrence",
    "value": "18089"
  },
  {
    "label": "Madison",
    "value": "18091"
  },
  {
    "label": "Marion",
    "value": "18093"
  },
  {
    "label": "Marshall",
    "value": "18095"
  },
  {
    "label": "Martin",
    "value": "18097"
  },
  {
    "label": "Miami",
    "value": "18099"
  },
  {
    "label": "Monroe",
    "value": "18101"
  },
  {
    "label": "Montgomery",
    "value": "18103"
  },
  {
    "label": "Morgan",
    "value": "18105"
  },
  {
    "label": "Newton",
    "value": "18107"
  },
  {
    "label": "Noble",
    "value": "18109"
  },
  {
    "label": "Ohio",
    "value": "18111"
  },
  {
    "label": "Orange",
    "value": "18113"
  },
  {
    "label": "Owen",
    "value": "18115"
  },
  {
    "label": "Parke",
    "value": "18117"
  },
  {
    "label": "Perry",
    "value": "18119"
  },
  {
    "label": "Posey",
    "value": "18121"
  },
  {
    "label": "Pulaski",
    "value": "18123"
  },
  {
    "label": "Putnam",
    "value": "18125"
  },
  {
    "label": "Randolph",
    "value": "18127"
  },
  {
    "label": "Ripley",
    "value": "18129"
  },
  {
    "label": "Rush",
    "value": "18131"
  },
  {
    "label": "St. Joseph",
    "value": "18133"
  },
  {
    "label": "Starke",
    "value": "18135"
  },
  {
    "label": "Steuben",
    "value": "18137"
  },
  {
    "label": "Sullivan",
    "value": "18139"
  },
  {
    "label": "Switzerland",
    "value": "18141"
  },
  {
    "label": "Tippecanoe",
    "value": "18143"
  },
  {
    "label": "Tipton",
    "value": "18145"
  },
  {
    "label": "Union",
    "value": "18147"
  },
  {
    "label": "Vanderburgh",
    "value": "18149"
  },
  {
    "label": "Vermillion",
    "value": "18151"
  },
  {
    "label": "Vigo",
    "value": "18153"
  },
  {
    "label": "Wabash",
    "value": "18155"
  },
  {
    "label": "Warren",
    "value": "18157"
  },
  {
    "label": "Warrick",
    "value": "18159"
  },
  {
    "label": "Washington",
    "value": "18161"
  },
  {
    "label": "Wayne",
    "value": "18163"
  },
  {
    "label": "Wells",
    "value": "18165"
  },
  {
    "label": "White",
    "value": "18167"
  },
  {
    "label": "Whitley",
    "value": "18169"
  }
],
"ia" : [
  {
    "label": "Adair",
    "value": "19001"
  },
  {
    "label": "Adams",
    "value": "19003"
  },
  {
    "label": "Allamakee",
    "value": "19005"
  },
  {
    "label": "Appanoose",
    "value": "19007"
  },
  {
    "label": "Audubon",
    "value": "19009"
  },
  {
    "label": "Benton",
    "value": "19011"
  },
  {
    "label": "Black Hawk",
    "value": "19013"
  },
  {
    "label": "Boone",
    "value": "19015"
  },
  {
    "label": "Bremer",
    "value": "19017"
  },
  {
    "label": "Buchanan",
    "value": "19019"
  },
  {
    "label": "Buena Vista",
    "value": "19021"
  },
  {
    "label": "Butler",
    "value": "19023"
  },
  {
    "label": "Calhoun",
    "value": "19025"
  },
  {
    "label": "Carroll",
    "value": "19027"
  },
  {
    "label": "Cass",
    "value": "19029"
  },
  {
    "label": "Cedar",
    "value": "19031"
  },
  {
    "label": "Cerro Gordo",
    "value": "19033"
  },
  {
    "label": "Cherokee",
    "value": "19035"
  },
  {
    "label": "Chickasaw",
    "value": "19037"
  },
  {
    "label": "Clarke",
    "value": "19039"
  },
  {
    "label": "Clay",
    "value": "19041"
  },
  {
    "label": "Clayton",
    "value": "19043"
  },
  {
    "label": "Clinton",
    "value": "19045"
  },
  {
    "label": "Crawford",
    "value": "19047"
  },
  {
    "label": "Dallas",
    "value": "19049"
  },
  {
    "label": "Davis",
    "value": "19051"
  },
  {
    "label": "Decatur",
    "value": "19053"
  },
  {
    "label": "Delaware",
    "value": "19055"
  },
  {
    "label": "Des Moines",
    "value": "19057"
  },
  {
    "label": "Dickinson",
    "value": "19059"
  },
  {
    "label": "Dubuque",
    "value": "19061"
  },
  {
    "label": "Emmet",
    "value": "19063"
  },
  {
    "label": "Fayette",
    "value": "19065"
  },
  {
    "label": "Floyd",
    "value": "19067"
  },
  {
    "label": "Franklin",
    "value": "19069"
  },
  {
    "label": "Fremont",
    "value": "19071"
  },
  {
    "label": "Greene",
    "value": "19073"
  },
  {
    "label": "Grundy",
    "value": "19075"
  },
  {
    "label": "Guthrie",
    "value": "19077"
  },
  {
    "label": "Hamilton",
    "value": "19079"
  },
  {
    "label": "Hancock",
    "value": "19081"
  },
  {
    "label": "Hardin",
    "value": "19083"
  },
  {
    "label": "Harrison",
    "value": "19085"
  },
  {
    "label": "Henry",
    "value": "19087"
  },
  {
    "label": "Howard",
    "value": "19089"
  },
  {
    "label": "Humboldt",
    "value": "19091"
  },
  {
    "label": "Ida",
    "value": "19093"
  },
  {
    "label": "Iowa",
    "value": "19095"
  },
  {
    "label": "Jackson",
    "value": "19097"
  },
  {
    "label": "Jasper",
    "value": "19099"
  },
  {
    "label": "Jefferson",
    "value": "19101"
  },
  {
    "label": "Johnson",
    "value": "19103"
  },
  {
    "label": "Jones",
    "value": "19105"
  },
  {
    "label": "Keokuk",
    "value": "19107"
  },
  {
    "label": "Kossuth",
    "value": "19109"
  },
  {
    "label": "Lee",
    "value": "19111"
  },
  {
    "label": "Linn",
    "value": "19113"
  },
  {
    "label": "Louisa",
    "value": "19115"
  },
  {
    "label": "Lucas",
    "value": "19117"
  },
  {
    "label": "Lyon",
    "value": "19119"
  },
  {
    "label": "Madison",
    "value": "19121"
  },
  {
    "label": "Mahaska",
    "value": "19123"
  },
  {
    "label": "Marion",
    "value": "19125"
  },
  {
    "label": "Marshall",
    "value": "19127"
  },
  {
    "label": "Mills",
    "value": "19129"
  },
  {
    "label": "Mitchell",
    "value": "19131"
  },
  {
    "label": "Monona",
    "value": "19133"
  },
  {
    "label": "Monroe",
    "value": "19135"
  },
  {
    "label": "Montgomery",
    "value": "19137"
  },
  {
    "label": "Muscatine",
    "value": "19139"
  },
  {
    "label": "O'Brien",
    "value": "19141"
  },
  {
    "label": "Osceola",
    "value": "19143"
  },
  {
    "label": "Page",
    "value": "19145"
  },
  {
    "label": "Palo Alto",
    "value": "19147"
  },
  {
    "label": "Plymouth",
    "value": "19149"
  },
  {
    "label": "Polk",
    "value": "19151"
  },
  {
    "label": "Pottawattamie",
    "value": "19153"
  },
  {
    "label": "Poweshiek",
    "value": "19155"
  },
  {
    "label": "Ringgold",
    "value": "19157"
  },
  {
    "label": "Sac",
    "value": "19159"
  },
  {
    "label": "Scott",
    "value": "19161"
  },
  {
    "label": "Shelby",
    "value": "19163"
  },
  {
    "label": "Sioux",
    "value": "19165"
  },
  {
    "label": "Story",
    "value": "19167"
  },
  {
    "label": "Tama",
    "value": "19169"
  },
  {
    "label": "Taylor",
    "value": "19171"
  },
  {
    "label": "Union",
    "value": "19173"
  },
  {
    "label": "Wapello",
    "value": "19175"
  },
  {
    "label": "Warren",
    "value": "19177"
  },
  {
    "label": "Washington",
    "value": "19179"
  },
  {
    "label": "Wayne",
    "value": "19181"
  },
  {
    "label": "Webster",
    "value": "19183"
  },
  {
    "label": "Winnebago",
    "value": "19185"
  },
  {
    "label": "Winneshiek",
    "value": "19187"
  },
  {
    "label": "Woodbury",
    "value": "19189"
  },
  {
    "label": "Worth",
    "value": "19191"
  },
  {
    "label": "Wright",
    "value": "19193"
  }
],
"ks" : [
  {
    "label": "Allen",
    "value": "20001"
  },
  {
    "label": "Anderson",
    "value": "20003"
  },
  {
    "label": "Atchison",
    "value": "20005"
  },
  {
    "label": "Barber",
    "value": "20007"
  },
  {
    "label": "Barton",
    "value": "20009"
  },
  {
    "label": "Bourbon",
    "value": "20011"
  },
  {
    "label": "Brown",
    "value": "20013"
  },
  {
    "label": "Butler",
    "value": "20015"
  },
  {
    "label": "Chase",
    "value": "20017"
  },
  {
    "label": "Chautauqua",
    "value": "20019"
  },
  {
    "label": "Cherokee",
    "value": "20021"
  },
  {
    "label": "Cheyenne",
    "value": "20023"
  },
  {
    "label": "Clark",
    "value": "20025"
  },
  {
    "label": "Clay",
    "value": "20027"
  },
  {
    "label": "Cloud",
    "value": "20029"
  },
  {
    "label": "Coffey",
    "value": "20031"
  },
  {
    "label": "Comanche",
    "value": "20033"
  },
  {
    "label": "Cowley",
    "value": "20035"
  },
  {
    "label": "Crawford",
    "value": "20037"
  },
  {
    "label": "Decatur",
    "value": "20039"
  },
  {
    "label": "Dickinson",
    "value": "20041"
  },
  {
    "label": "Doniphan",
    "value": "20043"
  },
  {
    "label": "Douglas",
    "value": "20045"
  },
  {
    "label": "Edwards",
    "value": "20047"
  },
  {
    "label": "Elk",
    "value": "20049"
  },
  {
    "label": "Ellis",
    "value": "20051"
  },
  {
    "label": "Ellsworth",
    "value": "20053"
  },
  {
    "label": "Finney",
    "value": "20055"
  },
  {
    "label": "Ford",
    "value": "20057"
  },
  {
    "label": "Franklin",
    "value": "20059"
  },
  {
    "label": "Geary",
    "value": "20061"
  },
  {
    "label": "Gove",
    "value": "20063"
  },
  {
    "label": "Graham",
    "value": "20065"
  },
  {
    "label": "Grant",
    "value": "20067"
  },
  {
    "label": "Gray",
    "value": "20069"
  },
  {
    "label": "Greeley",
    "value": "20071"
  },
  {
    "label": "Greenwood",
    "value": "20073"
  },
  {
    "label": "Hamilton",
    "value": "20075"
  },
  {
    "label": "Harper",
    "value": "20077"
  },
  {
    "label": "Harrison",
    "value": "20079"
  },
  {
    "label": "Jackson",
    "value": "20081"
  },
  {
    "label": "Jefferson",
    "value": "20083"
  },
  {
    "label": "Jewell",
    "value": "20085"
  },
  {
    "label": "Johnson",
    "value": "20087"
  },
  {
    "label": "Kearny",
    "value": "20089"
  },
  {
    "label": "Kingman",
    "value": "20091"
  },
  {
    "label": "Kiowa",
    "value": "20093"
  },
  {
    "label": "Labette",
    "value": "20095"
  },
  {
    "label": "Lane",
    "value": "20097"
  },
  {
    "label": "Leavenworth",
    "value": "20099"
  },
  {
    "label": "Lincoln",
    "value": "20101"
  },
  {
    "label": "Linn",
    "value": "20103"
  },
  {
    "label": "Logan",
    "value": "20105"
  },
  {
    "label": "Lyon",
    "value": "20107"
  },
  {
    "label": "Marion",
    "value": "20109"
  },
  {
    "label": "Marshall",
    "value": "20111"
  },
  {
    "label": "McPherson",
    "value": "20113"
  },
  {
    "label": "Meade",
    "value": "20115"
  },
  {
    "label": "Miami",
    "value": "20117"
  },
  {
    "label": "Mitchell",
    "value": "20119"
  },
  {
    "label": "Montgomery",
    "value": "20121"
  },
  {
    "label": "Morris",
    "value": "20123"
  },
  {
    "label": "Morton",
    "value": "20125"
  },
  {
    "label": "Nemaha",
    "value": "20127"
  },
  {
    "label": "Neosho",
    "value": "20129"
  },
  {
    "label": "Ness",
    "value": "20131"
  },
  {
    "label": "Norton",
    "value": "20133"
  },
  {
    "label": "Osage",
    "value": "20135"
  },
  {
    "label": "Osborne",
    "value": "20137"
  },
  {
    "label": "Ottawa",
    "value": "20139"
  },
  {
    "label": "Pawnee",
    "value": "20141"
  },
  {
    "label": "Phillips",
    "value": "20143"
  },
  {
    "label": "Pottawatomie",
    "value": "20145"
  },
  {
    "label": "Pratt",
    "value": "20147"
  },
  {
    "label": "Rawlins",
    "value": "20149"
  },
  {
    "label": "Reno",
    "value": "20151"
  },
  {
    "label": "Republic",
    "value": "20153"
  },
  {
    "label": "Rice",
    "value": "20155"
  },
  {
    "label": "Riley",
    "value": "20157"
  },
  {
    "label": "Rooks",
    "value": "20159"
  },
  {
    "label": "Rush",
    "value": "20161"
  },
  {
    "label": "Russell",
    "value": "20163"
  },
  {
    "label": "Saline",
    "value": "20165"
  },
  {
    "label": "Scott",
    "value": "20167"
  },
  {
    "label": "Sedgwick",
    "value": "20169"
  },
  {
    "label": "Seward",
    "value": "20171"
  },
  {
    "label": "Shawnee",
    "value": "20173"
  },
  {
    "label": "Sheridan",
    "value": "20175"
  },
  {
    "label": "Sherman",
    "value": "20177"
  },
  {
    "label": "Smith",
    "value": "20179"
  },
  {
    "label": "Stafford",
    "value": "20181"
  },
  {
    "label": "Stanton",
    "value": "20183"
  },
  {
    "label": "Stevens",
    "value": "20185"
  },
  {
    "label": "Sumner",
    "value": "20187"
  },
  {
    "label": "Thomas",
    "value": "20189"
  },
  {
    "label": "Trego",
    "value": "20191"
  },
  {
    "label": "Wabaunsee",
    "value": "20193"
  },
  {
    "label": "Wallace",
    "value": "20195"
  },
  {
    "label": "Washington",
    "value": "20197"
  },
  {
    "label": "Wichita",
    "value": "20199"
  },
  {
    "label": "Wilson",
    "value": "20201"
  },
  {
    "label": "Woodson",
    "value": "20203"
  },
  {
    "label": "Wyandotte",
    "value": "20205"
  }
],
"ky" : [
  {
    "label": "Adair",
    "value": "21001"
  },
  {
    "label": "Allen",
    "value": "21003"
  },
  {
    "label": "Anderson",
    "value": "21005"
  },
  {
    "label": "Bourbon",
    "value": "21007"
  },
  {
    "label": "Boyd",
    "value": "21009"
  },
  {
    "label": "Bracken",
    "value": "21011"
  },
  {
    "label": "Breathitt",
    "value": "21013"
  },
  {
    "label": "Campbell",
    "value": "21015"
  },
  {
    "label": "Carter",
    "value": "21017"
  },
  {
    "label": "Clark",
    "value": "21019"
  },
  {
    "label": "Clay",
    "value": "21021"
  },
  {
    "label": "Elliott",
    "value": "21023"
  },
  {
    "label": "Estill",
    "value": "21025"
  },
  {
    "label": "Fayette",
    "value": "21027"
  },
  {
    "label": "Fleming",
    "value": "21029"
  },
  {
    "label": "Floyd",
    "value": "21031"
  },
  {
    "label": "Gallatin",
    "value": "21033"
  },
  {
    "label": "Grant",
    "value": "21035"
  },
  {
    "label": "Greenup",
    "value": "21037"
  },
  {
    "label": "Harlan",
    "value": "21039"
  },
  {
    "label": "Harrison",
    "value": "21041"
  },
  {
    "label": "Jackson",
    "value": "21043"
  },
  {
    "label": "Jessamine",
    "value": "21045"
  },
  {
    "label": "Johnson",
    "value": "21047"
  },
  {
    "label": "Kenton",
    "value": "21049"
  },
  {
    "label": "Knott",
    "value": "21051"
  },
  {
    "label": "Knox",
    "value": "21053"
  },
  {
    "label": "Laurel",
    "value": "21055"
  },
  {
    "label": "Lawrence",
    "value": "21057"
  },
  {
    "label": "Lee",
    "value": "21059"
  },
  {
    "label": "Leslie",
    "value": "21061"
  },
  {
    "label": "Letcher",
    "value": "21063"
  },
  {
    "label": "Lewis",
    "value": "21065"
  },
  {
    "label": "Lincoln",
    "value": "21067"
  },
  {
    "label": "Madison",
    "value": "21069"
  },
  {
    "label": "Magoffin",
    "value": "21071"
  },
  {
    "label": "Martin",
    "value": "21073"
  },
  {
    "label": "Menifee",
    "value": "21075"
  },
  {
    "label": "Morgan",
    "value": "21077"
  },
  {
    "label": "Montgomery",
    "value": "21079"
  },
  {
    "label": "Owsley",
    "value": "21081"
  },
  {
    "label": "Pendleton",
    "value": "21083"
  },
  {
    "label": "Perry",
    "value": "21085"
  },
  {
    "label": "Powell",
    "value": "21087"
  },
  {
    "label": "Robertson",
    "value": "21089"
  },
  {
    "label": "Rockcastle",
    "value": "21091"
  },
  {
    "label": "Rowan",
    "value": "21093"
  },
  {
    "label": "Knox",
    "value": "21095"
  },
  {
    "label": "Whitley",
    "value": "21097"
  },
  {
    "label": "Wolfe",
    "value": "21099"
  },
  {
    "label": "Woodford",
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