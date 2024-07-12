@extends('Admin.layout.main')
@section('title') Booking List @endsection
@section('styles')
    <style>
        .center {
            text-align: center;
        }

        .float-right {
            float: right;
            padding: 10px;
        }

        .animated {
            min-width: 100px;
        }

        /*.dt-buttons.btn-group a {*/
        /*    margin: 0px 5px !important;*/
        /*}*/
        button.cancel-button {
            border-color: transparent;
            background: transparent;
            padding: 1px 10px;
        }

        button.cancel-button:hover {
            color: #262626;
            text-decoration: none;
            background-color: #f5f5f5;
        }

        .modal-content {
            width: 100%;
        }

        .modal-body {
            height: 400px;
            overflow: auto;
        }

        .danger {
            color: #FF4961 !important;
        }

        .modal-lg {
            width: 900px;
        }

        .modal-lg, .modal-xl {
            max-width: 1050px;
        !important;
        }

        .date-note {
            font-weight: 600;
        }

        .smart-search-bar {
            margin-right: 180px !important;
            background: none;
            padding-left: 50px;
            padding-right: 50px;
            border: none;
            pointer-events: none;
            color: black;
            padding-bottom: 0px;
            font-weight: 800;
            font-size: large;
        }
    </style>
@endsection
@section('content')
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Booked Packets</h3>
                </div>

            </div>
            <div class="clearfix"></div>

            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Listing</h2>
                            <ul class="nav navbar-right panel_toolbox justify-content-end">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                            <hr class="mt-2">
                            <div class="row">
                                <div class="col-md-12">
{{--                                    <input id="recordsTotal" value="0" type="hidden">--}}
                                    <h6 class="date-note"><b>Note: </b>Please select date range in order to see complete
                                        booked packet listing. By default it shows 15 days booking.</h6>
                                    <hr>
                                </div>
                                <div class="col-md-4 ">
                                    <label>Date</label>
                                    <div class="input-prepend input-group">
                                        <span class="add-on input-group-addon"><i class="fa fa-calendar"></i></span>
                                        <input type="text" name="reservation" id="reservation" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <label>Status</label>
                                    <select id="status" class="form-control select2" onchange="search()">
                                        <option selected value="">Please Select Packet Status</option>
                                    </select>
                                </div>

                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <label>Search By CN / Short CN / Order Id</label>
                                    <input id="booked_packet_cn" name="booked_packet_cn" class="form-control">
                                </div>

                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <label>Search By Consignee Phone / Consignee Email</label>
                                    <input id="consignee_phone" name="consignee_phone" class="form-control">
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <div class="form-group">
                                        <label>Client Regions</label>
                                        <select id="client_region" name="client_region" class="form-control select2" onchange="search()" >
                                            <option selected value="">Choose option</option>
                                        </select>
                                    </div>
                                </div>

                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <label>Origin City</label>
                                    <select id="origin" name="origin_city_id" style="width: 100%;" onchange="search()">
                                        <option value="" disabled selected>Select an option</option>
                                    </select>
                                </div>

                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <label>Destination City</label>
                                    <select id="destination" name="destination_city_id" style="width: 100%;"
                                            onchange="search()">
                                        <option value="" disabled selected>Select an option</option>
                                    </select>
                                </div>

                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <label>Shippers (Clients)</label>
                                    <select id="shipper_id" name="shipper_id" class="form-control select2"
                                            onchange="search()">
                                        <option selected value="">Choose option</option>
                                    </select>
                                </div>



                            </div>
                        </div>
                        <div class="x_content">
                            <form method="POST" enctype="multipart/form-data" action="#" id="export-csv" data-screen-permission-id="118">
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <label>Export To Excel</label>
                                    <select name="export[]" multiple id="export">
                                    </select>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-12" style="padding-top: 20px">
                                    <button type="submit" class="btn btn-primary btn-sm">Export</button>
                                </div>
                            </form>
                            <hr>
                            <table id="datatable" class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>Sr#</th>
                                    <th>Status</th>
                                    <th>OrderID</th>
                                    <th>Shipment Type</th>
                                    <th>CN#</th>
                                    <th>From</th>
                                    <th>To</th>
                                    <th>Shipper</th>
                                    <th>Consignee</th>
                                    <th>Phone1</th>
                                    <th>Booking Date</th>
                                    <th>Amount (PKR)</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="LoadSheetModal" class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog"
         aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myModalLabel">Generate LoadSheet</h4>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>From</label>
                                <input type="date" class="form-control" id="from" name="from">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>To</label>
                                <input type="date" class="form-control" id="to" name="to">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Shippers (Clients)</label>
                                <select id="shipper" name="shipper" class="form-control select2" style="width: 100%;">
                                    <option selected value="">Choose option</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <br>
                                <button type="button" onclick="loadSheetDetail()" class="btn btn-primary btn-sm">
                                    Search
                                </button>
                            </div>
                        </div>
                    </div>

                    <form id="process-loadsheet" action="" novalidate="novalidate" data-parsley-validate
                          class="form-horizontal form-label-left" method="post">
                        <div class="row">
                            <div class="form-group">
                                <div class="col-sm-6">
                                    <label>Courier Name</label>
                                    <input type="text" class="form-control" id="courier_name" name="courier_name"
                                           data-rule-required="true" data-msg-required="Courier Name is required">
                                </div>
                                <div class="col-sm-6">
                                    <label>Courier Code</label>
                                    <input type="text" class="form-control" id="courier_code" name="courier_code"
                                           data-rule-required="true" data-msg-required="Courier Code is required">
                                </div>
                            </div>
                        </div>


                        <table id="loadsheet_table" class="table table-striped table-bordered">

                            <thead>
                            <tr>
                                <th><input id="selectAllCheckbox" type="checkbox" checked='true'></th>
                                <th>Date</th>
                                <th>CN #</th>
                                <th>Status</th>
                                <th>Order ID</th>
                                <th>From</th>
                                <th>To</th>
                                <th>Merchant Name</th>
                                <th>Shipper Name</th>
                                <th>Consignee Name</th>
                                <th>COD Amount</th>
                            </tr>
                            </thead>

                            <tbody></tbody>
                        </table>
                        <div class="form-group">
                            <div class="col-sm-9">
                                <input type="submit" class="btn btn-secondary btn-sm btn-primary add" name="loadsheet"
                                       value="Process LoadSheet">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default antoclose" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade bd-example-modal-lg" id="packet_history" tabindex="-1" role="dialog" aria-labelledby="log" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <p class="modal-title" id="exampleModalLabel">Booked Packet Activity Log</p>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="log-body" style="height:auto">

                    </div>
                </div>
            </div>
    </div>

    <div class="modal fade bd-example-modal-lg" id="packet_airway_bill_log" tabindex="-1" role="dialog" aria-labelledby="log" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <p class="modal-title" id="exampleModalLabel">Booked Packet AirWay Bill Log</p>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="log-body-airway-bill" style="height:auto">

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade bd-example-modal" id="status_update" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Status Update</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="padding: 0px 10px 0px 0;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="height: 260px;">
                    <div class="row">
                        <form id="status_update_form" action="" novalidate="novalidate" data-parsley-validate class="form-horizontal form-label-left" method="post">
                            <input type="hidden" id="bookedPacketID" name="bookedPacketID">
                            <div class="col-md-12 ">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select style="width: 100%; height: 20%;" id="booked_packet_status" name="booked_packet_status" data-rule-required="true"  data-msg-required="This is required"
                                            class="form-control">
                                        <option selected value="">Please Select Status</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 ">
                                <div class="form-group">
                                    <label >Comments</label>
                                    <textarea name="comments" id="comments" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="col-md-12 ">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- LoadSheet Modal End -->
