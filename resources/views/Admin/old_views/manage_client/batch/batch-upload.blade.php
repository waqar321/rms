@extends('Admin.layout.main')
@section('title') Bulk Update @endsection
@section('styles')
    <style>
        .note{
            margin-top: 10px;
        }
        .buttons-div{
            margin-top: 15px;
        }
        .download-sample-file{
            margin-bottom: 15px;
        }
        .upload-button{
            margin-left: 10px;
        }
    </style>
@endsection

@section('content')

    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Batch Upload</h3>
                </div>
            </div>
            <div class="clearfix"></div>

            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <form id="batch-form" action="" novalidate="novalidate" data-parsley-validate method="post" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-4 ">
                                            <label>Batch Upload<span class="danger">*</span></label>
                                            <select data-rule-required="true" data-msg-required="Batch upload is required"
                                                    class="form-control select2" id="batch_upload" name="batch_upload" onchange="salesPerson()">
                                                <option value="">Select Batch Upload Options</option>
                                                <option value="booked_packet_status">Booked Packet Status</option>
                                                <option value="bank_transaction_entry" data-screen-permission-id="213">Bank Transaction Entry</option>
                                                <option value="mark_code_zero" data-screen-permission-id="214">Mark Code Zero</option>
                                                <option value="update_shipment_types" data-screen-permission-id="215">Update Shipment Types</option>
                                                <option value="update_packets_weight" data-screen-permission-id="216">Update Packets Weight</option>
                                                <option value="update_packets_destination" data-screen-permission-id="217">Update Packets Destination</option>
                                                <option value="update_vpc" data-screen-permission-id="218">Update VPC</option>
{{--                                                <option value="admin_portal_update_bad_debts">Update Bad Debts</option>--}}
                                                <option value="update_origin_city" data-screen-permission-id="219">Update Origin City</option>
                                                <option value="update_cod_amount" data-screen-permission-id="220">Update COD Amount</option>
                                                <option value="update_clients_sales_person" data-screen-permission-id="221">Update Clients Sales Person</option>
{{--                                                <option value="update_booked_packet_without_payment_recieved">Batch Packet Status</option>--}}
                                            </select>
                                            <span class="error-container danger w-100"></span>
                                    </div>
                                    <div class="col-md-4">
                                            <label>Consignment Number(s) File <span class="danger">*</span></label>
                                            <input type="file" id="csv_file" name="file" data-rule-required="true"  data-msg-required="Please Upload Csv File First" class="form-control"  accept=".csv">
                                            <span class="error-container danger w-100"></span>
                                    </div>
                                    <div class="col-md-4 col-xs-12 buttons-div">
                                            <button type="submit" class="btn btn-success col-md-3">Upload</button>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-md-offset-3 col-xs-12 buttons-div" style="display: none" id="sample-file">
                                            <span><a download href="<?php echo url_secure('sample/batch_update_sample_file.csv') ?>?id=2">click here</a> to download sample</span>
                                    </div>
                                    <div class="col-md-12 col-md-offset-3 col-xs-12 buttons-div" style="display: none" id="weight-sample-file">
                                            <span><a download href="<?php echo url_secure('sample/batch_weight_update_sample_file.csv') ?>">click here</a> to download sample</span>
                                    </div>
                                    <div class="col-md-12 col-md-offset-3 col-xs-12 buttons-div" style="display: none" id="client-sample-file">
                                        <span><a download href="<?php echo url_secure('sample/clients_sales_person_sample_file.csv') ?>">click here</a> to download update client sales person sample file</span>
                                    </div>
                                    <div class="col-md-12 col-md-offset-3 col-xs-12 buttons-div" style="display: none" id="bank-transaction-sample-file">
                                        <span><a download href="<?php echo url_secure('sample/bank_transaction_sample_file_for_batch_update.csv') ?>">click here</a> to download bank transaction sample file</span>
                                    </div>
                                    <div class="col-md-12 col-md-offset-3 col-xs-12 buttons-div" style="display: none" id="batch-update-destination-sample-file">
                                        <span><a download href="<?php echo url_secure('sample/batch_update_destination_sample_file.csv') ?>">click here</a> to download update destination sample file</span>
                                    </div>
                                    <div class="col-md-12 col-md-offset-3 col-xs-12 buttons-div" style="display: none" id="batch-update-origin-sample-file">
                                        <span><a download href="<?php echo url_secure('sample/batch_update_origin_sample_file.csv') ?>">click here</a> to download update origin sample file</span>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="row">
                            <div class="col-md-12" style="display: none" id="bookingTableData">
                                <form id="batchUpdateForm" action="" novalidate="novalidate" data-parsley-validate method="post">
                                    <input type="hidden" id="batch_upload_option" name="batch_upload_option" value="">
                                    <div class="row">
                                        <div class="col-md-6" id="update-status-id" style="display: none">
                                            <label>Select Book Packet Status<span class="danger">*</span></label>
                                            <select  data-msg-required="Status is required" style="width: 100%"
                                                    class="form-control select2" id="status_id" name="status_id">
                                            </select>
                                            <span class="error-container danger w-100"></span>
                                        </div>
                                        <div class="col-md-6" id="shipment_type" style="display: none">
                                            <label>Select Shipment Type<span class="danger">*</span></label>
                                            <select  data-msg-required="Shipment Type is required" style="width: 100%"
                                                    class="form-control select2" id="shipment_type_id" name="shipment_type_id">
                                            </select>
                                            <span class="error-container danger w-100"></span>
                                        </div>
                                    </div>
                                    <div class="row" id="bank_transaction" style="display: none">
                                        <div class="col-md-4">
                                            <label>Select Fields To Update<span class="danger">*</span></label>
                                            <select  data-msg-required="field is required" style="width: 100%"
                                                     class="form-control" id="field_name" name="field_name">
                                                <option value="">Select Fields</option>
                                                <option value="payment_mode">Payment Remarks</option>
                                            </select>
                                            <span class="error-container danger w-100"></span>
                                        </div>
                                        <div class="col-md-4">
                                            <label>Select Fields Value<span class="danger">*</span></label>
                                            <input type="text" name="field_value" id="field_value" class="form-control">
                                            <span class="error-container danger w-100"></span>
                                        </div>
                                    </div>
                                    <div class="row">
                                            <div class="form-horizontal" style="overflow-x: scroll;overflow-y: scroll;width:100%">
                                                <div class="row form-body">
                                                    <div class="col-md-12" >
                                                        <table id="booking-data" class="table table-striped table-bordered" style="width:100%;">
                                                            <thead>
                                                            <tr>
                                                                <th><input type="checkbox" id="checkAll" checked="true"></th>
                                                                <th>Sr#</th>
                                                                <th>CN#</th>
                                                                <th>Current Status</th>
                                                                <th>Consignee Name</th>
                                                                <th>Consignee Phone</th>
                                                                <th>Origin City</th>
                                                                <th>Destination City</th>
                                                                <th>COD Amount</th>
                                                                <th>Client</th>
                                                                <th>Date Created</th>
                                                            </tr>
                                                            </thead>

                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 col-md-offset-3 col-xs-12 buttons-div">
                                            <div class="col-md-12">
                                                <button type="submit" class="btn btn-success col-md-2 upload-button">Update</button>
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
    </div>
    <!-- /page content -->

