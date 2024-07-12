@extends('Admin.layout.main')

@section('styles')
    <link rel="stylesheet" href="{{ url_secure('build/css/jquery_ui.css')}}">
    <style>
        .container h1 {
            color: #fff;
            text-align: center;
        }

        details {
            background-color: #303030;
            color: #fff;
            font-size: 1.5rem;
        }

        summary {
            padding: .5em 1.3rem;
            list-style: none;
            display: flex;
            justify-content: space-between;
            transition: height 1s ease;
        }

        summary::-webkit-details-marker {
            display: none;
        }

        summary:after {
            content: "\002B";
        }

        details[open] summary {
            border-bottom: 1px solid #aaa;
            margin-bottom: .5em;
        }

        details[open] summary:after {
            content: "\00D7";
        }

        details[open] div {
            padding: .5em 1em;
        }

        .rights-section {
            margin-top: 5%;
        }

        .rights-section details {
            background-color: #ffcb05;
            color: black;
            margin-top: 1%;
        }
        .select2-container{
            width: 514px!important;
        }
    </style>
@endsection

@section('title') Users {{ (Request::segment(2) == 'edit') ? 'Edit' : 'Add' }}  @endsection

@section('content')
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Manage Users</h3>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>{{ (Request::segment(2) == 'edit') ? 'Edit' : 'Add' }}</h2>
                            <ul class="nav navbar-right panel_toolbox justify-content-end">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <form id="add-user" action="" novalidate="novalidate" data-parsley-validate
                                  class="form-horizontal form-label-left" method="post">
                                <div class="row">
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label>First Name *</label>
                                            <input type="text" id="first_name" name="first_name"
                                                   data-rule-required="true"
                                                   data-msg-required="first name field is required"
                                                   class="form-control">
                                            <span class="error-container danger w-100"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="last_name">Last Name *</label>

                                            <input type="text" id="last_name" name="last_name" data-rule-required="true"
                                                   data-msg-required="last name field is required" class="form-control">
                                            <span class="error-container danger w-100"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="mobile">Mobile </label>

                                            <input id="mobile" class="form-control"
                                                   data-inputmask="'mask' : '99999999999'"
                                                   type="text" name="mobile">
                                            <span class="error-container danger w-100"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="phone">TelePhone</label>

                                            <input id="phone" class="form-control" type="text"
                                                   data-inputmask="'mask' : '(999) 999-9999'" name="phone">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label>Country </label>
                                            <select class="select2 form-control" name="country_id" id="country_id"
                                                    tabindex="-1"></select>
                                            <span class="error-container danger w-100"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label>City </label>

                                            <select class="select2 form-control" name="city_id" id="city_id"
                                                    tabindex="-1"></select>
                                            <span class="error-container danger w-100"></span>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label>Merchant </label>
                                            <select class="select2 form-control" name="merchant_id" id="merchant_id"
                                                    onchange=" (this.value.length > 0) ? $('#role_id').prop('disabled',false) :$('#role_id').prop('disabled',true) "
                                                    tabindex="-1" data-rule-required="true"
                                                    data-msg-required="Merchant is requried"></select>
                                            <span class="error-container danger w-100"></span>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label>Role * </label>

                                            <select class="select2 form-control" tabindex="-1" data-rule-required="true" disabled
                                                    data-msg-required="Role field is required" name="role_id" id="role_id">
                                            </select>
                                            <span class="error-container danger w-100"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="username">User Name *</label>

                                            <input id="username" class="form-control" type="text" name="username"
                                                   data-rule-required="true"
                                                   data-msg-required="user name field is required">
                                            <span class="error-container danger w-100"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="email">Primary Email *</label>

                                            <input id="email" class="form-control" type="email" name="email"
                                                   data-rule-required="true"
                                                   data-msg-required="email field is required">
                                            <span class="error-container danger w-100"></span>
                                        </div>
                                    </div>

                                    <input type="hidden" value="" disabled name="id">
                                    <div class="col-md-6 col-sm-6 col-xs-12" id="pass">
                                        <div class="form-group">
                                            <label for="password">Password *</label>

                                            <input id="password" class="form-control" type="password" name="password"
                                                   data-rule-required="true"
                                                   data-msg-required="password field is required">
                                            <span class="error-container danger w-100"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12" id="conf-pass">
                                        <div class="form-group">
                                            <label for="password_confirmation">Confirm Password *</label>

                                            <input id="password_confirmation" class="form-control" type="password"
                                                   name="password_confirmation" data-rule-required="true"
                                                   data-msg-required="confirm password field is required">
                                            <span class="error-container danger w-100"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="date_of_birth">Date of Birth</label>

                                            <input id="date_of_birth" class="form-control" type="date"
                                                   name="date_of_birth">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label>Gender </label>

                                            <select class="select2 form-control" tabindex="-1" name="gender"
                                                    id="gender">
                                                <option></option>
                                                <option value="male">Male</option>
                                                <option value="female">Female</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label>User Type *</label>

                                            <select class="form-control" tabindex="-1" name="user_type_id"
                                                    id="user_type_id" data-rule-required="true"
                                                    data-msg-required="User type is requried">
                                                <option value="">Select User Type</option>

                                            </select>
                                            <span class="error-container danger w-100"></span>
                                        </div>
                                    </div>



                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <a href="<?php echo url_secure('manage_client/client') ?>">
                                                <button class="btn btn-danger" type="button">Cancel</button>
                                            </a>
                                            <button type="submit"
                                                    class="btn btn-success"><?php echo (isset($user['id'])) ? 'Update' : 'Submit'; ?></button>
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
    <script src="{{ url_secure('build/js/jquery_ui.js')}}"></script>
    <script src="<?php echo url_secure('vendors/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js') ?>"></script>
    <script src="<?php echo url_secure('vendors/validate/jquery.validate.min.js') ?>" type="text/javascript"></script>
    <script>
        const token = getToken();
        const headers = {
            "Authorization": `Bearer ${token}`,
        };

        $("#add-user").validate({
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
                        var data = $('#add-user').serialize();
                        $.ajax({
                            url: '<?php echo api_url('manage_client/client/submit'); ?>',
                            method: 'POST',
                            data: data,
                            headers: headers,
                            dataType: 'json', // Set the expected data type to JSON
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
                                    window.location.href = '<?php echo url_secure('/manage_client/client') ?>'
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
            if (id) {
                const pass = $('#pass');
                const confPass = $('#conf-pass');
                pass.hide();
                confPass.hide();
            }
            $.ajax({
                url: '<?php echo api_url('manage_client/client/edit'); ?>',
                method: 'GET',
                data: {ajax: true, id: id},
                headers: headers,
                dataType: 'json', // Set the expected data type to JSON
                beforeSend: function () {
                    $('.error-container').html('');
                },
                success: function (data) {
                    if (data && data.status == 1) {
                        editForm(data.data.user);
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
            var admin = '<option value="4">Merchant Admin</option>';
            var shipper = '<option value="5">Shipper Admin</option>';

            $('#user_type_id').append(admin+shipper);
        }

        function editForm(data) {
            var keys = Object.keys(data);
            var values = Object.values(data);

            $(keys).each(function (index, element) {

                var input = $('input[name="' + element + '"], textarea[name="' + element + '"], select[name="' + element + '"]');
                if(element == 'gender'){
                    if(data.gender == 'male'){
                        $('#gender').append(`<option value="male" selected>Male</option>`);
                    }else{
                        $('#gender').append(`<option value="female" selected>Female</option>`);
                    }
                }
                if (element === 'user_type_id') {
                    if(data.user_type_id == 4){
                        $('#user_type_id').append(`<option value="4" selected>Merchant Admin</option><option value="5">Merchant Shipper</option>`);
                    }else{
                        $('#user_type_id').append(`<option value="5" selected>Merchant Shipper</option><option value="4">Merchant Admin</option>`);
                    }
                }

                if (element === 'merchant_id') {
                    option = new Option(data.merchant.merchant_name, data.merchant.id, true, true);
                    $('#merchant_id').append(option).trigger('change');
                }

                if (input.is(':checkbox')) {
                    if (input.val() === values[index]) {
                        input.prop('checked', true);
                    }
                } else if (input.is('select')) {
                    if (element === 'city_id' && data.city_id != null) {
                        option = new Option(data.city.city_name, data.city.id, true, true);
                        $('#city_id').append(option).trigger('change');
                    } else if (element === 'role_id' && data.role_id != null) {
                        option = new Option(data.role.role_name, data.role.id, true, true);
                        $('#role_id').append(option).trigger('change');
                    } else if (data.city_id != null) {
                        option = new Option(data.city.country.country_name, data.city.country.id, true, true);
                        $('#country_id').append(option).trigger('change');
                    } else {
                        input.val(values[index]);
                        input.trigger('change');
                    }
                } else if (input.is(':radio')) {
                    $(`input[name="${element}"][value=${values[index]}]`).trigger('click');
                } else {
                    if (element === 'id') {
                        input.prop('disabled', false);
                    }
                    input.val(values[index]);
                }
            });
        }

        $(document).ready(function () {



            $("#role_id").select2({
                placeholder: "Search Role",
                // minimumInputLength: 2, // Minimum characters before sending the AJAX request
                allowClear: true,
                ajax: {
                    url: "{{ api_url('role_list_merchant') }}", // Replace with your actual server endpoint
                    dataType: "json",
                    delay: 250, // Delay before sending the request in milliseconds
                    headers: headers,
                    data: function (params) {
                        return {
                            term: params.term, // Search term entered by the user
                            merchant_id: $('#merchant_id').val()
                        };
                    },
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

            $("#city_id").select2({
                placeholder: "Search City",
                minimumInputLength: 2, // Minimum characters before sending the AJAX request
                allowClear: true,
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
            $("#country_id").select2({
                placeholder: "Search Country",
                minimumInputLength: 2, // Minimum characters before sending the AJAX request
                allowClear: true,
                ajax: {
                    url: "{{ api_url('get_countries') }}", // Replace with your actual server endpoint
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

            $("#merchant_id").select2({
                placeholder: "Search Merchant",
                // minimumInputLength: 2, // Minimum characters before sending the AJAX request
                allowClear: true,
                ajax: {
                    url: "{{ api_url('merchant_list_parent') }}", // Replace with your actual server endpoint
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

        });


    </script>

    <script src="{{ url_secure('build/js/main.js')}}"></script>
@endsection
