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
                                        <input type="text" name="reservation" id="reservation" class="form-control" value="{{ (isset($request_data['date'])) ? $request_data['date'] : '' }}">
                                    </div>
                                </div>

                            </div>

                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <label>Search By Shippers (Clients)</label>
                                <select class="form-control select2" onchange="search()" name="merchants" id="merchants">
                                    <option value="">View All</option>
                                </select>
                            </div>

                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <label>Ticket Status</label>
                                    <select class="form-control select2" name="status" id="status" onchange="search()">
                                        <option value="" disabled selected>1</option>
                                        <option value="0">View All</option>
                                        <?php
                                        foreach($ticketStatuses as $status){
                                            $selected="";
                                            $selectedstatus = (isset($request_data['status']))?$request_data['status']:'';
                                            if(!empty($selectedstatus)){
                                                if((int)$selectedstatus == $status['id']){
                                                    $selected = "selected";
                                                }
                                            }
                                        ?>
                                        <option value="<?php echo $status['id']; ?>" <?php echo $selected ?> ><?php echo $status['title']; ?></option>
                                        <?php } ?>
                                    </select>
                            </div>


                        </div>

                        <div class="col-md-12">

                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <label>Nature Type</label>
                                <select class="form-control select2" onchange="searchByNature()" name="ticket_type" id="ticket_type">
                                    <option value="" disabled selected>Nature Type</option>
                                    <?php
                                    foreach($ticketTypes as $type){
                                        $selected="";
                                        $selectednature = (isset($request_data['ticket_type']))?$request_data['ticket_type']:'';
                                        if(!empty($selectednature)){
                                            if((int)$selectednature == $type['id']){
                                                $selected = "selected";
                                            }
                                        }
                                    ?>
                                    <option value="<?php echo $type['id']; ?>" <?php echo $selected ?> ><?php echo $type['title']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <label>Ticket Type Option</label>
                                <select class="form-control select2" id="support_ticket_type_id" onchange="search()"></select>
                            </div>

                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <label>Destination City</label>
                                <select class="form-control select2" id="destination_city_id" onchange="search()"></select>
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
                                    <th>Ticket No</th>
                                    <th>CN #</th>
                                    <th>CN Booking Date</th>
                                    <th>Destination</th>
                                    <th>Ticket Nature</th>
                                    <th>Ticket Type</th>
                                    <th>Ticket Status</th>
                                    <th>Ticket Created Date/Time</th>
                                    <th>Last Activity Date/Time</th>
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
            url: '<?php echo api_url('support_ticket') ?>',
            data: function (d) {
                d.date = $('#reservation').val();
                d.status = $('#status').val();
                d.ticket_type = $('#ticket_type').val();
                d.shipper_id = $('#merchants').val();
                d.destination_city = $('#destination_city_id').val();
                d.issue_type = $('#support_ticket_type_id').val();
                d.ajax = 1;
            },
            headers: headers,
        },
        drawCallback: function (xhr, textStatus) {
            setTimeout(delayfunc(),200);
        },
        rowId: 'id',
        order: [[5, 'desc']],
        // columns: [
        //     {data: 'serial_number', orderable: false, searchable: false, name: 'serial_number', class: 'align-middle serial_number', targets: 1, render: function (data, type, row) {return '';} ,download:false},
        //     {data: 'TicketID', name: 'TicketID', searchable:true ,class: 'align-middle ticket_number',text:'Ticket Number#' ,download:true},
        //     {data: 'CN', name: 'CN', class: 'align-middle cn_number',text:'CN #',download:true},
        //     {data: 'RequestNature', name: 'RequestNature' , class: 'align-middle ticket_title',text:'Ticket Type',download:true},
        //     {data: 'IssueType', name: 'IssueType' , class: 'align-middle IssueType',text:'IssueType',download:true},
        //     {data: 'CurrentStatus', name: 'CurrentStatus', class: 'align-middle status_title',text:'Status',download:true},
        //     {data: 'Origin', name: 'Origin', class: 'align-middle Origin',text:'Origin',download:true},
        //     {data: 'Destination', name: 'Destination' , as : 'Destination' , class: 'align-middle status_title',text:'Destination',download:true},
        //     {data: 'DefaulterCity', name: 'DefaulterCity' , as : 'DefaulterCity' , class: 'align-middle status_title',text:'Defaulter City',download:true},
        //     {data: 'Shipper', name: 'Shipper', class: 'align-middle Shipper',text:'Shipper',download:true},
        //     {data: 'ConsigneeContact', name: 'ConsigneeContact', class: 'align-middle ConsigneeContact',text:'ConsigneeContact',download:true},
        //     {data: 'CreatedOn', name: 'CreatedOn', class: 'align-middle created_at',text:'Date Created',download:true},
        //     {data: 'LastUpdatedOn', name: 'LastUpdatedOn', class: 'align-middle updated_at',text:'Date Updated',download:true},
        //     {data: 'action'  ,class: 'align-middle text-center action', orderable: false, searchable: false,download:false}
        // ],
        columns: [
            {data: 'serial_number', orderable: false, searchable: false, name: 'Sr#', class: 'align-middle serial_number', targets: 1, render: function (data, type, row) {return '';} ,download:false},
            {data: 'TicketID', name: 'TicketID', searchable:true ,class: 'align-middle ticket_number',text:'Ticket No' ,download:true},
            {data: 'CN', name: 'CN', class: 'align-middle cn_number',text:'CN#',download:true},
            {data: 'BookingDate', name: 'BookingDate', class: 'align-middle BookingDate',text:'CN Booking Date',download:true},
            {data: 'Destination', name: 'Destination', class: 'align-middle Destination',text:'Destination',download:true},
            {data: 'RequestNature', name: 'RequestNature' , class: 'align-middle ticket_title',text:'Ticket Nature',download:true},
            {data: 'IssueType', name: 'IssueType' , class: 'align-middle IssueType',text:'Ticket Type',download:true},
            {data: 'CurrentStatus', name: 'CurrentStatus', class: 'align-middle status_title',text:'Ticket Status',download:true},
            {data: 'CreatedOn', name: 'CreatedOn', class: 'align-middle created_at',text:'Ticket Created Date/Time',download:true},
            {data: 'LastUpdatedOn', name: 'LastUpdatedOn', class: 'align-middle updated_at',text:'Last Activity Date/Time',download:true},
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

                if ($(header).is('.action') ||  $(header).is('.serial_number') ||  $(header).is('.select')) {
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
        if(column.download) {
            let col_name = column.name;
            let col_text = column.text;
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
                    url: '{{api_url('support_ticket/downloadCsv')}}', // Replace with your backend URL
                    type: 'GET',
                    data: {
                        selectedValue: selectedValue,
                        selectedTexts: selectedTexts,
                        excel:true,
                        ajax:1,
                        date : $('#reservation').val(),
                        status : $('#status').val(),
                        ticket_type : $('#ticket_type').val()
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
                    var data2 = "";
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

