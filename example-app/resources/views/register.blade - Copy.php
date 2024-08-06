<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!--script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script-->

</head>
<style>
    span {
        color: red;
    }
    </style>
<body>
<form method="post" action="{{ url('register') }}" id="register">
    @csrf
    <input type="text" name="name"  autocomplete="on" placeholder="Enter Name:">Enter Name:
    <span class="error name_err"></span>
    <br><br>
    <input type="email" name="email" autocomplete="on" placeholder="Enter Name:">Enter Email:
    <span class="error email_err"></span>
    <br><br>
    <input type="text" name="phone" autocomplete="on" placeholder="Enter Phone:">Enter Phone:
    <span class="error phone_err"></span>
    <br><br>
    <input type="password" name="password"autocomplete="on"  placeholder="Enter Name:">Enter password:
    <span class="error password_err"></span>

    <br><br>
    <input type="password" name="password_confirmation" autocomplete="on"  placeholder="Enter Name:">Enter confirmed password:
    <span class="error password_confirmation_err"></span>

    <br>
    <input type="submit" value="Register">
    <br>
    <p class="result"></p>

</form>
<script type="text/javascript"> 
$(document).ready(function(){
$('#register').on('submit',function(event){
    event.preventDefault();
alert('hi  hru');
jQuery.ajax({
    url:"{{ url('register') }}",
    data:jQuery('#register').serialize(),
    type:'POST',
    success:function(data)
    {
        alert(data);
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
});

function printErrorMsg(message) {
    alert(message);
            $(".error").text("");

            $.each(message, function(key, value) {
                if (key == 'password') {
                    if (value.length > 1) {
                        $(".password_err").text(value[0]);
                        $(".password_confirmation_err").text(value[1]);

                    } else {
                        if(value[0].includes('password confirmation'))
                    {
                        $(".password_confirmation_err").text(value);

                    }
                    else
                    {
                        $(".password_err").text(value);

                    }

                    }

                } else {
                    $("." + key + "_err").text(value)
                }

            });
        }
</script>
</body>
</html>
<h1>Register</h1>


