@extends('Admin.layout.main')
@section('page_title') Import Booking @endsection
@section('styles')
 <style>
    .form-control {
        width: auto;
    }

    div.dataTables_wrapper div.dataTables_length select {
        width: 102px;
    }
    .dataTables_wrapper > .row {
        overflow: auto !important;
    }
     .row{
         display: flow!important;
     }
     .dataTables_info{
         display: none;
     }
     .dataTables_paginate{
         display: none;
     }
    input#file {
        height: 39px;
        font-size: small;
    }
 </style>
 <style>
     /* CSS to reduce the zoom size of a specific div */
     #datatable-responsive2 {
         transform: scale(0.9); /* Adjust the scale value as needed (0.8 reduces to 80% of the original size) */
         transform-origin: top left; /* You can change the transform-origin to suit your needs */
         display: block;
         width: 110%;
     }
     #datatable-responsive2  input textarea select{
         font-size: 10.5px;
     }
     table{
         overflow-x: scroll;
     }
 </style>
@endsection

@section('content')
<!-- page content -->
<div class="right_col" role="main">
    <div class="">

        <div class="clearfix"></div>

        <div class="row" >
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Import Bulk Booked Packets </h2>
                        <div class="clearfix"></div>


                        <form id="upload-data"  action="" novalidate="novalidate" data-parsley-validate class="form-horizontal form-label-left" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="control-label col-md-12 col-sm-12">Dedicated Bulk Booking</label>
                                    <div class="col-md-12 col-sm-12">
                                        <input data-rule-required="true" type="file" id="file" name="file" onchange="readFile()" required="required" class="form-control">
                                        <span class="error-container danger w-100"></span>
                                        <ul class="error_class danger" >
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-md-3 " >
                                    <label class="control-label col-md-12 col-sm-12">&nbsp;</label>
                                    <button type="submit" class="btn btn-primary" id="upload" >Upload</button>
                                </div>
                            </div>
                        </form>

                        <div class="col-md-6 col-md-offset-3 " style="margin-top: 15px">
                            <span><a download href="<?php echo url_secure('/sample/SampleFile_OneAccount.xls') ?>">click here</a> to download sample</span>
                        </div>

                    </div>


                </div>
            </div>
            <form style="display: none;" id="import-data"  action="" novalidate="novalidate" data-parsley-validate class="form-horizontal form-label-left" method="post" enctype="multipart/form-data">
                <table id="datatable-responsive2" class="table table-striped table-bordered" cellspacing="0" width="100%" >
                    <thead>
                        <tr>
                            <th>S#</th>
                            <th>Shipper Name</th>
                            <th>Shipper Phone</th>
                            <th>Shipper Address</th>
                            <th>Shipper Email</th>
                            <th>Origin City Name</th>
                            <th>Consignee Name</th>
                            <th>Consignee Email</th>
                            <th>Consignee Phone</th>
                            <th>Consignee Address</th>
                            <th>Destination City Name</th>
                            <th>Booked Packet Collect Amount</th>
                            <th>Booked Packet OrderID</th>
                            <th>Product Description</th>
                            <th>Booked Packet Weight</th>
                            <th>Shipment Type</th>
                            <th>Number Of Pieces</th>
                            <th>Return City</th>
                            <th>Return Address</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>

                </table>
                <input type="file" id="uploaded_file" name="file" style="display: none">
{{--                <input type="hidden"  name="booked_packet_cn">--}}
                <input type="hidden" value="1" name="is_form">
                <input type="hidden" id="batch_no" name="batch_no">
                <input type="submit"  class="btn btn-primary" value="Import" id="import" >
            </form>

        </div>
    </div>
</div>
<!-- /page content -->
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
<script src="{{ url_secure('vendors\validate\validate_1_19_3.min.js') }}"></script>
<script src="<?php echo url_secure('vendors/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js') ?>"></script>
<script src="{{ url_secure('build/js/jquery_ui.js')}}"></script>

<script>
    const token = getToken();
    const headers = {
        "Authorization": `Bearer ${token}`,
    };
    var shipment_typeOption = '';
    var shipment_type = "";
    $(document).ready(function () {
        $('#menu_toggle').trigger('click');

        $.ajax({
            url: '{{ api_url('manage_booking/get_services') }}',
            method: 'GET',
            dataType: 'json',
            headers: headers,
            beforeSend: function () {
                $('.error-container').html('');
            },
            success: function (data) {
                shipment_typeOption = data.data;
                shipment_type = "<option value='' >Select Shipment Type</option>";
                $.each(data.data, function (index, value) {
                    shipment_type += `<option value="${value.shipment_type_id}">${value.shipment_type_name}</option>`;
                });
            },
            complete: function (data) {
            }

        });
    });

    // var table = $('#datatable-responsive2').DataTable({
    //     lengthMenu: [[50,500, 1000, 5000, 10000, -1], [50,500, 1000, 5000, 10000, 'All']],
    //     pageLength: 5000,
    //     pagingType: 'full_numbers',
    //     processing: true,
    //     "searching": false,
    //     "lengthChange": false,
    //     orderable: false,
    //     // scrollX: true,
    //     // scrollY: true,
    // });