@endsection

@section('scripts')
    <script src="<?php echo url_secure('vendors/validate/jquery.validate.min.js') ?>" type="text/javascript"></script>
    <script>
        const token = getToken();
        const getUserData = JSON.parse(getUser());
        const headers = {
            "Authorization": `Bearer ${token}`,
        };

        $(document).ready(function() {


            $("#checkAll").change(function () {
                $(".checkbox").prop('checked', $(this).prop("checked"));
            });

            // Individual Checkboxes
            $(".checkbox").change(function () {
                if ($(".checkbox:checked").length === $(".checkbox").length) {
                    $("#checkAll").prop("checked", true);
                } else {
                    $("#checkAll").prop("checked", false);
                }
            });


        });

        var table =  $('#booking-data').DataTable({
            searching: false, // Disable searching
            ordering: true ,// Enable sorting,
            paging: false, // Disable pagination
            scrollX: true
        });

        $("#batch-form").validate({
            errorClass: "danger",
            errorPlacement: function (error, element) {
                error.addClass('w-100').appendTo(element.parent(0));
            },
            submitHandler: function (form, event) {
                event.preventDefault();

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't to upload this file!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ffca00',
                    cancelButtonColor: '#0e1827',
                    confirmButtonText: 'Submit'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var formData = new FormData(form);

                        $.ajax({
                            url: '<?php echo api_url('manage_client/batch/upload'); ?>',
                            method: 'POST',
                            data: formData, // Use the FormData object
                            headers:headers,
                            processData: false, // Don't process the data (needed for FormData)
                            contentType: false, // Don't set content type (needed for FormData)
                            dataType: 'json',
                            beforeSend: function(){
                                $('.error-container').html('');
                                let timerInterval;
                                sw = Swal.fire({
                                    title: '',
                                    html: 'Please Wait',
                                    timerProgressBar: true,
                                    didOpen: () => {
                                        Swal.showLoading()

                                    },
                                    willClose: () => {
                                        clearInterval(timerInterval)
                                    }
                                })
                            },
                            success: function (data) {
                                table.destroy();
                                if (data.status == 1) {
                                    $('#batch_upload_option').val(data.bit);
                                    $('#update-status-id').hide();
                                    $('#shipment_type').hide();
                                    $('#bank_transaction').hide();
                                    var head = `
                                        <tr role="row">
                                        <th><input type="checkbox" id="checkAll" checked="true"></th>
                                        <th>Sr#</th>
                                        <th>CN#</th>
                                        <th>Current Status</th>
                                        <th>Consignee Name</th>
                                        <th>Consignee Phone</th>
                                        <th>Origin City&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                        <th>Destination City&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                        <th>COD Amount</th>
                                        <th>Client</th>
                                        <th>Date Created</th>
                                        </tr>`;
                                    var destinationHead = `
                                        <tr role="row">
                                        <th><input type="checkbox" id="checkAll" checked="true"></th>
                                        <th>Sr#</th>
                                        <th>CN#</th>
                                        <th>Current Status</th>
                                        <th>Consignee Name</th>
                                        <th>Consignee Phone</th>
                                        <th>Origin City&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                        <th>Destination City&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                        <th>Update Destination City&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                        <th>COD Amount</th>
                                        <th>Client</th>
                                        <th>Date Created</th>
                                        </tr>`;
                                    var OriginHead = `
                                        <tr role="row">
                                        <th><input type="checkbox" id="checkAll" checked="true"></th>
                                        <th>Sr#</th>
                                        <th>CN#</th>
                                        <th>Current Status</th>
                                        <th>Consignee Name</th>
                                        <th>Consignee Phone</th>
                                        <th>Origin City&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                        <th>Update Origin City&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                        <th>Destination City&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                        <th>COD Amount</th>
                                        <th>Client</th>
                                        <th>Date Created</th>
                                        </tr>`;
                                    var headWeight = `
                                        <tr role="row">
                                        <th><input type="checkbox" id="checkAll" checked="true"></th>
                                        <th>Sr#</th>
                                        <th>CN#</th>
                                        <th>Current Status</th>
                                        <th>Consignee Name</th>
                                        <th>Updated Arrival Dispatch Weight</th>
                                        <th>Previous Arrival Dispatch Weight</th>
                                        <th>Updated Volumetric Weight</th>
                                        <th>Previous Volumetric Weight</th>
                                        <th>Updated Booked Packet Weight</th>
                                        <th>Previous Booked Packet Weight</th>
                                        <th>COD Amount</th>
                                        <th>Client</th>
                                        <th>Date Created</th>
                                        </tr>`;
                                    var headVpc = `
                                        <tr role="row">
                                        <th><input type="checkbox" id="checkAll" checked="true"></th>
                                        <th>Sr#</th>
                                        <th>CN#</th>
                                        <th>Current Status</th>
                                        <th>Consignee Name</th>
                                        <th>Consignee Phone</th>
                                        <th>Origin City</th>
                                        <th>Destination City</th>
                                        <th>Vendor Pickup Charges</th>
                                        <th>COD Amount</th>
                                        <th>Client</th>
                                        <th>Date Created</th>
                                        <th>Invoice Cheque No</th>
                                        </tr>`;
                                    var headcod = `
                                        <tr role="row">
                                        <th><input type="checkbox" id="checkAll" checked="true"></th>
                                        <th>Sr#</th>
                                        <th>CN#</th>
                                        <th>Current Status</th>
                                        <th>Consignee Name</th>
                                        <th>Consignee Phone</th>
                                        <th>Origin City</th>
                                        <th>Destination City</th>
                                        <th>COD Amount</th>
                                        <th>COD Remarks</th>
                                        <th>Client</th>
                                        <th>Date Created</th>
                                        </tr>`;
                                    var headsalesPerson = `
                                        <tr role="row">
                                        <th><input type="checkbox" id="checkAll" checked="true"></th>
                                        <th>Sr#</th>
                                        <th>Account No#&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                        <th>Merchant Name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                        <th>City&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                        <th>Current Sales Person Name &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                        <th>New Sales Person Name &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                        </tr>`;
                                    var headBankTransaction = `
                                        <tr role="row">
                                        <th><input type="checkbox" id="checkAll" checked="true"></th>
                                        <th>Sr#</th>
                                        <th>Short CN # &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                        <th>Invoice Cheque # &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                        <th>Branch Name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                        <th>Deposit Slip &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                        <th>Collection Date &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                        <th>Credit Date &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                        <th>Payment Remarks &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                        <th>Amount &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                        <th>Origin &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                        </tr>`;
                                    if (data.bit == 'booked_packet_status') {
                                        $('#booking-data thead').html(head);
                                        $('#update-status-id').show();
                                        $('#bank_transaction').hide();
                                        $('#shipment_type').hide();
                                        var status_id = $('#status_id');
                                        status_id.empty();
                                        var op = "";
                                        data.data.booked_packet_status_list.forEach(function (item) {
                                            op+= `<option value="${item.id}">${item.title}</option>`;
                                        });
                                        status_id.append(op);
                                    } else if (data.bit == 'bank_transaction_entry') {
                                        $('#booking-data thead').html(headBankTransaction);
                                        $('#bank_transaction').show();
                                        $('#shipment_type').hide();
                                        $('#update-status-id').hide();

                                        var fieldName = $('#field_name');
                                        var fieldValue = $('#field_value');

                                        // var status_id = $('#status_id');
                                        // status_id.empty();
                                        // var op = "";
                                        // data.data.booked_packet_status_list.forEach(function (item) {
                                        //     op+= `<option value="${item.id}">${item.title}</option>`;
                                        // });
                                        // status_id.append(op);
                                    }

                                    else if (data.bit == 'update_shipment_types') {
                                        $('#booking-data thead').html(head);
                                        $('#shipment_type').show();
                                        $('#bank_transaction').hide();
                                        $('#update-status-id').hide();

                                        var shipment_type = $('#shipment_type_id');
                                        shipment_type.empty();
                                        var shipment_type_op = "";
                                        data.data.shipment_type_list.forEach(function (item) {
                                            shipment_type_op+= `<option value="${item.shipment_type_id}">${item.shipment_type_name}</option>`;
                                        });
                                        shipment_type.append(shipment_type_op);
                                    } else if (data.bit == 'update_packets_weight') {
                                        $('#booking-data thead').html(headWeight);
                                    } else if(data.bit == 'update_packets_destination'){
                                        $('#booking-data thead').html(destinationHead);
                                    } else if(data.bit == 'update_vpc'){
                                        $('#booking-data thead').html(headVpc);
                                    } else if(data.bit == 'update_origin_city'){
                                        $('#booking-data thead').html(OriginHead);
                                    } else if(data.bit == 'update_cod_amount'){
                                        $('#booking-data thead').html(headcod);
                                    } else if(data.bit == 'update_clients_sales_person'){
                                        $('#booking-data thead').html(headsalesPerson);
                                    }
                                    table =  $('#booking-data').DataTable({
                                        searching: false, // Disable searching
                                        ordering: true ,// Enable sorting,
                                        paging: false, // Disable pagination
                                        scrollX: true
                                    });
                                    populateBookingData(data);

                                } else {
                                    Swal.fire(
                                        'Error!',
                                        data.message,
                                        'error'
                                    );
                                }
                            },
                            complete: function() {
                                sw.close();
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

        function salesPerson(){
            var uploadOption = $('#batch_upload').val();
            var sampleFile = $('#sample-file');
            var clientsalesPerson = $('#client-sample-file');
            var weightFile = $('#weight-sample-file');
            var bankTransactionFile = $('#bank-transaction-sample-file');
            var updateDestinationFile = $('#batch-update-destination-sample-file');
            var updateOriginFile = $('#batch-update-origin-sample-file');


            if(uploadOption == 'update_clients_sales_person'){
                clientsalesPerson.css('display', 'block'); // Set display to block
                sampleFile.css('display', 'none');
                weightFile.css('display', 'none');
                bankTransactionFile.css('display', 'none');
                updateDestinationFile.css('display', 'none');
                updateOriginFile.css('display', 'none');
            }
            else if(uploadOption == 'update_origin_city'){
                bankTransactionFile.css('display', 'none'); // Set display to block
                clientsalesPerson.css('display', 'none');
                sampleFile.css('display', 'none');
                weightFile.css('display', 'none');
                updateDestinationFile.css('display', 'none');
                updateOriginFile.css('display', 'block');
            }
            else if(uploadOption == 'bank_transaction_entry'){
                bankTransactionFile.css('display', 'block'); // Set display to block
                clientsalesPerson.css('display', 'none');
                sampleFile.css('display', 'none');
                weightFile.css('display', 'none');
                updateDestinationFile.css('display', 'none');
                updateOriginFile.css('display', 'none');
            }
            else if(uploadOption == 'update_packets_destination'){
                updateDestinationFile.css('display', 'block'); // Set display to block
                clientsalesPerson.css('display', 'none');
                sampleFile.css('display', 'none');
                bankTransactionFile.css('display', 'none');
                weightFile.css('display', 'none');
                updateOriginFile.css('display', 'none');
            }
            else if(uploadOption == 'update_packets_weight'){
                weightFile.css('display', 'block'); // Set display to block
                clientsalesPerson.css('display', 'none');
                sampleFile.css('display', 'none');
                bankTransactionFile.css('display', 'none');
                updateDestinationFile.css('display', 'none');
                updateOriginFile.css('display', 'none');
            }else{
                sampleFile.css('display', 'block'); // Set display to block
                clientsalesPerson.css('display', 'none');
                weightFile.css('display', 'none');
                bankTransactionFile.css('display', 'none');
                updateDestinationFile.css('display', 'none');
                updateOriginFile.css('display', 'none');
            }
        }

        function populateBookingData(data){
            $('#bookingTableData').show();
            $('#booking-data').DataTable().clear().draw();
            if(data.bit == 'update_packets_weight'){
                var rows = [];
                data.data.booked_packet_list.forEach(item => {
                    var row = [
                        "<input type='checkbox' class='checkbox' name='booking_id[]' value=" + item.booked_packet_id + ">",
                        item.booked_packet_id,
                        item.booked_packet_cn,
                        item.status,
                        item.consignee_name,
                        "<input type='text' class='form-control-sm' name='arival_dispatch_weight[]' value=" + item.arival_dispatch_weight + ">",
                        "<input type='text' class='form-control-sm' name='actual_arrival_dispatch_weight[]' value=" + item.actual_arrival_dispatch_weight + ">",
                        "<input type='text' class='form-control-sm' name='booked_packet_vol_weight_cal[]' value=" + item.booked_packet_vol_weight_cal + ">",
                        "<input type='text' class='form-control-sm' name='actual_booked_packet_vol_weight_cal[]' value=" + item.actual_booked_packet_vol_weight_cal + ">",
                        "<input type='text' class='form-control-sm' name='booked_packet_weight[]' value=" + item.booked_packet_weight + ">",
                        "<input type='text' class='form-control-sm' name='actual_booked_packet_weight[]' value=" + item.actual_booked_packet_weight + ">",
                        item.booked_packet_collect_amount,
                        item.merchant_name,
                        item.created_at,
                    ];
                    rows.push(row);
                });
                // Append all rows at once
                table.rows.add(rows).draw();
            } else if(data.bit == 'bank_transaction_entry'){
                var rows = [];
                data.data.booked_packet_list.forEach(item => {
                    var row = [
                        "<input type='checkbox' class='checkbox' name='transaction_id[]' value=" + item.transaction_id + ">",
                        item.transaction_id,
                        item.cn_short,
                        item.invoice_cheque_no,
                        item.branch_name,
                        item.deposit_slip_no,
                        item.date_collection,
                        item.date_credit,
                        item.payment_mode,
                        item.amount,
                        item.origin_description,
                    ];
                    rows.push(row);
                });
                // Append all rows at once
                table.rows.add(rows).draw();
            }else if(data.bit == 'update_packets_destination'){
                var rows = [];
                data.data.booked_packet_list.forEach(item => {
                    var row = [
                        "<input type='checkbox' class='checkbox' name='booking_id[]' value="+item.booked_packet_id+">",
                        item.booked_packet_id,
                        item.booked_packet_cn,
                        item.status,
                        item.consignee_name,
                        item.consignee_phone,
                        item.origin_city_name,
                        item.dest_city_name,
                        `<select  style='width: 100%' class='form-control' id="destination_city" name='destination_city[]'>
                           <option value="  ${item.destination_city}">${item.origin_city}</option>
                        </select>`,
                        item.booked_packet_collect_amount,
                        item.merchant_name,
                        item.created_at,
                    ];
                    rows.push(row);
                });
                // Append all rows at once
                table.rows.add(rows).draw();


                {{--$(".destination_city").select2({--}}
                {{--    placeholder: "Search City",--}}
                {{--    minimumInputLength: 2, // Minimum characters before sending the AJAX request--}}
                {{--    allowClear: false,--}}
                {{--    ajax: {--}}
                {{--        url: "{{ api_url('get_cities') }}", // Replace with your actual server endpoint--}}
                {{--        dataType: "json",--}}
                {{--        delay: 250, // Delay before sending the request in milliseconds--}}
                {{--        headers: headers,--}}
                {{--        processResults: function (data) {--}}
                {{--            return {--}}
                {{--                results: data.map(function (item) {--}}
                {{--                    return {--}}
                {{--                        id: item.id,--}}
                {{--                        text: item.label // 'text' property is required by Select2--}}
                {{--                    };--}}
                {{--                })--}}
                {{--            };--}}
                {{--        },--}}
                {{--        cache: true // Enable caching of AJAX results--}}
                {{--    }--}}
                {{--});--}}
            }else if(data.bit == 'update_origin_city'){
                // data.data.booked_packet_list.forEach(item => {
                //     table.row.add([
                //         "<input type='checkbox' class='checkbox' name='booking_id[]' value="+item.booked_packet_id+">",
                //         item.booked_packet_id,
                //         item.booked_packet_cn,
                //         item.status,
                //         item.consignee_name,
                //         item.consignee_phone,
                //         `<select  style='width: 100%' class='form-control select2 origin_city' id="origin_city_${item.origin_city}" name='origin_city[]'>
                //            <option value="  ${item.origin_city}">${item.origin_city_name}</option>
                //         </select>`,
                //         item.dest_city_name,
                //         item.booked_packet_collect_amount,
                //         item.merchant_name,
                //         item.created_at,
                //     ]).draw();
                // });

                var rows = [];
                data.data.booked_packet_list.forEach(item => {
                    var row = [
                        "<input type='checkbox' class='checkbox' name='booking_id[]' value="+item.booked_packet_id+">",
                        item.booked_packet_id,
                        item.booked_packet_cn,
                        item.status,
                        item.consignee_name,
                        item.consignee_phone,
                        item.origin_city_name,
                        `<select  style='width: 100%' class='form-control' id="origin_city" name='origin_city[]'>
                           <option value="  ${item.updated_origin_city_id}">${item.updated_origin_city}</option>
                        </select>`,
                        item.dest_city_name,
                        item.booked_packet_collect_amount,
                        item.merchant_name,
                        item.created_at,
                    ];
                    rows.push(row);
                });
                // Append all rows at once
                table.rows.add(rows).draw();

                {{--$(".origin_city").select2({--}}
                {{--    placeholder: "Search City",--}}
                {{--    minimumInputLength: 2, // Minimum characters before sending the AJAX request--}}
                {{--    allowClear: false,--}}
                {{--    ajax: {--}}
                {{--        url: "{{ api_url('get_cities') }}", // Replace with your actual server endpoint--}}
                {{--        dataType: "json",--}}
                {{--        delay: 250, // Delay before sending the request in milliseconds--}}
                {{--        headers: headers,--}}
                {{--        processResults: function (data) {--}}
                {{--            return {--}}
                {{--                results: data.map(function (item) {--}}
                {{--                    return {--}}
                {{--                        id: item.id,--}}
                {{--                        text: item.label // 'text' property is required by Select2--}}
                {{--                    };--}}
                {{--                })--}}
                {{--            };--}}
                {{--        },--}}
                {{--        cache: true // Enable caching of AJAX results--}}
                {{--    }--}}
                {{--});--}}
            } else if(data.bit == 'update_vpc'){
                data.data.booked_packet_list.forEach(item => {
                    table.row.add([
                        "<input type='checkbox' class='checkbox' name='booking_id[]' value="+item.booked_packet_id+">",
                        item.booked_packet_id,
                        item.booked_packet_cn,
                        item.status,
                        item.consignee_name,
                        item.consignee_phone,
                        item.origin_city_name,
                        item.dest_city_name,
                        item.vendor_pickup_charges,
                        "<input type='text' class='form-control-sm' name='booked_packet_collect_amount[]' value="+item.booked_packet_collect_amount+">",
                        item.merchant_name,
                        item.created_at,
                        item.invoice_cheque_no,
                    ]).draw();
                });
            }else if(data.bit == 'update_cod_amount'){
                data.data.booked_packet_list.forEach(item => {
                    table.row.add([
                        "<input type='checkbox' class='checkbox' name='booking_id[]' value="+item.booked_packet_id+">",
                        item.booked_packet_id,
                        item.booked_packet_cn,
                        item.status,
                        item.consignee_name,
                        item.consignee_phone,
                        item.origin_city_name,
                        item.dest_city_name,
                        "<input type='text' class='form-control-sm' name='booked_packet_collect_amount[]' value="+item.booked_packet_collect_amount+">",
                        "<textarea class='form-control-sm' name='amount_change_remarks[]'>"+item.amount_change_remarks+"</textarea>",
                        item.merchant_name,
                        item.created_at,
                    ]).draw();
                });
            }else if(data.bit == 'update_clients_sales_person'){
                // var rows = [];
                // data.data.booked_packet_list.forEach(item => {
                //     var row = [
                //         "<input type='checkbox' class='checkbox' name='booking_id[]' value="+item.booked_packet_id+">",
                //         item.booked_packet_id,
                //         item.booked_packet_cn,
                //         item.status,
                //         item.consignee_name,
                //         item.consignee_phone,
                //         item.origin_city_name,
                //         item.dest_city_name,
                //         `<select  style='width: 100%' class='form-control' id="destination_city" name='destination_city[]'>
                //            <option value="  ${item.destination_city}">${item.origin_city}</option>
                //         </select>`,
                //         item.booked_packet_collect_amount,
                //         item.merchant_name,
                //         item.created_at,
                //     ];
                //     rows.push(row);
                // });
                // // Append all rows at once
                // table.rows.add(rows).draw();


                data.data.booked_packet_list.forEach(item => {
                    table.row.add([
                        "<input type='checkbox' class='checkbox' name='Sale_id[]' value="+item.Sale_id+"><input type='hidden' name='merchant_account_no[]' value="+item.merchant_account_no+">",
                        item.merchant_id,
                        item.merchant_account_no,
                        item.merchant_name,
                        item.city_name,
                        item.username,
                        item.new_sale_person+"<input type='hidden' class='form-control' name='update_sale_id[]' value="+item.updated_sale_person_id+">",
                    ]).draw();
                });

                $(".sale_person").select2({
                    placeholder: "Sales Person",
                    minimumInputLength: 2, // Minimum characters before sending the AJAX request
                    allowClear: false,
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

            } else{
                data.data.booked_packet_list.forEach(item => {
                    table.row.add([
                        "<input type='checkbox' class='checkbox' name='booking_id[]' value="+item.booked_packet_id+">",
                        item.booked_packet_id,
                        item.booked_packet_cn,
                        item.status,
                        item.consignee_name,
                        item.consignee_phone,
                        item.origin_city_name,
                        item.dest_city_name,
                        item.booked_packet_collect_amount,
                        item.merchant_name,
                        item.created_at,
                    ]).draw();
                });
            }

            $(".checkbox").prop("checked", true); //Make Checkboxes Checked
        }



        $("#batchUpdateForm").validate({
            errorClass: "danger",
            errorPlacement: function (error, element) {
                error.addClass('w-100').appendTo(element.parent(0));
            },
            submitHandler: function (form, event) {
                event.preventDefault();

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't to upload this file!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ffca00',
                    cancelButtonColor: '#0e1827',
                    confirmButtonText: 'Submit'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var formData = new FormData(form); // Pass the form element, not the form variable

                        $.ajax({
                            url: '<?php echo api_url('manage_client/batch/update-booked-packet-status'); ?>',
                            method: 'POST',
                            data: formData,
                            processData: false, // Set to false to prevent jQuery from transforming the data
                            contentType: false, // Set to false to prevent jQuery from setting content type
                            headers: headers,
                            dataType: 'json',
                            beforeSend: function(){
                                $('.error-container').html('');
                                let timerInterval;
                                sw2 = Swal.fire({
                                    title: '',
                                    html: 'Please Wait',
                                    timerProgressBar: true,
                                    didOpen: () => {
                                        Swal.showLoading();
                                    },
                                    willClose: () => {
                                        clearInterval(timerInterval);
                                    }
                                });
                            },
                            success: function(data) {
                                if (data.status == 1) {
                                    Swal.fire({
                                        icon: 'success',
                                        text: 'Form has been submitted successfully',
                                        showConfirmButton: true,
                                        confirmButtonColor: '#ffca00',
                                    });
                                   window.location.reload();
                                } else {
                                    Swal.fire(
                                        'Error!',
                                        data.message,
                                        'error'
                                    );
                                }
                            },
                            complete: function() {
                                sw2.close();
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
                });
            }
        });


    </script>

@endsection
