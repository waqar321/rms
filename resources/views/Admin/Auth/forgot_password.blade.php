<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ url_secure('login/fonts/icomoon/style.css') }}">

    <link rel="stylesheet" href="{{ url_secure('login/css/owl.carousel.min.css') }}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ url_secure('login/css/bootstrap.min.css') }}">

    <!-- Style -->
    <link rel="stylesheet" href="{{ url_secure('login/css/style.css') }}">
    <link href="<?php echo url_secure('vendors/sweet_alert/sweetalert2.min.css') ?>"  rel="stylesheet"/>
    <title>Forgot Password</title>
    <style>
        .back a{
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
                <img src="{{ url_secure('login/images/login-bg.png') }}" alt="Image" class="img-fluid">
            </div>
            <div class="col-md-6 contents">
                <div class="row justify-content-end">
                    <div class="col-md-10">
                        <div class="mb-4">
                            <h3>Forgot Password</h3>
                            <p class="mb-4">Insert your email for new password.</p>
                        </div>
                        <form id="myform" action="" novalidate="novalidate" data-parsley-validate class="form-horizontal form-label-left form-detail" method="post">
                            <div class="form-group first">
                                <label for="email">Email</label>
                                <input type="text" class="form-control" id="email" name="email" data-rule-required="true" data-msg-required="Email is required">
                                <span class="error-container danger w-100"></span>
                            </div>
                            <input type="submit" value="Submit" class="btn btn-block btn-primary btn-yellow">
                            <p class="text-right mt-3 back"><a href="{{ url_secure('/') }}">Back To Login</a></p>
                        </form>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>


<script src="{{ url_secure('login/js/jquery-3.3.1.min.js') }}"></script>
<script src="{{ url_secure('login/js/popper.min.js') }}"></script>
<script src="{{ url_secure('login/js/bootstrap.min.js') }}"></script>
<script src="{{ url_secure('login/js/main.js') }}"></script>

<script src="<?php echo url_secure('build/js/custom.min.js') ?>"></script>
<script src="<?php echo url_secure('vendors/sweet_alert/sweetalert2.all.min.js') ?>" ></script>
<script src="<?php echo url_secure('vendors/validate/jquery.validate.min.js') ?>" type="text/javascript"></script>
<script src="<?php echo url_secure('build/js/ScantumToken.js') ?>"></script>
<script>
    const token = getToken();
    const headers = {
        "Authorization": `Bearer ${token}`,
    };
    $("#myform").validate({
        errorClass: "danger",
        errorPlacement: function (error, element) {
            error.addClass('w-100').appendTo(element.parent(0));
        },
        submitHandler: function (form, event) {
            event.preventDefault();

            Swal.fire({
                title: 'Auto close after email send!',
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
            $.ajax({
                url: '<?php echo api_url('forgot/password'); ?>',
                method: 'POST',
                data:data,
                dataType: 'json', // Set the expected data type to JSON
                headers: headers,
                beforeSend: function(){
                    $('.error-container').html('');
                },
                success: function(data) {
                    if(data.status == 2){
                        Swal.fire(
                            'Error!',
                            data.message,
                            'warning'
                        );
                    }
                    if (data && data.status == 1) {
                        Swal.fire(
                            'Saved!',
                            data.message,
                            'success'
                        );
                    } else {
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
