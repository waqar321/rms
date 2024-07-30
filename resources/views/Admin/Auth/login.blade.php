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
    <title>LMS-Login</title>
    <style>
        .forgot-password {
            text-decoration: none!important;
            color: #6387d9!important;
        }
        .forgot-password:hover 
        {
            color: #ecbc37 !important
        }

        .send-otp {
            display: flex;
            align-items: center;
            font-family: Arial, sans-serif;
            padding-top: 10px;
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
                            <p class="mb-4">Insert your login credentials for sign in.</p>
                        </div>
                        <form id="myform" action="" novalidate="novalidate" data-parsley-validate class="form-horizontal form-label-left form-detail" method="post">
                            <div class="form-group first">
                                <label for="username">Employee Code</label>
                                <input type="text" class="form-control" id="user_id" name="user_id" required>
                            </div>
                            <div class="form-group last mb-4">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>

                            </div>
                            <input type="submit" value="Log In" class="btn btn-block btn-primary btn-yellow">

                            <div class="send-otp">
                                <i class="fas fa-mobile-alt"></i>
                                <label for="sendOtp">Send OTP To Hum Leopards App To Set Password &nbsp; 
                                    <!-- <a class="text-right mt-3 forgot-password" href="#" >
                                        Get OTP On Mobile
                                    </a> -->
                                    <a class="text-right mt-3 forgot-password" href="#" data-toggle="modal" data-target="#OptModel">
                                        Get OTP On Mobile
                                    </a>
                                </label>
                            </div>
                            
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


<!-- Button trigger modal -->
<!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#OptModel">
  Launch demo modal
</button> -->



<!-- Modal -->
<div class="modal fade" id="OptModel" tabindex="-1" role="dialog" aria-labelledby="OptModelTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="OptModelLongTitle">Get OTP </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form id="GetpasswordForm" action="" novalidate="novalidate" data-parsley-validate class="form-horizontal form-label-left form-detail" method="post">

            <div class="modal-body">

                <!-- -------------------------------------------------------------------------------------------------- -->

                        <div class="row">
                            <div class="col-lg-6">
                                <label class="text_label" style="text-transform: capitalize;">Employee Code :</label>
                            </div>
                            <div class="col-lg-6">
                                <input type="number" name="code" id="code" placeholder="Employee Code" pattern="[0-9]{1,10}" title="Employee Code is Required">
                            </div>
                            <div class="col-lg-6">
                                <label class="text_label" style="text-transform: capitalize;">Last 4 Digits Reg. Mobile No.:</label>
                            </div>
                            <div class="col-lg-6">
                                <input type="number" name="numberDigit" id="numberDigit" placeholder="Mobile Last 4 Digit" pattern="[0-9]{1,10}" title="Please Enter Last 4 Digit Number ">
                            </div>
                        </div>

                    <!-- <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-left">
                        <label class="text_label" style="text-transform: capitalize;">Employee Code :</label>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-left">
                        <input type="text" name="code" id="code" class="input input_login" required="" placeholder="Employee Code" pattern="[0-9]{1,10}" title="Employee Code Only" oninvalid="this.setCustomValidity('Employee Code Only')" oninput="setCustomValidity('')">
                    </div> -->

                <!-- ------------------------------------------------------------------------------------------------- -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <!-- <button type="button" class="btn btn-primary">Submit</button> -->
                <button type="submit" class="btn btn-primary">Submit</button> <!-- Changed to type="submit" -->
            </div>

        </form>


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


    $("#GetpasswordForm").validate({
        errorClass: "danger",
        errorPlacement: function (error, element) {
            error.addClass('w-100').appendTo(element.parent(0));
        },
        submitHandler: function (form, event) {
            event.preventDefault();


            // ------------------ validate eemployee code and phone number ------------------
                var code;
                var numberDigit;

                if($('#code').val() == '')
                {
                    Swal.fire({
                        icon: 'error',
                        title: 'Please Enter Employee Code',
                        text: 'Please Enter Employee Code',
                    });  
                    return false;
                }
                else if($('#numberDigit').val() == '')
                {
                    Swal.fire({
                        icon: 'error',
                        title: 'Please Enter Phone Number\'s Last 4 Digit',
                        text: 'Please Enter Phone Number\'s Last 4 Digit',
                    });  
                    return false;
                }
                else
                {
                    code = $('#code').val();
                    numberDigit = $('#numberDigit').val();
                }

            // ------------------ loader ------------------

                Swal.fire({
                    title: 'Auto close after login!',
                    // timer: 2000,
                    timerProgressBar: true,
                    didOpen: () => {
                        Swal.showLoading()
                        const b = Swal.getHtmlContainer().querySelector('b')
                        timerInterval = setInterval(() => {
                        }, 300)
                    },
                    willClose: () => {
                        clearInterval(timerInterval)
                    }
                });

                
            var data = $('#GetpasswordForm').serialize();
            // ------------------ Send OPT Request ------------------

            $.ajax({
                url: '<?php echo login_url('set_Api'); ?>',
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
                        Swal.fire({
                            icon: 'success',
                            title: data.message,
                            text: 'Please Use otp as Password To login',
                        });  

                        $('#OptModel').modal('hide');

                        // quizModal.on('hidden.bs.modal', function () 
                        // {
                        //     // 
                        // });
                        
                        // saveToken(data.token);                              //local storage
                        // saveUser(JSON.stringify(data.data));                //local storage
                        // savePermissions(JSON.stringify(data.permissions));  //local storage              
                        // console.log('<?php //echo url_secure('dashboard') ?>');
                        // console.log('{!! route('dashboard') !!}');
                        // console.log({!! url('dashboard') !!});
                        // return false;
                        // window.location.href = '{!! route('dashboard') !!}';
                    } 
                    else 
                    {
                        // var errors = (data.errors) ? data.errors : {};
                        // if (Object.keys(errors).length > 0) {

                        //     var error_key = Object.keys(errors);
                        //     for (var i = 0; i < error_key.length; i++) {
                        //         var fieldName = error_key[i];
                        //         var errorMessage = errors[fieldName];
                        //         if ($('#' + fieldName).length) {
                        //             var element = $('#' + fieldName);
                        //             var element_error = `${errorMessage}`;
                        //             element.next('.error-container').html(element_error);
                        //             element.focus();
                        //         }
                        //     }
                        // }
                    }
                },
                error: function(xhr, textStatus, errorThrown) 
                {
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


    $("#myform").validate({
        errorClass: "danger",
        errorPlacement: function (error, element) {
            // error.addClass('w-100').appendTo(element.parent(0));
        },
        submitHandler: function (form, event) 
        {
            event.preventDefault();
            // return false;

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
