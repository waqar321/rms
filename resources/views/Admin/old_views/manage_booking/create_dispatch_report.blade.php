@extends('Admin.layout.main')

@section('styles')
    <style>
        .body input {
            font-size: 11px;
        }
        .body textarea {
            font-size: 11px;
        }
        .body select {
            font-size: 11px;
        }
    </style>
@endsection

@section('content')
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Create Dispatch Report</h3>
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
                            <hr>

                            <form id="dispatch_form"  action="" novalidate="novalidate" data-parsley-validate class="form-horizontal form-label-left" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">

                                    <div class="col-md-12">
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <label class="control-label col-md-12 col-sm-12">Courier Name</label>
                                            <div class="col-md-12 col-sm-12">
                                                <input type="text" id="courier_name" name="courier_name"
                                                       data-rule-required="true"
                                                       data-rule-message="This Field is Required"
                                                       class="form-control" placeholder="Mohsin Mazhar">
                                                <span class="error-container danger w-100"></span>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <label class="control-label col-md-12 col-sm-12">Courier Code</label>
                                            <div class="col-md-12 col-sm-12">
                                                <input type="text" id="courier_code" name="courier_code"
                                                       data-rule-required="true"
                                                       data-rule-message="This Field is Required"
                                                       class="form-control"    placeholder="40001">
                                                <span class="error-container danger w-100"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                        <label class="control-label col-md-12 col-sm-12">Search In</label>
                                        <div class="col-md-12 col-sm-12">
                                            <select tabindex="2" class="form-control"    id="s_type" name="s_type">
                                                <option value="booked_packet_cn">CN Numbers</option>
                                                <option value="booked_packet_order_id">Order IDs</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                        <label class="control-label col-md-12 col-sm-12">Search Booked Packet (Press Tab)</label>
                                        <div class="col-md-12 col-sm-12">
                                            <input tabindex="1"  type="text" id="booked_packet_cn" name="booked_packet_cn"  class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                        <label class="control-label col-md-12 col-sm-12">Client</label>
                                        <div class="col-md-12 col-sm-12">
                                            <select tabindex="2" class="form-control" id="client_id" name="client_id">
                                            </select>
                                        </div>
                                    </div>

                                </div>
                                <div class="x_content">
                                    <div class="row" style="float: right;padding: 5px" >
                                        <button class="btn btn-danger btn-sm" onclick="clearDispatch();serial = 1;" type="button">Reset Report</button>
                                    </div>
                                    <table id="table_dispatch" class="table table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Sr #</th>
                                            <th>Pickup Date</th>
                                            <th>Searched In</th>
                                            <th>CN Short</th>
                                            <th>CN #</th>
                                            <th>From</th>
                                            <th>To</th>
                                            <th>Consignee Name</th>
                                            <th>COD Amount</th>
                                            <th>Remarks</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                    <div class="col-xs-12" >
                                        <button type="submit" class="btn btn-primary btn-sm">Create Report</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /page content -->
        @endsection

        @section('scripts')
            <script src="{{ url_secure('vendors\validate\validate_1_19_3.min.js') }}"></script>
            <script src="<?php echo url_secure('vendors/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js') ?>"></script>
            <script src="{{ url_secure('build/js/jquery_ui.js')}}"></script>

            <script>
                const token = getToken();
                const getUserData = JSON.parse(getUser());

                const headers = {
                    "Authorization": `Bearer ${token}`,
                };
                var ajaxTimer; // Initialize a timer variable
                var serial = 1;


                $('body').delegate('#booked_packet_cn', 'change', function (e) {

                    var value = $(this).val();
                    var data = $('#dispatch_form').serialize();
                    var s_type = $("#s_type option:selected").text();
                    var s_type_val = $("#s_type").val();
                    var limit = 11;
                    if(s_type_val == 'booked_packet_cn'){
                        limit = 11;
                    }else{
                        limit = 3;
                    }

                    // console.log(data);

                    if (value.length  >= limit) {
                        $.ajax({
                            url: '{{ api_url('manage_booking/get_dispatch_data') }}',
                            method: 'GET',
                            dataType: "json",
                            headers: headers,
                            data: data,
                            success: function (data) {
                                if (data && data.status == 1) {
                                    $.each(data.data, function(i, item) {
                                        var valid_Color = (item.valid_record == 'Valid Record') ? 'green' : 'red';
                                        var table_dispatch = $('#table_dispatch');
                                        var check = saveDispatch(item.cn_short);
                                        if (check) {
                                            var data2 = `<tr>
                                                <td>${serial}
                                                    <input name="cn_no[]" type="hidden" value="${item.id}">
                                                </td>
                                                <td>${item.current_date}</td>
                                                <td>${s_type}</td>
                                                <td>${item.cn_short}</td>
                                                <td>${item.booked_packet_cn}</td>
                                                <td>${item.origin_city}</td>
                                                <td>${item.destination_city}</td>
                                                <td>${item.consignee_name}</td>
                                                <td>${item.booked_packet_collect_amount}</td>
                                                <td style="color:${valid_Color} ">${item.valid_record}</td>
                                                <td><button onclick="removeData(this,${item.cn_short})" type="button" class="btn btn-danger btn-sm remove"><span class="fa fa-times-circle-o"></span></button> </td>
                                            </tr>`;
                                            scan_sound(1);
                                            table_dispatch.append(data2);
                                            serial = parseInt(serial) + 1;
                                            $('#booked_packet_cn').val('');
                                        }
                                    });

                                }else{
                                    scan_sound(2);
                                    $.toaster(data.message, 'Error', 'danger');
                                }
                            },
                            error: function (xhr, textStatus, errorThrown) {
                                scan_sound(2);
                                $.toaster(xhr.responseJSON.message, 'Error', 'danger');
                            },
                            complete: function () {
                                setTimeout(function() {
                                    $('#booked_packet_cn').focus();
                                }, 1000);
                            }
                        });
                    }

                });

                $(document).ready(function () {


                    $("#client_id").select2({
                        placeholder: "Search By Client",
                        minimumInputLength: 2, // Minimum characters before sending the AJAX request
                        allowClear: true,
                        ajax: {
                            url: "{{ api_url('merchant_list') }}", // Replace with your actual server endpoint
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


                    const getCurrentDispatch = JSON.parse(getDispatch());
                    if(getCurrentDispatch) {
                        var sent_data = {s_type: 'cn_short', booked_packet_cn : getCurrentDispatch};
                        $.ajax({
                            url: '{{ api_url('manage_booking/get_dispatch_data') }}',
                            method: 'GET',
                            dataType: 'json',
                            headers: headers,
                            data: sent_data,
                            success: function (data) {
                                if (data && data.status == 1) {
                                    $.each(data.data, function(i, item) {
                                        var valid_Color = (item.valid_record == 'Valid Record') ? 'green' : 'red';
                                        var table_dispatch = $('#table_dispatch');
                                        var data2 = `<tr>
                                                     <td>${serial}
                                                             <input name="cn_no[]" type="hidden" value="${item.id}"><span class="error-container danger w-100"></span>
                                                      </td>
                                                    <td>${item.current_date}</td>
                                                    <td>CN SHORT</td>
                                                    <td>${item.cn_short}</td>
                                                    <td>${item.booked_packet_cn}</td>
                                                    <td>${item.origin_city}</td>
                                                    <td>${item.destination_city}</td>
                                                    <td>${item.consignee_name}</td>
                                                    <td>${item.booked_packet_collect_amount}</td>
                                                    <td style="color:${valid_Color} ">${item.valid_record}</td>
                                                   <td><button onclick="removeData(this,${item.cn_short})" type="button" class="btn btn-danger btn-sm remove"><span class="fa fa-times-circle-o"></span></button> </td>
                                                </tr>`;
                                        table_dispatch.append(data2);
                                        serial = parseInt(serial) + 1;

                                    });

                                } else {
                                    $.toaster(data.message, 'Error', 'danger');
                                }
                            },
                            error: function (xhr, textStatus, errorThrown) {
                                scan_sound(2);
                                $.toaster(xhr.responseJSON.message, 'Error', 'danger');
                            },
                        });
                    }
                });

                function removeData(get,cn_no){
                    $(get).closest('tr').remove();
                    removeDispatch(cn_no)
                }

                function handleScan(event) {
                    // Check if the Enter key is pressed (key code 13)
                    if (event.keyCode === 13) {
                        // Prevent the default behavior (form submission)
                        event.preventDefault();

                        // Place any logic here to handle the scanned input

                        // Refocus on the input field
                        $('#booked_packet_cn').focus();
                    }
                }


                $("#dispatch_form").validate({
                    ignore: "",
                    rules: {
                        'cn_short[]': {
                            required: true
                        }
                    },
                    errorClass: "danger",
                    errorPlacement: function (error, element) {
                        error.addClass('w-100').appendTo(element.parent(0));
                    },
                    submitHandler: function (form, event) {
                        event.preventDefault();
                        if ($("input[name='cn_no[]']").length > 0) {
                            Swal.fire({
                                title: 'Are you sure To Import This Data?',
                                text: "You won't to sumbit this form!",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Submit'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    var formData = new FormData(form);
                                    let sw;
                                    $.ajax({
                                        url: '<?php echo api_url('manage_booking/send_courier_pickup_packetRequest'); ?>',
                                        method: 'POST',
                                        data: formData, // Use the FormData object
                                        processData: false, // Important: tell jQuery not to process the data
                                        contentType: false,
                                        headers: headers,
                                        dataType: 'json',
                                        beforeSend: function (data) {
                                            $('.error-container').html('');
                                            $('.error_class').html('');
                                            let timerInterval;
                                            sw = Swal.fire({
                                                title: '',
                                                html: 'Please Wait',
                                                timer: 5000,
                                                timerProgressBar: true,
                                                didOpen: () => {
                                                    Swal.showLoading()

                                                },
                                                willClose: () => {
                                                    clearInterval(timerInterval)
                                                }
                                            })
                                        },

                                        success: function (data) {
                                            if (data && data.status == 1) {
                                                clearDispatch();
                                                Swal.fire(
                                                    'Saved!',
                                                    'Dispatch Successfully',
                                                    'success'
                                                );

                                            } else {
                                                sw.close();
                                                Swal.fire(
                                                    'Error!',
                                                    '' + data.message,
                                                    'error'
                                                );
                                            }
                                        },
                                        error: function (xhr, textStatus, errorThrown) {
                                            sw.close();
                                            Swal.fire(
                                                'Error!',
                                                'Form submission failed: ' + errorThrown,
                                                'error'
                                            );
                                        }
                                    });
                                }
                            })
                        }else{
                            scan_sound(2);
                            $.toaster('Atleast one CN is Required', 'Error', 'danger');
                        }
                    }
                })

                $("#dispatch_form").on("keypress", ":input", function (event) {
                    if($('#booked_packet_cn').val().length > 0) {
                        $('#booked_packet_cn').trigger('change');
                    }
                    return event.keyCode !== 13; // 13 is the Enter key code
                });

            </script>
@endsection


