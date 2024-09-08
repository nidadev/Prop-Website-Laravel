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
  <link href="{{ asset('css/global.css') }}" rel="stylesheet">
  <link href="{{ asset('css/contact.css') }}" rel="stylesheet">
  <link href="{{ asset('css/index.css') }}" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link href="https://cdn.datatables.net/2.1.5/css/dataTables.dataTables.css" rel="stylesheet" crossorigin="anonymous">

</head>

<body>
  @include('layouts.navbar');
  @yield('content')
  
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script src="https://cdn.datatables.net/2.1.5/js/dataTables.js"></script>
  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.2/moment.min.js"></script>
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