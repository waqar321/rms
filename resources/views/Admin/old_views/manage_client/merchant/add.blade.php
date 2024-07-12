@extends('Admin.layout.main')

@section('styles')
    <link rel="stylesheet" href="{{ url_secure('build/css/jquery_ui.css')}}">
    <style>
        .address {
            margin-left: -5px !important;
        }

        .table-tr-class-dynamic-table {
            margin-left: 5px;
            margin-bottom: 0px !important;
        }

        #employee-table tbody tr {
            margin-top: 4px;
        }

        .dynamic-table-input {
            margin-bottom: 1px;
        }

        .radio-settlement {
            margin-top: 11px !important;
        }

        .div-space {
            margin-bottom: 8%;
        }

        .stepContainer {
            height: 550px !important;
        }

        .divider {
            border-top: 1px solid #ccc;
            margin: 20px;
        }

        .float-right {
            padding: 6px;
        }

        .select2-container {
            display: inline;
        }
    </style>
@endsection

@section('title') Merchant Add @endsection

@section('content')

    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_content">
                            <h2>Client Add</h2>

                            <div id="wizard" class="form_wizard wizard_horizontal">
                                <ul class="wizard_steps anchor">
                                    <li>
                                        <a href="#step-11" class="selected" isdone="1" rel="1">
                                            <span class="step_no">1</span>
                                            <span class="step_descr">
                                              Step 1<br>
                                              <small>General Information</small>
                                          </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#step-22" class="selected" isdone="0" rel="2">
                                            <span class="step_no">2</span>
                                            <span class="step_descr">
                                              Step 2<br>
                                              <small>Contacts</small>
                                          </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#step-33" class="selected" isdone="0" rel="3">
                                            <span class="step_no">3</span>
                                            <span class="step_descr">
                                              Step 3<br>
                                              <small>Bank & Login Information</small>
                                          </span>
                                        </a>
                                    </li>
                                </ul>
                                <div id="step-11" class="col-md-12 content">
                                    <form id="company_form" action="" novalidate="novalidate" data-parsley-validate
                                          class="form-horizontal form-label-left" method="post">
                                        <div class="form-group col-md-6">
                                            <label class="control-label col-md-4 col-sm-4" for="account-opening-date">A/C
                                                Opening Date <span class="required text-danger">*</span>
                                            </label>
                                            <div class="col-md-8 col-sm-8">
                                                <input type="date" id="account_opening_date"
                                                       name="merchant_account_opening_date" value="{{ date('Y-m-d') }}"
                                                       data-rule-required="true"
                                                       data-msg-required="This field is required" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="control-label col-md-4 col-sm-4 col-xs-12">Account
                                                Status<span class="required text-danger">*</span>
                                            </label>
                                            <div class="col-md-8 col-sm-8 col-xs-12">
                                                <select data-rule-required="true"
                                                        data-msg-required="This field is required" class="form-control"
                                                        name="is_active" id="is_active">
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="control-label col-md-4 col-sm-4 col-xs-12">Country<span
                                                    class="required text-danger">*</span></label>
                                            <div class="col-md-8 col-sm-8 col-xs-12">
                                                <select class="form-control" name="country_id" id="country_id"
                                                        data-rule-required="true"
                                                        data-msg-required="This field is required">
                                                    <option value="166">Pakistan</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="control-label col-md-4 col-sm-4 col-xs-12">City<span
                                                    class="required text-danger">*</span></label>
                                            <div class="col-md-8 col-sm-8 col-xs-12">
                                                <select class="form-control" name="city_id" id="city_id"
                                                        data-rule-required="true"
                                                        data-msg-required="This field is required">
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label class="control-label col-md-4 col-sm-4">Search Client<span
                                                    class="required text-danger">*</span></label>
                                            <div class="col-md-8 col-sm-8">
                                                <input id="search_merchant" name="merchant_account_no"
                                                       class="form-control" type="text" data-rule-required="true"
                                                       data-msg-required="This field is required">
                                                <input id="merchant_id" type="hidden" name="merchant_id">
                                            </div>
                                        </div>

                                        <input type="hidden" name="id" id="id" value="">
                                        <div class="form-group col-md-6">
                                            <label class="control-label col-md-4 col-sm-4 col-xs-12">Account
                                                Type<span class="required text-danger">*</span></label>
                                            <div class="col-md-8 col-sm-8 col-xs-12">

                                                <select data-rule-required="true"
                                                        data-msg-required="This field is required" class="form-control"
                                                        name="account_type_id" id="account_type_id">
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="control-label col-md-4 col-sm-4">Client Name <span
                                                    class="required text-danger">*</span></label>
                                            <div class="col-md-8 col-sm-8">
                                                <input id="merchant_name" name="merchant_name" data-rule-required="true"
                                                       data-msg-required="This field is required"
                                                       class="form-control" type="text">
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="control-label col-md-4 col-sm-4">Branch Code Name </label>
                                            <div class="col-md-8 col-sm-8">
                                                <input id="company_branch" name="company_branch"
                                                       class="form-control" type="text">
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="control-label col-md-4 col-sm-4">Phone </label>
                                            <div class="col-md-8 col-sm-8">
                                                <input id="merchant_phone" name="merchant_phone"
                                                       class="form-control" type="number">
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="control-label col-md-4 col-sm-4">Fax </label>
                                            <div class="col-md-8 col-sm-8">
                                                <input id="fax_no" name="fax" class="form-control"
                                                       type="number">
                                            </div>
                                        </div>
                                        <div class="form-group col-md-12 address">
                                            <label class="control-label col-md-2 col-sm-2">Address <span
                                                    class="required text-danger">*</span></label>
                                            <div class="col-md-10 col-sm-10">
                                                <textarea id="merchant_address1" name="merchant_address1"
                                                          class="form-control" data-rule-required="true"
                                                          data-msg-required="This field is required"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="control-label col-md-4 col-sm-4 col-xs-12">Client Type<span
                                                    class="required text-danger">*</span></label>
                                            <div class="col-md-8 col-sm-8 col-xs-12">
                                                <select data-rule-required="true"
                                                        data-msg-required="This field is required" class="form-control"
                                                        name="client_type" id="client_type">
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group col-md-6">
                                                <label class="control-label col-md-4 col-sm-4">G.S.T %</label>
                                                <div class="col-md-8 col-sm-8" style="margin-left: -6px;">
                                                    <input id="merchant_gst_per" name="merchant_gst_per"
                                                           class="form-control" type="number">
                                                </div>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label class="control-label col-md-4 col-sm-4">Discount (%)</label>
                                                <div class="col-md-8 col-sm-8">
                                                    <input id="merchant_discount" name="merchant_discount"
                                                           class="form-control" type="number">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12" id="gst" style="display: none">
                                            <div class="form-group col-md-6">
                                                <label class="control-label col-md-4 col-sm-4">G.S.T No</label>
                                                <div class="col-md-8 col-sm-8" style="margin-left: -6px;">
                                                    <input id="merchant_gst" name="merchant_gst"
                                                           class="form-control" type="number">
                                                </div>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label class="control-label col-md-4 col-sm-4">N.T.N No</label>
                                                <div class="col-md-8 col-sm-8">
                                                    <input id="merchant_ntn" name="merchant_ntn"
                                                           class="form-control" type="number">
                                                </div>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                                <div id="step-22">
                                    <form id="company_form2" action="" novalidate="novalidate" data-parsley-validate
                                          class="form-horizontal form-label-left" method="post">
                                        <div class="col-md-10" style="padding-bottom: 15px;">
                                            <label class="control-label col-md-12 col-sm-12 col-xs-12">(Commision
                                                %)</label>
                                        </div>
                                        {{--                                        <div class="form-group col-md-12">--}}
                                        {{--                                            <label class="control-label col-md-2 col-sm-6 col-xs-12">Referred By</label>--}}
                                        {{--                                            <div class="col-md-3 col-sm-6">--}}
                                        {{--                                                <input id="referred_by_id" name="referred_by_id"--}}
                                        {{--                                                       class="form-control" type="text" disabled>--}}
                                        {{--                                            </div>--}}
                                        {{--                                            <div class="col-md-3 col-sm-6 col-xs-12">--}}
                                        {{--                                                <select class="form-control select2" id="referred_by"--}}
                                        {{--                                                        name="referred_by">--}}
                                        {{--                                                    <option value="">Select Referrer</option>--}}
                                        {{--                                                </select>--}}
                                        {{--                                            </div>--}}
                                        {{--                                            <div class="col-md-3 col-sm-6">--}}

                                        {{--                                                <input id="referred_commission" name="referred_commission"--}}
                                        {{--                                                       class="form-control" type="number">--}}
                                        {{--                                            </div>--}}
                                        {{--                                        </div>--}}
                                        {{--                                        <div class="form-group col-md-12">--}}
                                        {{--                                            <label class="control-label col-md-2 col-sm-6 col-xs-12">Recovery By</label>--}}
                                        {{--                                            <div class="col-md-3 col-sm-6">--}}
                                        {{--                                                <input id="recovery_by_id" name="recovery_by_id"--}}
                                        {{--                                                       class="form-control" type="text" disabled>--}}
                                        {{--                                            </div>--}}
                                        {{--                                            <div class="col-md-3 col-sm-6 col-xs-12">--}}
                                        {{--                                                <select class="form-control select2" id="recovery_by"--}}
                                        {{--                                                        name="recovery_by">--}}
                                        {{--                                                    <option value="">Select Recovery Person</option>--}}
                                        {{--                                                </select>--}}
                                        {{--                                            </div>--}}
                                        {{--                                            <div class="col-md-3 col-sm-6">--}}
                                        {{--                                                <input id="recovery_commission" name="recovery_commission"--}}
                                        {{--                                                       class="form-control" type="number">--}}
                                        {{--                                            </div>--}}
                                        {{--                                        </div>--}}
                                        {{--                                        <div class="form-group col-md-12">--}}
                                        {{--                                            <label class="control-label col-md-2 col-sm-6 col-xs-12">Sales--}}
                                        {{--                                                Person</label>--}}
                                        {{--                                            <div class="col-md-3 col-sm-6">--}}
                                        {{--                                                <input id="sale_person_id" name="sale_person_id"--}}
                                        {{--                                                       class="form-control" type="text" disabled>--}}
                                        {{--                                            </div>--}}
                                        {{--                                            <div class="col-md-3 col-sm-6 col-xs-12">--}}
                                        {{--                                                <select class="form-control select2" id="sale_person"--}}
                                        {{--                                                        name="sale_person">--}}
                                        {{--                                                    <option value="">Select Sales Person</option>--}}
                                        {{--                                                </select>--}}
                                        {{--                                            </div>--}}
                                        {{--                                            <div class="col-md-3 col-sm-6">--}}
                                        {{--                                                <input id="sale_person_commission" name="sale_person_commission"--}}
                                        {{--                                                       class="form-control" type="number">--}}
                                        {{--                                            </div>--}}
                                        {{--                                        </div>--}}
                                        <div class="form-group col-md-12 divider"></div>
                                        <div class="col-md-12">
                                            <div class="form-group col-md-6">
                                                <label class="control-label col-md-4 col-sm-4 col-xs-12">Recovery
                                                    City</label>
                                                <div class="col-md-8 col-sm-8 col-xs-12">
                                                    <select class="form-control" id="recovery_city_id"
                                                            name="recovery_city_id">
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label class="control-label col-md-4 col-sm-4">Commission Month</label>
                                                <div class="col-md-8 col-sm-8">
                                                    <input id="commissionable_month" name="commissionable_month"
                                                           class="form-control" type="text">
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <label class="control-label col-md-2 col-sm-6 col-xs-12">Pickup Timing
                                                    *</label>
                                                <div class="col-md-5 col-sm-5">
                                                    <input id="pickup_start_time" placeholder="From"
                                                           name="pickup_start_time" class="form-control col-md-12 col-xs-12"
                                                           type="time" data-rule-required="true"
                                                           data-msg-required="This field is required">
                                                </div>
                                                <div class="col-md-5 col-sm-5">
                                                    <input id="pickup_end_time" placeholder="From" name="pickup_end_time"
                                                           class="form-control col-md-12 col-xs-12" type="time"
                                                           data-rule-required="true"
                                                           data-msg-required="This field is required">
                                                </div>
                                            </div>

                                        </div>
                                        <div class="form-group col-md-12 divider"></div>
                                        <div class="form-group col-md-12">
                                            <label class="control-label col-md-2 col-sm-6 col-xs-12">Contact
                                                Person</label>
                                            <div class="col-md-10 col-sm-9">
                                                <table id="employee-table" class="col-md-12 col-sm-12">
                                                    <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Designation</th>
                                                        <th>Phone</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td><input type="text"
                                                                   class="form-control dynamic-table-input"
                                                                   placeholder="Name"
                                                                   name="contact_person1" id="contact_person1"></td>
                                                        <td><input type="text"
                                                                   class="form-control dynamic-table-input"
                                                                   placeholder="Designation"
                                                                   name="contact_person_des1" id="contact_person_des1">
                                                        </td>
                                                        <td><input type="text"
                                                                   class="form-control dynamic-table-input"
                                                                   placeholder="Phone"
                                                                   name="contact_person_phone1"
                                                                   id="contact_person_phone1"></td>
                                                    </tr>
                                                    <tr>
                                                        <td><input type="text"
                                                                   class="form-control dynamic-table-input"
                                                                   placeholder="Name"
                                                                   name="contact_person2" id="contact_person2"></td>
                                                        <td><input type="text"
                                                                   class="form-control dynamic-table-input"
                                                                   placeholder="Designation"
                                                                   name="contact_person_des2" id="contact_person_des2">
                                                        </td>
                                                        <td><input type="text"
                                                                   class="form-control dynamic-table-input"
                                                                   placeholder="Phone"
                                                                   name="contact_person_phone2"
                                                                   id="contact_person_phone2"></td>
                                                    </tr>
                                                    <tr>
                                                        <td><input type="text"
                                                                   class="form-control dynamic-table-input"
                                                                   placeholder="Name"
                                                                   name="contact_person3" id="contact_person3"></td>
                                                        <td><input type="text"
                                                                   class="form-control dynamic-table-input"
                                                                   placeholder="Designation"
                                                                   name="contact_person_des3" id="contact_person_des3">
                                                        </td>
                                                        <td><input type="text"
                                                                   class="form-control dynamic-table-input"
                                                                   placeholder="Phone"
                                                                   name="contact_person_phone3"
                                                                   id="contact_person_phone3"></td>
                                                    </tr>
                                                    </tbody>

                                                </table>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-12 divider"></div>
                                        <div class="form-group col-md-12" id="packing_material_rate">

                                        </div>
                                    </form>
                                </div>
                                <div id="step-33">
                                    <form id="company_form3" action="" novalidate="novalidate" data-parsley-validate
                                          class="form-horizontal form-label-left" method="post">
                                        <input type="hidden" id="is_settlement" name="is_settlement" value="1">
                                        <div class="row">
                                            <h2 class="StepTitle col-md-2">Bank Information</h2>
                                            <div class="col-md-10 col-sm-12 col-xs-12 mb-3 text-right" id="add-more">
                                                <div class="form-group">
                                                    <button onclick="addFields()" type="button"
                                                            class="btn btn-success btn-sm">Add Bank Details
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="form-container" class="col-md-12"></div>

                                        <h2 class="StepTitle">Login Information</h2>
                                        <hr>

                                        <div class="form-group col-md-6">
                                            <label class="control-label col-md-6 col-sm-6"> Name</label>
                                            <div class="col-md-6 col-sm-6">
                                                <input class="form-control" type="text" disabled
                                                       name="merchant_name" id="name" data-rule-required="true"
                                                       data-msg-required="This field is required">
                                            </div>
                                        </div>
                                        <input type="hidden" id="is_settlement" name="is_settlement" value="1">
                                        <div class="form-group col-md-6">
                                            <label class="control-label col-md-6 col-sm-6">User Name*</label>
                                            <div class="col-md-6 col-sm-6">
                                                <input class="form-control" type="text"
                                                       name="user_name" id="user_name" data-rule-required="true"
                                                       data-msg-required="This field is required">
                                            </div>
                                        </div>
                                        <input id="merchant_email" class="form-control" type="hidden"
                                               name="merchant_email"
                                               id="merchant_email" data-rule-required="true"
                                               data-msg-required="This field is required">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /page content -->
