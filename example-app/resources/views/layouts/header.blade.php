<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="robots" content="noindex,nofollow" />
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Propelyze</title>
    <link href="http://165.140.69.88/~plotplaza/realtor_zip/css/bootstrap.min.css" rel="stylesheet">
    <link href="http://165.140.69.88/~plotplaza/realtor_zip/css/font-awesome.min.css" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.3/themes/smoothness/jquery-ui.css">

    <!--link href="http://165.140.69.88/~plotplaza/realtor_zip/css/font-awesome.min.css" rel="stylesheet"-->
    <link href="{{ asset('css/global.css') }}" rel="stylesheet">
    <link href="{{ asset('css/contact.css') }}" rel="stylesheet">
    <link href="{{ asset('css/index.css') }}" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <!--link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans&display=swap" rel="stylesheet"-->
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://code.jquery.com/ui/1.13.3/jquery-ui.js"></script>

    <script src="https://cdn.datatables.net/2.1.3/js/dataTables.js"></script>

    <link href="https://cdn.datatables.net/2.1.3/css/dataTables.dataTables.css" rel="stylesheet">
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/gh/xcash/bootstrap-autocomplete@v2.3.7/dist/latest/bootstrap-autocomplete.min.js"></script>
</head>
<style>
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


<script type="text/javascript">
    /*var app_url = '{{ env("APP_URL") }}';
 var login_url = ''+app_url+'/login';
 var register_url = ''+app_url+'/register';
 var profile_url = ''+app_url+'/profile';
 //alert(login_url);

var token = localStorage.getItem('user_token2');
    /*if(window.location.pathname == login_url || window.location.pathname == register_url)
{
    if(token != null)
{
    window.open(profile_url,'_self');
}
$('.logout').hide();

}
else
{
    if(token == null)
{
    window.open(login_url,'_self');
}

}*/
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


        var radioButtons = $("input[type='radio'][name='sele_ac']");
        var radioStates = {};
        $.each(radioButtons, function(index, rd) {
            radioStates[rd.value] = $(rd).is(':checked');
        });

        radioButtons.click(function() {

            var val = $(this).val();
            $("#ac_sel").val(val);
            $(this).attr('checked', (radioStates[val] = !radioStates[val]));

            $.each(radioButtons, function(index, rd) {
                if (rd.value !== val) {
                    radioStates[rd.value] = false;
                }
            });
        });

        var APP_URL = "{{ url('') }}";
        var page_login_url = '' + APP_URL + '/login';

        ////////////////////agree ///////////////
        $(".reg").click(function() {
            $("#customCheck1").click(function() {
                //alert('chk')
                if ($(this).is(':checked')) {
                    $('.agree_err').text('');
                } else {
                    $('.agree_err').text('Please check agree and conditions');
                }
                $(".reg").attr("disabled", !this.checked);
            });
        });
        //////////////////////////
        /////////////datatable/////
        $('#show_pane').click(function() {
            $(".btn.icon").toggleClass("collapsed");
            var paneDiv = $(this).find("a").attr("href");
            $(paneDiv).toggle('1000');
        });
        /////////////////////

        //////////////////////////update///////////////////
        $("#profile_form").on('submit', function(event) {
            event.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                url: '{{ url("/api/profile-update") }}',
                type: "POST",
                data: formData,
                headers: {
                    'Authorization': localStorage.getItem('user_token2')
                },
                success: function(data) {
                    //console.log(data);
                    if (data.success == true) {
                        //alert(data.data.is_verified);
                        $('.result').text(data.message);
                        $('.error').text();
                        $('.email').text(data.data.email);
                        if (data.data.is_verified == 0) {
                            //alert(data.is_verified)
                            $('.verify').html('<button class="button verify_mail" data-id="' + data.data.email + '" style="border:none;" href="">Verify</button>');
                        } else {
                            $('.verify').html("Verified");
                        }

                    } else {
                        printErrorMsgLogin(data);
                        $('.error').text(data.message);
                        //alert(data.message);

                    }
                }
            });
        });

        /////////////////////////////
        $.ajax({
            url: '{{ url("/api/profile") }}',
            type: "GET",
            headers: {
                'Authorization': localStorage.getItem('user_token2')
            },
            success: function(data) {
                //console.log(data);
                if (data.status == true) {
                    //alert(data.user.is_verified);
                    //console.log(data.user);
                    $('.name').text(data.name);
                    $('.email').text(data.email);
                    //$('#phone').val(data.user.phone);
                    $('#name').val(data.name);
                    $('#email').val(data.email);
                    $('#user_id').val(data.user_id);
                    var cid = '<?php echo config('app.client_id'); ?>';
                    var cs = '<?php echo config('app.client_secret'); ?>';

                    if (data.is_verified == 0) {
                        $('.verify').html('<button class="button verify_mail" data-id="' + data.email + '" style="border:none;" href="">Verify</button>');
                    } else {
                        $('.verify').html("Verified");
                    }
                    /////////////authenticate
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
                    ////////////////

                } else {
                    //$('.verify').html("Verified");
                    alert(data.message);

                }
            },
            statusCode: {
                401: function(data) {
                    alert('Please relogin.Token Expired');
                    $('.error1').text('Please re-login.Token Expired');
                    localStorage.removeItem('user_token2');
                    localStorage.removeItem('api_token');
                    window.open(page_login_url, '_self');

                }
            }
        });
        ///verify email called /////
        $(document).on('click', '.verify_mail', function() {
            //alert('')
            var APP_URL = "{{ url('') }}";
            //alert(APP_URL);
            var emailVerify = $(this).attr('data-id');
            // alert(emailVerify);
            var page_url = '' + APP_URL + '/api/send-verify-mail/' + emailVerify + '';
            //alert(page_url);
            $.ajax({
                url: page_url,
                type: "GET",
                headers: {
                    'Authorization': localStorage.getItem('user_token2')
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

        //////////////////

        $('.logout').click(function() {

            var page_url = '' + APP_URL + '/login';
            $.ajax({
                url: '{{ url("/api/logout")}}',
                type: "POST",
                headers: {
                    'Authorization': localStorage.getItem('user_token2')
                },
                success: function(data) {
                    //console.log(data);
                    if (data.success == true) {
                        localStorage.removeItem('user_token2');
                        localStorage.removeItem('api_token');
                        window.open(page_url, '_self');

                        //window.open('http://165.140.69.88/~plotplaza/checkapi/example-app/public/login','_self');
                    } else {
                        alert(data.message);

                    }
                }
            });
        });
        $(document).on('click', '.abc', function(event) {
            alert('abc');
            $.ajax({
                url: "{{ url('/pdf') }}",
                type: "GET",
                headers: {
                    'Authorization': localStorage.getItem('user_token2')
                },
                success: function(data) {
                    //alert(url);
                    //alert(data);
                    console.log(data);
                    if (data) {}
                }
            });
        });
        //// pdf click

        ///////
        //alert(token);
        /*$('#login_id').on('submit', function(event) {
             event.preventDefault();

             //alert('123');
             var APP_URL = "{{ url('') }}";
             //alert(APP_URL);
             var page_url = '' + APP_URL + '/profile';
             //alert(test);
             var formdata = $(this).serialize();
             // alert(formdata);
             $.ajax({
                 url: '{{ url("/api/login") }}',
                 type: "POST",
                 data: formdata,
                 success: function(data) {
                     //alert(url);
                     //alert(data);
                     //console.log(data);
                     if (data.success == false) {
                         $('.incorrect').text(data.message);
                     } else if (data.success == true) {
                         //alert(data);
                         console.log(data);
                         $(".incorrect").text("");
                         $(".result").text(data.message);
                         localStorage.setItem("user_token2", data.token_type + " " + data.token);
                         //alert(data.token_type);
                         window.open(page_url, "_self");
                         //window.open('http://165.140.69.88/~plotplaza/checkapi/example-app/public/profile', "_self");
                     } else {
                         printErrorMsgLogin(data);
                     }
                     //alert(data);
                     //console.log(data);
                 },

             }); /////////////////login

         });

       
       
       
         $('#register').on('submit', function(event) {
            event.preventDefault();
            //alert('hi  hru');
            var formdata = $(this).serialize();
            $.ajax({
                url: "{{ url('api/register') }}",
                data: formdata,
                type: 'POST',
                success: function(data) {
                    //alert(data);
                    if (data.message) {
                        $("#register")[0].reset();
                        $(".error").text("");
                        $(".agree_err").text('');
                        $(".result").text(data.message);

                    } else {
                        //console.log(data)
                        //alert(data);
                        printErrorMsg(data);
                        $(".agree_err").text("Please check agree and conditions");
                    }
                },

            })
        });*/
        ////////////////////////////logout////////////////

        ////////////////////////////profile//////////////
        //////////////////////////////////research////////////////////
        $("#sale_search_form").submit(function(event) {
            event.preventDefault();
            var formData = $(this).serialize();
            //alert(formData.st);
            //var st_n = $("#st_n").val();
            var acr1 = $("#acr1").val();
            var acr2 = $("#acr2").val();
            var st = $("#st").val();
            var cp = $("#cp").val();
            var ac_sl = $("#ac_sel").val();
            //alert(ac_sl);
            var page_url = '' + APP_URL + '/login';
            myarray = [];

            //info = [0.01, 4.99, 9.99, 14.99, 20.99, 24.99, 30.00, 35.99, 40.99, 45.99, 50.99, 55.99, 60.99, 65.99, 70.99, 75.99, 80.99, 85.99, 90.99, 95.99, 99.99];

            var info = [];
            for (var i = 1; i < ac_sl; i++) {
                console.log(i);
                var numbers = i;
                info.push(numbers);
            }
            //info = [0,5,10];
            for (var i = 0; i < info.length; i++) {
                $.ajax({
                    url: 'https://dtapiuat.datatree.com/api/Report/GetReport?Ver=1.0',
                    type: "POST",

                    data: {
                        "ProductNames": [
                            "SalesComparables",
                            "TotalViewReport"
                        ],
                        "SearchType": "Filter",

                        "SearchRequest": {
                            "ReferenceId": "1",
                            "ProductName": "SearchLite",
                            "MaxReturn": "1",
                            "Filters": [{
                                "FilterName": "StateFips",
                                "FilterOperator": "is",
                                "FilterValues": [
                                    st
                                ],
                                "FilterGroup": 1
                            }, {
                                "FilterName": "LotAcreage",
                                "FilterOperator": "is between",
                                "FilterValues": [
                                    info[i],
                                    info[i + 1]
                                ]
                            }, {

                                "FilterName": "SalePrice",

                                "FilterOperator": "is between",

                                "FilterValues": ["1", "10000000"],

                                "FilterGroup": 1

                            }]
                        }
                    },
                    headers: {
                        'Authorization': localStorage.getItem('api_token')
                    },
                    success: function(data1) {
                        //alert('111')
                        console.log("abc" + data1);
                        if (data1) {
                            //console.log(data);
                            $('.error').text('');
                            //myarray = JSON.stringify(data.Reports);
                            myarray["data1"] = data1;
                            var apn = data1.LitePropertyList[0].Apn;
                            myarray["data1"]["state"] = data1.LitePropertyList[0].State;
                            myarray["data1"]["county"] = data1.LitePropertyList[0].County;
                            myarray["data1"]["maxcount"] = data1.MaxResultsCount;
                            myarray["data1"]["info"] = info.shift();



                            buildTable(myarray);
                            //new DataTable('#myDataTable');
                            $("#myDataTable").DataTable();
                            //$("#mytable").show();
                        }
                        //dosri
                    },
                    statusCode: {
                        400: function(data1) {
                            //alert( "page not found" );
                            console.log(data1.responseText);
                            $(".error").text(data1.responseJSON.Message);

                        },
                        401: function(data) {
                            alert("unauthorized");
                            //console.log(data.responseText);
                            $(".error").text("Please Re-login.Token is expired");

                        },
                        405: function(data) {
                            //alert('Please relogin.Token Expired');
                            $(".error").text(data.message);
                            //window.open(page_url, "_self");
                        }


                    } ///main ajax success

                });
            } /////forloop                       

        }); ///////click

        //////////////////////////////////research////////////////////
        $("#sale_search_form2").submit(function(event) {
            event.preventDefault();
            var formData = $(this).serialize();
            //alert(formData.st);
            var st_n = $("#st_n").val();
            var st_nm = $("#st_nm").val();
            var st = $("#st").val();
            var cp = $("#cp").val();
            var page_url = '' + APP_URL + '/login';
            myarray = [];

            $.ajax({
                url: 'https://dtapiuat.datatree.com/api/Report/GetReport?Ver=1.0',
                type: "POST",

                data: {
                    ProductNames: [
                        "SalesComparables",

                    ],
                    SearchType: "ADDRESS",
                    AddressDetail: {
                        StreetNumber: st_nm,
                        StreetNames: st_n,
                        City: "",
                        ZipCode: "",
                        StateFips: st,
                        CountyFips: cp
                    }
                },
                headers: {
                    'Authorization': localStorage.getItem('api_token')
                },
                success: function(data) {
                    //alert('111')
                    console.log("abc" + data.StatusDescription);
                    if (data) {
                        console.log(data.Reports[0].Data.ComparableProperties);
                        $('.error').text('');
                        //myarray = JSON.stringify(data.Reports);
                        myarray = data.Reports[0].Data.ComparableProperties;
                        console.log(myarray);
                        //alert(data);
                        buildTable(myarray);
                        $("#myDataTable").DataTable();
                    }
                },
                statusCode: {
                    400: function(data) {
                        //alert( "page not found" );
                        console.log(data.responseText);
                        $(".error").text(data.responseJSON.Message);
                        //alert(data);
                        //printErrorMsg(data)
                    },
                    401: function() {
                        alert("unauthorized");
                        //console.log(data.responseText);
                        $(".error").text("Please Re-login.Token is expired");

                        //alert(data);
                        //printErrorMsg(data)
                    },
                    405: function(data) {
                        //alert('Please relogin.Token Expired');
                        $(".error").text(data.message);
                        //window.open(page_url, "_self");
                    }

                } ///main ajax success

            });

        });

        /////////////////
        //////////////////////comp report ////////////////
        /*$("#compreport_search_form").submit(function(event) {
            event.preventDefault();
            //alert(formData.st);
            var apn = $("#apn").val();
            //alert(apn);

            var page_url = '' + APP_URL + '/login';
            myarray = [];

            $.ajax({
                url: 'https://dtapiuat.datatree.com/api/Report/GetReport',
                type: "POST",
                data: {

                    "ProductNames": [
                        "PropertyDetailReport"
                    ],
                    "SearchType": "Filter",
                    "SearchRequest": {
                        "ReferenceId": "1",
                        "ProductName": "SearchLite",
                        "MaxReturn": "1",
                        "Filters": [{
                            "FilterName": "ApnRange",
                            "FilterOperator": "starts with",
                            "FilterValues": [
                                apn
                            ]
                        }]
                    }

                },
                headers: {
                    'Authorization': localStorage.getItem('api_token')
                    //'Authorization':'Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJVc2VySUQiOiIxNTczNDkiLCJBY2NvdW50SUQiOiIyMDEwNTE0IiwiVXNlck5hbWUiOiJEVEFQSV9wcm9wZWx5emVfVUFUIiwiTmFtZSI6IkZhcmhhbiBCYWtodCIsIlVzZXJFbWFpbCI6InByb3BlbHl6ZUBnbWFpbC5jb20iLCJJU1JlZmVyZW5jZVJlcXVpcmVkIjoiMCIsIkFjY291bnRUeXBlIjoiMCIsIk9BdXRoVG9rZW4iOiJleUowZVhBaU9pSktWMVFpTENKaGJHY2lPaUpTVXpJMU5pSXNJbXRwWkNJNklrdFJNblJCWTNKRk4yeENZVlpXUjBKdFl6VkdiMkpuWkVwdk5DSjkuZXlKaGRXUWlPaUl6TkRFMVltTTJNaTFtT1RCaUxUUmhaR0l0T0dGa01DMDJaakZsTlRZMU5tWXlaakFpTENKcGMzTWlPaUpvZEhSd2N6b3ZMMnh2WjJsdUxtMXBZM0p2YzI5bWRHOXViR2x1WlM1amIyMHZOR05qTmpWbVpEWXRPV00zTmkwME9EY3hMV0UxTkRJdFpXSXhNbUUxWVRjNE1EQmpMM1l5TGpBaUxDSnBZWFFpT2pFM01qUXhOelV3T0Rrc0ltNWlaaUk2TVRjeU5ERTNOVEE0T1N3aVpYaHdJam94TnpJME1UYzRPVGc1TENKaGFXOGlPaUpCVTFGQk1pODRXRUZCUVVFNFQwTkRjWFprTW1sMVRWVkxOV3hXTUdkcVRreGFUVkZrZG5sWVJYQlhWM3BHUjA1MVYxVTRZazh3UFNJc0ltRjZjQ0k2SW1NMllUZzRNbVV4TFRneVl6Y3RORFUwWkMwNU1EVTVMVGRpTVdFNFlqWmpZVEV4TVNJc0ltRjZjR0ZqY2lJNklqRWlMQ0p2YVdRaU9pSmpPR1ZpT0dOaU9DMHlOems0TFRRek9UY3RPREF3WWkwNFpUUTNOalJsTXpKaU1HWWlMQ0p5YUNJNklqQXVRVkV3UVRGc1gwZFVTR0ZqWTFWcGJGRjFjMU53WVdWQlJFZExPRVpVVVV3dFpIUkxhWFJDZGtoc1dsYzRka0ZPUVVGQkxpSXNJbkp2YkdWeklqcGJJa0ZRU1VGalkyVnpjeUpkTENKemRXSWlPaUpqT0dWaU9HTmlPQzB5TnprNExUUXpPVGN0T0RBd1lpMDRaVFEzTmpSbE16SmlNR1lpTENKMGFXUWlPaUkwWTJNMk5XWmtOaTA1WXpjMkxUUTROekV0WVRVME1pMWxZakV5WVRWaE56Z3dNR01pTENKMWRHa2lPaUprWkRVNFFrVm9TV2hyVjFrMVVucFBlWEo1TVVGQklpd2lkbVZ5SWpvaU1pNHdJaXdpWVhCd1JHRjBZU0k2SW50Y0luVnBaRndpT2pFMU56TTBPU3hjSW1GcFpGd2lPakl3TVRBMU1UUjlJbjAuTTZ0Yk9KTW92OTNUUkI5TUNJZ3o0U2tyTFVwUzE5UnJ4Q0FjczJYNU5TNW1IVDJvNm0xRGdlSDdCaExlZEhvZFBBV3N0azhvUjJnc0tSbm5LNjVDQWI0aDVPZ2k4b1UwLThZLTNONDFta2RkTWVCbUZ0TXI1SGcyazJDRXpkcEgtSU1JY2V2NmZRTW5oY1JweEdNSVY0STloMGItMlRTWWsxbTVxc21MUUF2WFR6bnNrR1ctT3pmQnE1LUJUbU1IZGh0bEtsU3ZwaDhReU80ZmNwZVZDUGxicm1ZVlBMSG5XQU5IeG1jVHBHQmZlWHpqZ2ZoMVhSSTZTcmVhVmhNOFU5OVVlSGViNUR0dG10a0dfV0dEVGlXbmE5eGtUWkxJeUtKOUt6alZwajVpa3UxNDdnSk5GVXlfRk9OTkp2UWhiSXZzOTRXUVRTd0xzQ3p6UVJxWTBBIiwiQXZhaWxhYmxlUHJvZHVjdHMiOiJbXCIxMDA4XCIsXCIxMDUzXCIsXCIxMDA1XCIsXCIxMDExXCIsXCIyMDg5XCIsXCIxMDI2XCIsXCIxMDI3XCIsXCIxMDI4XCIsXCI1MDAwXCIsXCI1MDAxXCIsXCI1MDAzXCIsXCIyMDAwXCIsXCIyMDAxXCIsXCIyMDAyXCIsXCIyMDAzXCIsXCIyMDA0XCIsXCIyMDA1XCJdIiwibmJmIjoxNzI0MTc1MzkwLCJleHAiOjE3MjQxODI1OTAsImlhdCI6MTcyNDE3NTM5MCwiaXNzIjoiaHR0cHM6Ly9kdGFwaXVhdC5kYXRhdHJlZS5jb20iLCJhdWQiOiJXZWJBcGlDb25zdW1lcnMifQ.MIEqprEnvlMvuMLA3p-Fc5ugz_soUoXpOg8uMbGDxQM',
                },
                success: function(data) {

                    if (data) {
                        console.log(data);
                        console.log(data.Reports[0].Data);
                        $('.error').text('');
                        //myarray = JSON.stringify(data.Reports);
                        myarray = data.Reports[0].Data;
                        $(".pid").val(data.Reports[0].PropertyId);
                        console.log(myarray);
                        //alert(data);
                        buildTable2(myarray);
                        $("#myDataTable2").DataTable();
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
                        $(".error").text("Please Re-login.Token is expired");
                        window.open(page_url, "_self");

                    },

                } ///main ajax success

            });

        });*/

        ///////////////////////////////////////////////
        //////////////////////comp2
        $("#pricehouse_search_form").submit(function(event) {
            event.preventDefault();
            var formData = $(this).serialize();
            $('#mytable3').html();
            var st = $("#st").val();
            var cp = $("#cp").val();
            var page_url = '' + APP_URL + '/login';
            myarray = [];

            $.ajax({
                url: 'https://dtapiuat.datatree.com/api/Report/GetReport?Ver=1.0',

                type: "POST",
                data: {
                    ProductNames: [
                        "PropertyDetailReport"
                    ],
                    SearchType: "Filter",
                    SearchRequest: {
                        ReferenceId: "1",
                        ProductName: "SearchLite",
                        MaxReturn: "1",
                        Filters: [{
                                FilterName: "StateFips",
                                FilterOperator: "is",
                                FilterValues: [
                                    st
                                ],
                                FilterGroup: 0
                            },
                            {
                                FilterName: "CountyFips",
                                FilterOperator: "is",
                                FilterValues: [
                                    cp
                                ],
                                FilterGroup: 0
                            }
                        ]
                    }
                },

                headers: {
                    'Authorization': localStorage.getItem('api_token')
                },
                success: function(data) {

                    if (data) {
                        console.log(data);
                        console.log(data.LitePropertyList);

                        myarray = data.LitePropertyList;

                        buildTable3(myarray);
                        $("#myDataTable3").DataTable();
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
                        //console.log(data.responseText);
                        $(".error").text("Please Re-login.Token is expired");
                        window.open(page_url, "_self");

                    },

                } ///main ajax success

            });

        });
        ////////////////////////////
        //////////////////////////priceland
       /* $("#priceland_search_form").submit(function(event) {
            event.preventDefault();
            var dataArray = $(this).serializeArray(),
                dataObj = {};

            $(dataArray).each(function(i, field) {
                dataObj[field.name] = field.value;
            });
            //alert(dataObj['cp']);
            //var st_n = $("#st_n").val();
            var acr1 = $("#acr1").val();

            var ac = $("#autocomplete").val();
            var newarr = [];
            if (ac == 'ca') {
                st = 6;
            }
            if (ac == 'al') {
                st = 1;
            }
            if (ac == 'ak') {
                st = 2;
            }
            if (ac == 'az') {
                st = 4;
            }
            if (ac == 'ar') {
                st = 5;
            }
            if (ac == 'co') {
                st = 8;
            }
            if (ac == 'ct') {
                st = 9;
            }
            if (ac == 'de') {
                st = 10;
            }
            if (ac == 'dc') {
                st = 11;
            }
            if (ac == 'fl') {
                st = 12;
            }
            //newarr['ca'] = 6
            //alert(newarr[st]);
            var acr2 = $("#acr2").val();
            //var st = $("#st").val();
            var cp = dataObj['cp'];
            //alert(acr1);
            var page_url = '' + APP_URL + '/login';
            myarray = [];
            myarray2 = [];
            var info = [];
            info = [acr1, acr2];

            //info = [0.01, 4.99, 9.99, 14.99, 20.99, 24.99, 30.00, 35.99, 40.99, 45.99, 50.99, 55.99, 60.99, 65.99, 70.99, 75.99, 80.99, 85.99, 90.99, 95.99, 99.99];

            for (var i = 0; i < info.length; i++) {

                $.ajax({
                    url: 'https://dtapiuat.datatree.com/api/Report/GetReport?Ver=1.0',
                    type: "POST",

                    data: {
                        "ProductNames": [
                            "SalesComparables"
                        ],
                        "SearchType": "Filter",

                        "SearchRequest": {
                            "ReferenceId": "1",
                            "ProductName": "SearchLite",
                            "MaxReturn": "1",
                            "Filters": [
                                /*{

                                                                    "FilterName": "SaleDate",

                                                                    "FilterOperator": "is between",

                                                                    "FilterValues": ["04/01/1900", "04/23/2024"],

                                                                    "FilterGroup": 1

                                                                },*/
                                /*{
                                    "FilterName": "LotAcreage",
                                    "FilterOperator": "is between",
                                    "FilterValues": [
                                        info[i],
                                        info[i + 1]
                                    ]
                                },
                                {
                                    "FilterName": "StateFips",
                                    "FilterOperator": "is",
                                    "FilterValues": [
                                        st
                                    ],
                                    "FilterGroup": 1
                                },
                                {
                                    "FilterName": "CountyFips",
                                    "FilterOperator": "is",
                                    "FilterValues": [
                                        cp
                                    ],
                                    "FilterGroup": 1
                                },
                                {
                                    "FilterName": "SalePrice",

                                    "FilterOperator": "is between",

                                    "FilterValues": ["1", "10000000"],

                                    "FilterGroup": 1

                                },
                                {

                                    "FilterName": "YearBuilt",

                                    "FilterOperator": "is between",

                                    "FilterValues": ["1800", "2024"],

                                    "FilterGroup": 1

                                },

                                {

                                    "FilterName": "ForSaleListedPrice",

                                    "FilterOperator": "is between",

                                    "FilterValues": ["1", "10000000"],

                                    "FilterGroup": 1

                                }, {

                                    "FilterName": "TotalNumberOfBedrooms",

                                    "FilterOperator": "is between",

                                    "FilterValues": ["1", "2"],

                                    "FilterGroup": 1

                                }, {

                                    "FilterName": "TotalNumberOfbathrooms",

                                    "FilterOperator": "is",

                                    "FilterValues": ["1"],

                                    "FilterGroup": 1

                                },
                                /*{

                                                                   "FilterName": "BuildingAreaSquarefeet",

                                                                   "FilterOperator": "is between",

                                                                   "FilterValues": ["138", "2625"],

                                                                   "FilterGroup": 1

                                                               },*/

                            /*] //
                        } //
                    },
                    headers: {
                        'Authorization': localStorage.getItem('api_token')
                    },
                    success: function(data1) {
                        //alert('111')
                        //console.log("abc" + data.StatusDescription);
                        if (data1) {
                            //console.log(data);
                            $('.error').text('');
                            //myarray = JSON.stringify(data.Reports);
                            myarray["data1"] = data1;
                            var apn = data1.LitePropertyList[0].Apn;
                            myarray["data1"]["state"] = data1.LitePropertyList[0].State;
                            myarray["data1"]["county"] = data1.LitePropertyList[0].County;
                            myarray["data1"]["maxcount"] = data1.MaxResultsCount;
                            myarray["data1"]["info"] = info.shift();

                            buildTable4(myarray);
                            $("#myDataTable4").DataTable();
                            //$("#mytable").show();
                        }
                        //dosri
                    },
                    statusCode: {
                        400: function(data1) {
                            //alert( "page not found" );
                            console.log(data1.responseText);
                            $(".error").text(data1.responseJSON.Message);

                        },
                        401: function(data) {
                            alert("unauthorized");
                            //console.log(data.responseText);
                            $(".error").text("Please Re-login.Token is expired");

                        },
                        405: function(data) {
                            //alert('Please relogin.Token Expired');
                            $(".error").text(data.message);
                            //window.open(page_url, "_self");
                        }


                    } ///main ajax success

                });
            } /////forloop                       

        /*});*/ ///////click


        /////////////////////////////div click//////////////
        $("#map_id").click(function() {
            $('html,body').animate({
                    scrollTop: $(".map").offset().top
                },
                'slow');
        });
    });

    function printErrorMsgLogin(message) {
        //alert(message);
        $(".error").text("");
        $.each(message, function(key, value) {
            $("." + key + "_err").text(value);

        });
    }

    function printErrorMsg(message) {
        //alert(message);
        $(".error").text("");

        $.each(message, function(key, value) {

            if (key == 'password') {
                if (value.length > 1) {
                    $(".password_err").text(value[0]);
                    $(".password_confirmation_err").text(value[1]);

                } else {
                    if (value[0].includes('password confirmation')) {
                        $(".password_confirmation_err").text(value);

                    } else {
                        $(".password_err").text(value);

                    }

                }

            } else {
                $("." + key + "_err").text(value);

            }

        });

    }

    function buildTable(data) {
        //alert(data[0].data1.maxcount);

        //var row = 0;
        //var i = 0;
        var table = document.getElementById('mytable');
        //for (var i = 0; i < data.length; i++) {
        var mainval = data.data1.maxcount * 0.01;

        var row = `<tr>
            <td>${data.data1.maxcount}</td>
             <td>${data.data1.info}</td>
            <td>${data.data1.state}</td>
            <td>${data.data1.county}</td>
             <td>$20000-400000</td>
            <td><input type='checkbox' id='sm' onclick=toggle(${data.data1.maxcount}); class='su' value=${mainval} name='sum[]' style='border:14px solid green;width:30px;height:30px;'></td>
        </tr>`
        table.innerHTML += row;
        // }
    }

    function buildTable3(data) {
        var table = document.getElementById('mytable3');
        var maxcount = 1;
        var mainval = maxcount * 0.01;
        table.innerHTML = "";
        for (var i = 0; i < data.length; i++) {
            var row = `<tr>
            <td>${[i+1]}</td>
        <!--td>${data[i].PropertyId}</td-->
        <td>${data[i].County}</td>
        <td>${data[i].City}</td>
         <td>${data[i].State}</td>
         <td>${data[i].Owner}</td>
         <td>${data[i].Address}</td>
         <td>${data[i].Apn}</td>
         <td>${data[i].Zip}</td>
        <td><input type='checkbox' id='sm' onclick=toggle(${maxcount}); class='su' value=${mainval} name='sum[]' style='border:14px solid green;width:30px;height:30px;'></td>
      
        </tr>`
            table.innerHTML += row;
        }

    }

    function buildTable4(data) {
        var row = 0;
        var i = 0;
        var table = document.getElementById('mytable4');

        var mainval = data.data1.maxcount * 0.01;
        var row = `<tr>
            <td>${data.data1.maxcount}</td>
             <td>${data.data1.info}</td>
            <td>${data.data1.state}</td>
            <td>${data.data1.county}</td>
             <td>$20000-10000000</td>
            <td><input type='checkbox' id='sm' onclick=toggle(${data.data1.maxcount}); class='su' value=${mainval} name='sum[]' style='border:14px solid green;width:30px;height:30px;'></td>
        </tr>`
        table.innerHTML += row;

    }


    function buildTable2(data) {
        var table = document.getElementById('mytable2');
        var pid = data.SubjectProperty.PropertyId;
        var maxcount = 1;
        var mainval = maxcount * 0.02;
        var APP_URL = "{{ url('') }}";
        //alert(APP_URL);
        // alert(emailVerify);
        var page_url = '' + APP_URL + '/pdf/' + pid + '';
        var row = `<tr>
        <!--td>${data.SubjectProperty.PropertyId}</td-->
        <td>${data.SubjectProperty.SitusAddress.StreetAddress}</td>  
        <td>${data.SubjectProperty.SitusAddress.City}</td>
        <td>${data.SubjectProperty.SitusAddress.State}</td> 
        <td>${data.OwnerInformation.Owner1FullName }</td>
         <td>${data.SiteInformation.Zoning }</td> 
          <td>${data.SiteInformation.CountyUse }</td> 
           <td>${data.SiteInformation.Acres }</td> 
            <td>$${data.TaxInformation.AssessedValue }</td>
        <td><input type='checkbox' id='sm' onclick=toggle(${maxcount}); class='su' value=${mainval} name='sum[]' style='border:14px solid green;width:30px;height:30px;'></td>
 
            <td><a href=${page_url}>Download</a></td>
        </tr>`
        table.innerHTML += row;

    }

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