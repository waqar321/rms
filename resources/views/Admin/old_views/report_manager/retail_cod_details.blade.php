@extends('Admin.layout.main')
@section('title') Retail Ready For Invoice Bookings @endsection
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
            max-width: 900px;
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
                    <h3>Retail Ready For Invoice Packets</h3>
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
                                    <h6 class="date-note"><b>Note: </b>Please select date range in order to see complete
                                        booked packet listing. By default it shows 3 months date booking.</h6>
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
                                        <option value="12">Delivered</option>
                                        <option value="7">Returned To Shipper</option>
                                    </select>
                                </div>

                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <label>Search By CN</label>
                                    <input id="booked_packet_cn" name="booked_packet_cn" class="form-control">
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

                                <!-- <div class="col-md-4 col-sm-4 col-xs-12">
                                    <label>Shippers (Clients)</label>
                                    <select id="shipper_id" name="shipper_id" class="form-control select2"
                                            onchange="search()">
                                        <option selected value="">Choose option</option>
                                    </select>
                                </div> -->

                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <label>Banking Details</label>
                                    <select id="with_bank" name="shipper_id" class="form-control select2"
                                            onchange="search()">
                                        <option selected value="">Choose option</option>
                                        <option value="1">With Banking Details</option>
                                        <option value="0">Without Banking Details</option>
                                    </select>
                                </div>

                            </div>
                        </div>
                        <div class="x_content">
                            <form method="POST" enctype="multipart/form-data" action="#" id="export-csv" data-screen-permission-id="202">
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
                                    <!-- <th>OrderID</th> -->
                                    <th>Shipment Type</th>
                                    <th>CN#</th>
                                    <th>From</th>
                                    <th>To</th>
                                    <th>Shipper ID</th>
                                    <th>Shipper</th>
                                    <th>Consignee</th>
                                    <!-- <th>Phone1</th> -->
                                    <th>Booking Date</th>
                                    <th>Amount (PKR)</th>
                                    <th>Bank Branch</th>
                                    <th>Bank Name</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
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
            buttons: [],
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
                url: '<?php echo api_url('report_manager/retail_cod_details') ?>',
                data: function (d) {
                    d.origin = $('#origin').val();
                    d.destination = $('#destination').val();
                    d.status = $('#status').val();
                    d.shipper_id = $('#shipper_id').val();
                    d.date_range = $('#reservation').val();
                    d.booked_packet_cn = $('#booked_packet_cn').val();
                    d.with_bank = $('#with_bank').val();
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
                // {
                //     data: 'booked_packet_order_id',
                //     name: 'ecom_bookings.booked_packet_order_id',
                //     class: 'align-middle booked_packet_order_id',
                //     text: 'Order Id',
                //     download: true
                // },
                {
                    data: 'shipment_type_name',
                    name: 'st.shipment_type_name',
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
                    class: 'align-middle origin_city',
                    text: 'Origin City',
                    download: true
                },
                {
                    data: 'destination_city',
                    name: 'dest.city_name',
                    class: 'align-middle destination_city',
                    text: 'Destination City',
                    download: true
                },
                {
                    data: 'shipper_id',
                    name: 'ecom_bookings.shipper_id',
                    class: 'align-middle shipper_id',
                    text: 'Shipper ID',
                    download: true
                },
                {
                    data: 'merchant_name',
                    name: 'shipper.merchant_name',
                    class: 'align-middle merchant_name',
                    text: 'Merchant Name',
                    download: true
                },
                {
                    data: 'consignment_name',
                    name: 'ecom_consignee.consignee_name',
                    class: 'align-middle consignment_name',
                    text: 'Consignee',
                    download: true
                },
                // {
                //     data: 'consignee_phone',
                //     name: 'ecom_consignee.consignee_phone',
                //     class: 'align-middle consignee_phone',
                //     text: 'Consignee Phone',
                //     download: true
                // },
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
                    },

                },
                {
                    data: 'bank_branch',
                    name: 'ecom_merchant_finance.bank_branch',
                    class: 'align-middle bank_branch',
                    text: 'Bank Branch',
                    download: true
                },
                {
                    data: 'bank_name',
                    name: 'ecom_bank_list.bank_name',
                    class: 'align-middle bank_name',
                    text: 'Bank Name',
                    download: true
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

        function search() {
            table.draw();
        }

        $('body').delegate('.applyBtn ', 'click', function (e) {
            search();
        });

        $('body').delegate('#booked_packet_cn', 'keyup', function (e) {
            var cnLength = $('#booked_packet_cn').val().length;
            if(cnLength > 8){
                search();
            }
        });

        $('body').delegate('.Loadsheet ', 'click', function (e) {
            loadSheetDetail();
        });

        function loadSheetDetail() {
            var from = $('#from').val();
            var to = $('#to').val();

            $.ajax({
                url: '<?php echo api_url('manage_booking/packets/ajax'); ?>',
                method: 'GET',
                dataType: 'json', // Set the expected data type to JSON
                headers: headers,
                data: {from, to},
                beforeSend: function () {
                    $('#loadsheet_table tbody').html('');
                    $('#loadsheet_table tbody').html(`<tr><td colspan="10" class="text-center"><img src="${giff_url}" alt="Loading..."></td></tr>`);
                },
                success: function (data) {
                    var body = "";
                    data.forEach(item => {
                        const tr = `
                                        <tr>
                                            <td><input type='checkbox' class='checkbox' checked='true' name='checked_bookings[]' value=${item.id}></td>
                                            <td>${item.booked_packet_date}</td>
                                            <td>${item.booked_packet_cn}</td>
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
                        url: '<?php  echo api_url('report_manager/retail_cod_details')  ?>', // Replace with your backend URL
                        type: 'GET',
                        data: {
                            selectedValue: selectedValue,
                            selectedTexts: selectedTexts,
                            origin :$('#origin').val(),
                            destination:$('#destination').val(),
                            status:$('#status').val(),
                            shipper_id:$('#shipper_id').val(),
                            date_range:$('#reservation').val(),
                            with_bank : $('#with_bank').val(),
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
                            a.download = 'retail_cod_detail_report_' + new Date().toISOString().slice(0, 10) + '.csv';

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

    </script>
@endsection
