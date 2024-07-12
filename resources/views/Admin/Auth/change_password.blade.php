@extends('Admin.layout.main')
@section('title')
    Change Password
@endsection
@section('styles')

@endsection

@section('content')
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Change Password</h3>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Change Password</h2>
                            <ul class="nav navbar-right panel_toolbox justify-content-end">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <br/>

                            <form id="change-password" action="" novalidate="novalidate" data-parsley-validate class="form-horizontal form-label-left" method="POST">
                                <div class="col-md-7 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label>Previous Password<span class="danger">*</span></label>
                                        <input id="current_password" class="form-control" type="password" name="current_password" data-rule-required="true"  data-msg-required="password is required">
                                        <span class="error-container danger w-100"></span>
                                    </div>
                                </div>
                                <div class="col-md-7 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label>New Password<span class="danger">*</span></label>
                                        <input id="new_password" class="form-control" type="password" name="new_password" data-rule-required="true"  data-msg-required="new password is required">
                                        <span class="error-container danger w-100"></span>
                                    </div>
                                </div>
                                <div class="col-md-7 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label>Confirm Password<span class="danger">*</span></label>
                                        <input id="confirm_password" class="form-control" type="password" name="confirm_password" data-rule-required="true"  data-msg-required="confirm password is required">
                                        <span class="error-container danger w-100"></span>
                                    </div>
                                </div>

                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                    <div class="form-group">
                                        <a href="<?php echo url_secure('dashboard') ?>"><button class="btn btn-danger cancel-button" type="button">Cancel</button></a>
                                        <button type="submit" class="btn btn-success submit-and-update-button">Submit</button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /page content -->
@endsection

@section('scripts')

    <script src="<?php echo url_secure('vendors') ?>/validate/jquery.validate.min.js" type="text/javascript"></script>
    <script>

        const token = getToken();
        const getUserData = JSON.parse(getUser());
        const headers = {
            "Authorization": `Bearer ${token}`,
        };


        $("#change-password").validate({
            errorClass: "danger",
            errorPlacement: function (error, element) {
                error.addClass('w-100').appendTo(element.parent(0));
            },
            submitHandler: function (form, event) {
                event.preventDefault();

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to submit this form!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ffca00',
                    cancelButtonColor: '#0e1827',
                    confirmButtonText: 'Submit'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var data = $('#change-password').serialize();
                        $.ajax({
                            url: '<?php echo api_url('change/password'); ?>',
                            method: 'POST',
                            data:data,
                            dataType: 'json', // Set the expected data type to JSON
                            headers: headers,
                            beforeSend: function(){
                                $('.error-container').html('');
                            },
                            success: function(data) {
                                if (data && data.status == 1) {
                                    Swal.fire({
                                        icon: 'success',
                                        text: 'Form has been submitted successfully',
                                        showConfirmButton: true,
                                        confirmButtonColor: '#ffca00',
                                    });
                                    window.location.href = '<?php echo url_secure('/logout') ?>'
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
                })
            }
        });

    </script>

@endsection
