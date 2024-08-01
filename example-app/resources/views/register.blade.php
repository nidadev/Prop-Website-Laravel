<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

</head>
<body>
<form method="post" action="{{ url('register') }}" id="register">
    @csrf
    <input type="text" name="name">
    <input type="text" name="email">
    <input type="text" name="phone">
    <input type="password" name="password">
    <input type="submit" value="register">

</form>
<script type="text/javascript"> 
$(document).ready(function(){
$('#register').on('submit',function(){
alert('hi  hru');
});
});
</script>
</body>
</html>
<h1>Register</h1>


