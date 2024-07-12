@extends('Admin.layout.main')

@section('styles')
<style>
        .dt-buttons.btn-group a {
            margin: 0px 5px !important;
        }
        .float-right{
            float: right;
            padding: 10px;
        }
</style>
@endsection

@section('content')
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Manage Bulk Labels</h3>
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

                        <div class="row">
                            <div class="col-md-3 col-sm-3 col-xs-12">
                                <label style="margin-left: 11px;">Date</label>
                                <form class="form-horizontal">
                                    <fieldset>
                                        <div class="control-group">
                                            <div class="controls">
                                                <div class="input-prepend input-group" style="margin-left: 11px;">
                                                    <span class="add-on input-group-addon"><i class="fa fa-calendar"></i></span>
                                                    <input type="text" name="reservation" id="reservation" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                </form>
                            </div>

                            <div class="col-md-3 col-sm-3 col-xs-12">
                                <label class="control-label col-md-12 col-sm-12">Batch #</label>
                                <select id="batch_no" class="form-control select2" onchange="search()">
                                    <option selected disabled>Please Select Option</option>
                                </select>
                            </div>

                            <div class="col-md-3 col-sm-3 col-xs-12">
                                <label class="control-label col-md-12 col-sm-12 col-xs-12">Origin City</label>
                                <select id="origin" name="origin_city_id" style="width: 100%;"  onchange="search()">
                                    <option value="" disabled selected>Select an option</option>
                                </select>
                            </div>

                            <div class="col-md-3 col-sm-3 col-xs-12">
                                <label class="control-label col-md-12 col-sm-12 col-xs-12">Destination City</label>
                                <select id="destination" name="destination_city_id" style="width: 100%;"  onchange="search()">
                                    <option value="" disabled selected>Select an option</option>
                                </select>
                            </div>

                        </div>

                    </div>
                    <div class="x_content">
                    <form action="print_multi_label" target="_blank" method="POST">
                        @csrf
                        <table id="datatable" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>Sr #</th>
                                <th><input id="selectAllCheckbox" class="checkbox" type="checkbox" checked="true"></th>
                                <th>Date</th>
                                <th>Batch #</th>
                                <th>CN #</th>
                                <th>From</th>
                                <th>To</th>
                                <th>Consignee Name</th>
                                <th>Consignee Phone</th>
                                <th>Order Id</th>
                                <th>No. Of Pieces</th>
                                <th>COD Amount</th>
                            </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                        <div class="single-page-label-wrap pt-5">
                                <input type="checkbox" name="print_single_label" class="print_single_label">
                                <span>This will generate all labels on separate pages.</span>
                        </div>
                        <button class="btn btn-primary" type="submit" data-screen-permission-id="128">Print Labels <i class="fa fa-print"></i></button>
                    </form>
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
        $("#origin").select2({
            placeholder: "Search City",
            // minimumInputLength: 2, // Minimum characters before sending the AJAX request
            allowClear: true,
            ajax: {
                url: "{{ api_url('rights/city') }}", // Replace with your actual server endpoint
                dataType: "json",
                delay: 250, // Delay before sending the request in milliseconds
                headers: headers,
                processResults: function(data) {
                    return {
                        results: data.map(function(item) {
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
        $("#destination").select2({
            placeholder: "Search City",
            minimumInputLength: 2, // Minimum characters before sending the AJAX request
            allowClear: true,
            ajax: {
                url: "{{ api_url('get_cities') }}", // Replace with your actual server endpoint
                dataType: "json",
                delay: 250, // Delay before sending the request in milliseconds
                headers: headers,
                processResults: function(data) {
                    return {
                        results: data.map(function(item) {
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

        var batch = $.ajax({
            url: '{{ api_url('manage_booking/batch_data') }}',
            method: 'GET',
            dataType: 'json',
            headers: headers,
            beforeSend: function() {
                $('.error-container').html('');
            }
        });
        $.when(batch).done(function(BatchData) {
            var BatchDataOPtion = '';
            $.each(BatchData.data.batch, function(index, value) {
                BatchDataOPtion += `<option value="${value.instance_id}">${value.id}: Batch ID - (${value.instance_id})</option>`;
            });
            $('#batch_no').append(BatchDataOPtion);
        });

    });

    var selected_rows = [];
    var table = $('#datatable').DataTable({
        dom: '<"search-box"f>l  <"col-md-12" <"float-right" B> ><"datatable-wrapper"rt><"datatable-info"i><"datatable-pagination"p>',
        search: {
            return: true
        },
        buttons: [],
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
            url: '{{ api_url('manage_booking/bulk_print_label') }}',
            data: function (d) {
                d.origin = $('#origin').val();
                d.destination = $('#destination').val();
                d.batch_no = $('#batch_no').val();
                d.date_range = $('#reservation').val();
                d.ajax =1;
            },
            headers:headers,
        },
        rowId: 'id',
        order: [[2, 'desc']],
        columns: [
            {data: 'serial_number', orderable: false, searchable: false, name: 'pickup_requests.id', class: 'align-middle serial_number', targets: 1, render: function (data, type, row) {return '';},download:false},
            {data: 'checkbox', orderable: false, searchable: false, name: 'checkbox', class: 'align-middle title',download:false},
            {data: 'booked_packet_date', name: 'booked_packet_date', class: 'align-middle booked_packet_date',text:'Column 1',download:true},
            {data: 'batch_no', name: 'batch_no', class: 'align-middle batch_no',text:'Column 1',download:true},
            {data: 'booked_packet_cn', name: 'booked_packet_cn', class: 'align-middle track_number',text:'Column 1',download:true},
            {data: 'origin_city', name: 'orig.city_name', class: 'align-middle origin_city',text:'Column 2',download:true},
            {data: 'destination_city', name: 'dest.city_name', class: 'align-middle destination_city',text:'Column 2',download:true},
            {data: 'consignment_name', name: 'consignment_name', class: 'align-middle destination_city',text:'Column 2',download:true},
            {data: 'consignee_phone', name: 'consignee_phone', class: 'align-middle consignment_name',text:'Column 2',download:true},
            {data: 'booked_packet_order_id', name: 'booked_packet_order_id', class: 'align-middle booked_packet_order_id',text:'Column 2',download:true},
            {data: 'booked_packet_no_piece', name: 'booked_packet_no_piece', class: 'align-middle booked_packet_no_piece',text:'Column 2',download:true},
            {data: 'booked_packet_collect_amount', name: 'booked_packet_collect_amount', class: 'align-middle booked_packet_collect_amount',text:'Column 2',download:true},
        ],
        //	Sr #	Sys ID#	Page Order	Page Name	Pages Body	Date Created	Actions
        rowCallback: function (row, data, index) {
            var info = table.page.info();

            $('td:eq(0)', row).html(index + 1 + info.page * info.length);

            if ($.inArray(data.id, selected_rows) !== -1) {
                table.row(row).select();
            }
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

    function search(){
        table.draw();
    }

    $('body').delegate('.applyBtn ','click',function(e){
        search();
    });

    // jQuery function to toggle between "Select All" and "Unselect All" states
    $(document).ready(function () {
        $('#selectAllCheckbox').on('change', function () {
            $('.checkbox').prop('checked', this.checked);
        });
    });

    // $('body').delegate('.printLabel','click', function(){

    // var checkedValues = $("input[name='checked_bookings']:checked").map(function() {
    //   return this.value;
    // });

    //     console.log(checkedValues.join(", "));
    // });

</script>
@endsection
