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

    <!--link href="http://165.140.69.88/~plotplaza/realtor_zip/css/font-awesome.min.css" rel="stylesheet"-->
    <link href="{{ asset('css/global.css') }}" rel="stylesheet">
    <link href="{{ asset('css/contact.css') }}" rel="stylesheet">
    <link href="{{ asset('css/index.css') }}" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>

    <script src="https://cdn.datatables.net/2.1.3/js/dataTables.js"></script>

    <link href="https://cdn.datatables.net/2.1.3/css/dataTables.dataTables.css" rel="stylesheet">
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/gh/xcash/bootstrap-autocomplete@v2.3.7/dist/latest/bootstrap-autocomplete.min.js"></script>
</head>
<style>

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

        var APP_URL = "{{ url('') }}";
        var page_login_url = '' + APP_URL + '/login';

        $.noConflict();
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
                    //alert(cid);
                    //localStorage.removeItem('user_token');
                    //window.open('/login','_self');
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

        //alert(token);
        $('#login_id').on('submit', function(event) {
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
        });
        ////////////////////////////logout////////////////

        ////////////////////////////profile//////////////
        //////////////////////////////////research////////////////////
        $("#sale_search_form").submit(function(event) {
            event.preventDefault();
            var formData = $(this).serialize();
            //alert(formData.st);
            var st_n = $("#st_n").val();
            var st_nm = $("#st_nm").val();
            var st = $("#st").val();
            var cp = $("#cp").val();
            var page_url = '' + APP_URL + '/login';
            myarray = [];

            //alert(localStorage.getItem('api_token'));
            //alert(formD.Filters);
            $.ajax({
                url: 'https://dtapiuat.datatree.com/api/Report/GetReport?Ver=1.0',
                type: "POST",
                /*data: {
                    CountOnly: t,
                    MaxReturn: max,
                    ProductName: product,
                    SpatialType: sp,
                    Filters: [{FilterName: 'StateFips',
                        FilterOperator: 'is',
                        FilterValues: ['46'],
                        FilterGroup: 0
                    }]
                },*/
                data: {
                    ProductNames: [
                        //"PropertyDetailReport",
                        "SalesComparables",
                        //"TotalViewReport",
                        //"ForeclosureReport",
                        //"PropertyListingReport"
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


        //////////////////////////////////////////
        //////////////////////comp report ////////////////

        $("#compreport_search_form").submit(function(event) {
            event.preventDefault();
            var formData = $(this).serialize();
            //alert(formData.st);
            var apn = $("#apn").val();
            //alert(apn);
            var st_n = $("#st_n").val();
            var st_nm = $("#st_nm").val();
            var st = $("#st").val();
            var cp = $("#cp").val();
            var page_url = '' + APP_URL + '/login';
            myarray = [];

            //alert(localStorage.getItem('api_token'));
            //alert(formD.Filters);
            $.ajax({
                url: 'https://dtapiuat.datatree.com/api/Report/GetReport',
                type: "POST",
                data: {
                    ProductNames: [
                        "PropertyDetailReport"
                    ],
                    SearchType: "ADDRESS",
                    AddressDetail: {
                        StreetNumber: st_nm,
                        StreetNames: st_n,
                        City: "",
                        ZipCode: "",
                        StateFips: st,
                        CountyFips: cp
                    },
                    IncludeFilelink: true
                },
                headers: {
                    'Authorization': localStorage.getItem('api_token')
                    //'Authorization':'Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJVc2VySUQiOiIxNTczNDkiLCJBY2NvdW50SUQiOiIyMDEwNTE0IiwiVXNlck5hbWUiOiJEVEFQSV9wcm9wZWx5emVfVUFUIiwiTmFtZSI6IkZhcmhhbiBCYWtodCIsIlVzZXJFbWFpbCI6InByb3BlbHl6ZUBnbWFpbC5jb20iLCJJU1JlZmVyZW5jZVJlcXVpcmVkIjoiMCIsIkFjY291bnRUeXBlIjoiMCIsIk9BdXRoVG9rZW4iOiJleUowZVhBaU9pSktWMVFpTENKaGJHY2lPaUpTVXpJMU5pSXNJbXRwWkNJNklrdFJNblJCWTNKRk4yeENZVlpXUjBKdFl6VkdiMkpuWkVwdk5DSjkuZXlKaGRXUWlPaUl6TkRFMVltTTJNaTFtT1RCaUxUUmhaR0l0T0dGa01DMDJaakZsTlRZMU5tWXlaakFpTENKcGMzTWlPaUpvZEhSd2N6b3ZMMnh2WjJsdUxtMXBZM0p2YzI5bWRHOXViR2x1WlM1amIyMHZOR05qTmpWbVpEWXRPV00zTmkwME9EY3hMV0UxTkRJdFpXSXhNbUUxWVRjNE1EQmpMM1l5TGpBaUxDSnBZWFFpT2pFM01qUXhOelV3T0Rrc0ltNWlaaUk2TVRjeU5ERTNOVEE0T1N3aVpYaHdJam94TnpJME1UYzRPVGc1TENKaGFXOGlPaUpCVTFGQk1pODRXRUZCUVVFNFQwTkRjWFprTW1sMVRWVkxOV3hXTUdkcVRreGFUVkZrZG5sWVJYQlhWM3BHUjA1MVYxVTRZazh3UFNJc0ltRjZjQ0k2SW1NMllUZzRNbVV4TFRneVl6Y3RORFUwWkMwNU1EVTVMVGRpTVdFNFlqWmpZVEV4TVNJc0ltRjZjR0ZqY2lJNklqRWlMQ0p2YVdRaU9pSmpPR1ZpT0dOaU9DMHlOems0TFRRek9UY3RPREF3WWkwNFpUUTNOalJsTXpKaU1HWWlMQ0p5YUNJNklqQXVRVkV3UVRGc1gwZFVTR0ZqWTFWcGJGRjFjMU53WVdWQlJFZExPRVpVVVV3dFpIUkxhWFJDZGtoc1dsYzRka0ZPUVVGQkxpSXNJbkp2YkdWeklqcGJJa0ZRU1VGalkyVnpjeUpkTENKemRXSWlPaUpqT0dWaU9HTmlPQzB5TnprNExUUXpPVGN0T0RBd1lpMDRaVFEzTmpSbE16SmlNR1lpTENKMGFXUWlPaUkwWTJNMk5XWmtOaTA1WXpjMkxUUTROekV0WVRVME1pMWxZakV5WVRWaE56Z3dNR01pTENKMWRHa2lPaUprWkRVNFFrVm9TV2hyVjFrMVVucFBlWEo1TVVGQklpd2lkbVZ5SWpvaU1pNHdJaXdpWVhCd1JHRjBZU0k2SW50Y0luVnBaRndpT2pFMU56TTBPU3hjSW1GcFpGd2lPakl3TVRBMU1UUjlJbjAuTTZ0Yk9KTW92OTNUUkI5TUNJZ3o0U2tyTFVwUzE5UnJ4Q0FjczJYNU5TNW1IVDJvNm0xRGdlSDdCaExlZEhvZFBBV3N0azhvUjJnc0tSbm5LNjVDQWI0aDVPZ2k4b1UwLThZLTNONDFta2RkTWVCbUZ0TXI1SGcyazJDRXpkcEgtSU1JY2V2NmZRTW5oY1JweEdNSVY0STloMGItMlRTWWsxbTVxc21MUUF2WFR6bnNrR1ctT3pmQnE1LUJUbU1IZGh0bEtsU3ZwaDhReU80ZmNwZVZDUGxicm1ZVlBMSG5XQU5IeG1jVHBHQmZlWHpqZ2ZoMVhSSTZTcmVhVmhNOFU5OVVlSGViNUR0dG10a0dfV0dEVGlXbmE5eGtUWkxJeUtKOUt6alZwajVpa3UxNDdnSk5GVXlfRk9OTkp2UWhiSXZzOTRXUVRTd0xzQ3p6UVJxWTBBIiwiQXZhaWxhYmxlUHJvZHVjdHMiOiJbXCIxMDA4XCIsXCIxMDUzXCIsXCIxMDA1XCIsXCIxMDExXCIsXCIyMDg5XCIsXCIxMDI2XCIsXCIxMDI3XCIsXCIxMDI4XCIsXCI1MDAwXCIsXCI1MDAxXCIsXCI1MDAzXCIsXCIyMDAwXCIsXCIyMDAxXCIsXCIyMDAyXCIsXCIyMDAzXCIsXCIyMDA0XCIsXCIyMDA1XCJdIiwibmJmIjoxNzI0MTc1MzkwLCJleHAiOjE3MjQxODI1OTAsImlhdCI6MTcyNDE3NTM5MCwiaXNzIjoiaHR0cHM6Ly9kdGFwaXVhdC5kYXRhdHJlZS5jb20iLCJhdWQiOiJXZWJBcGlDb25zdW1lcnMifQ.MIEqprEnvlMvuMLA3p-Fc5ugz_soUoXpOg8uMbGDxQM',
                },
                success: function(data) {
                    //alert('111')
                    //console.log("abc" + data.StatusDescription);
                    if (data) {
                        console.log(data);
                        console.log(data.Reports[0].Data);
                        $('.error').text('');
                        //myarray = JSON.stringify(data.Reports);
                        myarray = data.Reports[0].Data;
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
                        //alert(data);
                        //printErrorMsg(data)
                    },
                    401: function() {
                        alert("unauthorized");
                        //console.log(data.responseText);
                        $(".error").text("Please Re-login.Token is expired");
                        window.open(page_url, "_self");
                        //alert(data);
                        //printErrorMsg(data)
                    },

                } ///main ajax success

            });

        });

        ///////////////////////////////////////////////
        //////////////////////comp2
        $("#pricehouse_search_form").submit(function(event) {
            event.preventDefault();
            var formData = $(this).serialize();
            $('#mytable3').html();
            var st = $("#st").val();
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
                        }]
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
        $("#compreport2_search_form").submit(function(event) {
            event.preventDefault();
            var formData = $(this).serialize();
            //alert(formData.st);

            var st = $("#st").val();
            var ap = '5629-014-017';
            var page_url = '' + APP_URL + '/login';
            myarray = [];

            $.ajax({
                //url: 'https://dtapiuat.datatree.com/api/Report/GetReport?Ver=1.0',
                url: 'https://dtapiuat.datatree.com/api/Report/GetReport?Ver=1.0',

                type: "POST",
                data: {
  
  "ProductNames": [
    "SalesComparables"
  ],
  "SearchType": "PROPERTY",
  "PropertyId": '8948416',
  "SalesCompSettings": {
    "CompsMaxNumber": 25
  }

},
        /*data: {
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
                }]
            }
        },
        /*data: {
            ProductNames: [
                "TotalViewReport"
            ],
            SearchType: "ADDRESS",
            AddressDetail: {
                StreetNumber: st_nm,
                StreetNames: st_n,
                City: "",
                ZipCode: "",
                StateFips: st,
                CountyFips: cp
            },
            IncludeFilelink: true
        },*/
        headers: {
                    //'Content-type': 'application/json',
                    'Authorization': localStorage.getItem('api_token')
                    //'Authorization':'Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJVc2VySUQiOiIxNTczNDkiLCJBY2NvdW50SUQiOiIyMDEwNTE0IiwiVXNlck5hbWUiOiJEVEFQSV9wcm9wZWx5emVfVUFUIiwiTmFtZSI6IkZhcmhhbiBCYWtodCIsIlVzZXJFbWFpbCI6InByb3BlbHl6ZUBnbWFpbC5jb20iLCJJU1JlZmVyZW5jZVJlcXVpcmVkIjoiMCIsIkFjY291bnRUeXBlIjoiMCIsIk9BdXRoVG9rZW4iOiJleUowZVhBaU9pSktWMVFpTENKaGJHY2lPaUpTVXpJMU5pSXNJbXRwWkNJNklrdFJNblJCWTNKRk4yeENZVlpXUjBKdFl6VkdiMkpuWkVwdk5DSjkuZXlKaGRXUWlPaUl6TkRFMVltTTJNaTFtT1RCaUxUUmhaR0l0T0dGa01DMDJaakZsTlRZMU5tWXlaakFpTENKcGMzTWlPaUpvZEhSd2N6b3ZMMnh2WjJsdUxtMXBZM0p2YzI5bWRHOXViR2x1WlM1amIyMHZOR05qTmpWbVpEWXRPV00zTmkwME9EY3hMV0UxTkRJdFpXSXhNbUUxWVRjNE1EQmpMM1l5TGpBaUxDSnBZWFFpT2pFM01qUXpNamc1TWpJc0ltNWlaaUk2TVRjeU5ETXlPRGt5TWl3aVpYaHdJam94TnpJME16TXlPREl5TENKaGFXOGlPaUpGTW1SbldWQm9OSGQxZVhCd1duUkVNREJJSzNWNU9ESXpSMHA0WWxZdlR6Wm1OVXhQTWtoMWFHdFNjRVJ2ZGxCMlZITkNJaXdpWVhwd0lqb2lZelpoT0RneVpURXRPREpqTnkwME5UUmtMVGt3TlRrdE4ySXhZVGhpTm1OaE1URXhJaXdpWVhwd1lXTnlJam9pTVNJc0ltOXBaQ0k2SW1NNFpXSTRZMkk0TFRJM09UZ3RORE01TnkwNE1EQmlMVGhsTkRjMk5HVXpNbUl3WmlJc0luSm9Jam9pTUM1QlVUQkJNV3hmUjFSSVlXTmpWV2xzVVhWelUzQmhaVUZFUjBzNFJsUlJUQzFrZEV0cGRFSjJTR3hhVnpoMlFVNUJRVUV1SWl3aWNtOXNaWE1pT2xzaVFWQkpRV05qWlhOeklsMHNJbk4xWWlJNkltTTRaV0k0WTJJNExUSTNPVGd0TkRNNU55MDRNREJpTFRobE5EYzJOR1V6TW1Jd1ppSXNJblJwWkNJNklqUmpZelkxWm1RMkxUbGpOell0TkRnM01TMWhOVFF5TFdWaU1USmhOV0UzT0RBd1l5SXNJblYwYVNJNklqTXdVbmx0UW5KMk16QnRRM2hEUWxsYUxXTm1RVUVpTENKMlpYSWlPaUl5TGpBaUxDSmhjSEJFWVhSaElqb2llMXdpZFdsa1hDSTZNVFUzTXpRNUxGd2lZV2xrWENJNk1qQXhNRFV4TkgwaWZRLlFROXJRdEYyM1YyMjlUazR0eVFTYzFnN3lqOUo4VXJmUWFCNGQwWGhnU3dfeWgwblEzR1ljSjY5SWN1SHFBTDJnN1RvNnBhVFdMdDhnNWF4N0c3N19IVnVOMkdNR3F0WEl3b3kxQ1BBemFRbkdaMGRiVnhUbkQ4YUVFTE4xbmo0amU1LUY3UkJUWG1VbExXek9vekg1bk5UVWVTdjNZdnRxX1Y3VjUxWjVEODFTb2tnQ0tGMWtzYnhXS3VrandNbEVOZW0yVkFidnZaWU9qT0F1SUpGZGVsc0JRNXZPdlVkVE9IWXdsYXJ1S295OFBQTmVDUG13cENxTnNEaGw5eVBYdDE4Ui1XN1JCeU5qUWp4MkFCSXRKNDFmWEs1SWZaOXlRX2Jua3BTRk1TQ09TZjA1TlRaZUNPb1JHRWNLTUZGVi1KTEtPTEN6UEZNd3JUdmh2S2RvUSIsIkF2YWlsYWJsZVByb2R1Y3RzIjoiW1wiMTAwOFwiLFwiMTA1M1wiLFwiMTAwNVwiLFwiMTAxMVwiLFwiMjA4OVwiLFwiMTAyNlwiLFwiMTAyN1wiLFwiMTAyOFwiLFwiNTAwMFwiLFwiNTAwMVwiLFwiNTAwM1wiLFwiMjAwMFwiLFwiMjAwMVwiLFwiMjAwMlwiLFwiMjAwM1wiLFwiMjAwNFwiLFwiMjAwNVwiXSIsIm5iZiI6MTcyNDMyOTIyMiwiZXhwIjoxNzI0MzM2NDIyLCJpYXQiOjE3MjQzMjkyMjIsImlzcyI6Imh0dHBzOi8vZHRhcGl1YXQuZGF0YXRyZWUuY29tIiwiYXVkIjoiV2ViQXBpQ29uc3VtZXJzIn0.3jOQUl3uIEhGdByswdUKg2O6wFxxfetMeQAnwqZzJnU',
                },
                success: function(data) {
                    //alert('111')
                    //console.log("abc" + data.StatusDescription);
                    if (data) {
                        console.log(data);
                        //console.log(data.LitePropertyList);
                        //$('.error').text('');
                        //myarray = JSON.stringify(data.Reports);
                        //myarray = data.LitePropertyList;
                        //console.log(myarray);
                        //alert(data);
                        //buildTable3(myarray);
                        //$("#myDataTable3").DataTable();
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
                        window.open(page_url, "_self");
                        //alert(data);
                        //printErrorMsg(data)
                    },

                } ///main ajax success

            });

        });
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
            //var $submit = $('.reg');
            //$submit.prop('disabled', false);
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
        //alert(data[0].address.state);
        
        var table = document.getElementById('mytable');
        for (var i = 0; i < data.length; i++) {
            var row = `<tr>
        <td>${data[i].PropertyId}</td>
        <td>$${data[i].AssessedValue}</td>
        <td>${data[i].SitusAddress.County}</td>
        <td>${data[i].SitusAddress.City}</td>
         <td>${data[i].SitusAddress.State}</td>
         <td>${data[i].OwnerName1Full}</td>
         <td>$${data[i].LastMarketSaleInformation.SalePrice}</td>
         <td>${data[i].PropertyStatusIndicators.IsForSale}</td>
         <td>${data[i].SiteInformation.Acres}</td>
         <td>${data[i].SiteInformation.LandUse}</td>
         <td>${data[i].SiteInformation.LotArea}</td>      
      
        </tr>`
            table.innerHTML += row;
        }

    }

    function buildTable3(data) {
        //alert(data[0].address.state);
        var table = document.getElementById('mytable3');
        table.innerHTML = "";
        for (var i = 0; i < data.length; i++) {
            var row = `<tr>
            <td>${[i+1]}</td>
        <td>${data[i].PropertyId}</td>
        <td>${data[i].County}</td>
        <td>${data[i].City}</td>
         <td>${data[i].State}</td>
         <td>${data[i].Owner}</td>
         <td>${data[i].Address}</td>      
        </tr>`
            table.innerHTML += row;
        }
        //table.innerHTML = '';

    }

    function buildTable2(data) {
        //alert(data[0].address.state);
        var table = document.getElementById('mytable2');
        //for (var i = 0; i < data.length; i++) {
        var row = `<tr>
        <td>${data.SubjectProperty.PropertyId}</td>
        <td>${data.SubjectProperty.SitusAddress.StreetAddress}</td>  
        <td>${data.SubjectProperty.SitusAddress.City}</td>
        <td>${data.SubjectProperty.SitusAddress.State}</td> 
        <td>${data.OwnerInformation.Owner1FullName }</td>
         <td>${data.SiteInformation.Zoning }</td> 
          <td>${data.SiteInformation.CountyUse }</td> 
           <td>${data.SiteInformation.Acres }</td> 
            <td>$${data.TaxInformation.AssessedValue }</td> 
            <td><a href="#">Export Data</a></td>
        </tr>`
        table.innerHTML += row;
        //}

    }
</script>