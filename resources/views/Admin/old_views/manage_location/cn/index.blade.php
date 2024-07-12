@extends('Admin.layout.main')

@section('styles')@endsection

@section('title') CN Listing @endsection

@section('content')
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Manage CN</h3>
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
{{--                    <form method="POST" enctype="multipart/form-data" action="#" id="export-csv">--}}
{{--                        <div class="row">--}}
{{--                            <div class="col-md-4 col-sm-4 col-xs-12">--}}
{{--                                <label class="control-label col-md-12 col-sm-12 col-xs-12">Export To Excel</label>--}}
{{--                                <div class="col-md-12 col-sm-12 col-xs-12">--}}
{{--                                    <select name="export[]" multiple id="export">--}}

{{--                                    </select>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="col-md-4 col-sm-4 col-xs-12 mt-4">--}}
{{--                                <label class="control-label col-md-12 col-sm-12 col-xs-12">&nbsp;</label>--}}
{{--                                <button type="submit" class="btn btn-primary col-md-3 col-sm-3 col-xs-12 export-button">Export</button>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </form>--}}

                    <div class="x_content">
                        <form method="POST" enctype="multipart/form-data" action="#" id="export-csv" data-screen-permission-id="59">
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
                                <th width="30"></th>
                                <th >S. No.</th>
                                <th >CN Number</th>
                                <th >City</th>
                                <th>Is Issued</th>
                                <th>On Hold</th>
                                <th>Type</th>
                                <th>Shipment Type</th>
                                <th>Date Created</th>
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
@endSection

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
                text: '<i class="la la-cogs"></i> Hold - UnHold',
                className: 'btn btn-primary btn-sm add',
                action: function (e, dt, node, config) {
                    hold_un_hold(selected_rows);
                },
                init: function (dt, node, config) {
                    // Add custom data attributes to the button
                    $(node).attr('data-screen-permission-id', "58");
                }
            },
            {
                text: '<i class="la la-cogs"></i> Add CN',
                className: 'btn btn-primary btn-sm add',
                action: function (e, dt, node, config) {
                    window.location = '<?php echo url_secure('manage_location/cn/add') ?>';
                },
                init: function (dt, node, config) {
                    // Add custom data attributes to the button
                    $(node).attr('data-screen-permission-id', "57");
                }
            },
            {
                text: '<i class="la la-cogs"></i> CN Stock',
                className: 'btn btn-primary btn-sm add',
                action: function (e, dt, node, config) {
                    window.location = '<?php echo url_secure('manage_location/cn/stock') ?>';
                },
                init: function (dt, node, config) {
                    // Add custom data attributes to the button
                    $(node).attr('data-screen-permission-id', "174");
                }
            },

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
            url: '<?php echo api_url('manage_location/cn') ?>',
            data: function (d) {
                d.ajax=1;
            },
            headers: headers,
        },
        drawCallback: function (xhr, textStatus) {
            setTimeout(delayfunc(),200);
        },
        rowId: 'id',
        order: [[2, 'desc']],
        columns: [
            {data: 'id', orderable: false, searchable: false, class: 'text-center align-middle select select-checkbox p-1', targets: 0, render: function (data, type, row) {return '';} ,download:false},
            {data: 'serial_number', orderable: false, searchable: false, name: 'serial_number', class: 'align-middle serial_number', targets: 1, render: function (data, type, row) {return '';} ,download:false},
            {data: 'cn_with_prefix', name: 'ecom_bank_cn.cn_with_prefix', class: 'align-middle cn_with_prefix',text:'CN#' ,download:true},
            {data: 'city_name', name: 'c.city_name', class: 'align-middle city_name',text:'City' ,download:true},
            {data: 'is_issued', name: 'ecom_bank_cn.is_issued', class: 'align-middle is_issued text-center',text:'Issued',download:true},
            {data: 'on_hold', name: 'ecom_bank_cn.on_hold', class: 'align-middle on_hold text-center',text:'On Hold',download:true},
            {data: 'isCSV', name: 'ecom_bank_cn.isCSV', class: 'align-middle isCSV',text:'CSV',download:true},
            {data: 'shipment_type_name', name: 'st.shipment_type_name', class: 'align-middle shipment_type_name',text:'Shipment Type',download:true},
            {data: 'created_at', name: 'ecom_bank_cn.created_at', class: 'align-middle created_at',text:'Date Created',download:true},
            {data: 'action'  ,class: 'align-middle text-center action', orderable: false, searchable: false,download:false}
        ],
        //	Sr #	Sys ID#	Page Order	Page Name	Pages Body	Date Created	Actions
        rowCallback: function (row, data, index) {
            var info = table.page.info();

            var lock =`<span class="fa fa-lock fa-2x red"></span>`;
            var unlock = `<span class="fa fa-unlock fa-2x green "></span>`;
            $('td:eq(1)', row).html(index + 1 + info.page * info.length);
            if(data['is_issued'] == 1) {
                $('td:eq(4)', row).html(unlock);
            }else{
                    $('td:eq(4)', row).html(lock);
            }
            if(data['on_hold'] == 1) {
                $('td:eq(5)', row).html(lock);
            }else{
                    $('td:eq(5)', row).html(unlock);
            }
            if(data['isCSV'] == 0) {
                $('td:eq(6)', row).html('Manual');
            }else{
                    $('td:eq(6)', row).html('CSV');
            }

            if ($.inArray(data.id, selected_rows) !== -1) {
                table.row(row).select();
            }
        },
        initComplete: function () {
            var search = $('<tr role="row" class="bg-lighten-1 search"></tr>').appendTo(this.api().table().header());

            var td = '<td style="padding:5px;" class="border-lighten-2"><fieldset class="form-group m-0 position-relative has-icon-right"></fieldset></td>';
            var input = '<input type="text" class="form-control form-control-sm input-sm mb-0">';
            var csv = `<select name="is_csv" id="is_csv" class="form-control form-control-sm input-sm mb-0">
                        <option value="">Select</option>
                        <option value="0">Manual</option>
                        <option value="1">CSV</option>
                       </select>`;
            var icon = '<div class="form-control-position primary"><i class="la la-search"></i></div>';
            this.api().columns().every(function (column_id) {
                var column = this;
                var header = column.header();

                if ($(header).is('.action') ||  $(header).is('.serial_number') ||  $(header).is('.select') ||  $(header).is('.is_issued') ||  $(header).is('.on_hold')) {
                    $(td).appendTo($(search));
                } else if ($(header).is('.isCSV')) {
                    $(csv).appendTo($(search))
                        .on('change', function () {
                            column.search($(this).val(), false, false, true).draw();
                        }).wrap(td);
                }
                else {
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
                    url: '<?php  echo api_url('manage_location/cn/downloadCsv')  ?>', // Replace with your backend URL
                    type: 'GET',
                    data: {
                        selectedValue: selectedValue,
                        selectedTexts: selectedTexts,
                        excel:true,
                        ajax:1,
                    },
                    headers: headers,
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
                    error: function (error) {
                    }
                });
                e.preventDefault();
            }
        })
    })

    $('body').on('click','button.hold_un_hold',function () {
        var id = $(this).parents('tr').attr('id');
        var on_hold = $(this).attr('rel');


        Swal.fire({
            title: 'Are you sure?',
            text: "Click Submit to continue",
            // icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ffca00',
            cancelButtonColor: '#0e1827',
            confirmButtonText: 'Submit'
        }).then((result) => {
            if (result.isConfirmed) {
                hold_un_hold(id);
            }
        });


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


    function hold_un_hold(ids) {
        if(ids == '' || ids == null){
            Swal.fire({
                icon: 'error',
                text: 'Please select at least one CN No #.!',
                showConfirmButton: true,
                confirmButtonColor: '#ffca00',
            });
            return false;
        }
        $.ajax({
            url: '<?php echo api_url('manage_location/cn/status'); ?>',
            method: 'POST',
            data:{id : ids},
            dataType: 'json',
            headers: headers,
            success: function(data) {
                if (data && data.status == 1) {
                    Swal.fire(
                        'Saved!',
                        'Status Changed',
                        'success'
                    );
                    $('.select_none').trigger('click');
                    table.draw();

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


</script>

@endSection

