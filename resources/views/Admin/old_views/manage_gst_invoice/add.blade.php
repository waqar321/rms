@extends('Admin.layout.main')

@section('styles')
<style>
    .print_invoice {
        background: transparent;
        border: transparent;
        padding: 0;
        color: #5a738e;
    }
    .portlet-title {
        padding: 8px 14px 1px;
        background: #dbb60d;
        margin: 10px;
    }
    .row.form-body.charges {
        margin-top: 30px;
    }
    .select2-container {
        width: 100% !important;
        margin: 2px 0 12px;
    }
    .h1-border-bottom {
        font-size: 15px;
        font-weight: 600;
    }
    input#invoice_date {
        background: #fff;
    }
    .dataTables_wrapper {
        min-height: auto !important;
        height: 500px;
    }
    div#readyForChequeTable_wrapper {
        height: 500px;
    }
    table#myTable thead,table#readyForChequeTable thead {
        table-layout: fixed;
        position: sticky;
        top: 0;
    }
</style>
@endsection

@section('title') Make A New Invoice @endsection

@section('content')
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Manage Invoice</h3>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Make A New Invoice</h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <br/>
                            <form id="select_form" action="" novalidate="novalidate" data-parsley-validate
                                  class="form-horizontal form-label-left" method="post">
                                <input type="hidden" value="" disabled name="id">

                                <div class="col-md-3 col-sm-4 col-xs-12">
                                        <label>Search By End Date</label>
                                        <input type="date" class="form-control" name="ending_date" id="ending_date">
                                </div>

                                <div class="col-md-3 col-sm-6 col-xs-12">

                                    <div class="form-group">
                                        <label>Shipment Type<span class="danger">*</span></label>
                                        <select data-rule-required="true" data-msg-required="This is required"
                                                name="shipment_type_id" id="shipment_type_id"
                                                class="form-control select2">
                                            <option value="0">- All Shipment Types -</option>
                                        </select>
                                        <span class="error-container danger w-100"></span>
                                    </div>
                                </div>

                                <div class="col-md-3 col-sm-6 col-xs-12">

                                    <div class="form-group">
                                        <label>City Name</label>
                                        <select name="city_id" id="city_id" class="form-control select2" onchange="getClientByCity()">
                                            <option value="">- Select a City For Client -</option>
                                        </select>
                                        <span class="error-container danger w-100"></span>
                                    </div>
                                </div>

                                <div class="col-md-3 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label>Client (Shipper)<span class="danger">*</span></label>
                                        <select data-rule-required="true" data-msg-required="This is required" class="form-control select2" name="merchant_id" id="merchant_id" onchange="getShippersByClient()">
                                        </select>
                                        <span class="error-container danger w-100"></span>
                                    </div>
                                </div>

                                <div class="col-md-3 col-sm-6 col-xs-12" style="display:none" id="shipper_div">
                                    <div class="form-group">
                                        <label>Sub Shippers <span class="danger">*</span></label>
                                        <select data-rule-required="true" data-msg-required="This is required" class="form-control select2" name="shipper_id" id="shipper_id" required>
                                        </select>
                                        <span class="error-container danger w-100"></span>
                                    </div>
                                </div>

                                <div class="col-md-12 col-sm-12 col-xs-12">

                                    <div class="form-group">
                                        <a href="<?php echo url_secure('manage_cheque') ?>">
                                            <button class="btn btn-danger cancel-button" type="button">Cancel</button>
                                        </a>
                                        <button type="submit" class="btn btn-success submit-and-update-button">View Details</button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>

                    <div class="x_panel search-results" style="display: none;">
                        <div class="x_title">
                            <h2>Search Results</h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                        <div class="portlet-body form">
                            <div class="form-horizontal">
                                <div class="row form-body">
                                    <div class="col-md-4" style="border-right: 1px solid #e7ecf1;">
                                        <div class="h1-border-bottom">Client Information</div>
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <th width="30%">Name</th>
                                                    <td id="merchant_name"></td>
                                                </tr>
                                                <tr>
                                                    <th>Address</th>
                                                    <td id="merchant_address1"></td>
                                                </tr>
                                                <tr>
                                                    <th>Location</th>
                                                    <td>Karachi, Pakistan</td>
                                                </tr>
                                                <tr>
                                                    <th>Phone</th>
                                                    <td  id="merchant_phone"></td>
                                                </tr>
                                                <tr>
                                                    <th>Email</th>
                                                    <td id="merchant_email"></td>
                                                </tr>
                                                <tr>
                                                    <th>Tariff Charges</th>
                                                    <td><a href="javascript:void(0)" id="client_id" onclick="viewTariff(this)" class="btn btn-sm">View Tariff</a></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-4 charges">
                                        <div class="h1-border-bottom">Packet Information</div>
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <th width="60%">Delivered:</th>
                                                    <td id="total_delivered"></td>
                                                </tr>
                                                <tr>
                                                    <th>Return:</th>
                                                    <td id="total_returned"></td>
                                                </tr>
                                                <tr>
                                                    <th>Under Process:</th>
                                                    <td id="total_under_process"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <hr>
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <th width="60%">Total:</th>
                                                    <td id="total_packets"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-4" style="border-left: 1px solid #e7ecf1;">
                                        <div class="h1-border-bottom">Payment History</div>
                                        <table class="table table-bordered" id="invoice-history">
                                            <thead>
                                                <tr>
                                                    <th width="30%">Invoice No.</th>
                                                    <th width="30%">Invoice Amount</th>
                                                    <th width="30%">Invoice Date</th>
                                                    <th width="10%">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="row form-body">
                                    <div class="col-md-12">
                                        <div class="portlet yellow">
                                            <div class="portlet-title">
                                                <h4><strong>Delivered - Payment not received or Payment difference</strong></h4>
                                            </div>
                                            <div class="portlet-body form">
                                                <div class="form-horizontal">
                                                    <div class="row form-body">
                                                        <div class="col-md-12" style="overflow:scroll">
                                                            <table id="myTable" class="table table-striped table-bordered" style="width:100%">
                                                                <thead>
                                                                    <tr role="row">
                                                                        <th>Sr#</th>
                                                                        <th>Status</th>
                                                                        <th>CN#</th>
                                                                        <th>Client A/C#</th>
                                                                        <th>Booking Date</th>
                                                                        <th>Destination</th>
                                                                        <th>Zone</th>
                                                                        <th>Weight (KG)</th>
                                                                        <th>VPC (PKR)</th>
                                                                        <th>Insurance#</th>
                                                                        <th>G.S.T</th>
                                                                        <th>Fuel Surcharge</th>
                                                                        <th>Amount (PKR)</th>
                                                                        <th>Charges (PKR)</th>
                                                                    </tr>
                                                                </thead>
                                                                <tfoot>
                                                                    <tr>
                                                                        <th colspan="7" align="right"><b>Grand Total:</b></th>
                                                                        <th id="notpayable-weight"align="right">0.00</th>
                                                                        <th id="notpayable-vpc" align="right">0.00</th>
                                                                        <th id="notpayable-insurance" align="right">0.00</th>
                                                                        <th id="notpayable-gst" align="right">0.00</th>
                                                                        <th id="notpayable-fuel-surge" align="right">0.00</th>
                                                                        <th id="notpayable-cod">0.00</th>
                                                                        <th id="notpayable-charges">0.00</th>
                                                                    </tr>
                                                                </tfoot>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row form-body">
                                    <div class="col-md-12">
                                        <div class="portlet yellow">
                                            <div class="portlet-title">
                                                <h4><strong>Delivered - Payment Received (Ready for Invoice)</strong></h4>
                                            </div>
                                            <div class="portlet-body form">
                                                <div class="form-horizontal">
                                                    <div class="row form-body">
                                                        <div class="col-md-12" style="overflow:scroll">
                                                            <table id="readyForChequeTable" class="table table-striped table-bordered" style="width:100%">
                                                                <thead>
                                                                    <tr role="row">
                                                                        <th><input type="checkbox" class="selectAll" checked="true"></th>
                                                                        <th>Sr# - Status</th>
                                                                        <th>CN#</th>
                                                                        <th>Client A/C#</th>
                                                                        <th>Booking Date</th>
                                                                        <th>Destination</th>
                                                                        <th>Shipment Type</th>
                                                                        <th>Zone</th>
                                                                        <th>Weight (KG)</th>
                                                                        <th>VPC (PKR)</th>
                                                                        <th>Insurance#</th>
                                                                        <th>G.S.T</th>
                                                                        <th>Fuel Surcharge</th>
                                                                        <th>Amount (PKR)</th>
                                                                        <th>Charges (PKR)</th>
                                                                    </tr>
                                                                </thead>
                                                                <tfoot>
                                                                    <tr>
                                                                        <th colspan="8" align="right"><b>Grand Total:</b></th>
                                                                        <th id="payable-weight"align="right">0.00</th>
                                                                        <th id="payable-vpc" align="right">0.00</th>
                                                                        <th id="payable-insurance" align="right">0.00</th>
                                                                        <th id="payable-gst" align="right">0.00</th>
                                                                        <th id="payable-fuel-surge" align="right">0.00</th>
                                                                        <th id="payable-cod">0.00</th>
                                                                        <th id="payable-charges">0.00</th>
                                                                    </tr>
                                                                </tfoot>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row form-body charges">
                                    <div class="col-md-12">
                                        <div class="portlet-title">
                                                <h4><strong>Summary</strong></h4>
                                        </div>
                                    </div>
                                        <div class="col-md-4" style="border-right: 1px solid #e7ecf1;">
                                            <div class="h1-border-bottom">Freight Charges</div>
                                            <table class="table">
                                                <tbody>
                                                    <tr>
                                                        <th width="60%">Net Freight Charges	</th>
                                                        <td id="total_charges">0.00</td>
                                                    </tr>
                                                    <tr>
                                                        <th>
                                                            Discount (<span id="merchant_discount"></span>)%
                                                        </th>
                                                        <td id="discount-value"> - 0.00</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <hr>
                                            <table class="table">
                                                <tbody>
                                                    <tr>
                                                        <th width="60%">Freight Charges</th>
                                                        <td id="invoice">0.00</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Fuel Surcharge</th>
                                                        <td id="total_sercharge">0.00</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Fuel Factor	</th>
                                                        <td id="fuel_factor">0.00</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <hr>
                                            <table class="table">
                                                <tbody>
                                                    <tr>
                                                        <th width="60%">Net Amount</th>
                                                        <td id="net_amount">0.00/td>
                                                    </tr>
                                                    <tr>
                                                        <th>G.S.T.</th>
                                                        <td id="total_gst">0.00</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Insurance</th>
                                                        <td id="total_insurance">0.00</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <hr>
                                            <table class="table">
                                                <tbody>
                                                    <tr>
                                                        <th width="60%">Gross Freight Charges</th>
                                                        <td id="gross_invoice">0.00</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="h1-border-bottom">COD Amount</div>
                                            <table class="table">
                                                <tbody>
                                                    <tr>
                                                        <th width="60%">Total COD Amount</th>
                                                        <td id="total_amount">0.00</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Return COD Amount</th>
                                                        <td id="total_return_amount">0.00</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <hr>
                                            <table class="table">
                                                <tbody>
                                                    <tr>
                                                        <th width="60%">Amount Payable</th>
                                                        <td id="amount_payable">0.00</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="col-md-4" style="border-left: 1px solid #e7ecf1;">
                                            <div class="h1-border-bottom">Payable</div>
                                            <table class="table">
                                                <tbody>
                                                    <tr>
                                                        <th width="60%">Amount Payable</th>
                                                        <td id="amount_payable_1">0.00</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Gross Freight Charges</th>
                                                        <td id="gross_invoice_1">0.00</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <hr>
                                            <table class="table">
                                                <tbody>
                                                    <tr>
                                                        <th width="60%">Total Payable</th>
                                                        <td id="total_payable">0.00</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <hr>
                                            <table class="table">
                                                <tbody>
                                                    <tr>
                                                        <th width="60%">Deduction</th>
                                                        <td>
                                                            <span id="deductionNew" data-original-title="" title="">- 0.00</span>
                                                            <a href="#deduction_model" data-toggle="modal"><i class="fa fa-pencil"></i> </a>
                                                            <input type="hidden" id="deductionOld" value="0">
                                                        </td>
                                                    </tr>
                                                    <tr class="hide">
                                                        <th>Miscellaneous Payable</th>
                                                        <td>
                                                            <span id="deficitNew" data-original-title="" title="">+ 0.00 </span>
                                                            <a href="#deficit_model" data-toggle="modal"><i class="fa fa-pencil"></i> </a>
                                                            <input type="hidden" id="deficitOld" value="0">
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <hr>
                                            <table class="table" id="packing-materials">
                                                <tbody></tbody>
                                            </table>
                                            <hr>
                                            <table class="table">
                                                <tbody>
                                                    <tr>
                                                        <th width="60%">Invoice Payable</th>
                                                        <td id="cheque_payable">0.00</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 text-center" style="padding: 15px;">
                                            <button id="process_pay" type="button" class="btn btn-success submit-and-update-button">Process &amp; Pay</button>
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
    <div class="modal fade in" id="download-invoice-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body" style="max-height: 400px;overflow: auto;">
                    <div class="row">
                        <div class="col-md-6 text-center">
                            <div class="h1-border-bottom">Print Invoice Summary</div>
                        </div>
                        <div class="col-md-6 text-center">
                            <div class="h1-border-bottom">Print Invoice Detail</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 text-center" style="border-right: 1px solid #c2cad8;">
                            <div>
                                <img src="../images/print.png">
                            </div>
                            <div>
                                <button data-type="summary" class="print_invoice invoiceId">Print</button> | <a target="_blank" href="../manage_cheque/invoice/summary/PDF/" class="print_summary invoiceId">PDF</a> | <a target="_blank" href="../manage_cheque/invoice/summary/Excel/" class="excel_invoice invoiceId">Excel</a>
                            </div>
                        </div>
                        <div class="col-md-6 text-center">
                            <div>
                                <img src="../images/print.png">
                            </div>
                            <div>
                                <button data-type="details" class="print_invoice invoiceId">Print</button> | <a target="_blank" href="../manage_cheque/invoice/detail/PDF/" class="print_summary invoiceId">PDF</a> | <a target="_blank" href="../manage_cheque/invoice/detail/Excel/" class="excel_invoice invoiceId">Excel</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div class="modal fade" id="deduction_model" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Deduction</h4>
                </div>
                <div class="modal-body form-horizontal" style="max-height: 400px;overflow: auto;">
                    <div class="form-group">
                        <label class="col-md-4 control-label">Deduction Amount</label>
                        <div class="col-md-8">
                            <input type="number" id="deductionValue" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label">Comments</label>
                        <div class="col-md-8">
                            <textarea id="deduction_comments" class="form-control" row="2"></textarea>
                        </div>
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

    <div class="modal fade" id="deficit_model" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Miscellaneous Payable</h4>
                </div>
                <div class="modal-body form-horizontal" style="max-height: 400px;overflow: auto;">
                    <div class="form-group">
                        <label class="col-md-4 control-label">Misc. Payable Amount</label>
                        <div class="col-md-8">
                            <input type="number" id="deficitValue" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label">Comments</label>
                        <div class="col-md-8">
                            <textarea id="deficit_comments" class="form-control" row="2"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="deficit_submit" class="btn yellow">Save</button>
                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Payment Process</h4>
                </div>
                <form id="payment-form" action="" novalidate="novalidate" data-parsley-validate class="form-horizontal form-label-left" method="post">
                    <div class="modal-body form-horizontal" style="max-height: 400px;overflow: auto;">

                        <div class="form-group">
                            <label class="col-md-4 control-label">Payment Mode<span class="danger">*</span></label>
                            <div class="col-md-8">
                                <select data-rule-required="true" data-msg-required="This is required" name="payment_method_id" id="payment_method_id" class="form-control select2" onchange="selectPaymentMode()">
                                    <option value="">- Select Payment Mode -</option>
                                </select>
                                <span class="error-container danger w-100"></span>
                            </div>
                        </div>

                        <div class="form-group" id="bank-control" style="display:none">
                            <label class="col-md-4 control-label">Banks List<span class="danger">*</span></label>
                            <div class="col-md-8">
                                <select data-rule-required="true" data-msg-required="This is required" name="bank_id" id="bank_id" class="form-control select2">
                                    <option value="">- Select Bank -</option>
                                </select>
                                <span class="error-container danger w-100"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Invoice Amount*</label>
                            <div class="col-md-8">
                                <input type="number" id="invoice_cheque_amount" name="invoice_cheque_amount" class="form-control" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Payee Name<span class="danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" id="invoice_cheque_holder_name" name="invoice_cheque_holder_name" class="form-control" value="" readonly>
                                <span class="error-container danger w-100"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Payment Refrence No.<span class="danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" id="invoice_cheque_no" name="invoice_cheque_no" class="form-control" data-rule-required="true" data-msg-required="This is required">
                                <span class="error-container danger w-100"></span>
                            </div>
                        </div>

                        <div class="form-group" id="cheque-date">
                            <label class="col-md-4 control-label">Payment Date<span class="danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" id="invoice_date" placeholder="dd/mm/yyyy" name="invoice_cheque_date" class="form-control" value="{{date('d-m-y')}}">
                                <span class="error-container danger w-100"></span>
                            </div>
                        </div>

                        <!-- <div class="form-group">
                            <label class="col-md-4 control-label">Invoice Comments</label>
                            <div class="col-md-8">
                                <textarea id="invoice_comments" class="form-control" row="3"></textarea>
                            </div>
                        </div> -->
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="merchant_id" id="merchant_id">
                        <input type="hidden" name="total_amount" id="total_amount" value="0">
                        <input type="hidden" name="total_charges" id="total_charges" value="0">
                        <input type="hidden" name="total_gst" id="total_gst" value="0">
                        <input type="hidden" name="total_return" id="total_return" value="0">
                        <input type="hidden" name="total_charges_discount" id="total_charges_discount" value="0">
                        <input type="hidden" name="total_sercharge" id="total_sercharge" value="0">
                        <input type="hidden" name="deduction_amount" id="deduction_amount" value="0">
                        <input type="hidden" name="deduction_comments" id="deduction_comments" value="0">
                        <input type="hidden" name="deficit_amount" id="deficit_amount" value="0">
                        <input type="hidden" name="deficit_comments" id="deficit_comments" value="0">
                        <input type="hidden" name="booking_ids" id="booking_ids">
                        <input type="hidden" name="assignment_ids" id="assignment_ids">
                        <input type="hidden" name="city_id" id="city_id">
                        <button type="submit" id="payment_submit" class="btn yellow">Save</button>
                        <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
    </div>
    <!-- /page content -->
