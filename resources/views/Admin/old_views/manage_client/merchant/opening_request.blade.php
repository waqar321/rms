@extends('Admin.layout.main')

@section('styles')
    <style>
        .display-detail{
            display: inline;
            margin-top: 2%;
        }
        .merchant-detail{
            margin-top: 5%!important;
        }
        .modal-body{
            padding: 0px;
        }
        .modal-dialog{
            width: 65%;
        }
    </style>
    <link rel="stylesheet" href="{{ url_secure('build/css/jquery_ui.css')}}">
@endsection

@section('title') Account Opening Request @endsection

@section('content')

<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Account Opening Request</h3>
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
                    <div class="container mt-4">
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <label class="control-label col-md-12 col-sm-12">Status</label>
                            <div class="col-md-12 col-sm-12">
                                <select class="form-control" name="status" id="status" onchange="search()">
                                    <option value="">Please Select Status</option>
                                    <option value="2">View All</option>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <label class="control-label col-md-12 col-sm-12">Country </label>
                            <div class="col-md-12 col-sm-12">
                                <select id="country_id" name="country_id" class="form-control" onchange="search()">

                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <label class="control-label col-md-12 col-sm-12">City </label>
                            <div class="col-md-12 col-sm-12">
                                <select class="form-control" name="city_id" id="city_id" onchange="search()">

                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row" style="margin-top: 3%">
                        <div class="col-md-12">
{{--                            <form method="POST" enctype="multipart/form-data" action="#" id="export-csv">--}}
{{--                                <div class="row">--}}
{{--                                    <div class="col-md-4 col-sm-4 col-xs-12">--}}
{{--                                        <label class="control-label col-md-12 col-sm-12 col-xs-12">Export To Excel</label>--}}
{{--                                        <div class="col-md-12 col-sm-12 col-xs-12">--}}
{{--                                            <select name="export[]" multiple id="export">--}}

{{--                                            </select>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="col-md-4 col-sm-4 col-xs-12 mt-4">--}}
{{--                                        <label class="control-label col-md-12 col-sm-12 col-xs-12">&nbsp;</label>--}}
{{--                                        <button type="submit" class="btn btn-primary col-md-3 col-sm-3 col-xs-12 export-button">Export</button>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </form>--}}
                        </div>
                    </div>
                    <hr>

                    <div class="x_content">
                        <form method="POST" enctype="multipart/form-data" action="#" id="export-csv" data-screen-permission-id="72">
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
                                <th >Sr #</th>
                                <th >Sys ID#</th>
                                <th >Company Name</th>
                                <th >Contact Person Name</th>
                                <th >Contact Person Mobile</th>
                                <th >City</th>
                                <th >Country</th>
                                <th >Date Created</th>
                                <th >Actions</th>
                            </tr>
                            </thead>

                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Request Detail modal -->
<div id="merchant-request-detail" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="merchant-name">Merchant Detail</h4>
            </div>
            <div class="modal-body">
                <div class="col-md-3">
                    <img src="{{ url_secure('build/images/company_details.png')}}" style="height: 195px;">
                </div>
                <div class="col-md-9 merchant-detail">
                    <ul>
                        <li class="display-detail col-md-12">
                            <span class="col-md-3"><b>Branch:</b> </span>
                            <span class="text_cn_number col-md-9" id="branch"></span>
                        </li>
                        <li class="display-detail col-md-12">
                            <span class="col-md-3">Phone: </span>
                            <span class="text_cn_number col-md-9" id="phone"></span>
                        </li>
                        <li class="display-detail col-md-12">
                            <span class="col-md-3">Email: </span>
                            <span class="text_cn_number col-md-9" id="email"></span>
                        </li>
                        <li class="display-detail col-md-12">
                            <span class="col-md-3">Address: </span>
                            <span class="text_cn_number col-md-9" id="address"></span>
                        </li>
                    </ul>
                </div>
                <div class="col-md-12 merchant-detail">
                    <hr>
                    <ul>
                        <li class="display-detail col-md-6">
                            <span class="col-md-5">Contact Person Name: </span>
                            <span class="text_cn_number col-md-7" id="contact_person_name"></span>
                        </li>
                        <li class="display-detail col-md-6">
                            <span class="col-md-5">Designation: </span>
                            <span class="text_cn_number col-md-7" id="designation"></span>
                        </li>
                        <li class="display-detail col-md-6">
                            <span class="col-md-5">Mobile: </span>
                            <span class="text_cn_number col-md-7" id="mobile"></span>
                        </li>
                        <li class="display-detail col-md-6">
                            <span class="col-md-5">Phone: </span>
                            <span class="text_cn_number col-md-7" id="phone"></span>
                        </li>
                        <li class="display-detail col-md-6">
                            <span class="col-md-5">City: </span>
                            <span class="text_cn_number col-md-7" id="city"></span>
                        </li>
                        <li class="display-detail col-md-6">
                            <span class="col-md-5">Country: </span>
                            <span class="text_cn_number col-md-7" id="country"></span>
                        </li>
                    </ul>
                </div>
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
    <script src="{{ url_secure('build/js/jquery_ui.js')}}"></script>
