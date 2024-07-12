<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ url_secure('login/fonts/icomoon/style.css')}}">

    <link rel="stylesheet" href="{{ url_secure('login/css/owl.carousel.min.css')}}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ url_secure('login/css/bootstrap.min.css')}}">

    <!-- Style -->
    <link rel="stylesheet" href="{{ url_secure('login/css/style.css')}}">
    <link href="<?php echo url_secure('vendors/sweet_alert/sweetalert2.min.css') ?>"  rel="stylesheet"/>
    <title>Admin-Login</title>
    <style>
        .forgot-password a{
            text-decoration: none!important;
            color: #007bff!important;
        }

        .send-otp {
            display: flex;
            align-items: center;
            font-family: Arial, sans-serif;
        }
        .send-otp i {
            margin-right: 10px;
            color: #007bff; /* Adjust the color as needed */
        }
        .send-otp label {
            font-size: 16px;
            color: #333; /* Adjust the color as needed */
        }

    </style>
</head>
<body>

    <style>
        body
        {
            /* background-color: #ffffff !important; */
        }
    </style>

<div class="content">
    <div class="container">
        <div class="row">

            <div class="col-md-6">
                <img src="{{ url_secure('login/images/login-bg.jpg')}}" alt="Image" class="img-fluid">
            </div>
            <div class="col-md-6 contents">
                <div class="row justify-content-end">
                    <div class="col-md-10">
                        <div class="mb-4">
                            <h3>Sign In</h3>
                            <p class="mb-4">Insert your login credentials for admin sign in.</p>
                        </div>
                        <form id="myform" action="" novalidate="novalidate" data-parsley-validate class="form-horizontal form-label-left form-detail" method="post">
                            <div class="form-group first">
                                <label for="username">Username / Employee Code</label>
                                <input type="text" class="form-control" id="user_id" name="user_id" required>

                            </div>
                            <div class="form-group last mb-4">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>

                            </div>

                            <input type="submit" value="Log In" class="btn btn-block btn-primary btn-yellow">
                            <p class="text-right mt-3 forgot-password"><a href="{{ url_secure('forgot-password') }}">Get OPT On Mobile</a></p>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


<script src="{{ url_secure('login/js/jquery-3.3.1.min.js')}}"></script>
<script src="{{ url_secure('login/js/popper.min.js')}}"></script>
<script src="{{ url_secure('login/js/bootstrap.min.js')}}"></script>
<script src="{{ url_secure('login/js/main.js')}}"></script>

<script src="<?php echo url_secure('build/js/custom.min.js') ?>"></script>
<script src="<?php echo url_secure('vendors/sweet_alert/sweetalert2.all.min.js') ?>" ></script>
<script src="<?php echo url_secure('vendors/validate/jquery.validate.min.js') ?>" type="text/javascript"></script>
<script src="<?php echo url_secure('build/js/ScantumToken.js?id=4') ?>"></script>
<script>

    $("#myform").validate({
        errorClass: "danger",
        errorPlacement: function (error, element) {
            error.addClass('w-100').appendTo(element.parent(0));
        },
        submitHandler: function (form, event) {
            event.preventDefault();

            Swal.fire({
                title: 'Auto close after login!',
                // timer: 2000,
                timerProgressBar: true,
                didOpen: () => {
                    Swal.showLoading()
                    const b = Swal.getHtmlContainer().querySelector('b')
                    timerInterval = setInterval(() => {
                        // b.textContent = Swal.getTimerLeft()
                    }, 300)
                },
                willClose: () => {
                    clearInterval(timerInterval)
                }
            });
            var data = $('#myform').serialize();

            // console.log('data');
            // console.log(data);

            $.ajax({
                url: '<?php echo login_url('login_api'); ?>',
                method: 'POST',
                data:data,
                dataType: 'json',       // Set the expected data type to JSON
                beforeSend: function(){
                    $('.error-container').html('');
                },
                success: function(data) 
                {
                    // console.log(data);
                    // return false;
                        
                    if (data && data.status == 1)
                    {     
                        saveToken(data.token);                              //local storage
                        saveUser(JSON.stringify(data.data));                //local storage
                        savePermissions(JSON.stringify(data.permissions));  //local storage              
                        console.log('<?php //echo url_secure('dashboard') ?>');
                        // console.log('{!! route('dashboard') !!}');
                        // console.log({!! url('dashboard') !!});
                        // return false;
                        window.location.href = '{!! route('dashboard') !!}';
                    } 
                    else 
                    {
                        var errors = (data.errors) ? data.errors : {};
                        if (Object.keys(errors).length > 0) {

                            var error_key = Object.keys(errors);
                            for (var i = 0; i < error_key.length; i++) {
                                var fieldName = error_key[i];
                                var errorMessage = errors[fieldName];
                                if ($('#' + fieldName).length) {
                                    var element = $('#' + fieldName);
                                    var element_error = `${errorMessage}`;
                                    element.next('.error-container').html(element_error);
                                    element.focus();
                                }
                            }
                        }

                    }
                },
                error: function(xhr, textStatus, errorThrown) {
                    // Handle AJAX errors here
                    Swal.fire(
                        'Error!',
                        'Form submission failed: ' + errorThrown,
                        'error'
                    );
                }
            });
        }
    });


</script>
</body>
</html>
