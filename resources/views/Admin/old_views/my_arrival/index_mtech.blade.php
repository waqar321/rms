@extends('Admin.layout.main')
@section('title', 'My Arrivals M-Tech')
@section('styles')

@endsection
@section('content')
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>My Arrivals M-Tech</h3>
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

                        <div class="col-md-12 mt-4">
                            <div class="col-md-4">
                                <label>Date</label>
                                {{--                                <form class="form-horizontal">--}}
                                {{--                                    <fieldset>--}}
                                {{--                                        <div class="control-group">--}}
                                {{--                                            <div class="controls">--}}
                                {{--                                                --}}
                                {{--                                            </div>--}}
                                {{--                                        </div>--}}
                                {{--                                    </fieldset>--}}
                                {{--                                </form>--}}
                                <div class="input-prepend input-group">
                                                    <span class="add-on input-group-addon"><i
                                                            class="fa fa-calendar"></i></span>
                                    <input type="text" style="width: 272px" name="reservation"
                                           id="reservation" class="form-control"
                                           value=""/>
                                </div>
                            </div>
                            <div class="col-md-4 ">
                                <div class="form-group">
                                    <label class="">Origin </label>
                                    <select data-rule-required="true"  data-msg-required="This field is required" class="form-control" id="origin_city" name="origin_city">
                                        <option selected disabled>Choose option</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 ">
                                <div class="form-group">
                                    <label class="">Destination</label>
                                    <select data-rule-required="true"  data-msg-required="This field is required" class="form-control" name="destination_city" id="destination_city">
                                        <option selected disabled>Choose option</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-12">
                            <div class="col-md-4 ">
                                <div class="form-group">
                                    <label >Status</label>
                                    <select id="status" class="form-control select2"  multiple="multiple">
                                        <option disabled>Please Select Packet Status</option>
                                    </select>
                                </div>
                            </div>
                            <!-- <div class="col-md-4 ">
                                <div class="form-group">
                                    <label >Shippers</label>
                                    <select id="shipper_id" name="shipper_id" class="form-control select2" >
                                        <option selected value="">Choose option</option>
                                    </select>
                                </div>
                            </div> -->
                            <div class="col-md-3 col-sm-3 col-xs-12 mt-4">
                                <button type="button"  onclick="search()" class="btn btn-primary">Filter</button>
                            </div>
                        </div>
                        <div class="x_content">
                            <form method="POST" enctype="multipart/form-data" action="#" id="export-csv" data-screen-permission-id="186">
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
                                    <th >Sr#</th>
                                    <th >Status&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                    <th>CN#</th>
                                    <th>Company Account</th>
                                    <th>Order ID</th>
                                    <th>Origin</th>
                                    <th>Destination</th>
                                    <th>Shipper</th>
                                    <th>Consignee</th>
                                    <th>Cons. Address</th>
                                    <th>Booking Date</th>
                                    <th>Created At</th>
                                    <th>COD Amount</th>
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


    <div class="modal fade bd-example-modal" id="status_update" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Status Update</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="reason-error" class="alert alert-danger" style="display:none;">
                        Please Provide Reason...
                    </div>
                    <div id="reciever-error" class="alert alert-danger" style="display:none;">
                        Please Provide Receiver Name and Relation...
                    </div>
                    <div class="row">

                        <form id="status_update_form" action="" novalidate="novalidate" data-parsley-validate class="form-horizontal form-label-left" method="post">
                            <input type="hidden" id="bookedPacketID" name="bookedPacketID">
                            <div class="col-md-12 ">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select style="width: 100%;" id="booked_packet_status" name="booked_packet_status" data-rule-required="true"  data-msg-required="This is required"
                                            class="form-control select2">
                                        <option selected value="">Please Select Packet Status</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 ">
                                <div class="form-group receiver" style="display: none;">
                                    <label >Receiver Name</label>
                                    <input type="text" class="form-control" name="receiver_name" id="receiver_name">
                                </div>
                            </div>
                            <div class="col-md-6 ">
                                <div class="form-group relation" style="display: none;">
                                    <label >Relation</label>
                                    <select style="width: 100%;" class="form-control select2" id="packet_relation" name="packet_relation">
                                        <option value=""> - Select -</option>
                                        <option value="1">Testing Relation</option>

                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 ">
                                <div class="form-group reason_box" style="display: none;">
                                    <label >Reason</label>
                                    <select style="width: 100%;" class="form-control select2" id="reason_id" name="reason_id">
                                        <option value=""> - Select -</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 ">
                                <div class="form-group">
                                    <label >Comments</label>
                                    <textarea name="comments" id="comments" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="col-md-12 ">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade bd-example-modal-lg" id="packet_detail_mtech" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <p class="modal-title" id="exampleModalLabel">Tracking Info</p>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="packet_body" style="height:auto">

                    </div>
                    <!-- <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div> -->
                </div>
            </div>
        </div>

