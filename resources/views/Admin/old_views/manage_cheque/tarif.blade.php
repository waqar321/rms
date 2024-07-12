@extends('Admin.layout.main')

@section('styles')
    <style>
        .portlet-title {
            padding: 2px 7px;
            background: #f3d758;
        }

        .portlet {
            border: 2px solid #ffcb05;
            border-radius: 5px;
            margin-bottom: 5px;
        }
        .h1-border-bottom {
            font-size: 18px;
            border-bottom: 1px solid;
            padding: 10px 0;
        }
        h2.form-section.no-margin.no-border {
            font-size: 15px;
            font-weight: bold;
        }
        .tariff-info h2 {
            font-size: 15px;
            font-weight: bold;
        }
    </style>
@endsection

@section('title') View Tariff @endsection

@section('content')
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>View Tariff</h2>
                            <ul class="nav navbar-right panel_toolbox justify-content-end">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label>Tariff Date<span class="danger">*</span></label>
                                    <select  class="form-control" name="traiff_date" id="traiff_date" onchange="viewTariff()">
                                        <option selected>Please Select</option>
                                    </select>
                                </div>
                            </div>

                            <div class="page-content all-trafic">
                                <div class="col-md-12">
                                    <div class="portlet yellow">
                                        <div class="portlet-title">
                                            <div class="tariff-info">
                                                <h2 class="">Tariff Info</h2>
                                            </div>
                                        </div>
                                        <div class="portlet-body form tariff_info">
                                            <div class="form-horizontal">
                                                <div class="row form-body">
                                                    <div class="col-md-12">
                                                        <label class="control-label col-md-4">Company Name: <strong id="merchant_name"></strong></label>
                                                        <label class="control-label col-md-4">Applicable Date: <strong id="applicable_date">01/02/2023</strong></label>
                                                        <label class="control-label col-md-4">Created By: <strong id="created_by">None</strong></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="portlet yellow">
                                        <div class="portlet-title">
                                            <div class="tariff-info">
                                                <h2>Shipment Charges</h2>
                                            </div>
                                        </div>
                                        <div class="portlet-body form">
                                            <div class="form-horizontal">
                                                <div class="row form-body">
                                                    <div class="col-md-12" id="tariff-shipment-charges">

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="portlet yellow">
                                        <div class="portlet-title">
                                            <div class="tariff-info">
                                                <h2>Special Tariff</h2>
                                            </div>
                                        </div>
                                        <div class="portlet-body form">
                                            <div class="form-horizontal">
                                                <div class="row form-body" id="special-tariff">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="portlet yellow">
                                        <div class="portlet-title">
                                            <div class="tariff-info"><h2>Packing Material Rate</h2>
                                            </div>
                                        </div>
                                        <div class="portlet-body  form">
                                            <div class="form-horizontal" id="packing-material-rate">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="portlet yellow">
                                        <div class="portlet-title">
                                            <div class="tariff-info">
                                                <h2>Vendor Pickup Charge</h2>
                                            </div>
                                        </div>
                                        <div class="portlet-body  form">
                                            <div class="form-horizontal ">
                                                <div class="row form-body">
                                                    <div class="col-md-12">
                                                        <div class="col-md-8">
                                                            <label>Vendor Pickup Charges (if not self)</label>
                                                        </div>
                                                        <div class="col-md-4" id="vendor_pickup_charges">
                                                            0.00
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="portlet yellow">
                                        <div class="portlet-title">
                                            <div class="tariff-info">
                                                <h2>Insurance Details</h2>
                                            </div>
                                        </div>
                                        <div class="portlet-body  form">
                                            <div class="form-horizontal ">
                                                <div class="row form-body">
                                                    <div class="col-md-12">
                                                        <div class="col-md-4">
                                                            <label class="trafic-text">Insurance Enable: <b id="insurance_enable">No</b> </label>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="trafic-text">Type: <b id="insurance_type">None</b></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row form-body">
                                                    <div class="col-md-12" id="insurance_detail">

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="portlet yellow">
                                        <div class="portlet-title">
                                            <div class="tariff-info">
                                                <h2>Cash Handling Charges</h2>
                                            </div>
                                        </div>
                                        <div class="portlet-body  form">
                                            <div class="form-horizontal ">
                                                <div class="row form-body">
                                                    <div class="col-md-12">
                                                        <div class="col-md-4">
                                                            <label class="trafic-text">Charges Type : </label>
                                                             <span id="charge-type"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row form-body">
                                                    <div class="col-md-12" id="cash_handling_charges">

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="portlet yellow">
                                        <div class="portlet-title">
                                            <div class="tariff-info">
                                                <h2>Billing Information</h2>
                                            </div>
                                        </div>
                                        <div class="portlet-body  form">
                                            <div class="form-horizontal ">
                                                <div class="row form-body">
                                                    <div class="col-md-12" id="billing_information">

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
            </div>
        </div>
    </div>
    <!-- /page content -->
