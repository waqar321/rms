@extends('Admin.layout.main')
@section('title') Manage Bank Transactions @endsection
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
        .orange-background {
            background: #ffd752;
        }
        .red-background {
            background: #ffa7a7;
        }
    </style>
@endsection

@section('content')
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
                <div class="title_left">
                    <h3>Manage Bank Transactions</h3>
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
                            <label>Search By Filters</label>
                                <select class="form-control select2" onchange="search()" name="search_filter" id="search_filter">
                                    <option value="viewAll">View All Transactions</option>
                                    <option value="viewActive">Valid Transactions</option>
                                    <option value="viewVerified">Verified Transactions</option>
                                    <option value="viewNonVerified">Non-Verified Transactions</option>
                                    <option value="viewValidDuplicate">Valid Duplicate Transactions</option>
                                    <option value="viewInvalidDuplicate">Invalid Duplicate Transactions</option>
                                </select>
                        </div>

                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <label>Search By CN / Branch Code / Slip# / Amount</label>
                            <input id="cn_number" name="cn_number" class="form-control">
                        </div>

                    </div>

                    <div class="clearfix"></div>

                    <div class="x_content">
                        <div id="summary-data" class="col-md-12"></div>
                        <form method="POST" enctype="multipart/form-data" action="#" id="export-csv" data-screen-permission-id="171">
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
                                    <th>St.</th>
                                    <th>Status</th>
                                    <th>Batch#</th>
                                    <th>CN#</th>
                                    <th>Branch Code</th>
                                    <th>Branch Name</th>
                                    <th>Slip No.</th>
                                    <th>Amount</th>
                                    <th>COD Amount</th>
                                    <th>Difference</th>
                                    <th>Pay Mode</th>
                                    <th>Dt. Collection</th>
                                    <th>Dt. Credit</th>
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
                        <div class="h1-border-bottom">Print Cheque Summary</div>
                    </div>
                    <div class="col-md-6 text-center">
                        <div class="h1-border-bottom">Print Cheque Detail</div>
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
                        <select class="form-control" id="payment_change_status" onchange="updateStatus()"></select>
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

