@extends('Admin.layout.main')
@section('title') Book Packet @endsection
@section('styles')
    <style>
        .labels {
            text-align: left !important;
        }

        .profile_details:nth-child(3n) {
            clear: none !important;
        }

        .profile_details .profile_view {
            height: 90px;
            background: #f2f5f7;
        }

        .danger.w-100 {
            color: red;
            font-size: 12px;
            float: left;
        }

        .add-shipper-btn {
            display: inline;
        }
    </style>
    <link rel="stylesheet" href="{{ url_secure('build/css/jquery_ui.css')}}">
@endsection

@section('content')

    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left" style="width: 100%">
                    <h3>Book Packet</h3>
                    <div class="col-md-10 error_display"
                         style="border-radius: 5px;background: rgb(214 214 214 / 25%);display: none">
                        <ul style="color:#ff000099;font-family: inherit"></ul>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="row equal d-lg-flex">
                <form id="booking_form" action="" novalidate="novalidate" data-parsley-validate
                      class="form-horizontal form-label-left" method="post">
                    <input type="hidden" name="booking_id" id="booking_id">
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="x_panel">
                            <div class="x_content" style="padding: 5px 5px 15px 5px;height: 1100px;">
                                <div class="col-sm-12">
                                    <h4 class="title border-bottom pb-1">Basic Information</h4>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12 col-xs-12 mb-2">
                                        <label>City <span class="danger">*</span></label>
                                        <select data-rule-required="true"
                                                data-msg-required="This field is required"
                                                class="form-control" id="client_city_id"
                                                name="client_city_id" onchange="getClientByCity()">
                                        </select>
                                        <span class="error-container danger w-100"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12 col-xs-12 mb-2">
                                        <label>Merchant *</label>
                                        <select class="select2 form-control" tabindex="-1" name="client_id"
                                                id="client_id" data-rule-required="true"  disabled
                                                data-msg-required="merchant is required" onchange="getShipperByClient()">
                                            <option value="">First select city</option>
                                        </select>
                                        <span class="error-container danger w-100"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12 col-xs-12 mb-2">
                                        <label>Division <span class="danger">*</span></label>
                                        <select data-rule-required="true"
                                                data-msg-required="This field is required" class="form-control"
                                                name="division_id" id="division_id" onchange="getServices()">
                                                <option value="">Select Division</option>
                                        </select>
                                        <span class="error-container danger w-100"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12 col-xs-12 mb-2">
                                        <label>Shipment Type <span class="danger">*</span></label>
                                        <select data-rule-required="true" disabled
                                                data-msg-required="This field is required" class="form-control select2"
                                                name="shipment_type_id" id="shipment_type_id"
                                                onchange="getServiceCode()">
                                            <option selected disabled>Select Division First...</option>
                                        </select>
                                        <input type="hidden" name="service_code" id="service_code">
                                        <span class="error-container danger w-100"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12">
                                        <label
                                            for="booking-date">Booking Date <span
                                                class="danger">*</span>
                                        </label>
                                        <input data-rule-required="true"
                                               data-msg-required="This field is required"
                                               type="date" id="booked_packet_date"
                                               name="booked_packet_date" required="required"
                                               class="form-control">
                                        <span class="error-container danger w-100"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12">
                                        <label>Net Weight (grams)<span class="danger">*</span></label>
                                        <input data-rule-maxlength="11"
                                               data-rule-required="true"
                                               data-msg-required="This field is required"
                                               id="booked_packet_weight"
                                               class="form-control"
                                               type="number" name="booked_packet_weight">
                                        <span class="error-container danger w-100"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12">
                                        <label>No Of Pieces <span class="danger">*</span></label>
                                        <input data-rule-maxlength="11"
                                               data-rule-required="true"
                                               data-msg-required="This field is required"
                                               id="booked_packet_no_piece"
                                               class="form-control"
                                               type="number" name="booked_packet_no_piece">
                                        <span class="error-container danger w-100"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12">
                                        <label>Order Id</label>
                                        <input data-rule-maxlength="11"
                                               id="booked_packet_order_id"
                                               class="form-control"
                                               type="number" name="booked_packet_order_id">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-12">Volumetric Dimensions</label>
                                    <div class="col-md-4 col-sm-12">
                                        <input data-rule-maxlength="11"
                                               id="booked_packet_vol_weight_w"
                                               class="form-control col-md-12 col-xs-12"
                                               type="number"
                                               name="booked_packet_vol_weight_w"
                                               placeholder="Width"
                                               onchange="volumeCompute()">
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <input data-rule-maxlength="11"
                                               id="booked_packet_vol_weight_h"
                                               class="form-control col-md-12 col-xs-12"
                                               type="number"
                                               name="booked_packet_vol_weight_h"
                                               placeholder="Height"
                                               onchange="volumeCompute()">
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <input data-rule-maxlength="11"
                                               id="booked_packet_vol_weight_l"
                                               class="form-control col-md-12 col-xs-12"
                                               type="number"
                                               name="booked_packet_vol_weight_l"
                                               placeholder="Length"
                                               onchange="volumeCompute()">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12">
                                        <label>Volumetric Weight Ratio</label>
                                        <input type="text" readonly
                                               name="booked_packet_vol_weight"
                                               class="form-control"
                                               id="booked_packet_vol_weight">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12">
                                        <label>Volumetric
                                            Weight</label>
                                        <input type="text" readonly
                                               name="booked_packet_vol_weight_cal"
                                               class="form-control"
                                               id="booked_packet_vol_weight_cal">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12">
                                        <label>CN#</label>
                                        <input type="text" readonly name="booked_packet_cn" class="form-control" id="booked_packet_cn">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="x_panel">
                            <div class="x_content" style="padding: 5px 5px 15px 5px;height: 880px;">
                                <div class="col-sm-12">
                                    <h4 class="title border-bottom pb-1 d-flex align-items-center justify-content-between">
                                        Shipper Details
                                        <button type="button" data-screen-permission-id="2"
                                                class="btn btn-outline-info btn-sm add-shipper-btn" data-toggle="modal"
                                                data-target="#add_shipper"><span class="fa fa-plus"></span></button>
                                    </h4>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12 col-xs-12 mb-3">
                                        <label>Shippers<span class="danger">*</span></label>
                                        <select data-rule-required="true" disabled
                                                data-msg-required="This field is required"
                                                id="shipper" name="merchant_id"
                                                class="form-control select2"
                                                onchange="getShipperDetails()">
                                            <option value="">First select merchant</option>
                                        </select>
                                        <span class="error-container danger w-100"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12">
                                        <label for="shipper_name">Shipper Name <span class="danger">*</span>
                                        </label>
                                        <input data-rule-required="true"
                                               data-msg-required="This field is required"
                                               type="text" id="shipper_name"
                                               required="required"
                                               class="form-control"
                                               disabled>
                                        <span class="error-container danger w-100"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12">
                                        <label>Shipper Email<span class="danger">*</span></label>
                                        <input data-rule-email="true"
                                               data-rule-required="true"
                                               data-msg-required="This field is required"
                                               id="shipper_email"
                                               class="form-control"
                                               type="email" name="shipper_email" disabled>
                                        <span class="error-container danger w-100"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12">
                                        <label>Shipper Phone <span class="danger">*</span></label>
                                        <input data-rule-required="true"
                                               data-msg-required="This field is required"
                                               id="shipper_phone"
                                               class="form-control"
                                               type="text"
                                               data-inputmask="'mask' : '99999999999'"
                                               disabled>
                                        <span class="error-container danger w-100"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label for="shipper_address">Shipper Address <span
                                                class="danger">*</span></label>
                                        <textarea maxlength="250" data-rule-required="true"
                                                  data-msg-required="This field is required"
                                                  id="shipper_address" required="required"
                                                  class="form-control"
                                                  disabled>
                                                </textarea>
                                        <span class="error-container danger w-100"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12 col-xs-12 mb-3">
                                        <label>Origin City <span class="danger">*</span></label>
                                        <select data-rule-required="true"
                                                data-msg-required="This field is required"
                                                class="form-control" id="origin_city"
                                                name="origin_city">
                                            }
                                            <option selected disabled>Choose option</option>
                                        </select>
                                        <span class="error-container danger w-100"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label for="return_address">Return Address</label>
                                        <textarea maxlength="50" data-rule-maxlength="300"
                                                  id="return_address" name="return_address"
                                                  class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label>Return City</label>
                                        <select class="form-control" name="return_city"
                                                id="return_city">
                                            <option selected disabled>Choose option</option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="x_panel">
                            <div class="x_content" style="padding: 5px 5px 15px 5px;height: 1100px;">
                                <div class="col-sm-12">
                                    <h4 class="title border-bottom pb-1">Consignee Detail</h4>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12">
                                        <label for="search_consignee">Search Consignee</label>
                                        <input id="search_consignee" name="search_consignee" class="form-control">
                                        <span>Search consignee by name/number</span>
                                        <input type="hidden" name="consignee_id" id="consignee_id">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12">
                                        <label for="consignee_name">Consignee Name <span class="danger">*</span></label>
                                        <input data-rule-required="true" maxlength="50"
                                               data-msg-required="This field is required"
                                               type="text" id="consignee_name"
                                               name="consignee_name"
                                               class="consignee form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12">
                                        <label>Consignee Email</label>
                                        <input data-rule-email="true" maxlength="50"
                                               id="consignee_email"
                                               class="consignee form-control"
                                               type="email" name="consignee_email">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12">
                                        <label>Consignee Phone <span class="danger">*</span></label>
                                        <input data-rule-maxlength="20"
                                               data-rule-required="true"
                                               data-msg-required="This field is required"
                                               id="consignee_phone"
                                               class="consignee form-control"
                                               type="text"
                                               data-inputmask="'mask' : '99999999999'"
                                               name="consignee_phone">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12">
                                        <label>Consignee Phone 2</label>
                                        <input data-rule-maxlength="20"
                                               id="consignee_phone_2"
                                               class="consignee form-control"
                                               type="text"
                                               data-inputmask="'mask' : '99999999999'"
                                               name="consignee_phone_2">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12">
                                        <label>Consignee Phone 3</label>
                                        <input data-rule-maxlength="20"
                                               id="consignee_phone_3"
                                               class="consignee form-control"
                                               type="text"
                                               data-inputmask="'mask' : '99999999999'"
                                               name="consignee_phone_3">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label for="consignee_address">Consignee Address <span
                                                class="danger">*</span></label>
                                        <textarea maxlength="250" data-rule-maxlength="300"
                                                  data-rule-required="true"
                                                  data-msg-required="This field is required"
                                                  id="consignee_address" required="required"
                                                  name="consignee_address"
                                                  class="consignee form-control"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12">
                                        <label>Postal Code</label>
                                        <input data-rule-maxlength="10"
                                               name="postal_code"
                                               id="postal_code"
                                               class="form-control consignee"
                                               type="number"
                                        >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-6 col-sm-6">
                                        <label>Latitude</label>
                                        <input data-rule-maxlength="20"
                                               name="lat"
                                               id="lat"
                                               class="form-control consignee"
                                               type="number"
                                        >
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <label>Longitude</label>
                                        <input data-rule-maxlength="20"
                                               name="long"
                                               id="long"
                                               class="consignee form-control"
                                               type="number"
                                        >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12 col-xs-12 mb-3">
                                        <label>Destination City <span class="danger">*</span></label>
                                        <select data-rule-required="true"
                                                data-msg-required="This field is required"
                                                class="form-control" name="destination_city"
                                                id="destination_city">
                                            <option selected disabled>Choose option</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12 col-xs-12 mb-3">
                                        <label>Select Area </label>
                                        <select id="consignee_area_id" style="width: 100%;"
                                                class="select2 form-control"
                                                name="consignee_area_id">
                                            <option value="" disabled selected>Select an option</option>
                                        </select>
                                        <span class="error-container danger w-100"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12 col-xs-12 mb-3">
                                        <label>Select Block </label>
                                        <select id="consignee_sub_area_id" style="width: 100%;"
                                                class="select2 form-control"
                                                name="consignee_sub_area_id">
                                            <option value="" disabled selected>Select an option</option>
                                        </select>
                                        <span class="error-container danger w-100"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label for="special instruction">Special Instruction <span
                                                class="danger">*</span></label>
                                        <textarea data-rule-required="true"
                                                  data-msg-required="This field is required"
                                                  id="booked_packet_comments"
                                                  required="required"
                                                  name="booked_packet_comments"
                                                  class="form-control"></textarea>
                                        <span class="error-container danger w-100"></span>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="x_panel">
                            <div class="x_content" style="padding: 5px 5px 15px 5px;height: 1100px;">
                                <div class="col-sm-12">
                                    <h4 class="title border-bottom pb-1">Payment Information</h4>
                                </div>
                                <div class="form-group" data-screen-permission-id="205">
                                    <div class="col-md-12 col-sm-12">
                                        <label>COD Amount <span class="danger">*</span></label>
                                        <input data-rule-required="true"
                                               data-msg-required="This field is required"
                                               maxlength="10" type="number"
                                               id="booked_packet_collect_amount"
                                               name="booked_packet_collect_amount"
                                               class="form-control" >
                                    </div>
                                </div>
                                <div class="form-group" data-screen-permission-id="205">
                                    <div class="col-md-12 col-sm-12">
                                        <label for="consignee_name">Payment Type <span class="danger">*</span></label>
                                        <hr>
                                        <button
                                            onclick="$('#booked_packet_collect_amount').removeAttr('readonly');"
                                            type="button" class="btn btn-primary btn-sm">COD
                                        </button>
                                        <button
                                            onclick="$('#booked_packet_collect_amount').attr('readonly','readonly');$('#booked_packet_collect_amount').val('0')"
                                            type="button" class="btn btn-success btn-sm">Prepaid
                                        </button>
                                    </div>
                                </div>
                                <div class="form-group" data-screen-permission-id="205">
                                    <p class="labels control-label col-md-12 col-sm-12">
                                        Please select prepaid option if your shipment is
                                        prepaid, otherwise select COD for cash on
                                        delivery.</p>
                                </div>
                                <div class="form-group text-right">
                                    <a href="<?php echo url_secure('manage_booking/list') ?>"><button class="btn btn-danger cancel-button" type="button">Cancel</button></a>
                                    <button type="submit" class="btn btn-success">{{ (Request::segment(3) == 'edit') ? 'Update' : 'Submit' }}</button>
                                </div>

                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /page content -->

    <div id="add_shipper" class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog"
         aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myModalLabel">Add Shipper</h4>
                </div>
                <div class="modal-body">
                    <div class="row-cols-1">
                        <form id="shipper_form" action="" novalidate="novalidate" data-parsley-validate
                              class="form-horizontal form-label-left" method="post">
                            <input type="hidden" value="" disabled name="id">
                            <div class="row">

                                <div class="col-md-4 col-sm-6 col-xs-12">
                                    <div class="form-group">

                                        <label for="last-name">Shipper Name <span class="danger">*</span></label>
                                        <input type="text" id="merchant_name" name="merchant_name"
                                               data-msg-required="This is required"
                                               data-rule-required="true"
                                               class="form-control">
                                        <span class="error-container danger w-100"></span>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label for="middle-name">Shipper
                                            Email <span class="danger">*</span></label>
                                        <input id="merchant_email" data-rule-email="true"
                                               data-msg-required="This is required"
                                               class="form-control" type="text" data-rule-required="true"
                                               name="merchant_email">
                                        <span class="error-container danger w-100"></span>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-6 col-xs-12">
                                    <div class="form-group">


                                        <label for="middle-name">Shipper
                                            Phone <span class="danger">*</span></label>
                                        <input data-inputmask="'mask' : '99999999999'" data-rule-required="true"
                                               data-msg-required="This is required" id="merchant_phone"
                                               class="form-control" type="text"
                                               name="merchant_phone">
                                        <span class="error-container danger w-100"></span>
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label>Select City <span class="danger">*</span></label>
                                        <select id="city_id" style="width: 100%;"
                                                data-rule-required="true"
                                                name="city_id" data-msg-required="This is required">
                                            <option value="" disabled selected>Select an option</option>
                                        </select>
                                        <span class="error-container danger w-100"></span>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label>Select Area <span class="danger">*</span></label>
                                        <select id="area_id" style="width: 100%;"
                                                class="select2 form-control"
                                                name="area_id">
                                            <option value="" disabled selected>Select an option</option>
                                        </select>
                                        <span class="error-container danger w-100"></span>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label>Select Block <span class="danger">*</span></label>
                                        <select id="subarea_id" style="width: 100%;"
                                                class="select2 form-control"
                                                name="subarea_id">
                                            <option value="" disabled selected>Select an option</option>
                                        </select>
                                        <span class="error-container danger w-100"></span>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">


                                        <label for="middle-name">Shipper
                                            Address <span class="danger">*</span></label>
                                        <textarea data-msg-required="This is required"
                                                  id="merchant_address1" class="form-control"
                                                  name="merchant_address1"></textarea>
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
                                            <input type="checkbox" class="bank checkoption" id="iban" value="1"
                                                   name="iban">
                                            <span class="error-container danger w-100"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-xs-12 mb-3">
                                        <div class="form-group">
                                            <label for="middle-name">A/C No #</label>
                                            <input type="checkbox" class="bank checkoption" id="ac_no" value="1"
                                                   name="ac_no">
                                            <span class="error-container danger w-100"></span>
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

                                <div class="col-md-6 col-sm-6 col-xs-12 account_details">
                                    <div class="form-group">
                                        <label>Select Bank <span class="danger">*</span></label>
                                        <select id="bank_id" name="bank_id" class="bank_account_no bank_id"
                                                style="width: 100%;"
                                                data-msg-required="This is required">
                                            <option value="" disabled selected>Select an option</option>
                                        </select>
                                        <span class="error-container danger w-100"></span>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12 account_details">
                                    <div class="form-group">

                                        <label for="middle-name">Bank Account No. <span
                                                class="danger">*</span></label>
                                        <input id="bank_ac_no" class="bank_account_no form-control" type="text"
                                               name="bank_ac_no">
                                        <span class="error-container danger w-100"></span>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12 account_details">
                                    <div class="form-group">
                                        <label for="middle-name">Bank Account Tittle <span
                                                class="danger">*</span></label>
                                        <input id="bank_ac_title" class="bank_account_no form-control"
                                               type="text" name="bank_ac_title">
                                        <span class="error-container danger w-100"></span>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12 account_details">
                                    <div class="form-group">
                                        <label for="middle-name">Bank Branch <span class="danger">*</span></label>
                                        <input id="bank_branch" class="bank_account_no form-control" type="text"
                                               name="bank_branch">
                                        <span class="error-container danger w-100"></span>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                    <div class="form-group">


                                        <button class="btn btn-danger" data-dismiss="modal" type="button">Cancel
                                        </button>

                                        <button type="submit" class="btn btn-success">{{ (Request::segment(3) == 'edit') ? 'Update' : 'Submit' }}</button>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default antoclose" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="<?php echo url_secure('vendors/validate/jquery.validate.min.js') ?>" type="text/javascript"></script>
    <script src="<?php echo url_secure('vendors/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js') ?>"></script>
    <script src="{{ url_secure('build/js/jquery_ui.js')}}"></script>
    <script>
        const token = getToken();
        const getUserData = JSON.parse(getUser());
        const headers = {
            "Authorization": `Bearer ${token}`,
        };

    const url = window.location.search;
    if(url) {
        const urlParams = new URLSearchParams(url);
        const cn = atob(urlParams.get('cn'));
        $.ajax({
            url: '<?php echo api_url('manage_booking/edit'); ?>',
            method: 'GET',
            headers: headers,
            data: {ajax: true, cn: cn},
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

        $(document).ready(function () {

            $("#client_city_id").select2({
                placeholder: "Search City",
                minimumInputLength: 2, // Minimum characters before sending the AJAX request
                allowClear: true,
                ajax: {
                    url: "{{ api_url('get_cities') }}", // Replace with your actual server endpoint
                    dataType: "json",
                    delay: 250, // Delay before sending the request in milliseconds
                    headers: headers,
                    processResults: function (data) {
                        $('#client_id').prop('disabled', false);
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

            $("#division_id").select2({
                placeholder: "Search Division",
                minimumInputLength: 2, // Minimum characters before sending the AJAX request
                allowClear: true,
                ajax: {
                    url: "{{ api_url('manage_booking/get_divisions') }}", // Replace with your actual server endpoint
                    dataType: "json",
                    delay: 250, // Delay before sending the request in milliseconds
                    headers: headers,
                    processResults: function (data) {
                        $('#shipment_type_id').prop('disabled', false);
                        return {
                            results: data.data.divisions.map(function (item) {
                                return {
                                    id: item.Division_code,
                                    text: item.Division_Name // 'text' property is required by Select2
                                };
                            })
                        };
                    },
                    cache: true // Enable caching of AJAX results
                }
            });

            $("#origin_city").select2({
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
            $("#return_city").select2({
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
            $("#destination_city").select2({
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

            $("#city_id").select2({
                dropdownParent: $("#city_id").parent(),
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

            $("#area_id").select2({
                dropdownParent: $("#area_id").parent(),
                placeholder: "Search Area",
                minimumInputLength: 2, // Minimum characters before sending the AJAX request
                ajax: {
                    url: "{{ api_url('get_areas') }}", // Replace with your actual server endpoint
                    dataType: "json",
                    data: function (params) {
                        return {
                            term: params.term,
                            city_id: $('#city_id').val(),
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
                dropdownParent: $("#subarea_id").parent(),
                placeholder: "Search Block",
                minimumInputLength: 2, // Minimum characters before sending the AJAX request
                ajax: {
                    url: "{{ api_url('get_blocks') }}", // Replace with your actual server endpoint
                    dataType: "json",
                    data: function (params) {
                        return {
                            term: params.term,
                            area_id: $('#area_id').val(),
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

            $("#bank_id").select2({
                dropdownParent: $("#bank_id").parent(),
                placeholder: "Search Bank",
                minimumInputLength: 2, // Minimum characters before sending the AJAX request
                ajax: {
                    url: "{{ api_url('get_banks') }}", // Replace with your actual server endpoint
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

            $("#consignee_area_id").select2({
                dropdownParent: $("#consignee_area_id").parent(),
                placeholder: "Search Area",
                minimumInputLength: 2, // Minimum characters before sending the AJAX request
                ajax: {
                    url: "{{ api_url('get_areas') }}", // Replace with your actual server endpoint
                    dataType: "json",
                    data: function (params) {
                        return {
                            term: params.term,
                            city_id: $('#destination_city').val(),
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

            $("#consignee_sub_area_id").select2({
                dropdownParent: $("#consignee_sub_area_id").parent(),
                placeholder: "Search Block",
                minimumInputLength: 2, // Minimum characters before sending the AJAX request
                ajax: {
                    url: "{{ api_url('get_blocks') }}", // Replace with your actual server endpoint
                    dataType: "json",
                    data: function (params) {
                        return {
                            term: params.term,
                            area_id: $('#consignee_area_id').val(),
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

            $(function () {


                $("#search_consignee").autocomplete({
                    source: function (request, response) {
                        var merchant_id = $('#client_id').val();
                        $.ajax({
                            url: "{{ api_url('manage_client/consignee/consignee_details')}}",
                            dataType: "json",
                            data: {
                                term: request.term, // Pass the search term entered by the user
                                id: merchant_id,
                            },
                            headers: headers,
                            beforeSend: function () {
                                $('.consignee').attr('disabled', false);
                                $('.consignee').val('');
                                $('#consignee_id').val('');
                                $('#consignee_name').val('');
                                $('#consignee_email').val('');
                                $('#consignee_phone').val('');
                                $('#consignee_phone_2').val('');
                                $('#consignee_phone_3').val('');
                                $('#consignee_address').val('');
                                $('#postal_code').val('');
                                $('#lat').val('');
                                $('#long').val('');
                            },
                            success: function (data) {
                                if(data.status == 0){
                                    Swal.fire(
                                        'Error!',
                                        data.msg,
                                        'error'
                                    );
                                }
                                response(data);
                            }
                        });
                    },
                    focus: function (event, ui) {
                        return false;
                    },
                    select: function (event, ui) {
                        $('#consignee_id').val(ui.item.id);
                        $('#consignee_name').val(ui.item.consignee_name);
                        $('#consignee_email').val(ui.item.consignee_email);
                        $('#consignee_phone').val(ui.item.consignee_phone);
                        $('#consignee_phone_2').val(ui.item.consignee_phone_two);
                        $('#consignee_phone_3').val(ui.item.consignee_phone_three);
                        $('#consignee_address').val(ui.item.consignee_address);
                        $('#postal_code').val(ui.item.postal_code);
                        $('#lat').val(ui.item.lat);
                        $('#long').val(ui.item.long);

                        $('.consignee').attr('disabled', true);
                        return false;
                    },
                });
            });
            // getShippers();
            // getDivisions();

            // $.ajax({
            //     url: '{{ api_url('merchant/booking/get_shipment_type') }}',
            //     method: 'GET',
            //     dataType: 'json',
            //     headers: headers,
            //     beforeSend: function () {
            //         $('.error-container').html('');
            //     },
            //     success: function (data) {
            //         var shipperOption = '';
            //         $('#shipment_type_id').empty();
            //         $('#shipment_type_id').append('<option value="">Select Shipment Type</option>');
            //         $.each(data.data.shipment_type, function (index, value) {
            //             shipperOption += `<option value="${value.id}">${value.shipment_type_name}</option>`;
            //         });
            //         $('#shipment_type_id').append(shipperOption);
            //     },
            //     complete: function (data) {
            //         $('#shipment_type_id').prop('disabled', false);
            //     }

            // });
        });



        function getDivisions() {
            $.ajax({
                url: '{{ api_url('manage_booking/get_divisions') }}',
                method: 'GET',
                dataType: 'json',
                headers: headers,
                beforeSend: function () {
                    $('.error-container').html('');
                },
                success: function (data) {
                    var shipperOption = '';
                    $('#division_id').empty();
                    $('#division_id').append('<option value="">Select Division</option>');
                    $.each(data.data.divisions, function (index, value) {
                        shipperOption += `<option value="${value.Division_code}">${value.Division_Name}</option>`;
                    });
                    $('#division_id').append(shipperOption);
                },
                complete: function (data) {
                    $('#division_id').prop('disabled', false);
                }

            });
        }

        function getServiceCode() {
            var service_code = $('#shipment_type_id').find(":selected").attr('data-service_code');
            $('#service_code').val(service_code);
        }

        function getServices() {
            var division_code = $('#division_id').find(":selected").val();

            $.ajax({
                url: '{{ api_url('manage_booking/getservicesbydivisions') }}',
                method: 'GET',
                headers: headers,
                data: {division_code: division_code},
                dataType: 'json',
                success: function (data) {
                    var shipperOption = '';
                    $('#shipment_type_id').empty();
                    $('#shipment_type_id').append('<option value="">Select Shipment Type</option>');

                    $.each(data.data, function (index, value) {
                        shipperOption += `<option data-service_code="${value.service_code}" value="${value.shipment_type_id}">${value.service_name}</option>`;
                    });
                    $('#shipment_type_id').append(shipperOption);
                },
                complete: function (data) {
                    $('#shipment_type_id').prop('disabled', false);
                }
            });
        }

        function getShipperDetails() {
            var shipper_id = $('#shipper').find(":selected").val();
            if(shipper_id){
                $.ajax({
                    url: '{{ api_url('manage_client/shipper/shipper_details') }}',
                    method: 'GET',
                    headers: headers,
                    data: {shipper_id: shipper_id},
                    dataType: 'json',
                    success: function (data) {
                        var response = data.data.shipper_detail;
                        $('#shipper_name').val(response.merchant_name);
                        $('#shipper_email').val(response.merchant_email);
                        $('#shipper_phone').val(response.merchant_phone);
                        $('#shipper_address').val(response.merchant_address1);
                    },
                    error: function () {
                        // Handle any errors
                        console.error('An error occurred during the AJAX request.');
                    }
                });
             }
        }

        function volumeCompute() {

            var width = ($('#booked_packet_vol_weight_w').val()) ? parseFloat($('#booked_packet_vol_weight_w').val()) : 0;
            var height = ($('#booked_packet_vol_weight_h').val()) ? parseFloat($('#booked_packet_vol_weight_h').val()) : 0;
            var length = ($('#booked_packet_vol_weight_l').val()) ? parseFloat($('#booked_packet_vol_weight_l').val()) : 0;

            if (width && height && length) {
                var booked_packet_vol_weight_cal = (width * height * length) / 5000;
                $('#booked_packet_vol_weight').val($('#booked_packet_vol_weight_w').val() + ':' + $('#booked_packet_vol_weight_h').val() + ':' + $('#booked_packet_vol_weight_l').val());
                $('#booked_packet_vol_weight_cal').val(booked_packet_vol_weight_cal);
            } else {
                $('#booked_packet_vol_weight_cal').val('');
                $('#booked_packet_vol_weight').val('');
            }


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
                    if (element === 'client_city_id' && data.client_city_id) {
                        option = new Option(data.client_city_name, data.client_city_id, true, true);
                        $('#client_city_id').append(option).trigger('change');

                    }
                    else if (element === 'client_id' && data.client_id) {
                        option = new Option(data.client_name, data.client_id, true, true);
                        $('#client_id').append(option).trigger('change');
                        $('#client_id').prop('disabled', false);
                    }

                    else if (element === 'shipment_type_id' && data.shipment_type_id) {

                        option = new Option(data.shipment_type_name, data.shipment_type_id, true, true);
                        $('#shipment_type_id').append(option).trigger('change');
                        $('#shipment_type_id').prop('disabled', false);
                        if(data.shipment_type_id == 2 || data.shipment_type_id == 10){
                            option = new Option('EXPRESS', 'E', true, true);
                        }
                        else if(data.shipment_type_id == 3){
                            option = new Option('LOGISTICS', 'L', true, true);
                        }
                        $('#division_id').append(option);
                    }
                    else if (element === 'origin_city' && data.origin_city) {
                        option = new Option(data.origin_city_name, data.origin_city, true, true);
                        $('#origin_city').append(option).trigger('change');
                    }
                    else if (element === 'destination_city' && data.destination_city) {
                        option = new Option(data.destination_city_name, data.destination_city, true, true);
                        $('#destination_city').append(option).trigger('change');
                    }
                    else if (element === 'return_city' && data.return_city) {
                        option = new Option(data.return_city_name, data.return_city, true, true);
                        $('#return_city').append(option).trigger('change');
                    }
                    else if (data.shipper_id) {
                        option = new Option(data.shipper_name, data.shipper_id, true, true);
                        $('#shipper').append(option).trigger('change');
                        $('#shipper').prop('disabled', false);
                    }
                    else if (element === 'consignee_area_id' && data.area_id) {
                        option = new Option(data.area_id, data.area_id, true, true);
                        $('#consignee_area_id').append(option).trigger('change');
                    }
                    else if (element === 'consignee_sub_area_id' && data.subarea_id) {
                        option = new Option(data.subarea_id, data.subarea_id, true, true);
                        $('#consignee_sub_area_id').append(option).trigger('change');
                    }
                    else {
                        input.val(values[index]);
                        input.trigger('change');
                    }
                } else {

                    if (element === 'booking_id') {
                        input.prop('disabled', false);
                    }
                    input.val(values[index]);
                }
            });
        }

        $("#booking_form").validate({
            errorClass: "danger",
            errorPlacement: function (error, element) {
                error.addClass('w-100').appendTo(element.parent(0));
            },
            submitHandler: function (form, event) {
                event.preventDefault();

                Swal.fire({
                    title: 'Are you sure to submit this form?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Submit'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var data = $('#booking_form').serialize();
                        $.ajax({
                            url: '<?php echo api_url('manage_booking/add'); ?>',
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
                                    Swal.fire({
                                        title: 'Do you want to print a Airway Bill?',
                                        text: "Click Print to Continue",
                                        icon: 'warning',
                                        showCancelButton: true,
                                        confirmButtonColor: '#3085d6',
                                        cancelButtonColor: '#d33',
                                        confirmButtonText: 'Print',
                                        cancelButtonText: 'No',
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            window.open(`<?php echo url_secure('manage_booking/booked_packet_slip/')?>/${data.booking_id}`, '_blank');
                                        }
                                        window.location.href = '<?php echo url_secure('manage_booking/list') ?>'

                                    });
                                } else {
                                    var errors = (data.errors) ? data.errors : {};
                                    if (Object.keys(errors).length > 0) {

                                        var error_key = Object.keys(errors);
                                        var error_display = "";
                                        for (var i = 0; i < error_key.length; i++) {
                                            var fieldName = error_key[i];
                                            var errorMessage = errors[fieldName];
                                            if (errorMessage.length > 0) {
                                                if ($('#' + fieldName).length) {
                                                    var element = $('#' + fieldName);
                                                    var element_error = `${errorMessage}`;
                                                    element.next('.error-container').html(element_error);
                                                    element.focus();
                                                    error_display += `<li>${errorMessage}</li>`;
                                                }
                                            }
                                        }
                                        $('.error_display ul').html(error_display);
                                        $('.error_display').show();
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

    </script>

    <script>
        $('.bank').attr('disabled', 'disabled');
        $('body').on('click', '#is_settlement', function () {
            if ($(this).is(':checked')) {
                $('.bank').removeAttr('disabled');
            } else {
                $('.bank').attr('disabled', 'disabled');
                $('.bank').val('');
                $('.bank').trigger('change');
                $('.account_details').css('display', 'none');
                $('.iban_details').css('display', 'none');
                $('.bank_account_no').val('');
                $('.bank_account_no').trigger('change');
                $('#iban').prop('checked', false);
                $('#ac_no').prop('checked', false);
            }
        });

        $('.account_details').css('display', 'none');
        $('.iban_details').css('display', 'none');

        $('body').on('click', '#ac_no', function () {
            if ($(this).is(':checked')) {
                $('.account_details').css('display', 'block');
                $('.iban_details').css('display', 'none');
            } else {
                $('.account_details').css('display', 'none');
                // $('.iban_details').css('display', 'block');
                $('.bank_account_no').val('');
                $('.bank_account_no').trigger('change');
            }
        });

        $('body').on('click', '#iban', function () {
            if ($(this).is(':checked')) {
                $('.iban_details').css('display', 'block');
                $('.account_details').css('display', 'none');
            } else {
                // $('.account_details').css('display', 'none');
                $('.iban_details').css('display', 'none');
                $('.bank_account_no').val('');
                $('.bank_account_no').trigger('change');
            }
        });

        $('.checkoption').click(function () {
            $('.checkoption').not(this).prop('checked', false);
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
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Submit'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var data = $('#shipper_form').serialize();
                        $.ajax({
                            url: '<?php echo api_url('merchant/shipper/submit'); ?>',
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
                                        'New Shipper Added successfully',
                                        'success'
                                    );
                                    $('#add_shipper').modal('hide');
                                    getShippers(data.shipper_id);
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


        function getClientByCity(){
            $("#client_id").select2({
                placeholder: "Search By Client",
                minimumInputLength: 2, // Minimum characters before sending the AJAX request
                allowClear: true,
                ajax: {
                    url: "{{ api_url('clients_list') }}?city_id="+$('#client_city_id').val(), // Replace with your actual server endpoint
                    dataType: "json",
                    delay: 250, // Delay before sending the request in milliseconds
                    headers: headers,
                    processResults: function (data) {
                        $('#shipper').prop('disabled', false);
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

        function getShipperByClient(){
            $("#shipper").select2({
                placeholder: "First Select Merchant",
                minimumInputLength: 2, // Minimum characters before sending the AJAX request
                allowClear: true,
                ajax: {
                    url: "{{ api_url('manage_client/shipper/get_shippers') }}?client_id="+$('#client_id').val(), // Replace with your actual server endpoint
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

    </script>
@endsection