@endsection
@section('scripts')
    <script>
        const token = getToken();
        const getUserData = JSON.parse(getUser());
        const headers = {
            "Authorization": `Bearer ${token}`,
        };

        $(document).ready(function () {
            $("#origin").select2({
                placeholder: "Search City",
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
            $("#destination").select2({
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

            $("#shipper_id").select2({
                placeholder: "Search Client",
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

            $("#shipper").select2({
                dropdownParent: $("#shipper").parent(),
                placeholder: "Search Client",
                minimumInputLength: 4, // Minimum characters before sending the AJAX request
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
            {{--$("#booked_packet_status").select2({--}}
            {{--    dropdownParent: $("#booked_packet_status").parent(),--}}
            {{--    placeholder: "Search Status",--}}
            {{--    // minimumInputLength: 4, // Minimum characters before sending the AJAX request--}}
            {{--    // allowClear: true,--}}
            {{--    ajax: {--}}
            {{--        url: "{{ api_url('get_status_list') }}", // Replace with your actual server endpoint--}}
            {{--        dataType: "json",--}}
            {{--        delay: 250, // Delay before sending the request in milliseconds--}}
            {{--        headers: headers,--}}
            {{--        processResults: function (data) {--}}
            {{--            console.log(data)--}}
            {{--            return {--}}
            {{--                results: data.map(function (item) {--}}
            {{--                    return {--}}
            {{--                        id: item.id,--}}
            {{--                        text: item.title // 'text' property is required by Select2--}}
            {{--                    };--}}
            {{--                })--}}
            {{--            };--}}
            {{--        },--}}
            {{--        cache: true // Enable caching of AJAX results--}}
            {{--    }--}}
            {{--});--}}

            var statusRequest = $.ajax({
                url: '{{ api_url('get_status') }}',
                method: 'GET',
                dataType: 'json',
                headers: headers,
                beforeSend: function () {
                    $('.error-container').html('');
                }
            });
            {{--var shippersRequest = $.ajax({--}}
            {{--    url: '{{ api_url('manage_client/shipper/get_shippers') }}',--}}
            {{--    method: 'GET',--}}
            {{--    dataType: 'json',--}}
            {{--    headers: headers,--}}
            {{--    beforeSend: function() {--}}
            {{--        $('.error-container').html('');--}}
            {{--    }--}}
            {{--});--}}
            $.when(statusRequest).done(function (statusData) {
                console.log(statusData);
                var statusOption = '';
                $.each(statusData.data.status, function (index, value) {
                    statusOption += `<option value="${value.id}">${value.title}</option>`;
                });
                $('#status').append(statusOption);
                $('#booked_packet_status').append(statusOption);
            });
        });

        $('#status_update').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var bookedPacketID = button.data('booked_packet_id'); // Extract data from data-* attributes
            // var booked_packet_status = button.data('booked_packet_status'); // Extract data from data-* attributes
            // $('#booked_packet_status').val(booked_packet_status).trigger('change');
            $('#bookedPacketID').val(bookedPacketID);
        });

        var selected_rows = [];
        var table = $('#datatable').DataTable({
            dom: '<"search-box"f>l  <"col-md-12" <"float-right" B> ><"datatable-wrapper"rt><"datatable-info"i><"datatable-pagination"p>',
            search: {
                return: true
            },
            scrollX: true,
            scrollY: '400px', // Set the desired height in pixels
            scrollCollapse: true,
            buttons: [
                {
                    text: 'Smart Search Bar',
                    className: 'smart-search-bar',
                },
                {
                    text: '<i class="fa fa-file-pdf-o"></i> Generate LoadSheet',
                    className: 'btn btn-primary btn-sm add Loadsheet',
                    init: function (dt, node, config) {
                        // Add custom data attributes to the button
                        $(node).attr('data-toggle', "modal");
                        $(node).attr('data-target', "#LoadSheetModal");
                        $(node).attr('data-screen-permission-id', "114");
                    }
                },
            ],
            select: {
                info: false,
                style: 'multi',
                selector: 'td.select-checkbox',
                className: 'selected bg-primary bg-lighten-5 primary'
            },
            lengthMenu: [[50, 500, 1000, 5000, 10000, -1], [50, 500, 1000, 5000, 10000, 'All']],
            pageLength: 50,
            pagingType: 'full_numbers',
            processing: true, // Enable processing indicator
            language: {
                processing: '<img  src="{{ url_secure('build/images/transpatent_leopard.gif') }}" alt="Loading..."> Loading Data...',

            },
            serverSide: true,
            ajax: {
                url: '<?php echo api_url('manage_booking/list') ?>',
                data: function (d) {
                    d.origin = $('#origin').val();
                    d.destination = $('#destination').val();
                    d.status = $('#status').val();
                    d.shipper_id = $('#shipper_id').val();
                    d.date_range = $('#reservation').val();
                    d.booked_packet_cn = $('#booked_packet_cn').val();
                    d.consignee_phone = $('#consignee_phone').val();
                    d.client_region = $('#client_region').val();
                    d.ajax = 1;
                },
                headers: headers,
            },
            drawCallback: function (xhr, textStatus) {
                setTimeout(delayfunc(), 200);
            },
            rowId: 'id',
            order: [[10, 'desc']],
            columns: [
                {
                    data: 'serial_number',
                    orderable: false,
                    searchable: false,
                    name: 'pickup_requests.id',
                    class: 'align-middle serial_number',
                    targets: 1,
                    render: function (data, type, row) {
                        return '';
                    },
                    download: false
                },
                {
                    data: 'booked_packet_status_message',
                    name: 'ecom_status.title',
                    class: 'align-middle booked_packet_status_message',
                    text: 'Status',
                    download: true
                },
                {
                    data: 'booked_packet_order_id',
                    name: 'ecom_bookings.booked_packet_order_id',
                    class: 'align-middle booked_packet_order_id',
                    text: 'Order Id',
                    download: true
                },
                {
                    data: 'shipment_type_name',
                    name: 'shipment_type_name',
                    class: 'align-middle shipment_type_name',
                    text: 'Shipment Type',
                    download: true
                },
                {
                    data: 'booked_packet_cn',
                    name: 'ecom_bookings.booked_packet_cn',
                    class: 'align-middle booked_packet_cn',
                    text: 'CN',
                    download: true
                },
                {
                    data: 'origin_city',
                    name: 'orig.city_name',
                    as: 'origin_city',
                    class: 'align-middle origin_city',
                    text: 'Origin City',
                    download: true
                },
                {
                    data: 'destination_city',
                    name: 'dest.city_name',
                    as: 'destination_city',
                    class: 'align-middle destination_city',
                    text: 'Destination City',
                    download: true
                },
                {
                    data: 'merchant_name',
                    name: 'ecom_merchant.merchant_name',
                    class: 'align-middle merchant_name',
                    text: 'Merchant Name/Merchant Contact Person',
                    download: true
                },
                {
                    data: 'consignment_name',
                    name: 'ecom_consignee.consignee_name',
                    class: 'align-middle consignment_name',
                    text: 'Consignee',
                    download: true
                },
                {
                    data: 'consignee_phone',
                    name: 'ecom_consignee.consignee_phone',
                    class: 'align-middle consignee_phone',
                    text: 'Consignee Phone',
                    download: true
                },
                {
                    data: 'booked_packet_date',
                    name: 'ecom_bookings.booked_packet_date',
                    class: 'align-middle booked_packet_date',
                    text: 'Booking Date',
                    download: true
                },
                {
                    data: 'booked_packet_collect_amount',
                    name: 'ecom_bookings.booked_packet_collect_amount',
                    class: 'align-middle booked_packet_collect_amount',
                    text: 'COD Amount',
                    download: true,
                    "render": function (data, type, row) {
                        // Format the number as currency with commas
                        return Math.round(parseFloat(data)).toLocaleString('en-IN');
                    }
                },
                {
                    data: 'action',
                    class: 'align-middle text-center action',
                    orderable: false,
                    searchable: false,
                    download: false
                },
            ],
            //	Sr #	Sys ID#	Page Order	Page Name	Pages Body	Date Created	Actions
            rowCallback: function (row, data, index) {
                var info = table.page.info();

                $('td:eq(0)', row).html(index + 1 + info.page * info.length);

                if ($.inArray(data.id, selected_rows) !== -1) {
                    table.row(row).select();
                }
            },
            initComplete: function (settings, json) {
                // console.log(json);
                // if(json){
                //     if(json.recordsTotal){
                //         $('#recordsTotal').val(json.recordsTotal);
                //     }
                // }
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
                        var current = $(input).appendTo($(search)).on('change', function () {
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
        let option = '';
        var columnNames2 = table.settings().init().columns.map(function (column) {
            if (column.download) {
                let col_name = column.name;
                let col_text = column.text;
                if(col_name == 'merchant_name'){
                    col_name = encodeURIComponent(`CONCAT(ecom_merchant.merchant_name,"(",ecom_merchant.merchant_contact_person,")")`);
                }
                if(column.as){
                    col_name+= ' as ' +column.as;
                }
                if (col_name && col_text) {
                    option += `<option value="${col_name}">${col_text}</option>`;
                }

            }
        });

        function search() {
            table.draw();
        }

        $('body').delegate('.applyBtn ', 'click', function (e) {
            search();
        });

        $('body').delegate('#booked_packet_cn', 'keyup', function (e) {
            var cnLength = $('#booked_packet_cn').val().length;
            if(cnLength > 7){
                search();
            }
        });

        $('body').delegate('#consignee_phone', 'keyup', function (e) {
            var cnLength = $('#consignee_phone').val().length;
            if(cnLength > 7){
                search();
            }
        });

        $('body').delegate('.Loadsheet ', 'click', function (e) {
            loadSheetDetail();
        });

        function loadSheetDetail() {
            var from = $('#from').val();
            var to = $('#to').val();
            var shipper = $('#shipper').val();
            $.ajax({
                url: '<?php echo api_url('manage_booking/packets/ajax'); ?>',
                method: 'GET',
                dataType: 'json', // Set the expected data type to JSON
                headers: headers,
                data: {from, to,shipper},
                beforeSend: function () {
                    $('#loadsheet_table tbody').html('');
                    $('#loadsheet_table tbody').html(`<tr><td colspan="11" class="text-center"><img src="${giff_url}" alt="Loading..."></td></tr>`);
                },
                success: function (data) {
                    var body = "";
                    data.forEach(item => {
                        const tr = `
                                        <tr>
                                            <td><input type='checkbox' class='checkbox' checked='true' name='checked_bookings[]' value=${item.id}></td>
                                            <td>${item.booked_packet_date}</td>
                                            <td>${item.booked_packet_cn}</td>
                                            <td>${item.title}</td>
                                            <td>${item.booked_packet_order_id}</td>
                                            <td>${item.origin_city}</td>
                                            <td>${item.destination_city}</td>
                                            <td>${item.merchant_name}</td>
                                            <td>${item.shipper_name}</td>
                                            <td>${item.consignee_name}</td>
                                            <td>${item.booked_packet_collect_amount}</td>
                                        </tr>
                               `;
                        body += tr;
                    });

                    $('#loadsheet_table tbody').html(body);
                },
                error: function (xhr, textStatus, errorThrown) {
                    // Handle AJAX errors here
                }
            });
        }

        $('body').delegate('.cancel_booking', 'click', function (e) {
            var cn = $(this).attr("rel");
            Swal.fire({
                title: 'Are you sure To Cancel This Packet?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Submit'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '<?php echo api_url('manage_booking/cancel_booked_packet/'); ?>' + cn,
                        method: 'GET',
                        dataType: 'json', // Set the expected data type to JSON
                        beforeSend: function () {
                            $('.error-container').html('');
                        },
                        headers: headers,
                        success: function (data) {
                            if (data && data.status == 1) {
                                Swal.fire(
                                    'Done!',
                                    'Packet has been cancelled successfully',
                                    'success'
                                );
                                search();
                            }
                        },
                        error: function (xhr, textStatus, errorThrown) {
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


        $('body').delegate('.generate_slip', 'click', function (e) {
            var cn = $(this).attr("rel");
            var url = `<?php echo api_url('merchant/booking/booked_packet_slip/') ?>` + cn;

            Swal.fire({
                title: 'Are you sure To Cancel This Packet?',
                text: "This Will Print The Slip",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Print'
            }).then((result) => {
                if (result.isConfirmed) {

                    let sw;
                    $.ajax({
                        url: url,
                        method: 'GET',
                        headers: headers,
                        beforeSend: function () {
                            let timerInterval;
                            sw = Swal.fire({
                                title: '',
                                html: 'Please Wait',
                                timer: 2000,
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
                        complete: function () {

                        },
                        error: function (xhr, textStatus, errorThrown) {
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


        // jQuery function to toggle between "Select All" and "Unselect All" states
        $(document).ready(function () {
            $('#reservation').val('');
            $('#selectAllCheckbox').on('change', function () {
                $('.checkbox').prop('checked', this.checked);
            });
        });

        $("#process-loadsheet").validate({
            errorClass: "danger",
            errorPlacement: function (error, element) {
                error.addClass('w-100').appendTo(element.parent(0));
            },
            submitHandler: function (form, event) {
                event.preventDefault();
                Swal.fire({
                    title: 'Are you sure To Generate Loadsheet for these CNs?',
                    text: "You won't to sumbit this form!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Submit'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var data = $('#process-loadsheet').serialize();
                        $.ajax({
                            url: '<?php echo api_url('manage_booking/loadsheet/process'); ?>',
                            method: 'POST',
                            data: data,
                            dataType: 'json', // Set the expected data type to JSON
                            headers: headers,
                            success: function (data) {
                                console.log(data)
                                if (data && data.status == 1) {
                                    Swal.fire(
                                        'Saved!',
                                        'Load Sheet Generated Successfully. Challan ID Is' + data.loadsheet_id,
                                        'success'
                                    );
                                    window.location.href = '<?php echo url_secure('manage_booking/list') ?>'
                                } else {
                                    // Handle other status codes or error scenarios if needed
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
                        url: '<?php  echo api_url('manage_booking/downloadCsv')  ?>', // Replace with your backend URL
                        type: 'GET',
                        data: {
                            selectedValue: selectedValue,
                            selectedTexts: selectedTexts,
                            origin :$('#origin').val(),
                            destination:$('#destination').val(),
                            status:$('#status').val(),
                            shipper_id:$('#shipper_id').val(),
                            date_range:$('#reservation').val(),
                            booked_packet_cn:$('#booked_packet_cn').val(),
                            consignee_phone:$('#consignee_phone').val(),
                            excel: true,
                            ajax:1,
                        },
                        headers:headers,
                        success: function (response) {
                            // Create a blob from the response
                            var blob = new Blob([response], {type: 'text/csv'});

                            // Create a temporary URL for the blob
                            var url = window.URL.createObjectURL(blob);

                            // Create a hidden anchor link and set its attributes
                            var a = document.createElement('a');
                            a.href = url;
                            a.download = 'manage_booked_packet' + new Date().toISOString().slice(0, 10) + '.csv';

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


        $('#packet_history').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var booked_packet_cn = button.data('booked_packet_cn'); // Extract data from data-* attributes
            var is_admin = (button.data('is_admin')) ? button.data('is_admin') : 0;

            $.ajax({
                url: '<?php echo api_url('manage_booking/packet_log') ?>', // Replace with your backend URL
                type: 'GET',
                headers:headers,
                data: {booked_packet_cn,is_admin},
                beforeSend: function(){
                    $('#log-body').html('');
                    $('#log-body').html(`<div class="text-center"><img src="${giff_url}" alt="Loading..."></div>`);
                },
                success: function (response) {
                    $('#log-body').html(response);
                },
                error: function (error) {
                }
            });
        });

        $('#packet_airway_bill_log').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var booked_packet_cn = button.data('booked_packet_cn'); // Extract data from data-* attributes
            var is_admin = (button.data('is_admin')) ? button.data('is_admin') : 0;

            $.ajax({
                url: '<?php echo api_url('manage_booking/airway_bill_log') ?>', // Replace with your backend URL
                type: 'GET',
                headers:headers,
                data: {booked_packet_cn,is_admin},
                beforeSend: function(){
                    $('#log-body-airway-bill').html('');
                    $('#log-body-airway-bill').html(`<div class="text-center"><img src="${giff_url}" alt="Loading..."></div>`);
                },
                success: function (response) {
                    $('#log-body-airway-bill').html(response);
                },
                error: function (error) {
                }
            });
        });


        $("#status_update_form").validate({
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

                        var booked_packet_status = $("#booked_packet_status option:selected").text();
                        var book_packet_status_id = $("#booked_packet_status option:selected").val();
                        var booked_packet_comments = $("#comments").val();
                        var booked_packet_id = $('#bookedPacketID').val();

                        $.ajax({
                            url: '{{ api_url('manage_booking/update_status') }}',
                            type: 'POST',
                            dataType: 'json',
                            headers:headers,
                            data: {
                                booked_packet_status: book_packet_status_id,
                                booked_packet_comments: booked_packet_comments,
                                booked_packet_id:booked_packet_id,
                                '_token': '{{ csrf_token() }}'
                            },
                            success: function (response) {
                                Swal.fire({
                                    icon: 'success',
                                    text: 'Form has been submitted successfully',
                                    showConfirmButton: true,
                                    confirmButtonColor: '#ffca00',
                                });
                                $('#status_update').modal('hide');
                                $('#booked_packet_status').val('');
                                $("#comments").val('');
                                table.draw();
                            }
                        });
                    }
                })
            }
        });

    </script>
@endsection
