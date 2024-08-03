<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="robots" content="noindex,nofollow" />
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Propelyze</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="http://165.140.69.88/~plotplaza/checkapi/example-app/public/css/font-awesome.min.css" rel="stylesheet">
    <link href="{{ asset('css/global.css') }}" rel="stylesheet">
    <link href="{{ asset('css/contact.css') }}" rel="stylesheet">
    <link href="{{ asset('css/index.css') }}" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans&display=swap" rel="stylesheet">
    <script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<style>
    span,
    .incorrect {
        color: red;
    }

    p.result {
        color: green;
    }
</style>
<?php
$app_url = config('app.url');
//echo $app_url.'/login';
//echo $app_url;
?>

<script type="text/javascript">
    $(document).ready(function() {
        var token = localStorage.getItem('user_token2');
        //alert($app_url);
        /*if (window.location.pathname == <?php echo $app_url ?>.'/login' || window.location.pathname == <?php echo $app_url ?>.'/register') {
            if (token != null) {
                window.open(<?php echo $app_url ?>.'/profile', '_self');
            }
           // $('.logout').hide();

        } else {
            if (token == null) {
                window.open(<?php echo $app_url ?>.'/login', '_self');
            }

        }*/
        //alert(token);
        $('#register').on('submit', function(event) {
            event.preventDefault();
            //alert('hi  hru');
            jQuery.ajax({
                url: "{{ url('register') }}",
                data: jQuery('#register').serialize(),
                type: 'POST',
                success: function(data) {
                    //alert(data);
                    if (data.message) {
                        $("#register")[0].reset();
                        $(".error").text("");

                        $(".result").text(data.message);

                    } else {
                        console.log(data)
                        //alert(data);
                        printErrorMsg(data)
                    }
                },

            })
        });

        //////////////////////login ////////////////////////////

        $('#login_id').on('submit', function(event) {
            event.preventDefault();
            //alert('hi  hru');
            jQuery.ajax({
                url: "{{ url('login') }}",
                data: jQuery('#login_id').serialize(),
                type: 'POST',
                success: function(data) {
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
                        alert(data.token_type);
                        window.open("/profile", "_self");
                    } else {
                        printErrorMsgLogin(data);
                    }
                    //alert(data);
                    //console.log(data);


                },

            })
        });
        ////////////////////////////logout////////////////
        $('#logout_b').on('click', function(event) {
            event.preventDefault();
            //alert('hi  hru');
            jQuery.ajax({
                url: "{{ url('logout') }}",
                type: "GET",
                headers: {
                    'Authorization': localStorage.getItem('user_token2')
                },
                statusCode: {
                    200: function() {
                        alert("success");
                        localStorage.removeItem('user_token2');
                    window.open('/login','_self');
                    },
                    404: function() {
                        alert("page not found");
                    },
                    500: function() {
                        alert("error");
                    }
                },
                /*statusCode: {
                    404: function() {
                        alert("page not found");
                    }
                }*/
            });
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
                $("." + key + "_err").text(value)
            }

        });
    }
</script>