function readFile() {
    document.querySelector('#uploaded_file').files = document.querySelector('#file').files;
}

function readExcelFile() {
  $('#import-data').show();
  var files = document.querySelector('#file').files;
  document.querySelector('#uploaded_file').files = document.querySelector('#file').files;

  if (files.length > 0) {
    // Selected file
    var file = files[0];
    // $('#uploaded_file').val(file.name);
    // Create a new FileReader
    var reader = new FileReader();

    // Read file as binary string
    reader.readAsBinaryString(file);

    // Load event
    reader.onload = function (event) {
      var data = event.target.result;
      var workbook = XLSX.read(data, { type: 'binary' });

      // Assuming you want to read the first sheet of the workbook
      var firstSheetName = workbook.SheetNames[0];
      var worksheet = workbook.Sheets[firstSheetName];

      // Convert worksheet data to an array of objects
      var excelData = XLSX.utils.sheet_to_json(worksheet, { header: 1 });
      // <table> <tbody>
      var tbodyEl = document.getElementById('datatable-responsive2').getElementsByTagName('tbody')[0];
      tbodyEl.innerHTML = "";
      var ship_type = "";
      // Loop through the data and populate the table
      for (var row = 1; row < excelData.length ; row++) {
        var rowData = excelData[row];
        var newRow = tbodyEl.insertRow();
        if(rowData.length > 0) {
            for (var col = 0; col < excelData[0].length; col++) {
                var col_value = (rowData[col]) ? rowData[col]  : '';

                if (col == 0) {
                    newRow.insertCell().innerHTML = `<input  type="hidden" name='count[${row}]' id="count_${row}" class='form-control' >${row}`;
                }

                var newCell = newRow.insertCell();
                fieldName = excelData[0][col].replace(/\s/g, '');
                var rules = "data-rule-required";
                if (fieldName === 'return_address' || fieldName === 'return_city' || fieldName === 'consigneeEmail') {
                    rules = "";
                }
                if (fieldName === 'shipment_type') {
                    ship_type = `<select ${rules}  name="${fieldName}[${row}]" class="form-control " id="${fieldName}_${row}">${shipment_type}</select>`;
                    newCell.innerHTML = ship_type + `<span class="error-container danger w-100"></span>`;
                    if(col_value) {
                        $(`#${fieldName}_${row} option:contains(${col_value.toUpperCase()})`).prop("selected", true);
                    }

                } else if (fieldName === 'consigneeAddress' || fieldName === 'shipperAddress') {
                    newCell.innerHTML = `<textarea ${rules}   name='${fieldName}[${row}]' id="${fieldName}_${row}" class='form-control'>${col_value}</textarea>` + `<span class="error-container danger w-100"></span>`;
                } else {
                    newCell.innerHTML = `<input  ${rules}  type='text' name='${fieldName}[${row}]' id="${fieldName}_${row}" class='form-control' value='${col_value}'>` + `<span class="error-container danger w-100"></span>`;
                }

            }
        }
      }
    };
  } else {
    alert("Please select a file.");
  }
}

