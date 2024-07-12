@extends('Admin.layout.main')
@section('title') Manage Invoices @endsection
@section('styles')
    <style>
        .x_title {
             margin-bottom: 13px;
        }
        .print_invoice {
            background: transparent;
            border: transparent;
            padding: 0;
            color: #5a738e;
        }
    </style>
@endsection

@section('content')
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
                <div class="title_left">
                    <h3>Manage Invoices</h3>
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

                    <div class="col-md-12">
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

                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <label>Search By Clients</label>
                            <select class="form-control select2" onchange="search()" name="merchant_id" id="merchant_id">
                                <option value="">View All</option>
                            </select>
                        </div>

                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <label>Search By Client City</label>
                                <select class="form-control select2" name="city_id" id="city_id" onchange="search()">
                                    <option value="">View All</option>
                                </select>
                        </div>

                    </div>
                    <div class="col-md-12">
                    <div class="col-md-4 col-sm-4 col-xs-12">
                            <label>Search By Payment Method</label>
                                <select class="form-control select2" onchange="search()" name="payment_method_id" id="payment_method_id">
                                    <option value="">View All</option>
                                </select>
                        </div>

                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <label>Search By Payment Status</label>
                                <select class="form-control select2" onchange="search()" name="payment_status_id" id="payment_status_id">
                                    <option value="">View All</option>
                                </select>
                        </div>
                    </div>

                    <div class="clearfix"></div>

                    <div class="x_content">
                        <form method="POST" enctype="multipart/form-data" action="#" id="export-csv" data-screen-permission-id="138">
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
                        <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr role="row">
                                    <th style="width:5%"></th>
                                    <th>Sr#</th>
                                    <th>System ID</th>
                                    <th>City</th>
                                    <th>Date Created</th>
                                    <th>Invoice No.</th>
                                    <th>Client Name</th>
                                    <th>Payee Name</th>
                                    <th>Invoice Amount</th>
                                    <th>Bank Name</th>
                                    <th>Payment Method</th>
                                    <th>Status</th>
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

<div class="modal fade in" id="download-invoice-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body" style="max-height: 400px;overflow: auto;">
                <div class="row">
                    <div class="col-md-6 text-center">
                        <div class="h1-border-bottom">Print Invoice Summary</div>
                    </div>
                    <div class="col-md-6 text-center">
                        <div class="h1-border-bottom">Print Invoice Detail</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 text-center" style="border-right: 1px solid #c2cad8;">
                        <div>
                            <img src="images/print.png">
                        </div>
                        <div>
                            <button data-type="summary" class="print_invoice invoiceId">Print</button> | <a target="_blank" data-initial-href="manage_cheque/invoice/summary/PDF/" href="manage_cheque/invoice/summary/PDF/" class="print_summary invoiceId">PDF</a> | <a target="_blank" data-initial-href="manage_cheque/invoice/summary/Excel/" href="manage_cheque/invoice/summary/Excel/" class="excel_invoice invoiceId">Excel</a>
                        </div>
                    </div>
                    <div class="col-md-6 text-center">
                        <div>
                            <img src="images/print.png">
                        </div>
                        <div>
                            <button data-type="details" class="print_invoice invoiceId">Print</button> | <a target="_blank" data-initial-href="manage_cheque/invoice/detail/PDF/" href="manage_cheque/invoice/detail/PDF/" class="print_summary invoiceId">PDF</a> | <a target="_blank" data-initial-href="manage_cheque/invoice/detail/Excel/" href="manage_cheque/invoice/detail/Excel/" class="excel_invoice invoiceId">Excel</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade in" id="status-update-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body" style="max-height: 400px;overflow: auto;">
                <div class="row">
                    <div class="col-md-12">
                        <label class="control-label col-md-12 col-sm-12 col-xs-12">Please Select Status</label>
                        <select class="form-control" id="payment_change_status" onchange="updateStatus()">
                            <option selected disabled>Please Select Option</option>
                        </select>
                        <input type="hidden" id="invoice-ids">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!-- /page content -->
@endsection

@section('scripts')

