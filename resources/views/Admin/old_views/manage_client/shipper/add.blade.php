@extends('Admin.layout.main')

@section('styles')
    <link rel="stylesheet" href="{{ url_secure('build/css/jquery_ui.css')}}">
@endsection

@section('title') {{ (Request::segment(3) == 'edit') ? 'Edit' : 'Add' }} Shipper @endsection

@section('content')
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Manage Shipper</h3>
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
                            <br/>
                            <form id="shipper_form" action="" novalidate="novalidate" data-parsley-validate
                                  class="form-horizontal form-label-left" method="post">
                                <input type="hidden" value="" disabled name="id">
                                <div class="row">


                                    <div class="col-md-6 col-sm-6 col-xs-12">

                                        <div class="form-group">
                                            <label>Shipper Name <span class="required">*</span></label>
                                            <input type="text" id="merchant_name" name="merchant_name"
                                                   data-rule-required="true" data-msg-required="shipper name is required"
                                                   class="form-control">
                                            <span class="error-container danger w-100"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12">

                                        <div class="form-group">
                                            <label>Shipper Email</label>
                                            <input id="merchant_email" class="form-control" type="text"
                                                   name="merchant_email">
                                            <span class="error-container danger w-100"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12">

                                        <div class="form-group">
                                            <label>Shipper Phone *</label>
                                            <input id="merchant_phone" class="form-control" type="text"
                                                   name="merchant_phone" data-inputmask="'mask' : '99999999999'"
                                                   data-rule-required="true" data-msg-required="shipper phone no is required">
                                            <span class="error-container danger w-100"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12">

                                        <div class="form-group">
                                            <label>Shipper Cnic *</label>
                                            <input id="cnic" class="form-control" type="text"
                                                   name="cnic" data-inputmask="'mask' : '99999-9999999-9'"
                                                   data-rule-required="true" data-msg-required="shipper cnic is required">
                                            <span class="error-container danger w-100"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12">

                                        <div class="form-group">
                                            <label>Select City <span class="danger">*</span></label>
                                            <select data-rule-required="true" data-msg-required="City is required"
                                                    class="form-control" id="city_id" name="city_id">
                                            </select>
                                            <span class="error-container danger w-100"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label>Select Area <span class="danger">*</span></label>
                                            <select id="area_id"
                                                    class="select2 form-control"
                                                    name="area_id" data-rule-required="true"
                                                    data-msg-required="Area is required">
                                                <option value="" disabled selected>Select an option</option>
                                            </select>
                                            <span class="error-container danger w-100"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label>Select Block / Sub Area </label>
                                            <select id="subarea_id"
                                                    class="select2 form-control"
                                                    name="subarea_id">
                                                <option value="" disabled selected>Select an option</option>
                                            </select>
                                            <span class="error-container danger w-100"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12">

                                        <div class="form-group">
                                            <label>Select Merchant *</label>
                                            <select class="select2 form-control" tabindex="-1" name="parent_id"
                                                    id="parent_id" data-rule-required="true" data-msg-required="merchant is required">
                                            </select>
                                            <span class="error-container danger w-100"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12">

                                        <div class="form-group">
                                            <label>Shipper Address *</label>
                                            <input id="merchant_address1" class="form-control" type="text"
                                                   name="merchant_address1"
                                                   data-rule-required="true" data-msg-required="shipper address is required">
                                            <span class="error-container danger w-100"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-sm-12 col-xs-12 mb-3">
                                        <div class="form-group">

                                            <label for="middle-name">Settle Your Shipper</label>
                                            <input type="checkbox" id="is_settlement" value="1" name="is_settlement">
                                            &nbsp;&nbsp;&nbsp;&nbsp;(If you intend to settle your shippers separately,
                                            you can insert below mentioned
                                            details to facilitate your shippers.)
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="col-md-4 col-sm-4 col-xs-12 mb-3">
                                            <div class="form-group">
                                                <label for="middle-name">IBAN #</label>
                                                <input type="checkbox" class="bank checkoption" id="iban" value="1" name="iban">
                                                <span class="error-container danger w-100"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-4 col-xs-12 mb-3">
                                            <div class="form-group">
                                                <label for="middle-name">A/C No #</label>
                                                <input type="checkbox" class="bank checkoption" id="ac_no" value="1" name="ac_no">
                                                <span class="error-container danger w-100"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-4 col-xs-12 mb-3 text-right" id="add-more" style="display: none;">
                                            <div class="form-group">
                                                <button onclick="addFields()" type="button" class="btn btn-success btn-sm">Add Bank Details</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-7 col-sm-6 col-xs-12 iban_details">
                                        <div class="form-group">

                                            <label for="middle-name">IBAN No. <span
                                                    class="danger">*</span></label>
                                            <input id="iban_no" class="form-control bank_account_no" type="text"
                                                   name="iban_no">
                                            <span class="error-container danger w-100"></span>
                                        </div>
                                    </div>

                                    <div id="form-container" class="col-md-12">

