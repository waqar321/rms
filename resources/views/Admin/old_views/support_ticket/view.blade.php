@extends('Admin.layout.main')
@section('title') View Ticket @endsection
@section('styles')
<style>
td, th {
    padding: 3px;
    background: #f9f9f9;
    border: solid 1px #d7d7d7;
    font-size: 11px;
}
#comments-data li {
    line-height: 30px;
}
.tab-content>.active {
    opacity: 1;
}
.form-control {
    font-size: 14px;
    min-height: 40px;
}
.profile-title {
    font-weight: bold !important;
    text-transform: capitalize !important;
    background: #fecd11;
    padding: 5px 10px !important;
}
img#ticket-image {
    max-width: 100%;
}
.basicBg {
    background: #f9f9f9;
}
a#attachment-show {
    background: #c6c6c6;
    color: #fff;
}
.profile-detail-wrap {
    padding: 0px 5px;
    font-size: 14px;
}
tbody.tracking_details {
    font-size: 14px;
}
button.btn.btn-success {
    background: #000;
    border: transparent;
}
div#TicketDetails {
    padding: 0px 10px;
    font-size: 14px;
}
div#trackingInformationTable {
    min-height: auto !important;
    height: 300px;
    overflow-y: auto;
}
.visible {
    background: #ffc1073b;
    padding: 10px;
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
                            <h2>Support Ticket<small>Details</small></h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="view-inner-wrapper shadow-sm border mb-3 basicBg">
                                        <h4 class="profile-title fs-6 fw-bold text-dark mb-0 text-uppercase family-Inter-Bold border-bottom p-1" locale-res="TicketInformation">Ticket Information</h4>
                                        <div class="p-1">
                                            <div class="profile-detail-wrap">
                                                <input type="hidden" id="hidden_cn" value="KI195380369">
                                                <label class="detail-label d-inline-block fw-500 family-Inter-Bold family-Inter-Bold">CN Number:</label>
                                                <div class="detail-info d-inline-block" id="ticket_cn_no"></div>
                                            </div>
                                        </div>
                                        <div class="p-1">
                                                <div class="profile-detail-wrap">
                                                    <label class="detail-label d-inline-block fw-500 family-Inter-Bold family-Inter-Bold">Ticket
                                                        Type:</label>
                                                    <div class="detail-info d-inline-block" id="ticket_type"></div>
                                                </div>
                                        </div>
                                        <div class="p-1">
                                                <div class="profile-detail-wrap">
                                                    <label class="detail-label d-inline-block fw-500 family-Inter-Bold family-Inter-Bold">Issue
                                                        Type:</label>
                                                    <div class="detail-info d-inline-block" id="ticket_Issuetype"></div>
                                                </div>
                                        </div>
                                        <div class="p-1">
                                                <div class="profile-detail-wrap">
                                                    <label class="detail-label d-inline-block fw-500 family-Inter-Bold family-Inter-Bold">Created
                                                        Date:</label>
                                                    <div class="detail-info d-inline-block" id="created_date"></div>
                                                </div>
                                        </div>
                                        <div class="p-1">
                                                <div class="profile-detail-wrap">
                                                    <label class="detail-label d-inline-block fw-500 family-Inter-Bold family-Inter-Bold">Last
                                                        Updated
                                                        Date:</label>
                                                    <div class="detail-info d-inline-block" id="lastUpdated_date"></div>
                                                </div>
                                        </div>
                                        <div class="p-1">
                                                <div class="profile-detail-wrap">
                                                    <label class="detail-label d-inline-block fw-500 family-Inter-Bold family-Inter-Bold">Destination
                                                        City:</label>
                                                    <div class="detail-info d-inline-block" id="destination_city"></div>
                                                </div>
                                        </div>
                                        <div class="p-1">
                                                <div class="profile-detail-wrap">
                                                    <label class="detail-label d-inline-block fw-500 family-Inter-Bold family-Inter-Bold">Origin
                                                        City:</label>
                                                    <div class="detail-info d-inline-block" id="origin_city"></div>
                                                </div>
                                        </div>
                                        <div class="p-1">
                                                <div class="profile-detail-wrap">
                                                    <label class="detail-label d-inline-block fw-500 family-Inter-Bold family-Inter-Bold">Current Ticket Status:</label>
                                                    <div class="detail-info d-inline-block" id="CurrentStatus"></div>
                                                </div>
                                            </div>
                                    </div>
                                    <div class="view-inner-wrapper shadow-sm border mb-3 basicBg" data-screen-permission-id="134">
                                        <h4 class="profile-title fs-6 fw-bold text-dark mb-0 text-uppercase family-Inter-Bold border-bottom p-1" locale-res="AddComments">Add Comments</h4>
                                        <div class="table-type-form p-1">
                                            <form id="support-ticket-comment" action="" novalidate="novalidate" data-parsley-validate class="form-horizontal form-label-left col-md-12" method="post" enctype="multipart/form-data">
                                                <div class="form-group">
                                                    <label><span locale-res="TicketStatus">Ticket Status</span>:</label>
                                                    <select name="ticket_status_id" id="ticket_status_id" class="form-control" data-rule-required="true">
                                                        <option selected disabled>Please Select Status</option>
                                                        <option value="1">Pending</option>
                                                        <option value="2">Completed</option>
                                                        <option value="3">Closed</option>
                                                        <option value="4">Opened</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <input type="hidden" id="ticket_id" value="" name="ticket_id">
                                                    <label locale-res="Attachment">Comment</label>
                                                    <textarea cols="40" rows="2" name="text" id="ticket_comment" class="form-control" data-rule-required="true"></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label locale-res="Attachment">Attachment</label>
                                                    <div class="form-field">
                                                        <input name="file_name" type="file" id="comment_attachment" class="form-control">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="form-field">
                                                        <label locale-res="Attachment">Visible To Merchant</label>
                                                        <input name="is_visible" type="checkbox" id="is_visible">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-success">Submit</button>
                                                </div>
                                            </form>
                                            <div class="form-group"><label>Comment Will be add here</label></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="view-inner-wrapper shadow-sm border basicBg mb-3 position-relative">
                                        <h4 class="profile-title fs-6 fw-bold text-dark mb-0 text-uppercase family-Inter-Bold border-bottom p-1" locale-res="TrackPacket">Track Packet</h4>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="p-1">
                                                    <div class="profile-detail-wrap">
                                                        <label class="detail-label d-inline-block fw-500 family-Inter-Bold family-Inter-Bold">
                                                            No. of Pieces:
                                                        </label>
                                                        <div class="detail-info d-inline-block" id="no_of_pieces">1</div>
                                                    </div>
                                                </div>
                                                <div class="p-1">
                                                    <div class="profile-detail-wrap">
                                                        <label class="detail-label d-inline-block fw-500 family-Inter-Bold family-Inter-Bold">
                                                            Shipper Name:
                                                        </label>
                                                        <div class="detail-info d-inline-block" id="track_shippmentName"></div>
                                                    </div>
                                                </div>
                                                <div class="p-1">
                                                    <div class="profile-detail-wrap">
                                                        <label class="detail-label d-inline-block fw-500 family-Inter-Bold family-Inter-Bold">
                                                            Shipper Phone:
                                                        </label>
                                                        <div class="detail-info d-inline-block" id="track_shippmentPhone"></div>
                                                    </div>
                                                </div>
                                                <div class="p-1">
                                                    <div class="profile-detail-wrap">
                                                        <label class="detail-label d-inline-block fw-500 family-Inter-Bold family-Inter-Bold">
                                                            Shipper Address:
                                                        </label>
                                                        <div class="detail-info d-inline-block" id="track_shipment_address">.</div>
                                                    </div>
                                                </div>

                                                <div class="p-1">
                                                    <div class="profile-detail-wrap">
                                                        <label class="detail-label d-inline-block fw-500 family-Inter-Bold family-Inter-Bold">
                                                            Packet Weight:
                                                        </label>
                                                        <div class="detail-info d-inline-block">
                                                            <span id="dispatch_weight"></span>
                                                            <span>(Kgs)</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="p-1">
                                                    <div class="profile-detail-wrap">
                                                        <label class="detail-label d-inline-block fw-500 family-Inter-Bold family-Inter-Bold">
                                                            Consignee Name:
                                                        </label>
                                                        <div class="detail-info d-inline-block" id="track_Consignee_name"></div>
                                                    </div>
                                                </div>
                                                <div class="p-1">
                                                    <div class="profile-detail-wrap">
                                                        <label class="detail-label d-inline-block fw-500 family-Inter-Bold family-Inter-Bold">
                                                            Consignee Address:
                                                        </label>
                                                        <div class="detail-info d-inline-block" id="track_Consignee_address"></div>
                                                    </div>
                                                </div>
                                                <div class="p-1">
                                                    <div class="profile-detail-wrap">
                                                        <label class="detail-label d-inline-block fw-500 family-Inter-Bold family-Inter-Bold">
                                                            Consignee Number:
                                                        </label>
                                                        <div class="detail-info d-inline-block" id="track_Consignee_number"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-box table-type-form" id="trackingInformationTable">
                                        <div class="view-inner-wrapper shadow-sm border mb-3 basicBg">
                                            <h4 class="profile-title fs-6 fw-bold text-dark mb-0 text-uppercase family-Inter-Bold border-bottom p-1" locale-res="TrackingInformation">Tracking Information</h4>
                                            <table class="w-100">
                                                <thead>
                                                    <tr>
                                                        <th locale-res="ActivityDateTime">Activity Date Time</th>
                                                        <th locale-res="Status">Status</th>
                                                        <th locale-res="CourierCode">Courier Code</th>
                                                        <th locale-res="CourierName">Courier Name</th>
                                                    </tr>
                                                </thead>
                                                <tbody data-repeat="tracking_details" class="tracking_details">
                                                    <tr>
                                                        <td colspan="2" align="center">No Record Found</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="view-inner-wrapper shadow-sm border mb-3 basicBg">
                                        <h4 class="profile-title fs-6 fw-bold text-dark mb-0 text-uppercase family-Inter-Bold border-bottom p-1" locale-res="TicketActivity">Ticket Activity</h4>
                                        <div id="commentHistory" class="p-1">
                                            <div data-repeat="TicketDetails" id="TicketDetails"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="deduction_model" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Image</h4>
                </div>

                <div class="profile_img">
                    <div id="crop-avatar">
                        <!-- Current avatar -->
                        <img id="ticket-image" class="img-responsive avatar-view" alt="Avatar" title="Change the avatar" src="">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" id="deduction_submit" class="btn yellow">Save</button>
                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
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
        const id = atob(urlParams.get('id'));
        const cn = atob(urlParams.get('cn'));
        $.ajax({
            url: '<?php echo api_url('support_ticket/view'); ?>',
            method: 'GET',
            data: {ajax: true, id: id,cn: cn},
            headers: headers,
            dataType: 'json', // Set the expected data type to JSON
            beforeSend: function () {
                $('.error-container').html('');
            },
            success: function (data) {
                if (data && data.status == 1) {
                    syncFields(data.data);
                    getTrackingHistory(cn);
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

});

    function syncFields(data){

        $('#ticket_id').val(data.ticket.Id);
        $('#ticket_cn_no').text(data.ticket.CN);
        $('#tracking_id').text(data.ticket.CN);
        $('#created_date').text(data.ticket.CreatedOn);
        $('#lastUpdated_date').text(data.ticket.LastUpdatedOn);
        $('#ticket_type').text(data.ticket.Nature);
        $('#ticket_Issuetype').text(data.ticket.Name);
        $('#consignee_address').text(data.ticket.ConsigneeAddress);
        $('#consignee_number').text(data.ticket.ConsigneeContact);
        $('#destination_city').text(data.ticket.Destination);
        $('#track_destination_city').text(data.ticket.Destination);
        $('#origin_city').text(data.ticket.Origin);
        $('#track_origin_city').text(data.ticket.Origin);
        $('#cod_amount').text(data.ticket.CODAmount);
        $('#CurrentStatus').text(data.ticket.Status);
        $('#no_of_pieces').text(data.ticket.Pieces);
        $('#track_shippmentName').text(data.ticket.Shipper);
        $('#track_shippmentPhone').text(data.ticket.ShipperContact);
        $('#track_shipment_address').text(data.ticket.ShipperAddress);
        $('#dispatch_weight').text(data.ticket.Weight);
        $('#track_Consignee_name').text(data.ticket.Consignee);
        $('#track_Consignee_address').text(data.ticket.ConsigneeAddress);
        $('#track_Consignee_number').text(data.ticket.ConsigneeContact);
        if(data.TicketDetails==null){
            $('#comments-data').hide();
        }
        else{
            // Iterate through the ticketDetails array and create lists for each comment
             var $commentList = "";
            data.TicketDetails.forEach(comment => {
                if(comment.UserName != null){

                    $img="";
                    visibleClass="";
                    if(comment.ImgExist==1){
                        $img=`<div class="d-block w-100 mb-1">
                                        <a href="#deduction_model"  data-toggle="modal" data-repeat-item="Id" style="font-size: x-small;" class="attachment_open_btn text-uppercase p-1" id="attachment-show" data-comment-id="${comment.Id}">View Attachment</a>
                                    </div>`;
                    }
                    if(comment.IsVisible==true){
                        visibleClass="visible";
                    }
                    // Add comment details to the list
                    $commentList += `<div class="d-block w-100 mb-1 ${visibleClass}">
                                    <span class="fw-500 family-Inter-Bold">Updated At : </span>
                                    <span data-repeat-item="UpdatedDate">${comment.UpdatedDate}</span>
                                    <br>
                                    <span class="fw-500 family-Inter-Bold">Updated By : </span>
                                    <span data-repeat-item="UserName">${comment.UserName}</span><br>
                                    <span locale-res="Comments" class="fw-500 family-Inter-Bold">Comments : </span>
                                    <span data-repeat-item="Remarks">${comment.Remarks}</span><br>
                                    <span locale-res="Status" class="fw-500 family-Inter-Bold">Status : </span>
                                    <span data-repeat-item="Status"><b>${comment.Status}</b></span>
                                    <br>${$img}
                                    </div><hr>`;
                }

            });
            // Append the list to the #comments-data div
            $('#TicketDetails').append($commentList);
        }
    }

    function getTrackingHistory(cn){
        $.ajax({
            url: '<?php echo api_url('support_ticket/getTrackingHistory'); ?>',
            method: 'GET',
            data: {ajax: true, cn: cn},
            headers: headers,
            dataType: 'json', // Set the expected data type to JSON
            beforeSend: function () {
                $('.error-container').html('');
            },
            success: function (data) {
                if (data) {

                    populateTrackingHistory(data.data);

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

    function getTicketImages(data){

        lastIndex = data.TicketDetails.length-1;
        imgId = data.TicketDetails[lastIndex].Id;

        $.ajax({
            url: '<?php echo api_url('support_ticket/images'); ?>',
            method: 'GET',
            data: {ajax: true, id: imgId},
            headers: headers,
            dataType: 'json', // Set the expected data type to JSON
            beforeSend: function () {
                $('.error-container').html('');
            },
            success: function (data) {
                if (data) {

                    var imgElement = document.getElementById("ticket-image");

                    // Set the src attribute to the Base64 data URI
                    imgElement.src = "data:image/png;base64,"+data;

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

    $('#deduction_model').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                commentId = button.data('comment-id'); // Extract data from data-* attributes
                $.ajax({
            url: '<?php echo api_url('support_ticket/images'); ?>',
            method: 'GET',
            data: {ajax: true, id: commentId},
            headers: headers,
            dataType: 'json', // Set the expected data type to JSON
            beforeSend: function () {
                $('.error-container').html('');
            },
            success: function (data) {
                if (data) {

                    var imgElement = document.getElementById("ticket-image");

                    // Set the src attribute to the Base64 data URI
                    imgElement.src = data.data.DocPath;

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
    });

    $("#support-ticket-comment").validate({
        errorClass: "danger",
        errorPlacement: function (error, element) {
            error.addClass('w-100').appendTo(element.parent(0));
        },



        submitHandler: function (form, event) {
            event.preventDefault();

            var selectedStatus = document.getElementById("ticket_status_id").value;
            var isVisibleCheckbox = document.getElementById("is_visible");

            // Check if the selected status is "Closed"
            if (selectedStatus === "3") {
                // Check if the checkbox is checked
                if (!isVisibleCheckbox.checked) {
                    alert("Visible To Merchant is required for Closed status.");
                    return false; // Prevent form submission
                }
            }
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
                        url: '<?php echo api_url('support_ticket/comment_submit'); ?>',
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
                            if (data && data.status == 1) {
                                Swal.fire(
                                    'Saved!',
                                    'Ticket Comment has been added successfully',
                                    'success'
                                );
                                window.location.reload();
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

    function populateTrackingHistory(data){
        const sortedData = Object.values(data.journey).sort((a, b) => new Date(b.activity_date) - new Date(a.activity_date));
        var tableBody = $('.tracking_details');
        tableBody.empty();
        var row;
        // Loop through the JSON array and append rows to the table
        $.each(sortedData, function (index, item) {
            row = '<tr>' +
                '<td>' + item.activity_date + '</td>' +
                '<td>' + item.packet_status + '</td>' +
                '<td>' + item.courier_id + '</td>' +
                '<td>' + item.courier_name + '</td>' +
                '</tr>';

            tableBody.append(row);
        });

        if(data.tracking_detail){
            row += '<tr>' +
                    '<td>' + data.tracking_detail.created_at + '</td>' +
                    '<td> Posted for Consignment Booking at ' + data.tracking_detail.origin_city_name + '</td>' +
                    '</tr>';

            tableBody.append(row);
       }
    }
</script>


@endsection