@endsection
@section('scripts')
    <script>
        var thiss = "";
        var valid_1 = false;
        var valid_2 = false;
        var valid_3 = false;
    </script>
    <script src="{{ url_secure('build/js/jquery_ui.js')}}"></script>
    <script src="<?php echo url_secure('vendors/jQuery-Smart-Wizard/js/jquery.smartWizard.js?id=10') ?>"></script>
    <script src="<?php echo url_secure('vendors/validate/jquery.validate.min.js') ?>" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function () {

            $("#bank_id").select2({
                placeholder: "Search Banks",
                minimumInputLength: 2, // Minimum characters before sending the AJAX request
                allowClear: true,
                ajax: {
                    url: "{{ api_url('bank_list') }}", // Replace with your actual server endpoint
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

            $("#recovery_city_id").select2({
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

        });

        $('body').on('change', '#client_type', function () {
            const client_type = $(this).val();
            const gstElement = $('#gst');
            if (client_type == 1) {
                gstElement.show();
            } else {
                gstElement.hide();
            }
        });

    </script>

    <script>
        const token = getToken();
        const headers = {
            "Authorization": `Bearer ${token}`,
        };

        $("#company_form").validate({
            errorClass: "danger",
            errorPlacement: function (error, element) {
                error.addClass('w-100').appendTo(element.parent(0));
            },
            submitHandler: function (form, event) {
                event.preventDefault();
            }
        });

        $("#company_form2").validate({
            errorClass: "danger",
            errorPlacement: function (error, element) {
                error.addClass('w-100').appendTo(element.parent(0));
            },
            submitHandler: function (form, event) {
                event.preventDefault();
            }
        });

        $("#company_form3").validate({
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
                        var data = $('#company_form').serialize() + "&" + $('#company_form2').serialize() + "&" + $('#company_form3').serialize();
                        $.ajax({
                            url: '<?php echo api_url('manage_client/merchant/submit'); ?>',
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
                                    window.location.href = '<?php echo url_secure('/manage_client/merchant') ?>'
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
                url: '<?php echo api_url('manage_client/merchant/edit'); ?>',
                method: 'GET',
                data: {ajax: true, id: id},
                dataType: 'json', // Set the expected data type to JSON
                headers: headers,
                beforeSend: function () {
                    $('.error-container').html('');
                },
                success: function (data) {
                    if (data && data.status == 1) {
                        editForm(data.data.merchant, data.data.merchant.bank_detail);
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
        } else {
            $.ajax({
                url: '<?php echo api_url('manage_client/merchant/getPackingMaterial'); ?>',
                method: 'GET',
                data: {ajax: true},
                dataType: 'json', // Set the expected data type to JSON
                headers: headers,
                beforeSend: function () {
                    $('.error-container').html('');
                },
                success: function (data) {
                    if (data && data.status == 1) {
                        getPackingMaterial(data.data);
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

        function editForm(data, banks) {
            var keys = Object.keys(data);
            var values = Object.values(data);

            getPackingMaterial(data.packingMaterialRate);
            Object.keys(data.packingMaterialRate).forEach(function (index) {
                var merchantMaterial = data.packingMaterialRate[index];
                if (data.packingMaterialRate.length > 0) {
                    $('#material_value' + index).val(merchantMaterial.material_value);
                    $('#material_value' + index).addClass('disabled').prop('disabled', true);
                }
            });

            banks.forEach(function (obj) {
                addFields(obj);
            });

            $(keys).each(function (index, element) {
                $('#account_opening_date').addClass('disabled').prop('disabled', true);
                $('#search_merchant').addClass('disabled').prop('disabled', true);

                $('#commissionable_month').val(data.commissionable_month);
                $('#merchant_id').val(data.id);
                $('#id').val(data.id);
                $('#merchant_name').val(data.merchant_name);
                // $('#referred_by_id').val(data.referred_by_id);
                // $('#referred_commission').val(data.referred_commission);
                // $('#recovery_by').val(data.recovery_by);
                // $('#recovery_commission').val(data.recovery_commission);
                // $('#sale_person').val(data.sale_person);
                // $('#sale_person_commission').val(data.sale_person_commission);
                $('#contact_person1').val(data.merchant_representative_name);
                $('#contact_person_des1').val(data.merchant_representative_des);
                $('#contact_person_phone1').val(data.merchant_representative_phone);
                $('#contact_person2').val(data.merchant_representative_name2);
                $('#contact_person_des2').val(data.merchant_representative_des2);
                $('#contact_person_phone2').val(data.merchant_representative_phone2);
                $('#contact_person3').val(data.merchant_representative_name3);
                $('#contact_person_des3').val(data.merchant_representative_des3);
                $('#contact_person_phone3').val(data.merchant_representative_phone3);
                $('#search_merchant').val(data.merchant_id);
                $('#name').val(data.merchant_name);
                $('#company_branch').val(data.company_branch);
                $('#merchant_phone').val(data.merchant_phone);
                $('#merchant_address1').val(data.merchant_address1);
                $('#fax_no').val(data.fax_no);
                $('#merchant_ntn').val(data.merchant_ntn);
                $('#merchant_gst').val(data.merchant_gst);
                $('#merchant_gst_per').val(data.merchant_gst_per);
                $('#merchant_discount').val(data.merchant_discount);
                $('#merchant_email').val(data.merchant_email);
                $('#user_name').val(data.admin_user.username);
                $('#pickup_start_time').val(data.merchant_details.pickup_start_time);
                $('#pickup_end_time').val(data.merchant_details.pickup_end_time);


                var Iac = `<option value="0">In-Active</option>`;
                var ac = `<option  value="1">Active</option>`;
                var cod = `<option  value="1">COD</option>`;
                var gen = `<option value="0">General</option>`;
                var ntn = data.merchant_ntn;
                if (element == 'is_active') {
                    if (data.is_active == 1) {
                        $('#is_active').append(ac + Iac);
                        $('#account_type_id').append(cod + gen);
                    } else {
                        $('#account_type_id').append(gen + cod);
                        $('#is_active').append(Iac + ac);
                    }
                }
                $('#city_id').append(`<option value="` + data.city_id + `">` + data.city + `</option>`);

                if (element === 'merchant_ntn') {
                    var nreg = `<option value="0">Non Registered</option>`;
                    var reg = `<option  value="1">Registered</option>`;
                    if (data.merchant_ntn != null) {
                        $('#client_type').append(reg + nreg).trigger('change');
                    } else {
                        $('#client_type').append(nreg + reg).trigger('change');
                    }
                }

                $('#recovery_city_id').append(`<option value="` + data.recovery_city_id + `" selected>` + data.recovery_city + `</option>`);
            });
        }


        $(function () {
            $("#search_merchant").autocomplete({
                source: function (request, response) {
                    $.ajax({
                        url: "{{ api_url('manage_client/merchant/getClientDetail')}}",
                        dataType: "json",
                        data: {
                            term: request.term // Pass the search term entered by the user
                        },
                        headers: headers,
                        beforeSend: function () {
                            $('.merchant').attr('disabled', false);
                            $('.merchant').val('');
                            $('#merchant_id').val('');

                        },
                        success: function (data) {
                            data[0].bank_detail.forEach(function (obj) {
                                addFields(obj);
                            });
                            response(data);
                        }
                    });
                },
                focus: function (event, ui) {
                    return false;
                },
                select: function (event, ui) {
                    $('#merchant_id').val(ui.item.id);
                    $('#search_merchant').val(ui.item.id);
                    $('#merchant_name').val(ui.item.merchant_name);
                    $('#merchant_phone').val(ui.item.merchant_phone);
                    $('#company_branch').val(ui.item.company_branch);
                    $('#merchant_ntn').val(ui.item.merchant_ntn);
                    $('#merchant_gst').val(ui.item.merchant_gst);
                    $('#merchant_gst_per').val(ui.item.merchant_gst_per);
                    $('#merchant_discount').val(ui.item.merchant_discount);
                    $('#fax_no').val(ui.item.fax_no);
                    $('#merchant_address1').val(ui.item.merchant_address1);
                    $('#account_opening_date').val(ui.item.account_opening_date);
                    $('#referred_by_id').val(ui.item.referred_by_id);
                    $('#referred_commission').val(ui.item.referred_commission);
                    $('#recovery_by_id').val(ui.item.recovery_by_id);
                    $('#recovery_commission').val(ui.item.recovery_commission);
                    $('#sale_person_id').val(ui.item.sale_person_id);
                    $('#sale_person_commission').val(ui.item.sale_person_commission);
                    $('#contact_person1').val(ui.item.merchant_representative_name);
                    $('#contact_person_des1').val(ui.item.merchant_representative_des);
                    $('#contact_person_phone1').val(ui.item.merchant_representative_phone);
                    $('#contact_person2').val(ui.item.merchant_representative_name2);
                    $('#contact_person_des2').val(ui.item.merchant_representative_des2);
                    $('#contact_person_phone2').val(ui.item.merchant_representative_phone2);
                    $('#contact_person3').val(ui.item.merchant_representative_name3);
                    $('#contact_person_des3').val(ui.item.merchant_representative_des3);
                    $('#contact_person_phone3').val(ui.item.merchant_representative_phone3);
                    $('#name').val(ui.item.name);
                    $('#merchant_email').val(ui.item.merchant_email);
                    $('#commissionable_month').val(ui.item.commissionable_month);

                    $('#is_active').empty();
                    var Iac = `<option value="0">In-Active</option>`;
                    var ac = `<option  value="1">Active</option>`;
                    var ntn = ui.item.merchant_ntn;

                    $('#city_id').append(`<option value="` + ui.item.city_id + `">` + ui.item.city + `</option>`);
                    $('#recovery_city_id').append(`<option value="` + ui.item.recovery_city_id + `" selected>` + ui.item.recovery_city + `</option>`);

                    $('#account_type_id').empty();
                    var gen = `<option value="0">General</option>`;
                    var cod = `<option  value="1">COD</option>`;

                    if (ui.item.is_active == 1) {
                        $('#is_active').append(ac);
                        $('#account_type_id').append(cod);
                    } else {
                        $('#is_active').append(Iac);
                        $('#account_type_id').append(gen);
                    }

                    $('#client_type').empty();
                    var nreg = `<option value="0">Non Registered</option>`;
                    var reg = `<option  value="1">Registered</option>`;
                    if (ntn != null && ntn.length) {
                        $('#client_type').append(reg).trigger('change');
                    } else {
                        $('#client_type').append(nreg).trigger('change');
                    }
                    $('.merchant').attr('disabled', true);
                    return false;
                },
            });
        });

        function getPackingMaterial(packingMaterialItem) {

            var packingItemDiv = document.getElementById("packing_material_rate");
            var packingItemContent = `<label class="control-label col-md-2 col-sm-6 col-xs-12">Packing Material Rate</label>
                                                <div class="col-md-10 col-sm-6 col-xs-12">`;
            Object.keys(packingMaterialItem).forEach(function (index) {
                var packingItemValue = packingMaterialItem[index];
                console.log(packingItemValue.material_value);
                var packingItemContent1 = `
                                                    <div class="form-group col-md-6">
                                                        <label class="control-label col-md-4 col-sm-4">` + packingItemValue.material_name + `</label>
                                                        <div class="col-md-8 col-sm-8">
                                                            <input type="hidden" name="material_id[]" id="material_id" value="` + packingItemValue.id + `">
                                                            <input id="material_value` + index + `" name="material_value[]"
                                                                   class="form-control" type="number">
                                                        </div>
                                                    </div>
                                                `;
                packingItemContent += packingItemContent1;
            });
            packingItemContent2 = `</div>`;
            packingItemContent += packingItemContent2;
            packingItemDiv.innerHTML = packingItemContent;
        }

        function addFields(data = null) {
            var formContainer = document.getElementById('form-container');
            // Create a new row
            var newRow = document.createElement('div');
            newRow.className = 'bank-dynamic'; // You may adjust the class name
            // Add content to the new row

            var bankOption = 'Select an option';
            var selected = 'disabled selected';
            var bankOptionId = 0;
            var bankAccountNo = '';
            var bankTitle = '';
            var bankBranch = '';
            var merchantId = 0;
            var financeId = '';

            if (data != null) {
                bankOption = data.bank_name;
                bankOptionId = data.bank_id;
                bankAccountNo = data.bank_ac_no;
                bankTitle = data.bank_ac_title;
                bankBranch = data.bank_branch;
                merchantId = data.merchant_id;
                financeId = data.id;
                selected = 'selected';
            }

            newRow.innerHTML = `<div class="form-group col-md-3">
                                    <label class="control-label col-md-12 col-sm-12 col-xs-12">Bank Name*</label>
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <select class="form-control bank_id" name="bank_id[]">
                                            <option value="${bankOptionId}" ${selected}>${bankOption}</option>
                                        </select>
                                    </div>
                                </div>
                                <input type="hidden" name="finance_id[]" value="${financeId}">
                                <div class="form-group col-md-3">
                                    <label class="control-label col-md-12 col-sm-12" for="bank_ac_title">Bank
                                        Account Title <span class="required">*</span>
                                    </label>
                                    <div class="col-md-12 col-sm-12">
                                        <input type="text" id="bank_ac_title" name="bank_ac_title[]"
                                               required="required" class="form-control" value="${bankTitle}">
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="control-label col-md-12 col-sm-12" for="bank_ac_no">Account No #
                                        <span class="required">*</span>
                                    </label>
                                    <div class="col-md-12 col-sm-12">
                                        <input type="text" id="bank_ac_no" name="bank_ac_no[]" value="${bankAccountNo}" required="required"
                                               class="form-control">
                                    </div>
                                </div>
                                <div class="form-group col-md-2">
                                    <label class="control-label col-md-12 col-sm-12" for="bank_branch">Branch Name
                                        <span class="required">*</span>
                                    </label>
                                    <div class="col-md-12 col-sm-12">
                                        <input type="text" id="bank_branch" name="bank_branch[]"
                                               required="required" class="form-control" value="${bankBranch}">
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <button type="button" class="btn btn-sm btn-danger mt-4" onclick="removeRow(${financeId})">Remove</button>
                                </div>`;
            // Append the new row to the form container
            formContainer.appendChild(newRow);

            //banks dropdown with select2
            $(".bank_id").select2({
                placeholder: "Search Bank",
                // minimumInputLength: 2, // Minimum characters before sending the AJAX request
                ajax: {
                    url: "{{ api_url('bank_list') }}", // Replace with your actual server endpoint
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
        }

        function removeRow(financeId = null) {
            var formContainer = document.getElementById('form-container');

            // Get all rows with the specified class
            var rows = formContainer.getElementsByClassName('bank-dynamic');

            // Check if there are rows to remove
            if (rows.length > 0) {
                // Remove the last row
                formContainer.removeChild(rows[rows.length - 1]);
                if (financeId != null) {
                    $.ajax({
                        url: '<?php echo api_url('manage_client/shipper/delete_bank_details') ?>',
                        method: 'POST',
                        data: {id: financeId},
                        dataType: 'json',
                        headers: headers,
                        success: function (data) {
                            // if (data && data.status == 1) {
                            //     Swal.fire({
                            //         icon: 'success',
                            //         text: 'Record Has Been Removed Successfully',
                            //         showConfirmButton: true,
                            //         confirmButtonColor: '#ffca00',
                            //     })
                            // }
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
            } else {
                console.log("No rows to remove.");
            }

            // console.log(bankId);


        }

    </script>


@endsection

