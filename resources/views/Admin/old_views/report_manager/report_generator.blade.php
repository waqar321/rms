@extends('Admin.layout.main')
@section('title')
   Report Generator
@endsection
@section('styles')

@endsection

@section('content')
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Report Generator</h3>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2 class="col-md-6">GENERATE REPORT BY UPLOADING CN NUMBER(S) FILE</h2>
                            <div class="col-md-5 text-right" style="margin-left: 15px">
                                <a download href="{{ url_secure('sample/generate_booking_sample_file.csv') }}" class="btn btn-info btn-sm"> <i class="fa fa-download" aria-hidden="true"></i> Sample file</a>
                                <a download href="{{ url_secure('sample/shipper_ids.csv') }}" class="btn btn-info btn-sm"> <i class="fa fa-download" aria-hidden="true"></i> Shipper ids sample file</a>
                            </div>
                            <ul class="nav navbar-right panel_toolbox justify-content-end">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <br/>

                            <form id="report-generator" action="" novalidate="novalidate" data-parsley-validate
                                  enctype="multipart/form-data" class="form-horizontal form-label-left" method="POST">

                                <div class="col-md-6">
                                    <div class="col-md-12 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label>CN Number Type<span class="danger">*</span></label>
                                            <select name="cn_number_type" class="form-control select2" id="cn_number_type">
                                                <option value="cn_number">CN with Prefix</option>
                                                <option value="cn_short">CN without Prefix</option>
                                            </select>
                                            <span class="error-container danger w-100"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label>CN Numbers File <span class="danger">*</span></label>
                                            <input type="file" id="cn_file" name="cn_file" class="form-control" accept=".csv,.xls,.xlsx" required style="padding: 3px;">
                                            <span class="error-container danger w-100"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label>Report Type<span class="danger">*</span></label>
                                            <select name="report_type" id="report_type" class="form-control select2" onchange="getReportTypeColums(this.value)" required="">
                                                <option value="booking_data">Get Booking Data</option>
                                                <option value="invoice_data">Get Invoice Data</option>
                                                <option value="booking_deposit_data">Get Booking And Deposit Data</option>
                                                <option value="all_packets">Get all packets</option>
                                                <option value="shipper_detail">Get Shipper Detail</option>
                                            </select>
                                            <span class="error-container danger w-100"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label>Available Columns  <input type="checkbox" id="selectAllCheckbox"> Select All</label>
                                            <select id="availableColumns" name="availableColumns[]" class="form-control select2"
                                                    multiple="multiple" disabled>
                                                <option disabled>Please Select Available Columns</option>
                                            </select>
                                            <span class="error-container danger w-100"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                        <div class="form-group">
                                            <a href="<?php echo url_secure('dashboard') ?>"><button class="btn btn-danger cancel-button" type="button">Cancel</button></a>
                                            <button type="submit" class="btn btn-success submit-and-update-button">Submit</button>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-md-6">
                                    <div class="col-md-12 col-sm-12 col-xs-12 mt-3" id="result" style="display: none">
                                        <div class="form-group">
                                            <label>Total Time Taken : <span class="success" id="execution_time"></span></label><br>
                                            <label>Total Cns : <span class="success" id="total_cns"></span></label><br>
                                            <label>Valid Cns : <span class="success" id="valid_cns"></span></label><br>
                                            <label>In valid Cns : <span class="danger" id="invalid_cns"></span></label>
                                        </div>
                                        <div class="col-md-12 col-sm-12 col-xs-12 p-0">
                                            <div class="form-group">
                                                <button type="button" class="btn btn-success submit-and-update-button" id="download-result" onclick="downloadFile()">Download File</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="col-md-12 col-sm-12 col-xs-12 mt-3" id="shipper_detail_download" style="display: none">
                                        <div class="col-md-12 col-sm-12 col-xs-12 p-0">
                                            <div class="form-group">
                                                <button type="button" class="btn btn-success submit-and-update-button" id="download-result" onclick="downloadFile()">Download File</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>


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

    <script src="<?php echo url_secure('vendors') ?>/validate/jquery.validate.min.js" type="text/javascript"></script>
    <script>

        const token = getToken();
        const getUserData = JSON.parse(getUser());
        const headers = {
            "Authorization": `Bearer ${token}`,
        };

        $(document).ready(function () {
            $.ajax({
                url: '{{ api_url('report_manager/report_generator/file/headers') }}',
                method: 'GET',
                dataType: 'json',
                data: { file_header: 'booking_data' },
                headers: headers,
                beforeSend: function () {
                    $('.error-container').html('');
                },
                success: function (data) {
                    var statusOption = '';
                    $.each(data.data, function (index, value) {
                        selected = "";
                        if (data.add_cn_column.includes(value)) {
                            selected = "selected";
                        }
                        statusOption += `<option value="${index}" ${selected}>${value}</option>`;
                    });
                    $('#availableColumns').append(statusOption);
                    var element = document.getElementById('availableColumns');
                    element.disabled = false;
                },
                complete: function (data) {
                }

            });

            $('#availableColumns').select2();

            // Handle "Select All" checkbox
            $('#selectAllCheckbox').on('change', function() {
                if ($(this).prop('checked')) {
                    // If checkbox is checked, select all options
                    $('#availableColumns').find('option').prop('selected', true).end().trigger('change');
                } else {
                    // If checkbox is unchecked, deselect all options
                    $('#availableColumns').find('option').prop('selected', false).end().trigger('change');
                }
            });

            // Handle Select2 change event
            $('#availableColumns').on('change', function() {
                // Update the state of the "Select All" checkbox based on the selected options
                $('#selectAllCheckbox').prop('checked', $(this).find('option:selected').length === $(this).find('option').length);
            });

        });


        function getReportTypeColums(selectedReportType) {
            var element = document.getElementById('availableColumns');
            element.disabled = true;
            var fileHeaders = [];
            $.ajax({
                url: '{{ api_url('report_manager/report_generator/file/headers') }}',
                method: 'GET',
                dataType: 'json',
                data: {file_header: selectedReportType},
                headers: headers,
                beforeSend: function () {
                    $('.error-container').html('');
                },
                success: function (data) {
                    var statusOption = '';
                    $('#availableColumns').empty();
                    $.each(data.data, function (index, value) {
                        selected = "";
                        if (data.add_cn_column.includes(value)) {
                            selected = "selected";
                        }
                        statusOption += `<option value="${index}" ${selected}>${value}</option>`;
                    });
                    $('#availableColumns').append(statusOption);
                    element.disabled = false;
                },
                complete: function (data) {
                }
            });

        }

        $("#report-generator").validate({
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
                        var formData = new FormData(form);
                        $.ajax({
                            url: '<?php echo api_url('report_manager/report_generator/submit'); ?>',
                            method: 'POST',
                            data:formData,
                            processData: false, // Don't process the data (needed for FormData)
                            contentType: false, // Don't set content type (needed for FormData)
                            dataType: 'json',
                            headers: headers,
                            beforeSend: function(){
                                $('.error-container').html('');
                                $('.error_class').html('');
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
                                // $('.error-container').html('');
                            },
                            success: function(data) {


                                if (data && data.status == 1) {
                                    Swal.fire({
                                        icon: 'success',
                                        text: 'Form has been submitted successfully',
                                        showConfirmButton: true,
                                        confirmButtonColor: '#ffca00',
                                    });


                                    if (data.data.length !== 0) {
                                        $('#result').css('display', 'block');
                                        $('#shipper_detail_download').css('display', 'none');
                                        $('#execution_time').html(data.data.execution_time+' Seconds');
                                        $('#total_cns').html(data.data.total_cns);
                                        $('#valid_cns').html(data.data.valid_cns);
                                        $('#invalid_cns').html(data.data.in_valid_cns);
                                    }
                                    if(data.data.length === 0){
                                        $('#shipper_detail_download').css('display', 'block');
                                        $('#result').css('display', 'none');
                                    }


                                    // var button = document.getElementById('download-result');
                                    // button.setAttribute('data-custom-id', data.data.id);
                                    {{--window.location.href = '<?php echo url_secure('/reports_manager/report_generator/result?id=') ?>'+data.data--}}
                                } else {
                                    if(data.status === 0){
                                        var errors = (data.errors) ? data.errors : {};
                                        $('.error-container').html(errors);
                                    }
                                    if(data.status === 2){
                                        for (var i = 0; i < data.errors.length; i++) {
                                            Swal.fire(
                                                'Error!',
                                                data.errors,
                                                'error'
                                            );
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
                })
            }
        });

        function downloadFile(){
            var formData = new FormData($("#report-generator")[0]);
            var dropdown = document.getElementById("report_type");
            var selectedOption = dropdown.options[dropdown.selectedIndex].text;
            $.ajax({
                url: '<?php  echo api_url('report_manager/report_generator/result/download')  ?>', // Replace with your backend URL
                type: 'POST',
                data: formData,
                headers: headers,
                processData: false, // Prevent jQuery from processing the data
                contentType: false, // Prevent jQuery from setting the content type
                success: function (response) {
                    // Create a blob from the response
                    var blob = new Blob([response], { type: 'text/csv' });

                    // Create a temporary URL for the blob
                    var url = window.URL.createObjectURL(blob);

                    // Create a hidden anchor link and set its attributes
                    var a = document.createElement('a');
                    a.href = url;
                    a.download = 'report_generator_' + selectedOption + 'report_' + new Date().toISOString().slice(0, 10) + '.csv';

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

        }

    </script>

@endsection
