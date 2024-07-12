@extends('Admin.layout.main')

@section('styles')
    <style>
        .datatable-wrapper {
            overflow-x: scroll;
        }

        .date-note {
            font-weight: 600;
        }

        .smart-search-bar {
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

@section('title') Consignment Details @endsection

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
                            <h2> Consignment Details </h2>
                            <ul class="nav navbar-right panel_toolbox justify-content-end">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                            <hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <h6 class="date-note"><b>Note: </b>Please select date range in order to see complete
                                        booked packet listing.By default it shows only current date booking.</h6>
                                    <hr>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <div class="form-group">
                                        <label>Date</label>
                                        <input type="hidden" id="date" name="date">
                                        <div class="input-prepend input-group">
                                                <span class="add-on input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </span>
                                            <input type="text" name="reservation" id="reservation"
                                                   class="form-control" value="">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Client Regions</label>
                                        <select id="client_region" name="client_region" class="form-control select2" onchange="search()">
                                            <option selected value="">Choose option</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <div class="form-group">
                                        <label>Client</label>
                                        <select class="form-control select2" name="merchant_id" id="merchant_id"
                                                onchange="search()" multiple="multiple">
                                            <option value="">Please Select Client</option>
                                        </select>
                                        <span class="error-container danger w-100"></span>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <div class="form-group">
                                        <label>Tier</label>
                                        <select class="form-control select2" name="tier_id" id="tier_id"
                                                onchange="search()">
                                            <option value="">Please Select Tier</option>
                                        </select>
                                        <span class="error-container danger w-100"></span>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label col-md-12 col-sm-12 col-xs-12">Origin City</label>
                                        <select class="form-control select2" name="city_id" id="city_id"
                                                onchange="search()">
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="x_content">
                            <form method="POST" enctype="multipart/form-data" action="#" id="export-csv"
                                  data-screen-permission-id="156">
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
                            <!-- <p class="text-muted font-13 m-b-30">
                              DataTables has most features enabled by default, so all you need to do to use it with your own tables is to call the construction function: <code>$().DataTable();</code>
                            </p> -->
                            <table id="datatable" class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>SR#</th>
                                    <th>Status</th>
                                    <th>Delivery/Return Date</th>
                                    <th>Client ID-Name</th>
                                    <th>Booking Date</th>
                                    <th>Pickup Date</th>
                                    <th>CN #</th>
                                    <th>Order ID</th>
                                    <th>Origin</th>
                                    <th>Destination</th>
                                    <th>Destination Zone</th>
                                    <th>Tier</th>
                                    <th>COD Amount (PKR)</th>
                                    <th>Payment Flag</th>
                                    <th>Consignee Name</th>
                                    <th>Consignee Address</th>
                                    <th>Consignee Phone</th>
                                    <th>Comments</th>
                                </tr>
                                </thead>
                            </table>
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

        $(document).ready(function () {
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

            $("#city_id").select2({
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

            $("#tier_id").select2({
                placeholder: "Search Tier Label",
                // minimumInputLength: 2, // Minimum characters before sending the AJAX request
                allowClear: true,
                ajax: {
                    url: "{{ api_url('get_tier') }}", // Replace with your actual server endpoint
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
        var selected_rows = [];
        var table = $('#datatable').DataTable({
            dom: '<"search-box"f>l  <"" <"text-center" B> ><"datatable-wrapper"rt><"datatable-info"i><"datatable-pagination"p>',
            search: {
                return: true
            },
            buttons: [
                {
                    text: 'Smart Search Bar',
                    className: 'smart-search-bar',
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
            processing: true,
            language: {
                processing: '<img  src="{{ url_secure('build/images/transpatent_leopard.gif') }}" alt="Loading..."> Loading Data...',
            },
            serverSide: true,
            ajax: {
                url: '<?php echo api_url('report_manager/consignment_details'); ?>',
                data: function (d) {
                    d.ajax = 1;
                    d.date = $('#date').val();
                    d.city_id = $('#city_id').val();
                    d.merchant_id = $('#merchant_id').val();
                    d.tier_id = $('#tier_id').val();
                    d.client_region = $('#client_region').val();
                },
                headers: headers,
            },
            rowId: 'serial_number',
            order: [[4, 'desc']],
            columns: [
                // {data: 'id', orderable: false, searchable: false, class: 'text-center align-middle select select-checkbox p-1', targets: 0, render: function (data, type, row) {return '';} ,download:false},
                {
                    data: 'serial_number',
                    orderable: false,
                    searchable: false,
                    name: 'serial_number',
                    class: 'align-middle serial_number',
                    targets: 1,
                    render: function (data, type, row) {
                        return '';
                    },
                    download: false
                },
                {data: 'title', name: 'ecom_status.title', class: 'align-middle title', text: 'Status', download: true},
                {data: 'delivery_return', name: 'ecom_bookings.delivery_date', as:'delivery_return', class: 'align-middle delivery_date', text: 'Delivery / Return Date #', download: true},
                {data: 'client', name: 'client', as: 'Client_ID_Name', class: 'align-middle client', text: 'Client', download: true},
                {data: 'booked_packet_date', name: 'ecom_bookings.booked_packet_date', class: 'align-middle booked_packet_date', text: 'Booked Packet Date', download: true},
                {data: 'ARVL_DATE', name: 'eao.ARVL_DATE', class: 'align-middle ARVL_DATE', text: 'Pickup Date', download: true},
                {data: 'booked_packet_cn', name: 'ecom_bookings.booked_packet_cn', class: 'align-middle booked_packet_cn', text: 'CN #', download: true},
                {data: 'booked_packet_order_id', name: 'ecom_bookings.booked_packet_order_id', class: 'align-middle booked_packet_order_id', text: 'Order ID', download: true},
                {data: 'origin_name', name: 'origin_city.city_name', as: 'origin_name', class: 'align-middle city_name', text: 'Origin City', download: true},
                {data: 'des_name', name: 'des_city.city_name', as: 'des_name', class: 'align-middle city_name', text: 'Destination City', download: true},
                {data: 'zone', name: 'central_ops_branch.zone', as: 'zone', class: 'align-middle zone', text: 'Destination Zone', download: true},
                {data: 'tier', name: 'ecom_tiers.label', as: 'tier', class: 'align-middle tier', text: 'Tier', download: true},
                {data: 'booked_packet_collect_amount', name: 'ecom_bookings.booked_packet_collect_amount', class: 'align-middle booked_packet_collect_amount', text: 'COD Amount (PKR)', download: true},
                {data: 'payment_flag', name: 'ecom_bookings.payment_received', class: 'align-middle payment_received', text: 'Payment Received Flag', download: true},
                {data: 'consignee_name', name: 'ecom_consignee.consignee_name', class: 'align-middle consignee_name', text: 'Consignee Name', download: true},
                {data: 'consignee_address', name: 'ecom_consignee.consignee_address', class: 'align-middle consignee_address limited', text: 'Consignee Address', download: true},
                {data: 'consignee_phone', name: 'ecom_consignee.consignee_phone', class: 'align-middle consignee_phone', text: 'Consignee Phone', download: true},
                {data: 'booked_packet_comments', name: 'ecom_bookings.booked_packet_comments', class: 'align-middle booked_packet_comments limited', text: 'Comments', download: true},

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

                    if ($(header).is('.action') || $(header).is('.serial_number') || $(header).is('.select') || $(header).is('.status')) {
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
        let option = '';
        var columnNames2 = table.settings().init().columns.map(function (column) {
            if (column.download) {
                let col_name = column.name;
                let col_text = column.text;
                if(col_name == 'client'){
                    col_name = encodeURIComponent(`CONCAT(ecom_merchant.merchant_account_no," - ",ecom_merchant.merchant_name)`);
                }
                if (column.as) {
                    col_name += ' as ' + column.as;
                }
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
                        url: '<?php  echo api_url('report_manager/consignment_details/downloadCsv')  ?>', // Replace with your backend URL
                        type: 'GET',
                        data: {
                            selectedValue: selectedValue,
                            selectedTexts: selectedTexts,
                            excel: true,
                            ajax: 1,
                            date: $('#date').val(),
                            city_id: $('#city_id').val(),
                            merchant_id: $('#merchant_id').val(),
                            client_region:$('#client_region').val(),
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
                            a.download = 'consignment_detail_report_' + new Date().toISOString().slice(0, 10) + '.csv';

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

        $("body").delegate(".applyBtn", "click", function () {
            $('#date').val($('#reservation').val());
            table.draw();
        })

        function search() {
            table.draw();
        }

    </script>

    <script src="{{ url_secure('build/js/main.js')}}"></script>
@endsection

