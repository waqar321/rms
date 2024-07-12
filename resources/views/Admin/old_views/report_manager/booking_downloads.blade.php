@extends('Admin.layout.main')
@section('title')
   Booking Details
@endsection
@section('styles')

@endsection

@section('content')
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Booking Details</h3>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2 class="col-md-8">DOWNLOAD CUSTOMIZED & FILTERED BOOKING DETAILS</h2>
                            <ul class="nav navbar-right panel_toolbox justify-content-end">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                    <form id="report-generator" action="" novalidate="novalidate" data-parsley-validate
                                  enctype="multipart/form-data" class="form-horizontal form-label-left" method="POST">
                        <div class="col-md-12">
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <label>Search By Date</label>

                                    <fieldset>
                                        <div class="control-group">
                                            <div class="controls">
                                                <div class="input-prepend input-group">
                                                        <span class="add-on input-group-addon"><i
                                                                    class="fa fa-calendar"></i></span>
                                                    <input type="text" name="reservation"
                                                        id="reservation" class="form-control"
                                                        value="">
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                            </div>

                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <label>Search By Client City</label>
                                    <select class="form-control select2" name="city_id" id="city_id">
                                        <option value="">View All</option>
                                    </select>
                            </div>

                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <label>Search By Clients</label>
                                <select class="form-control select2" name="merchant_id" id="merchant_id">
                                    <option value="">View All</option>
                                </select>
                            </div>
                        </div>

                        <div class="x_content">
                            <br/>

                            <!-- <form id="report-generator" action="" novalidate="novalidate" data-parsley-validate
                                  enctype="multipart/form-data" class="form-horizontal form-label-left" method="POST"> -->

                                <div class="col-md-6">
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

    <script src="<?php echo url_secure('vendors') ?>/validate/jquery.validate.min.js" type="text/javascript"></script>
    <script>

        $(document).ready(function() {
            getMerchantList();
            getCitiesList();
            // Remove default value from the input field
            $('#reservation').val('');
        });

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
                        // console.log(formData);
                        $.ajax({
                                    url: '<?php  echo api_url('report_manager/booking_downloads/submit')  ?>', // Replace with your backend URL
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
                                        a.download = 'booking_downloads_' + new Date().toISOString().slice(0, 10) + '.csv';

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
                        })
                    }
        });

        function downloadFile(){
            var formData = new FormData($("#report-generator")[0]);
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

        }

        function getMerchantList(){

            $("#merchant_id").select2({
                    placeholder: "Search By Client",
                    minimumInputLength: 2, // Minimum characters before sending the AJAX request
                    allowClear: false,
                    ajax: {
                        url: "{{ api_url('clients_list') }}", // Replace with your actual server endpoint
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
        }

        function getCitiesList(){

            $("#city_id").select2({
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
        }

    </script>

@endsection
