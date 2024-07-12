@extends('Admin.layout.main')
@section('styles')
<style>
    .center {
        text-align: center;
    }
    #datatable1_length{
        margin-top: -43px;
    }
    /*.pagination {*/
    /*    display: inline-block;*/
    /*}*/

    /*.pagination a {*/
    /*    color: black;*/
    /*    float: left;*/
    /*    padding: 8px 16px;*/
    /*    text-decoration: none;*/
    /*    transition: background-color .3s;*/
    /*    border: 1px solid #ddd;*/
    /*    margin: 0 4px;*/
    /*}*/

    /*.pagination a.active {*/
    /*    background-color: #4CAF50;*/
    /*    color: white;*/
    /*    border: 1px solid #4CAF50;*/
    /*}*/

    /*.pagination a:hover:not(.active) {background-color: #ddd;}*/
    .float-right{
            float: right;
            /*padding: 10px;*/
        }
        .animated  {
            min-width: 100px;
        }

        .dt-buttons.btn-group a {
            margin: 0px 5px !important;
        }
        button.cancel-button {
            border-color: transparent;
            background: transparent;
            padding: 1px 10px;
        }
        button.cancel-button:hover {
            color: #262626;
            text-decoration: none;
            background-color: #f5f5f5;
        }
        /* a.btn.btn-secondary.btn-primary.add {
            background: #ffcb05;
            border-color: #0e1827;
            color: #0e1827;
            padding: 10px 15px;
            font-weight: 700;
        }
        a.btn.btn-secondary.btn-primary.add:hover {
            background: #000;
            color: #ffcb05;
        } */
        /*.modal-content {*/
        /*    width: max-content;*/
        /*}*/
        /*.modal-body {*/
        /*    height: 400px;*/
        /*    overflow: auto;*/
        /*}*/
        /*.danger {*/
        /*    color: #FF4961 !important;*/
        /*}*/
</style>
@endsection
@section('content')
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Manage Dispatch Report</h3>
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
                        <hr>
                        <div class="row">
                            <div class="col-md-4 ">
                                <label style="margin-left: 11px;">Date</label>
                                <form class="form-horizontal">
                                    <fieldset>
                                        <div class="control-group">
                                            <div class="controls">
                                                <div class="input-prepend input-group" style="margin-left: 11px;">
                                                    <span class="add-on input-group-addon"><i class="fa fa-calendar"></i></span>
                                                    <input type="text" style="width: 272px" name="reservation" id="reservation" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="x_content">
                    <table id="datatable1" class="table table-striped table-bordered">
                            <thead>
                                <th>Sr#</th>
                                <th>Challan#</th>
                                <th>Challan Date</th>
                                <th>Print Performa</th>
                                <th>Print AWB</th>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- LoadSheet Modal End -->
@endsection
@section('scripts')
<script>
    $(document).ready(function() {
        $('#reservation').val('');
    });
    const token = getToken();
    const headers = {
        "Authorization": `Bearer ${token}`,
    };
    var selected_rows = [];
    var table = $('#datatable1').DataTable({
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
            url: '<?php echo api_url('manage_booking/load_sheet') ?>',
            data: function (d) {
                d.date_range = $('#reservation').val();
                d.ajax = 1;
            },
            headers: headers,
        },
        rowId: 'id',
        order: [[1, 'desc']],
        columns: [
            {data: 'serial_number', orderable: false, searchable: false, name: 'id', class: 'align-middle serial_number', targets: 1, render: function (data, type, row) {return '';},download:false},
            {data: 'id', orderable: true, searchable: false, name: 'id', class: 'align-middle title',download:false},
            {data: 'pickup_date', name: 'pickup_date', class: 'align-middle ppd_pickup_date',text:'pickup_date',download:true},
            {data: 'print_performa', name: 'print_performa', class: 'align-middle print_performa',text:'print_performa', orderable: false, searchable: false,download:true},
            {data: 'print_awb', name: 'print_awb', class: 'align-middle print_awb',text:'Column 1', orderable: false, searchable: false,download:true},
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

</script>
@endsection
