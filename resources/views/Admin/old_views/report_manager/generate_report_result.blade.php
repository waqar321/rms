@extends('Admin.layout.main')
@section('title')
    Report Generator Result
@endsection
@section('styles')

@endsection

@section('content')
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Report Generator Result</h3>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Result To Download File</h2>
                            <ul class="nav navbar-right panel_toolbox justify-content-end">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <br/>
                            <div class="col-md-7 col-sm-6 col-xs-12" id="result">
                                <div class="form-group">
                                    <label>Total Time Taken : <span class="success" id="execution_time"></span></label><br>
                                    <label>Total Cns <span class="success">0</span></label><br>
                                    <label>Valid Cns <span class="success">0</span></label><br>
                                    <label>In valid Cns <span class="danger">0</span></label>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                    <div class="form-group">
                                        <a href="<?php echo url_secure('reports_manager/report_generator') ?>"><button class="btn btn-danger cancel-button" type="button">Back</button></a>
                                        <button type="button" class="btn btn-success submit-and-update-button" onclick="downloadFile()">Download File</button>
                                    </div>
                                </div>
                            </div>
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


        const url = window.location.search;
        if (url) {
            const urlParams = new URLSearchParams(url);
            const id = atob(urlParams.get('id'));

            $.ajax({
                url: '<?php echo api_url('report_manager/report_generator/result'); ?>',
                method: 'GET',
                data: {ajax: true, id: id},
                headers: headers,
                dataType: 'json', // Set the expected data type to JSON
                beforeSend: function () {
                    $('.error-container').html('');
                },
                success: function (data) {
                    if (data && data.status == 1) {
                        $('#execution_time').html(data.data.result.execution_time+' Seconds');
                    } else {
                        Swal.fire(
                            'Error!',
                            'Something Went Wrong',
                            'error'
                        );
                    }
                },
                error: function (xhr, textStatus, errorThrown) {
                    // Handle AJAX errors here
                    Swal.fire(
                        'Error!',
                        'Form submission failed: ' + errorThrown,
                        'error'
                    );
                }
            });
        }


        function downloadFile(){
            const url = window.location.search;
            const urlParams = new URLSearchParams(url);
            const id = atob(urlParams.get('id'));
            console.log(id);

            $.ajax({
                url: '<?php  echo api_url('report_manager/report_generator/result/download')  ?>', // Replace with your backend URL
                type: 'GET',
                data: {id:id},
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

        }

    </script>

@endsection
