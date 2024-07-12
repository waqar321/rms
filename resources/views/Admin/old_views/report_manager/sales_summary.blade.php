@extends('Admin.layout.main')

@section('styles')
<style>
    .datatable-wrapper {
        overflow-x: scroll;
    }
    .date-note {
        font-weight: 600;
    }
    .smart-search-bar{
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

@section('title') Sales Summary Report @endsection

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
                            <h2> Sales Summary Report</h2>
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
                                    <label>Search By Date</label>

                                    <fieldset>
                                        <div class="control-group">
                                            <div class="controls">
                                                <div class="input-prepend input-group">
                                                        <span class="add-on input-group-addon"><i
                                                                    class="fa fa-calendar"></i></span>
                                                    <input type="text" name="reservation"
                                                        id="reservation" class="form-control"
                                                        value="">
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
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
                                    <label>Search By Clients</label>
                                    <select class="form-control select2" onchange="search()" name="merchant_id" id="merchant_id" multiple="multiple">
                                        <option value="">View All</option>
                                    </select>
                                </div>

                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <label>Search By Client City</label>
                                        <select class="form-control select2" name="city_id" id="city_id" onchange="search()">
                                            <option value="">View All</option>
                                        </select>
                                </div>

                                <div class="col-md-4 col-sm-4 col-xs-12" data-screen-permission-id="211">
                                    <label>Search By Sales Person</label>
                                    <select class="form-control select2" onchange="search()" name="sale_person" id="sale_person">
                                        <option value="">View All</option>
                                    </select>
                                </div>


                            </div>

                        </div>
                        <div class="x_content">
                            <form method="POST" enctype="multipart/form-data" action="#" id="export-csv" data-screen-permission-id="162">
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
                            <p class="text-muted font-13 m-b-30">
                              This report will use for extract sales data with respect to clients and their bookings
                            </p>
                            <div id="datatable-div">
                                <table id="datatable" class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th>SR#</th>
                                        <th>Client Name</th>
                                        <th>Sales Person</th>
                                        <th>No. Of Bookings</th>
                                        <th>COD Amount</th>
                                        <th>Packet Charges</th>
                                        <th>Cash Handling Charges</th>
                                        <th>Return Charges</th>
                                        <th>Vendor Pickup Charges</th>
                                        <th>Packing Charges</th>
                                        <th>Total Charges</th>
                                        <th>Discount %</th>
                                        <th>Discount Amount</th>
                                        <th>Net Charges</th>
                                        <th>Fuel %</th>
                                        <th>Fuel Charges</th>
                                        <th>Total Amount</th>
                                        <th>GST %</th>
                                        <th>GST Amount</th>
                                        <th>Total Sale</th>
                                        <th>Station</th>
                                    </tr>
                                    </thead>
                                </table>
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

    $(document).ready(function() {
        getMerchantList();
        getCitiesList();
        $('#reservation').val('');
    });

    function getMerchantList(){

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

        $("#merchant_id").select2({
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

        $("#sale_person").select2({
            placeholder: "Search By Sales Person",
            minimumInputLength: 2, // Minimum characters before sending the AJAX request
            allowClear: true,
            ajax: {
                url: "{{ api_url('sales_persons') }}", // Replace with your actual server endpoint
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

    function getCitiesList(){
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
    }

    var selected_rows = [];
    var table = $('#datatable').DataTable({
        dom: '<"search-box"f>l  <"" <"text-center" B> ><"datatable-wrapper"rt><"datatable-info"i><"datatable-pagination"p>',
        search: {
            return: true
        },
        buttons: [
            // {
            //     text: 'Smart Search Bar',
            //     className: 'smart-search-bar',
            // },
        ],
        select: {
            info: false,
            style: 'multi',
            selector: 'td.select-checkbox',
            className: 'selected bg-primary bg-lighten-5 primary'
        },
        lengthMenu: [[50,500, 1000, 5000, 10000, -1], [50,500, 1000, 5000, 10000, 'All']],
        pageLength: 50,
        pagingType: 'full_numbers',
        processing: true,
        language: {
            processing: '<img  src="{{ url_secure('build/images/transpatent_leopard.gif') }}" alt="Loading..."> Loading Data...',
        },
        serverSide: true,
        ajax: {
            url: '<?php echo api_url('report_manager/sales_summary') ?>',
            data: function (d) {
                d.ajax=1;
                d.date = $('#reservation').val();
                d.city_id = $('#city_id').val();
                d.merchant_id = $('#merchant_id').val();
                d.client_region = $('#client_region').val();
                d.sale_person = $('#sale_person').val();
            },
            headers:headers
        },
        rowId: 'serial_number',
        order: [[0, 'desc']],
        columns: [
            {data: 'serial_number', orderable: false, searchable: false, name: 'serial_number', class: 'align-middle serial_number', targets: 1, render: function (data, type, row) {return '';} ,download:false},
            {data: 'client_name', name: 'client_name', class: 'align-middle client_name',text:'Client Name' ,download:true},
            {data: 'sales_person', name: 'sales_person', class: 'align-middle sales_person',text:'Sales Person',download:true},
            {data: 'bookings', name: 'bookings', class: 'align-middle bookings',text:'Bookings',download:true},
            {data: 'cod_amount', name: 'cod_amount', class: 'align-middle cod_amount',text:'COD Amount',download:true,
                "render": function (data, type, row) {
                    if(!data || data === 0){
                        data = 0;
                        return data;
                    }else{
                        return Math.round(parseFloat(data)).toLocaleString('en-IN');
                    }
                }
            },
            {data: 'packet_charges', name: 'packet_charges', class: 'align-middle packet_charges',text:'Packet Charges',download:true,
                "render": function (data, type, row) {
                    if(!data || data === 0){
                        data = 0;
                        return data;
                    }else{
                        return Math.round(parseFloat(data)).toLocaleString('en-IN');
                    }
                }
            },
            {data: 'cash_handling_charges', name: 'cash_handling_charges', class: 'align-middle cash_handling_charges',text:'Cash Handling Charges',download:true,
                "render": function (data, type, row) {
                    if(!data || data === 0){
                        data = 0;
                        return data;
                    }else{
                        return Math.round(parseFloat(data)).toLocaleString('en-IN');
                    }
                }
            },
            {data: 'return_charges', name: 'return_charges', class: 'align-middle return_charges',text:'Return Charges',download:true,
                "render": function (data, type, row) {
                    if(!data || data === 0){
                        data = 0;
                        return data;
                    }else{
                        return Math.round(parseFloat(data)).toLocaleString('en-IN');
                    }
                }
            },
            {data: 'vpc_charges', name: 'vpc_charges', class: 'align-middle vpc_charges',text:'VPC Charges',download:true,
                "render": function (data, type, row) {
                    if(!data || data === 0){
                        data = 0;
                        return data;
                    }else{
                        return Math.round(parseFloat(data)).toLocaleString('en-IN');
                    }
                }
            },
            {data: 'MaterialValue', name: 'MaterialValue', class: 'align-middle MaterialValue',text:'MaterialValue',download:true,
                "render": function (data, type, row) {
                    if(!data || data === 0){
                        data = 0;
                        return data;
                    }else{
                        return Math.round(parseFloat(data)).toLocaleString('en-IN');
                    }
                }
            },
            {data: 'total_charges', name: 'total_charges', class: 'align-middle total_charges',text:'Total Charges',download:true,
                "render": function (data, type, row) {
                    if(!data || data === 0){
                        data = 0;
                        return data;
                    }else{
                        return Math.round(parseFloat(data)).toLocaleString('en-IN');
                    }
                }
            },
            {data: 'discount', name: 'discount', class: 'align-middle discount',text:'Discount %',download:true,
                "render": function (data, type, row) {
                    if(!data || data === 0){
                        data = 0;
                        return data;
                    }else{
                        return Math.round(parseFloat(data)).toLocaleString('en-IN');
                    }
                }
            },
            {data: 'discount_charges', name: 'discount_charges', class: 'align-middle discount_charges',text:'Discount Amount',download:true,
                "render": function (data, type, row) {
                    if(!data || data === 0){
                        data = 0;
                        return data;
                    }else{
                        return Math.round(parseFloat(data)).toLocaleString('en-IN');
                    }
                }
            },
            {data: 'net_charges', name: 'net_charges', class: 'align-middle net_charges',text:'Net Charges',download:true,
                "render": function (data, type, row) {
                    if(!data || data === 0){
                        data = 0;
                        return data;
                    }else{
                        return Math.round(parseFloat(data)).toLocaleString('en-IN');
                    }
                }
            },
            {data: 'fuel', name: 'fuel', class: 'align-middle fuel',text:'Fuel',download:true,
                "render": function (data, type, row) {
                    if(!data || data === 0){
                        data = 0;
                        return data;
                    }else{
                        return Math.round(parseFloat(data)).toLocaleString('en-IN');
                    }
                }
            },
            {data: 'fuel_charges', name: 'fuel_charges', class: 'align-middle fuel_charges',text:'Fuel charges',download:true,
                "render": function (data, type, row) {
                    if(!data || data === 0){
                        data = 0;
                        return data;
                    }else{
                        return Math.round(parseFloat(data)).toLocaleString('en-IN');
                    }
                }
            },
            {data: 'total_amount', name: 'total_amount', class: 'align-middle total_amount',text:'Total Amount',download:true,
                "render": function (data, type, row) {
                    if(!data || data === 0){
                        data = 0;
                        return data;
                    }else{
                        return Math.round(parseFloat(data)).toLocaleString('en-IN');
                    }
                }
            },

            {data: 'gst', name: 'gst', class: 'align-middle gst',text:'GST',download:true,
                "render": function (data, type, row) {
                    if(!data || data === 0){
                        data = 0;
                        return data;
                    }else{
                        return Math.round(parseFloat(data)).toLocaleString('en-IN');
                    }
                }
            },

            {data: 'gst_amount', name: 'gst_amount', class: 'align-middle gst_amount',text:'GST Amount',download:true,
                "render": function (data, type, row) {
                    if(!data || data === 0){
                        data = 0;
                        return data;
                    }else{
                        return Math.round(parseFloat(data)).toLocaleString('en-IN');
                    }

                }
            },
            {data: 'total_sale', name: 'total_sale', class: 'align-middle total_sale',text:'Total Sale',download:true,
                "render": function (data, type, row) {
                    if(!data || data === 0){
                        data = 0;
                        return data;
                    }else{
                        return Math.round(parseFloat(data)).toLocaleString('en-IN');
                    }

                }
            },
            {data: 'station_id', name: 'station_id', class: 'align-middle station_id',text:'Station ID',download:true}
        ],
        //	Sr #	Sys ID#	Page Order	Page Name	Pages Body	Date Created	Actions
        rowCallback: function (row, data, index) {
            var info = table.page.info();
            var discount_charges = 0;

            // Parse data values to ensure they are numbers
            var packet_charges = parseFloat(data.packet_charges) || 0;
            var cash_handling_charges = parseFloat(data.cash_handling_charges) || 0;
            var vpc_charges = parseFloat(data.vpc_charges) || 0;
            var return_charges = parseFloat(data.return_charges) || 0;
            var fuel = parseFloat(data.fuel) || 0;
            var gst = parseFloat(data.gst) || 0;
            var packing_charges = parseFloat(data.MaterialValue) || 0;
            var discount = parseFloat(data.discount) || 0;

            var total_charges = packet_charges + cash_handling_charges + vpc_charges + return_charges+packing_charges;
            $('td:eq(10)', row).html(total_charges.toLocaleString('en-IN'));

            $('td:eq(11)', row).html(discount.toLocaleString('en-IN'));

            if (!isNaN(discount) && discount > 0) {
                discount_charges = (total_charges * discount) / 100;
            } else {
                discount_charges = 0;
            }
            $('td:eq(12)', row).html(discount_charges.toLocaleString('en-IN'));

            var net_charges = total_charges - discount_charges;
            $('td:eq(13)', row).html(net_charges.toLocaleString('en-IN'));

            var fuel_charges = net_charges*fuel/100;
            $('td:eq(15)', row).html(fuel_charges.toLocaleString('en-IN'));

            var total_amount = net_charges + fuel_charges;
            $('td:eq(16)', row).html(total_amount.toLocaleString('en-IN'));

            $('td:eq(17)', row).html(gst.toLocaleString('en-IN'));

            var gst_amount = (total_amount * gst) / 100;
            $('td:eq(18)', row).html(gst_amount.toLocaleString('en-IN'));

            var total_sale = total_amount + gst_amount;
            $('td:eq(19)', row).html(total_sale.toLocaleString('en-IN'));

            if ($.inArray(data.id, selected_rows) !== -1) {
                table.row(row).select();
            }
        },
        initComplete: function () {
            var search = $('<tr role="row" class="bg-lighten-1 search"></tr>').appendTo(this.api().table().header());

            var td = '<td style="padding:5px;" class="border-lighten-2"><fieldset class="form-group m-0 position-relative has-icon-right"></fieldset></td>';
            // var input = '<input type="text" class="form-control form-control-sm input-sm mb-0">';
            var icon = '<div class="form-control-position primary"><i class="la la-search"></i></div>';
            var drop_select = '<select name="status_select" id="status_select" class="select2 form-control"></select>';
            var rider_status_select = '<select name="rider_status_select" id="rider_status_select" class="select2 form-control"></select>';
            this.api().columns().every(function (column_id) {
                var column = this;
                var header = column.header();

                if ($(header).is('.action') ||  $(header).is('.serial_number') ||  $(header).is('.select') ||  $(header).is('.status')) {
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
                    // var current = $(input).appendTo($(search)).on('change keyup', function () {
                    //     column.search($(this).val(), false, false, true).draw();
                    // }).wrap(td).after(icon);

                    // if (column.search()) {
                    //     current.val(column.search());
                    // }
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
                    url: '<?php  echo api_url('report_manager/sales_summary/downloadCsv')  ?>', // Replace with your backend URL
                    type: 'GET',
                    data: {
                        selectedValue: selectedValue,
                        selectedTexts: selectedTexts,
                        excel:true,
                        ajax:1,
                        date:$('#reservation').val(),
                        city_id:$('#city_id').val(),
                        merchant_id:$('#merchant_id').val(),
                        client_region:$('#client_region').val(),
                        sale_person: $('#sale_person').val(),
                    },
                    headers: headers,
                    success: function (response) {
                        // Create a blob from the response
                        var blob = new Blob([response], { type: 'text/csv' });

                        // Create a temporary URL for the blob
                        var url = window.URL.createObjectURL(blob);

                        // Create a hidden anchor link and set its attributes
                        var a = document.createElement('a');
                        a.href = url;
                        a.download = 'sales_summary_report_' + new Date().toISOString().slice(0, 10) + '.csv';

                        // Append the anchor link to the document
                        document.body.appendChild(a);

                        // Programmatically click the anchor link to trigger the download
                        a.click();

                        // Remove the temporary URL and the anchor link
                        window.URL.revokeObjectURL(url);
                        a.remove();
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

    $( "body" ).delegate( ".applyBtn", "click", function() {
        table.draw();
    })

</script>

<script src="{{ url_secure('build/js/main.js')}}"></script>
@endsection

