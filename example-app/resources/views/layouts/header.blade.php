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

    <!--script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script-->

<link href="https://cdn.datatables.net/2.1.3/css/dataTables.dataTables.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdn.datatables.net/2.1.3/js/dataTables.js"></script>
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
 var app_url = '{{ env("APP_URL") }}';
 var login_url = ''+app_url+'/login';
 var register_url = ''+app_url+'/register';
 var profile_url = ''+app_url+'/profile';
 alert(login_url);

var token = localStorage.getItem('user_token2');
    if(window.location.pathname == login_url || window.location.pathname == register_url)
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

}
    $(document).ready(function() {
        /////////////datatable/////
        /////////////////////
        var token = localStorage.getItem('user_token2');
       
        //alert(token);
     

       
        ////////////////////////////logout////////////////
        $('#logout_b').on('click', function(event) {
            event.preventDefault();
            alert('hi  hru');
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
             
            });
        });
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
                    headers: { 'x-rapidapi-key' : '896c054dd8mshb6b3aa6ff000d3fp19756djsnc2c76cac4add' },
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
        scrollTop: $(".map").offset().top},
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
                $("." + key + "_err").text(value)
            }

        });
    }

    function buildTable(data)
       {
        //alert(data[0].address.state);
        var table = document.getElementById('mytable');
        for(var i=0; i < data.length; i++)
       {
        var row = `<tr>
        <td>${data[i].bathrooms}</td><td>${data[i].bedrooms}</td>
        <td>${data[i].address.state}</td> <td>$${data[i].price}</td>
        <!--td>${data[i].taxAssessedValue}</td-->
        <td>${data[i].livingArea}</td>
        <!--td>${data[i].rentZestimate}</td-->
        <td>${data[i].address.city}</td>
        <td>${data[i].homeStatus}</td></tr>`
        table.innerHTML +=row;
       }

       }
</script>