@endSection

@section('scripts')
    <script>

        const token = getToken();
        const headers = {
            "Authorization": `Bearer ${token}`
        };

        const url = window.location.search;
        if (url) {
            const urlParams = new URLSearchParams(url);
            const id = atob(urlParams.get('id'));
            // $.ajax({
            //     url: '<?php echo api_url('manage_cheque/tariff'); ?>',
            //     method: 'GET',
            //     data: {ajax: true, id: id},
            //     dataType: 'json', // Set the expected data type to JSON
            //     beforeSend: function () {
            //         $('.error-container').html('');
            //     },
            //     success: function (data) {
            //         if (data && data.status == 1) {
            //             document.getElementById('merchant_name').innerHTML = data.data.clientInfo[0].CLNT_NAME;
            //             // document.getElementById('gst').innerHTML = data.data.clientInfo[0].GST;
            //             // document.getElementById('discount').innerHTML = data.data.clientInfo[0].Discount;
            //             // document.getElementById('fuel_sercg').innerHTML = data.data.clientInfo[0].CLNT_NAME;
            //             // document.getElementById('petrol').innerHTML = data.data.clientInfo[0].CLNT_NAME;
            //             // document.getElementById('diesel').innerHTML = data.data.clientInfo[0].CLNT_NAME;
            //             // document.getElementById('jet').innerHTML = data.data.clientInfo[0].CLNT_NAME;
            //             shipmentCharges(data.data.lssRefRateMatrixCorporate);
            //             packingMaterialRate(data.data.packingMaterialRate);
            //             cashHandlingCharges(data.data.cashHandlingCharges);
            //             billingInformation(data.data.billingInformation, data.data.clientInfo);
            //         } else {
            //             Swal.fire(
            //                 'Error!',
            //                 'Something Went Wrong',
            //                 'error'
            //             );
            //         }
            //     },
            //     error: function (xhr, textStatus, errorThrown) {
            //         // Handle AJAX errors here
            //         Swal.fire(
            //             'Error!',
            //             'Form submission failed: ' + errorThrown,
            //             'error'
            //         );
            //     }
            // });

            $.ajax({
                url: '<?php echo api_url('manage_client/tariff/dates'); ?>',
                method: 'GET',
                data: {ajax: true, id: id},
                headers:headers,
                dataType: 'json', // Set the expected data type to JSON
                beforeSend: function () {
                    $('.error-container').html('');
                },
                success: function (data) {
                    var option = "";
                    $.each(data.data, function (index, value) {
                        option += `<option value="${value.Id +' '+ value.EffectiveFrom}">${value.EffectiveFrom}</option>`;
                    });
                    $('#traiff_date').append(option);
                    // Select the last option by default
                    $('#traiff_date').val(data.data[0].Id +' '+ data.data[0].EffectiveFrom);
                    viewTariff();
                },
                error: function (xhr, textStatus, errorThrown) {

                }
            });
        }

        function viewTariff(){

            const urlParams = new URLSearchParams(url);
            const id = atob(urlParams.get('id'));
            date = $('#traiff_date').val();
            var applicableDateSplit = date.split(' ');

            $.ajax({
                url: '<?php echo api_url('manage_cheque/tariff'); ?>',
                method: 'GET',
                data: {ajax: true, id: id, tariff:date},
                headers: headers,
                dataType: 'json', // Set the expected data type to JSON
                beforeSend: function () {
                    $('.error-container').html('');
                },
                success: function (data) {
                    if (data && data.status == 1) {
                        document.getElementById('merchant_name').innerHTML = data.data.clientInfo[0].CLNT_NAME;
                        document.getElementById('applicable_date').innerHTML = applicableDateSplit[1];
                        document.getElementById('vendor_pickup_charges').innerHTML = data.data.clientInfo[0].vendor_pickup_charges;
                        if(data.data.insurance_details.length > 0){
                            insuranceDetails(data.data.insurance_details);
                        }

                        shipmentCharges(data.data.lssRefRateMatrixCorporate);
                        specialTariff(data.data.groupedSpcialTeriffRate);
                        packingMaterialRate(data.data.packingMaterialRate);
                        if(data.data.cashHandlingCharges.length > 0){
                            cashHandlingCharges(data.data.cashHandlingCharges);
                        }
                        billingInformation(data.data.billingInformation, data.data.clientInfo);
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

        function shipmentCharges(data) {
            $('#tariff-shipment-charges').empty();
            var shipmentChargesDiv = document.getElementById("tariff-shipment-charges");
            var shipmentChargesContent = '';
            var count_service = data;
            var col_md = parseInt(12/count_service.length);

            Object.keys(data).forEach(function (index) {
                var lssRefRateMatrixCorporate = data[index];
                var shipmentChargesContent = `<div class="col-md-${col_md}"><div class="h1-border-bottom">` + lssRefRateMatrixCorporate.service + `</div>`;
                Object.keys(lssRefRateMatrixCorporate.zones).forEach(function (index2) {
                    var ratingZone = lssRefRateMatrixCorporate.zones[index2];
                    var zoneName = '';
                    if(ratingZone === 'D'){
                        zoneName = 'Different Zone';
                    }
                    if(ratingZone === 'S'){
                        zoneName = 'Same Zone';
                    }
                    if(ratingZone === 'W'){
                        zoneName = 'Local';
                    }

                    var zoneContent = `<h2 class="form-section no-margin no-border">` + zoneName + `</h2>
                                                        <div>
                                                        <table class="table table-striped table-bordered table-hover">
                                                            <thead>
                                                            <tr class="text-center">
                                                                <th width="20%">From Weight</th>
                                                                <th width="20%">To Weight</th>
                                                                <th width="20%">Del. Rate</th>
                                                                <th width="20%">Return. Rate</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody class="text-center">`;
                    shipmentChargesContent += zoneContent;
                    var addWeight,addCharges,totalreturnvalue;
                    Object.keys(lssRefRateMatrixCorporate.weightRate).forEach(function (index3,weight_rates) {
                        var shipmentChargesData = lssRefRateMatrixCorporate.weightRate[index3];

                            if(shipmentChargesData.rating_zone == ratingZone){
                                var tableListData = `<tr>
                                                <td>` + shipmentChargesData.from_weight + `</td>
                                                <td>` + shipmentChargesData.to_weight + `</td>
                                                <td>` + shipmentChargesData.tarrif_rate + `</td>
                                                <td>` + shipmentChargesData.return_rate + `</td>
                                            </tr>`;
                                shipmentChargesContent += tableListData;

                                addWeight = shipmentChargesData.add_weight;
                                addCharges = shipmentChargesData.add_charges;

                                totalReturnValue = shipmentChargesData.return_rate/shipmentChargesData.tarrif_rate;
                                if(Number.isInteger(totalReturnValue)) {
                                    additionalReturncharges = addCharges*totalReturnValue;
                                }
                                else{
                                    totalReturnValue = shipmentChargesData.return_rate-shipmentChargesData.tarrif_rate;
                                    additionalReturncharges = addCharges+totalReturnValue;
                                    if(totalReturnValue < 0){
                                        totalReturnValue = shipmentChargesData.return_rate/shipmentChargesData.tarrif_rate;
                                        additionalReturncharges = addCharges*totalReturnValue;
                                    }
                                }

                            }


                    });
                    var addRow = `<tr><td>Each Additional Weight</td><td>`+addWeight+`</td><td>`+addCharges+`</td><td>`+additionalReturncharges+`</td></tr>`;
                    var endBody = `</tbody></table></div>`;
                    shipmentChargesContent += addRow+endBody;
                });
                var endDiv = `</div>`;
                shipmentChargesContent += endDiv;
                shipmentChargesDiv.innerHTML += shipmentChargesContent;
            });


        }
      
        function specialTariff(data) {
            var groupedRows = {};
            $('#special-tariff').empty();
            
            var shipmentChargesDiv = document.getElementById("special-tariff");
            var spacialteriffContent="";
            var spacialteriffContent2="";
            Object.keys(data).forEach(function (ratingZone) {
                
                //start

                var groupedRows2 = {};

                var groupedRows = {};
                var key = data[ratingZone].origin_city + '-' + data[ratingZone].destination_city + '-' + data[ratingZone].shipment_type_name;

                if (!groupedRows2[key]) {
                     groupedRows2[key] = key;
                     var keysArray = Object.keys(groupedRows2);
                }
                
              

            if (jQuery.inArray(key, keysArray) !== -1) {
        
                if (!groupedRows[key]) {

                    groupedRows[key] = { 'key': key, 'header': '', 'values': '' };
                }

                groupedRows[key]['header'] = `
                            <table>
                                <thead>
                                    <tr class="text-center">
                                        <th width="20%">Shipment Type</th>
                                        <th width="20%">Origin</th>
                                        <th width="20%">Destination</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    <tr>
                                        <td>${data[ratingZone].shipment_type_name}</td>
                                        <td>${data[ratingZone].origin_city}</td>
                                        <td>${data[ratingZone].destination_city}</td>
                                    </tr>
                                </tbody>
                            </table>

                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr class="text-center">
                                        <th width="20%">From Weight</th>
                                        <th width="20%">To Weight</th>
                                        <th width="20%">Del. Rate</th>
                                        <th width="20%">Return. Rate</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                        `;


                    totalReturnValue = data[ratingZone].return_rate / data[ratingZone].tarrif_rate;

                    if (Number.isInteger(totalReturnValue)) {
                        additionalReturncharges = data[ratingZone].add_charges * totalReturnValue;
                    } else {
                        totalReturnValue = data[ratingZone].return_rate - data[ratingZone].tarrif_rate;
                        additionalReturncharges = data[ratingZone].add_charges + totalReturnValue;
                    }

                    var zonerow2 = `
                        <tr>
                            <td>${data[ratingZone].from_weight}</td>
                            <td>${data[ratingZone].to_weight}</td>
                            <td>${data[ratingZone].tarrif_rate}</td>
                            <td>${data[ratingZone].return_rate}</td>
                        </tr>`;
                    groupedRows[key]['values'] += zonerow2;

                    var zoneFooter2 = `
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td>Each Additional Weight</td>
                                    <td>${data[ratingZone].add_weight}</td>
                                    <td>${data[ratingZone].add_charges}</td>
                                    <td>${additionalReturncharges}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>`;
                    groupedRows[key]['values'] += zoneFooter2;
                               
                     } else {
                       


            
                        totalReturnValue = data[ratingZone].return_rate / data[ratingZone].tarrif_rate;

                        if (Number.isInteger(totalReturnValue)) {
                            additionalReturncharges = data[ratingZone].add_charges * totalReturnValue;
                        } else {
                            totalReturnValue = data[ratingZone].return_rate - data[ratingZone].tarrif_rate;
                            additionalReturncharges = data[ratingZone].add_charges + totalReturnValue;
                        }

                        var zonerow2 = `
                            <tr>
                                <td>${data[ratingZone].from_weight}</td>
                                <td>${data[ratingZone].to_weight}</td>
                                <td>${data[ratingZone].tarrif_rate}</td>
                                <td>${data[ratingZone].return_rate}</td>
                            </tr>`;
                        groupedRows[key]['values'] += zonerow2;

                        var zoneFooter2 = `
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td>Each Additional Weight</td>
                                        <td>${data[ratingZone].add_weight}</td>
                                        <td>${data[ratingZone].add_charges}</td>
                                        <td>${additionalReturncharges}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>`;
                        groupedRows[key]['values'] += zoneFooter2;

                        
                      


                    }
               

                        console.log(groupedRows2);
                                var specialtariffHeader = `<div class="col-md-4">    
                                <table class="table table-striped table-bordered table-hover">
                                            <thead>
                                                <tr class="text-center">
                                                    <th width="20%">Shipment Type</th>
                                                    <th width="20%">Origin</th>
                                                    <th width="20%">Destination</th>
                                                </tr>
                                            </thead>
                                            <tbody class="text-center">
                                            <tr>
                                                    <td>${data[ratingZone].shipment_type_name}</td>    
                                                    <td>${data[ratingZone].origin_city}</td>
                                                    <td>${data[ratingZone].destination_city}</td>
                                                </tr>
                                            </tbody>
                                            
                                        </table>
                                    
                                        <table class="table table-striped table-bordered table-hover">
                                            <thead>
                                                <tr class="text-center">
                                                    <th width="20%">From Weight</th>
                                                    <th width="20%">To Weight</th>
                                                    <th width="20%">Del. Rate</th>
                                                    <th width="20%">Return. Rate</th>
                                                </tr>
                                            </thead>
                                            <tbody class="text-center">`;
                                            spacialteriffContent += specialtariffHeader;
                            /* data[ratingZone].forEach(function (ratingRow){*/

                                    totalReturnValue = data[ratingZone].return_rate / data[ratingZone].tarrif_rate;

                                    if(Number.isInteger(totalReturnValue)) {
                                        additionalReturncharges = data[ratingZone].add_charges*totalReturnValue;
                                    }
                                    else{
                                        totalReturnValue = data[ratingZone].return_rate-data[ratingZone].tarrif_rate;
                                        additionalReturncharges = data[ratingZone].add_charges+totalReturnValue;
                                    }


                                    var zonerow = `
                                                
                                                <tr>
                                                    <td>${data[ratingZone].from_weight}</td>
                                                    <td>${data[ratingZone].to_weight}</td>
                                                    <td>${data[ratingZone].tarrif_rate}</td>
                                                    <td>${data[ratingZone].return_rate}</td>
                                                </tr>`;
                                    spacialteriffContent += zonerow;           
                                /*});
                                    */
                                var zoneFooter = `</tbody>
                                            <tfoot> 
                                                <tr>
                                                    <td>Each Additional Weight</td>
                                                    <td>${data[ratingZone].add_weight}</td>
                                                    <td>${data[ratingZone].add_charges}</td>
                                                    <td>${additionalReturncharges}</td>
                                                </tr>
                                            </tfoot>
                                            
                                        </table>
                                    
                                            
                                        
                                    </div>`;
                                    spacialteriffContent += zoneFooter;
                                    shipmentChargesDiv.innerHTML = spacialteriffContent;
                            });

        }

        function packingMaterialRate(item){
            var packingMaterialRateDiv = document.getElementById("packing-material-rate");
            var packingMaterialRateContent = `<table class="table table-striped table-bordered table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th width="20%">Material Name</th>
                                                                <th width="20%">Material Value</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="text-center">`;
            Object.keys(item).forEach(function (index) {
                var packingItem = item[index];
                var packingMaterialRateContent1 = `<tr><td>`+packingItem.material_name+`</td><td>`+packingItem.material_value+`</td></tr>`;
                packingMaterialRateContent += packingMaterialRateContent1;
            });
            packingMaterialRateContent2 = `</tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <td class="trafic-text-box-text"></td>
                                                                <td class="trafic-text-box-text"></td>
                                                            </tr>
                                                        </tfoot>
                                                    </table>`;
            packingMaterialRateContent += packingMaterialRateContent2;
            packingMaterialRateDiv.innerHTML = packingMaterialRateContent;
        }

        function cashHandlingCharges(cashHandling){
            cashHandlingChargeContent2="";
            $('#charge-type').text(cashHandling[0].rate_type);
            var cashHandlingDiv = document.getElementById("cash_handling_charges");
            var cashHandlingContent = `<table class="table table-striped table-bordered table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th width="20%">From Amount</th>
                                                                <th width="20%">To Amount</th>
                                                                <th width="20%">Amount</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="text-center">`;
            Object.keys(cashHandling).forEach(function (index) {

                var cashHandlingCharge = cashHandling[index];
                var cashHandlingChargeContent1 = `<tr>
                                                        <td>`+cashHandlingCharge.from_amount+`</td>
                                                        <td>`+cashHandlingCharge.to_amount+`</td>
                                                        <td>`+cashHandlingCharge.rate+`</td>
                                                    </tr>`;
                cashHandlingContent += cashHandlingChargeContent1;
                above_type = `<tfoot><tr><td>Above</td><td>`+cashHandlingCharge.above_charges_type+`</td><td>`+cashHandlingCharge.above_charges_rate+`</td></tr></tfoot>`;
            });
            cashHandlingChargeContent2 += `</tbody>`+above_type+`</table>`;
            cashHandlingContent += cashHandlingChargeContent2;
            cashHandlingDiv.innerHTML = cashHandlingContent;
        }

        function insuranceDetails(insuranceDetails){
            var insurance = 'N/A';
            if(insuranceDetails[0].insurance_enable == 1){
                insurance = 'Yes';
            }else{
                insurance = 'No';
            }
            $('#insurance_enable').text(insurance);
            $('#insurance_type').text(insuranceDetails[0].insurance_type);
            var insuranceDetailDiv = document.getElementById("insurance_detail");
            var insuranceDetailContent = `<table class="table table-striped table-bordered table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th width="20%">From Amount</th>
                                                                <th width="20%">To Amount</th>
                                                                <th width="20%">Amount</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="text-center">`;
            Object.keys(insuranceDetails).forEach(function (index) {
                var insuranceDetailCharges = insuranceDetails[index];
                var insuranceDetailChargesContent1 = `<tr>
                                                        <td>`+insuranceDetailCharges.from_amount+`</td>
                                                        <td>`+insuranceDetailCharges.to_amount+`</td>
                                                        <td>`+insuranceDetailCharges.rate+`</td>
                                                    </tr>`;
                insuranceDetailContent += insuranceDetailChargesContent1;
            });
            insuranceDetailChargesContent2 = `</tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <td class="trafic-text-box-text"></td>
                                                                <td class="trafic-text-box-text"></td>
                                                                <td class="trafic-text-box-text"></td>
                                                            </tr>
                                                        </tfoot>
                                                    </table>`;
            insuranceDetailContent += insuranceDetailChargesContent2;
            insuranceDetailDiv.innerHTML = insuranceDetailContent;
        }

        function billingInformation(billing, clientInfo){
            var billingInformationDiv = document.getElementById("billing_information");
            var billingInformationContent = `<div class="col-md-4">
                                                            <label>G.S.T (%)</label>: <span id="gst">`+clientInfo[0].GST+`</span>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label>Discount (%)</label>: <span id="discount">`+clientInfo[0].Discount+`</span>
                                                        </div>`;
            Object.keys(billing).forEach(function (index) {
                var billingInfo = billing[index];
                var billingInfoContent1 = `<div class="col-md-4">
                                                        <label>`+billingInfo.desc+` (%)</label>: <span>`+billingInfo.fuelprice+`</span>
                                                    </div>`;
                billingInformationContent += billingInfoContent1;
            });

            billingInformationDiv.innerHTML = billingInformationContent;
        }

        $(document).ready(function() {

        });
    </script>
    <script src="{{ url_secure('build/js/main.js')}}"></script>
@endSection
