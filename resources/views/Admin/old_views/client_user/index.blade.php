@extends('Admin.layout.main')

@section('styles')@endsection

@section('title') Users Listing @endsection

@section('content')
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Manage Users</h3>
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
                            <hr>
                            <div class="row">
                                <div class="col-md-4 col-sm-3 col-xs-12">
                                    <label class="control-label col-md-12 col-sm-12 col-xs-12">Status</label>
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <select class="form-control" name="status" id="status" onchange="search()">
                                            <option value="">Please Select Status</option>
                                            <option value="2">View All</option>
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-3 col-xs-12">
                                    <label class="control-label col-md-12 col-sm-12 col-xs-12">City</label>
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <select class="form-control select2" name="city_id" id="city_id" onchange="search()">
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-3 col-xs-12">
                                    <label class="control-label col-md-12 col-sm-12 col-xs-12">Role</label>
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <select class="form-control select2" name="role_id" id="role_id" onchange="search()">

                                        </select>
                                    </div>
                                </div>
                                {{--                                <div class="col-md-4 col-sm-3 col-xs-12">--}}
                                {{--                                    <label class="control-label col-md-12 col-sm-12 col-xs-12">User Type</label>--}}
                                {{--                                    <div class="col-md-12 col-sm-12 col-xs-12">--}}
                                {{--                                        <select class="form-control" name="user_type_id" id="user_type_id" onchange="search()">--}}
                                {{--                                            <option value="">Please Select User Type</option>--}}
                                {{--                                            <option value="3">Admin User</option>--}}
                                {{--                                            <option value="5">Shipper User</option>--}}
                                {{--                                        </select>--}}
                                {{--                                    </div>--}}
                                {{--                                </div>--}}
                            </div>

                            {{--                            <form method="POST" enctype="multipart/form-data" action="#" id="export-csv">--}}
                            {{--                                <div class="row">--}}
                            {{--                                    <div class="col-md-4 col-sm-4 col-xs-12">--}}
                            {{--                                        <label class="control-label col-md-12 col-sm-12 col-xs-12">Status</label>--}}
                            {{--                                        <div class="col-md-12 col-sm-12 col-xs-12">--}}
                            {{--                                            <select name="export[]" multiple id="export">--}}

                            {{--                                            </select>--}}
                            {{--                                        </div>--}}
                            {{--                                    </div>--}}
                            {{--                                    <div class="col-md-4 col-sm-4 col-xs-12 mt-4">--}}
                            {{--                                        <label class="control-label col-md-12 col-sm-12 col-xs-12">&nbsp;</label>--}}
                            {{--                                        <button type="submit" class="btn btn-primary col-md-3 col-sm-3 col-xs-12" >Export</button>--}}
                            {{--                                    </div>--}}
                            {{--                                </div>--}}
                            {{--                            </form>--}}

                        </div>
                        <div class="x_content">
                            <form method="POST" enctype="multipart/form-data" action="#" id="export-csv" data-screen-permission-id="182">
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
                                    <th>SYS ID#</th>
                                    <th>City</th>
                                    <th>User Name</th>
                                    <th>User ID (Email)</th>
                                    <th>Role Name</th>
                                    <th>Date Created </th>
                                    <th>Status </th>
                                    <th>Action</th>
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
        var selected_rows = [];
        var table = $('#datatable').DataTable({
            dom: '<"search-box"f>l  <"" <"float-right" B> ><"datatable-wrapper"rt><"datatable-info"i><"datatable-pagination"p>',
            search: {
                return: true
            },
            buttons: [
                {
                    text: '<i class="la la-cogs"></i> Add Client User',
                    className: 'btn btn-primary btn-sm add',
                    action: function (e, dt, node, config) {
                        window.location = '<?php echo url_secure('manage_client/client/add') ?>';
                    },
                    init: function (dt, node, config) {
                        // Add custom data attributes to the button
                        $(node).attr('data-screen-permission-id', "179");
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
                url: '<?php echo api_url('manage_client/client') ?>',
                data: function (d) {
                    d.ajax=1;
                    d.status = $('#status').val();
                    d.city_id = $('#city_id').val();
                    d.role_id = $('#role_id').val();
                    // d.user_type_id = $('#user_type_id').val();
                },
                headers: headers,
            },
            drawCallback: function (xhr, textStatus) {
                setTimeout(delayfunc(),200);
            },
            rowId: 'id',
            order: [[1, 'desc']],
            columns: [
                // {data: 'id', orderable: false, searchable: false, class: 'text-center align-middle select select-checkbox p-1', targets: 0, render: function (data, type, row) {return '';} ,download:false},
                {data: 'serial_number', orderable: false, searchable: false, name: 'serial_number', class: 'align-middle serial_number', targets: 1, render: function (data, type, row) {return '';} ,download:false},
                {data: 'id', name: 'ecom_admin_user.id', class: 'align-middle id',text:'Sys ID#' ,download:true},
                {data: 'city_name', name: 'ecom_city.city_name', class: 'align-middle bank_name',text:'City',download:true},
                {data: 'username', name: 'ecom_admin_user.username', class: 'align-middle username',text:'User Name',download:true},
                {data: 'email', name: 'ecom_admin_user.email', class: 'align-middle email',text:'User Id (Email)',download:true},
                {data: 'role_name', name: 'ecom_user_roles.role_name', class: 'align-middle role_name',text:'Role Name',download:true},
                {data: 'created_at', name: 'ecom_admin_user.created_at', class: 'align-middle created_at',text:'Date Created',download:true},
                {data: 'status'  ,class: 'align-middle text-center status', orderable: false, searchable: false,download:false},
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
                        url: '<?php  echo api_url('manage_client/client/downloadCsv')  ?>', // Replace with your backend URL
                        type: 'GET',
                        data: {
                            selectedValue: selectedValue,
                            selectedTexts: selectedTexts,
                            excel:true,
                            ajax:1,
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

        $(document).ready(function () {
            $("#role_id").select2({
                placeholder: "Search Role",
                // minimumInputLength: 2, // Minimum characters before sending the AJAX request
                allowClear: true,
                ajax: {
                    url: "{{ api_url('role_list_merchant') }}", // Replace with your actual server endpoint
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
            $("#country_id").select2({
                placeholder: "Search Country",
                minimumInputLength: 2, // Minimum characters before sending the AJAX request
                allowClear: true,
                ajax: {
                    url: "{{ api_url('get_countries') }}", // Replace with your actual server endpoint
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

    <script src="{{ url_secure('build/js/main.js')}}"></script>
@endsection