function makedata(Result){
    var ErrorData = Result.data;
    var tbodyEl = document.getElementById('datatable-responsive2').getElementsByTagName('tbody')[0];
    tbodyEl.innerHTML = "";
    var ship_type = "";
    $.each(ErrorData, function(row){
        var rowData = ErrorData[row];
        var newRow = tbodyEl.insertRow();
        newRow.insertCell().innerHTML = `<input  type="hidden" name='count[${row}]' id="count_${row}" class='form-control' >${row}`;
        $.each(rowData, function(col,value){
                var col_value = (rowData[col]) ? rowData[col]  : '';
                fieldName = col.replace(/\s/g, '');
                var rules = "data-rule-required";
                if (fieldName === 'return_address' || fieldName === 'return_city' || fieldName === 'consigneeEmail') {
                    rules = "";
                }
                if (fieldName === 'shipment_type') {
                    ship_type = `<select ${rules}  name="${fieldName}[${row}]" class="form-control " id="${fieldName}_${row}">${shipment_type}</select>`;
                    newRow.insertCell().innerHTML = ship_type + `<span class="error-container danger w-100"></span>`;
                    if(col_value) {
                        $(`#${fieldName}_${row}`).val(col_value).trigger('change');
                    }

                } else if (fieldName === 'consigneeAddress' || fieldName === 'shipperAddress' || fieldName === 'ProductDescription') {
                    newRow.insertCell().innerHTML = `<textarea ${rules}   name='${fieldName}[${row}]' id="${fieldName}_${row}" class='form-control'>${col_value}</textarea>` + `<span class="error-container danger w-100"></span>`;
                } else if (fieldName === 'shipperName' || fieldName === 'shipperPhone'|| fieldName === 'shipperEmail'|| fieldName === 'return_city'|| fieldName === 'return_address'|| fieldName === 'consigneeName'|| fieldName === 'consigneePhone'|| fieldName === 'consigneeEmail'|| fieldName === 'DestinationCityName'|| fieldName === 'OriginCityName' || fieldName === 'bookedPacketCollectAmount'|| fieldName === 'bookedpacketorderid'|| fieldName === 'numberOfPieces'|| fieldName === 'bookedPacketWeight') {
                    newRow.insertCell().innerHTML = `<input  ${rules}  type='text' name='${fieldName}[${row}]' id="${fieldName}_${row}" class='form-control' value='${col_value}'>` + `<span class="error-container danger w-100"></span>`;
                }

        });
    });

    var errors = (Result.errors) ? Result.errors : {};
    if (errors) {
        var li = "";
        $.each(errors, function(key,row){
            $.each(row, function(index,value){
                var fieldName = index+'_'+key;
                var errorMessage = key + ': '+ value;
                li+= `<li>${errorMessage}</li>`;
                $('.error_class').html(li);
                $('html, body').animate({
                    scrollTop: 0
                }, 'slow');
                if ($('#' + fieldName).length) {
                    var element = $('#' + fieldName);
                    var element_error = `${errorMessage}`;
                    element.next('.error-container').html(element_error);
                    element.focus();
                }
            });
        });
    }

    Swal.fire(
        'Correct the Remaining Order Detail Below',
        '' + Result.message,
        'success'
    );
}

$(document).ready(function() {
      $("#import-data").validate({
        ignore: "",
        rules: {
            'shipment_type[]': {
                required: true
            }
        },
        errorClass: "danger",
        errorPlacement: function (error, element) {
            error.addClass('w-100').appendTo(element.parent(0));
        },
          submitHandler: function (form, event) {
            event.preventDefault();
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
                    let sw ;
                    $.ajax({
                        url: '<?php echo api_url('manage_booking/UploadPacketData'); ?>',
                        method: 'POST',
                        data: formData, // Use the FormData object
                        processData: false, // Don't process the data (needed for FormData)
                        contentType: false, // Don't set content type (needed for FormData)
                        dataType: 'json',
                        beforeSend: function(data) {
                            $('.error-container').html('');
                            $('.error_class').html('');
                            let timerInterval;
                            sw = Swal.fire({
                                title: '',
                                html: 'Please Wait',
                                timer:5000,
                                timerProgressBar: true,
                                didOpen: () => {
                                    Swal.showLoading()

                                },
                                willClose: () => {
                                    clearInterval(timerInterval)
                                }
                            })
                        },

                        success: function(data) {
                            if (data && data.status == 1) {
                                Swal.fire(
                                    'Saved!',
                                    'Packets Imported Successfully.',
                                    'success'
                                );
                                window.location.href = "<?php echo  url_secure('manage_booking/list')?>"
                            } else {
                                sw.close();
                                if(data.errors) {
                                    $('#import-data').show();
                                    makedata(data);
                                    $('#batch_no').val(data.batch_no);
                                    $('#upload').hide();
                                }else{
                                    Swal.fire(
                                        'Error!',
                                        '' + data.message,
                                        'error'
                                    );
                                }
                            }
                        },
                        error: function(xhr, textStatus, errorThrown) {
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
        }
    })


    $("#upload-data").validate({
        ignore: "",
        errorClass: "danger",
        errorPlacement: function (error, element) {
            error.addClass('w-100').appendTo(element.parent(0));
        },
        submitHandler: function (form, event) {
            event.preventDefault();
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
                    let sw ;
                    $.ajax({
                        url: '<?php echo api_url('manage_booking/UploadPacketData'); ?>',
                        method: 'POST',
                        data: formData, // Use the FormData object
                        processData: false, // Don't process the data (needed for FormData)
                        contentType: false, // Don't set content type (needed for FormData)
                        dataType: 'json',
                        beforeSend: function(data) {
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
                        },

                        success: function(data) {
                            if (data && data.status == 1) {
                                Swal.fire(
                                    'Saved!',
                                    'Packets Imported Successfully.',
                                    'success'
                                );
                                window.location.href = "<?php echo  url_secure('manage_booking/list')?>"
                            } else {
                                sw.close();
                                if(data.errors) {
                                    $('#import-data').show();
                                    makedata(data);
                                    $('#batch_no').val(data.batch_no);
                                    $('#upload').hide();
                                }else{
                                    Swal.fire(
                                        'Error!',
                                        '' + data.message,
                                        'error'
                                    );
                                }
                            }
                        },
                        error: function(xhr, textStatus, errorThrown) {
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
        }
    })
});


</script>



@endsection
