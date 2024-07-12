@extends('Admin.layout.main')

@section('styles')
    <link rel="stylesheet" href="{{ url_secure('build/css/jquery_ui.css')}}">
    <style>
        .address {
            margin-left: -5px !important;
        }

        .table-tr-class-dynamic-table {
            margin-left: 5px;
            margin-bottom: 0px !important;
        }

        #employee-table tbody tr {
            margin-top: 4px;
        }

        .dynamic-table-input {
            margin-bottom: 1px;
        }

        .radio-settlement {
            margin-top: 11px !important;
        }

        .div-space {
            margin-bottom: 8%;
        }

        .stepContainer {
            height: 550px !important;
        }

        .divider {
            border-top: 1px solid #ccc;
            margin: 20px;
        }
        .float-right{
            padding: 6px;
        }
        .select2-container{
            display: inline;
        }
    </style>
@endsection

@section('title') Packing Material Rates @endsection

@section('content')

    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_content">
                            <h2>Packing Material</h2>
                                <div id="wizard1" class="form_wizard wizard_horizontal">
                                    <div id="step-22">
                                        <form id="company_form2" data-parsley-validate class="form-horizontal form-label-left">
                                            <div class="form-group col-md-12 divider"></div>
                                            <div class="form-group col-md-12" id="packing_material_rate"></div>
                                            <button type="submit" class="btn btn-success">Update</button>
                                        </form>
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
    <script src="{{ url_secure('build/js/jquery_ui.js')}}"></script>
    <script src="<?php echo url_secure('vendors/validate/jquery.validate.min.js') ?>" type="text/javascript"></script>
    <script>
        const token = getToken();
        const headers = {
            "Authorization": `Bearer ${token}`,
        };

        $("#company_form2").validate({
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
                        var data = $('#company_form2').serialize();
                        $.ajax({
                            url: '<?php echo api_url('manage_client/merchant/material_rate_update'); ?>',
                            method: 'POST',
                            data: data,
                            headers: headers,
                            dataType: 'json', // Set the expected data type to JSON
                            ajax: 1,
                            beforeSend: function () {
                                $('.error-container').html('');
                            },
                            success: function (data) {
                                if (data && data.status == 1) {
                                    Swal.fire(
                                        'Saved!',
                                        'Form has been submitted successfully',
                                        'success'
                                    );
                                    window.location.reload();
                                } else {
                                    var errors = (data.errors) ? data.errors : {};
                                    if (Object.keys(errors).length > 0) {

                                        var error_key = Object.keys(errors);
                                        for (var i = 0; i < error_key.length; i++) {
                                            var fieldName = error_key[i];
                                            var errorMessage = errors[fieldName];
                                            if ($('#' + fieldName).length) {
                                                var element = $('#' + fieldName);
                                                var element_error = `${errorMessage}`;
                                                element.next('.error-container').html(element_error);
                                                element.focus();
                                            }
                                        }
                                    }

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
                })
            }
        });

        $(document).ready(function () {

            const url = window.location.search;
            const urlParams = new URLSearchParams(url);
            const id = atob(urlParams.get('id'));

            // get Packing material rate
            $.ajax({
                url: '<?php echo api_url('manage_client/merchant/packing_material'); ?>',
                method: 'GET',
                data: {ajax: true, id: id},
                headers: headers,
                dataType: 'json', // Set the expected data type to JSON
                beforeSend: function () {
                    $('.error-container').html('');
                },
                success: function (data) {
                    if (data && data.status == 1) {
                        if(data.data.material.length > 0){
                            getPackingMaterial(data.data.material);
                        }

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


        });

        function getPackingMaterial(packingMaterialItem){
            var packingItemDiv = document.getElementById("packing_material_rate");
            var packingItemContent = `<label class="control-label col-md-2 col-sm-6 col-xs-12">Packing Material Rate</label>
                                                <div class="col-md-10 col-sm-6 col-xs-12">`;
            Object.keys(packingMaterialItem).forEach(function (index) {
                var packingItemValue = packingMaterialItem[index];
                console.log(packingItemValue);
                var packingItemContent1 = `
                                                    <div class="form-group col-md-6">
                                                        <label class="control-label col-md-4 col-sm-4">`+packingItemValue.material_name+`</label>
                                                        <div class="col-md-8 col-sm-8">
                                                            <input type="hidden" id="id" name="merchant_material_ids[]" value="`+packingItemValue.id+`">
                                                            <input type="number" id="material_value" name="merchant_material_values[]" class="form-control" value="`+packingItemValue.material_value+`" data-rule-required="true" data-msg-required="Client field is required" required>
                                                            <span class="error-container danger w-100"></span>
                                                        </div>
                                                    </div>
                                                `;
                packingItemContent += packingItemContent1;
            });
            packingItemContent2 = `</div>`;
            packingItemContent += packingItemContent2;
            packingItemDiv.innerHTML = packingItemContent;
        }

    </script>


@endsection

