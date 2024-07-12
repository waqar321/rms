@extends('Admin.layout.main')


@push('scripts')

    <!-- Datatables -->
    <link href="{{ url_secure('vendors/datatables.net-bs/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ url_secure('vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ url_secure('vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ url_secure('vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ url_secure('vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css')}}" rel="stylesheet">
    <link href="https://editor.datatables.net/extensions/Editor/css/editor.dataTables.min.css" rel="stylesheet">
    <!--    additional datatables-->
    <link href="{{ url_secure('vendors/datatable/vendors/css/tables/datatable/datatables.min.css')}}" rel="stylesheet"/>

    <link href="{{ url_secure('vendors/select2/dist/css/select2.min.css')}}" rel="stylesheet">

@endpush 

@section('styles')

    <link rel="stylesheet" href="{{ url_secure('build/css/jquery_ui.css')}}">
    
    <style>

        .select2-container {
            /* width: 598px!important */
            display: block !important;
        }

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
        /* .select2-container{
            width: 514px!important;
        } */
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
                    <div class="x_panel collapse-link" >
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
                                    {{--<div class="col-md-6 col-sm-6 col-xs-12">--}}
                                    {{--<div class="form-group">--}}
                                    {{--<label for="phone">TelePhone</label>--}}

                                    {{--<input id="phone" class="form-control" type="text"--}}
                                    {{--data-inputmask="'mask' : '(999) 999-9999'" name="phone">--}}
                                    {{--</div>--}}
                                    {{--</div>--}}
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
                                            <label>Role * </label>

                                            <select class="select2 form-control" tabindex="-1" data-rule-required="true"
                                                    data-msg-required="Role field is required" name="role_id"
                                                    id="role_id">
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

                                            <input id="password" class="form-control" type="password" name="password" autocomplete="off">
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
                        {{--<div class="col-md-6 col-sm-6 col-xs-12">--}}
                        {{--<div class="form-group">--}}
                        {{--<label for="date_of_birth">Date of Birth</label>--}}

                        {{--<input id="date_of_birth" class="form-control" type="date"--}}
                        {{--name="date_of_birth">--}}
                        {{--</div>--}}
                        {{--</div>--}}
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
                                            <label for="employee_id">Employee Id</label>
                                            <input id="employee_id" class="form-control" type="number"
                                                   name="employee_id">
                                        </div>
                                    </div>

                                    <!-- <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="domain_name">Domain Name</label>
                                            <input id="domain_name" class="form-control" type="text"
                                                   name="domain_name">
                                        </div>
                                    </div> -->

                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <a href="<?php echo url_secure('manage_user') ?>">
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

@push('scripts')


        <script src="{{ url_secure('vendors/datatables.net/js/jquery.dataTables.min.js')}}"></script>
        <script src="{{ url_secure('vendors/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
        <script src="{{ url_secure('vendors/datatables.net-buttons/js/dataTables.buttons.min.js')}}"></script>
        <script src="{{ url_secure('vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js')}}"></script>
        <script src="{{ url_secure('vendors/datatables.net-buttons/js/buttons.flash.min.js')}}"></script>
        <script src="{{ url_secure('vendors/datatables.net-buttons/js/buttons.html5.min.js')}}"></script>
        <script src="{{ url_secure('vendors/datatables.net-buttons/js/buttons.print.min.js')}}"></script>
        <script src="{{ url_secure('vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js')}}"></script>
        <script src="{{ url_secure('vendors/datatables.net-keytable/js/dataTables.keyTable.min.js')}}"></script>
        <script src="{{ url_secure('vendors/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
        <script src="{{ url_secure('vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js')}}"></script>
        <script src="{{ url_secure('vendors/datatables.net-scroller/js/dataTables.scroller.min.js')}}"></script>
        <script src="https://editor.datatables.net/extensions/Editor/js/dataTables.editor.min.js"></script>

        <script src="{{ url_secure('vendors/select2/dist/js/select2.full.min.js')}}"></script>

@endpush 
@section('scripts')
    
    <script>
        
        const token = getToken();
        const headers = {
            "Authorization": `Bearer ${token}`,
        };

        function userType(){
            var userTypeId = document.getElementById("user_type_id").value;
            if(userTypeId == 5){
                document.getElementById('merchant-client').style.display = 'block';
            }else{
                document.getElementById('merchant-client').style.display = 'none';
            }
        }


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
                            url: '<?php echo api_url('manage_user/submit'); ?>',
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
                                    window.location.href = '<?php echo url_secure('/manage_user') ?>'
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
                const confPass = $('#conf-pass');
                confPass.hide();
            }
            $.ajax({
                url: '<?php echo api_url('manage_user/edit'); ?>',
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

                if(element == 'id'){
                    document.getElementById("password").value = '';
                }


                // if (element === 'user_type_id') {
                //     if(data.user_type_id == 3){
                //         $('#user_type_id').append(`<option value="3" selected>Admin User</option>`);
                //     }else{
                //         $('#user_type_id').append(`<option value="5" selected>Shipper User</option>`);
                //     }
                // }

                // if(data.merchant_id != 0){
                //     document.getElementById('merchant-client').style.display = 'block';
                // }
                //
                // if (element === 'merchant_id') {
                //     console.log(data.merchant.merchant_name);
                //     option = new Option(data.merchant.merchant_name, data.merchant.id, true, true);
                //     $('#merchant_id').append(option).trigger('change');
                // }

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

        $(document).ready(function () 
        {
            $("#role_id").select2({
                placeholder: "Search Role",
                // minimumInputLength: 2, // Minimum characters before sending the AJAX request
                allowClear: true,
                ajax: {
                    url: "{{ api_url('role_list') }}", // Replace with your actual server endpoint
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
                // placeholder: "Search Merchant",
                // minimumInputLength: 2, // Minimum characters before sending the AJAX request
                allowClear: true,
                ajax: {
                    url: "{{ api_url('merchant_list') }}", // Replace with your actual server endpoint
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
