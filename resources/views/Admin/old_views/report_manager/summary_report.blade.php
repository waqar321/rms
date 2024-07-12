@extends('Admin.layout.main')

@section('styles')

    <style>
        #summary-report-data {
            overflow-x: scroll;
        }
    </style>

@endsection

@section('title') Summary Report @endsection

@section('content')
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Report Manager</h3>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2> Summary Report </h2>
                            <ul class="nav navbar-right panel_toolbox justify-content-end">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                            <hr>
                            <form id="generate" action="" novalidate="novalidate" data-parsley-validate
                                  class="form-horizontal form-label-left" method="post">
                                <div class="row">
                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                        <div class="form-group">
                                            <label>Date</label>
                                            <div class="input-prepend input-group">
                                                <span class="add-on input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </span>
                                                <input type="text" name="reservation" id="reservation"
                                                       class="form-control">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Client Regions</label>
                                            <select id="client_region" name="client_region"
                                                    class="form-control select2">
                                                <option selected value="">Choose option</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                        <label>Search By Client City</label>
                                        <select class="form-control select2" name="city_id" id="city_id" onchange="search()">
                                            <option value="">View All</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                        <div class="form-group">
                                            <label>Client</label>
                                            <select class="form-control select2" name="merchant_id[]" id="merchant_id"  multiple="multiple">
                                                <option value="">Please Select Client</option>
                                            </select>
                                            <span class="error-container danger w-100"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                        <div class="form-group">
                                            <label>Origin City</label>
                                            <select class="form-control select2" name="origin_city" id="origin_city">
                                                <option value="">Origin City</option>
                                            </select>
                                            <span class="error-container danger w-100"></span>
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                        <div class="form-group">
                                            <label>Destination City</label>
                                            <select class="form-control select2" name="dest_city" id="dest_city">
                                                <option value="">Destination City</option>
                                            </select>
                                            <span class="error-container danger w-100"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-xs-12" style="padding-top: 20px">
                                        <button type="submit" class="btn btn-primary btn-sm">Generate</button>
                                    </div>
                                </div>
                            </form>
                            <!-- Add this button in your HTML -->
                            <button onclick="exportToExcel()" class="btn btn-primary btn-sm">Export to Excel</button>

                        </div>
                        <div class="x_content">
                            {{--                            <form method="POST" enctype="multipart/form-data" action="#" id="export-csv">--}}
                            {{--                                <div class="col-md-4 col-sm-4 col-xs-12">--}}
                            {{--                                    <label>Export To Excel</label>--}}
                            {{--                                    <select name="export[]" multiple id="export">--}}
                            {{--                                    </select>--}}
                            {{--                                </div>--}}
                            {{--                                <div class="col-md-4 col-sm-4 col-xs-12" style="padding-top: 20px">--}}
                            {{--                                    <button type="submit" class="btn btn-primary btn-sm">Export</button>--}}
                            {{--                                </div>--}}
                            {{--                            </form>--}}
                            {{--                            <hr>--}}
                            <div class="col-md-12" id="summary-report-data">


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
        const token = getToken();
        const headers = {
            "Authorization": `Bearer ${token}`,
        };

        $("#generate").validate({
            errorClass: "danger",
            errorPlacement: function (error, element) {
                error.addClass('w-100').appendTo(element.parent(0));
            },
            submitHandler: function (form, event) {
                event.preventDefault();
                let timerInterval;
                Swal.fire({
                    title: 'Auto close when data is generated!',
                    timerProgressBar: true,
                    didOpen: () => {
                        Swal.showLoading()
                        const b = Swal.getHtmlContainer().querySelector('b')
                    },
                    willClose: () => {
                        clearInterval(timerInterval)
                    }
                });
                var data = $('#generate').serialize();
                $.ajax({
                    url: '<?php echo api_url('report_manager/summaryReport/generate'); ?>',
                    method: 'POST',
                    data: data,
                    headers: headers,
                    dataType: 'json', // Set the expected data type to JSON
                    beforeSend: function () {
                        $('.error-container').html('');
                    },
                    success: function (data) {
                        if (data && data.status == 1) {
                            summaryReportData(data.data, data.grandTotal);
                            Swal.fire(
                                'Saved!',
                                'Form has been submitted successfully',
                                'success'
                            );
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
        });

        jQuery(function ($) {
            //form submit handler
            $('#export-csv').submit(function (e) {
                //check atleat 1 checkbox is checked
                if (!$('#export').val()) {
                    //prevent the default form submit if it is not checked
                    alert('Please checked at least one checkbox for export to csv');
                    e.preventDefault();
                } else {

                    var selectedValue = $('#export').val();
                    var selectedTexts = $('#export option:selected').map(function () {
                        return $(this).text()
                    }).get();

                    $.ajax({
                        url: '<?php  echo api_url('report_manager/cancel_shipments/downloadCsv')  ?>', // Replace with your backend URL
                        type: 'GET',
                        data: {
                            selectedValue: selectedValue,
                            selectedTexts: selectedTexts,
                            excel: true,
                            ajax: 1,
                        },
                        headers: headers,
                        success: function (response) {
                            // Create a blob from the response
                            var blob = new Blob([response], {type: 'text/csv'});

                            // Create a temporary URL for the blob
                            var url = window.URL.createObjectURL(blob);

                            // Create a hidden anchor link and set its attributes
                            var a = document.createElement('a');
                            a.href = url;
                            a.download = 'data_' + new Date().toISOString().slice(0, 10) + '.csv';

                            // Append the anchor link to the document
                            document.body.appendChild(a);

                            // Programmatically click the anchor link to trigger the download
                            a.click();

                            // Remove the temporary URL and the anchor link
                            window.URL.revokeObjectURL(url);
                            a.remove();
                        },
                        beforeSend: function () {
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
                        complete: function () {
                            sw.close();
                        },
                        error: function (error) {
                        }
                    });
                    e.preventDefault();
                }
            })
        })

        function search() {
            table.draw();
        }

        $(document).ready(function () {

            $('#summaryDatatable').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'excelHtml5'
                ]
            });

            $("#merchant_id").select2({
                placeholder: "Search Client",
                // minimumInputLength: 2, // Minimum characters before sending the AJAX request
                allowClear: false,
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

            $("#origin_city").select2({
                placeholder: "Search Origin City",
                // minimumInputLength: 2, // Minimum characters before sending the AJAX request
                allowClear: true,
                ajax: {
                    url: "{{ api_url('rights/city') }}", // Replace with your actual server endpoint
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
            $("#dest_city").select2({
                placeholder: "Search Destination City",
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

            $("#client_region").select2({
                placeholder: "Select Region",
                // minimumInputLength: 2, // Minimum characters before sending the AJAX request
                allowClear: true,
                ajax: {
                    url: "{{ api_url('get_regions') }}", // Replace with your actual server endpoint
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
                placeholder: "Select Region",
                // minimumInputLength: 2, // Minimum characters before sending the AJAX request
                allowClear: true,
                ajax: {
                    url: "{{ api_url('get_client_wise_cities') }}", // Replace with your actual server endpoint
                    dataType: "json",
                    delay: 250, // Delay before sending the request in milliseconds
                    data: function (params) {
                        return {
                            term: params.term,
                            region:  $('#client_region').val(),
                        };
                    },
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

        function summaryReportData(data, grand) {

            var summaryReportBody = document.getElementById("summary-report-data");
            var summaryDataTable1 = `<h3>Summary Report</h3>
    <table class="table table-striped table-bordered" id="summaryDatatable">
<thead>
                                    <tr>
                                        <th>SR#</th>
                                        <th>Client</th>
                                        <th colspan="3" class="text-center">Delivered</th>
                                        <th colspan="3" class="text-center">Being Return</th>
                                        <th colspan="3" class="text-center">Return To Shipper</th>
                                        <th colspan="3" class="text-center">Under Process</th>
                                        <th colspan="3" class="text-center">Total</th>
                                    </tr>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th>Packets</th>
                                        <th>Cod Amount</th>
                                        <th>Inv Charges</th>
                                        <th>Packets</th>
                                        <th>Cod Amount</th>
                                        <th>Inv Charges</th>
                                        <th>Packets</th>
                                        <th>Cod Amount</th>
                                        <th>Inv Charges</th>
                                        <th>Packets</th>
                                        <th>Cod Amount</th>
                                        <th>Inv Charges</th>
                                        <th>Packets</th>
                                        <th>Cod Amount</th>
                                        <th>Inv Charges</th>
                                    </tr>
                                </thead>
            <tbody>`;

            var leoData = makeTd(data);
            var summaryDataTable2 = leoData;
            summaryDataTable1 += summaryDataTable2;
            var summaryDataTable2 = `<tr>
            <th colspan="2">Grand Total</th>
            <th>` + grand.grand_total.delivered_pack + `</th>
            <th>` + grand.grand_total.delivered_cod + `</th>
            <th>` + grand.grand_total.delivered_inv + `</th>
            <th>` + grand.grand_total.b_return_pack + `</th>
            <th>` + grand.grand_total.b_return_cod + `</th>
            <th>` + grand.grand_total.b_return_inv + `</th>
            <th>` + grand.grand_total.return_pack + `</th>
            <th>` + grand.grand_total.return_cod + `</th>
            <th>` + grand.grand_total.return_inv + `</th>
            <th>` + grand.grand_total.process_pack + `</th>
            <th>` + grand.grand_total.process_cod + `</th>
            <th>` + grand.grand_total.process_inv + `</th>
            <th>` + grand.grand_total.total_packs + `</th>
            <th>` + grand.grand_total.total_grand_amount + `</th>
            <th>` + grand.grand_total.total_grand_charges + `</th>
            </tr></tbody></table>`;
            summaryDataTable1 += summaryDataTable2;
            summaryReportBody.innerHTML = summaryDataTable1;
        }

        function makeTd(data) {
            var data_key = Object.keys(data);
            deliveredLength = 0;
            underProcessLength = 0;
            returnToShipperLength = 0;
            beingReturnDataLength = 0;
            totalDataLength = 0;

            var makeTdData = '';
            for (var i = 0; i < data_key.length; i++) {
                var m_key = data_key[i];
                var deliveredData = (data[m_key] && data[m_key]['delivered']) ? data[m_key]['delivered'] : {};
                deliveredLength = Object.keys(deliveredData).length;

                var underProcessData = (data[m_key] && data[m_key]['under_process']) ? data[m_key]['under_process'] : {};
                underProcessLength = Object.keys(underProcessData).length;

                var returnToShipper = (data[m_key] && data[m_key]['return_to_shipper']) ? data[m_key]['return_to_shipper'] : {};
                returnToShipperLength = Object.keys(returnToShipper).length;

                var beingReturnData = (data[m_key] && data[m_key]['being_return']) ? data[m_key]['being_return'] : {};
                beingReturnDataLength = Object.keys(beingReturnData).length;

                var totalData = (data[m_key] && data[m_key]['total']) ? data[m_key]['total'] : {};
                totalDataLength = Object.keys(totalData).length;

                var da_keys = Object.keys(deliveredData);
                var ud_keys = Object.keys(underProcessData);
                var ry_keys = Object.keys(returnToShipper);
                var br_keys = Object.keys(beingReturnData);
                var td_keys = Object.keys(totalData);

                var tdData = `<tr>
                    <td>` + i + `</td>
                    <td>` + data[m_key]['merchant_name'] + `</td>
                    <td>` + (deliveredData.total_packet ? deliveredData.total_packet : 0) + `</td>
                    <td>` + (deliveredData.total_amount ? deliveredData.total_amount : 0) + `</td>
                    <td>` + (deliveredData.total_charges ? deliveredData.total_charges : 0) + `</td>
                    <td>` + (beingReturnData.total_packet ? beingReturnData.total_packet : 0) + `</td>
                    <td>` + (beingReturnData.total_amount ? beingReturnData.total_amount : 0) + `</td>
                    <td>` + (beingReturnData.total_charges ? beingReturnData.total_charges : 0) + `</td>
                    <td>` + (returnToShipper.total_packet ? returnToShipper.total_packet : 0) + `</td>
                    <td>` + (returnToShipper.total_amount ? returnToShipper.total_amount : 0) + `</td>
                    <td>` + (returnToShipper.total_charges ? returnToShipper.total_charges : 0) + `</td>
                    <td>` + (underProcessData.total_packet ? underProcessData.total_packet : 0) + `</td>
                    <td>` + (underProcessData.total_amount ? underProcessData.total_amount : 0) + `</td>
                    <td>` + (underProcessData.total_charges ? underProcessData.total_charges : 0) + `</td>
                    <td>` + (totalData.total_packet ? totalData.total_packet : 0) + `</td>
                    <td>` + (totalData.total_amount ? totalData.total_amount : 0) + `</td>
                    <td>` + (totalData.total_charges ? totalData.total_charges : 0) + `</td>
                </tr>`;
                makeTdData += tdData;
            }
            return makeTdData;

            // console.log(tdData);


            // Object.keys(deliveredData).forEach(function (key) {
            //     var deli = deliveredData[key];
            //
            // });
            // return `<tr>
            //          <td>` + (data.total_packet || 0) + `</td>
            //          <td>` + (data.total_amount || 0) + `</td>
            //          <td>` + (data.total_charges || 0) + `</td>
            //      </tr>`;
        }
    </script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.5/xlsx.full.min.js"></script>
<script>
    // Add this function to your existing JavaScript code
    function exportToExcel() {
        var wb = XLSX.utils.book_new();
        var ws = XLSX.utils.table_to_sheet(document.getElementById('summaryDatatable'));
        XLSX.utils.book_append_sheet(wb, ws, 'SummaryReport');
        XLSX.writeFile(wb, 'SummaryReport.xlsx');
    }

</script>
    <script src="{{ url_secure('build/js/main.js')}}"></script>
@endsection

