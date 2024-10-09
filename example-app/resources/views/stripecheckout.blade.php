<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h3>Price:$20</h3>
    <form method="post" action="{{ route('stripe') }}">
        @csrf
        <input type="hidden" name="price" value="20">
        <input type="hidden" name="product_name" value="download_files">

        <input type="hidden" name="quantity" value="1">

        <button type="submit">Pay with stripe</button>


    </form>

</body>

</html>