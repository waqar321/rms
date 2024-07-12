@extends('Admin.layout.main')

@section('styles')
    <link rel="stylesheet" href="{{ url_secure('build/css/jquery_ui.css')}}">
@endsection

@section('title') {{ (Request::segment(3) == 'edit') ? 'Edit' : 'Add' }} Bank Transaction @endsection

@section('content')
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Manage Bank Transaction</h3>
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
                            <form id="consignee_form" action="" novalidate="novalidate" data-parsley-validate
                                  class="form-horizontal form-label-left" method="post">
                                <input type="hidden" value="" disabled name="id">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label>Branch Code <span class="danger">*</span></label>
                                        <input type="text" id="branch_code" name="branch_code" required="required" class="form-control">
                                        <span class="error-container danger w-100"></span>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label>Branch Name <span class="danger">*</span></label>
                                        <input type="text" id="branch_name" name="branch_name" required="required" class="form-control">
                                        <span class="error-container danger w-100"></span>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label>Deposit Slip No. <span class="danger">*</span></label>
                                        <input id="deposit_slip_no" class="form-control " type="text" name="deposit_slip_no">
                                        <span class="error-container danger w-100"></span>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label>Collection Date <span class="danger">*</span></label>
                                        <input id="date_collection" class="form-control" type="date" name="date_collection">
                                        <span class="error-container danger w-100"></span>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label>Mode Of Payment <span class="danger">*</span></label>
                                        <input id="payment_mode" class="form-control" type="text" name="payment_mode">
                                        <span class="error-container danger w-100"></span>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">

                                    <div class="form-group">
                                        <label>Deposit Amount <span class="danger">*</span></label>
                                        <input id="amount" class="form-control" type="text" name="amount">
                                        <span class="error-container danger w-100"></span>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">

                                    <div class="form-group">
                                        <label>Credit Date <span class="danger">*</span></label>
                                        <input id="date_credit" class="form-control" type="date" name="date_credit">
                                        <span class="error-container danger w-100"></span>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label>Consignment No. <span class="danger">*</span></label>
                                        <input id="cn_short" class="form-control" type="text" name="cn_short" onkeyup="getBookingDetails()">
                                        <input type="hidden" name="booking_id" id="booking_id">
                                        <input type="hidden" name="cod_amount" id="cod_amount">
                                        <input type="hidden" name="last_deposited_amount" id="last_deposited_amount">
                                        <span class="error-container danger w-100"></span>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12">

                                    <div class="form-group">
                                        <a href="{{ url_secure('manage_bank_transaction') }}">
                                            <button class="btn btn-danger cancel-button" type="button">Cancel</button>
                                        </a>
                                        <button type="submit"
                                                class="btn btn-success submit-and-update-button">{{ (Request::segment(3) == 'edit') ? 'Update' : 'Submit' }}</button>

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
    <script src="<?php echo url_secure('vendors') ?>/validate/jquery.validate.min.js" type="text/javascript"></script>

    <script>

        const token = getToken();
        const headers = {
            "Authorization": `Bearer ${token}`,
        };
        $('body').on('keyup change', '#editor-one', function () {
            $('#news_content').val($(this).html());
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
                    text: "You want to submit this form!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ffca00',
                    cancelButtonColor: '#0e1827',
                    confirmButtonText: 'Submit'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var data = $('#consignee_form').serialize();
                        $.ajax({
                            url: '<?php echo api_url('manage_bank_transaction/submit'); ?>',
                            method: 'POST',
                            data: data,
                            dataType: 'json', // Set the expected data type to JSON
                            ajax: 1,
                            headers:headers,
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
                                    window.location.href = '<?php echo url_secure('/manage_bank_transaction') ?>'
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
                url: '<?php echo api_url('manage_bank_transaction/edit'); ?>',
                method: 'GET',
                data: {ajax: true, id: id},
                headers:headers,
                dataType: 'json', // Set the expected data type to JSON
                beforeSend: function () {
                    $('.error-container').html('');
                },
                success: function (data) {
                    if (data && data.status == 1) {
                        editForm(data.data);
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
        // else{
        //     loadAjax();
        // }

        function editForm(data) {
            var keys = Object.keys(data);
            var values = Object.values(data);

            $(keys).each(function (index, element) {
                var input = $('input[name="' + element + '"], textarea[name="' + element + '"], select[name="' + element + '"]');
                if (input.is(':checkbox')) {
                    if (input.val() === values[index]) {
                        input.prop('checked', true);
                    }
                } else if (input.is('select')) {
                    if (element === 'city_id' && data.city.id) {
                        option = new Option(data.city.city_name, data.city.id, true, true);
                        $('#city_id').append(option).trigger('change');
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

        function getBookingDetails(){

        var cnNumber = document.getElementById('cn_short').value;
        if(cnNumber.length > 4){
            $.ajax({
                url: '<?php echo api_url('manage_bank_transaction/getBookingDetail'); ?>',
                method: 'GET',
                data:{ ajax: true,cn_number: cnNumber},
                headers:headers,
                dataType: 'json', // Set the expected data type to JSON
                beforeSend: function(){
                    $('.error-container').html('');
                },
                success: function(data) {
                    if (data && data.status == 1 && data.data != null) {
                        $('#booking_id').val(data.data.booking_data.id);
                        $('#cod_amount').val(data.data.booking_data.booked_packet_collect_amount);
                        $('#last_deposited_amount').val(data.data.last_deposited_amount);
                    } else {
                        Swal.fire('Error!',
                            'Error: ' + data.error,
                            'error'
                        );
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

    }

    </script>

@endsection