<script>
    const token = getToken();
    const headers = {
        "Authorization": `Bearer ${token}`,
    };
    var selected_rows = [];
    var table = $('#datatable').DataTable({
        dom: '<"search-box"f>l  <"col-md-12" <"float-right" B> ><"datatable-wrapper"rt><"datatable-info"i><"datatable-pagination"p>',
        scrollX: true,
        search: {
            return: true
        },
        buttons: [
            // {
                //text: '<i class="la la-cogs"></i> Add',
                //className: 'btn btn-primary add',
                //action: function (e, dt, node, config) {
                //    window.location = '<?php //echo base_url('manage/shipment_type/add') ?>//';
                //}
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
            url: '<?php echo api_url('manage_client/merchant/request') ?>',
            data: function (d) {
                d.ajax=1;
                d.status = $('#status').val();
                d.country_id = $('#country_id').val();
                d.city_id = $('#city_id').val();
            },
            headers: headers,
        },
        rowId: 'id',
        order: [[5, 'desc']],
        columns: [
            // {data: 'id', orderable: false, searchable: false, class: 'text-center align-middle select select-checkbox p-1', targets: 0, render: function (data, type, row) {return '';} ,download:false},
            {data: 'serial_number', orderable: false, searchable: false, name: 'serial_number', class: 'align-middle serial_number', targets: 1, render: function (data, type, row) {return '';} ,download:false},
            {data: 'id', name: 'ecom_merchant_request.id', class: 'align-middle id',text:'Sys ID#' ,download:true},
            {data: 'merchant_name', name: 'ecom_merchant_request.merchant_name', class: 'align-middle merchant_name',text:'Merchant Name #',download:true},
            {data: 'merchant_representative_name', name: 'ecom_merchant_request.merchant_representative_name', class: 'align-middle merchant_representative_name',text:'Contact Person Name',download:true},
            {data: 'merchant_representative_des', name: 'ecom_merchant_request.merchant_representative_des', class: 'align-middle merchant_representative_des',text:'Contact Person Mobile',download:true},
            {data: 'city_name', name: 'ecom_city.city_name', class: 'align-middle city_name',text:'City',download:true},
            {data: 'country_name', name: 'ecom_country.country_name', class: 'align-middle country_name',text:'Country',download:true},
            {data: 'created_at', name: 'ecom_merchant_request.created_at', class: 'align-middle created_at',text:'Date Created',download:true},
            {data: 'action'  ,class: 'align-middle text-center action', orderable: false, searchable: false,download:false}
        ],
        //	Sr #	Sys ID#	Page Order	Page Name	Pages Body	Date Created	Actions
        rowCallback: function (row, data, index) {
            var info = table.page.info();

            $('td:eq(1)', row).html(index + 1 + info.page * info.length);

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
                    url: '<?php  echo api_url('manage_client/merchant/request/downloadCsv')  ?>', // Replace with your backend URL
                    type: 'GET',
                    data: {
                        selectedValue: selectedValue,
                        selectedTexts: selectedTexts,
                        excel:true,
                        ajax:1,
                    },
                    headers:headers,
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


        function openRequestDetail(id){
            $.ajax({
                url: '<?php echo api_url('manage_client/merchant/request/detail'); ?>',
                method: 'GET',
                dataType: 'json', // Set the expected data type to JSON
                data: {id: id},
                headers:headers,
                beforeSend: function(){
                    $('.error-container').html('');
                },
                success: function(data) {
                    $("#merchant-request-detail").modal();

                    document.getElementById('branch').innerHTML = (data.result.merchant_branch) ? data.result.merchant_branch : 'N/A';
                    document.getElementById('address').innerHTML = (data.result.merchant_address1) ? data.result.merchant_address1 : 'N/A';
                    document.getElementById('phone').innerHTML = (data.result.merchant_mobile) ? data.result.merchant_mobile : 'N/A';
                    document.getElementById('email').innerHTML = (data.result.merchant_email) ? data.result.merchant_email : 'N/A';
                    document.getElementById('contact_person_name').innerHTML = (data.result.merchant_representative_name) ? data.result.merchant_representative_name : 'N/A';
                    document.getElementById('designation').innerHTML = (data.result.merchant_representative_des) ? data.result.merchant_representative_des : 'N/A';
                    document.getElementById('mobile').innerHTML = (data.result.merchant_mobile) ? data.result.merchant_mobile : 'N/A';
                    document.getElementById('phone').innerHTML = (data.result.merchant_phone) ? data.result.merchant_phone : 'N/A';
                    document.getElementById('city').innerHTML = (data.result.city_name) ? data.result.city_name : 'N/A';
                    document.getElementById('country').innerHTML = (data.result.country_name) ? data.result.country_name : 'N/A';
                    // $(data).each(function( index ) {
                    //     tr = "<tr><td><input type='checkbox' class='checkbox' checked='true' name='checked_bookings[]' value="+data[index].id+"></td>";
                    //     booking_date = "<td>"+data[index].booked_packet_date+"</td>";
                    //     cn = "<td>"+data[index].booked_packet_cn+"</td>";
                    //     booked_packet_order_id = "<td>"+data[index].booked_packet_order_id+"</td>";
                    //     origin_city = "<td>"+data[index].origin_city+"</td>";
                    //     destination_city = "<td>"+data[index].destination_city+"</td>";
                    //     shipment_name_eng = "<td>"+data[index].shipment_name_eng+"</td>";
                    //     consignment_name_eng = "<td>"+data[index].consignment_name_eng+"</td>";
                    //     booked_packet_collect_amount = "<td>"+data[index].booked_packet_collect_amount+"</td>";
                    //     trclose = "</tr>";
                    //     body += tr+booking_date+cn+booked_packet_order_id+origin_city+destination_city+shipment_name_eng+consignment_name_eng+booked_packet_collect_amount+trclose;
                    // });
                    //
                    // $('#body').html(body);
                },
                error: function(xhr, textStatus, errorThrown) {
                    // Handle AJAX errors here
                }
            });
        }

    $(document).ready(function() {
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
    });

    $(document).ready(function() {
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


