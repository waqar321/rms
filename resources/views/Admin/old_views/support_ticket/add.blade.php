@extends('Admin.layout.main')
@section('title')
Add New Ticket
@endsection
@section('styles')
<style>

td, th {
    padding: 10px;
    background: #f9f9f9;
    border: solid 1px #d7d7d7;;
}
input#file_id {
    height: unset;
}
</style>
@endsection

@section('content')
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Support Ticket</h3>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Support Ticket<small>Add</small></h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <br />

                            <form id="support-ticket" action="" novalidate="novalidate" data-parsley-validate class="form-horizontal form-label-left col-md-6" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="cn_number" class="control-label col-md-4 col-sm-4 col-xs-12">CN Number*</label>
                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                        <input id="cn_number" onkeyup="getBookingDetails()" class="form-control col-md-12 col-xs-12" type="text" name="cn_number" data-rule-required="true"  data-msg-required="cn number is required">
                                        <span class="error-container danger w-100"></span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="ticket_type" class="control-label col-md-4 col-sm-4 col-xs-12">Ticket Type*</label>
                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                        <select name="ticket_type" id="ticket_type" class="form-control" data-rule-required="true"  data-msg-required="ticket type is required" onchange="getIssueType()">
                                            <option disabled selected>Please Select</option>
                                            @foreach($categories as $ticketCatgory)
                                                <option value="{{$ticketCatgory->id}}"> {{$ticketCatgory->title}} </option>
                                            @endforeach
                                        </select>
                                        <span class="error-container danger w-100"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="support_ticket_type_id" class="control-label col-md-4 col-sm-4 col-xs-12">Ticket Type Option*</label>
                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                        <select name="support_ticket_type_id" id="support_ticket_type_id" class="form-control" data-rule-required="true"  data-msg-required="ticket type option is required"></select>
                                        <span class="error-container danger w-100"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="ticket_description" class="control-label col-md-4 col-sm-4 col-xs-12">Description</label>
                                    <div class="col-md-8 col-sm-6 col-xs-12">
                                        <textarea id="ticket_description" class="form-control col-md-12 col-xs-12"  name="ticket_description"></textarea>
                                        <span class="error-container danger w-100"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="file_id" class="control-label col-md-4 col-sm-4 col-xs-12">Attachment</label>
                                    <div class="col-md-8 col-sm-6 col-xs-12">
                                        <input type="file" id="file_id" class="form-control col-md-12 col-xs-12"  name="file_name">
                                        <span class="error-container danger w-100"></span>
                                    </div>
                                </div>

                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                        <button class="btn btn-primary" type="button">Cancel</button>
                                        <button type="submit" class="btn btn-success">Submit</button>
                                    </div>
                                </div>

                            </form>
                            <div class="col-md-6" style="display: none" id="booking-data">
                                <h4>Booking Information</h4>
                                <table id="bookedPacketDetails" class="col-md-12">
                                    <tbody>
                                        <tr>
                                            <th align="left">CN Number: </th>
                                            <td align="left" class="text_cn_number " id="text_cn_number"></td>
                                        </tr>
                                        <tr>
                                            <th align="left">Booking Date</th>
                                            <td align="left" class="text_booking_date" id="text_booking_date"></td>
                                        </tr>
                                        <tr>
                                            <th align="left">COD Amount</th>
                                            <td align="left" class="text_cod_amount" id="text_cod_amount"></td>
                                        </tr>
                                        <tr>
                                            <th align="left">Consignee Name</th>
                                            <td align="left" class="text_consignee_name" id="text_consignee_name"></td>
                                        </tr>
                                        <tr>
                                            <th align="left">Shipment Type</th>
                                            <td align="left" class="text_shipment_type" id="text_shipment_type"></td>
                                        </tr>
                                        <tr>
                                            <th align="left">Current Status</th>
                                            <td align="left" class="text_current_status" id="text_current_status"></td>
                                        </tr>
                                    </tbody>
                                </table>
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
    <script src="<?php echo url_secure('vendors') ?>/validate/jquery.validate.min.js" type="text/javascript"></script>
