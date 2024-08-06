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
        /////////////datatable/////

        /////////////////////
        var token = localStorage.getItem('user_token2');


        $.ajax({
            url: '{{ url("/api/profile") }}',
            type: "GET",
            headers: {
                'Authorization': localStorage.getItem('user_token2')
            },
            success: function(data) {
                console.log(data);
                if (data.status == true) {
                    console.log(data.user);
                    $('.name').text(data.user.name);
                    $('#name').val(data.user.name);
                    $('#email').val(data.user.email);
                    //localStorage.removeItem('user_token');
                    //window.open('/login','_self');
                } else {
                    alert(data.message);

                }
            }
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
            var APP_URL = "{{ url('') }}";
            //alert(APP_URL);
            var page_url = '' + APP_URL + '/profile';
            //alert(test);
            event.preventDefault();
            //alert('hi  hru');
            jQuery.ajax({
                url: "{{ url('login') }}",
                data: jQuery('#login_id').serialize(),
                type: 'POST',
                success: function(data) {
                    alert(data);
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
        ////////////////////////////logout////////////////
        /*$('#logout_b').on('click', function(event) {
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
        });*/
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
