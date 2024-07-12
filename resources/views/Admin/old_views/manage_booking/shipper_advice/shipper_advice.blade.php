@extends('Admin.layout.main')
@section('title') Shipper Advice Bulk @endsection
@section('styles')
@endsection

@section('content')
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Shipper Advice</h3>
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
                                    <label>Origin City</label>
                                    <select class="form-control select2" name="origin_city" id="origin_city"
                                            onchange="search()">
                                        <option value="">Origin City</option>
                                    </select>
                                </div>

                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <label>Destination City</label>
                                    <select class="form-control select2" name="dest_city" id="dest_city"
                                            onchange="search()">
                                        <option value="">Destination City</option>
                                    </select>
                                </div>

                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <label>Status</label>
                                    <select class="form-control select2" onchange="search()" name="status" id="status">
                                        <option value="ALL">All</option>
                                        <option value="PI">Pending</option>
                                        <option value="RA">Re-Attempt</option>
                                        <option value="RT">Return</option>
                                    </select>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <label>Total Records</label>
                                    <select class="form-control select2" onchange="search()" name="record" id="record">
                                        <option value="None">None</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="x_content">
                            <form method="POST" enctype="multipart/form-data" action="#" id="export-csv" data-screen-permission-id="106">
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
                                    <!--                                <th></th>-->
                                    <th>Sr #</th>
                                    <th>Sys ID</th>
                                    <th>CN #</th>
                                    <th>Order ID</th>
                                    <th>Booking Date</th>
                                    <th>Shipper</th>
                                    <th>Shipper Phone</th>
                                    <th width="20%">Shipper Address</th>
                                    <th>Consignee Name</th>
                                    <th>Consignee Phone</th>
                                    <th width="20%">Consignee Address</th>
                                    <th>Pending Reason</th>
                                    <th>Shipper Remarks</th>
                                    <th>Advice Status</th>
                                    <th>Origin City</th>
                                    <th>Destination City</th>
                                    <th>Status Description</th>
                                    <th>OutCome Status</th>
                                    <th>OMS Status</th>
                                    <th>Created Date</th>
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

    <div id="activity-log" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="merchant-name"></h4>
                </div>
                <div class="modal-body">
                    <table id="datatable" class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th>Activity DateTime</th>
                            <th>Remarks</th>
                            <th>Status</th>
                            <th>Reason</th>
                        </tr>
                        <tbody>
                            <tr>
                                <td id="activity-date-time"></td>
                                <td id="remarks"></td>
                                <td id="status"></td>
                                <td id="reason"></td>
                            </tr>
                        </tbody>
                        </thead>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default antoclose" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /page content -->
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
                    },
                    init: function (dt, node, config) {
                        // Add custom data attributes to the button
                        $(node).attr('data-screen-permission-id', "103");
                    }
                },
                {
                    text: '<i class="la la-cogs"></i> Shipper Advice Log Report',
                    className: 'btn btn-primary btn-sm add',
                    action: function (e, dt, node, config) {
                        window.location = '<?php echo url_secure('manage_booking/shipper_advice/log/report') ?>';
                    },
                    init: function (dt, node, config) {
                        // Add custom data attributes to the button
                        $(node).attr('data-screen-permission-id', "104");
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
            processing: true,
            language: {
                processing: '<img src="{{ url_secure('build/images/transpatent_leopard.gif') }}" alt="Loading..."> Loading Data...',
            },
            serverSide: true,
            ajax: {
                url: '<?php echo api_url('manage_booking/shipper_advice') ?>',
                data: function (d) {
                    d.ajax = 1;
                    d.client = $('#client').val();
                    d.originCity = $('#origin_city').val();
                    d.destinationCity = $('#dest_city').val();
                    d.cn_number = $('#search').val();
                    d.date = $('#reservation').val();
                    d.status = $('#status').val();
                    d.record = $('#record').val();
                },
                headers: headers,
            },
            rowId: 'id',
            order: [[5, 'desc']],
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
                {data: 'id', name: 'id', class: 'align-middle id', text: 'Sys ID#', download: true},
                {data: 'cn_number', name: 'cn_number', class: 'align-middle cn_number', text: 'CN #', download: true},
                {data: 'order_id', name: 'order_id', class: 'align-middle order_id', text: 'Order Id', download: true},
                {
                    data: 'created_date',
                    name: 'created_date',
                    class: 'align-middle created_date',
                    text: 'Booking Date',
                    download: true
                },
                {
                    data: 'shipper_name',
                    name: 'shipper_name',
                    class: 'align-middle shipper_name',
                    text: 'Shipper',
                    download: true
                },
                {
                    data: 'shipper_mobile',
                    name: 'shipper_mobile',
                    class: 'align-middle shipper_mobile',
                    text: 'Shipper Phone',
                    download: true
                },
                {
                    data: 'shipper_address',
                    name: 'shipper_address',
                    class: 'align-middle shipper_address',
                    text: 'Shipper Address',
                    download: true
                },
                {
                    data: 'consignee_name',
                    name: 'consignee_name',
                    class: 'align-middle consignee_name',
                    text: 'Consignee Name',
                    download: true
                },
                {
                    data: 'consignee_mobile',
                    name: 'consignee_mobile',
                    class: 'align-middle consignee_mobile',
                    text: 'Consignee Phone',
                    download: true
                },
                {
                    data: 'consignee_address',
                    name: 'consignee_address',
                    class: 'align-middle consignee_address',
                    text: 'Consignee Address',
                    download: true
                },
                {data: 'reason', name: 'reason', class: 'align-middle reason', text: 'Pending Reason', download: true},
                {
                    data: 'shipper_remarks',
                    name: 'shipper_remarks',
                    class: 'align-middle shipper_remarks',
                    text: 'Shipper Remarks',
                    download: true
                },
                {
                    data: 'shipper_advice_status',
                    name: 'shipper_advice_status',
                    class: 'align-middle shipper_advice_status',
                    text: 'Shipper Advice Status',
                    download: true
                },
                {
                    data: 'origin_name',
                    name: 'origin_name',
                    class: 'align-middle origin_name',
                    text: 'Origin City',
                    download: true
                },
                {
                    data: 'dst_name',
                    name: 'dst_name',
                    class: 'align-middle dst_name',
                    text: 'Destination City',
                    download: true
                },
                {
                    data: 'status_description',
                    name: 'status_description',
                    class: 'align-middle status_description',
                    text: 'Status Description',
                    download: true
                },
                {
                    data: 'outcome_status',
                    name: 'outcome_status',
                    class: 'align-middle outcome_status',
                    text: 'OutCome Status',
                    download: true
                },
                {
                    data: 'oms_status',
                    name: 'oms_status',
                    class: 'align-middle oms_status',
                    text: 'OMS Status',
                    download: true
                },
                {
                    data: 'created_date',
                    name: 'created_date',
                    class: 'align-middle created_date',
                    text: 'Date Created',
                    download: true
                },
                {
                    data: 'action',
                    class: 'align-middle text-center action',
                    orderable: false,
                    searchable: false,
                    download: false
                }
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
                        url: '<?php  echo api_url('manage_booking/shipper_advice/downloadCsv')  ?>', // Replace with your backend URL
                        type: 'GET',
                        data: {
                            selectedValue: selectedValue,
                            selectedTexts: selectedTexts,
                            excel: true,
                            ajax: 1,
                            client: $('#client').val(),
                            originCity: $('#origin_city').val(),
                            destinationCity: $('#dest_city').val(),
                            cn_number: $('#search').val(),
                            date: $('#reservation').val(),
                            status: $('#status').val(),
                            record: $('#record').val(),
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
            // console.log(table.draw());
            // let timerInterval;
            // sw = Swal.fire({
            //     title: '',
            //     html: 'Please Wait',
            //     timerProgressBar: true,
            //     didOpen: () => {
            //         Swal.showLoading()
            //
            //     },
            //     willClose: () => {
            //         clearInterval(timerInterval)
            //     }
            // })
            table.draw();
        }

        $("body").delegate(".applyBtn", "click", function () {
            table.draw();
        })

        function activityLog(cnNumber){
            Swal.fire({
                title: 'Auto close When Get Response!',
                timerProgressBar: true,
                didOpen: () => {
                    Swal.showLoading()
                    const b = Swal.getHtmlContainer().querySelector('b')
                    timerInterval = setInterval(() => {
                       // b.textContent = Swal.getTimerLeft()
                    })
                },
                willClose: () => {
                    clearInterval(timerInterval)
                }
            });
            // alert(id)
            $.ajax({
                url: '<?php echo api_url('manage_booking/shipper_advice/activity/log'); ?>',
                method: 'GET',
                dataType: 'json', // Set the expected data type to JSON
                headers: headers,
                data: {cn_number: cnNumber},
                beforeSend: function(){
                    $('.error-container').html('');
                },
                success: function(data) {
                    $('.swal2-backdrop-show').hide();
                    $("#activity-log").modal();
                    const dateObject = new Date(data.data[0].activity);
                    console.log(dateObject);
                    document.getElementById('activity-date-time').innerHTML = dateObject;
                    document.getElementById('remarks').innerHTML = data.data[0].remarks;
                    document.getElementById('status').innerHTML = data.data[0].shipper_advice_status;
                    document.getElementById('reason').innerHTML = data.data[0].reason;

                },
                error: function(xhr, textStatus, errorThrown) {
                    // Handle AJAX errors here
                }
            });
        }

        $(document).ready(function () {
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
            $.ajax({
                url: '<?php echo api_url('getShipperRecord'); ?>',
                method: 'GET',
                dataType: 'json', // Set the expected data type to JSON
                headers: headers,
                success: function(data) {
                    console.log(data)
                    var BatchDataOPtion = '';
                    $.each(data, function(index, value) {
                        BatchDataOPtion += `<option value="${value}">${value}</option>`;
                    });
                    $('#record').append(BatchDataOPtion);
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
        });

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
        });

    </script>

@endsection

