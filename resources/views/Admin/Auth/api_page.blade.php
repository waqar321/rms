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
    </style>
</head>
<body>



<div class="content">
    <div class="container">
        <div class="row">

            <div class="col-md-6">
                <img src="{{ url_secure('login/images/login-bg.png')}}" alt="Image" class="img-fluid">
            </div>
            <div class="col-md-6 contents">
                <div class="row justify-content-end">
                    <div class="col-md-10">
                        <div class="mb-4">
                            <h3>API SECTION</h3>
                            <p class="mb-4">This is the API SECTION</p>
                        </div>
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
<script src="<?php echo url_secure('build/js/ScantumToken.js') ?>"></script>

</body>
</html>
