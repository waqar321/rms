@extends('Admin.layout.main')
@section('title') Support Tickets @endsection
@section('styles')
    <style>
        .x_title {
             margin-bottom: 13px;
        }
        th,td {
            font-size: 12px !important;
        }
        #datatable_length {
            margin-top: 0;
        }
        div#datatable_filter {
            display: none;
        }

    </style>
@endsection

@section('content')
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
                <div class="title_left">
                    <h3>Support tickets</h3>
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
                    </div>

                    <div class="row">
                       <div class="col-md-12">

                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <div class="form-group">
                                    <label>Date</label>
                                    <div class="input-prepend input-group">
                                        <span class="add-on input-group-addon"><i class="fa fa-calendar"></i></span>
                                        <input type="text" name="reservation" id="reservation" class="form-control"
                                               value="{{ (isset($request_data['date'])) ? $request_data['date'] : '' }}">
                                    </div>
                                </div>

                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Client Regions</label>
                                    <select id="client_region" name="client_region" class="form-control select2" onchange="search()" >
                                        <option selected value="">Choose option</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4 col-sm-3 col-xs-12">
                                <label>Search By Shippers (Clients)</label>
                                <select class="form-control select2" onchange="search()" name="merchants" id="merchants" multiple="multiple">
                                    <option value="">View All</option>
                                </select>
                            </div>

                        </div>

                        <div class="col-md-12">

                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <label>Ticket Status</label>
                                    <select class="form-control select2" name="status" id="status" onchange="search()" multiple="multiple">
                                        <option value="0">View All</option>
{{--                                        <option value="-1"></option>--}}
                                        <?php
                                        foreach($ticketStatuses as $status){
                                            $selected="";
                                            $selectedstatus = (isset($request_data->status))?$request_data->status:'';
                                            if(!empty($selectedstatus)){
                                                if((int)$selectedstatus == $status->Id){
                                                    $selected = "selected";
                                                }
                                            }
                                        ?>
                                        <option value="<?php echo $status->Id; ?>" <?php echo $selected ?> ><?php echo $status->Name; ?></option>
                                        <?php } ?>
                                    </select>
                            </div>

                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <label>Nature Type</label>
                                <select class="form-control select2" onchange="searchByNature()" name="ticket_type" id="ticket_type">
                                    <option selected value="">Select Nature Type</option>
                                    <?php
                                    foreach($ticketTypes as $type){
                                        $selected="";
                                        $selectednature = (isset($request_data['ticket_type']))?$request_data['ticket_type']:'';
                                        if(!empty($selectednature)){
                                            if((int)$selectednature == $type->id){
                                                $selected = "selected";
                                            }
                                        }
                                    ?>
                                    <option value="<?php echo $type->id; ?>" <?php echo $selected ?> ><?php echo $type->Nature; ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <label>Ticket Type Option</label>
                                <select class="form-control select2" id="support_ticket_type_id" onchange="search()">

                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Destination Regions</label>
                                    <select id="region" name="region" class="form-control select2" onchange="search()" >
                                        <option selected value="">Choose option</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Destination Zones</label>
                                    <select id="zone" name="zone" class="form-control select2" onchange="search()" >
                                        <option selected value="">Choose option</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <label>Destination City</label>
                                <select class="form-control select2" id="destination_city_id" onchange="search()"></select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <div class="form-group mt-2">
                                    <label>Cn Or Ticket No #</label>
                                    <div class="input-prepend input-group">
                                        <input type="text" name="cn_ticket" id="cn_ticket" class="form-control" onchange="search()">
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <hr>

                    <div class="row" style="margin-top: 3%">
                        <div class="col-md-12">
                            <form method="POST" enctype="multipart/form-data" action="#" id="export-csv" data-screen-permission-id="133">
                                <div class="row">
                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                        <label class="control-label col-md-12 col-sm-12 col-xs-12">Export To Excel</label>
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <select name="export[]" multiple id="export">

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                        <label class="control-label col-md-12 col-sm-12 col-xs-12">&nbsp;</label>
                                        <button type="submit" class="btn btn-primary btn-sm">Export</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="clearfix"></div>



                    <div class="x_content">
                        <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                            <!-- <tr>
                                <th>Sr #</th>
                                <th>Ticket No</th>
                                <th>CN #</th>
                                <th>Nature Type</th>
                                <th>Ticket Type</th>
                                <th>Status</th>
                                <th>Origin</th>
                                <th>Destination City</th>
                                <th>Defaulter City</th>
                                <th>Consignee Contact</th>
                                <th>Shipper</th>
                                <th>Created At</th>
                                <th>Last Activity Date</th>
                                <th>Actions</th>
                            </tr> -->
                                <tr>
                                    <th>Sr #</th>
                                    <th>Ticket No &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                    <th>CN Number# &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                    <th>COD Amount &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                    <th>Client (ID - Name) &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                    <th>CN Booking Date &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                    <th>Destination City &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                    <th>Destination Zone &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                    <th>Current Status &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                    <th>Current City &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                    <th>Current Zone &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                    <th>Defaulter City &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                    <th>Defaulter Zone &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                    <th>Ticket Nature &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                    <th>Ticket Type &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                    <th>Ticket Status &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                    <th>Ticket Created Date/Time &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                    <th>Last Activity Date/Time &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                    <th>Last Updated By &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
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
<!-- /page content -->
@endsection

@section('scripts')

<script>

    const token = getToken();
    const headers = {
        "Authorization": `Bearer ${token}`
    };
	// Get the URL query string
	var queryString = window.location.search;
	var queryParams = new URLSearchParams(queryString);
	var ticketOptionValue = queryParams.has('ticket_option') ? queryParams.get('ticket_option') : null;

    $(document).ready(function() {
        $('#reservation').val(null);
        getMerchantList();
        getCitesList();
        if($('#ticket_type').val() != ''){
             searchByNature();
        }
        // Remove default value from the input field
        // $('#reservation').val('');
    });

    function getMerchantList(){
        $("#merchants").select2({
                placeholder: "Search By Client",
                minimumInputLength: 2, // Minimum characters before sending the AJAX request
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

        $("#zone").select2({
            placeholder: "Select Zone",
            // minimumInputLength: 2, // Minimum characters before sending the AJAX request
            allowClear: true,
            ajax: {
                url: "{{ api_url('get_zones') }}", // Replace with your actual server endpoint
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

        $("#region").select2({
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
    }




    function getCitesList(){

        $("#destination_city_id").select2({
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

    }

    var selected_rows = [];
    var table = $('#datatable').DataTable({
        dom: '<"search-box"f>l  <"col-md-12" <"float-right" B> ><"datatable-wrapper"rt><"datatable-info"i><"datatable-pagination"p>',
        scrollX: true,
        search: {
            return: true
        },
        buttons: [
            {
                text: '<i class="la la-cogs"></i> Create New Ticket',
                className: 'btn btn-primary add',
                action: function (e, dt, node, config) {
                    window.location = '<?php echo url_secure('support_ticket/add') ?>';
                },
                init: function (dt, node, config) {
                    // Add custom data attributes to the button
                    $(node).attr('data-screen-permission-id', "136");
                }
            },
        ],
        select: {
            info: false,
            style: 'multi',
            selector: 'td.select-checkbox',
            className: 'selected bg-primary bg-lighten-5 primary'
        },
        lengthMenu: [[50,500, 1000, 5000, 10000], [50,500, 1000, 5000, 10000]],
        pageLength: 50,
        pagingType: 'full_numbers',
        processing: true,
        language: {
            processing: '<img  src="{{ url_secure('build/images/transpatent_leopard.gif') }}" alt="Loading..."> Loading Data...',
        },
        serverSide: true,
        ajax: {
            url: '<?php echo api_url('support_ticket/new') ?>',
            data: function (d) {
                d.date = $('#reservation').val();
                d.cn_ticket = $('#cn_ticket').val();
                d.status = $('#status').val();
                d.ticket_type = $('#ticket_type').val();
                d.shipper_id = $('#merchants').val();
                d.destination_city = $('#destination_city_id').val();
                d.issue_type = $('#support_ticket_type_id').val();
                d.zone = $('#zone').val();
                d.region = $('#region').val();
                d.client_region = $('#client_region').val();
                d.ajax = 1;
            },
            headers: headers,
        },
        drawCallback: function (xhr, textStatus) {
            setTimeout(delayfunc(),200);
        },
        rowId: 'id',
        order: [[1, 'asc']],
        columns: [
            {data: 'serial_number', orderable: false, searchable: false, name: 'Sr#', class: 'align-middle serial_number', targets: 1, render: function (data, type, row) {return '';} ,download:false},
            {data: 'Id', name: 't.Id', searchable:true ,class: 'align-middle ticket_number',text:'Ticket No' , orderable: true, download:true},
            {data: 'CN', name: 't.CN', class: 'align-middle cn_number',text:'CN#',download:true, orderable: true},
            {data: 'cod_amount', name: 'cod_amount', class: 'align-middle CODAmount',text:'COD Amount',download:true, orderable: true},
            {data: 'client', name: 't.Client_ID', class: 'align-middle client',text:'Client_ID',download:true, orderable: true},
            {data: 'BookingDate', name: 't.BookingDate', class: 'align-middle BookingDate',text:'CN Booking Date', orderable: true, download:true},
            {data: 'DestinationCity', name: 'DestinationCity', class: 'align-middle DestinationCity',text:'Destination City', orderable: true, download:true},
            {data: 'DestinationZone', name: 'DestinationZone', class: 'align-middle DestinationZone',text:'Destination Zone', orderable: true, download:true},
            {data: 'current_status', name: 'current_status', class: 'align-middle current_status',text:'Current Status', orderable: true, download:true},
            {data: 'current_city', name: 'current_city', class: 'align-middle DestinationZone',text:'Current City', orderable: true,download:true},
            {data: 'current_zone', name: 'current_zone', class: 'align-middle DestinationZone',text:'Current Zone', orderable: true,download:true},
            {data: 'defaulterCity', name: 'defaulterCity', class: 'align-middle defaulterCity',text:'defaulter City', orderable: true,download:true},
            {data: 'defaulterZone', name: 'defaulterZone', class: 'align-middle defaulterZone',text:'defaulter Zone', orderable: true,download:true},
            {data: 'Nature', name: 'cn.Nature' , class: 'align-middle ticket_title',text:'Ticket Nature', orderable: true,download:true},
            {data: 'Name', name: 'it.Name' , class: 'align-middle IssueType',text:'Ticket Type', orderable: true,download:true},
            {data: 'Status', name: 'tst.Name', as: 'Status', class: 'align-middle status_title',text:'Ticket Status', orderable: true,download:true},
            {data: 'CreatedOn', name: 't.CreatedOn', class: 'align-middle created_at',text:'Ticket Created Date/Time', orderable: true, download:true},
            {data: 'UpdatedDate', name: 'td.UpdatedDate', class: 'align-middle updated_at',text:'Last Activity Date/Time', orderable: true, download:true},
            {data: 'RemarksBy', name: 'td.RemarksBy', class: 'align-middle RemarksBy',text:'Last Updated By', orderable: true, download:true},
            {data: 'action'  ,class: 'align-middle text-center action', orderable: false, searchable: false,download:false}
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
            var input = '<input type="text" class="form-control form-control-sm input-sm primary">';
            var icon = '<div class="form-control-position primary"><i class="la la-search"></i></div>';
            var drop_select = '<select name="status_select" id="status_select" class="select2 form-control"></select>';
            var rider_status_select = '<select name="rider_status_select" id="rider_status_select" class="select2 form-control"></select>';
            this.api().columns().every(function (column_id) {
                var column = this;
                var header = column.header();

                if ($(header).is('.action') ||
                    $(header).is('.serial_number') ||
                    $(header).is('.select')
                    // $(header).is('.current_status') ||
                    // $(header).is('.CODAmount') ||
                    // $(header).is('.BookingDate')
                ) {
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
                    var current = $(input).appendTo($(search)).on('keyup', function (e) {
                        if (e.type === 'keyup' && e.key !== 'Enter') {
                            return;
                        }
                        column.search($(this).val()).draw();
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
        if(column.download) {
            let col_name = column.name;
            let col_text = column.text;
            if(col_name == 't.Client_ID'){
                col_name = encodeURIComponent(`CONCAT(t.Client_ID," - ",cc.client_name)`);
            }
            if(col_name == 'td.RemarksBy'){
                col_name = encodeURIComponent("CASE WHEN RemarksBy IS NOT NULL THEN RemarksBy ELSE user_users.Name END AS RemarksBy");
            }
            if(column.as){
                col_name+= ' as ' +column.as;
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
            }else{

                var selectedValue = $('#export').val();
                var selectedTexts = $('#export option:selected').map(function () {
                    return $(this).text()
                }).get();

                $.ajax({
                    url: '{{api_url('support_ticket/new/downloadCsv')}}', // Replace with your backend URL
                    type: 'GET',
                    data: {
                        selectedValue: selectedValue,
                        selectedTexts: selectedTexts,
                        excel:true,
                        ajax:1,
                        date : $('#reservation').val(),
                        status : $('#status').val(),
                        ticket_type : $('#ticket_type').val(),
                        shipper_id: $('#merchants').val(),
                        destination_city: $('#destination_city_id').val(),
                        issue_type: $('#support_ticket_type_id').val(),
                        zone:$('#zone').val(),
                        region:$('#region').val(),
                        client_region:$('#client_region').val(),
                    },
                    headers: headers,
                    success: function (response) {
                        console.log(response);
                        // Create a blob from the response
                        var blob = new Blob([response], { type: 'text/csv' });

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

    function search(){
        // var ticketTypeValue =  $('#ticket_type').val(),
        // var status : $('#status').val(),
        table.draw();
    }
    function searchByNature(){
        table.draw();

        $('#support_ticket_type_id').empty();
        var ticket_type = document.getElementById('ticket_type').value;

        $.ajax({
            url: '<?php echo api_url('support_ticket/getIssueType'); ?>',
            method: 'GET',
            data:{ ajax: true,ticket_type: ticket_type},
            dataType: 'json', // Set the expected data type to JSON
            headers: headers,
            beforeSend: function(){
                $('.error-container').html('');
            },
            success: function(data) {
                if (data && data.status == 1) {
                   // Assuming #support_ticket_type_id is the ID of your select element
                    var data2 = "<option value='0'>Select Issue Type</option>";
                    $.each(data.data, function(index, item) {
                        if(ticketOptionValue){
                            var select = (item.Id == ticketOptionValue) ? 'selected' : '';
                        }

                        data2+= `<option ${select} value='${item.Id}'>${item.Name}</option>`
                    });

                    $('#support_ticket_type_id').append(data2).trigger('change');
                } else {
                    if(data && data.status == 0){
                        Swal.fire(
                            'Error!',
                            data.error,
                            'error'
                        );
                        document.getElementById("booking-data").style.display = "none";
                        // var errors = (data.errors) ? data.errors : {};
                        // $('.error-container').html(errors);
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

    $( "body" ).delegate( ".applyBtn", "click", function() {
        table.draw();
    })


</script>

@endsection

