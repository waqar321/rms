@extends('Admin.layout.main')

@section('styles')

    <style>
        #summary-report-data {
            overflow-x: scroll;
        }
    </style>

@endsection

@section('title') City Wise Packets Report @endsection

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
                            <h2> City Wise Packets Report </h2>
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
                                        <div class="form-group">
                                            <label>Client</label>
                                            <select class="form-control select2" name="merchant_id" id="merchant_id">
                                                <option value="">Please Select Client</option>
                                            </select>
                                            <span class="error-container danger w-100"></span>
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                        <div class="form-group">
                                            <label>Client City</label>
                                            <select class="form-control select2" name="client_city" id="client_city">
                                                <option value="">Client City</option>
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
                            <div class="col-md-12" id="summary-report-data"></div>
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
                    url: '<?php echo api_url('report_manager/city_wise_packet_counts/generate'); ?>',
                    method: 'POST',
                    data: data,
                    headers: headers,
                    dataType: 'json', // Set the expected data type to JSON
                    beforeSend: function () {
                        $('.error-container').html('');
                    },
                    success: function (data) {
                        
                        if(data && data.status == 1) {
                            summaryReportData(data.data);
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

            $("#client_city").select2({
                placeholder: "Search Client City",
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
        });

        function summaryReportData(data) {
            var summaryReportBody = document.getElementById("summary-report-data");
            var summaryDataTable1 = `<h3>City Wise Packets Report</h3>
            <table class="table table-striped table-bordered" id="summaryDatatable">
                                <thead>
                                    <tr>
                                        <th>SR#</th>
                                        <th>City</th>
                                        <th colspan="3" class="text-center">Total</th>
                                        <th colspan="3" class="text-center">Payment Made To Client</th>
                                        <th colspan="3" class="text-center">Payment Received in Bank but not Paid to Client</th>
                                        <th colspan="3" class="text-center">Payment not Received but Delivered</th>
                                        <th colspan="3" class="text-center">Packets Return Marked</th>
                                        <th colspan="3" class="text-center">Under Process</th>
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
                                        <th>Packets</th>
                                        <th>Cod Amount</th>
                                        <th>Inv Charges</th>
                                    </tr>
                                </thead>
            <tbody>`;

            var summaryDataTable2 = makeTd(data);
            summaryDataTable2 +=`</tbody></table>`;
            summaryDataTable1+= summaryDataTable2;
            summaryReportBody.innerHTML = summaryDataTable1;
        }

        function makeTd(data) {
            var makeTdData = '';
            for (var i = 0; i < data.length; i++) {
                var tdData = `<tr>
                    <td>` + i + `</td>
                    <td>` + data[i].city_name + `</td>
                    <td>` + data[i].packets + `</td>
                    <td>` + data[i].cod_amount + `</td>
                    <td>` + data[i].net_charges + `</td>
                    <td>` + data[i].paid_packets + `</td>
                    <td>` + data[i].paid_cod_amount + `</td>
                    <td>` + data[i].paid_net_charges + `</td>
                    <td>` + data[i].not_paid_packets + `</td>
                    <td>` + data[i].not_paid_cod_amount + `</td>
                    <td>` + data[i].not_paid_net_charges + `</td>
                    <td>` + data[i].delivered_packets + `</td>
                    <td>` + data[i].delivered_amount + `</td>
                    <td>` + data[i].delivered_charges + `</td>
                    <td>` + data[i].returned_packets + `</td>
                    <td>` + data[i].returned_amount + `</td>
                    <td>` + data[i].returned_charges + `</td>
                    <td>` + data[i].processing_packets + `</td>
                    <td>` + data[i].processing_amount + `</td>
                    <td>` + data[i].processing_charges + `</td>
                </tr>`;
                makeTdData += tdData;
            }
            return makeTdData;
        }
    </script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.5/xlsx.full.min.js"></script>
<script>
    // Add this function to your existing JavaScript code
    function exportToExcel() {
        var wb = XLSX.utils.book_new();
        var ws = XLSX.utils.table_to_sheet(document.getElementById('summaryDatatable'));
        XLSX.utils.book_append_sheet(wb, ws, 'SummaryReport');
        XLSX.writeFile(wb, 'CiyWisePacketsReport.xlsx');
    }

</script>
    <script src="{{ url_secure('build/js/main.js')}}"></script>
@endsection