<script>

    const token = getToken();
    const headers = {
        "Authorization": `Bearer ${token}`
    };

    $(document).ready(function() {
        const url = window.location.search;
        if(url) {
            const urlParams = new URLSearchParams(url);
            const CN = atob(urlParams.get('cn'));
            $('#cn_number').val(CN);
            getBookingDetails(CN);

        }

    });

    function getIssueType(){
        $('#support_ticket_type_id').empty();
        var ticket_type = document.getElementById('ticket_type').value;

        $.ajax({
                url: '<?php echo api_url('support_ticket/getIssueType'); ?>',
                method: 'GET',
                data:{ ajax: true,ticket_type: ticket_type},
                dataType: 'json', // Set the expected data type to JSON
                headers: headers,
                beforeSend: function(){
                    $('.error-container').html('');
                },
                success: function(data) {
                    if (data && data.status == 1) {
                        $.each(data.data, function(index, item) {
                            $('#support_ticket_type_id').append($('<option>', {
                                value: item.Id,
                                text: item.Name
                            }));
                        });

                    } else {
                        if(data && data.status == 0){
                            Swal.fire(
                                'Error!',
                                data.error,
                                'error'
                            );
                            document.getElementById("booking-data").style.display = "none";
                            // var errors = (data.errors) ? data.errors : {};
                            // $('.error-container').html(errors);
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

    function getBookingDetails(cnNumber=null){
        $('#booking-data').hide();
        if(cnNumber==null){
            cnNumber = document.getElementById('cn_number').value;
        }

        if(cnNumber.length > 8){
            $.ajax({
                url: '<?php echo api_url('support_ticket/getBookingDetail'); ?>',
                method: 'GET',
                data:{ ajax: true,cn_number: cnNumber},
                dataType: 'json', // Set the expected data type to JSON
                headers: headers,
                beforeSend: function(){
                    $('.error-container').html('');
                },
                success: function(data) {
                    if (data && data.status == 1 && data.data != null) {
                        // console.log(data.result.booked_packet_cn);
                        Swal.fire({
                            icon: 'success',
                            text: 'CN details has been populated successfully',
                            showConfirmButton: false,
                            confirmButtonColor: '#ffca00',
                            timer: 1500
                        });
                        console.log(data.data);
                        document.getElementById("booking-data").style.display = "block";
                        document.getElementById('text_cn_number').innerHTML = data.data.booked_packet_cn;
                        document.getElementById('text_booking_date').innerHTML = data.data.booked_packet_date;
                        document.getElementById('text_cod_amount').innerHTML = data.data.booked_packet_collect_amount;
                        document.getElementById('text_consignee_name').innerHTML = data.data.consignee_name;
                        document.getElementById('text_shipment_type').innerHTML = data.data.shipment_type_name;
                        document.getElementById('text_current_status').innerHTML = data.data.title;
                    }
                    else if(data && data.status == 1 && data.data == null){
                        Swal.fire(
                            'Error!',
                            'Invalid CN for Support Ticket',
                            'error'
                        );
                    } else {
                        var errors = (data.data) ? data.data : {};

                            if (Object.keys(errors).length > 0) {
                                var error_key = Object.keys(errors);
                                for (var i = 0; i < error_key.length; i++) {
                                    var fieldName = error_key[i];
                                    var errorMessage = errors[fieldName];
                                    if(fieldName == 'message'){
                                        Swal.fire(
                                        'Error!',
                                        'Error: ' + errorMessage,
                                        'error'
                                         );
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

    }

    $("#support-ticket").validate({
        errorClass: "danger",
        errorPlacement: function (error, element) {
            error.addClass('w-100').appendTo(element.parent(0));
        },
        submitHandler: function (form, event) {
            event.preventDefault();

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't to submit this form!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Submit'
            }).then((result) => {
                if (result.isConfirmed) {
                    var formData = new FormData(form);
                    $.ajax({
                        url: '<?php echo api_url('support_ticket/submit'); ?>',
                        headers: headers,
                        method: 'POST',
                        data:formData,
                        processData: false, // Don't process the data (needed for FormData)
                        contentType: false, // Don't set content type (needed for FormData)
                        dataType: 'json', // Set the expected data type to JSON
                        beforeSend: function(){
                            $('.error-container').html('');

                        },
                        success: function(data) {

                            if(data.error == 1){
                                Swal.fire(
                                    'Error!',
                                    data.message,
                                    'error'
                                );
                                return false;
                            }

                            if (data && data.status == 1) {
                                Swal.fire(
                                    'Saved!',
                                    'Form has been submitted successfully',
                                    'success'
                                );
                                window.location.href = '<?php echo url_secure('support_ticket/new') ?>'
                            } else {
                                var errors = (data.data) ? data.data[0] : {};

                                if (Object.keys(errors).length > 0) {
                                    var error_key = Object.keys(errors);
                                    for (var i = 0; i < error_key.length; i++) {
                                        var fieldName = error_key[i];
                                        var errorMessage = errors[fieldName];
                                        if(fieldName == 'message'){
                                            Swal.fire(
                                            'Error!',
                                            'Form submission failed: ' + errorMessage,
                                            'error'
                                             );
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

</script>


@endsection
