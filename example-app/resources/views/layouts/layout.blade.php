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
  <title>Propelyze | We Simplify Your Search</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="{{ asset('css/global.css') }}" rel="stylesheet">
  <link href="{{ asset('css/contact.css') }}" rel="stylesheet">
  <link href="{{ asset('css/index.css') }}" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

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
  @include('layouts.navbar')
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
      $("#agrre1").change(function() {
  var name = $(this).attr("name");
  $("input[type=checkbox][name=" + name + "]").val(($(this).is(":checked") ? "Yes" : "No"));
  //console.log($("input[type=hidden][name=" + name + "]").val());
})
      $(".su").on('click', function(event) {
        //alert('checkpdf');
      var cid = '<?php echo config('app.client_id'); ?>';
                    var cs = '<?php echo config('app.client_secret'); ?>';
                    var prop_id = $(this).attr("data-element");

      $.ajax({
                        url: 'https://dtapiuat.datatree.com/api/Login/AuthenticateClient',
                        type: "POST",
                        data: {
                            ClientId: cid,
                            ClientSecretKey: cs
                        },
                        success: function(data) {
                            localStorage.setItem('api_token', 'Bearer' + " " + data);
                        },

                    });
                    /////
                    $.ajax({
                url: 'https://dtapiuat.datatree.com/api/Report/GetReport?Ver=1.0',

                type: "POST",
                data: {
                    ProductNames: [
                        "SalesComparables"
                    ],
                    SearchType: "PROPERTY",
                    PropertyId: prop_id
                },

                headers: {
                    'Authorization': localStorage.getItem('api_token')
                },
                success: function(data) {

                    if (data) {
                        //console.log(data);
                        //console.log(data.LitePropertyList);
                        //console.log(data.Reports[0].Data.ComparableCount);
                        if(data.Reports[0].Data.ComparableCount > 0)
                        {
                          $("#d_pd").show();

                          $("#pdf1").show();

                        }
                    }

                },
                statusCode: {
                    400: function(data) {
                        //alert( "page not found" );
                        console.log(data.responseText);
                        $(".error").text(data.responseJSON.Message);

                    },
                    401: function() {
                        alert("unauthorized");
                    },

                } ///main ajax success

            });
                  });
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
      $(".run,.chk").on('submit',function() { //alert('')
        $('.loader').show();
        $('.sm-txt').show();
        setTimeout("hide()", 720); 
      });
      $("#myDataTable4").DataTable();
      
      $("#map_id").click(function() {
            $('html,body').animate({
                scrollTop: $(".tabmap").offset().top
              },
              'slow');
          });

          $(document).on('click', '.verify_mail', function() {
            var APP_URL = "{{ url('') }}";
            var emailVerify = $(this).attr('data-id');
            var page_url = '' + APP_URL + '/send-verify-mail/' + emailVerify + '';
            //alert(page_url);
            $.ajax({
                url: page_url,
                type: "GET",
                headers: {
                },

                success: function(data) {
                    //alert(url);
                    if (data.success == true) {
                        $('.result1').text(data.message);
                        setTimeout(() => {
                            $('.result1').text();

                        }, 1000);
                    } else {
                        alert(data.message);
                    }
                    //alert(url);
                },

            });

        });
    
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
"la" :
[
  {
    "label": "Acadia Parish",
    "value": "22001"
  },
  {
    "label": "Allen Parish",
    "value": "22003"
  },
  {
    "label": "Ascension Parish",
    "value": "22005"
  },
  {
    "label": "Assumption Parish",
    "value": "22007"
  },
  {
    "label": "Avoyelles Parish",
    "value": "22009"
  },
  {
    "label": "Beauregard Parish",
    "value": "22011"
  },
  {
    "label": "Bienville Parish",
    "value": "22013"
  },
  {
    "label": "Bossier Parish",
    "value": "22015"
  },
  {
    "label": "Caddo Parish",
    "value": "22017"
  },
  {
    "label": "Calcasieu Parish",
    "value": "22019"
  },
  {
    "label": "Caldwell Parish",
    "value": "22021"
  },
  {
    "label": "Cameron Parish",
    "value": "22023"
  },
  {
    "label": "Carroll Parish",
    "value": "22025"
  },
  {
    "label": "Cherokee Parish",
    "value": "22027"
  },
  {
    "label": "Claiborne Parish",
    "value": "22029"
  },
  {
    "label": "Concordia Parish",
    "value": "22031"
  },
  {
    "label": "DeSoto Parish",
    "value": "22033"
  },
  {
    "label": "East Baton Rouge Parish",
    "value": "22035"
  },
  {
    "label": "East Carroll Parish",
    "value": "22037"
  },
  {
    "label": "East Feliciana Parish",
    "value": "22039"
  },
  {
    "label": "Evangeline Parish",
    "value": "22041"
  },
  {
    "label": "Franklin Parish",
    "value": "22043"
  },
  {
    "label": "Grant Parish",
    "value": "22045"
  },
  {
    "label": "Iberia Parish",
    "value": "22047"
  },
  {
    "label": "Iberville Parish",
    "value": "22049"
  },
  {
    "label": "Jackson Parish",
    "value": "22051"
  },
  {
    "label": "Jefferson Parish",
    "value": "22053"
  },
  {
    "label": "Jefferson Davis Parish",
    "value": "22055"
  },
  {
    "label": "Lafayette Parish",
    "value": "22057"
  },
  {
    "label": "Lafourche Parish",
    "value": "22059"
  },
  {
    "label": "La Salle Parish",
    "value": "22061"
  },
  {
    "label": "Lincoln Parish",
    "value": "22063"
  },
  {
    "label": "Livingston Parish",
    "value": "22065"
  },
  {
    "label": "Madison Parish",
    "value": "22067"
  },
  {
    "label": "Morehouse Parish",
    "value": "22069"
  },
  {
    "label": "Natchitoches Parish",
    "value": "22071"
  },
  {
    "label": "Orleans Parish",
    "value": "22073"
  },
  {
    "label": "Ouachita Parish",
    "value": "22075"
  },
  {
    "label": "Plaquemines Parish",
    "value": "22077"
  },
  {
    "label": "Pointe Coupee Parish",
    "value": "22079"
  },
  {
    "label": "Rapides Parish",
    "value": "22081"
  },
  {
    "label": "Red River Parish",
    "value": "22083"
  },
  {
    "label": "Richland Parish",
    "value": "22085"
  },
  {
    "label": "Sabine Parish",
    "value": "22087"
  },
  {
    "label": "Saint Bernard Parish",
    "value": "22089"
  },
  {
    "label": "Saint Charles Parish",
    "value": "22091"
  },
  {
    "label": "Saint Helena Parish",
    "value": "22093"
  },
  {
    "label": "Saint James Parish",
    "value": "22095"
  },
  {
    "label": "Saint John the Baptist Parish",
    "value": "22097"
  },
  {
    "label": "Saint Landry Parish",
    "value": "22099"
  },
  {
    "label": "Saint Martin Parish",
    "value": "22101"
  },
  {
    "label": "Saint Mary Parish",
    "value": "22103"
  },
  {
    "label": "Saint Tammany Parish",
    "value": "22105"
  },
  {
    "label": "Tangipahoa Parish",
    "value": "22107"
  },
  {
    "label": "Tensas Parish",
    "value": "22109"
  },
  {
    "label": "Terrebonne Parish",
    "value": "22111"
  },
  {
    "label": "Union Parish",
    "value": "22113"
  },
  {
    "label": "Vermilion Parish",
    "value": "22115"
  },
  {
    "label": "Vernon Parish",
    "value": "22117"
  },
  {
    "label": "Washington Parish",
    "value": "22119"
  },
  {
    "label": "Webster Parish",
    "value": "22121"
  },
  {
    "label": "West Baton Rouge Parish",
    "value": "22123"
  },
  {
    "label": "West Carroll Parish",
    "value": "22125"
  },
  {
    "label": "West Feliciana Parish",
    "value": "22127"
  },
  {
    "label": "Winn Parish",
    "value": "22129"
  }
],
"me":[
  {
    "label": "Androscoggin",
    "value": "23001"
  },
  {
    "label": "Aroostook",
    "value": "23003"
  },
  {
    "label": "Cumberland",
    "value": "23005"
  },
  {
    "label": "Franklin",
    "value": "23007"
  },
  {
    "label": "Hancock",
    "value": "23009"
  },
  {
    "label": "Kennebec",
    "value": "23011"
  },
  {
    "label": "Knox",
    "value": "23013"
  },
  {
    "label": "Lincoln",
    "value": "23015"
  },
  {
    "label": "Oxford",
    "value": "23017"
  },
  {
    "label": "Penobscot",
    "value": "23019"
  },
  {
    "label": "Piscataquis",
    "value": "23021"
  },
  {
    "label": "Sagadahoc",
    "value": "23023"
  },
  {
    "label": "Somerset",
    "value": "23025"
  },
  {
    "label": "Waldo",
    "value": "23027"
  },
  {
    "label": "Washington",
    "value": "23029"
  },
  {
    "label": "York",
    "value": "23031"
  }
]
,
"md" :[
  {
    "label": "Allegany",
    "value": "24001"
  },
  {
    "label": "Anne Arundel",
    "value": "24003"
  },
  {
    "label": "Baltimore",
    "value": "24005"
  },
  {
    "label": "Baltimore City",
    "value": "24510"
  },
  {
    "label": "Calvert",
    "value": "24009"
  },
  {
    "label": "Caroline",
    "value": "24011"
  },
  {
    "label": "Carroll",
    "value": "24013"
  },
  {
    "label": "Cecil",
    "value": "24015"
  },
  {
    "label": "Charles",
    "value": "24017"
  },
  {
    "label": "Dorchester",
    "value": "24019"
  },
  {
    "label": "Frederick",
    "value": "24021"
  },
  {
    "label": "Garrett",
    "value": "24023"
  },
  {
    "label": "Harford",
    "value": "24025"
  },
  {
    "label": "Howard",
    "value": "24027"
  },
  {
    "label": "Kent",
    "value": "24029"
  },
  {
    "label": "Montgomery",
    "value": "24031"
  },
  {
    "label": "Prince George's",
    "value": "24033"
  },
  {
    "label": "Queen Anne's",
    "value": "24035"
  },
  {
    "label": "Saint Mary's",
    "value": "24037"
  },
  {
    "label": "Somerset",
    "value": "24039"
  },
  {
    "label": "Talbot",
    "value": "24041"
  },
  {
    "label": "Washington",
    "value": "24043"
  },
  {
    "label": "Wicomico",
    "value": "24045"
  },
  {
    "label": "Worcester",
    "value": "24047"
  }
],
"ma":[
  {
    "label": "Barnstable",
    "value": "25001"
  },
  {
    "label": "Berkshire",
    "value": "25003"
  },
  {
    "label": "Bristol",
    "value": "25005"
  },
  {
    "label": "Dukes",
    "value": "25007"
  },
  {
    "label": "Essex",
    "value": "25009"
  },
  {
    "label": "Franklin",
    "value": "25011"
  },
  {
    "label": "Hampden",
    "value": "25013"
  },
  {
    "label": "Hampshire",
    "value": "25015"
  },
  {
    "label": "Middlesex",
    "value": "25017"
  },
  {
    "label": "Norfolk",
    "value": "25019"
  },
  {
    "label": "Plymouth",
    "value": "25021"
  },
  {
    "label": "Suffolk",
    "value": "25023"
  },
  {
    "label": "Worcester",
    "value": "25025"
  }
]
,
"mi" :[
  {
    "label": "Alcona",
    "value": "26001"
  },
  {
    "label": "Alger",
    "value": "26003"
  },
  {
    "label": "Allegan",
    "value": "26005"
  },
  {
    "label": "Antrim",
    "value": "26007"
  },
  {
    "label": "Arenac",
    "value": "26009"
  },
  {
    "label": "Baraga",
    "value": "26011"
  },
  {
    "label": "Barry",
    "value": "26013"
  },
  {
    "label": "Bay",
    "value": "26015"
  },
  {
    "label": "Benzie",
    "value": "26017"
  },
  {
    "label": "Berrien",
    "value": "26019"
  },
  {
    "label": "Branch",
    "value": "26021"
  },
  {
    "label": "Calhoun",
    "value": "26023"
  },
  {
    "label": "Cass",
    "value": "26025"
  },
  {
    "label": "Charlevoix",
    "value": "26027"
  },
  {
    "label": "Cheboygan",
    "value": "26029"
  },
  {
    "label": "Chippewa",
    "value": "26031"
  },
  {
    "label": "Clare",
    "value": "26033"
  },
  {
    "label": "Clinton",
    "value": "26035"
  },
  {
    "label": "Crawford",
    "value": "26037"
  },
  {
    "label": "Delta",
    "value": "26039"
  },
  {
    "label": "Dickinson",
    "value": "26041"
  },
  {
    "label": "Eaton",
    "value": "26043"
  },
  {
    "label": "Emmet",
    "value": "26045"
  },
  {
    "label": "Genesee",
    "value": "26047"
  },
  {
    "label": "Gladwin",
    "value": "26049"
  },
  {
    "label": "Gogebic",
    "value": "26051"
  },
  {
    "label": "Grand Traverse",
    "value": "26053"
  },
  {
    "label": "Gratiot",
    "value": "26055"
  },
  {
    "label": "Hillsdale",
    "value": "26057"
  },
  {
    "label": "Houghton",
    "value": "26059"
  },
  {
    "label": "Huron",
    "value": "26061"
  },
  {
    "label": "Ingham",
    "value": "26063"
  },
  {
    "label": "Ionia",
    "value": "26065"
  },
  {
    "label": "Ishpeming",
    "value": "26067"
  },
  {
    "label": "Jackson",
    "value": "26069"
  },
  {
    "label": "Kalamazoo",
    "value": "26071"
  },
  {
    "label": "Kalkaska",
    "value": "26073"
  },
  {
    "label": "Kent",
    "value": "26075"
  },
  {
    "label": "Keweenaw",
    "value": "26077"
  },
  {
    "label": "Lake",
    "value": "26079"
  },
  {
    "label": "Lapeer",
    "value": "26081"
  },
  {
    "label": "Leelanau",
    "value": "26083"
  },
  {
    "label": "Lenawee",
    "value": "26085"
  },
  {
    "label": "Livingston",
    "value": "26087"
  },
  {
    "label": "Luce",
    "value": "26089"
  },
  {
    "label": "Mackinac",
    "value": "26091"
  },
  {
    "label": "Macomb",
    "value": "26093"
  },
  {
    "label": "Manistee",
    "value": "26095"
  },
  {
    "label": "Marquette",
    "value": "26097"
  },
  {
    "label": "Mason",
    "value": "26099"
  },
  {
    "label": "Mecosta",
    "value": "26101"
  },
  {
    "label": "Menominee",
    "value": "26103"
  },
  {
    "label": "Midland",
    "value": "26105"
  },
  {
    "label": "Missaukee",
    "value": "26107"
  },
  {
    "label": "Monroe",
    "value": "26109"
  },
  {
    "label": "Montcalm",
    "value": "26111"
  },
  {
    "label": "Montmorency",
    "value": "26113"
  },
  {
    "label": "Muskegon",
    "value": "26115"
  },
  {
    "label": "Newaygo",
    "value": "26117"
  },
  {
    "label": "Oakland",
    "value": "26119"
  },
  {
    "label": "Oceana",
    "value": "26121"
  },
  {
    "label": "Ogemaw",
    "value": "26123"
  },
  {
    "label": "Ontonagon",
    "value": "26125"
  },
  {
    "label": "Osceola",
    "value": "26127"
  },
  {
    "label": "Oscoda",
    "value": "26129"
  },
  {
    "label": "Otsego",
    "value": "26131"
  },
  {
    "label": "Presque Isle",
    "value": "26133"
  },
  {
    "label": "Roscommon",
    "value": "26135"
  },
  {
    "label": "Saginaw",
    "value": "26137"
  },
  {
    "label": "Saint Clair",
    "value": "26139"
  },
  {
    "label": "Saint Joseph",
    "value": "26141"
  },
  {
    "label": "Sanilac",
    "value": "26143"
  },
  {
    "label": "Schoolcraft",
    "value": "26145"
  },
  {
    "label": "Shiawassee",
    "value": "26147"
  },
  {
    "label": "Tuscola",
    "value": "26149"
  },
  {
    "label": "Van Buren",
    "value": "26151"
  },
  {
    "label": "Washtenaw",
    "value": "26153"
  },
  {
    "label": "Wayne",
    "value": "26155"
  },
  {
    "label": "Wexford",
    "value": "26157"
  }
]
,"mn" :[
  {
    "label": "Aitkin",
    "value": "27001"
  },
  {
    "label": "Anoka",
    "value": "27003"
  },
  {
    "label": "Becker",
    "value": "27005"
  },
  {
    "label": "Beltrami",
    "value": "27007"
  },
  {
    "label": "Benton",
    "value": "27009"
  },
  {
    "label": "Big Stone",
    "value": "27011"
  },
  {
    "label": "Blue Earth",
    "value": "27013"
  },
  {
    "label": "Brown",
    "value": "27015"
  },
  {
    "label": "Carlton",
    "value": "27017"
  },
  {
    "label": "Carver",
    "value": "27019"
  },
  {
    "label": "Cass",
    "value": "27021"
  },
  {
    "label": "Chippewa",
    "value": "27023"
  },
  {
    "label": "Chisago",
    "value": "27025"
  },
  {
    "label": "Clay",
    "value": "27027"
  },
  {
    "label": "Clearwater",
    "value": "27029"
  },
  {
    "label": "Cook",
    "value": "27031"
  },
  {
    "label": "Cottonwood",
    "value": "27033"
  },
  {
    "label": "Crow Wing",
    "value": "27035"
  },
  {
    "label": "Dakota",
    "value": "27037"
  },
  {
    "label": "Dodge",
    "value": "27039"
  },
  {
    "label": "Douglas",
    "value": "27041"
  },
  {
    "label": "Faribault",
    "value": "27043"
  },
  {
    "label": "Fillmore",
    "value": "27045"
  },
  {
    "label": "Freeborn",
    "value": "27047"
  },
  {
    "label": "Goodhue",
    "value": "27049"
  },
  {
    "label": "Grant",
    "value": "27051"
  },
  {
    "label": "Hennepin",
    "value": "27053"
  },
  {
    "label": "Houston",
    "value": "27055"
  },
  {
    "label": "Hubbard",
    "value": "27057"
  },
  {
    "label": "Isanti",
    "value": "27059"
  },
  {
    "label": "Itasca",
    "value": "27061"
  },
  {
    "label": "Jackson",
    "value": "27063"
  },
  {
    "label": "Kanabec",
    "value": "27065"
  },
  {
    "label": "Kandiyohi",
    "value": "27067"
  },
  {
    "label": "Carver",
    "value": "27019"
  },
  {
    "label": "Lake",
    "value": "27069"
  },
  {
    "label": "Lake of the Woods",
    "value": "27071"
  },
  {
    "label": "Le Sueur",
    "value": "27073"
  },
  {
    "label": "Lincoln",
    "value": "27075"
  },
  {
    "label": "Lyon",
    "value": "27077"
  },
  {
    "label": "McLeod",
    "value": "27079"
  },
  {
    "label": "Mahnomen",
    "value": "27081"
  },
  {
    "label": "Marshall",
    "value": "27083"
  },
  {
    "label": "Martin",
    "value": "27085"
  },
  {
    "label": "Meeker",
    "value": "27087"
  },
  {
    "label": "Mille Lacs",
    "value": "27089"
  },
  {
    "label": "Morrison",
    "value": "27091"
  },
  {
    "label": "Mower",
    "value": "27093"
  },
  {
    "label": "Murray",
    "value": "27095"
  },
  {
    "label": "Nicollet",
    "value": "27097"
  },
  {
    "label": "Nobles",
    "value": "27099"
  },
  {
    "label": "Olmsted",
    "value": "27101"
  },
  {
    "label": "Otter Tail",
    "value": "27103"
  },
  {
    "label": "Pennington",
    "value": "27105"
  },
  {
    "label": "Pine",
    "value": "27107"
  },
  {
    "label": "Pipestone",
    "value": "27109"
  },
  {
    "label": "Polk",
    "value": "27111"
  },
  {
    "label": "Pope",
    "value": "27113"
  },
  {
    "label": "Ramsey",
    "value": "27115"
  },
  {
    "label": "Red Lake",
    "value": "27117"
  },
  {
    "label": "Redwood",
    "value": "27119"
  },
  {
    "label": "Renville",
    "value": "27121"
  },
  {
    "label": "Rice",
    "value": "27123"
  },
  {
    "label": "Rock",
    "value": "27125"
  },
  {
    "label": "Roseau",
    "value": "27127"
  },
  {
    "label": "St. Louis",
    "value": "27129"
  },
  {
    "label": "Scott",
    "value": "27131"
  },
  {
    "label": "Sherburne",
    "value": "27133"
  },
  {
    "label": "Sibley",
    "value": "27135"
  },
  {
    "label": "Stearns",
    "value": "27137"
  },
  {
    "label": "Steele",
    "value": "27139"
  },
  {
    "label": "Stevens",
    "value": "27141"
  },
  {
    "label": "Swift",
    "value": "27143"
  },
  {
    "label": "Todd",
    "value": "27145"
  },
  {
    "label": "Wabasha",
    "value": "27147"
  },
  {
    "label": "Wadena",
    "value": "27149"
  },
  {
    "label": "Washington",
    "value": "27151"
  },
  {
    "label": "Wilkin",
    "value": "27153"
  },
  {
    "label": "Winona",
    "value": "27155"
  },
  {
    "label": "Wright",
    "value": "27157"
  },
  {
    "label": "Yellow Medicine",
    "value": "27159"
  }
]
,"ms" : [
  {
    "label": "Adams",
    "value": "28001"
  },
  {
    "label": "Alcorn",
    "value": "28003"
  },
  {
    "label": "Amite",
    "value": "28005"
  },
  {
    "label": "Benton",
    "value": "28007"
  },
  {
    "label": "Bolivar",
    "value": "28009"
  },
  {
    "label": "Calhoun",
    "value": "28011"
  },
  {
    "label": "Carroll",
    "value": "28013"
  },
  {
    "label": "Chickasaw",
    "value": "28015"
  },
  {
    "label": "Choctaw",
    "value": "28017"
  },
  {
    "label": "Claiborne",
    "value": "28019"
  },
  {
    "label": "Clarke",
    "value": "28021"
  },
  {
    "label": "Clay",
    "value": "28023"
  },
  {
    "label": "Coahoma",
    "value": "28025"
  },
  {
    "label": "Copiah",
    "value": "28027"
  },
  {
    "label": "Covington",
    "value": "28029"
  },
  {
    "label": "DeSoto",
    "value": "28031"
  },
  {
    "label": "Forrest",
    "value": "28033"
  },
  {
    "label": "Franklin",
    "value": "28035"
  },
  {
    "label": "George",
    "value": "28037"
  },
  {
    "label": "Greene",
    "value": "28039"
  },
  {
    "label": "Grenada",
    "value": "28041"
  },
  {
    "label": "Hancock",
    "value": "28043"
  },
  {
    "label": "Harrison",
    "value": "28045"
  },
  {
    "label": "Hinds",
    "value": "28047"
  },
  {
    "label": "Holmes",
    "value": "28049"
  },
  {
    "label": "Humphreys",
    "value": "28051"
  },
  {
    "label": "Issaquena",
    "value": "28053"
  },
  {
    "label": "Itawamba",
    "value": "28055"
  },
  {
    "label": "Jackson",
    "value": "28057"
  },
  {
    "label": "Jasper",
    "value": "28059"
  },
  {
    "label": "Jefferson",
    "value": "28061"
  },
  {
    "label": "Jefferson Davis",
    "value": "28063"
  },
  {
    "label": "Jones",
    "value": "28065"
  },
  {
    "label": "Kemper",
    "value": "28067"
  },
  {
    "label": "Lafayette",
    "value": "28069"
  },
  {
    "label": "Lamar",
    "value": "28071"
  },
  {
    "label": "Lauderdale",
    "value": "28073"
  },
  {
    "label": "Lawrence",
    "value": "28075"
  },
  {
    "label": "Leake",
    "value": "28077"
  },
  {
    "label": "Leflore",
    "value": "28079"
  },
  {
    "label": "Lincoln",
    "value": "28081"
  },
  {
    "label": "Lowndes",
    "value": "28083"
  },
  {
    "label": "Madison",
    "value": "28085"
  },
  {
    "label": "Marion",
    "value": "28087"
  },
  {
    "label": "Marshall",
    "value": "28089"
  },
  {
    "label": "Monroe",
    "value": "28091"
  },
  {
    "label": "Montgomery",
    "value": "28093"
  },
  {
    "label": "Neshoba",
    "value": "28095"
  },
  {
    "label": "Newton",
    "value": "28097"
  },
  {
    "label": "Noxubee",
    "value": "28099"
  },
  {
    "label": "Oktibbeha",
    "value": "28101"
  },
  {
    "label": "Panola",
    "value": "28103"
  },
  {
    "label": "Pearl River",
    "value": "28105"
  },
  {
    "label": "Perry",
    "value": "28107"
  },
  {
    "label": "Pike",
    "value": "28109"
  },
  {
    "label": "Pontotoc",
    "value": "28111"
  },
  {
    "label": "Prentiss",
    "value": "28113"
  },
  {
    "label": "Quitman",
    "value": "28115"
  },
  {
    "label": "Rankin",
    "value": "28117"
  },
  {
    "label": "Scott",
    "value": "28119"
  },
  {
    "label": "Sharkey",
    "value": "28121"
  },
  {
    "label": "Simpson",
    "value": "28123"
  },
  {
    "label": "Smith",
    "value": "28125"
  },
  {
    "label": "Stone",
    "value": "28127"
  },
  {
    "label": "Sunflower",
    "value": "28129"
  },
  {
    "label": "Tallahatchie",
    "value": "28131"
  },
  {
    "label": "Tate",
    "value": "28133"
  },
  {
    "label": "Tippah",
    "value": "28135"
  },
  {
    "label": "Tishomingo",
    "value": "28137"
  },
  {
    "label": "Tunica",
    "value": "28139"
  },
  {
    "label": "Union",
    "value": "28141"
  },
  {
    "label": "Walthall",
    "value": "28143"
  },
  {
    "label": "Warren",
    "value": "28145"
  },
  {
    "label": "Washington",
    "value": "28147"
  },
  {
    "label": "Wayne",
    "value": "28149"
  },
  {
    "label": "Wilkinson",
    "value": "28151"
  },
  {
    "label": "Winston",
    "value": "28153"
  },
  {
    "label": "Yalobusha",
    "value": "28155"
  },
  {
    "label": "Yazoo",
    "value": "28157"
  }
]
,
"mo" :[
  {
    "label": "Adair",
    "value": "29001"
  },
  {
    "label": "Andrew",
    "value": "29003"
  },
  {
    "label": "Atchison",
    "value": "29005"
  },
  {
    "label": "Audrain",
    "value": "29007"
  },
  {
    "label": "Barry",
    "value": "29009"
  },
  {
    "label": "Barton",
    "value": "29011"
  },
  {
    "label": "Bates",
    "value": "29013"
  },
  {
    "label": "Benton",
    "value": "29015"
  },
  {
    "label": "Bollinger",
    "value": "29017"
  },
  {
    "label": "Boone",
    "value": "29019"
  },
  {
    "label": "Buchanan",
    "value": "29021"
  },
  {
    "label": "Butler",
    "value": "29023"
  },
  {
    "label": "Caldwell",
    "value": "29025"
  },
  {
    "label": "Callaway",
    "value": "29027"
  },
  {
    "label": "Camden",
    "value": "29029"
  },
  {
    "label": "Cape Girardeau",
    "value": "29031"
  },
  {
    "label": "Carroll",
    "value": "29033"
  },
  {
    "label": "Carter",
    "value": "29035"
  },
  {
    "label": "Cass",
    "value": "29037"
  },
  {
    "label": "Cedar",
    "value": "29039"
  },
  {
    "label": "Chariton",
    "value": "29041"
  },
  {
    "label": "Christian",
    "value": "29043"
  },
  {
    "label": "Clark",
    "value": "29045"
  },
  {
    "label": "Clay",
    "value": "29047"
  },
  {
    "label": "Clinton",
    "value": "29049"
  },
  {
    "label": "Cole",
    "value": "29051"
  },
  {
    "label": "Cooper",
    "value": "29053"
  },
  {
    "label": "Crawford",
    "value": "29055"
  },
  {
    "label": "Dade",
    "value": "29057"
  },
  {
    "label": "Dallas",
    "value": "29059"
  },
  {
    "label": "Daviess",
    "value": "29061"
  },
  {
    "label": "DeKalb",
    "value": "29063"
  },
  {
    "label": "Dent",
    "value": "29065"
  },
  {
    "label": "Douglas",
    "value": "29067"
  },
  {
    "label": "Dunklin",
    "value": "29069"
  },
  {
    "label": "Franklin",
    "value": "29071"
  },
  {
    "label": "Gasconade",
    "value": "29073"
  },
  {
    "label": "Gentry",
    "value": "29075"
  },
  {
    "label": "Greene",
    "value": "29077"
  },
  {
    "label": "Grundy",
    "value": "29079"
  },
  {
    "label": "Harrison",
    "value": "29081"
  },
  {
    "label": "Henry",
    "value": "29083"
  },
  {
    "label": "Hickory",
    "value": "29085"
  },
  {
    "label": "Holt",
    "value": "29087"
  },
  {
    "label": "Howard",
    "value": "29089"
  },
  {
    "label": "Howell",
    "value": "29091"
  },
  {
    "label": "Iron",
    "value": "29093"
  },
  {
    "label": "Jackson",
    "value": "29095"
  },
  {
    "label": "Jasper",
    "value": "29097"
  },
  {
    "label": "Jefferson",
    "value": "29099"
  },
  {
    "label": "Johnson",
    "value": "29101"
  },
  {
    "label": "Knox",
    "value": "29103"
  },
  {
    "label": "Laclede",
    "value": "29105"
  },
  {
    "label": "Lafayette",
    "value": "29107"
  },
  {
    "label": "Lawrence",
    "value": "29109"
  },
  {
    "label": "Lewis",
    "value": "29111"
  },
  {
    "label": "Lincoln",
    "value": "29113"
  },
  {
    "label": "Linn",
    "value": "29115"
  },
  {
    "label": "Livingston",
    "value": "29117"
  },
  {
    "label": "McDonald",
    "value": "29119"
  },
  {
    "label": "Macoupin",
    "value": "29121"
  },
  {
    "label": "Madison",
    "value": "29123"
  },
  {
    "label": "Maries",
    "value": "29125"
  },
  {
    "label": "Marion",
    "value": "29127"
  },
  {
    "label": "McDonald",
    "value": "29129"
  },
  {
    "label": "Moniteau",
    "value": "29131"
  },
  {
    "label": "Montgomery",
    "value": "29133"
  },
  {
    "label": "Morgan",
    "value": "29135"
  },
  {
    "label": "New Madrid",
    "value": "29137"
  },
  {
    "label": "Newton",
    "value": "29139"
  },
  {
    "label": "Nodaway",
    "value": "29141"
  },
  {
    "label": "Oregon",
    "value": "29143"
  },
  {
    "label": "Osage",
    "value": "29145"
  },
  {
    "label": "Ozark",
    "value": "29147"
  },
  {
    "label": "Pemiscot",
    "value": "29149"
  },
  {
    "label": "Perry",
    "value": "29151"
  },
  {
    "label": "Pike",
    "value": "29153"
  },
  {
    "label": "Platte",
    "value": "29155"
  },
  {
    "label": "Polk",
    "value": "29157"
  },
  {
    "label": "Pulaski",
    "value": "29159"
  },
  {
    "label": "Ralls",
    "value": "29161"
  },
  {
    "label": "Randolph",
    "value": "29163"
  },
  {
    "label": "Ray",
    "value": "29165"
  },
  {
    "label": "Reynolds",
    "value": "29167"
  },
  {
    "label": "Ripley",
    "value": "29169"
  },
  {
    "label": "Saint Charles",
    "value": "29171"
  },
  {
    "label": "Saint Clair",
    "value": "29173"
  },
  {
    "label": "Saint Francois",
    "value": "29175"
  },
  {
    "label": "Saint Genevieve",
    "value": "29177"
  },
  {
    "label": "Saint Louis",
    "value": "29179"
  },
  {
    "label": "Sainte Genevieve",
    "value": "29181"
  },
  {
    "label": "Saline",
    "value": "29183"
  },
  {
    "label": "Schuyler",
    "value": "29185"
  },
  {
    "label": "Scotland",
    "value": "29187"
  },
  {
    "label": "Scott",
    "value": "29189"
  },
  {
    "label": "Shannon",
    "value": "29191"
  },
  {
    "label": "Shelby",
    "value": "29193"
  },
  {
    "label": "Stone",
    "value": "29195"
  },
  {
    "label": "Sullivan",
    "value": "29197"
  },
  {
    "label": "Taney",
    "value": "29199"
  },
  {
    "label": "Texas",
    "value": "29201"
  },
  {
    "label": "Vernon",
    "value": "29203"
  },
  {
    "label": "Warren",
    "value": "29205"
  },
  {
    "label": "Washington",
    "value": "29207"
  },
  {
    "label": "Wayne",
    "value": "29209"
  },
  {
    "label": "Webster",
    "value": "29211"
  },
  {
    "label": "Worth",
    "value": "29213"
  },
  {
    "label": "Wright",
    "value": "29215"
  }
]
,"mt" :[
  {
    "label": "Beaverhead",
    "value": "30001"
  },
  {
    "label": "Big Horn",
    "value": "30003"
  },
  {
    "label": "Blaine",
    "value": "30005"
  },
  {
    "label": "Broadwater",
    "value": "30007"
  },
  {
    "label": "Carbon",
    "value": "30009"
  },
  {
    "label": "Carter",
    "value": "30011"
  },
  {
    "label": "Cascade",
    "value": "30013"
  },
  {
    "label": "Chouteau",
    "value": "30015"
  },
  {
    "label": "Custer",
    "value": "30017"
  },
  {
    "label": "Daniels",
    "value": "30019"
  },
  {
    "label": "Dawson",
    "value": "30021"
  },
  {
    "label": "Deer Lodge",
    "value": "30023"
  },
  {
    "label": "Fallon",
    "value": "30025"
  },
  {
    "label": "Fergus",
    "value": "30027"
  },
  {
    "label": "Flathead",
    "value": "30029"
  },
  {
    "label": "Gallatin",
    "value": "30031"
  },
  {
    "label": "Garfield",
    "value": "30033"
  },
  {
    "label": "Glacier",
    "value": "30035"
  },
  {
    "label": "Golden Valley",
    "value": "30037"
  },
  {
    "label": "Granite",
    "value": "30039"
  },
  {
    "label": "Hill",
    "value": "30041"
  },
  {
    "label": "Jefferson",
    "value": "30043"
  },
  {
    "label": "Judith Basin",
    "value": "30045"
  },
  {
    "label": "Lake",
    "value": "30047"
  },
  {
    "label": "Lewis and Clark",
    "value": "30049"
  },
  {
    "label": "Liberty",
    "value": "30051"
  },
  {
    "label": "Lincoln",
    "value": "30053"
  },
  {
    "label": "McCone",
    "value": "30055"
  },
  {
    "label": "Madison",
    "value": "30057"
  },
  {
    "label": "Mineral",
    "value": "30059"
  },
  {
    "label": "Missoula",
    "value": "30061"
  },
  {
    "label": "Musselshell",
    "value": "30063"
  },
  {
    "label": "Park",
    "value": "30065"
  },
  {
    "label": "Petroleum",
    "value": "30067"
  },
  {
    "label": "Phillips",
    "value": "30069"
  },
  {
    "label": "Pondera",
    "value": "30071"
  },
  {
    "label": "Powder River",
    "value": "30073"
  },
  {
    "label": "Powell",
    "value": "30075"
  },
  {
    "label": "Prairie",
    "value": "30077"
  },
  {
    "label": "Ravalli",
    "value": "30079"
  },
  {
    "label": "Richland",
    "value": "30081"
  },
  {
    "label": "Roosevelt",
    "value": "30083"
  },
  {
    "label": "Rosebud",
    "value": "30085"
  },
  {
    "label": "Sanders",
    "value": "30087"
  },
  {
    "label": "Sheridan",
    "value": "30089"
  },
  {
    "label": "Silver Bow",
    "value": "30091"
  },
  {
    "label": "Stillwater",
    "value": "30093"
  },
  {
    "label": "Sweet Grass",
    "value": "30095"
  },
  {
    "label": "Teton",
    "value": "30097"
  },
  {
    "label": "Toole",
    "value": "30099"
  },
  {
    "label": "Treasure",
    "value": "30101"
  },
  {
    "label": "Valley",
    "value": "30103"
  },
  {
    "label": "Wheatland",
    "value": "30105"
  },
  {
    "label": "Yellowstone",
    "value": "30107"
  }
]
,
"ne" :[
  {
    "label": "Adams",
    "value": "31001"
  },
  {
    "label": "Antelope",
    "value": "31003"
  },
  {
    "label": "Arthur",
    "value": "31005"
  },
  {
    "label": "Banner",
    "value": "31007"
  },
  {
    "label": "Blaine",
    "value": "31009"
  },
  {
    "label": "Boone",
    "value": "31011"
  },
  {
    "label": "Box Butte",
    "value": "31013"
  },
  {
    "label": "Boyd",
    "value": "31015"
  },
  {
    "label": "Brown",
    "value": "31017"
  },
  {
    "label": "Buffalo",
    "value": "31019"
  },
  {
    "label": "Burt",
    "value": "31021"
  },
  {
    "label": "Butler",
    "value": "31023"
  },
  {
    "label": "Cass",
    "value": "31025"
  },
  {
    "label": "Cedar",
    "value": "31027"
  },
  {
    "label": "Chase",
    "value": "31029"
  },
  {
    "label": "Cherry",
    "value": "31031"
  },
  {
    "label": "Cheyenne",
    "value": "31033"
  },
  {
    "label": "Clay",
    "value": "31035"
  },
  {
    "label": "Colfax",
    "value": "31037"
  },
  {
    "label": "Cuming",
    "value": "31039"
  },
  {
    "label": "Custer",
    "value": "31041"
  },
  {
    "label": "Dakota",
    "value": "31043"
  },
  {
    "label": "Dawes",
    "value": "31045"
  },
  {
    "label": "Dixon",
    "value": "31047"
  },
  {
    "label": "Dodge",
    "value": "31049"
  },
  {
    "label": "Douglas",
    "value": "31051"
  },
  {
    "label": "Dundy",
    "value": "31053"
  },
  {
    "label": "Fillmore",
    "value": "31055"
  },
  {
    "label": "Franklin",
    "value": "31057"
  },
  {
    "label": "Frontier",
    "value": "31059"
  },
  {
    "label": "Furnas",
    "value": "31061"
  },
  {
    "label": "Gage",
    "value": "31063"
  },
  {
    "label": "Garden",
    "value": "31065"
  },
  {
    "label": "Garfield",
    "value": "31067"
  },
  {
    "label": "Giant",
    "value": "31069"
  },
  {
    "label": "Greeley",
    "value": "31071"
  },
  {
    "label": "Hall",
    "value": "31073"
  },
  {
    "label": "Hamilton",
    "value": "31075"
  },
  {
    "label": "Harlan",
    "value": "31077"
  },
  {
    "label": "Hayes",
    "value": "31079"
  },
  {
    "label": "Hitchcock",
    "value": "31081"
  },
  {
    "label": "Holt",
    "value": "31083"
  },
  {
    "label": "Hooker",
    "value": "31085"
  },
  {
    "label": "Howard",
    "value": "31087"
  },
  {
    "label": "Jefferson",
    "value": "31089"
  },
  {
    "label": "Johnson",
    "value": "31091"
  },
  {
    "label": "Kearney",
    "value": "31093"
  },
  {
    "label": "Keith",
    "value": "31095"
  },
  {
    "label": "Keya Paha",
    "value": "31097"
  },
  {
    "label": "Knox",
    "value": "31099"
  },
  {
    "label": "Lancaster",
    "value": "31101"
  },
  {
    "label": "Lincoln",
    "value": "31103"
  },
  {
    "label": "Logan",
    "value": "31105"
  },
  {
    "label": "Loup",
    "value": "31107"
  },
  {
    "label": "McPherson",
    "value": "31109"
  },
  {
    "label": "Madison",
    "value": "31111"
  },
  {
    "label": "Merrick",
    "value": "31113"
  },
  {
    "label": "Morrill",
    "value": "31115"
  },
  {
    "label": "Nance",
    "value": "31117"
  },
  {
    "label": "Nemaha",
    "value": "31119"
  },
  {
    "label": "Nuckolls",
    "value": "31121"
  },
  {
    "label": "Otoe",
    "value": "31123"
  },
  {
    "label": "Pawnee",
    "value": "31125"
  },
  {
    "label": "Perkins",
    "value": "31127"
  },
  {
    "label": "Phelps",
    "value": "31129"
  },
  {
    "label": "Pierce",
    "value": "31131"
  },
  {
    "label": "Platte",
    "value": "31133"
  },
  {
    "label": "Red Willow",
    "value": "31135"
  },
  {
    "label": "Richardson",
    "value": "31137"
  },
  {
    "label": "Rock",
    "value": "31139"
  },
  {
    "label": "Saline",
    "value": "31141"
  },
  {
    "label": "Sarpy",
    "value": "31143"
  },
  {
    "label": "Saunders",
    "value": "31145"
  },
  {
    "label": "Scotts Bluff",
    "value": "31147"
  },
  {
    "label": "Seward",
    "value": "31149"
  },
  {
    "label": "Sheridan",
    "value": "31151"
  },
  {
    "label": "Sherman",
    "value": "31153"
  },
  {
    "label": "Sioux",
    "value": "31155"
  },
  {
    "label": "Stanton",
    "value": "31157"
  },
  {
    "label": "Thayer",
    "value": "31159"
  },
  {
    "label": "Thomas",
    "value": "31161"
  },
  {
    "label": "Valley",
    "value": "31163"
  },
  {
    "label": "Washington",
    "value": "31165"
  },
  {
    "label": "Wayne",
    "value": "31167"
  },
  {
    "label": "Webster",
    "value": "31169"
  },
  {
    "label": "Wheeler",
    "value": "31171"
  },
  {
    "label": "York",
    "value": "31173"
  }
]
,
"nv" :[
  {
    "label": "Carson City",
    "value": "32001"
  },
  {
    "label": "Churchill",
    "value": "32003"
  },
  {
    "label": "Clark",
    "value": "32005"
  },
  {
    "label": "Douglas",
    "value": "32007"
  },
  {
    "label": "Esmeralda",
    "value": "32009"
  },
  {
    "label": "Eureka",
    "value": "32011"
  },
  {
    "label": "Humboldt",
    "value": "32013"
  },
  {
    "label": "Lander",
    "value": "32015"
  },
  {
    "label": "Lincoln",
    "value": "32017"
  },
  {
    "label": "Lyon",
    "value": "32019"
  },
  {
    "label": "Mineral",
    "value": "32021"
  },
  {
    "label": "Nye",
    "value": "32023"
  },
  {
    "label": "Pershing",
    "value": "32025"
  },
  {
    "label": "Storey",
    "value": "32027"
  },
  {
    "label": "Washoe",
    "value": "32029"
  },
  {
    "label": "White Pine",
    "value": "32031"
  }
],
"nh" : [
  {
    "label": "Belknap",
    "value": "33001"
  },
  {
    "label": "Carroll",
    "value": "33003"
  },
  {
    "label": "Cheshire",
    "value": "33005"
  },
  {
    "label": "Coos",
    "value": "33007"
  },
  {
    "label": "Grafton",
    "value": "33009"
  },
  {
    "label": "Hillsborough",
    "value": "33011"
  },
  {
    "label": "Merrimack",
    "value": "33013"
  },
  {
    "label": "Rockingham",
    "value": "33015"
  },
  {
    "label": "Strafford",
    "value": "33017"
  },
  {
    "label": "Sullivan",
    "value": "33019"
  }
]
,"nj" :[
  {
    "label": "Atlantic",
    "value": "34001"
  },
  {
    "label": "Bergen",
    "value": "34003"
  },
  {
    "label": "Burlington",
    "value": "34005"
  },
  {
    "label": "Camden",
    "value": "34007"
  },
  {
    "label": "Cape May",
    "value": "34009"
  },
  {
    "label": "Cumberland",
    "value": "34011"
  },
  {
    "label": "Essex",
    "value": "34013"
  },
  {
    "label": "Gloucester",
    "value": "34015"
  },
  {
    "label": "Hudson",
    "value": "34017"
  },
  {
    "label": "Hunterdon",
    "value": "34019"
  },
  {
    "label": "Mercer",
    "value": "34021"
  },
  {
    "label": "Middlesex",
    "value": "34023"
  },
  {
    "label": "Monmouth",
    "value": "34025"
  },
  {
    "label": "Morris",
    "value": "34027"
  },
  {
    "label": "Ocean",
    "value": "34029"
  },
  {
    "label": "Passaic",
    "value": "34031"
  },
  {
    "label": "Salem",
    "value": "34033"
  },
  {
    "label": "Somerset",
    "value": "34035"
  },
  {
    "label": "Sussex",
    "value": "34037"
  },
  {
    "label": "Union",
    "value": "34039"
  },
  {
    "label": "Warren",
    "value": "34041"
  }
]
,"nm" :[
  {
    "label": "Bernalillo",
    "value": "35001"
  },
  {
    "label": "Catron",
    "value": "35003"
  },
  {
    "label": "Chaves",
    "value": "35005"
  },
  {
    "label": "Cibola",
    "value": "35006"
  },
  {
    "label": "Colfax",
    "value": "35007"
  },
  {
    "label": "De Baca",
    "value": "35009"
  },
  {
    "label": "Dona Ana",
    "value": "35011"
  },
  {
    "label": "Eddy",
    "value": "35013"
  },
  {
    "label": "Grant",
    "value": "35015"
  },
  {
    "label": "Guadalupe",
    "value": "35017"
  },
  {
    "label": "Harding",
    "value": "35019"
  },
  {
    "label": "Hidalgo",
    "value": "35021"
  },
  {
    "label": "Lea",
    "value": "35023"
  },
  {
    "label": "Lincoln",
    "value": "35025"
  },
  {
    "label": "Los Alamos",
    "value": "35026"
  },
  {
    "label": "Luna",
    "value": "35027"
  },
  {
    "label": "McKinley",
    "value": "35028"
  },
  {
    "label": "Mora",
    "value": "35029"
  },
  {
    "label": "Otero",
    "value": "35031"
  },
  {
    "label": "Quay",
    "value": "35033"
  },
  {
    "label": "Rio Arriba",
    "value": "35035"
  },
  {
    "label": "Roosevelt",
    "value": "35037"
  },
  {
    "label": "Sandoval",
    "value": "35039"
  },
  {
    "label": "Santa Barbara",
    "value": "35041"
  },
  {
    "label": "Santa Fe",
    "value": "35043"
  },
  {
    "label": "Sierra",
    "value": "35045"
  },
  {
    "label": "Socorro",
    "value": "35047"
  },
  {
    "label": "Taos",
    "value": "35049"
  },
  {
    "label": "Torrance",
    "value": "35051"
  },
  {
    "label": "Union",
    "value": "35053"
  },
  {
    "label": "Valencia",
    "value": "35055"
  }
]
,
"ny" : [
  {
    "label": "Albany",
    "value": "36001"
  },
  {
    "label": "Allegany",
    "value": "36003"
  },
  {
    "label": "Bronx",
    "value": "36005"
  },
  {
    "label": "Broome",
    "value": "36007"
  },
  {
    "label": "Cattaraugus",
    "value": "36009"
  },
  {
    "label": "Cayuga",
    "value": "36011"
  },
  {
    "label": "Chautauqua",
    "value": "36013"
  },
  {
    "label": "Chemung",
    "value": "36015"
  },
  {
    "label": "Chenango",
    "value": "36017"
  },
  {
    "label": "Clinton",
    "value": "36019"
  },
  {
    "label": "Columbia",
    "value": "36021"
  },
  {
    "label": "Cortland",
    "value": "36023"
  },
  {
    "label": "Delaware",
    "value": "36025"
  },
  {
    "label": "Dutchess",
    "value": "36027"
  },
  {
    "label": "Erie",
    "value": "36029"
  },
  {
    "label": "Essex",
    "value": "36031"
  },
  {
    "label": "Franklin",
    "value": "36033"
  },
  {
    "label": "Fulton",
    "value": "36035"
  },
  {
    "label": "Genesee",
    "value": "36037"
  },
  {
    "label": "Greene",
    "value": "36039"
  },
  {
    "label": "Hamilton",
    "value": "36041"
  },
  {
    "label": "Herkimer",
    "value": "36043"
  },
  {
    "label": "Jefferson",
    "value": "36045"
  },
  {
    "label": "Kings",
    "value": "36047"
  },
  {
    "label": "Lewis",
    "value": "36049"
  },
  {
    "label": "Livingston",
    "value": "36051"
  },
  {
    "label": "Madison",
    "value": "36053"
  },
  {
    "label": "Monroe",
    "value": "36055"
  },
  {
    "label": "Montgomery",
    "value": "36057"
  },
  {
    "label": "Nassau",
    "value": "36059"
  },
  {
    "label": "New York",
    "value": "36061"
  },
  {
    "label": "Niagara",
    "value": "36063"
  },
  {
    "label": "Oneida",
    "value": "36065"
  },
  {
    "label": "Onondaga",
    "value": "36067"
  },
  {
    "label": "Ontario",
    "value": "36069"
  },
  {
    "label": "Orange",
    "value": "36071"
  },
  {
    "label": "Orleans",
    "value": "36073"
  },
  {
    "label": "Oswego",
    "value": "36075"
  },
  {
    "label": "Otsego",
    "value": "36077"
  },
  {
    "label": "Putnam",
    "value": "36079"
  },
  {
    "label": "Queens",
    "value": "36081"
  },
  {
    "label": "Rensselaer",
    "value": "36083"
  },
  {
    "label": "Richmond",
    "value": "36085"
  },
  {
    "label": "Rockland",
    "value": "36087"
  },
  {
    "label": "St. Lawrence",
    "value": "36089"
  },
  {
    "label": "Saratoga",
    "value": "36091"
  },
  {
    "label": "Schenectady",
    "value": "36093"
  },
  {
    "label": "Schoharie",
    "value": "36095"
  },
  {
    "label": "Schuyler",
    "value": "36097"
  },
  {
    "label": "Seneca",
    "value": "36099"
  },
  {
    "label": "Steuben",
    "value": "36101"
  },
  {
    "label": "Suffolk",
    "value": "36103"
  },
  {
    "label": "Sullivan",
    "value": "36105"
  },
  {
    "label": "Tioga",
    "value": "36107"
  },
  {
    "label": "Tompkins",
    "value": "36109"
  },
  {
    "label": "Ulster",
    "value": "36111"
  },
  {
    "label": "Warren",
    "value": "36113"
  },
  {
    "label": "Washington",
    "value": "36115"
  },
  {
    "label": "Westchester",
    "value": "36117"
  },
  {
    "label": "Wyoming",
    "value": "36119"
  },
  {
    "label": "Yates",
    "value": "36121"
  }
]
,
"nc" :
[
  {
    "label": "Alamance",
    "value": "37001"
  },
  {
    "label": "Alexander",
    "value": "37003"
  },
  {
    "label": "Alleghany",
    "value": "37005"
  },
  {
    "label": "Anson",
    "value": "37007"
  },
  {
    "label": "Ashe",
    "value": "37009"
  },
  {
    "label": "Avery",
    "value": "37011"
  },
  {
    "label": "Beaufort",
    "value": "37013"
  },
  {
    "label": "Bertie",
    "value": "37015"
  },
  {
    "label": "Bladen",
    "value": "37017"
  },
  {
    "label": "Brunswick",
    "value": "37019"
  },
  {
    "label": "Buncombe",
    "value": "37021"
  },
  {
    "label": "Burke",
    "value": "37023"
  },
  {
    "label": "Cabarrus",
    "value": "37025"
  },
  {
    "label": "Caldwell",
    "value": "37027"
  },
  {
    "label": "Camden",
    "value": "37029"
  },
  {
    "label": "Carteret",
    "value": "37031"
  },
  {
    "label": "Caswell",
    "value": "37033"
  },
  {
    "label": "Catawba",
    "value": "37035"
  },
  {
    "label": "Chatham",
    "value": "37037"
  },
  {
    "label": "Cherokee",
    "value": "37039"
  },
  {
    "label": "Chowan",
    "value": "37041"
  },
  {
    "label": "Clay",
    "value": "37043"
  },
  {
    "label": "Cleveland",
    "value": "37045"
  },
  {
    "label": "Columbus",
    "value": "37047"
  },
  {
    "label": "Craven",
    "value": "37049"
  },
  {
    "label": "Cumberland",
    "value": "37051"
  },
  {
    "label": "Currituck",
    "value": "37053"
  },
  {
    "label": "Dare",
    "value": "37055"
  },
  {
    "label": "Davidson",
    "value": "37057"
  },
  {
    "label": "Davie",
    "value": "37059"
  },
  {
    "label": "Duplin",
    "value": "37061"
  },
  {
    "label": "Durham",
    "value": "37063"
  },
  {
    "label": "Edgecombe",
    "value": "37065"
  },
  {
    "label": "Forsyth",
    "value": "37067"
  },
  {
    "label": "Gaston",
    "value": "37069"
  },
  {
    "label": "Gates",
    "value": "37071"
  },
  {
    "label": "Graham",
    "value": "37073"
  },
  {
    "label": "Granville",
    "value": "37075"
  },
  {
    "label": "Greene",
    "value": "37077"
  },
  {
    "label": "Guilford",
    "value": "37079"
  },
  {
    "label": "Halifax",
    "value": "37081"
  },
  {
    "label": "Harnett",
    "value": "37083"
  },
  {
    "label": "Haywood",
    "value": "37085"
  },
  {
    "label": "Henderson",
    "value": "37087"
  },
  {
    "label": "Hertford",
    "value": "37089"
  },
  {
    "label": "Hoke",
    "value": "37091"
  },
  {
    "label": "Hyde",
    "value": "37093"
  },
  {
    "label": "Iredell",
    "value": "37095"
  },
  {
    "label": "Jackson",
    "value": "37097"
  },
  {
    "label": "Johnston",
    "value": "37099"
  },
  {
    "label": "Jones",
    "value": "37101"
  },
  {
    "label": "Lee",
    "value": "37103"
  },
  {
    "label": "Lenoir",
    "value": "37105"
  },
  {
    "label": "Lincoln",
    "value": "37107"
  },
  {
    "label": "McDowell",
    "value": "37109"
  },
  {
    "label": "Macon",
    "value": "37111"
  },
  {
    "label": "Madison",
    "value": "37113"
  },
  {
    "label": "Martin",
    "value": "37115"
  },
  {
    "label": "Mecklenburg",
    "value": "37117"
  },
  {
    "label": "Mitchell",
    "value": "37119"
  },
  {
    "label": "Montgomery",
    "value": "37121"
  },
  {
    "label": "Moore",
    "value": "37123"
  },
  {
    "label": "Nash",
    "value": "37125"
  },
  {
    "label": "New Hanover",
    "value": "37127"
  },
  {
    "label": "Northampton",
    "value": "37129"
  },
  {
    "label": "Onslow",
    "value": "37131"
  },
  {
    "label": "Orange",
    "value": "37133"
  },
  {
    "label": "Person",
    "value": "37135"
  },
  {
    "label": "Pitt",
    "value": "37137"
  },
  {
    "label": "Polk",
    "value": "37139"
  },
  {
    "label": "Randolph",
    "value": "37141"
  },
  {
    "label": "Richmond",
    "value": "37143"
  },
  {
    "label": "Robeson",
    "value": "37145"
  },
  {
    "label": "Rockingham",
    "value": "37147"
  },
  {
    "label": "Rowan",
    "value": "37149"
  },
  {
    "label": "Rutherford",
    "value": "37151"
  },
  {
    "label": "Sampson",
    "value": "37153"
  },
  {
    "label": "Scotland",
    "value": "37155"
  },
  {
    "label": "Stanly",
    "value": "37157"
  },
  {
    "label": "Stokes",
    "value": "37159"
  },
  {
    "label": "Surry",
    "value": "37161"
  },
  {
    "label": "Swain",
    "value": "37163"
  },
  {
    "label": "Transylvania",
    "value": "37165"
  },
  {
    "label": "Tyrrell",
    "value": "37167"
  },
  {
    "label": "Union",
    "value": "37169"
  },
  {
    "label": "Vance",
    "value": "37171"
  },
  {
    "label": "Wake",
    "value": "37173"
  },
  {
    "label": "Warren",
    "value": "37175"
  },
  {
    "label": "Washington",
    "value": "37177"
  },
  {
    "label": "Watauga",
    "value": "37179"
  },
  {
    "label": "Wilkes",
    "value": "37181"
  },
  {
    "label": "Wilson",
    "value": "37183"
  },
  {
    "label": "Yadkin",
    "value": "37185"
  },
  {
    "label": "Yancey",
    "value": "37187"
  }
]
,
"nd" :
[
  {
    "label": "Adams",
    "value": "38001"
  },
  {
    "label": "Barnes",
    "value": "38003"
  },
  {
    "label": "Benson",
    "value": "38005"
  },
  {
    "label": "Billings",
    "value": "38007"
  },
  {
    "label": "Bottineau",
    "value": "38009"
  },
  {
    "label": "Bowman",
    "value": "38011"
  },
  {
    "label": "Burke",
    "value": "38013"
  },
  {
    "label": "Burleigh",
    "value": "38015"
  },
  {
    "label": "Cass",
    "value": "38017"
  },
  {
    "label": "Cataline",
    "value": "38019"
  },
  {
    "label": "Dickey",
    "value": "38021"
  },
  {
    "label": "Divide",
    "value": "38023"
  },
  {
    "label": "Dunn",
    "value": "38025"
  },
  {
    "label": "Eddy",
    "value": "38027"
  },
  {
    "label": "Emmons",
    "value": "38029"
  },
  {
    "label": "Foster",
    "value": "38031"
  },
  {
    "label": "Golden Valley",
    "value": "38033"
  },
  {
    "label": "Grand Forks",
    "value": "38035"
  },
  {
    "label": "Grant",
    "value": "38037"
  },
  {
    "label": "Griggs",
    "value": "38039"
  },
  {
    "label": "Hettinger",
    "value": "38041"
  },
  {
    "label": "Kidder",
    "value": "38043"
  },
  {
    "label": "LaMoure",
    "value": "38045"
  },
  {
    "label": "Logan",
    "value": "38047"
  },
  {
    "label": "McHenry",
    "value": "38049"
  },
  {
    "label": "McIntosh",
    "value": "38051"
  },
  {
    "label": "McKenzie",
    "value": "38053"
  },
  {
    "label": "McLean",
    "value": "38055"
  },
  {
    "label": "Mercer",
    "value": "38057"
  },
  {
    "label": "Morton",
    "value": "38059"
  },
  {
    "label": "Mountrail",
    "value": "38061"
  },
  {
    "label": "Nelson",
    "value": "38063"
  },
  {
    "label": "Oliver",
    "value": "38065"
  },
  {
    "label": "Pembina",
    "value": "38067"
  },
  {
    "label": "Pierce",
    "value": "38069"
  },
  {
    "label": "Ramsey",
    "value": "38071"
  },
  {
    "label": "Ransom",
    "value": "38073"
  },
  {
    "label": "Renville",
    "value": "38075"
  },
  {
    "label": "Richland",
    "value": "38077"
  },
  {
    "label": "Rolette",
    "value": "38079"
  },
  {
    "label": "Sargent",
    "value": "38081"
  },
  {
    "label": "Sheridan",
    "value": "38083"
  },
  {
    "label": "Sioux",
    "value": "38085"
  },
  {
    "label": "Slope",
    "value": "38087"
  },
  {
    "label": "Stark",
    "value": "38089"
  },
  {
    "label": "Steele",
    "value": "38091"
  },
  {
    "label": "Stutsman",
    "value": "38093"
  },
  {
    "label": "Towner",
    "value": "38095"
  },
  {
    "label": "Traill",
    "value": "38097"
  },
  {
    "label": "Walsh",
    "value": "38099"
  },
  {
    "label": "Ward",
    "value": "38101"
  },
  {
    "label": "Williams",
    "value": "38103"
  }
]
,
"oh" : [
  {
    "label": "Adams",
    "value": "39001"
  },
  {
    "label": "Allen",
    "value": "39003"
  },
  {
    "label": "Ashland",
    "value": "39005"
  },
  {
    "label": "Ashtabula",
    "value": "39007"
  },
  {
    "label": "Athens",
    "value": "39009"
  },
  {
    "label": "Auglaize",
    "value": "39011"
  },
  {
    "label": "Belmont",
    "value": "39013"
  },
  {
    "label": "Brown",
    "value": "39015"
  },
  {
    "label": "Butler",
    "value": "39017"
  },
  {
    "label": "Carroll",
    "value": "39019"
  },
  {
    "label": "Champaign",
    "value": "39021"
  },
  {
    "label": "Clark",
    "value": "39023"
  },
  {
    "label": "Clay",
    "value": "39025"
  },
  {
    "label": "Clinton",
    "value": "39027"
  },
  {
    "label": "Columbiana",
    "value": "39029"
  },
  {
    "label": "Coshocton",
    "value": "39031"
  },
  {
    "label": "Crawford",
    "value": "39033"
  },
  {
    "label": "Cuyahoga",
    "value": "39035"
  },
  {
    "label": "Darke",
    "value": "39037"
  },
  {
    "label": "Defiance",
    "value": "39039"
  },
  {
    "label": "Delaware",
    "value": "39041"
  },
  {
    "label": "Erie",
    "value": "39043"
  },
  {
    "label": "Fairfield",
    "value": "39045"
  },
  {
    "label": "Fayette",
    "value": "39047"
  },
  {
    "label": "Franklin",
    "value": "39049"
  },
  {
    "label": "Fulton",
    "value": "39051"
  },
  {
    "label": "Gallia",
    "value": "39053"
  },
  {
    "label": "Geauga",
    "value": "39055"
  },
  {
    "label": "Greene",
    "value": "39057"
  },
  {
    "label": "Guernsey",
    "value": "39059"
  },
  {
    "label": "Hamilton",
    "value": "39061"
  },
  {
    "label": "Hancock",
    "value": "39063"
  },
  {
    "label": "Hardin",
    "value": "39065"
  },
  {
    "label": "Harrison",
    "value": "39067"
  },
  {
    "label": "Henry",
    "value": "39069"
  },
  {
    "label": "Highland",
    "value": "39071"
  },
  {
    "label": "Hocking",
    "value": "39073"
  },
  {
    "label": "Holmes",
    "value": "39075"
  },
  {
    "label": "Huron",
    "value": "39077"
  },
  {
    "label": "Jackson",
    "value": "39079"
  },
  {
    "label": "Jefferson",
    "value": "39081"
  },
  {
    "label": "Knox",
    "value": "39083"
  },
  {
    "label": "Lake",
    "value": "39085"
  },
  {
    "label": "Lawrence",
    "value": "39087"
  },
  {
    "label": "Licking",
    "value": "39089"
  },
  {
    "label": "Logan",
    "value": "39091"
  },
  {
    "label": "Lorain",
    "value": "39093"
  },
  {
    "label": "Lucas",
    "value": "39095"
  },
  {
    "label": "Madison",
    "value": "39097"
  },
  {
    "label": "Mahoning",
    "value": "39099"
  },
  {
    "label": "Marion",
    "value": "39101"
  },
  {
    "label": "Medina",
    "value": "39103"
  },
  {
    "label": "Meigs",
    "value": "39105"
  },
  {
    "label": "Monroe",
    "value": "39107"
  },
  {
    "label": "Montgomery",
    "value": "39109"
  },
  {
    "label": "Morgan",
    "value": "39111"
  },
  {
    "label": "Morrow",
    "value": "39113"
  },
  {
    "label": "Muskingum",
    "value": "39115"
  },
  {
    "label": "Noble",
    "value": "39117"
  },
  {
    "label": "Ottawa",
    "value": "39119"
  },
  {
    "label": "Paulding",
    "value": "39121"
  },
  {
    "label": "Perry",
    "value": "39123"
  },
  {
    "label": "Pickaway",
    "value": "39125"
  },
  {
    "label": "Pike",
    "value": "39127"
  },
  {
    "label": "Portage",
    "value": "39129"
  },
  {
    "label": "Preble",
    "value": "39131"
  },
  {
    "label": "Putnam",
    "value": "39133"
  },
  {
    "label": "Richland",
    "value": "39135"
  },
  {
    "label": "Ross",
    "value": "39137"
  },
  {
    "label": "Sandusky",
    "value": "39139"
  },
  {
    "label": "Scioto",
    "value": "39141"
  },
  {
    "label": "Seneca",
    "value": "39143"
  },
  {
    "label": "Shelby",
    "value": "39145"
  },
  {
    "label": "Stark",
    "value": "39147"
  },
  {
    "label": "Summit",
    "value": "39149"
  },
  {
    "label": "Trumbull",
    "value": "39151"
  },
  {
    "label": "Tuscarawas",
    "value": "39153"
  },
  {
    "label": "Union",
    "value": "39155"
  },
  {
    "label": "Van Wert",
    "value": "39157"
  },
  {
    "label": "Vinton",
    "value": "39159"
  },
  {
    "label": "Warren",
    "value": "39161"
  },
  {
    "label": "Washington",
    "value": "39163"
  },
  {
    "label": "Wayne",
    "value": "39165"
  },
  {
    "label": "Williams",
    "value": "39167"
  },
  {
    "label": "Wood",
    "value": "39169"
  },
  {
    "label": "Wyandot",
    "value": "39171"
  }
]
,
"ok" :[
  {
    "label": "Adair",
    "value": "40001"
  },
  {
    "label": "Alfalfa",
    "value": "40003"
  },
  {
    "label": "Atoka",
    "value": "40005"
  },
  {
    "label": "Beaver",
    "value": "40007"
  },
  {
    "label": "Beckham",
    "value": "40009"
  },
  {
    "label": "Blaine",
    "value": "40011"
  },
  {
    "label": "Bryan",
    "value": "40013"
  },
  {
    "label": "Caddo",
    "value": "40015"
  },
  {
    "label": "Canadian",
    "value": "40017"
  },
  {
    "label": "Carson",
    "value": "40019"
  },
  {
    "label": "Cherokee",
    "value": "40021"
  },
  {
    "label": "Choctaw",
    "value": "40023"
  },
  {
    "label": "Cimarron",
    "value": "40025"
  },
  {
    "label": "Cleveland",
    "value": "40027"
  },
  {
    "label": "Coal",
    "value": "40029"
  },
  {
    "label": "Comanche",
    "value": "40031"
  },
  {
    "label": "Cotton",
    "value": "40033"
  },
  {
    "label": "Craig",
    "value": "40035"
  },
  {
    "label": "Creek",
    "value": "40037"
  },
  {
    "label": "Custer",
    "value": "40039"
  },
  {
    "label": "Delaware",
    "value": "40041"
  },
  {
    "label": "Dewey",
    "value": "40043"
  },
  {
    "label": "Ellis",
    "value": "40045"
  },
  {
    "label": "Garfield",
    "value": "40047"
  },
  {
    "label": "Garvin",
    "value": "40049"
  },
  {
    "label": "Grady",
    "value": "40051"
  },
  {
    "label": "Grant",
    "value": "40053"
  },
  {
    "label": "Greer",
    "value": "40055"
  },
  {
    "label": "Harmon",
    "value": "40057"
  },
  {
    "label": "Harper",
    "value": "40059"
  },
  {
    "label": "Haskell",
    "value": "40061"
  },
  {
    "label": "Hughes",
    "value": "40063"
  },
  {
    "label": "Jackson",
    "value": "40065"
  },
  {
    "label": "Jefferson",
    "value": "40067"
  },
  {
    "label": "Johnston",
    "value": "40069"
  },
  {
    "label": "Kay",
    "value": "40071"
  },
  {
    "label": "Kingfisher",
    "value": "40073"
  },
  {
    "label": "Kiowa",
    "value": "40075"
  },
  {
    "label": "Latimer",
    "value": "40077"
  },
  {
    "label": "Le Flore",
    "value": "40079"
  },
  {
    "label": "Lincoln",
    "value": "40081"
  },
  {
    "label": "Logan",
    "value": "40083"
  },
  {
    "label": "Love",
    "value": "40085"
  },
  {
    "label": "McClain",
    "value": "40087"
  },
  {
    "label": "McCurtain",
    "value": "40089"
  },
  {
    "label": "McIntosh",
    "value": "40091"
  },
  {
    "label": "Noble",
    "value": "40093"
  },
  {
    "label": "Oklahoma",
    "value": "40095"
  },
  {
    "label": "Okmulgee",
    "value": "40097"
  },
  {
    "label": "Osage",
    "value": "40099"
  },
  {
    "label": "Ottawa",
    "value": "40101"
  },
  {
    "label": "Pawnee",
    "value": "40103"
  },
  {
    "label": "Payne",
    "value": "40105"
  },
  {
    "label": "Pittsburg",
    "value": "40107"
  },
  {
    "label": "Pontotoc",
    "value": "40109"
  },
  {
    "label": "Pottawatomie",
    "value": "40111"
  },
  {
    "label": "Pushmataha",
    "value": "40113"
  },
  {
    "label": "Roger Mills",
    "value": "40115"
  },
  {
    "label": "Rogers",
    "value": "40117"
  },
  {
    "label": "Seminole",
    "value": "40119"
  },
  {
    "label": "Sequoyah",
    "value": "40121"
  },
  {
    "label": "Stephens",
    "value": "40123"
  },
  {
    "label": "Texas",
    "value": "40125"
  },
  {
    "label": "Tillman",
    "value": "40127"
  },
  {
    "label": "Tulsa",
    "value": "40129"
  },
  {
    "label": "Wagoner",
    "value": "40131"
  },
  {
    "label": "Washington",
    "value": "40133"
  },
  {
    "label": "Woods",
    "value": "40135"
  },
  {
    "label": "Woodward",
    "value": "40137"
  }
]
,
"or" :[
  {
    "label": "Baker",
    "value": "41001"
  },
  {
    "label": "Benton",
    "value": "41003"
  },
  {
    "label": "Clackamas",
    "value": "41005"
  },
  {
    "label": "Clatsop",
    "value": "41007"
  },
  {
    "label": "Columbia",
    "value": "41009"
  },
  {
    "label": "Coos",
    "value": "41011"
  },
  {
    "label": "Crook",
    "value": "41013"
  },
  {
    "label": "Curry",
    "value": "41015"
  },
  {
    "label": "Deschutes",
    "value": "41017"
  },
  {
    "label": "Douglas",
    "value": "41019"
  },
  {
    "label": "Gilliam",
    "value": "41021"
  },
  {
    "label": "Grant",
    "value": "41023"
  },
  {
    "label": "Harney",
    "value": "41025"
  },
  {
    "label": "Hood River",
    "value": "41027"
  },
  {
    "label": "Jackson",
    "value": "41029"
  },
  {
    "label": "Jefferson",
    "value": "41031"
  },
  {
    "label": "Josephine",
    "value": "41033"
  },
  {
    "label": "Klamath",
    "value": "41035"
  },
  {
    "label": "Lake",
    "value": "41037"
  },
  {
    "label": "Lane",
    "value": "41039"
  },
  {
    "label": "Lincoln",
    "value": "41041"
  },
  {
    "label": "Linn",
    "value": "41043"
  },
  {
    "label": "Malheur",
    "value": "41045"
  },
  {
    "label": "Marion",
    "value": "41047"
  },
  {
    "label": "Morrow",
    "value": "41049"
  },
  {
    "label": "Multnomah",
    "value": "41051"
  },
  {
    "label": "Polk",
    "value": "41053"
  },
  {
    "label": "Sherman",
    "value": "41055"
  },
  {
    "label": "Tillamook",
    "value": "41057"
  },
  {
    "label": "Umatilla",
    "value": "41059"
  },
  {
    "label": "Union",
    "value": "41061"
  },
  {
    "label": "Wallowa",
    "value": "41063"
  },
  {
    "label": "Wasco",
    "value": "41065"
  },
  {
    "label": "Washington",
    "value": "41067"
  },
  {
    "label": "Wheeler",
    "value": "41069"
  },
  {
    "label": "Yamhill",
    "value": "41071"
  }
]
,
"pa" : [
  {
    "label": "Adams",
    "value": "42001"
  },
  {
    "label": "Allegheny",
    "value": "42003"
  },
  {
    "label": "Armstrong",
    "value": "42005"
  },
  {
    "label": "Berks",
    "value": "42007"
  },
  {
    "label": "Blair",
    "value": "42009"
  },
  {
    "label": "Bradford",
    "value": "42011"
  },
  {
    "label": "Bucks",
    "value": "42013"
  },
  {
    "label": "Butler",
    "value": "42015"
  },
  {
    "label": "Cambria",
    "value": "42017"
  },
  {
    "label": "Cameron",
    "value": "42019"
  },
  {
    "label": "Carbon",
    "value": "42021"
  },
  {
    "label": "Centre",
    "value": "42023"
  },
  {
    "label": "Chester",
    "value": "42025"
  },
  {
    "label": "Clarion",
    "value": "42027"
  },
  {
    "label": "Clearfield",
    "value": "42029"
  },
  {
    "label": "Clinton",
    "value": "42031"
  },
  {
    "label": "Columbia",
    "value": "42033"
  },
  {
    "label": "Crawford",
    "value": "42035"
  },
  {
    "label": "Cumberland",
    "value": "42037"
  },
  {
    "label": "Dauphin",
    "value": "42039"
  },
  {
    "label": "Delaware",
    "value": "42041"
  },
  {
    "label": "Elk",
    "value": "42043"
  },
  {
    "label": "Erie",
    "value": "42045"
  },
  {
    "label": "Fayette",
    "value": "42047"
  },
  {
    "label": "Forest",
    "value": "42049"
  },
  {
    "label": "Franklin",
    "value": "42051"
  },
  {
    "label": "Fulton",
    "value": "42053"
  },
  {
    "label": "Greene",
    "value": "42055"
  },
  {
    "label": "Huntingdon",
    "value": "42057"
  },
  {
    "label": "Indiana",
    "value": "42059"
  },
  {
    "label": "Jefferson",
    "value": "42061"
  },
  {
    "label": "Juniata",
    "value": "42063"
  },
  {
    "label": "Lackawanna",
    "value": "42065"
  },
  {
    "label": "Lancaster",
    "value": "42067"
  },
  {
    "label": "Lawrence",
    "value": "42069"
  },
  {
    "label": "Lebanon",
    "value": "42071"
  },
  {
    "label": "Lehigh",
    "value": "42073"
  },
  {
    "label": "Luzerne",
    "value": "42075"
  },
  {
    "label": "Lykens",
    "value": "42077"
  },
  {
    "label": "Monroe",
    "value": "42079"
  },
  {
    "label": "Montgomery",
    "value": "42081"
  },
  {
    "label": "Montour",
    "value": "42083"
  },
  {
    "label": "Northampton",
    "value": "42085"
  },
  {
    "label": "Northumberland",
    "value": "42087"
  },
  {
    "label": "Perry",
    "value": "42089"
  },
  {
    "label": "Philadelphia",
    "value": "42091"
  },
  {
    "label": "Pike",
    "value": "42093"
  },
  {
    "label": "Potter",
    "value": "42095"
  },
  {
    "label": "Schuylkill",
    "value": "42097"
  },
  {
    "label": "Snyder",
    "value": "42099"
  },
  {
    "label": "Somerset",
    "value": "42101"
  },
  {
    "label": "Sullivan",
    "value": "42103"
  },
  {
    "label": "Susquehanna",
    "value": "42105"
  },
  {
    "label": "Tioga",
    "value": "42107"
  },
  {
    "label": "Union",
    "value": "42109"
  },
  {
    "label": "Venango",
    "value": "42111"
  },
  {
    "label": "Warren",
    "value": "42113"
  },
  {
    "label": "Washington",
    "value": "42115"
  },
  {
    "label": "Wayne",
    "value": "42117"
  },
  {
    "label": "Westmoreland",
    "value": "42119"
  },
  {
    "label": "Wyoming",
    "value": "42121"
  },
  {
    "label": "York",
    "value": "42123"
  }
]
,
"ri" :
[
  {
    "label": "Bristol",
    "value": "44001"
  },
  {
    "label": "Kent",
    "value": "44003"
  },
  {
    "label": "Newport",
    "value": "44005"
  },
  {
    "label": "Providence",
    "value": "44007"
  },
  {
    "label": "Washington",
    "value": "44009"
  }
]
,
"sc" :[
  {
    "label": "Abbeville",
    "value": "45001"
  },
  {
    "label": "Aiken",
    "value": "45003"
  },
  {
    "label": "Allendale",
    "value": "45005"
  },
  {
    "label": "Anderson",
    "value": "45007"
  },
  {
    "label": "Bamberg",
    "value": "45009"
  },
  {
    "label": "Barnwell",
    "value": "45011"
  },
  {
    "label": "Beaufort",
    "value": "45013"
  },
  {
    "label": "Berkeley",
    "value": "45015"
  },
  {
    "label": "Calhoun",
    "value": "45017"
  },
  {
    "label": "Charleston",
    "value": "45019"
  },
  {
    "label": "Cherokee",
    "value": "45021"
  },
  {
    "label": "Chester",
    "value": "45023"
  },
  {
    "label": "Chesterfield",
    "value": "45025"
  },
  {
    "label": "Clarendon",
    "value": "45027"
  },
  {
    "label": "Colleton",
    "value": "45029"
  },
  {
    "label": "Darlington",
    "value": "45031"
  },
  {
    "label": "Dillon",
    "value": "45033"
  },
  {
    "label": "Dorchester",
    "value": "45035"
  },
  {
    "label": "Edgefield",
    "value": "45037"
  },
  {
    "label": "Fairfield",
    "value": "45039"
  },
  {
    "label": "Florence",
    "value": "45041"
  },
  {
    "label": "Georgetown",
    "value": "45043"
  },
  {
    "label": "Greenville",
    "value": "45045"
  },
  {
    "label": "Greenwood",
    "value": "45047"
  },
  {
    "label": "Hampton",
    "value": "45049"
  },
  {
    "label": "Horry",
    "value": "45051"
  },
  {
    "label": "Jasper",
    "value": "45053"
  },
  {
    "label": "Kershaw",
    "value": "45055"
  },
  {
    "label": "Lancaster",
    "value": "45057"
  },
  {
    "label": "Laurens",
    "value": "45059"
  },
  {
    "label": "Lee",
    "value": "45061"
  },
  {
    "label": "Lexington",
    "value": "45063"
  },
  {
    "label": "McCormick",
    "value": "45065"
  },
  {
    "label": "Marion",
    "value": "45067"
  },
  {
    "label": "Marlboro",
    "value": "45069"
  },
  {
    "label": "Newberry",
    "value": "45071"
  },
  {
    "label": "Oconee",
    "value": "45073"
  },
  {
    "label": "Orangeburg",
    "value": "45075"
  },
  {
    "label": "Pickens",
    "value": "45077"
  },
  {
    "label": "Richland",
    "value": "45079"
  },
  {
    "label": "Saluda",
    "value": "45081"
  },
  {
    "label": "Spartanburg",
    "value": "45083"
  },
  {
    "label": "Sumter",
    "value": "45085"
  },
  {
    "label": "Union",
    "value": "45087"
  },
  {
    "label": "Williamsburg",
    "value": "45089"
  },
  {
    "label": "York",
    "value": "45091"
  }
]
,
"sd" :[
  {
    "label": "Aurora",
    "value": "46001"
  },
  {
    "label": "Beadle",
    "value": "46003"
  },
  {
    "label": "Bennett",
    "value": "46005"
  },
  {
    "label": "Bon Homme",
    "value": "46007"
  },
  {
    "label": "Brookings",
    "value": "46009"
  },
  {
    "label": "Brown",
    "value": "46011"
  },
  {
    "label": "Brule",
    "value": "46013"
  },
  {
    "label": "Buffalo",
    "value": "46015"
  },
  {
    "label": "Butte",
    "value": "46017"
  },
  {
    "label": "Campbell",
    "value": "46019"
  },
  {
    "label": "Charles Mix",
    "value": "46021"
  },
  {
    "label": "Clark",
    "value": "46023"
  },
  {
    "label": "Clay",
    "value": "46025"
  },
  {
    "label": "Codington",
    "value": "46027"
  },
  {
    "label": "Corson",
    "value": "46029"
  },
  {
    "label": "Custer",
    "value": "46031"
  },
  {
    "label": "Davison",
    "value": "46033"
  },
  {
    "label": "Day",
    "value": "46035"
  },
  {
    "label": "Deuel",
    "value": "46037"
  },
  {
    "label": "Dewey",
    "value": "46039"
  },
  {
    "label": "Douglas",
    "value": "46041"
  },
  {
    "label": "Edmunds",
    "value": "46043"
  },
  {
    "label": "Fall River",
    "value": "46045"
  },
  {
    "label": "Faulk",
    "value": "46047"
  },
  {
    "label": "Grant",
    "value": "46049"
  },
  {
    "label": "Gregory",
    "value": "46051"
  },
  {
    "label": "Haakon",
    "value": "46053"
  },
  {
    "label": "Hamlin",
    "value": "46055"
  },
  {
    "label": "Hand",
    "value": "46057"
  },
  {
    "label": "Hanson",
    "value": "46059"
  },
  {
    "label": "Harding",
    "value": "46061"
  },
  {
    "label": "Hughes",
    "value": "46063"
  },
  {
    "label": "Hutchinson",
    "value": "46065"
  },
  {
    "label": "Jackson",
    "value": "46067"
  },
  {
    "label": "Jerauld",
    "value": "46069"
  },
  {
    "label": "Jones",
    "value": "46071"
  },
  {
    "label": "Kingsbury",
    "value": "46073"
  },
  {
    "label": "Lake",
    "value": "46075"
  },
  {
    "label": "Lawrence",
    "value": "46077"
  },
  {
    "label": "Lincoln",
    "value": "46079"
  },
  {
    "label": "Lyman",
    "value": "46081"
  },
  {
    "label": "Marshall",
    "value": "46083"
  },
  {
    "label": "McCook",
    "value": "46085"
  },
  {
    "label": "McPherson",
    "value": "46087"
  },
  {
    "label": "Miner",
    "value": "46089"
  },
  {
    "label": "Minnehaha",
    "value": "46091"
  },
  {
    "label": "Moody",
    "value": "46093"
  },
  {
    "label": "Pennington",
    "value": "46095"
  },
  {
    "label": "Perkins",
    "value": "46097"
  },
  {
    "label": "Potter",
    "value": "46099"
  },
  {
    "label": "Roberts",
    "value": "46101"
  },
  {
    "label": "Sanborn",
    "value": "46103"
  },
  {
    "label": "Shannon",
    "value": "46105"
  },
  {
    "label": "Spink",
    "value": "46107"
  },
  {
    "label": "Stanley",
    "value": "46109"
  },
  {
    "label": "Sully",
    "value": "46111"
  },
  {
    "label": "Todd",
    "value": "46113"
  },
  {
    "label": "Tripp",
    "value": "46115"
  },
  {
    "label": "Union",
    "value": "46117"
  },
  {
    "label": "Walworth",
    "value": "46119"
  },
  {
    "label": "Yankton",
    "value": "46121"
  },
  {
    "label": "Ziebach",
    "value": "46123"
  }
]
,
"tn" :[
  {
    "label": "Anderson",
    "value": "47001"
  },
  {
    "label": "Bedford",
    "value": "47003"
  },
  {
    "label": "Benton",
    "value": "47005"
  },
  {
    "label": "Bledsoe",
    "value": "47007"
  },
  {
    "label": "Blount",
    "value": "47009"
  },
  {
    "label": "Bradley",
    "value": "47011"
  },
  {
    "label": "Campbell",
    "value": "47013"
  },
  {
    "label": "Cannon",
    "value": "47015"
  },
  {
    "label": "Carroll",
    "value": "47017"
  },
  {
    "label": "Carter",
    "value": "47019"
  },
  {
    "label": "Cheatham",
    "value": "47021"
  },
  {
    "label": "Chester",
    "value": "47023"
  },
  {
    "label": "Claiborne",
    "value": "47025"
  },
  {
    "label": "Clay",
    "value": "47027"
  },
  {
    "label": "Cocke",
    "value": "47029"
  },
  {
    "label": "Coffee",
    "value": "47031"
  },
  {
    "label": "Crockett",
    "value": "47033"
  },
  {
    "label": "Cumberland",
    "value": "47035"
  },
  {
    "label": "Davidson",
    "value": "47037"
  },
  {
    "label": "Decatur",
    "value": "47039"
  },
  {
    "label": "DeKalb",
    "value": "47041"
  },
  {
    "label": "Dickson",
    "value": "47043"
  },
  {
    "label": "Dyer",
    "value": "47045"
  },
  {
    "label": "Fayette",
    "value": "47047"
  },
  {
    "label": "Fentress",
    "value": "47049"
  },
  {
    "label": "Franklin",
    "value": "47051"
  },
  {
    "label": "Gibson",
    "value": "47053"
  },
  {
    "label": "Giles",
    "value": "47055"
  },
  {
    "label": "Grainger",
    "value": "47057"
  },
  {
    "label": "Green",
    "value": "47059"
  },
  {
    "label": "Greene",
    "value": "47061"
  },
  {
    "label": "Grundy",
    "value": "47063"
  },
  {
    "label": "Hamblen",
    "value": "47065"
  },
  {
    "label": "Hamilton",
    "value": "47067"
  },
  {
    "label": "Hancock",
    "value": "47069"
  },
  {
    "label": "Hardeman",
    "value": "47071"
  },
  {
    "label": "Hardin",
    "value": "47073"
  },
  {
    "label": "Hawkins",
    "value": "47075"
  },
  {
    "label": "Haywood",
    "value": "47077"
  },
  {
    "label": "Henderson",
    "value": "47079"
  },
  {
    "label": "Henry",
    "value": "47081"
  },
  {
    "label": "Hickman",
    "value": "47083"
  },
  {
    "label": "Houston",
    "value": "47085"
  },
  {
    "label": "Humphreys",
    "value": "47087"
  },
  {
    "label": "Jackson",
    "value": "47089"
  },
  {
    "label": "Jefferson",
    "value": "47091"
  },
  {
    "label": "Johnson",
    "value": "47093"
  },
  {
    "label": "Knox",
    "value": "47095"
  },
  {
    "label": "Lake",
    "value": "47097"
  },
  {
    "label": "Lauderdale",
    "value": "47099"
  },
  {
    "label": "Lawrence",
    "value": "47101"
  },
  {
    "label": "Lewis",
    "value": "47103"
  },
  {
    "label": "Lincoln",
    "value": "47105"
  },
  {
    "label": "Loudon",
    "value": "47107"
  },
  {
    "label": "McMinn",
    "value": "47109"
  },
  {
    "label": "McNairy",
    "value": "47111"
  },
  {
    "label": "Macon",
    "value": "47113"
  },
  {
    "label": "Madison",
    "value": "47115"
  },
  {
    "label": "Marion",
    "value": "47117"
  },
  {
    "label": "Marshall",
    "value": "47119"
  },
  {
    "label": "Maury",
    "value": "47121"
  },
  {
    "label": "Meigs",
    "value": "47123"
  },
  {
    "label": "Monroe",
    "value": "47125"
  },
  {
    "label": "Montgomery",
    "value": "47127"
  },
  {
    "label": "Moore",
    "value": "47129"
  },
  {
    "label": "Morgan",
    "value": "47131"
  },
  {
    "label": "Obion",
    "value": "47133"
  },
  {
    "label": "Overton",
    "value": "47135"
  },
  {
    "label": "Perry",
    "value": "47137"
  },
  {
    "label": "Pickett",
    "value": "47139"
  },
  {
    "label": "Polk",
    "value": "47141"
  },
  {
    "label": "Putnam",
    "value": "47143"
  },
  {
    "label": "Rhea",
    "value": "47145"
  },
  {
    "label": "Roane",
    "value": "47147"
  },
  {
    "label": "Robertson",
    "value": "47149"
  },
  {
    "label": "Rutherford",
    "value": "47151"
  },
  {
    "label": "Scott",
    "value": "47153"
  },
  {
    "label": "Sequatchie",
    "value": "47155"
  },
  {
    "label": "Sevier",
    "value": "47157"
  },
  {
    "label": "Shelby",
    "value": "47159"
  },
  {
    "label": "Smith",
    "value": "47161"
  },
  {
    "label": "Stewart",
    "value": "47163"
  },
  {
    "label": "Sullivan",
    "value": "47165"
  },
  {
    "label": "Sumner",
    "value": "47167"
  },
  {
    "label": "Tipton",
    "value": "47169"
  },
  {
    "label": "Trousdale",
    "value": "47171"
  },
  {
    "label": "Unicoi",
    "value": "47173"
  },
  {
    "label": "Union",
    "value": "47175"
  },
  {
    "label": "Van Buren",
    "value": "47177"
  },
  {
    "label": "Warren",
    "value": "47179"
  },
  {
    "label": "Washington",
    "value": "47181"
  },
  {
    "label": "Wayne",
    "value": "47183"
  },
  {
    "label": "Weakley",
    "value": "47185"
  },
  {
    "label": "White",
    "value": "47187"
  },
  {
    "label": "Williamson",
    "value": "47189"
  },
  {
    "label": "Wilson",
    "value": "47191"
  }
]
,
"tx" : [
  {
    "label": "Anderson",
    "value": "48001"
  },
  {
    "label": "Andrews",
    "value": "48003"
  },
  {
    "label": "Angelina",
    "value": "48005"
  },
  {
    "label": "Aransas",
    "value": "48007"
  },
  {
    "label": "Armstrong",
    "value": "48009"
  },
  {
    "label": "Atascosa",
    "value": "48011"
  },
  {
    "label": "Austin",
    "value": "48013"
  },
  {
    "label": "Bailey",
    "value": "48015"
  },
  {
    "label": "Bandera",
    "value": "48017"
  },
  {
    "label": "Bastrop",
    "value": "48019"
  },
  {
    "label": "Baylor",
    "value": "48021"
  },
  {
    "label": "Bee",
    "value": "48023"
  },
  {
    "label": "Bell",
    "value": "48027"
  },
  {
    "label": "Bexar",
    "value": "48029"
  },
  {
    "label": "Blanco",
    "value": "48031"
  },
  {
    "label": "Bowie",
    "value": "48033"
  },
  {
    "label": "Brazoria",
    "value": "48035"
  },
  {
    "label": "Brazos",
    "value": "48037"
  },
  {
    "label": "Brewster",
    "value": "48039"
  },
  {
    "label": "Briscoe",
    "value": "48041"
  },
  {
    "label": "Brooks",
    "value": "48043"
  },
  {
    "label": "Brown",
    "value": "48045"
  },
  {
    "label": "Burleson",
    "value": "48047"
  },
  {
    "label": "Burnet",
    "value": "48049"
  },
  {
    "label": "Caldwell",
    "value": "48051"
  },
  {
    "label": "Calhoun",
    "value": "48053"
  },
  {
    "label": "Callahan",
    "value": "48055"
  },
  {
    "label": "Cameron",
    "value": "48057"
  },
  {
    "label": "Camp",
    "value": "48059"
  },
  {
    "label": "Carson",
    "value": "48061"
  },
  {
    "label": "Cass",
    "value": "48063"
  },
  {
    "label": "Castro",
    "value": "48065"
  },
  {
    "label": "Chadburn",
    "value": "48067"
  },
  {
    "label": "Chambers",
    "value": "48069"
  },
  {
    "label": "Cherokee",
    "value": "48071"
  },
  {
    "label": "Childress",
    "value": "48073"
  },
  {
    "label": "Clay",
    "value": "48075"
  },
  {
    "label": "Cochran",
    "value": "48077"
  },
  {
    "label": "Coke",
    "value": "48079"
  },
  {
    "label": "Coleman",
    "value": "48081"
  },
  {
    "label": "Collin",
    "value": "48083"
  },
  {
    "label": "Collingsworth",
    "value": "48085"
  },
  {
    "label": "Colorado",
    "value": "48087"
  },
  {
    "label": "Comal",
    "value": "48089"
  },
  {
    "label": "Cooke",
    "value": "48091"
  },
  {
    "label": "Coryell",
    "value": "48093"
  },
  {
    "label": "Cottle",
    "value": "48095"
  },
  {
    "label": "Crane",
    "value": "48097"
  },
  {
    "label": "Crockett",
    "value": "48099"
  },
  {
    "label": "Crosby",
    "value": "48101"
  },
  {
    "label": "Dallas",
    "value": "48113"
  },
  {
    "label": "Dawson",
    "value": "48115"
  },
  {
    "label": "Deaf Smith",
    "value": "48117"
  },
  {
    "label": "Delta",
    "value": "48119"
  },
  {
    "label": "Denton",
    "value": "48121"
  },
  {
    "label": "Dickens",
    "value": "48123"
  },
  {
    "label": "Dimmit",
    "value": "48125"
  },
  {
    "label": "Donley",
    "value": "48127"
  },
  {
    "label": "Duval",
    "value": "48129"
  },
  {
    "label": "Eastland",
    "value": "48131"
  },
  {
    "label": "Ector",
    "value": "48133"
  },
  {
    "label": "Edwards",
    "value": "48135"
  },
  {
    "label": "El Paso",
    "value": "48137"
  },
  {
    "label": "Ellis",
    "value": "48139"
  },
  {
    "label": "El Salvador",
    "value": "48141"
  },
  {
    "label": "Falls",
    "value": "48143"
  },
  {
    "label": "Fannin",
    "value": "48145"
  },
  {
    "label": "Fayette",
    "value": "48147"
  },
  {
    "label": "Fisher",
    "value": "48149"
  },
  {
    "label": "Floyd",
    "value": "48151"
  },
  {
    "label": "Foard",
    "value": "48153"
  },
  {
    "label": "Fort Bend",
    "value": "48155"
  },
  {
    "label": "Franklin",
    "value": "48157"
  },
  {
    "label": "Freestone",
    "value": "48159"
  },
  {
    "label": "Frio",
    "value": "48161"
  },
  {
    "label": "Gaines",
    "value": "48163"
  },
  {
    "label": "Galveston",
    "value": "48165"
  },
  {
    "label": "Garza",
    "value": "48167"
  },
  {
    "label": "Gillespie",
    "value": "48169"
  },
  {
    "label": "Gonzales",
    "value": "48171"
  },
  {
    "label": "Gray",
    "value": "48173"
  },
  {
    "label": "Grayson",
    "value": "48175"
  },
  {
    "label": "Gregg",
    "value": "48177"
  },
  {
    "label": "Grimes",
    "value": "48179"
  },
  {
    "label": "Guadalupe",
    "value": "48181"
  },
  {
    "label": "Hale",
    "value": "48183"
  },
  {
    "label": "Hall",
    "value": "48185"
  },
  {
    "label": "Hamilton",
    "value": "48187"
  },
  {
    "label": "Hansford",
    "value": "48189"
  },
  {
    "label": "Hardeman",
    "value": "48191"
  },
  {
    "label": "Hardin",
    "value": "48193"
  },
  {
    "label": "Harris",
    "value": "48195"
  },
  {
    "label": "Harrison",
    "value": "48197"
  },
  {
    "label": "Hartley",
    "value": "48199"
  },
  {
    "label": "Haskell",
    "value": "48201"
  },
  {
    "label": "Hays",
    "value": "48203"
  },
  {
    "label": "Henderson",
    "value": "48205"
  },
  {
    "label": "Hidalgo",
    "value": "48207"
  },
  {
    "label": "Hill",
    "value": "48209"
  },
  {
    "label": "Hockley",
    "value": "48211"
  },
  {
    "label": "Hood",
    "value": "48213"
  },
  {
    "label": "Hopkins",
    "value": "48215"
  },
  {
    "label": "Houston",
    "value": "48217"
  },
  {
    "label": "Howard",
    "value": "48219"
  },
  {
    "label": "Hunt",
    "value": "48221"
  },
  {
    "label": "Hutchinson",
    "value": "48223"
  },
  {
    "label": "Irion",
    "value": "48225"
  },
  {
    "label": "Jack",
    "value": "48227"
  },
  {
    "label": "Jackson",
    "value": "48229"
  },
  {
    "label": "Jasper",
    "value": "48231"
  },
  {
    "label": "Jeff Davis",
    "value": "48233"
  },
  {
    "label": "Jefferson",
    "value": "48235"
  },
  {
    "label": "Jim Hogg",
    "value": "48237"
  },
  {
    "label": "Jim Wells",
    "value": "48239"
  },
  {
    "label": "Johnson",
    "value": "48241"
  },
  {
    "label": "Jones",
    "value": "48243"
  },
  {
    "label": "Karnes",
    "value": "48245"
  },
  {
    "label": "Kaufman",
    "value": "48247"
  },
  {
    "label": "Kendall",
    "value": "48249"
  },
  {
    "label": "Kenedy",
    "value": "48251"
  },
  {
    "label": "Kent",
    "value": "48253"
  },
  {
    "label": "Kerr",
    "value": "48255"
  },
  {
    "label": "Kimble",
    "value": "48257"
  },
  {
    "label": "King",
    "value": "48259"
  },
  {
    "label": "Kleberg",
    "value": "48261"
  },
  {
    "label": "Knox",
    "value": "48263"
  },
  {
    "label": "Lamar",
    "value": "48265"
  },
  {
    "label": "Lamb",
    "value": "48267"
  },
  {
    "label": "Lampasas",
    "value": "48269"
  },
  {
    "label": "La Salle",
    "value": "48271"
  },
  {
    "label": "Lavaca",
    "value": "48273"
  },
  {
    "label": "Lee",
    "value": "48275"
  },
  {
    "label": "Leon",
    "value": "48277"
  },
  {
    "label": "Liberty",
    "value": "48279"
  },
  {
    "label": "Limestone",
    "value": "48281"
  },
  {
    "label": "Lipscomb",
    "value": "48283"
  },
  {
    "label": "Live Oak",
    "value": "48285"
  },
  {
    "label": "Llano",
    "value": "48287"
  },
  {
    "label": "Lubbock",
    "value": "48289"
  },
  {
    "label": "Lynn",
    "value": "48291"
  },
  {
    "label": "Madison",
    "value": "48293"
  },
  {
    "label": "Marion",
    "value": "48295"
  },
  {
    "label": "Martin",
    "value": "48297"
  },
  {
    "label": "Mason",
    "value": "48299"
  },
  {
    "label": "Matagorda",
    "value": "48301"
  },
  {
    "label": "Maverick",
    "value": "48303"
  },
  {
    "label": "Medina",
    "value": "48305"
  },
  {
    "label": "Menard",
    "value": "48307"
  },
  {
    "label": "Midland",
    "value": "48309"
  },
  {
    "label": "Milam",
    "value": "48311"
  },
  {
    "label": "Mills",
    "value": "48313"
  },
  {
    "label": "Mitchell",
    "value": "48315"
  },
  {
    "label": "Montague",
    "value": "48317"
  },
  {
    "label": "Montgomery",
    "value": "48319"
  },
  {
    "label": "Moore",
    "value": "48321"
  },
  {
    "label": "Nacogdoches",
    "value": "48323"
  },
  {
    "label": "Navarro",
    "value": "48325"
  },
  {
    "label": "Newton",
    "value": "48327"
  },
  {
    "label": "Nolan",
    "value": "48329"
  },
  {
    "label": "Nueces",
    "value": "48331"
  },
  {
    "label": "Ochiltree",
    "value": "48333"
  },
  {
    "label": "Oldham",
    "value": "48335"
  },
  {
    "label": "Orange",
    "value": "48337"
  },
  {
    "label": "Palo Pinto",
    "value": "48339"
  },
  {
    "label": "Panola",
    "value": "48341"
  },
  {
    "label": "Parker",
    "value": "48343"
  },
  {
    "label": "Parmer",
    "value": "48345"
  },
  {
    "label": "Perry",
    "value": "48347"
  },
  {
    "label": "Potter",
    "value": "48349"
  },
  {
    "label": "Presidio",
    "value": "48351"
  },
  {
    "label": "Rains",
    "value": "48353"
  },
  {
    "label": "Randall",
    "value": "48355"
  },
  {
    "label": "Reagan",
    "value": "48357"
  },
  {
    "label": "Real",
    "value": "48359"
  },
  {
    "label": "Red River",
    "value": "48361"
  },
  {
    "label": "Robertson",
    "value": "48363"
  },
  {
    "label": "Rockwall",
    "value": "48365"
  },
  {
    "label": "Runnels",
    "value": "48367"
  },
  {
    "label": "Rusk",
    "value": "48369"
  },
  {
    "label": "Sabine",
    "value": "48371"
  },
  {
    "label": "San Augustine",
    "value": "48373"
  },
  {
    "label": "San Jacinto",
    "value": "48375"
  },
  {
    "label": "San Patricio",
    "value": "48377"
  },
  {
    "label": "San Saba",
    "value": "48379"
  },
  {
    "label": "Schleicher",
    "value": "48381"
  },
  {
    "label": "Scurry",
    "value": "48383"
  },
  {
    "label": "Shackelford",
    "value": "48385"
  },
  {
    "label": "Shelby",
    "value": "48387"
  },
  {
    "label": "Sherman",
    "value": "48389"
  },
  {
    "label": "Smith",
    "value": "48391"
  },
  {
    "label": "Sonia",
    "value": "48393"
  },
  {
    "label": "Somervell",
    "value": "48395"
  },
  {
    "label": "Starr",
    "value": "48397"
  },
  {
    "label": "Stephens",
    "value": "48399"
  },
  {
    "label": "Sterling",
    "value": "48401"
  },
  {
    "label": "Stonewall",
    "value": "48403"
  },
  {
    "label": "Sutton",
    "value": "48405"
  },
  {
    "label": "Swisher",
    "value": "48407"
  },
  {
    "label": "Tarrant",
    "value": "48409"
  },
  {
    "label": "Taylor",
    "value": "48411"
  },
  {
    "label": "Terrell",
    "value": "48413"
  },
  {
    "label": "Throckmorton",
    "value": "48415"
  },
  {
    "label": "Titus",
    "value": "48417"
  },
  {
    "label": "Tom Green",
    "value": "48419"
  },
  {
    "label": "Travis",
    "value": "48421"
  },
  {
    "label": "Trinity",
    "value": "48423"
  },
  {
    "label": "Tyler",
    "value": "48425"
  },
  {
    "label": "Upshur",
    "value": "48427"
  },
  {
    "label": "Uvalde",
    "value": "48429"
  },
  {
    "label": "Val Verde",
    "value": "48431"
  },
  {
    "label": "Van Zandt",
    "value": "48433"
  },
  {
    "label": "Victoria",
    "value": "48435"
  },
  {
    "label": "Walker",
    "value": "48437"
  },
  {
    "label": "Waller",
    "value": "48439"
  },
  {
    "label": "Ward",
    "value": "48441"
  },
  {
    "label": "Washington",
    "value": "48443"
  },
  {
    "label": "Webb",
    "value": "48445"
  },
  {
    "label": "Wharton",
    "value": "48447"
  },
  {
    "label": "Wheeler",
    "value": "48449"
  },
  {
    "label": "Williamson",
    "value": "48451"
  },
  {
    "label": "Wilson",
    "value": "48453"
  },
  {
    "label": "Winkler",
    "value": "48455"
  },
  {
    "label": "Wise",
    "value": "48457"
  },
  {
    "label": "Wood",
    "value": "48459"
  },
  {
    "label": "Yoakum",
    "value": "48461"
  },
  {
    "label": "Young",
    "value": "48463"
  },
  {
    "label": "Zapata",
    "value": "48465"
  },
  {
    "label": "Zavala",
    "value": "48467"
  }
],
"ut" : [
  {
    "label": "Beaver",
    "value": "49001"
  },
  {
    "label": "Box Elder",
    "value": "49003"
  },
  {
    "label": "Cache",
    "value": "49005"
  },
  {
    "label": "Carbon",
    "value": "49007"
  },
  {
    "label": "Daggett",
    "value": "49009"
  },
  {
    "label": "Davis",
    "value": "49011"
  },
  {
    "label": "Duchesne",
    "value": "49013"
  },
  {
    "label": "Emery",
    "value": "49015"
  },
  {
    "label": "Garfield",
    "value": "49017"
  },
  {
    "label": "Grand",
    "value": "49019"
  },
  {
    "label": "Iron",
    "value": "49021"
  },
  {
    "label": "Juab",
    "value": "49023"
  },
  {
    "label": "Kane",
    "value": "49025"
  },
  {
    "label": "Millard",
    "value": "49027"
  },
  {
    "label": "Morgan",
    "value": "49029"
  },
  {
    "label": "Piute",
    "value": "49031"
  },
  {
    "label": "Rich",
    "value": "49033"
  },
  {
    "label": "Salt Lake",
    "value": "49035"
  },
  {
    "label": "San Juan",
    "value": "49037"
  },
  {
    "label": "Sanpete",
    "value": "49039"
  },
  {
    "label": "Sevier",
    "value": "49041"
  },
  {
    "label": "Summit",
    "value": "49043"
  },
  {
    "label": "Tooele",
    "value": "49045"
  },
  {
    "label": "Utah",
    "value": "49047"
  },
  {
    "label": "Wasatch",
    "value": "49049"
  },
  {
    "label": "Washington",
    "value": "49051"
  },
  {
    "label": "Wayne",
    "value": "49053"
  },
  {
    "label": "Weber",
    "value": "49055"
  }
]
,
"vt" : [
  {
    "label": "Addison",
    "value": "50001"
  },
  {
    "label": "Bennington",
    "value": "50003"
  },
  {
    "label": "Caledonia",
    "value": "50005"
  },
  {
    "label": "Chittenden",
    "value": "50007"
  },
  {
    "label": "Essex",
    "value": "50009"
  },
  {
    "label": "Franklin",
    "value": "50011"
  },
  {
    "label": "Grand Isle",
    "value": "50013"
  },
  {
    "label": "Lamoille",
    "value": "50015"
  },
  {
    "label": "Orange",
    "value": "50017"
  },
  {
    "label": "Orleans",
    "value": "50019"
  },
  {
    "label": "Rutland",
    "value": "50021"
  },
  {
    "label": "Washington",
    "value": "50023"
  },
  {
    "label": "Windham",
    "value": "50025"
  },
  {
    "label": "Windsor",
    "value": "50027"
  }
]
,
"va" : [
  {
    "label": "Accomack",
    "value": "51001"
  },
  {
    "label": "Albemarle",
    "value": "51003"
  },
  {
    "label": "Alleghany",
    "value": "51005"
  },
  {
    "label": "Amelia",
    "value": "51007"
  },
  {
    "label": "Amherst",
    "value": "51009"
  },
  {
    "label": "Appomattox",
    "value": "51011"
  },
  {
    "label": "Augusta",
    "value": "51013"
  },
  {
    "label": "Bath",
    "value": "51015"
  },
  {
    "label": "Bedford",
    "value": "51017"
  },
  {
    "label": "Bland",
    "value": "51019"
  },
  {
    "label": "Botetourt",
    "value": "51021"
  },
  {
    "label": "Brunswick",
    "value": "51023"
  },
  {
    "label": "Buchanan",
    "value": "51025"
  },
  {
    "label": "Buckingham",
    "value": "51027"
  },
  {
    "label": "Campbell",
    "value": "51029"
  },
  {
    "label": "Caroline",
    "value": "51031"
  },
  {
    "label": "Carroll",
    "value": "51033"
  },
  {
    "label": "Charles City",
    "value": "51035"
  },
  {
    "label": "Charlotte",
    "value": "51036"
  },
  {
    "label": "Chesterfield",
    "value": "51037"
  },
  {
    "label": "Clarke",
    "value": "51039"
  },
  {
    "label": "Craig",
    "value": "51041"
  },
  {
    "label": "Culpeper",
    "value": "51043"
  },
  {
    "label": "Cumberland",
    "value": "51045"
  },
  {
    "label": "Dickenson",
    "value": "51047"
  },
  {
    "label": "Dinwiddie",
    "value": "51049"
  },
  {
    "label": "Essex",
    "value": "51051"
  },
  {
    "label": "Fairfax",
    "value": "51059"
  },
  {
    "label": "Fauquier",
    "value": "51061"
  },
  {
    "label": "Floyd",
    "value": "51063"
  },
  {
    "label": "Fluvanna",
    "value": "51065"
  },
  {
    "label": "Franklin",
    "value": "51067"
  },
  {
    "label": "Giles",
    "value": "51069"
  },
  {
    "label": "Gloucester",
    "value": "51071"
  },
  {
    "label": "Goochland",
    "value": "51073"
  },
  {
    "label": "Grayson",
    "value": "51075"
  },
  {
    "label": "Green",
    "value": "51077"
  },
  {
    "label": "Greensville",
    "value": "51079"
  },
  {
    "label": "Halifax",
    "value": "51081"
  },
  {
    "label": "Hanover",
    "value": "51083"
  },
  {
    "label": "Henrico",
    "value": "51085"
  },
  {
    "label": "Henry",
    "value": "51087"
  },
  {
    "label": "Highland",
    "value": "51089"
  },
  {
    "label": "Isle of Wight",
    "value": "51091"
  },
  {
    "label": "James City",
    "value": "51093"
  },
  {
    "label": "King and Queen",
    "value": "51095"
  },
  {
    "label": "King George",
    "value": "51097"
  },
  {
    "label": "King William",
    "value": "51099"
  },
  {
    "label": "Lancaster",
    "value": "51101"
  },
  {
    "label": "Lee",
    "value": "51103"
  },
  {
    "label": "Loudoun",
    "value": "51105"
  },
  {
    "label": "Louisa",
    "value": "51107"
  },
  {
    "label": "Lunenburg",
    "value": "51109"
  },
  {
    "label": "Madison",
    "value": "51111"
  },
  {
    "label": "Mathews",
    "value": "51113"
  },
  {
    "label": "Mecklenburg",
    "value": "51115"
  },
  {
    "label": "Middlesex",
    "value": "51117"
  },
  {
    "label": "Montgomery",
    "value": "51119"
  },
  {
    "label": "Nelson",
    "value": "51121"
  },
  {
    "label": "New Kent",
    "value": "51123"
  },
  {
    "label": "Northampton",
    "value": "51125"
  },
  {
    "label": "Northumberland",
    "value": "51127"
  },
  {
    "label": "Nottoway",
    "value": "51129"
  },
  {
    "label": "Orange",
    "value": "51131"
  },
  {
    "label": "Page",
    "value": "51133"
  },
  {
    "label": "Patrick",
    "value": "51135"
  },
  {
    "label": "Pittsylvania",
    "value": "51137"
  },
  {
    "label": "Powhatan",
    "value": "51139"
  },
  {
    "label": "Prince Edward",
    "value": "51141"
  },
  {
    "label": "Prince George",
    "value": "51143"
  },
  {
    "label": "Prince William",
    "value": "51145"
  },
  {
    "label": "Pulaski",
    "value": "51147"
  },
  {
    "label": "Rappahannock",
    "value": "51149"
  },
  {
    "label": "Richmond",
    "value": "51151"
  },
  {
    "label": "Roanoke",
    "value": "51153"
  },
  {
    "label": "Rockbridge",
    "value": "51155"
  },
  {
    "label": "Rockingham",
    "value": "51157"
  },
  {
    "label": "Russell",
    "value": "51159"
  },
  {
    "label": "Scott",
    "value": "51161"
  },
  {
    "label": "Shenandoah",
    "value": "51163"
  },
  {
    "label": "Smyth",
    "value": "51165"
  },
  {
    "label": "Southampton",
    "value": "51167"
  },
  {
    "label": "Spotsylvania",
    "value": "51169"
  },
  {
    "label": "Stafford",
    "value": "51171"
  },
  {
    "label": "Surry",
    "value": "51173"
  },
  {
    "label": "Sussex",
    "value": "51175"
  },
  {
    "label": "Tazewell",
    "value": "51177"
  },
  {
    "label": "Warren",
    "value": "51179"
  },
  {
    "label": "Washington",
    "value": "51181"
  },
  {
    "label": "Westmoreland",
    "value": "51183"
  },
  {
    "label": "Wythe",
    "value": "51185"
  },
  {
    "label": "York",
    "value": "51187"
  }
]
,
"wa" : [
  {
    "label": "Adams",
    "value": "53001"
  },
  {
    "label": "Asotin",
    "value": "53003"
  },
  {
    "label": "Benton",
    "value": "53005"
  },
  {
    "label": "Chelan",
    "value": "53007"
  },
  {
    "label": "Clallam",
    "value": "53009"
  },
  {
    "label": "Clark",
    "value": "53011"
  },
  {
    "label": "Columbia",
    "value": "53013"
  },
  {
    "label": "Cowlitz",
    "value": "53015"
  },
  {
    "label": "Douglas",
    "value": "53017"
  },
  {
    "label": "Ferry",
    "value": "53019"
  },
  {
    "label": "Franklin",
    "value": "53021"
  },
  {
    "label": "Garfield",
    "value": "53023"
  },
  {
    "label": "Grant",
    "value": "53025"
  },
  {
    "label": "Grays Harbor",
    "value": "53027"
  },
  {
    "label": "Island",
    "value": "53029"
  },
  {
    "label": "Jefferson",
    "value": "53031"
  },
  {
    "label": "King",
    "value": "53033"
  },
  {
    "label": "Kitsap",
    "value": "53035"
  },
  {
    "label": "Kittitas",
    "value": "53037"
  },
  {
    "label": "Klickitat",
    "value": "53039"
  },
  {
    "label": "Lewis",
    "value": "53041"
  },
  {
    "label": "Lincoln",
    "value": "53043"
  },
  {
    "label": "Mason",
    "value": "53045"
  },
  {
    "label": "Okanogan",
    "value": "53047"
  },
  {
    "label": "Pacific",
    "value": "53049"
  },
  {
    "label": "Pend Oreille",
    "value": "53051"
  },
  {
    "label": "Pierce",
    "value": "53053"
  },
  {
    "label": "San Juan",
    "value": "53055"
  },
  {
    "label": "Skagit",
    "value": "53057"
  },
  {
    "label": "Skamania",
    "value": "53059"
  },
  {
    "label": "Snohomish",
    "value": "53061"
  },
  {
    "label": "Spokane",
    "value": "53063"
  },
  {
    "label": "Stevens",
    "value": "53065"
  },
  {
    "label": "Thurston",
    "value": "53067"
  },
  {
    "label": "Wahkiakum",
    "value": "53069"
  },
  {
    "label": "Walla Walla",
    "value": "53071"
  },
  {
    "label": "Whatcom",
    "value": "53073"
  },
  {
    "label": "Whitman",
    "value": "53075"
  },
  {
    "label": "Yakima",
    "value": "53077"
  }
]
,
"wv" :[
  {
    "label": "Barbour",
    "value": "54001"
  },
  {
    "label": "Berkeley",
    "value": "54003"
  },
  {
    "label": "Boone",
    "value": "54005"
  },
  {
    "label": "Braxton",
    "value": "54007"
  },
  {
    "label": "Brooke",
    "value": "54009"
  },
  {
    "label": "Cabell",
    "value": "54011"
  },
  {
    "label": "Calhoun",
    "value": "54013"
  },
  {
    "label": "Clay",
    "value": "54015"
  },
  {
    "label": "Doddridge",
    "value": "54017"
  },
  {
    "label": "Fayette",
    "value": "54019"
  },
  {
    "label": "Gilmer",
    "value": "54021"
  },
  {
    "label": "Grant",
    "value": "54023"
  },
  {
    "label": "Greenbrier",
    "value": "54025"
  },
  {
    "label": "Hampshire",
    "value": "54027"
  },
  {
    "label": "Hancock",
    "value": "54029"
  },
  {
    "label": "Hardy",
    "value": "54031"
  },
  {
    "label": "Harrison",
    "value": "54033"
  },
  {
    "label": "Jackson",
    "value": "54035"
  },
  {
    "label": "Jefferson",
    "value": "54037"
  },
  {
    "label": "Kanawha",
    "value": "54039"
  },
  {
    "label": "Lewis",
    "value": "54041"
  },
  {
    "label": "Lincoln",
    "value": "54043"
  },
  {
    "label": "Logan",
    "value": "54045"
  },
  {
    "label": "McDowell",
    "value": "54047"
  },
  {
    "label": "Marion",
    "value": "54049"
  },
  {
    "label": "Marshall",
    "value": "54051"
  },
  {
    "label": "Mason",
    "value": "54053"
  },
  {
    "label": "Mineral",
    "value": "54055"
  },
  {
    "label": "Mingo",
    "value": "54057"
  },
  {
    "label": "Monongalia",
    "value": "54059"
  },
  {
    "label": "Monroe",
    "value": "54061"
  },
  {
    "label": "Nicholas",
    "value": "54063"
  },
  {
    "label": "Ohio",
    "value": "54065"
  },
  {
    "label": "Pendleton",
    "value": "54067"
  },
  {
    "label": "Pleasants",
    "value": "54069"
  },
  {
    "label": "Polk",
    "value": "54071"
  },
  {
    "label": "Putnam",
    "value": "54073"
  },
  {
    "label": "Raleigh",
    "value": "54075"
  },
  {
    "label": "Randolph",
    "value": "54077"
  },
  {
    "label": "Ritchie",
    "value": "54079"
  },
  {
    "label": "Roane",
    "value": "54081"
  },
  {
    "label": "Summers",
    "value": "54083"
  },
  {
    "label": "Taylor",
    "value": "54085"
  },
  {
    "label": "Tucker",
    "value": "54087"
  },
  {
    "label": "Tyler",
    "value": "54089"
  },
  {
    "label": "Upshur",
    "value": "54091"
  },
  {
    "label": "Wayne",
    "value": "54093"
  },
  {
    "label": "Webster",
    "value": "54095"
  },
  {
    "label": "Wetzel",
    "value": "54097"
  },
  {
    "label": "Wirt",
    "value": "54099"
  },
  {
    "label": "Wood",
    "value": "54101"
  }
]
,
"wi" :[
  {
    "label": "Adams",
    "value": "55001"
  },
  {
    "label": "Ashland",
    "value": "55003"
  },
  {
    "label": "Barron",
    "value": "55005"
  },
  {
    "label": "Bayfield",
    "value": "55007"
  },
  {
    "label": "Brown",
    "value": "55009"
  },
  {
    "label": "Buffalo",
    "value": "55011"
  },
  {
    "label": "Burnett",
    "value": "55013"
  },
  {
    "label": "Calumet",
    "value": "55015"
  },
  {
    "label": "Chippewa",
    "value": "55017"
  },
  {
    "label": "Clark",
    "value": "55019"
  },
  {
    "label": "Columbia",
    "value": "55021"
  },
  {
    "label": "Crawford",
    "value": "55023"
  },
  {
    "label": "Dane",
    "value": "55025"
  },
  {
    "label": "Dodge",
    "value": "55027"
  },
  {
    "label": "Door",
    "value": "55029"
  },
  {
    "label": "Douglas",
    "value": "55031"
  },
  {
    "label": "Dunn",
    "value": "55033"
  },
  {
    "label": "Eau Claire",
    "value": "55035"
  },
  {
    "label": "Florence",
    "value": "55037"
  },
  {
    "label": "Fond du Lac",
    "value": "55039"
  },
  {
    "label": "Forest",
    "value": "55041"
  },
  {
    "label": "Grant",
    "value": "55043"
  },
  {
    "label": "Green",
    "value": "55045"
  },
  {
    "label": "Green Lake",
    "value": "55047"
  },
  {
    "label": "Iowa",
    "value": "55049"
  },
  {
    "label": "Iron",
    "value": "55051"
  },
  {
    "label": "Jackson",
    "value": "55053"
  },
  {
    "label": "Jefferson",
    "value": "55055"
  },
  {
    "label": "Juneau",
    "value": "55057"
  },
  {
    "label": "Kenosha",
    "value": "55059"
  },
  {
    "label": "Kewaunee",
    "value": "55061"
  },
  {
    "label": "La Crosse",
    "value": "55063"
  },
  {
    "label": "Lafayette",
    "value": "55065"
  },
  {
    "label": "Langlade",
    "value": "55067"
  },
  {
    "label": "Lincoln",
    "value": "55069"
  },
  {
    "label": "Manitowoc",
    "value": "55071"
  },
  {
    "label": "Marathon",
    "value": "55073"
  },
  {
    "label": "Marinette",
    "value": "55075"
  },
  {
    "label": "Marquette",
    "value": "55077"
  },
  {
    "label": "Menominee",
    "value": "55079"
  },
  {
    "label": "Milwaukee",
    "value": "55081"
  },
  {
    "label": "Monroe",
    "value": "55083"
  },
  {
    "label": "Oconto",
    "value": "55085"
  },
  {
    "label": "Oneida",
    "value": "55087"
  },
  {
    "label": "Outagamie",
    "value": "55089"
  },
  {
    "label": "Ozaukee",
    "value": "55091"
  },
  {
    "label": "Pepin",
    "value": "55093"
  },
  {
    "label": "Pierce",
    "value": "55095"
  },
  {
    "label": "Polk",
    "value": "55097"
  },
  {
    "label": "Portage",
    "value": "55099"
  },
  {
    "label": "Price",
    "value": "55101"
  },
  {
    "label": "Racine",
    "value": "55103"
  },
  {
    "label": "Richland",
    "value": "55105"
  },
  {
    "label": "Rock",
    "value": "55107"
  },
  {
    "label": "Rusk",
    "value": "55109"
  },
  {
    "label": "Sauk",
    "value": "55111"
  },
  {
    "label": "Sawyer",
    "value": "55113"
  },
  {
    "label": "Shawano",
    "value": "55115"
  },
  {
    "label": "Sheboygan",
    "value": "55117"
  },
  {
    "label": "Taylor",
    "value": "55119"
  },
  {
    "label": "Trempealeau",
    "value": "55121"
  },
  {
    "label": "Vernon",
    "value": "55123"
  },
  {
    "label": "Walworth",
    "value": "55125"
  },
  {
    "label": "Washburn",
    "value": "55127"
  },
  {
    "label": "Washington",
    "value": "55129"
  },
  {
    "label": "Waukesha",
    "value": "55131"
  },
  {
    "label": "Waupaca",
    "value": "55133"
  },
  {
    "label": "Waushara",
    "value": "55135"
  },
  {
    "label": "Winnebago",
    "value": "55137"
  },
  {
    "label": "Wood",
    "value": "55139"
  }
]
,
"wy" : [
  {
    "label": "Albany",
    "value": "56001"
  },
  {
    "label": "Big Horn",
    "value": "56003"
  },
  {
    "label": "Campbell",
    "value": "56005"
  },
  {
    "label": "Carbon",
    "value": "56007"
  },
  {
    "label": "Converse",
    "value": "56009"
  },
  {
    "label": "Crook",
    "value": "56011"
  },
  {
    "label": "Fremont",
    "value": "56013"
  },
  {
    "label": "Goshen",
    "value": "56015"
  },
  {
    "label": "Hot Springs",
    "value": "56017"
  },
  {
    "label": "Johnson",
    "value": "56019"
  },
  {
    "label": "Laramie",
    "value": "56021"
  },
  {
    "label": "Lincoln",
    "value": "56023"
  },
  {
    "label": "Natrona",
    "value": "56025"
  },
  {
    "label": "Niobrara",
    "value": "56027"
  },
  {
    "label": "Park",
    "value": "56029"
  },
  {
    "label": "Platte",
    "value": "56031"
  },
  {
    "label": "Sheridan",
    "value": "56033"
  },
  {
    "label": "Sublette",
    "value": "56035"
  },
  {
    "label": "Sweetwater",
    "value": "56037"
  },
  {
    "label": "Teton",
    "value": "56039"
  },
  {
    "label": "Uinta",
    "value": "56041"
  },
  {
    "label": "Washakie",
    "value": "56043"
  },
  {
    "label": "Weston",
    "value": "56045"
  }
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
        $("#show_exp").show();

      } else {
        $("#chk").hide();
        $("#amnt").hide();
      }
      var total = 0;
      var exp_data1 = [];
      $('.su:checked').each(function() { // iterate through each checked element.

        total += isNaN(parseFloat($(this).val())) ? 0 : parseFloat($(this).val());
        actual = total.toFixed(2);
        //exp_data = $(this).data('element');
        exp_data2 = $(this).data('element');
       // exp_data1 = exp_data1.push(exp_data2);
        //alert($("#exp_id").attr('href'));
      });
      var exp_multi;
      exp_data1 =  exp_data2;

      var searchIDs = $(".su:checked").map(function(){
        exp_data1 = $(this).data('element');
      return exp_data1;
    }).get(); // <----
    console.log(searchIDs);
     //console.log(myJsonString);
      //exp_d = exp_data1[0];
      
      //alert(exp_multi);
      $("#total_val").text(actual);
      $("#quan").val(actual);
      $("#chk").val(searchIDs);

      //$("#show_exp").text(searchIDs);
      //$("#show_exp").text(exp_data1[1]);

    }
    function getPdf()
    {
      //alert($('#pd1').val());
      $('.su1:checked').each(function() {
    
      var actual = $(this).val();
      $("#pdc").val(actual);    
    });
  }

  
  </script>