@endsection

@section('scripts')
    <script src="<?php echo url_secure('vendors') ?>/validate/jquery.validate.min.js" type="text/javascript"></script>
    <script src="{{ url_secure('build/js/main.js')}}"></script>



    <script>
        const token = getToken();
        const headers = {
            "Authorization": `Bearer ${token}`,
        };

        $(document).ready(function() {
            $("#origin_city").select2({
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
            $("#destination_city").select2({
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

            $("#shipper_id").select2({
                placeholder: "Search Shipper",
                minimumInputLength: 2, // Minimum characters before sending the AJAX request
                allowClear: true,
                ajax: {
                    url: "{{ api_url('manage_client/shipper/get_shippersByName') }}", // Replace with your actual server endpoint
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

            var statusRequest = $.ajax({
                url: '{{ api_url('get_status') }}',
                method: 'GET',
                dataType: 'json',
                headers: headers,
                beforeSend: function() {
                    $('.error-container').html('');
                }
            });
            var reasonRequest = $.ajax({
                url: '{{ api_url('manage_booking/my_arrivals/booked_packet_reasons') }}',
                method: 'GET',
                dataType: 'json',
                headers: headers,
                beforeSend: function() {
                    $('.error-container').html('');
                }
            });
            $.when(statusRequest,reasonRequest).done(function(statusData,reasonData) {
                var statusOption = '';
                var CheckedArray = [0,1,2,3,7,19,20];
                selected="";
                $.each(statusData[0].data.status, function(index, value) {
                    selected="";
                    if (!CheckedArray.includes(value.id)) {
                        selected="selected";
                    }

                    statusOption += `<option value="${value.id}" ${selected}>${value.title}</option>`;
                });
                $('#status').append(statusOption);
                $('#booked_packet_status').append(statusOption);


                var ReasonOption = '';
                $.each(reasonData[0].data.reasons, function(index, value) {
                    ReasonOption += `<option  value="${value.id}"> ${value.title} </option>`;
                });
                $('#reason_id').append(ReasonOption);
                search();
            });

        });
    </script>

    <script>
        var selected_rows = [];
        var table = $('#datatable').DataTable({
            dom: '<"search-box"f>l  <"col-md-12" <"float-right" B> ><"datatable-wrapper"rt><"datatable-info"i><"datatable-pagination"p>',
            search: {
                return: true
            },
            "deferLoading": 0,
            buttons: [],
            "scrollX": true,
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
                url: '<?php echo api_url('manage_booking/my_arrivals/my_arrival_mtech') ?>',
                data: function (d) {
                    d.ajax = 1;
                    d.status = $('#status').val();
                    d.date = $('#reservation').val();
                    d.origin_city = $('#origin_city').val();
                    d.destination_city = $('#destination_city').val();
                    d.shipper_id = $('#shipper_id').val();
                },
                headers: headers,
            },
            rowId: 'id',
            order: [[11, 'desc']],
            columns: [
                {data: 'serial_number', orderable: false, searchable: false, name: 'serial_number', class: 'align-middle serial_number', targets: 1, render: function (data, type, row) {return '';} ,download:false},
                {data: 'booked_packet_status_message', name: 'st.title', class: 'align-middle booked_packet_status_message',text:'Status' ,download:true},
                {data: 'booked_packet_cn', name: 'bp.booked_packet_cn', class: 'align-middle booked_packet_cn',text:'CN ID#' ,download:true},
                {data: 'merchant_account_no', name: 'em.company_account_no', class: 'align-middle company_account_no',text:'Company Account',download:true},
                {data: 'booked_packet_order_id', name: 'bp.booked_packet_order_id', class: 'align-middle booked_packet_order_id',text:'Order ID',download:true},
                {data: 'origin_city', name: 'or.city_name_eng', class: 'align-middle origin_city',text:'Origin',download:true},
                {data: 'destination_city', name: 'ds.city_name_eng', class: 'align-middle destination_city',text:'Destination' ,as : 'destination_city',download:true},
                {data: 'shipper_name', name: 'bp.shipment_name_eng', class: 'align-middle shipper_name',text:'Shipper',download:true},
                {data: 'consignee_name', name: 'bp.consignment_name_eng', class: 'align-middle consignee_name',text:'Consignee',download:true},
                {data: 'consignee_address', name: 'bp.consignment_address', class: 'align-middle consignee_address limited',text:'Consignee Address',download:true},
                {data: 'booked_packet_date', name: 'bp.booked_packet_date', class: 'align-middle booked_packet_date',text:'Booking Date',download:true},
                {data: 'created_at', name: 'bp.date_created', class: 'align-middle created_at',text:'Created Date',download:true},
                {data: 'booked_packet_collect_amount', name: 'bp.booked_packet_collect_amount', class: 'align-middle booked_packet_collect_amount',text:'COD Amount',download:true,
                    "render": function (data, type, row) {
                        // Format the number as currency with commas
                        return Math.round(parseFloat(data)).toLocaleString('en-IN');
                    }
                }
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

                    if ($(header).is('.action') ||  $(header).is('.serial_number') ||  $(header).is('.select') || $(header).is('.status') || $(header).is('.is_paid') || $(header).is('.pay_without_payment_received') || $(header).is('.deposited_amount')) {
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

        table.on('processing.dt', function (e, settings, processing) {
            if (processing) {
                $('#datatable tbody').hide();
            } else {
                $('#datatable tbody').show();
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

        option += `<option value="tlbppr.received_amount">Deposit Received</option>`;
        option += `<option value="bp.is_paid">Paid</option>`;
        option += `<option value="bp.pay_without_payment_received">Pay without payment Received</option>`;

        function search(){
            table.draw();
        }

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
                        url: '<?php echo api_url('manage_booking/my_arrivals/downloadCsvOld') ?>', // Replace with your backend URL
                        type: 'GET',
                        headers: headers,
                        data: {
                            selectedValue: selectedValue,
                            selectedTexts: selectedTexts,
                            excel:true,
                            ajax : 1,
                            status : $('#status').val(),
                            date : $('#reservation').val(),
                            origin_city : $('#origin_city').val(),
                            destination_city : $('#destination_city').val(),
                            shipper_id : $('#shipper_id').val()
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

        $('body').on('click','.approve',function () {
            var id = $(this).parents('tr').attr('id');

            Swal.fire({
                title: 'Are you sure?',
                text: "You want to Approve this news",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ffca00',
                cancelButtonColor: '#0e1827',
                cancelButtonText: 'No',
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.isConfirmed) {
                    approveNews(id);
                }
            });


        });
        function approveNews(ids) {
            $.ajax({
                url: '<?php  echo api_url('manage/news/approve')  ?>',
                method: 'POST',
                headers: headers,
                data:{id : ids, table: 'ecom_news'},
                dataType: 'json',
                success: function(data) {
                    if (data && data.status === 1) {
                        Swal.fire({
                            icon: 'success',
                            text: 'Record Has Been Approved Successfully',
                            showConfirmButton: true,
                            confirmButtonColor: '#ffca00',
                        })
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

        $( document ).ready(function() {
            $('#reservation').val('')
        });



        $('#status_update').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var bookedPacketID = button.data('booked_packet_id'); // Extract data from data-* attributes
            var booked_packet_status = button.data('booked_packet_status'); // Extract data from data-* attributes
            $('#booked_packet_status').val(booked_packet_status).trigger('change');
            $('#bookedPacketID').val(bookedPacketID);
        });

        $('body').on('change','#booked_packet_status',function () {
            var status = $(this).val();
            var select_status = $("#booked_packet_status option:selected").text();
            if (select_status == "Pending" || select_status == "Return") {
                $(".reason_box").show();
            } else {
                $(".reason_box").hide();
            }

            if(status == 12){
                $('.receiver').show();
                $('.relation').show();
            }else{
                $('.relation').hide();
                $('.receiver').hide();
            }
        });

        $("#status_update_form").validate({
            errorClass: "danger",
            errorPlacement: function (error, element) {
                error.addClass('w-100').appendTo(element.parent(0));
            },
            submitHandler: function (form, event) {
                event.preventDefault();

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to submit this form!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ffca00',
                    cancelButtonColor: '#0e1827',
                    confirmButtonText: 'Submit'
                }).then((result) => {
                    if (result.isConfirmed) {

                        var booked_packet_status = $("#booked_packet_status option:selected").text();
                        var book_packet_status_id = $("#booked_packet_status option:selected").val();
                        var return_reason = $("#reason_id option:selected").val();
                        var packet_received_by = $("#receiver_name").val();
                        var reciever_relation = $("#packet_relation option:selected").val();
                        var booked_packet_comments = $("#comments").val();
                        var booked_packet_id = $('#bookedPacketID').val();

                        if (booked_packet_status == "Pending" || booked_packet_status == "Return") {
                            packet_received_by = '';
                            reciever_relation = '';
                            if (return_reason == "") {
                                $("#reason-error").show();
                                return false;
                            }
                        } else if (booked_packet_status == "Delivered") {
                            return_reason = '';
                            if (packet_received_by == "" || reciever_relation == "") {
                                $("#reciever-error").show();
                                return false;
                            }
                        } else {
                            packet_received_by = '';
                            reciever_relation = '';
                            return_reason = '';
                        }

                        $.ajax({
                            url: '{{ api_url('manage_booking/my_arrivals/update_status') }}',
                            type: 'POST',
                            dataType: 'json',
                            headers:headers,
                            data: {
                                booked_packet_status: book_packet_status_id,
                                booked_packet_comments: booked_packet_comments,
                                return_reason: return_reason,
                                packet_received_by: packet_received_by,
                                reciever_relation: reciever_relation,
                                booked_packet_id:booked_packet_id,
                                '_token': '{{ csrf_token() }}'
                            },
                            success: function (response) {
                                Swal.fire({
                                    icon: 'success',
                                    text: 'Form has been submitted successfully',
                                    showConfirmButton: true,
                                    confirmButtonColor: '#ffca00',
                                });
                                $('#status_update').modal('hide');
                                table.draw();
                            }
                        });
                    }
                })
            }
        });


    $('#packet_detail_mtech').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var booked_packet_cn = button.data('booked_packet_cn'); // Extract data from data-* attributes
        var is_admin = (button.data('is_admin')) ? button.data('is_admin') : 0;

        $.ajax({
            url: '<?php echo api_url('manage_booking/my_arrivals/track_packet_mtech') ?>', // Replace with your backend URL
            type: 'GET',
            headers:headers,
            data: {booked_packet_cn,is_admin},
            beforeSend: function(){
                $('#packet_body').html('');
                $('#packet_body').html(`<div class="text-center"><img src="${giff_url}" alt="Loading..."></div>`);
            },
            success: function (response) {
                $('#packet_body').html(response);
            },
            error: function (error) {
            }
        });
    });

    </script>





@endsection

