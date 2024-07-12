@extends('Admin.layout.main')

@section('styles')@endsection

@section('title') {{ (Request::segment(3) == 'edit') ? 'Edit' : 'Add' }} Zone @endsection

@section('content')
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Manage Zones</h3>
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
                            <form id="zone_form" action="" novalidate="novalidate" data-parsley-validate class="form-horizontal form-label-left" method="post">
                                <input type="hidden" value="" disabled name="id">
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <div class="form-group">
                                    <label>Country Name<span class="danger">*</span></label>
                                        <select  data-rule-required="true"  data-msg-required="This is required" name="country_id" id="country_id" class="form-control select2">
                                            <option value="">- Select a Country -</option>
                                        </select>
                                        <span class="error-container danger w-100"></span>
                                    </div>
                                </div>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <div class="form-group">
                                    <label>Shipment Type<span class="danger">*</span></label>
                                        <select  data-rule-required="true"  data-msg-required="This is required" name="shipment_type_id" id="shipment_type_id" class="form-control select2">
                                            <option value="">- Select  Shipment Type -</option>
                                        </select>
                                        <span class="error-container danger w-100"></span>
                                    </div>
                                </div>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <div class="form-group">
                                    <label>Cod Zone Name<span class="danger">*</span></label>
                                        <input  data-rule-required="true"  data-msg-required="This is required" id="zone_name" class="form-control" type="text" name="zone_name">
                                        <span class="error-container danger w-100"></span>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">

                                <div class="form-group">
                                    <a href="<?php echo url_secure('manage_location/zone') ?>"><button class="btn btn-danger cancel-button" type="button">Cancel</button></a>
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
@endSection

@section('scripts')
    <script src="{{ url_secure('build/js/main.js')}}"></script>
    <script src="<?php echo url_secure('vendors') ?>/validate/jquery.validate.min.js" type="text/javascript"></script>
    <script>
        const token = getToken();
        const headers = {
            "Authorization": `Bearer ${token}`,
        };
        function loadAjax(EditData = []){
            $.ajax({
                url: '<?php echo api_url('manage_location/country/list'); ?>',
                method: 'GET',
                dataType: 'json', // Set the expected data type to JSON
                headers: headers,
                beforeSend: function () {
                    $('.error-container').html('');
                },
                success: function (data) {
                    var option = "";
                    $.each(data, function(index, value) {
                        option+= `<option value="${value.id}">${value.country_name}</option>`
                    });
                    $('#country_id').append(option);
                    if(EditData){
                        editForm(EditData);
                    }
                },
                error: function(xhr, textStatus, errorThrown) {

                }
            });

            $.ajax({
                url: '<?php echo api_url('manage/shipment_type/list'); ?>',
                method: 'GET',
                dataType: 'json', // Set the expected data type to JSON
                headers: headers,
                beforeSend: function () {
                    $('.error-container').html('');
                },
                success: function (data) {
                    var option = "";
                    $.each(data, function(index, value) {
                        option+= `<option value="${value.id}">${value.shipment_type_name}</option>`
                    });
                    $('#shipment_type_id').append(option);
                    if(EditData){
                        editForm(EditData);
                    }
                },
                error: function(xhr, textStatus, errorThrown) {

                }
            });
        }

        $("#zone_form").validate({
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
                        var data = $('#zone_form').serialize();
                        $.ajax({
                            url: '<?php echo api_url('manage_location/zone/submit'); ?>',
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
                                    window.location.href = '<?php echo url_secure('/manage_location/zone') ?>'
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
                url: '<?php echo api_url('manage_location/zone/edit'); ?>',
                method: 'GET',
                data: {ajax: true, id: id},
                headers: headers,
                dataType: 'json', // Set the expected data type to JSON
                beforeSend: function () {
                    $('.error-container').html('');
                },
                success: function (data) {
                    if (data && data.status == 1) {
                        loadAjax(data.data.zones);
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
