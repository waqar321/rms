@extends('Admin.layout.main')

@section('styles')@endsection

@section('title') {{ (Request::segment(3) == 'edit') ? 'Edit' : 'Add' }} Express Centre @endsection

@section('content')

<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Manage Express Centre</h3>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>{{ (Request::segment(3) == 'edit') ? 'Edit' : 'Add' }}</h2>
                        <ul class="nav navbar-right panel_toolbox justify-content-end">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <br />

                        <form id="express_form" action="" novalidate="novalidate" data-parsley-validate class="form-horizontal form-label-left" method="post">
                                <input type="hidden" value="" disabled name="id">
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label>Country<span class="danger">*</span></label>
                                        <select  data-rule-required="true"  data-msg-required="This is required" name="country_id" id="country_id" class="form-control select2">
                                            <option value="">- Select a Country -</option>
                                        </select>
                                        <span class="error-container danger w-100"></span>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label>City<span class="danger">*</span></label>
                                        <select  data-rule-required="true"  data-msg-required="This is required" name="city_id" id="city_id" class="form-control select2">
                                            <option value="">- Select  City -</option>
                                        </select>
                                        <span class="error-container danger w-100"></span>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">

                                <div class="form-group">
                                    <label>Express Centre Name<span class="danger">*</span></label>
                                        <input data-rule-required="true"  data-msg-required="This is required" type="text" maxlength="50" id="branch_name" name="branch_name"  class="form-control" placeholder="Express Centre Name">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">

                                <div class="form-group">
                                    <label>Express Centre Phone<span class="danger">*</span>
                                    </label>
                                        <input data-rule-required="true"  data-msg-required="This is required" type="text" id="branch_phone" name="branch_phone" maxlength="50"  class="form-control" placeholder="Express Centre Phone">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">

                                <div class="form-group">
                                    <label>Person Name<span class="danger">*</span>
                                    </label>
                                        <input data-rule-required="true"  data-msg-required="This is required" placeholder="Person Name" maxlength="50" type="text" id="branch_person_name" name="branch_person_name"  class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">

                                <div class="form-group col-md-6">
                                    <label>Is Main Express Centre?
                                    </label>
                                        <input value="1" type="checkbox" id="is_main_branch" name="is_main_branch" >
                                    </div>
                                </div>
                                <div class="col-md-9 col-sm-6 col-xs-12">

                                <div class="form-group">
                                    <label>Express Centre Address<span class="danger">*</span></label>
                                       <textarea data-rule-required="true"  data-msg-required="This is required" maxlength="500" id="branch_address" name="branch_address" class="form-control" rows="4" cols="5"></textarea>
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">

                            <div class="form-group">
                                <a href="<?php echo url_secure('manage_location/express_centre') ?>"><button class="btn btn-danger cancel-button" type="button">Cancel</button></a>
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


@endSection

@section('scripts')
    <script src="{{ url_secure('build/js/main.js')}}"></script>
    <script src="<?php echo url_secure('vendors/validate/jquery.validate.min.js') ?>" type="text/javascript"></script>
<script>

    function loadAjax(EditData = []){
        $.ajax({
            url: '<?php echo url_secure('manage_location/city/data_list'); ?>',
            method: 'GET',
            dataType: 'json', // Set the expected data type to JSON
            beforeSend: function () {
                $('.error-container').html('');
            },
            success: function (data) {
                var option1 = "";
                var option2 = "";

                $.each(data.countries, function(index, value) {
                    option1+= `<option value="${value.id}">${value.country_name}</option>`
                });

                $.each(data.cities, function(index, value) {
                    option2+= `<option value="${value.id}">${value.city_name}</option>`
                });


                $('#country_id').append(option1);
                $('#city_id').append(option2);
                if(EditData){
                    editForm(EditData);
                }
            },
            error: function(xhr, textStatus, errorThrown) {

            }
        });
    }

    $("#express_form").validate({
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
                    var data = $('#express_form').serialize();
                    $.ajax({
                        url: '<?php echo api_url('manage_location/express_centre/submit'); ?>',
                        method: 'POST',
                        data:data,
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
                                window.location.href = '<?php echo url_secure('/manage_location/express_centre') ?>'
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
            url: '<?php echo api_url('manage_location/express_centre/edit'); ?>',
            method: 'GET',
            data: {ajax: true, id: id},
            dataType: 'json', // Set the expected data type to JSON
            beforeSend: function () {
                $('.error-container').html('');
            },
            success: function (data) {
                if (data && data.status == 1) {
                    loadAjax(data.data.express_centre);
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
    }else{
        loadAjax();
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
@endSection
