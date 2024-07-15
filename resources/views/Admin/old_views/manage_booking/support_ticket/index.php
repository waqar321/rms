<?= $this->extend('Admin/layout/main') ?>

<?= $this->section('styles') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<!-- page content -->
<div class="right_col" role="main">
    <div class="">

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Support Ticket <small>Listing</small></h2>
                        <div class="clearfix"></div>
                    </div>

                    <div class="row">
<!--                        <div class="col-md-3 col-sm-3 col-xs-12">-->
<!--                            <label class="control-label col-md-12 col-sm-12">Search Ticket</label>-->
<!--                            <div class="col-md-12 col-sm-12">-->
<!--                                <input type="text" id="search" name="search" required="required"-->
<!--                                       class="form-control" placeholder="KL123456789">-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="col-md-3 col-sm-3 col-xs-12">-->
<!--                            <label class="control-label col-md-12 col-sm-12">Date To</label>-->
<!--                            <div class="col-md-12 col-sm-12">-->
<!--                                <input type="date" id="start-date" name="start-date" required="required"-->
<!--                                       class="form-control">-->
<!--                            </div>-->
<!--                        </div>-->
<!---->
<!--                        <div class="col-md-3 col-sm-3 col-xs-12">-->
<!--                            <label class="control-label col-md-12 col-sm-12">Date From</label>-->
<!--                            <div class="col-md-12 col-sm-12">-->
<!--                                <input type="date" id="end-date" name="end-date" required="required"-->
<!--                                       class="form-control">-->
<!--                            </div>-->
<!--                        </div>-->
                        <div class="col-md-4 ">
                            <label style="margin-left: 11px;">Date</label>
                            <form class="form-horizontal">
                                <fieldset>
                                    <div class="control-group">
                                        <div class="controls">
                                            <div class="input-prepend input-group" style="margin-left: 11px;">
                                                    <span class="add-on input-group-addon"><i
                                                                class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                                                <input type="text" style="width: 272px" name="reservation"
                                                       id="reservation" class="form-control"
                                                       value="">
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <label class="control-label col-md-12 col-sm-12">Ticket Status</label>
                            <div class="col-md-12 col-sm-12">
                                <select class="form-control" name="status" id="status" onchange="search()">
                                    <option value="all">View All</option>
                                    <?php foreach($ticketStatuses as $status){ ?>
                                        <option value="<?php echo $status['id']; ?>"><?php echo $status['title']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <label class="control-label col-md-12 col-sm-12">Ticket Type</label>
                            <div class="col-md-12 col-sm-12">
                                <select class="form-control" onchange="search()" name="ticket_type" id="ticket_type">
                                    <option value="">Ticket Type</option>
                                    <?php foreach($ticketTypes as $type){ ?>
                                        <option value="<?php echo $type['id']; ?>"><?php echo $type['title']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <hr>

                    <div class="row" style="margin-top: 3%">
                        <div class="col-md-12">
                            <form method="POST" enctype="multipart/form-data" action="#" id="export-csv" data-screen-permission-id="133">
                                <div class="row">
                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                        <label class="control-label col-md-12 col-sm-12 col-xs-12">Status</label>
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <select name="export[]" multiple id="export">

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-xs-12 mt-4">
                                        <label class="control-label col-md-12 col-sm-12 col-xs-12">&nbsp;</label>
                                        <button type="submit" class="btn btn-primary col-md-3 col-sm-3 col-xs-12">Export</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="clearfix"></div>



                    <div class="x_content">
                        <table id="datatable" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>Sr #</th>
                                <th>Ticket No</th>
                                <th>CN #</th>
                                <th>Ticket Type</th>
                                <th>Destination City</th>
                                <th>Zone</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th>Last Activity By</th>
                                <th>Last Activity Date</th>
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
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>

<script>
    $(document).ready(function() {
        // Remove default value from the input field
        $('#reservation').val('');
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
                text: '<i class="la la-cogs"></i> Add',
                className: 'btn btn-primary add',
                action: function (e, dt, node, config) {
                    window.location = '<?php echo base_url('manage_booking/support_ticket/add') ?>';
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
            url: '<?php echo base_url('manage_booking/support_ticket') ?>',
            data: function (d) {
                d.date = $('#reservation').val();
                d.status = $('#status').val();
                d.ticket_type = $('#ticket_type').val();
                // d.requested_to_date = $('#requested_to_date').val();
                // d.star_shipper_filter = $('#star_shippers_filter').val();
            },
            headers: headers,
        },
        rowId: 'id',
        order: [[5, 'desc']],
        columns: [
            // {data: 'id', orderable: false, searchable: false, class: 'text-center align-middle select select-checkbox p-1', targets: 0, render: function (data, type, row) {return '';} ,download:false},
            {data: 'serial_number', orderable: false, searchable: false, name: 'serial_number', class: 'align-middle serial_number', targets: 1, render: function (data, type, row) {return '';} ,download:false},
            {data: 'ticket_number', name: 'ecom_support_tickets.ticket_number', class: 'align-middle ticket_number',text:'Ticket Number#' ,download:true},
            {data: 'cn_number', name: 'ecom_support_tickets.cn_number', class: 'align-middle cn_number',text:'CN #',download:true},
            {data: 'ticket_title', name: 'ticket_type.title',as:'ticket_title' , class: 'align-middle ticket_title',text:'Ticket Type',download:true},
            {data: 'city_name', name: 'ecom_city.city_name', class: 'align-middle city_name',text:'Destination City',download:true},
            {data: 'zone_name', name: 'ecom_zone.zone_name', class: 'align-middle zone_name',text:'Zone',download:true},
            {data: 'status_title', name: 'status.title' , as : 'status_title' , class: 'align-middle status_title',text:'Status',download:true},
            {data: 'created_at', name: 'ecom_support_tickets.created_at', class: 'align-middle created_at',text:'Date Created',download:true},
            {data: 'created_at', name: 'ecom_support_tickets.created_at', class: 'align-middle created_at',text:'Date Created',download:true},
            {data: 'created_at', name: 'ecom_support_tickets.created_at', class: 'align-middle created_at',text:'Date Created',download:true},
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
                    url: '<?php  echo base_url('manage_booking/support_ticket/downloadCsv')  ?>', // Replace with your backend URL
                    type: 'GET',
                    data: {
                        selectedValue: selectedValue,
                        selectedTexts: selectedTexts,
                        excel:true,
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
    $( "body" ).delegate( ".applyBtn", "click", function() {
        table.draw();
    })


</script>

<?= $this->endSection() ?>