<script>

    const token = getToken();
    const headers = {
        "Authorization": `Bearer ${token}`
    };

    $(document).ready(function() {

        getMerchantList();
        getCitiesList();
        getPaymentMethodList();
        getPaymentStatusList();
        // Remove default value from the input field
        $('#reservation').val('');
    });

    function getMerchantList(){

        $("#merchant_id").select2({
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

    function getCitiesList(){
        $("#city_id").select2({
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
    }

    function getPaymentMethodList(){
        $.ajax({
            url: '<?php echo api_url('get_payment_method'); ?>',
            method: 'GET',
            data:{ ajax: true},
            headers: headers,
            dataType: 'json', // Set the expected data type to JSON
            beforeSend: function(){
                $('.error-container').html('');
            },
            success: function(data) {
                if (data) {
                    $.each(data.data, function(index, item) {
                        $('#payment_method_id').append($('<option>', {
                            value: item.id,
                            text: item.payment_method_name
                        }));
                    });

                } else {
                    if(data && data.status == 0){
                        Swal.fire(
                            'Error!',
                            data.error,
                            'error'
                        );
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

    function getPaymentStatusList(){
        $.ajax({
            url: '<?php echo api_url('get_payment_status'); ?>',
            method: 'GET',
            data:{ ajax: true},
            headers: headers,
            dataType: 'json', // Set the expected data type to JSON
            beforeSend: function(){
                $('.error-container').html('');
            },
            success: function(data) {
                if (data) {
                    $.each(data.data, function(index, item) {
                        $('#payment_status_id').append($('<option>', {
                            value: item.id,
                            text: item.pay_status_name
                        }));
                        $('#payment_change_status').append($('<option>', {
                            value: item.id,
                            text: item.pay_status_name
                        }));
                    });

                } else {
                    if(data && data.status == 0){
                        Swal.fire(
                            'Error!',
                            data.error,
                            'error'
                        );
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

    var selected_rows = [];
    var table = $('#datatable').DataTable({
        dom: '<"search-box"f>l  <"col-md-12" <"float-right" B> ><"datatable-wrapper"rt><"datatable-info"i><"datatable-pagination"p>',
        scrollX: true,
        search: {
            return: true
        },
        buttons: [
            {
                extend: 'selectAll',
                text: 'Select All',
                className: 'btn btn-primary btn-sm select_all add',
                action : function(e) {
                    e.preventDefault();
                    selected_rows = [];
                    table.rows().nodes().each(function(index) {
                        var row = table.row(index);
                        if ($(row.node().firstChild).hasClass('select-checkbox') && !$(row.node()).hasClass('selected')) {
                            id = parseInt(row.id());
                            var allow = true;
                            if (allow) {
                                row.select();

                                var index = $.inArray(id, selected_rows);

                                if (index === -1) {
                                    selected_rows.push(id);
                                }
                            }
                        }
                    });
                }
            },
            {
                extend: 'selectNone',
                text: 'Select None',
                className: 'btn btn-primary btn-sm select_none add',
                action : function(e) {
                    e.preventDefault();

                    table.rows().nodes().each(function(index) {
                        var row = table.row(index);

                        if ($(row.node().firstChild).hasClass('select-checkbox') && $(row.node()).hasClass('selected')) {
                            row.deselect();

                            id = parseInt(row.id());

                            var index = $.inArray(id, selected_rows);

                            if (index !== -1) {
                                selected_rows.splice(index, 1);
                            }

                            if (selected_rows.length == 0) {

                            }
                        }
                    });
                }
            },
            {
                text: '<i class="la la-cogs"></i> Generate Summary',
                className: 'btn btn-primary btn-sm chq-summary',
                action: function (e, dt, node, config) {
                    chq_summary(selected_rows);
                },
                init: function (dt, node, config) {
                    // Add custom data attributes to the button
                    $(node).attr('data-screen-permission-id', "140");
                }
            },
            {
                text: '<i class="la la-cogs"></i> Change Status',
                className: 'btn btn-primary btn-sm chq-summary',
                action: function (e, dt, node, config) {
                    change_status(selected_rows);
                },
                init: function (dt, node, config) {
                    // Add custom data attributes to the button
                    $(node).attr('data-screen-permission-id', "141");
                }
            },
            {
                text: '<i class="la la-cogs"></i> Make New Invoice',
                className: 'btn btn-primary btn-sm add',
                action: function (e, dt, node, config) {
                    window.location = '<?php echo url_secure('manage_cheque/add') ?>';
                },
                init: function (dt, node, config) {
                    // Add custom data attributes to the button
                    $(node).attr('data-screen-permission-id', "142");
                }
            },

        ],
        select: {
            info: false,
            style: 'multi',
            selector: 'td.select-checkbox',
            className: 'selected'
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
            url: '<?php echo api_url('manage_cheque') ?>',
            data: function (d) {
                d.date = $('#reservation').val();
                d.city_id = $('#city_id').val();
                d.payment_status_id = $('#payment_status_id').val();
                d.payment_method_id = $('#payment_method_id').val();
                d.merchant_id = $('#merchant_id').val();
                d.ajax = 1;
            },
            headers:headers,
        },
        drawCallback: function (xhr, textStatus) {
            setTimeout(delayfunc(),200);
        },
        rowId: 'id',
        order: [[2, 'desc']],
        columns: [
            {data: 'id', orderable: false, searchable: false, class: 'text-center align-middle select p-1', targets: 0, render: function (data, type, row) {return '';} ,download:false},
            {data: 'serial_number', orderable: false, searchable: false, name: 'serial_number', class: 'align-middle serial_number', targets: 1, render: function (data, type, row) {return '';} ,download:false},
            {data: 'id', name: 'ecom_invoice.id', class: 'align-middle id',text:'SysID',download:true},
            {data: 'city_name', name: 'ecom_city.city_name' , class: 'align-middle city_name',text:'City Name',download:true},
            {data: 'invoice_cheque_date', name: 'ecom_invoice.invoice_cheque_date' , as : 'created_at' , class: 'align-middle created_at',text:'Date Created',download:true},
            {data: 'invoice_cheque_no', name: 'invoice_cheque_no' , class: 'align-middle invoice_cheque_no',text:'Invoice No',download:true},
            {data: 'merchant_name', name: 'ecom_merchant.merchant_name' , as : 'ecom_merchant.merchant_name' , class: 'align-middle merchant_name',text:'Shipper Name',download:true},
            {data: 'invoice_cheque_holder_name', name: 'invoice_cheque_holder_name', class: 'align-middle invoice_cheque_holder_name',text:'Payee Name',download:true},
            {data: 'invoice_cheque_amount', name: 'invoice_cheque_amount', class: 'align-middle invoice_cheque_amount',text:'Invoice Amount',download:true,
                "render": function (data, type, row) {
                    // Format the number as currency with commas
                    return Math.round(parseFloat(data)).toLocaleString('en-IN');
                }
            },
            {data: 'bank_name', name: 'ecom_bank_list.bank_name', class: 'align-middle bank_name',text:'Bank Name',download:true},
            {data: 'payment_method_name', name: 'ecom_payment_method.payment_method_name', class: 'align-middle payment_method_name',text:'Payment Method',download:true},
            {data: 'pay_status_name', name: 'ecom_payment_status.pay_status_name', class: 'align-middle pay_status_name',text:'Payment Status',download:true},
            {data: 'action'  ,class: 'align-middle text-center action', orderable: false, searchable: false,download:false}
        ],
        //	Sr #	Sys ID#	Page Order	Page Name	Pages Body	Date Created	Actions
        rowCallback: function (row, data, index) {
            var info = table.page.info();

            $('td:eq(1)', row).html(index + 1 + info.page * info.length);

            if(data.pay_status_name != 'cancel' && data.pay_status_name != 'paid'){
                $('td:eq(0)', row).addClass('select-checkbox');
            }

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


    $('#export').append(option).multiselect({
        columns: 1,
        placeholder: 'Export Options',
        search: true,
        selectAll: true
    });

    $('#datatable tbody').on('click', 'tr td.select-checkbox', function() {
        var id = parseInt($(this).parent('tr').attr('id'));

        var index = $.inArray(id, selected_rows);

        if (index === -1) {
            selected_rows.push(id);
        }
        else {
            selected_rows.splice(index, 1);
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
            }else{

                var selectedValue = $('#export').val();
                var selectedTexts = $('#export option:selected').map(function () {
                    return $(this).text()
                }).get();

                $.ajax({
                    url: '{{api_url('manage_cheque/downloadCsv')}}', // Replace withyour backend URL
                    type: 'GET',
                    headers:headers,
                    data: {
                        selectedValue: selectedValue,
                        selectedTexts: selectedTexts,
                        excel:true,
                        ajax:1,
                        date : $('#reservation').val(),
                        status : $('#status').val(),
                        ticket_type : $('#ticket_type').val()
                    },
                    success: function (response) {
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

    $( "body" ).delegate( ".applyBtn", "click", function() {
        table.draw();
    })
    var invoiceId;
    $('#download-invoice-modal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        invoiceId = button.data('invoice-id'); // Extract data from data-* attributes

        $(".invoiceId").each(function () {
            // Get the initial href attribute
            var initialHref = $(this).data("initial-href");

            // Reset the href attribute to its initial value
            $(this).attr("href", initialHref);

            // Append the new invoiceId to the href
            var finalHref = $(this).attr("href") + invoiceId;

            // Set the updated href attribute
            $(this).attr("href", finalHref);
        });
    });

    $('body').delegate('.print_invoice', 'click', function(e) {

        invoiceType = $(this).data('type'); // Extract data from data-* attributes
        console.log(invoiceType);
        if(invoiceType=='details'){
            var url = `<?php echo api_url('manage_cheque/invoice/detail/Print/') ?>` + invoiceId;
        }
        else{
            var url = `<?php echo api_url('manage_cheque/invoice/summary/Print/') ?>` + invoiceId;
        }


        Swal.fire({
            title: 'Are you sure To Print This Invoice?',
            text: "This Will Print The Slip",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Print'
        }).then((result) => {
            if (result.isConfirmed) {

                let sw ;
                $.ajax({
                    url: url,
                    method: 'GET',
                    headers : headers,
                    beforeSend : function(){
                        let timerInterval;
                        sw = Swal.fire({
                            title: '',
                            html: 'Please Wait',
                            timer:2000,
                            timerProgressBar: true,
                            didOpen: () => {
                                Swal.showLoading()

                            },
                            willClose: () => {
                                clearInterval(timerInterval)
                            }
                        })
                    },
                    success: function(data) {
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
                    complete: function() {

                    },
                    error: function(xhr, textStatus, errorThrown) {
                        sw.close(); // Close the loading spinner
                        // Handle AJAX errors here
                        Swal.fire(
                            'Error!',
                            'Unknown Error Occured: ' + errorThrown,
                            'error'
                        );
                    }
                });
            }
        });
    });

    function chq_summary(ids) {

        if(ids.length==0){
            alert('Please select 1 checkbox at least');
            return;
        }

        var url = `<?php echo api_url('manage_cheque/invoice/summary_multiple/Print/') ?>?invoice_id=` + ids;

        Swal.fire({
            title: 'Are you sure To Print This Invoice?',
            text: "This Will Print The Slip",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Print'
        }).then((result) => {
            if (result.isConfirmed) {

                let sw ;
                $.ajax({
                    url: url,
                    method: 'GET',
                    headers : headers,
                    beforeSend : function(){
                        let timerInterval;
                        sw = Swal.fire({
                            title: '',
                            html: 'Please Wait',
                            timer:2000,
                            timerProgressBar: true,
                            didOpen: () => {
                                Swal.showLoading()

                            },
                            willClose: () => {
                                clearInterval(timerInterval)
                            }
                        })
                    },
                    success: function(data) {
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
                    complete: function() {

                    },
                    error: function(xhr, textStatus, errorThrown) {
                        sw.close(); // Close the loading spinner
                        // Handle AJAX errors here
                        Swal.fire(
                            'Error!',
                            'Unknown Error Occured: ' + errorThrown,
                            'error'
                        );
                    }
                });
            }
        });
    }

    function change_status(ids){

        if(ids.length==0){
            alert('Please select 1 checkbox at least');
            return;
        }
        $('#invoice-ids').val(ids);
        $("#status-update-modal").modal("show");
        return;
    }

    function updateStatus(){

        var invoiceIds = $('#invoice-ids').val();
         var status = $('#payment_change_status').val();


        Swal.fire({
            title: 'Are you sure To Update Status Of This Invoice?',
            text: "This Will Update The Payment Status Of Selected Invoice",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Update Payment Status'
        }).then((result) => {
            if (result.isConfirmed) {

                $.ajax({
                        url: '<?php echo api_url('manage_cheque/update_payment_status'); ?>',
                        headers: headers,
                        method: 'POST',
                        data: {
                            'invoice_id': invoiceIds,
                            'status' : status
                        },
                        beforeSend: function(){
                            $('.error-container').html('');
                        },
                        success: function(data) {

                            if (data) {
                                Swal.fire(
                                    'Saved!',
                                    'Payment status has been updated successfully',
                                    'success'
                                );
                                window.location.reload();
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
        });
    }

</script>

@endsection