<div class="modal fade bd-example-modal-lg" id="packet_history" tabindex="-1" role="dialog" aria-labelledby="log" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <p class="modal-title" id="exampleModalLabel">Bank Transaction Log</p>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="log-body" style="height:auto">

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
    $(document).ready(function() {
        $('#reservation').val('');
        importHistory();
    });

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
                text: '<i class="la la-cogs"></i> Verify Transaction',
                className: 'btn btn-primary btn-sm verify-transaction',
                action: function (e, dt, node, config) {
                    verify_transaction(selected_rows);
                },
                init: function (dt, node, config) {
                    // Add custom data attributes to the button
                    $(node).attr('data-screen-permission-id', "172");
                }
            },
            {
                text: '<i class="la la-cogs"></i> Import Transaction File',
                className: 'btn btn-primary btn-sm chq-summary',
                action: function (e, dt, node, config) {
                        window.location = '<?php echo url_secure('manage_bank_transaction/import') ?>';
                },
                init: function (dt, node, config) {
                    // Add custom data attributes to the button
                    $(node).attr('data-screen-permission-id', "173");
                }
            },
            {
                text: '<i class="la la-cogs"></i> Add Entry',
                className: 'btn btn-primary btn-sm add',
                action: function (e, dt, node, config) {
                        window.location = '<?php echo url_secure('manage_bank_transaction/add') ?>';
                },
                init: function (dt, node, config) {
                    // Add custom data attributes to the button
                    $(node).attr('data-screen-permission-id', "168");
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
            url: '<?php echo api_url('manage_bank_transaction') ?>',
            data: function (d) {
                d.date = $('#reservation').val();
                d.search_filter = $('#search_filter').val();
                d.cn_number = $('#cn_number').val();
                d.ajax = 1;
            },
            headers:headers,
        },
        drawCallback: function (xhr, textStatus) {
            setTimeout(delayfunc(),200);
        },
        rowId: 'id',
        order: [[1, 'desc']],
        columns: [
            {data: 'id', orderable: false, searchable: false, class: 'text-center align-middle select  p-1', targets: 0, render: function (data, type, row) {return '';} ,download:false},
            {data: 'serial_number', orderable: false, searchable: false, name: 'serial_number', class: 'align-middle serial_number', targets: 1, render: function (data, type, row) {return '';} ,download:false},
            {data: 'id', name: 'ecom_bank_transaction_detail.id', class: 'align-middle id',text:'SysID',download:true},
            {data: 'is_verified', name: 'is_verified' , class: 'align-middle is_verified',download:false},
            {data: 'batch_no', name: 'ecom_bank_transaction_detail.batch_no' , class: 'align-middle batch_no',text:'Batch No',download:true},
            {data: 'cn_short', name: 'ecom_bank_transaction_detail.cn_short' , class: 'align-middle cn_short',text:'CN Short',download:true},
            {data: 'branch_code', name: 'branch_code' , class: 'align-middle branch_code',text:'Branch Code',download:true},
            {data: 'branch_name', name: 'branch_name' , class: 'align-middle branch_name',text:'Branch Name',download:true},
            {data: 'deposit_slip_no', name: 'deposit_slip_no', class: 'align-middle deposit_slip_no',text:'Deposit Slip No',download:true},
            {data: 'amount', name: 'amount', class: 'align-middle amount',text:'Amount',download:true,
                "render": function (data, type, row) {
                    // Format the number as currency with commas
                    return Math.round(parseFloat(data)).toLocaleString('en-IN');
                }
            },
            {data: 'booked_packet_collect_amount', name: 'ecom_bookings.booked_packet_collect_amount', class: 'align-middle amount',text:'COD Amount',download:true,
                "render": function (data, type, row) {
                    // Format the number as currency with commas
                    return Math.round(parseFloat(data)).toLocaleString('en-IN');
                }
            },
            {data: 'difference', name: 'difference', class: 'align-middle difference',text:'Difference',download:false},
            {data: 'payment_mode', name: 'payment_mode', class: 'align-middle payment_mode',text:'Payment Mode',download:true},
            {data: 'date_collection', name: 'date_collection', class: 'align-middle date_collection',text:'Date Collection',download:true},
            {data: 'date_credit', name: 'date_credit', class: 'align-middle date_credit',text:'Date Credit',download:true},
            {data: 'action'  ,class: 'align-middle text-center action', orderable: false, searchable: false,download:false}
        ],
        //	Sr #	Sys ID#	Page Order	Page Name	Pages Body	Date Created	Actions
        rowCallback: function (row, data, index) {
            var info = table.page.info();
            $('td:eq(1)', row).html(index + 1 + info.page * info.length);

            if(data.is_verified_key == 0){
                $('td:eq(0)', row).addClass('select-checkbox');
            }

            if(data.difference > 0){
                $('td:eq(11)', row).addClass('orange-background');
            }
            else if(data.difference < 0){
                $('td:eq(11)', row).addClass('red-background');
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
                    url: '{{api_url('manage_bank_transaction/downloadCsv')}}', // Replace withyour backend URL
                    type: 'GET',
                    headers:headers,
                    data: {
                        selectedValue: selectedValue,
                        selectedTexts: selectedTexts,
                        excel:true,
                        ajax:1,
                        date : $('#reservation').val(),
                        search_filter : $('#search_filter').val(),
                        cn_number : $('#cn_number').val(),
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
        importHistory();
    });

    $('body').delegate('#cn_number', 'keyup', function (e) {
        var cnLength = $('#cn_number').val().length;
        if(cnLength > 1){
            search();
        }            
    });


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
                            'Packet cancellation failed: ' + errorThrown,
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
                            'Packet cancellation failed: ' + errorThrown,
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

    function verify_transaction(ids) {

        if(ids.length==0){
            alert('Please select 1 checkbox at least');
            return;
        }

        var url = `<?php echo api_url('manage_bank_transaction/verify_transaction') ?>?transaction_id=` + ids;

        Swal.fire({
            title: 'Are you sure to verify transaction?',
            text: "This Will verify the selected deposits",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Verify'
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

                            if (data) {
                                Swal.fire(
                                    'Saved!',
                                    'Deposit slip has been verified successfully',
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
                    complete: function() {

                    },
                    error: function(xhr, textStatus, errorThrown) {
                        sw.close(); // Close the loading spinner
                        // Handle AJAX errors here
                        Swal.fire(
                            'Error!',
                            'Deposits verification failed: ' + errorThrown,
                            'error'
                        );
                    }
                });
            }
        });
    }

    function importHistory(){
        $.ajax({
            url: '{{api_url('manage_bank_transaction/import_history')}}', // Replace withyour backend URL
            type: 'GET',
            headers:headers,
            data: {
                ajax:1,
                date : $('#reservation').val(),
            },
            success: function (response) {
                populateImportSummary(response.data);
            },
            error: function (error) {
            }
        });

    }

    function populateImportSummary(data){
        var result="";
        $(data).each(function (index, summary) {
            result += "<table class='mx-1 col-md-3 table table-striped table-bordered'>";
            result += "<tr><th>Date.</th><th>"+summary.batch_date+"</th></tr>";
            result += "<tr><td>Batch No.</td><td>"+summary.batch_no+"</td></tr>";
            result += "<tr><td>Valid Records:</td><td>"+parseFloat(summary.invalid_record+summary.matched_record)+"</td></tr>";
            result += "<tr><td>Invalid Records:</td><td>"+summary.invalid_record+"</td></tr>";
            result += "<tr><td>Matched Records:</td><td>"+summary.matched_record+"</td></tr>";
            result += "<tr><td>Non Matched Records:</td><td>"+summary.non_matched_record+"</td></tr>";
            result += "<tr><td>Duplicates:</td><td>"+summary.duplicate+"</td></tr>";
            result += "<tr><td>Non Duplicates:</td><td>"+summary.non_duplicate+"</td></tr>";
            result += "<tr><td colspan='2'>"+summary.file_name+"</td></tr>";
            result += "</table>";
        });
        $('#summary-data').append(result);
    }

    $('#packet_history').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var cn_short = button.data('booked_packet_cn'); // Extract data from data-* attributes
        var is_admin = (button.data('is_admin')) ? button.data('is_admin') : 0;
        var type = "bank_transaction";

        $.ajax({
            url: '<?php echo api_url('manage_booking/packet_log') ?>', // Replace with your backend URL
            type: 'GET',
            headers:headers,
            data: {cn_short,is_admin,type},
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

</script>

@endsection

