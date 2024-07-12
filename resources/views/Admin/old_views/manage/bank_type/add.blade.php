@extends('Admin.layout.main')
@section('title')  {{ (Request::segment(3) == 'edit') ? 'Edit' : 'Add' }} Bank Type @endsection
@section('styles')
@endsection

@section('content')
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Manage Bank Type</h3>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>{{ (Request::segment(3) == 'edit') ? 'Edit' : 'Add' }}</h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <br />
                            <form id="bank_type" action="" novalidate="novalidate" data-parsley-validate class="form-horizontal form-label-left" method="post">
                                <input type="hidden" value="" disabled name="id">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label>Bank Type Name</label>
                                        <input data-rule-required="true"  data-msg-required="This field is required" id="bank_type_name" class="form-control" type="text" name="bank_type_name">
                                        <span class="error-container danger w-100"></span>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <a href="<?php echo url_secure('manage/bank_type/index') ?>"><button class="btn btn-danger cancel-button" type="button">Cancel</button></a>
                                        <button type="submit" class="btn btn-success submit-and-update-button">{{ (Request::segment(3) == 'edit') ? 'Update' : 'Submit' }}</button>
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
        const headers = {
            "Authorization": `Bearer ${token}`,
        };
        $("#bank_type").validate({
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
                        var data = $('#bank_type').serialize();
                        $.ajax({
                            url: '<?php echo api_url('manage/bank_type/submit'); ?>',
                            method: 'POST',
                            data:data,
                            headers: headers,
                            dataType: 'json', // Set the expected data type to JSON
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
                                    window.location.href = '<?php echo url_secure('/manage/bank_type/index') ?>'
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

        const url = window.location.search;
        if(url) {
            const urlParams = new URLSearchParams(url);
            const id = atob(urlParams.get('id'));
            $.ajax({
                url: '<?php echo api_url('manage/bank_type/edit'); ?>',
                method: 'GET',
                data: {ajax: true, id: id},
                headers: headers,
                dataType: 'json', // Set the expected data type to JSON
                beforeSend: function () {
                    $('.error-container').html('');
                },
                success: function (data) {
                    if (data && data.status == 1) {
                        editForm(data.data.bank_types);
                    } else {
                        Swal.fire(
                            'Error!',
                            'Something Went Wrong',
                            'error'
                        );
                    }
                },
                error: function (xhr, textStatus, errorThrown) {
                    // Handle AJAX errors here
                    Swal.fire(
                        'Error!',
                        'Form submission failed: ' + errorThrown,
                        'error'
                    );
                }
            });
        }

        function editForm(data) {
            var keys = Object.keys(data);
            var values = Object.values(data);

            $(keys).each(function (index, element) {
                var input = $('input[name="' + element + '"], textarea[name="' + element + '"], select[name="' + element + '"]');
                if (input.is(':checkbox')) {
                    if (input.val() === values[index]) {
                        input.prop('checked', true);
                    }
                }
                else if(input.is('select')){
                    input.val(values[index]);
                    input.trigger('change');
                }
                else if (input.is(':radio')) {
                    $(`input[name="${element}"][value=${values[index]}]`).trigger('click');
                } else {
                    if(element === 'id'){
                        input.prop('disabled',false);
                    }
                    input.val(values[index]);
                }
            });
        }

    </script>
@endsection
