@extends('Admin.layout.main')

@section('styles')@endsection

@section('title') Material Assignment Listing @endsection

@section('content')
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Manage Material Assignment</h3>
            </div>
        </div>
        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2> Listing </h2>
                        <ul class="nav navbar-right panel_toolbox justify-content-end">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="col-md-12">

                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <label>Date</label>
                            <div class="input-prepend input-group">
                                    <span class="add-on input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                <input type="text" name="reservation" id="reservation" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <label>Status</label>
                            <select class="form-control select2" onchange="search()" name="status" id="status">
                                <option value="2">All</option>
                                <option value="1">Amount Collected</option>
                                <option value="0">Amount Not Collected</option>
                            </select>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <label>City</label>
                            <select class="form-control select2" name="city_id" id="city_id" onchange="getClientByCity()">
                            </select>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <label>Client</label>
                            <select class="form-control select2" name="merchant_id" id="merchant_id" onchange="search()">
                            </select>
                        </div>
                    </div>

                    <div class="x_content">
                        <form method="POST" enctype="multipart/form-data" action="#" id="export-csv" data-screen-permission-id="88">
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
                                <th>Sr #</th>
                                <th>System ID#</th>
                                <th>Batch ID#</th>
                                <th>Client</th>
                                <th>Material Name</th>
                                <th>Quantity</th>
                                <th>Material Rate</th>
                                <th>Material Charges</th>
                                <th>Status</th>
                                <th>Date Created</th>
                                <th>Flyer Range</th>
                                <th>Invoice Number</th>
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
    <script src="{{ url_secure('build/js/main.js')}}"></script>
<script>
    const token = getToken();
    const headers = {
        "Authorization": `Bearer ${token}`,
    };
    var selected_rows = [];
    var table = $('#datatable').DataTable({
        dom: '<"search-box"f>l  <"" <"float-right" B> ><"datatable-wrapper"rt><"datatable-info"i><"datatable-pagination"p>',
        search: {
            return: true
        },
        buttons: [
            {
                text: '<i class="la la-cogs"></i> Add Material Assignment',
                className: 'btn btn-primary btn-sm add',
                action: function (e, dt, node, config) {
                    window.location = '<?php echo url_secure('manage_client/material/assignment/add') ?>';
                },
                init: function (dt, node, config) {
                    // Add custom data attributes to the button
                    $(node).attr('data-screen-permission-id', "85");
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
            url: '<?php echo api_url('manage_client/material/assignment') ?>',
            data: function (d) {
                d.ajax=1;
                d.date = $('#reservation').val();
                d.status = $('#status').val();
                d.City = $('#city_id').val();
                d.client = $('#merchant_id').val();
            },
            headers: headers,
        },
        drawCallback: function (xhr, textStatus) {
            setTimeout(delayfunc(),200);
        },
        rowId: 'id',
        order: [[1, 'desc']],
        columns: [
            {data: 'serial_number', orderable: false, searchable: false, name: 'serial_number', class: 'align-middle serial_number', targets: 1, render: function (data, type, row) {return '';} ,download:false},
            {data: 'id', name: 'ecom_material_assignment.id', class: 'align-middle id',text:'Sys ID#' ,download:true},
            {data: 'batch_id', name: 'ecom_material_assignment.batch_id', class: 'align-middle batch_id',text:'Batch ID#' ,download:true},
            {data: 'merchant_name', name: 'ecom_merchant.merchant_name', class: 'align-middle merchant_name',text:'Merchant Name',download:true},
            {data: 'material_name', name: 'ecom_material.material_name', class: 'align-middle material_name',text:'Material Name',download:true},
            {data: 'material_quantity', name: 'ecom_material_assignment.material_quantity', class: 'align-middle material_quantity',text:'Material Quantity',download:true},
            {data: 'material_value', name: 'ecom_merchant_material.material_value', class: 'align-middle material_value',text:'Material Value',download:true},
            {data: 'material_charges', name: 'material_charges', class: 'align-middle material_charges',text:'material_charges',download:false},
            {data: 'status', name: 'ecom_material_assignment.is_paid', class: 'align-middle status',text:'Status',download:true},
            {data: 'created_at', name: 'ecom_material_assignment.created_at', class: 'align-middle created_at',text:'Created At',download:true},
            {data: 'flayer_range', name: 'ecom_material_assignment.flyer_range_from', class: 'align-middle flayer_range',text:'Flyer Range',download:true,searchable:false},
            {data: 'invoice_cheque_no', name: 'ecom_invoice.invoice_cheque_no', class: 'align-middle invoice_cheque_no',text:'Invoice Number',download:true,searchable:false},
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
            var input = '<input type="text" class="form-control form-control-sm input-sm mb-0">';
            var icon = '<div class="form-control-position primary"><i class="la la-search"></i></div>';
            var drop_select = '<select name="status_select" id="status_select" class="select2 form-control"></select>';
            var rider_status_select = '<select name="rider_status_select" id="rider_status_select" class="select2 form-control"></select>';
            this.api().columns().every(function (column_id) {
                var column = this;
                var header = column.header();

                if ($(header).is('.action') ||  $(header).is('.serial_number') ||  $(header).is('.select') || $(header).is('.flayer_range')) {
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
            if (col_name && col_text) {
                option += `<option value="${col_name}">${col_text}</option>`;
            }
        }
    });

    function search() {
        table.draw();
    }

    $("body").delegate(".applyBtn", "click", function () {
        table.draw();
    })

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
                    url: '<?php  echo api_url('manage_client/material/assignment/downloadCsv')  ?>', // Replace with your backend URL
                    type: 'GET',
                    data: {
                        selectedValue: selectedValue,
                        selectedTexts: selectedTexts,
                        excel: true,
                        ajax: 1,
                        date: $('#reservation').val(),
                        status: $('#status').val(),
                        City: $('#city_id').val(),
                        client: $('#merchant_id').val(),
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
    });

    $(document).ready(function () {
        $('#reservation').val('');
        $("#city_id").select2({
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
        $("#merchant_id").select2({
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

    function getClientByCity(){
        $("#merchant_id").select2({
            placeholder: "Search By Client",
            minimumInputLength: 2, // Minimum characters before sending the AJAX request
            allowClear: true,
            ajax: {
                url: "{{ api_url('clients_list') }}?city_id="+$('#city_id').val(), // Replace with your actual server endpoint
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
</script>
@endsection

