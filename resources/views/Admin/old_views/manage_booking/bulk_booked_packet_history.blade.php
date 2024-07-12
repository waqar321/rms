@extends('Admin.layout.main')

@section('styles')
    <style>
        .cancel-button {
                border-color: transparent;
                background: transparent;
                padding: 1px 10px;
                width: 100%;
                text-align: center;
        }
        .cancel-button:hover {
                color: #262626;
                text-decoration: none;
                background-color: #f5f5f5;
        }
    </style>
@endsection

@section('content')
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Batch Booked Packet History</h3>
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
                    <div class="x_content">
                        <table id="datatable" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>Sr #</th>
                                <th>Batch No</th>
                                <th>Batch Date</th>
                                <th>Batch File Name</th>
                                <th>Total Packets</th>
                                <th>Download</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody></tbody>
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
            url: '<?php echo api_url('manage_booking/bulk_booked_packet_history') ?>',
            data: function (d) {
                d.date_range = $('#reservation').val();
                d.ajax = 1;
            },
            headers : headers,
        },
        rowId: 'id',
        order: [[2, 'desc']],
        columns: [
            {data: 'serial_number', orderable: false, searchable: false, name: 'id', class: 'align-middle serial_number', targets: 1, render: function (data, type, row) {return '';},download:false},
            {data: 'instance_id', orderable: true, name: 'instance_id', class: 'align-middle title'},
            {data: 'created_at', name: 'created_at', class: 'align-middle created_at',text:'Column 1'},
            {data: 'file_name', name: 'file_name', class: 'align-middle file_name',text:'Column 1'},
            {data: 'total_packets', name: 'total_packets', class: 'align-middle total_packets',text:'Column 1',searchable: false},
            {data: 'download', name: 'download', class: 'align-middle download',text:'Column 1', orderable: false, searchable: false},
            {data: 'action', name: 'action', class: 'align-middle print_awb',text:'Column 1', orderable: false, searchable: false},
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

    function cancelBookConfirmation(batch){
        Swal.fire({
            title: 'Are you sure To Cancel This Packet?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Submit'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?php echo api_url('manage_booking/cancel_batch/'); ?>'+batch,
                    method: 'GET',
                    dataType: 'json', // Set the expected data type to JSON
                    headers :headers,
                    beforeSend: function(){
                         $('.error-container').html('');
                    },
                    success: function(data) {
                        if (data && data.status == 1) {
                            Swal.fire(
                                'Done!',
                                'Packet has been cancelled successfully',
                                'success'
                            );
                            search();
                        }
                    },
                    error: function(xhr, textStatus, errorThrown) {
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
    function search(){
        table.draw();
    }

</script>

@endsection
