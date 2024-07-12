@extends('Admin.layout.main')

@section('styles')
@endsection

@section('content')
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">

            <div class="clearfix"></div>

            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Cancel Booked Packets </h2>
                            <div class="clearfix"></div>
                            <div class="col-md-12">
                                @if (session('message'))
                                    <div class="alert alert-success">
                                        {{ session('message') }}
                                    </div>
                                @endif

                                @if (session('error'))
                                    <div class="alert alert-danger">
                                        {{ session('error') }}
                                    </div>
                                @endif
                            </div>
                            <form id="import-csv-cancel-booking" action="" novalidate="novalidate" data-parsley-validate method="post" enctype="multipart/form-data">
                                {{--                        <form action="{{ api_url('manage_booking/csv_cancel_booked_packets') }}" enctype="multipart/form-data" method="post">--}}
                                @csrf
                                <div class="row">
                                    <div class="col-md-6 col-md-offset-3">
                                        <label class="control-label col-md-12 col-sm-12">Batch Status File</label>
                                        <div class="col-md-12 col-sm-12">
                                            {{--                                        <input type="file" id="file" name="file" required="required" class="form-control">--}}
                                            <input type="file" id="file" name="file" data-rule-required="true"  data-msg-required="Please Upload Csv File First" class="form-control"  accept=".csv">
                                            <span class="error-container danger w-100"></span>
                                        </div>
                                    </div>
                                </div>
                                {{--                            <div class="row">--}}
                                {{--                                <div class="col-md-6 col-md-offset-3" style="margin-top: 15px;">--}}
                                {{--                                    <button type="submit" class="btn btn-primary">Upload</button>--}}
                                {{--                                    <button type="button" class="btn btn-default">Cancel</button>--}}
                                {{--                                </div>--}}
                                {{--                            </div>--}}
                                <div class="row">
                                    <div class="col-md-6 col-md-offset-3 col-xs-12 buttons-div" style="margin-top: 10px;">
                                        <div class="col-md-12 download-sample-file">
                                            <a download href="{{ url_secure('sample/cancel_booking_sample_file.csv') }}" class="btn btn-info btn-sm"> <i class="fa fa-download" aria-hidden="true"></i> download sample file</a>
                                            <button type="submit" class="btn btn-primary col-md-2 upload-button btn-sm">Upload</button>
                                        </div>

                                        {{--                                    <a href="<?php echo url_secure('merchant/booking') ?>"><button type="button" class="btn btn-default col-md-2">Cancel</button></a>--}}
                                    </div>
                                </div>
                            </form>

                            <div class="col-md-6 col-md-offset-3 " style="margin-top: 15px">
                                <span><a href="javascript:void(0)">click here</a> to download sample</span>
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

    <script src="<?php echo url_secure('vendors/validate/jquery.validate.min.js') ?>" type="text/javascript"></script>
    <script>
        const token = getToken();
        const headers = {
            "Authorization": `Bearer ${token}`,
        };

        $("#import-csv-cancel-booking").validate({
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
                        var data = $('#import-csv-cancel-booking')[0];
                        var formData = new FormData(data);
                        formData.append('file', formData);

                        // console.log(formData);

                        $.ajax({
                            url: '<?php echo api_url('manage_booking/csv_cancel_booked_packets'); ?>',
                            method: 'POST',
                            data:formData,
                            headers: headers,
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
                                        text: data.message,
                                        showConfirmButton: true,
                                        confirmButtonColor: '#ffca00',
                                    });
                                    // setTimeout(myURL, 2000);
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

        function myURL() {
            window.location.href = '<?php echo url_secure("manage_booking/shipper_advice") ?>';
        }

    </script>

@endsection