{{--                                        <div class="col-md-3 col-sm-3 col-xs-12 account_details">--}}
{{--                                            <div class="form-group">--}}
{{--                                                <label>Select Bank <span class="danger">*</span></label>--}}
{{--                                                <select name="bank_id[]" class="bank_account_no bank_id"--}}
{{--                                                        style="width: 100%;"--}}
{{--                                                        data-msg-required="This is required">--}}
{{--                                                    <option value="" disabled selected>Select an option</option>--}}
{{--                                                </select>--}}
{{--                                                <span class="error-container danger w-100"></span>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <div class="col-md-3 col-sm-3 col-xs-12 account_details">--}}
{{--                                            <div class="form-group">--}}
{{--                                                <label for="middle-name">Bank Account No. <span class="danger">*</span></label>--}}
{{--                                                <input id="bank_ac_no" class="bank_account_no form-control" type="text" name="bank_ac_no[]">--}}
{{--                                                <span class="error-container danger w-100"></span>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <div class="col-md-3 col-sm-3 col-xs-12 account_details">--}}
{{--                                            <div class="form-group">--}}
{{--                                                <label for="middle-name">Bank Account Tittle <span--}}
{{--                                                        class="danger">*</span></label>--}}
{{--                                                <input id="bank_ac_title" class="bank_account_no form-control"--}}
{{--                                                       type="text" name="bank_ac_title[]">--}}
{{--                                                <span class="error-container danger w-100"></span>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <div class="col-md-3 col-sm-3 col-xs-12 account_details">--}}
{{--                                            <div class="form-group">--}}
{{--                                                <label for="middle-name">Bank Branch <span class="danger">*</span></label>--}}
{{--                                                <input id="bank_branch" class="bank_account_no form-control" type="text"--}}
{{--                                                       name="bank_branch[]">--}}
{{--                                                <span class="error-container danger w-100"></span>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}

                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                        <div class="form-group">

                                            <a href="<?php echo url_secure('manage_client/shipper') ?>">
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
    <script src="{{ url_secure('build/js/jquery_ui.js')}}"></script>
    <script src="<?php echo url_secure('vendors/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js') ?>"></script>
    <script src="<?php echo url_secure('vendors/validate/jquery.validate.min.js') ?>" type="text/javascript"></script>
    <script>
        const token = getToken();
        const headers = {
            "Authorization": `Bearer ${token}`,
        };

        $('.bank').attr('disabled', 'disabled');
        $('body').on('click', '#is_settlement', function () {
            if ($(this).is(':checked')) {
                $('.bank').removeAttr('disabled');
            } else {
                $('.bank').attr('disabled', 'disabled');
                // $('.bank').val('');
                $('.bank').trigger('change');
                $('.account_details').css('display', 'none');
                $('.iban_details').css('display', 'none');
                // $('.bank_account_no').val('');
                $('.bank_account_no').trigger('change');
                $('#iban').prop('checked', false);
                $('#ac_no').prop('checked', false);
            }
        });

        $('.account_details').css('display', 'none');
        $('.iban_details').css('display', 'none');

        $('body').on('click', '#ac_no', function () {
            if ($(this).is(':checked')) {
                // document.getElementById("iban_no").value = '';

                $('.account_details').css('display', 'block');
                $('.iban_details').css('display', 'none');
                $('#add-more').css('display', 'block')
            } else {
                $('.account_details').css('display', 'none');
                // $('.iban_details').css('display', 'block');
                // $('.bank_account_no').val('');
                $('#add-more').css('display', 'none');
                $('.bank_account_no').trigger('change');
            }
        });

        $('body').on('click', '#iban', function () {
            if ($(this).is(':checked')) {

                // option = new Option('', '', true, true);
                // $('#bank_id').append(option).trigger('change');
                // document.getElementById("bank_ac_no").value = '';
                // document.getElementById("bank_ac_title").value = '';
                // document.getElementById("bank_branch").value = '';

                $('.iban_details').css('display', 'block');
                $('.account_details').css('display', 'none');
            } else {
                // $('.account_details').css('display', 'none');
                $('.iban_details').css('display', 'none');
                // $('.bank_account_no').val('');
                $('.bank_account_no').trigger('change');
            }
        });

        $('.checkoption').click(function() {
            $('.checkoption').not(this).prop('checked', false);
        });

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

            $("#parent_id").select2({
                placeholder: "Search Merchant",
                minimumInputLength: 2, // Minimum characters before sending the AJAX request
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

        $("#shipper_form").validate({
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
                        var data = $('#shipper_form').serialize();
                        $.ajax({
                            url: '<?php echo api_url('manage_client/shipper/submit'); ?>',
                            method: 'POST',
                            data: data,
                            headers: headers,
                            dataType: 'json', // Set the expected data type to JSON
                            beforeSend: function () {
                                $('.error-container').html('');
                            },
                            success: function (data) {
                                if (data && data.status == 1) {
                                    Swal.fire({
                                        icon: 'success',
                                        text: 'Form has been submitted successfully',
                                        showConfirmButton: true,
                                        confirmButtonColor: '#ffca00',
                                    });
                                    window.location.href = '<?php echo url_secure('manage_client/shipper') ?>'
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
                url: '<?php echo api_url('manage_client/shipper/edit'); ?>',
                method: 'GET',
                data: {ajax: true, id: id},
                headers: headers,
                dataType: 'json', // Set the expected data type to JSON
                beforeSend: function () {
                    $('.error-container').html('');
                },
                success: function (data) {
                    if (data && data.status == 1) {
                        editForm(data.data.shipper, data.data.banks);
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

        function addFields(data = null) {
            var formContainer = document.getElementById('form-container');
            // Create a new row
            var newRow = document.createElement('div');
            newRow.className = 'bank-dynamic'; // You may adjust the class name
            // Add content to the new row

            var bankOption = 'Select an option';
            var selected ='disabled selected';
            var bankOptionId = '';
            var bankAccountNo = '';
            var bankTitle = '';
            var bankBranch = '';
            var merchantId = '';
            var financeId = '';

            if(data != null){
                bankOption = data.bank_name;
                bankOptionId = data.bank_id;
                bankAccountNo = data.bank_ac_no;
                bankTitle = data.bank_ac_title;
                bankBranch = data.bank_branch;
                merchantId = data.merchant_id;
                financeId = data.id;
                selected = 'selected';
            }

            newRow.innerHTML = `<div class="col-md-3 col-sm-3 col-xs-12 account_details_dynamic">
                                    <div class="form-group">
                                        <label>Select Bank <span class="danger">*</span></label>
                                        <select name="bank_id[]" class="bank_account_no bank_id form-control"
                                            style="width: 100%;" data-msg-required="This is required">
                                            <option value="${bankOptionId}" ${selected}>${bankOption}</option>
                                        </select>
                                        <span class="error-container danger w-100"></span>
                                    </div>
                                </div>
                                <input type="hidden" name="finance_id[]" value="${financeId}">
                                <div class="col-md-3 col-sm-3 col-xs-12 account_details_dynamic">
                                    <div class="form-group">
                                        <label for="middle-name">Bank Account No. <span class="danger">*</span></label>
                                        <input class="bank_account_no form-control" type="text" name="bank_ac_no[]" value="${bankAccountNo}">
                                        <span class="error-container danger w-100"></span>
                                    </div>
                                </div>

                                <div class="col-md-3 col-sm-3 col-xs-12 account_details_dynamic">
                                    <div class="form-group">
                                        <label for="middle-name">Bank Account Title <span class="danger">*</span></label>
                                        <input class="bank_account_no form-control" type="text" name="bank_ac_title[]" value="${bankTitle}">
                                        <span class="error-container danger w-100"></span>
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-3 col-xs-12 account_details_dynamic">
                                    <div class="form-group">
                                        <label for="middle-name">Bank Branch <span class="danger">*</span></label>
                                        <input class="bank_account_no form-control" type="text" name="bank_branch[]" value="${bankBranch}">
                                        <span class="error-container danger w-100"></span>
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
                    if(financeId != null){
                        $.ajax({
                            url: '<?php echo api_url('manage_client/shipper/delete_bank_details') ?>',
                            method: 'POST',
                            data: {id: financeId},
                            dataType: 'json',
                            headers: headers,
                            success: function (data) {
                                if (data && data.status == 1) {
                                    Swal.fire({
                                        icon: 'success',
                                        text: 'Record Has Been Removed Successfully',
                                        showConfirmButton: true,
                                        confirmButtonColor: '#ffca00',
                                    })
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
                } else {
                    console.log("No rows to remove.");
                }

                // console.log(bankId);


            }

        function editForm(data, banks) {
            var keys = Object.keys(data);
            var values = Object.values(data);

            banks.forEach(function(obj) {
                if (obj.iban_no != null) {
                    $('#iban').prop('checked', true);
                    $('.account_details_dynamic').css('display', 'block');
                }
                if (obj.bank_ac_no != null) {
                    $('#ac_no').prop('checked', true);
                    $('.account_details_dynamic').css('display', 'block');
                    $('#add-more').css('display', 'block');

                }
                addFields(obj);
            });

            $(keys).each(function (index, element) {
                // console.log(element)
                var option = "";
                var input = $('input[name="' + element + '"], textarea[name="' + element + '"], select[name="' + element + '"]');
                if (input.is(':checkbox')) {
                    if (input.val() == values[index]) {
                        input.prop('checked', true);
                        if (element == 'is_settlement') {
                            $('.bank').removeAttr('disabled');
                        }
                        // console.log(data);

                    }
                } else if (input.is(':radio')) {
                    $(`input[name="${element}"][value=${values[index]}]`).trigger('click');
                } else if (input.is('select')) {
                    console.log(element)
                    if (element === 'city_id' && data.city_id) {
                        option = new Option(data.city_name, data.city_id, true, true);
                        $('#city_id').append(option).trigger('change');
                    }else if (element === 'area_id' && data.area_id) {
                        option = new Option(data.area_title, data.area_id, true, true);
                        $('#area_id').append(option).trigger('change');
                    }
                    else if (element === 'subarea_id' && data.subarea_id) {
                        option = new Option(data.subarea_title, data.subarea_id, true, true);
                        $('#subarea_id').append(option).trigger('change');
                    }
                    else if (element === 'bank_id' && data.bank_id) {
                        option = new Option(data.bank_name, data.bank_id, true, true);
                        $('#bank_id').append(option).trigger('change');
                    } else if (element === 'parent_id' && data.parent_id) {
                        // console.log(data.parent_merchant_id, 'here')
                        option = new Option(data.parent_merchant, data.parent_merchant_id, true, true);
                        $('#parent_id').append(option).trigger('change');
                    }else {
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
