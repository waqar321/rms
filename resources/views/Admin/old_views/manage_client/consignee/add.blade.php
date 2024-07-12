@extends('Admin.layout.main')
@section('page_title') {{ (Request::segment(3) == 'edit') ? 'Edit' : 'Add' }} Consignee @endsection
@section('styles')

    <style>
        .control-label {
            padding-left: 0px;
        }

        .sbmt-btn-mar {
            margin-top: 10px;
        }
    </style>
@endsection

@section('content')
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Manage Consignee</h3>
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

                            <form id="consignee_form" action="" novalidate="novalidate" data-parsley-validate
                                  class="form-horizontal form-label-left" method="post">
                                <input type="hidden" value="" disabled name="id">
                                <div class="row">

                                    <div class="col-md-4 col-sm-6 col-xs-12">

                                        <div class="form-group">
                                            <label for="last-name">Consignee Name<span class="danger">*</span></label>
                                            <input maxlength="50" data-rule-required="true"
                                                   data-msg-required="Consignee name field is required" type="text" id="consignee_name"
                                                   name="consignee_name" required="required"
                                                   class="form-control">
                                            <span class="error-container danger w-100"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-6 col-xs-12">

                                        <div class="form-group">
                                            <label for="middle-name">Consignee Email</label>
                                            <input maxlength="50" data-rule-email="true" id="consignee_email"
                                                   class="form-control" type="text"
                                                   name="consignee_email">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-6 col-xs-12">

                                        <div class="form-group">
                                            <label for="middle-name">Consignee Phone<span
                                                    class="danger">*</span></label>
                                            <input data-inputmask="'mask' : '99999999999'" data-rule-required="true"
                                                   data-msg-required="Consignee phone no field is required" id="consignee_phone"
                                                   class="form-control" type="text"
                                                   name="consignee_phone">
                                            <span class="error-container danger w-100"></span>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-sm-6 col-xs-12">

                                        <div class="form-group">
                                            <label for="middle-name">Consignee Phone 2</label>
                                            <input data-inputmask="'mask' : '99999999999'" id="consignee_phone_two"
                                                   class="form-control" type="text"
                                                   name="consignee_phone_two">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12">

                                        <div class="form-group">
                                            <label for="middle-name">
                                                Consignee Phone 3
                                            </label>
                                            <input data-inputmask="'mask' : '99999999999'" id="consignee_phone_three"
                                                   class="form-control" type="text"
                                                   name="consignee_phone_three">
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label>City<span class="danger">*</span> </label>
                                            <select id="city_id" style="width: 100%;" data-rule-required="true"
                                                    name="city_id" data-msg-required="City field is required">
                                                <option value="" disabled selected>Select an option</option>
                                            </select>
                                            <span class="error-container danger w-100"></span>
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label>Area</label>
                                            <select id="area_id" style="width: 100%;" name="area_id">
                                            </select>
                                            <span class="error-container danger w-100"></span>
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label>Block / Sub Areas</label>
                                            <select id="subarea_id" style="width: 100%;"
                                                    name="subarea_id">
                                            </select>
                                            <span class="error-container danger w-100"></span>
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-sm-6 col-xs-12">

                                        <div class="form-group">
                                            <label for="last-name">Postal Code</label>
                                            <input maxlength="10"
                                                   type="number" id="postal_code"
                                                   name="postal_code"
                                                   class="form-control">
                                            <span class="error-container danger w-100"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-6 col-xs-12">

                                        <div class="form-group">
                                            <label for="last-name">Latitude</label>
                                            <input maxlength="20"
                                                   type="number" id="lat"
                                                   name="lat"
                                                   class="form-control">
                                            <span class="error-container danger w-100"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-6 col-xs-12">

                                        <div class="form-group">
                                            <label for="last-name">Longitude</label>
                                            <input maxlength="20"
                                                   type="number" id="long"
                                                   name="long"
                                                   class="form-control">
                                            <span class="error-container danger w-100"></span>
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-sm-12 col-xs-12">

                                        <div class="form-group">
                                            <label for="middle-name">Consignee
                                                Address<span class="danger">*</span></label>
                                            <textarea maxlength="250" data-rule-required="true"
                                                      data-msg-required="Address field is required" id="consignee_address"
                                                      class="form-control"
                                                      name="consignee_address"></textarea>
                                            <span class="error-container danger w-100"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3 sbmt-btn-mar">

                                        <div class="form-group">
                                            <a href="<?php echo url_secure('manage_client/consignee') ?>">
                                                <button class="btn btn-danger" type="button">Cancel</button>
                                            </a>
                                            <button type="submit"
                                                    class="btn btn-success">{{ (Request::segment(3) == 'edit') ? 'Update' : 'Submit' }}</button>
                                        </div>
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
    <script src="<?php echo url_secure('vendors/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js') ?>"></script>
    <script>

        const token = getToken();
        const headers = {
            "Authorization": `Bearer ${token}`
        };

        $(document).ready(function () {
            $("#city_id").select2({
                placeholder: "Search City",
                // minimumInputLength: 2, // Minimum characters before sending the AJAX request
                ajax: {
                    url: "{{ api_url('get_cities') }}", // Replace with your actual server endpoint
                    dataType: "json",
                    delay: 250, // Delay before sending the request in milliseconds
                    headers: headers,
                    processResults: function (data) {
                        return {
                            results: data.map(function (item) {
                                return {
                                    id: item.id,
                                    text: item.label // 'text' property is required by Select2
                                };
                            })
                        };
                    },
                    cache: true // Enable caching of AJAX results
                }
            });

            $("#area_id").select2({
                placeholder: "Search Area",
                // minimumInputLength: 2, // Minimum characters before sending the AJAX request
                ajax: {
                    url: "{{ api_url('get_areas') }}", // Replace with your actual server endpoint
                    dataType: "json",
                    data: function (params) {
                        return {
                            term: params.term,
                            city_id:  $('#city_id').val(),
                        };
                    },
                    delay: 250, // Delay before sending the request in milliseconds
                    headers: headers,
                    processResults: function (data) {
                        return {
                            results: data.map(function (item) {
                                return {
                                    id: item.id,
                                    text: item.label // 'text' property is required by Select2
                                };
                            })
                        };
                    },
                    cache: true // Enable caching of AJAX results
                }
            });

            $("#subarea_id").select2({
                placeholder: "Search Block",
                // minimumInputLength: 2, // Minimum characters before sending the AJAX request
                ajax: {
                    url: "{{ api_url('get_blocks') }}", // Replace with your actual server endpoint
                    dataType: "json",
                    data: function (params) {
                        return {
                            term: params.term,
                            area_id:  $('#area_id').val(),
                        };
                    },
                    delay: 250, // Delay before sending the request in milliseconds
                    headers: headers,
                    processResults: function (data) {
                        return {
                            results: data.map(function (item) {
                                return {
                                    id: item.id,
                                    text: item.label // 'text' property is required by Select2
                                };
                            })
                        };
                    },
                    cache: true // Enable caching of AJAX results
                }
            });
        });


        $("#consignee_form").validate({
            errorClass: "danger",
            errorPlacement: function (error, element) {
                error.addClass('w-100').appendTo(element.parent(0));
            },
            submitHandler: function (form, event) {
                event.preventDefault();

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Submit'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var data = $('#consignee_form').serialize();
                        $.ajax({
                            url: '<?php echo api_url('manage_client/consignee/submit'); ?>',
                            method: 'POST',
                            data: data,
                            dataType: 'json', // Set the expected data type to JSON
                            headers: headers,
                            beforeSend: function () {
                                $('.error-container').html('');
                            },
                            success: function (data) {
                                if (data && data.status == 1) {
                                    Swal.fire(
                                        'Saved!',
                                        'Form has been submitted successfully',
                                        'success'
                                    );
                                    window.location.href = '<?php echo url_secure('/manage_client/consignee') ?>'
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
                })
            }
        });


        const url = window.location.search;
        if (url) {
            const urlParams = new URLSearchParams(url);
            const id = atob(urlParams.get('id'));
            $.ajax({
                url: '<?php echo api_url('manage_client/consignee/edit'); ?>',
                method: 'GET',
                data: {ajax: true, id: id},
                headers: headers,
                dataType: 'json', // Set the expected data type to JSON
                beforeSend: function () {
                    $('.error-container').html('');
                },
                success: function (data) {
                    if (data && data.status == 1) {
                        editForm(data.data.consignee);
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
                var option = "";
                var input = $('input[name="' + element + '"], textarea[name="' + element + '"], select[name="' + element + '"]');
                if (input.is(':checkbox')) {
                    if (input.val() === values[index]) {
                        input.prop('checked', true);
                        if (element === 'is_settlement') {
                            $('.bank').removeAttr('disabled');
                        }
                    }
                } else if (input.is(':radio')) {
                    $(`input[name="${element}"][value=${values[index]}]`).trigger('click');
                } else if (input.is('select')) {
                    if (element === 'city_id' && data.city.id) {
                        option = new Option(data.city.city_name, data.city.id, true, true);
                        $('#city_id').append(option).trigger('change');
                    }
                    else if (element === 'area_id' && data.area.id) {
                        option = new Option(data.area.area_title, data.area.id, true, true);
                        $('#area_id').append(option).trigger('change');
                    }
                    else if (element === 'subarea_id' && data.subarea.id) {
                        option = new Option(data.subarea.subarea_title, data.subarea.id, true, true);
                        $('#subarea_id').append(option).trigger('change');
                    }
                    else {
                        input.val(values[index]);
                        input.trigger('change');
                    }
                } else {

                    if (element === 'id') {
                        input.prop('disabled', false);
                    }
                    input.val(values[index]);
                }
            });
        }


    </script>

@endsection