@endSection

@section('scripts')
    <!-- <script src="<?php echo url_secure('vendors/validate/jquery.validate.min.js') ?>" type="text/javascript"></script> -->
    <!-- <script src="<?php echo url_secure('vendors/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js') ?>"></script> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>

        const token = getToken();
        const headers = {
            "Authorization": `Bearer ${token}`
        };

        flatpickr("#invoice_date", {
            dateFormat: "d/m/Y", // Desired format, e.g., "d/m/Y" for dd/mm/yyyy
            minDate: "today", // Set the minimum date to today
        });


        $(document).ready(function() {
            $('#myTable').DataTable({
                searching: false, // Disable searching
                ordering: true ,// Enable sorting,
                paging: false // Disable pagination
            });

            $('#readyForChequeTable').DataTable({
                searching: false, // Disable searching
                ordering: true ,// Enable sorting,
                paging: false // Disable pagination
            });


            $('#reservation').val('');

            $("#merchant_id").select2({
                placeholder: "Search By Client",
                minimumInputLength: 2, // Minimum characters before sending the AJAX request
                allowClear: true,
                ajax: {
                    url: "{{ api_url('clients_list') }}", // Replace with your actual server endpoint
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


        function loadAjax(EditData = []) {
            $.ajax({
                url: '<?php echo api_url('manage_location/city/data_list'); ?>',
                method: 'GET',
                dataType: 'json', // Set the expected data type to JSON
                headers: headers,
                beforeSend: function () {
                    $('.error-container').html('');
                },
                success: function (data) {
                    var option = "";
                    $.each(data.cities, function (index, value) {
                        option += `<option value="${value.id}">${value.city_name}</option>`
                    });
                    $('#city_id').append(option);
                },
                error: function (xhr, textStatus, errorThrown) {

                }
            });

            $.ajax({
                url: '<?php echo api_url('manage/shipment_type/get_services'); ?>',
                method: 'GET',
                dataType: 'json', // Set the expected data type to JSON
                headers: headers,
                beforeSend: function () {
                    $('.error-container').html('');
                },
                success: function (data) {
                    var option = "";
                    $.each(data.data, function (index, value) {
                        option += `<option value="${value.shipment_type_id}">${value.service_name}</option>`
                    });
                    $('#shipment_type_id').append(option);
                },
                error: function (xhr, textStatus, errorThrown) {

                }
            });
        }

        $("#select_form").validate({
            errorClass: "danger",
            errorPlacement: function (error, element) {
                error.addClass('w-100').appendTo(element.parent(0));
            },
            submitHandler: function (form, event) {
                event.preventDefault();

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to View Details!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ffca00',
                    cancelButtonColor: '#0e1827',
                    confirmButtonText: 'Submit'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var data = $('#select_form').serialize();
                        $('.search-results').hide();
                        $.ajax({
                            url: '<?php echo api_url('manage_cheque/packet/details'); ?>',
                            method: 'POST',
                            data: data,
                            dataType: 'json', // Set the expected data type to JSON
                            headers: headers,
                            beforeSend: function () {
                                $('.error-container').html('');
                                $('#myTable').DataTable().clear().draw();
                                $('#readyForChequeTable').DataTable().clear().draw();
                            },
                            success: function (data) {
                                if (data && data.status == 1) {
                                    $('.search-results').show();
                                    // Swal.fire({
                                    //     icon: 'success',
                                    //     text: 'Details has been populated successfully',
                                    //     showConfirmButton: true,
                                    //     confirmButtonColor: '#ffca00',
                                    // });

                                    populateClientDetails(data.data.clientInformation);
                                    $('#total_delivered').text(data.data.total_delivered);
                                    $('#total_packets').text(data.data.total_packets);
                                    $('#total_returned').text(data.data.total_returned);
                                    $('#total_under_process').text(data.data.total_under_process);

                                    if(data.data.invoiceHistory.length > 0){
                                        populateInvoiceHistoryDetails(data.data.invoiceHistory);
                                    }

                                    if(data.data.notPayablePackets.length > 0){
                                        populateNotPayableList(data.data.notPayablePackets);
                                    }

                                    if(data.data.payablePackets.length > 0){
                                        populatePayableList(data.data.payablePackets);
                                    }

                                    if(data.data.packing_materials.length > 0){
                                        populatePackingMaterials(data.data.packing_materials);
                                    }

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

        function populateDetails(data){
            var keys = Object.keys(data);
            var values = Object.values(data);

            $(keys).each(function (index, element) {
                if(element != 'merchant_id'){
                    $('#'+element).text(values[index]);

                    var client_id = document.getElementById('client_id');
                    if(element == 'id'){
                        client_id.setAttribute('data-client-id', values[index]);
                    }
                 }
            });
        }

        function populateClientDetails(data){
            populateDetails(data);
            $('.modal-footer #city_id').val(data.city_id);
            $('#invoice_cheque_holder_name').val(data.bank_ac_title);
        }

        function populateInvoiceHistoryDetails(data){

            var body = "";
            data.forEach(item => {
                const tr = `<tr>
                                <td>${item.invoice_cheque_no}</td>
                                <td>${item.invoice_cheque_amount}</td>
                                <td>${item.invoice_cheque_date}</td>
                                <td class="text-center"><a target="_blank" href="#download-invoice-modal" class="download-invoice" data-toggle="modal" data-invoice-id="${item.id}"><i class="fa fa-print"></i></a></td>
                            </tr>`;
                body += tr;
            });

            $('#invoice-history tbody').html(body);
        }

        function populateNotPayableList(data){

            $('#myTable').DataTable().clear().draw();

            var TotalBookedPacketWeight=0,Totalvpc=0,Totalfuelsurge=0,TotalGST=0,TotalCODAmount=0,TotalCharges=0;

            var key=1;
            data.forEach(item => {
                if(item.zone_name=='D'){
                    zone = 'Other Province';
                }
                else if(item.zone_name=='S'){
                    zone = 'Same Province';
                }
                else if(item.zone_name=='W'){
                    zone = 'Local';
                }
                else{
                    zone = 'Other Province';
                }

                fuelSurValue = (item.fuel_sercg_charges*item.packet_charges)/100;
                
                gstValue = (item.gst_per*(fuelSurValue+parseFloat(item.packet_charges)))/100;

                TotalBookedPacketWeight += item.arival_dispatch_weight/1000;
                Totalvpc += item.vendor_pickup_charges;
                Totalfuelsurge += fuelSurValue;
                TotalGST += gstValue;
                TotalCODAmount += parseFloat(item.booked_packet_collect_amount);
                TotalCharges += parseFloat(item.packet_charges);

                $('#myTable').DataTable().row.add([
                    key,
                    'Under Process',
                    item.booked_packet_cn,
                    item.merchant_account_no,
                    item.booked_packet_date,
                    item.city_name,
                    zone,
                    item.arival_dispatch_weight/1000,
                    item.vendor_pickup_charges,
                    0,
                    "("+item.gst_per+"%)<br>"+gstValue.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2 }),
                    "("+item.fuel_sercg_charges+"%)<br>"+fuelSurValue.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2 }),
                    item.booked_packet_collect_amount.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2 }),
                    item.packet_charges.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2 })
                ]).draw();
                key++;
            });

            $('#notpayable-weight').text(TotalBookedPacketWeight.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2 }));
            $('#notpayable-vpc').text(parseFloat(Totalvpc));
            $('#notpayable-fuel-surge').text(Totalfuelsurge.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2 }));
            $('#notpayable-gst').text(TotalGST.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2 }));
            $('#notpayable-cod').text(TotalCODAmount.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2 }));
            $('#notpayable-charges').text(TotalCharges.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2 }));
        }

        function populatePayableList(data){

            $('#readyForChequeTable').DataTable().clear().draw();

            var TotalBookedPacketWeight=0,Totalvpc=0,Totalfuelsurge=0,TotalGST=0,TotalCODAmount=0,TotalReturnCODAmount=0,TotalCharges=0;
            key=1;
            data.forEach(item => {

                if(item.zone_name=='D'){
                    zone = 'Other Province';
                }
                else if(item.zone_name=='S'){
                    zone = 'Same Province';
                }
                else if(item.zone_name=='W'){
                    zone = 'Local';
                }


                fuelSurValue = (item.fuel_sercg_charges*item.packet_charges)/100;
                gstValue = (item.gst_per*(fuelSurValue+parseFloat(item.packet_charges)))/100;

                TotalBookedPacketWeight += item.arival_dispatch_weight/1000;
                Totalvpc += item.vendor_pickup_charges;
                Totalfuelsurge += fuelSurValue;
                TotalGST += gstValue;
                TotalCODAmount += parseFloat(item.booked_packet_collect_amount);

                if(item.booked_packet_status==7){
                    TotalReturnCODAmount += parseFloat(item.booked_packet_collect_amount);
                }

                TotalCharges += parseFloat(item.packet_charges);

                $('#readyForChequeTable').DataTable().row.add([
                    "<input type='checkbox' class='checkbox-data' name='booking_id[]' value="+item.id+" data-cod-amount="+item.booked_packet_collect_amount+" data-charges="+item.packet_charges+" data-fuel-charges="+fuelSurValue+" data-gst-charges="+gstValue+" data-status-id="+item.booked_packet_status+">",
                    key+'-'+item.title,
                    item.booked_packet_cn,
                    item.merchant_account_no,
                    item.booked_packet_date,
                    item.city_name,
                    item.shipment_type_name,
                    zone,
                    item.arival_dispatch_weight/1000,
                    item.vendor_pickup_charges,
                    0,
                    "("+item.gst_per+"%)<br>"+gstValue.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2 }),
                    "("+item.fuel_sercg_charges+"%)<br>"+fuelSurValue.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2 }),
                    item.booked_packet_collect_amount.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2 }),
                    item.packet_charges.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2 })
                ]).draw();
                key++;
            });

            $(".checkbox-data").prop("checked", true); //Make Checkboxes Checked

            $('#payable-weight').text(TotalBookedPacketWeight.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2 }));
            $('#payable-vpc').text(parseFloat(Totalvpc));
            $('#payable-fuel-surge').text(Totalfuelsurge.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2 }));
            $('#payable-gst').text(TotalGST.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2 }));
            $('#payable-cod').text(TotalCODAmount.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2 }));
            $('#payable-charges').text(TotalCharges.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2 }));
            $('#total_charges').text(TotalCharges.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2 }));
            $('#merchant_discount').text(data[0].Discount);
            discount_value = (data[0].Discount/100)*TotalCharges;
            $('#discount-value').text("-"+discount_value.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2 }));
            freight_charges = TotalCharges - discount_value;
            $('#invoice').text(freight_charges.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2 }));
            $('#total_sercharge').text("+"+Totalfuelsurge.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2 }));
            net_amount = freight_charges+Totalfuelsurge;
            $('#net_amount').text(net_amount.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2 }));
            $('#total_gst').text("+"+TotalGST.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2 }));
            gross_charges = net_amount+TotalGST;
            $('#gross_invoice').text(gross_charges.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2 }));
            $('#total_amount').text(TotalCODAmount.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2 }));
            $('#total_return_amount').text("-"+TotalReturnCODAmount.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2 }));
            amount_payable = TotalCODAmount - TotalReturnCODAmount;
            $('#amount_payable').text(amount_payable.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2 }));
            $('#amount_payable_1').text(amount_payable.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2 }));
            $('#gross_invoice_1').text("-"+gross_charges.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2 }));
            total_payable = amount_payable - gross_charges;
            $('#total_payable').text(total_payable.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2 }));
            $('#cheque_payable').text(total_payable.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2 }));
            $('#invoice_cheque_amount').val(Math.ceil(total_payable));
            $('.modal-footer #merchant_id').val(data[0].merchant_id);
            $('.modal-footer #total_amount').val(TotalCODAmount);
            $('.modal-footer #total_charges').val(TotalCharges);
            $('.modal-footer #total_gst').val(TotalGST);
            $('.modal-footer #total_return').val(TotalReturnCODAmount);
            $('.modal-footer #total_charges_discount').val(discount_value);
            $('.modal-footer #total_sercharge').val(Totalfuelsurge);
        }

        var invoiceId;
        $('#download-invoice-modal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                invoiceId = button.data('invoice-id'); // Extract data from data-* attributes

                $(".invoiceId").each(function () {
                    // Get the current href attribute
                    var currentHref = $(this).attr("href");

                    // Append the common value to the href
                    var finalHref = currentHref + invoiceId;

                    // Set the updated href attribute
                    $(this).attr("href", finalHref);
                });
        });

        $('body').delegate('.print_invoice', 'click', function(e) {

            invoiceType = $(this).data('type'); // Extract data from data-* attributes
            if(invoiceType=='details'){
                var url = `<?php echo api_url('manage_cheque/invoice/detail/Print/') ?>` + invoiceId;
            }
            else{
                var url = `<?php echo api_url('manage_cheque/invoice/summary/Print/') ?>` + invoiceId;
            }


            Swal.fire({
                title: 'Are you sure To Print This Invoice?',
                text: "This Will Print The Slip",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Print'
            }).then((result) => {
                if (result.isConfirmed) {

                    let sw ;
                    $.ajax({
                        url: url,
                        method: 'GET',
                        headers : headers,
                        beforeSend : function(){
                            let timerInterval;
                            sw = Swal.fire({
                                title: '',
                                html: 'Please Wait',
                                timer:2000,
                                timerProgressBar: true,
                                didOpen: () => {
                                    Swal.showLoading()

                                },
                                willClose: () => {
                                    clearInterval(timerInterval)
                                }
                            })
                        },
                        success: function(data) {
                            $(data).printThis({
                                debug: false,               // show the iframe for debugging
                                importCSS: true,            // import parent page css
                                importStyle: true,          // import style tags
                                printContainer: true,       // print outer container/$.selector
                                loadCSS: "",                // path to additional css file - use an array [] for multiple
                                pageTitle: "",              // add title to print page
                                removeInline: false,        // remove inline styles from print elements
                                removeInlineSelector: "*",  // custom selectors to filter inline styles. removeInline must be true
                                printDelay: 1000,           // variable print delay
                                header: null,               // prefix to html
                                footer: null,               // postfix to html
                                base: false,                // preserve the BASE tag or accept a string for the URL
                                formValues: true,           // preserve input/form values
                                canvas: false,              // copy canvas content
                                doctypeString: '...',       // enter a different doctype for older markup
                                removeScripts: false,       // remove script tags from print content
                                copyTagClasses: true,       // copy classes from the html & body tag
                                copyTagStyles: true,        // copy styles from html & body tag (for CSS Variables)
                                beforePrintEvent: null,     // function for printEvent in iframe
                                beforePrint: null,          // function called before iframe is filled
                                afterPrint: null            // function called before iframe is removed
                            });
                        },
                        complete: function() {

                        },
                        error: function(xhr, textStatus, errorThrown) {
                            sw.close(); // Close the loading spinner
                            // Handle AJAX errors here
                            Swal.fire(
                                'Error!',
                                'Packet cancellation failed: ' + errorThrown,
                                'error'
                            );
                        }
                    });
                }
            });
        });

        $("#deduction_submit").click(function () {
            $('#deductionNew').text("-"+$('#deductionValue').val());
            $('.modal-footer #deduction_amount').val($('#deductionValue').val());
            $('.modal-footer #deduction_comments').val($('#deduction_comments').val());
            var stringWithoutComma = $('#cheque_payable').text().replace(/,/g, '');
            var floatValue = parseFloat(stringWithoutComma);
            totalChequeValue = floatValue - $('#deductionValue').val();
            $('#cheque_payable').text(totalChequeValue.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2 }));
            $('#invoice_cheque_amount').val(totalChequeValue);
            $("#deduction_model").modal("hide");
        });

        $("#deficit_submit").click(function () {
            $('#deficitNew').text("+"+$('#deficitValue').val());
            $('.modal-footer #deficit_amount').val($('#deficitValue').val());
            $('.modal-footer #deficit_comments').val($('#deficit_comments').val());

            var stringWithoutComma = $('#cheque_payable').text().replace(/,/g, '');
            var floatValue = parseFloat(stringWithoutComma);

            totalChequeValue = floatValue + parseFloat($('#deficitValue').val());
            $('#cheque_payable').text(totalChequeValue.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2 }));
            $('#invoice_cheque_amount').val(Math.ceil(totalChequeValue));
            $("#deficit_model").modal("hide");
        });

        $(document).ready(function () {
            $( "body" ).delegate( ".checkbox-data", "click", function() {

                let selectedCodAmountSum = 0;
                let selectedChargesSum = 0;
                let selectedFuelSum= 0;
                let selectedGSTSum=0;
                let selectedReturnCOdAmountSum= 0;

                $(".checkbox-data:checked").each(function () {
                    selectedCodAmountSum += parseFloat($(this).data("cod-amount"));
                    if($(this).data("status-id")==7){
                        selectedReturnCOdAmountSum += parseFloat($(this).data("cod-amount"));
                    }
                    selectedChargesSum += parseFloat($(this).data("charges"));
                    selectedFuelSum += parseFloat($(this).data("fuel-charges"));
                    selectedGSTSum += parseFloat($(this).data("gst-charges"));

                });
                computeSummaryCharges(selectedCodAmountSum,selectedReturnCOdAmountSum,selectedChargesSum,selectedFuelSum,selectedGSTSum);

            });
        });

        function computeSummaryCharges(TotalCODAmount,TotalReturnCODAmount,TotalCharges,Totalfuelsurge,TotalGST){

            $('#total_charges').text(TotalCharges.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2 }));
            var discount = $('#merchant_discount').text();
            discount_value = (discount/100)*TotalCharges;
            $('#discount-value').text("-"+discount_value.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2 }));
            freight_charges = TotalCharges - discount_value;
            $('#invoice').text(freight_charges.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2 }));
            $('#total_sercharge').text("+"+Totalfuelsurge.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2 }));
            net_amount = freight_charges+Totalfuelsurge;
            $('#net_amount').text(net_amount.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2 }));
            $('#total_gst').text("+"+TotalGST.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2 }));
            gross_charges = net_amount+TotalGST;
            $('#gross_invoice').text(gross_charges.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2 }));
            $('#total_amount').text(TotalCODAmount.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2 }));
            $('#total_return_amount').text("-"+TotalReturnCODAmount.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2 }));
            amount_payable = TotalCODAmount - TotalReturnCODAmount;
            $('#amount_payable').text(amount_payable.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2 }));
            $('#amount_payable_1').text(amount_payable.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2 }));
            $('#gross_invoice_1').text("-"+gross_charges.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2 }));
            total_payable = amount_payable - gross_charges;
            $('#total_payable').text(total_payable.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2 }));
            $('#cheque_payable').text(total_payable.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2 }));
            $('#invoice_cheque_amount').val(Math.ceil(total_payable));
            $('.modal-footer #total_amount').val(TotalCODAmount);
            $('.modal-footer #total_charges').val(TotalCharges);
            $('.modal-footer #total_gst').val(TotalGST);
            $('.modal-footer #total_return').val(TotalReturnCODAmount);
            $('.modal-footer #total_charges_discount').val(discount_value);
            $('.modal-footer #total_sercharge').val(Totalfuelsurge);
        }

        $("#process_pay").click(function () {

            var payable_charges = parseFloat($('#cheque_payable').text());
            if(payable_charges < 1){
                alert('Cheque Payable amount can not be zero or negative, Select more Booked Packets');
                return;
            }
            // Iterate through each checkbox with class "checkbox"
            var checkboxValues = [];
            $(".checkbox-data").each(function () {
                var checkbox = $(this);
                if (checkbox.is(":checked")) {
                    checkboxValues.push(checkbox.val());
                }
            });

            if(checkboxValues.length === 0){
                alert('Please select atleast 1 booking first');
                return;
            }

            $('#booking_ids').val(checkboxValues);
            loadBankList();
            getPaymentMethodList();

            $("#paymentModal").modal("show");
        });

        function viewTariff(){
            var customClientId = document.getElementById('client_id');
            var dataClientId = customClientId.getAttribute('data-client-id');
            var base64Encoded = btoa(dataClientId);
            window.location.href = '<?php echo url_secure('/manage_cheque/tariff?id=') ?>'+base64Encoded;
        }

        function loadBankList(){
            $.ajax({
                url: '<?php echo api_url('bank_list'); ?>',
                method: 'GET',
                dataType: 'json', // Set the expected data type to JSON
                headers: headers,
                beforeSend: function () {
                    $('.error-container').html('');
                },
                success: function (data) {
                    var option = "";
                    $.each(data, function(index, item) {
                            $('#bank_id').append($('<option>', {
                                value: item.id,
                                text: item.label
                            }));
                    });
                },
                error: function (xhr, textStatus, errorThrown) {

                }
            });
        }

        function getPaymentMethodList(){
            $.ajax({
                url: '<?php echo api_url('get_payment_method'); ?>',
                method: 'GET',
                data:{ ajax: true},
                headers: headers,
                dataType: 'json', // Set the expected data type to JSON
                beforeSend: function(){
                    $('.error-container').html('');
                },
                success: function(data) {
                    if (data) {
                        $.each(data.data, function(index, item) {
                            $('#payment_method_id').append($('<option>', {
                                value: item.id,
                                text: item.payment_method_name
                            }));
                        });

                    } else {
                        if(data && data.status == 0){
                            Swal.fire(
                                'Error!',
                                data.error,
                                'error'
                            );
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

        $("#payment-form").validate({
            errorClass: "danger",
            errorPlacement: function (error, element) {
                error.addClass('w-100').appendTo(element.parent(0));
            },
            submitHandler: function (form, event) {
                event.preventDefault();

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to Submit Cheque!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ffca00',
                    cancelButtonColor: '#0e1827',
                    confirmButtonText: 'Submit'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var data = $('#payment-form').serialize();
                        $.ajax({
                            url: '<?php echo api_url('manage_cheque/submit'); ?>',
                            method: 'POST',
                            data: data,
                            headers: headers,
                            dataType: 'json', // Set the expected data type to JSON
                            beforeSend: function () {
                                $('.error-container').html('');
                            },
                            success: function (data) {
                                if (data && data.status == 1) {
                                    $('.search-results').show();
                                    Swal.fire({
                                        icon: 'success',
                                        text: 'Invoice has been submitted successfully',
                                        showConfirmButton: true,
                                        confirmButtonColor: '#ffca00',
                                    });
                                    window.location.href = '<?php echo url_secure('/manage_cheque') ?>'
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


        // Handle the click event of the "select all" checkbox
        $(".selectAll").click(function () {
            // Get the state of the "select all" checkbox
            var isChecked = $(this).prop("checked");

            // Set the state of all checkboxes with class "checkbox" to match
            $(".checkbox-data").prop("checked", isChecked);
        });

        function getClientByCity(){
            $("#merchant_id").select2({
                placeholder: "Search By Client",
                minimumInputLength: 2, // Minimum characters before sending the AJAX request
                allowClear: true,
                ajax: {
                    url: "{{ api_url('clients_list') }}?city_id="+$('#city_id').val(), // Replace with your actual server endpoint
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

        function populatePackingMaterials(data){

            var body = "",total_material =0,material_assignment_ids=[];
            data.forEach(item => {
                const tr = `<tr>
                                <td>${item.material_name}(${item.material_quantity} Qty.)</td>
                                <td>-${item.material_value*item.material_quantity}</td>
                            </tr>`;

                body += tr;
                total_material += item.material_value*item.material_quantity;
                material_assignment_ids.push(item.id);
            });

            $('#packing-materials tbody').html(body);

            totalChequeValue = parseFloat($('#cheque_payable').text().replace(/,/g, '')) + total_material;
            $('#cheque_payable').text(totalChequeValue.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2 }));
            $('#invoice_cheque_amount').val(Math.ceil(totalChequeValue));
            $('#assignment_ids').val(material_assignment_ids);
        }

        function selectPaymentMode(){

            payment_method_id = $('#payment_method_id').val();

            if(payment_method_id == 4){
                $('#bank-control').hide();
                $('#invoice_cheque_no').val('CASHXXXXXXXXX');
                $('#invoice_cheque_no').attr('disabled',true);
            }
            else if(payment_method_id == 3){
                $('#bank-control').show();
                $('#invoice_cheque_no').attr('disabled',false);
                $('#invoice_cheque_no').val('');
            }
            else if(payment_method_id == 1 || payment_method_id == 2){

                    $('#bank-control').show();
                    $('#invoice_cheque_no').attr('disabled',true);
                    city_id = $('.modal-footer #city_id').val();
                    if(city_id==592){
                        $('#invoice_cheque_no').val('IBKIXXXXXXXXX');
                    }
                    else if(city_id==789){
                        $('#invoice_cheque_no').val('IBLEXXXXXXXXX');
                    }
                    else if(city_id==322){
                        $('#invoice_cheque_no').val('IBFSXXXXXXXXX');
                    }
                    else{
                        $('#invoice_cheque_no').val('IBOSXXXXXXXXX');
                    }
            }
        }

        function getShippersByClient(){
           $('#shipper_div').show();

           $("#shipper_id").select2({
            placeholder: "Search Shipper",
            minimumInputLength: 2,
            allowClear: true,
            ajax: {
                url: "{{ api_url('shippers_list') }}?merchant_id=" + $('#merchant_id').val(),
                dataType: "json",
                delay: 250,
                headers: headers,
                processResults: function (data) {
                    // Add "View All" as the default selection
                    var defaultSelection = {
                        id: '0',
                        text: 'View All'
                    };

                    // Combine the default selection with the fetched data
                    var results = [defaultSelection, ...data];

                    return {
                        results: results.map(function (item) {
                            return {
                                id: item.id,
                                text: item.label
                            };
                        })
                    };
                },
                cache: true
            }
            }).on('select2:select', function (e) {
                // Handle the selection of "View All"
                if (e.params.data.id === '0') {
                    // Your custom logic for handling "View All" selection
                    console.log('View All selected');
                }
            });

            // Set "View All" as the default selection
            var viewAllOption = new Option('View All', '0', true, true);
            $("#shipper_id").append(viewAllOption).trigger('change');
        }

    </script>
    <script src="{{ url_secure('build/js/main.js')}}"></script>
@endSection
