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
</head>
<style>
    /* Icon when the collapsible content is show */
    /*.btn.icon:after {
    font-family: "Glyphicons Halflings";
    content: "\2212";
}

/* Icon when the collapsible content is hidden */
    /*.btn.icon.collapsed:after {
    content: "\2b";
}*/
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
                    console.log(data);
                    if (data.success == true) {
                        //alert(data.message);
                        $('.result').text(data.message);
                        $('.error').text();
                        $('.email').text(data.data.email);
                        if (data.data.is_verified == 0) {
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
                    console.log(data.user);
                    $('.name').text(data.user.name);
                    $('.email').text(data.user.email);
                    $('#phone').val(data.user.phone);
                    $('#name').val(data.user.name);
                    $('#email').val(data.user.email);
                    $('#user_id').val(data.user.id);
                    //localStorage.removeItem('user_token');
                    //window.open('/login','_self');
                    if (data.user.is_verified == 0) {
                        $('.verify').html('<button class="button verify_mail" data-id="' + data.user.email + '" style="border:none;" href="">Verify</button>');
                    } else {
                        $('.verify').html("Verified");
                    }
                } else {
                    //$('.verify').html("Verified");
                    alert(data.message);

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
            var APP_URL = "{{ url('') }}";
            var page_url = '' + APP_URL + '/login';
            $.ajax({
                url: '{{ url("/api/logout")}}',
                type: "POST",
                headers: {
                    'Authorization': localStorage.getItem('user_token2')
                },
                success: function(data) {
                    console.log(data);
                    if (data.success == true) {
                        localStorage.removeItem('user_token2');
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
                    console.log(data);
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

            });
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
                        console.log(data)
                        //alert(data);
                        printErrorMsg(data);
                        $(".agree_err").text("Please check agree and conditions");
                    }
                },

            })
        });
        ////////////////////////////logout////////////////

        ////////////////////////////profile//////////////

        ///////////////////////////////////////////////
        /////////////////////////////////getSale/////////////////
        myarray = [];
        $("#sale_search_form").submit(function(event) {
            event.preventDefault();
            var formData = $(this).serialize();
            var zp = document.getElementById('loc').value; //246283880,//90001,//90030,//90403
            var appurl = "{{ env('AJAX_URL') }}";
            //alert(zp); //url https://zillow-com1.p.rapidapi.com/propertyComps    data.comps
            $.ajax({
                    url: 'https://zillow-com1.p.rapidapi.com/similarSales?zpid=19959099',
                    type: "GET",
                    headers: {
                        'x-rapidapi-key': '896c054dd8mshb6b3aa6ff000d3fp19756djsnc2c76cac4add'
                    },
                    data: formData,
                    success: function(data) {
                        //alert(data.address.city);

                        console.log(data);
                        if (data) {
                            myarray = data;
                            buildTable(myarray);
                            $("#myDataTable").DataTable();


                        } else {
                            alert(data.error);
                            //printErrorMsg(data)
                        }

                    }
                }

            );

        })
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
        <td>${data[i].bathrooms}</td><td>${data[i].bedrooms}</td>
        <td>${data[i].address.state}</td> <td>$${data[i].price}</td>
        <!--td>${data[i].taxAssessedValue}</td-->
        <td>${data[i].livingArea}</td>
        <!--td>${data[i].rentZestimate}</td-->
        <td>${data[i].address.city}</td>
        <td>${data[i].homeStatus}</td></tr>`
            table.innerHTML += row;
        }

    }
</script>