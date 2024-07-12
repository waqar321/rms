@extends('Admin.layout.main')
@section('title') Shipper Advice Log Report @endsection
@section('styles')
@endsection

@section('content')

    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Shipper Advice Log Report</h3>
                </div>
            </div>
            <div class="clearfix"></div>

            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2> Listing</h2>
                            <ul class="nav navbar-right panel_toolbox justify-content-end">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12">

                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <label>Search Consignment</label>
                                    <input type="text" id="search" name="search" required="required"
                                           class="form-control" placeholder="KL123456789" onchange="search()">
                                </div>

                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <label>Date</label>
                                    <div class="input-prepend input-group">
                                    <span class="add-on input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                        <input type="text" name="reservation" id="reservation" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <label>Client</label>
                                    <select class="form-control select2" name="client" id="client" onchange="search()">
                                        <option value="">Please Select Client</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">

                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <label>Destination City</label>
                                    <select class="form-control select2" name="dest_city" id="dest_city"
                                            onchange="search()">
                                        <option value="">Destination City</option>
                                    </select>
                                </div>


                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <label>Advice Status</label>
                                    <select class="form-control select2" name="advice_status" id="advice_status" onchange="search()">
                                        <option value="">All</option>
                                        <option value="RA">Re-Attempt</option>
                                        <option value="RT">RT-Return</option>
                                    </select>
                                </div>

                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <label>OMS Status</label>
                                    <select class="form-control select2" name="oms_status" id="oms_status" onchange="search()">
                                        <option value="">All</option>
                                        <option value="NR">NR-Ready For Return</option>
                                        <option value="CB">CB-Issued To Leopard At</option>
                                        <option value="RC">RC-Shipment Picked At Origin</option>
                                        <option value="DP">DP-Shipment Dispatched From</option>
                                        <option value="AR">AR-Arrived In</option>
                                        <option value="AC">AC-Assigned To Leopards In</option>
                                        <option value="PN">PN-Pending In</option>
                                        <option value="IT">IT-Inter Transfer At</option>
                                        <option value="DV">DV-Delivered At</option>
                                        <option value="DS">DS-Returned To Shipper At</option>
                                        <option value="DW">DW-Return To Warehouse</option>
                                        <option value="DR">DR-Return To Vendor</option>
                                        <option value="RF">RF-Re-forwarded To</option>
                                        <option value="DL">DL - Deleted</option>
                                    </select>
                                </div>


                            </div>
                        </div>


                        <div class="clearfix"></div>

                        <div class="x_content">
                            <form method="POST" enctype="multipart/form-data" action="#" id="export-csv" class="col-md-6 text-left mt-4">
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                    <label>Export To Excel</label>
                                    <select name="export[]" multiple id="export">
                                    </select>
                                </div>
                                <div class="col-md-2 col-sm-2 col-xs-12" style="padding-top: 20px">
                                    <button type="submit" class="btn btn-primary btn-sm">Export</button>
                                </div>
                            </form>
{{--                            <div class="col-md-3 col-sm-3"></div>--}}
{{--                            <div class="col-md-3 col-sm-3 col-xs-3 mt-4">--}}
{{--                                <label>Over All Records</label>--}}
{{--                                <select class="form-control" onchange="search()" name="record" id="record" style="height: 33px;">--}}
{{--                                    <option value="None">None</option>--}}
{{--                                    <option value="1-5000">5000</option>--}}
{{--                                    <option value="5001-10000">10000</option>--}}
{{--                                    <option value="10001-15000">15000</option>--}}
{{--                                    <option value="15001-20000">20000</option>--}}
{{--                                    <option value="20001-25000">25000</option>--}}
{{--                                    <option value="25001-30000">30000</option>--}}
{{--                                    <option value="30001-35000">35000</option>--}}
{{--                                    <option value="35001-40000">40000</option>--}}
{{--                                    <option value="40001-45000">45000</option>--}}
{{--                                    <option value="45001-50000">50000</option>--}}
{{--                                </select>--}}
{{--                            </div>--}}
                            <hr>
                            <table id="datatable" class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>Sr #</th>
                                    <th>Sys ID</th>
                                    <th>CN #</th>
                                    <th>Order ID</th>
                                    <th>Booking Date</th>
{{--                                    <th>Cour Date</th>--}}
                                    <th>Origin</th>
                                    <th>Destination</th>
                                    <th>Shipper</th>
                                    <th>Shipper Phone</th>
                                    <th>Consignee Name</th>
                                    <th>Consignee Phone</th>
                                    <th>Consignee Address</th>
                                    <th>Pending Reason</th>
                                    <th>Created Date</th>
                                    <th>Shipper Remarks</th>
                                    <th>Advice Status</th>
                                    <th>Advice Date</th>
                                    <th>OMS Current Status</th>
                                    <th>Remarks</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <script src="{{ url_secure('build/js/main.js')}}"></script>
    <script>
        const token = getToken();
        const headers = {
            "Authorization": `Bearer ${token}`,
        };
        var selected_rows = [];
        var table = $('#datatable').DataTable({
            dom: '<"search-box"f>l  <"" <"float-right" B> ><"datatable-wrapper"rt><"datatable-info"i><"datatable-pagination"p>',
            scrollX: true,
            search: {
                return: true
            },
            buttons: [
                {
                    text: '<i class="la la-cogs"></i> Bulk Advice',
                    className: 'btn btn-primary btn-sm add mr-1',
                    action: function (e, dt, node, config) {
                        window.location = '<?php echo url_secure('manage_booking/shipper_advice/import') ?>';
                    }
                },
            ],
            select: {
                info: false,
                style: 'multi',
                selector: 'td.select-checkbox',
                className: 'selected bg-primary bg-lighten-5 primary'
            },
            lengthMenu: [[50, 100, 500, 1000, 5000, 10000, -1], [50, 100, 500, 1000, 5000, 10000, 'All']],
            pageLength: 50,
            pagingType: 'full_numbers',
            processing: true,
            language: {
                processing: '<img  src="{{ url_secure('build/images/transpatent_leopard.gif') }}" alt="Loading..."> Loading Data...',
            },
            serverSide: true,
            ajax: {
                url: '<?php echo api_url('manage_booking/shipper_advice/log/report') ?>',
                data: function (d) {
                    d.ajax = 1;
                    d.client = $('#client').val();
                    d.destination_city_id = $('#dest_city').val();
                    d.cn_number = $('#search').val();
                    d.date = $('#reservation').val();
                    d.AdviceStatus = $('#advice_status').val();
                    d.OMSStatus = $('#oms_status').val();
                    d.record = $('#record').val();
                },
                headers: headers,
            },
            rowId: 'id',
            order: [[5, 'desc']],
            columns: [
                { data: 'serial_number', orderable: false, searchable: false, name: 'serial_number', class: 'align-middle serial_number', targets: 1, render: function (data, type, row) { return ''; }, download: false },
                { data: 'id', name: 'id', class: 'align-middle id', text: 'Sys ID#', download: true },
                { data: 'cn_number', name: 'cn_number', class: 'align-middle cn_number', text: 'CN #', download: true },
                { data: 'order_id', name: 'order_id', class: 'align-middle order_id', text: 'Order Id', download: true },
                { data: 'Booking_Date', name: 'Booking_Date', class: 'align-middle Booking_Date', text: 'Booking Date', download: true },
                // { data: 'cour_date', name: 'cour_date', class: 'align-middle cour_date', text: 'Courier Date', download: true },
                { data: 'origin_name', name: 'origin_name', class: 'align-middle origin_name', text: 'Origin', download: true },
                { data: 'dst_name', name: 'dst_name', class: 'align-middle dst_name', text: 'Destination', download: true },
                { data: 'shipper_name', name: 'shipper_name', class: 'align-middle shipper_name', text: 'Shipper', download: true },
                { data: 'shipper_mobile', name: 'shipper_mobile', class: 'align-middle shipper_mobile', text: 'Shipper Phone', download: true },
                { data: 'consignee_name', name: 'consignee_name', class: 'align-middle consignee_name', text: 'Consignee Name', download: true },
                { data: 'consignee_mobile', name: 'consignee_mobile', class: 'align-middle consignee_mobile', text: 'Consignee Phone', download: true },
                { data: 'consignee_address', name: 'consignee_address', class: 'align-middle consignee_address', text: 'Consignee Address', download: true },
                { data: 'reason', name: 'reason', class: 'align-middle reason', text: 'Pending Reason', download: true },
                { data: 'created_date', name: 'created_date', class: 'align-middle created_date', text: 'Date Created', download: true },
                { data: 'shipper_remarks', name: 'shipper_remarks', class: 'align-middle shipper_remarks', text: 'Shipper Remarks', download: true },
                { data: 'shipper_advice_status', name: 'shipper_advice_status', class: 'align-middle shipper_advice_status', text: 'Shipper Advice Status', download: true },
                { data: 'activity', name: 'activity', class: 'align-middle activity', text: 'Advice Date', download: true },
                { data: 'oms_status', name: 'oms_status', class: 'align-middle oms_status', text: 'OMS Current Status', download: true },
                { data: 'remarks', name: 'remarks', class: 'align-middle remarks', text: 'Remarks', download: true },
            ],
            //	Sr #	Sys ID#	Page Order	Page Name	Pages Body	Date Created	Actions
            rowCallback: function (row, data, index) {
                var info = table.page.info();

                $('td:eq(0)', row).html(index + 1 + info.page * info.length);

                if ($.inArray(data.id, selected_rows) !== -1) {
                    table.row(row).select();
                }
            },
            initComplete: function () {
                var search = $('<tr role="row" class="bg-lighten-1 search"></tr>').appendTo(this.api().table().header());

                var td = '<td style="padding:5px;" class="border-lighten-2"><fieldset class="form-group m-0 position-relative has-icon-right"></fieldset></td>';
                var input = '<input type="text" class="form-control form-control-sm input-sm mb-0">';
                var icon = '<div class="form-control-position primary"><i class="la la-search"></i></div>';
                var drop_select = '<select name="status_select" id="status_select" class="select2 form-control"></select>';
                var rider_status_select = '<select name="rider_status_select" id="rider_status_select" class="select2 form-control"></select>';
                this.api().columns().every(function (column_id) {
                    var column = this;
                    var header = column.header();

                    if ($(header).is('.action') || $(header).is('.serial_number') || $(header).is('.select')) {
                        $(td).appendTo($(search));
                    } else if ($(header).is('.pickup_status')) {
                        $(drop_select).appendTo($(search))
                            .on('change', function () {
                                column.search($(this).val(), false, false, true).draw();
                            }).wrap(td);
                    } else if ($(header).is('.rider_status')) {
                        $(rider_status_select).appendTo($(search))
                            .on('change', function () {
                                column.search($(this).val(), false, false, true).draw();
                            }).wrap(td);
                    } else {
                        var current = $(input).appendTo($(search)).on('change keyup', function () {
                            column.search($(this).val(), false, false, true).draw();
                        }).wrap(td).after(icon);

                        if (column.search()) {
                            current.val(column.search());
                        }
                    }
                });

                this.api().table().columns.adjust();
            }

        });

        table.on('processing.dt', function (e, settings, processing) {
            if (processing) {
                $('#datatable tbody').hide();
            } else {
                $('#datatable tbody').show();
            }
        });

        let option = '';
        var columnNames2 = table.settings().init().columns.map(function (column) {
            if (column.download) {
                let col_name = column.name;
                let col_text = column.text;
                if (col_name && col_text) {
                    option += `<option value="${col_name}">${col_text}</option>`;
                }
            }
        });


        // let columnNames = table.columns().header().toArray().map(function (header) {
        //     let col = $(header).text();
        //     if(col.length > 0) {
        //         option += `<option value="${col}">${col}</option>`;
        //     }
        // });

        $('#export').append(option).multiselect({
            columns: 1,
            placeholder: 'Export Options',
            search: true,
            selectAll: true
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
                        url: '<?php  echo api_url('manage_booking/shipper_advice/log/report/downloadCsv')  ?>', // Replace with your backend URL
                        type: 'GET',
                        data: {
                            selectedValue: selectedValue,
                            selectedTexts: selectedTexts,
                            excel: true,
                            ajax: 1,
                            client: $('#client').val(),
                            destination_city_id: $('#dest_city').val(),
                            cn_number: $('#search').val(),
                            date: $('#reservation').val(),
                            AdviceStatus: $('#advice_status').val(),
                            OMSStatus: $('#oms_status').val(),
                            record: $('#record').val(),
                            length: document.querySelector('select[name="datatable_length"]').value,
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
                        complete: function() {
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

        $("body").delegate(".applyBtn", "click", function () {
            table.draw();
        })

        {{--function openRequestDetail(id){--}}
        {{--    alert(id)--}}
        {{--    $.ajax({--}}
        {{--        url: '<?php echo api_url('manage_client/merchant/request/detail'); ?>',--}}
        {{--        method: 'GET',--}}
        {{--        dataType: 'json', // Set the expected data type to JSON--}}
        {{--        data: {id: id},--}}
        {{--        beforeSend: function(){--}}
        {{--            $('.error-container').html('');--}}
        {{--        },--}}
        {{--        success: function(data) {--}}
        {{--            $("#merchant-request-detail").modal();--}}

        {{--            document.getElementById('branch').innerHTML = (data.result.merchant_branch) ? data.result.merchant_branch : 'N/A';--}}
        {{--            document.getElementById('address').innerHTML = (data.result.merchant_address1) ? data.result.merchant_address1 : 'N/A';--}}
        {{--            document.getElementById('phone').innerHTML = (data.result.merchant_mobile) ? data.result.merchant_mobile : 'N/A';--}}
        {{--            document.getElementById('email').innerHTML = (data.result.merchant_email) ? data.result.merchant_email : 'N/A';--}}
        {{--            document.getElementById('contact_person_name').innerHTML = (data.result.merchant_representative_name) ? data.result.merchant_representative_name : 'N/A';--}}
        {{--            document.getElementById('designation').innerHTML = (data.result.merchant_representative_des) ? data.result.merchant_representative_des : 'N/A';--}}
        {{--            document.getElementById('mobile').innerHTML = (data.result.merchant_mobile) ? data.result.merchant_mobile : 'N/A';--}}
        {{--            document.getElementById('phone').innerHTML = (data.result.merchant_phone) ? data.result.merchant_phone : 'N/A';--}}
        {{--            document.getElementById('city').innerHTML = (data.result.city_name) ? data.result.city_name : 'N/A';--}}
        {{--            document.getElementById('country').innerHTML = (data.result.country_name) ? data.result.country_name : 'N/A';--}}
        {{--            // $(data).each(function( index ) {--}}
        {{--            //     tr = "<tr><td><input type='checkbox' class='checkbox' checked='true' name='checked_bookings[]' value="+data[index].id+"></td>";--}}
        {{--            //     booking_date = "<td>"+data[index].booked_packet_date+"</td>";--}}
        {{--            //     cn = "<td>"+data[index].booked_packet_cn+"</td>";--}}
        {{--            //     booked_packet_order_id = "<td>"+data[index].booked_packet_order_id+"</td>";--}}
        {{--            //     origin_city = "<td>"+data[index].origin_city+"</td>";--}}
        {{--            //     destination_city = "<td>"+data[index].destination_city+"</td>";--}}
        {{--            //     shipment_name_eng = "<td>"+data[index].shipment_name_eng+"</td>";--}}
        {{--            //     consignment_name_eng = "<td>"+data[index].consignment_name_eng+"</td>";--}}
        {{--            //     booked_packet_collect_amount = "<td>"+data[index].booked_packet_collect_amount+"</td>";--}}
        {{--            //     trclose = "</tr>";--}}
        {{--            //     body += tr+booking_date+cn+booked_packet_order_id+origin_city+destination_city+shipment_name_eng+consignment_name_eng+booked_packet_collect_amount+trclose;--}}
        {{--            // });--}}
        {{--            //--}}
        {{--            // $('#body').html(body);--}}
        {{--        },--}}
        {{--        error: function(xhr, textStatus, errorThrown) {--}}
        {{--            // Handle AJAX errors here--}}
        {{--        }--}}
        {{--    });--}}
        {{--}--}}

        $(document).ready(function () {
            // $("#reservation").val('');

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

            {{--$.ajax({--}}
            {{--    url: '<?php echo api_url('getShipperRecord'); ?>',--}}
            {{--    method: 'GET',--}}
            {{--    dataType: 'json', // Set the expected data type to JSON--}}
            {{--    headers: headers,--}}
            {{--    success: function(data) {--}}
            {{--        console.log(data)--}}
            {{--        var BatchDataOPtion = '';--}}
            {{--        $.each(data, function(index, value) {--}}
            {{--            BatchDataOPtion += `<option value="${value}">${value}</option>`;--}}
            {{--        });--}}
            {{--        $('#record').append(BatchDataOPtion);--}}
            {{--    },--}}
            {{--    error: function(xhr, textStatus, errorThrown) {--}}
            {{--        // Handle AJAX errors here--}}
            {{--        Swal.fire(--}}
            {{--            'Error!',--}}
            {{--            'Form submission failed: ' + errorThrown,--}}
            {{--            'error'--}}
            {{--        );--}}
            {{--    }--}}
            {{--});--}}

        });

        // client dropdown
        $(document).ready(function () {
            $("#client").select2({
                placeholder: "Search Client",
                minimumInputLength: 2, // Minimum characters before sending the AJAX request
                allowClear: true,
                ajax: {
                    url: "{{ api_url('merchant_list') }}", // Replace with your actual server endpoint
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

            {{--$.ajax({--}}
            {{--    url: '<?php echo api_url('getShipperRecord'); ?>',--}}
            {{--    method: 'GET',--}}
            {{--    dataType: 'json', // Set the expected data type to JSON--}}
            {{--    headers: headers,--}}
            {{--    success: function(data) {--}}
            {{--        console.log(data)--}}
            {{--        var BatchDataOPtion = '';--}}
            {{--        $.each(data, function(index, value) {--}}
            {{--            BatchDataOPtion += `<option value="${value}">${value}</option>`;--}}
            {{--        });--}}
            {{--        $('#record').append(BatchDataOPtion);--}}
            {{--    },--}}
            {{--    error: function(xhr, textStatus, errorThrown) {--}}
            {{--        // Handle AJAX errors here--}}
            {{--        Swal.fire(--}}
            {{--            'Error!',--}}
            {{--            'Form submission failed: ' + errorThrown,--}}
            {{--            'error'--}}
            {{--        );--}}
            {{--    }--}}
            {{--});--}}
        });

    </script>

@endsection
