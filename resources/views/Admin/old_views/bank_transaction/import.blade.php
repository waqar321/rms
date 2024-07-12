@extends('Admin.layout.main')
@section('title') Bank Transaction Import @endsection
@section('styles')
    <style>
        .note{
            margin-top: 10px;
        }
        .buttons-div{
            margin-top: 15px;
        }
        .download-sample-file{
            margin-bottom: 15px;
        }
        .upload-button{
            margin-left: 10px;
        }
    </style>
@endsection

@section('content')

<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Bank Transactions</h3>
            </div>
        </div>
        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Import  </h2>
                        <ul class="nav navbar-right panel_toolbox justify-content-end">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>

                        <form id="import-csv" action="" novalidate="novalidate" data-parsley-validate method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6 col-md-offset-3">
                                    <label class="control-label col-md-12 col-sm-12 col-xs-12">Import File</label>
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <input type="file" id="csv_file" name="csv_file" data-rule-required="true"  data-msg-required="Please Upload File First" class="form-control"  accept=".csv" style="height:auto">
                                        <span class="error-container danger w-100"></span>
                                        <hr>
                                        <span class="note"><b>Note:</b> please don't replace any column heading name of sample file only data should be replace</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-md-offset-3 col-xs-12 buttons-div">
                                    <div class="col-md-12 download-sample-file">
                                    <a download  href="{{ url_secure('sample/deposit_transaction_sample.csv') }}" class="btn btn-info"> <i class="fa fa-download" aria-hidden="true"></i> download sample file</a>
                                    </div>
                                    <button type="submit" class="btn btn-success col-md-2 upload-button">Upload</button>
                                    <a href="<?php echo url_secure('manage_bank_transaction/import') ?>"><button type="button" class="btn btn-danger btn-default col-md-2">Cancel</button></a>
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
<script src="<?php echo url_secure('vendors/validate/jquery.validate.min.js') ?>" type="text/javascript"></script>
<script>
    const token = getToken();
    const headers = {
        "Authorization": `Bearer ${token}`,
    };
    $("#import-csv").validate({
        errorClass: "danger",
        errorPlacement: function (error, element) {
            error.addClass('w-100').appendTo(element.parent(0));
        },
        submitHandler: function (form, event) {
            event.preventDefault();

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't to upload this file!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ffca00',
                cancelButtonColor: '#0e1827',
                confirmButtonText: 'Submit'
            }).then((result) => {
                if (result.isConfirmed) {
                var data = $('#import-csv')[0];
                var formData = new FormData(data);
                formData.append('csv_file', formData);

                // console.log(formData);

                $.ajax({
                    url: '<?php echo api_url('manage_bank_transaction/import_process'); ?>',
                    method: 'POST',
                    data:formData,
                    headers:headers,
                    dataType: 'json', // Set the expected data type to JSON
                    processData: false, // Prevent jQuery from processing the data
                    contentType: false,
                    beforeSend: function(){
                        $('.error-container').html('');
                    },
                    success: function(data) {
                        if (data && data.status == 1) {
                            Swal.fire({
                                icon: 'success',
                                text: 'Form has been submitted successfully',
                                showConfirmButton: true,
                                confirmButtonColor: '#ffca00',
                            });

                             setTimeout(myURL, 2000);
                        } else {
                            if(data.status === 0){
                                Swal.fire(
                                        'Error!',
                                        data.message,
                                        'error'
                                    );
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

    function myURL() {
        window.location.href = '<?php echo url_secure("manage_bank_transaction") ?>';
    }

</script>

@endsection
