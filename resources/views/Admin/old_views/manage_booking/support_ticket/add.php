<?= $this->extend('Admin/layout/main') ?>

<?= $this->section('styles') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
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
                            <form id="support-ticket" action="" novalidate="novalidate" data-parsley-validate class="form-horizontal form-label-left col-md-8" method="post">
                                <div class="form-group">
                                    <label for="cn_number" class="control-label col-md-3 col-sm-3 col-xs-12">CN Number</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input id="cn_number" onblur="getBookingDetails()" class="form-control col-md-7 col-xs-12" type="text" name="cn_number" data-rule-required="true"  data-msg-required="cn number is required">
                                        <span class="error-container danger w-100"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Priority</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select name="ticket_priority_id" id="ticket_priority_id" class="form-control" data-rule-required="true"  data-msg-required="priority is required">
                                            <option value="">- Select a Priority -</option>
                                            <?php foreach($priorities as $priority){ ?>
                                                <option value="<?php echo $priority['id']; ?>"><?php echo $priority['title']; ?></option>
                                            <?php } ?>
                                        </select>
                                        <span class="error-container danger w-100"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="ticket_type" class="control-label col-md-3 col-sm-3 col-xs-12">Ticket Type</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select name="ticket_type" id="ticket_type" class="form-control" data-rule-required="true"  data-msg-required="ticket type is required">
                                            <option value=""> - Please Select - </option>
                                            <option value="1"> Issue Type </option>
                                            <option value="2"> Request Type </option>
                                            <option value="3"> Claims </option>
                                        </select>
                                        <span class="error-container danger w-100"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="support_ticket_type_id" class="control-label col-md-3 col-sm-3 col-xs-12">Ticket Type Option</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select name="support_ticket_type_id" id="support_ticket_type_id" class="form-control" data-rule-required="true"  data-msg-required="ticket type option is required">
                                            <option value="">- Select a Ticket Type Option-</option>
                                            <?php foreach($ticketTypes as $ticketType){ ?>
                                                <option value="<?php echo $ticketType['id']; ?>"><?php echo $ticketType['title']; ?></option>
                                            <?php } ?>
                                        </select>
                                        <span class="error-container danger w-100"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="ticket_description" class="control-label col-md-3 col-sm-3 col-xs-12">Description</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <textarea id="ticket_description" class="form-control col-md-7 col-xs-12"  name="ticket_description"></textarea>
                                        <span class="error-container danger w-100"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="file_id" class="control-label col-md-3 col-sm-3 col-xs-12">Attachment</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="file" id="file_id" class="form-control col-md-7 col-xs-12"  name="file_id">
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
                            <div class="col-md-4" style="display: none" id="booking-data">
                                <table id="bookedPacketDetails" class="col-md-12">
                                    <tbody>
                                        <tr>
                                            <th align="left">CN Number: </th>
                                            <td align="left" class="text_cn_number" id="text_cn_number"></td>
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
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
    <script src="<?php echo base_url('vendors') ?>/validate/jquery.validate.min.js" type="text/javascript"></script>
<script>
    function getBookingDetails(){
        var cnNumber = document.getElementById('cn_number').value;

        $.ajax({
            url: '<?php echo base_url('manage_booking/getBookingDetail'); ?>',
            method: 'GET',
            data:{ cn_number: cnNumber},
            dataType: 'json', // Set the expected data type to JSON
            headers: headers,
            beforeSend: function(){
                $('.error-container').html('');
            },
            success: function(data) {
                if (data && data.status == 1) {
                    // console.log(data.result[0].booked_packet_cn);
                    Swal.fire(
                        'Saved!',
                        'booking Data Fetch Successfully!',
                        'success'
                    );

                    document.getElementById("booking-data").style.display = "block";
                    document.getElementById('text_cn_number').innerHTML = data.result[0].booked_packet_cn;
                    document.getElementById('text_booking_date').innerHTML = data.result[0].booked_packed_date;
                    document.getElementById('text_cod_amount').innerHTML = data.result[0].booked_packet_collect_amount;
                    document.getElementById('text_consignee_name').innerHTML = data.result[0].consignee_name;
                    document.getElementById('text_current_status').innerHTML = data.result[0].booked_packet_status;
                    //window.location.href = '<?php //echo base_url('/manage/bank_type/index') ?>//'
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

    $("#support-ticket").validate({
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
                var data = $('#support-ticket').serialize();
                $.ajax({
                    url: '<?php echo base_url('manage_booking/support_ticket/submit'); ?>',
                    method: 'POST',
                    data:data,
                    headers: headers,
                    dataType: 'json', // Set the expected data type to JSON
                    beforeSend: function(){
                        $('.error-container').html('');
                    },
                    success: function(data) {
                        if (data && data.status == 1) {
                            Swal.fire(
                                'Saved!',
                                'Form has been submitted successfully',
                                'success'
                            );
                            window.location.href = '<?php echo base_url('/manage_booking/support_ticket') ?>'
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

</script>


<?= $this->endSection() ?>
