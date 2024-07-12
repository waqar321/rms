@extends('Admin.layout.main')

@section('styles')@endsection

@section('title') Materials Assignment @endsection

@section('content')
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Manage Material Assignment</h3>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>{{ (Request::segment(3) == 'edit') ? 'Edit' : 'Add' }}</h2>
                            <ul class="nav navbar-right panel_toolbox justify-content-end">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">

                            <br/>
                            <form id="material-form" data-parsley-validate class="form-horizontal form-label-left">
                                <input type="hidden" value="" disabled name="id">

                                <div class="col-md-12 mb-4">
                                    <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                        <label>City</label>
                                        <select name="city_id" id="city_id" class="form-control select2" onchange="getClientByCity()">
                                            <option value="">- Select a City For Client -</option>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                        <label>Client</label>
                                        <select class="form-control select2" name="merchant_id" id="merchant_id"
                                                data-rule-required="true" data-msg-required="Client field is required"></select>
                                        <span class="error-container danger w-100"></span>
                                    </div>
                                </div>

                                <div class="col-md-12 mb-4" id="material">
                                    <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                        <label>Material</label>
                                        <select name="material_id" id="material_id" class="form-control select2"></select>
                                        <span class="error-container danger w-100"></span>
                                    </div>

                                    <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                        <label>Material Quantity</label>
                                        <input type="number" name="material_quantity" id="material_quantity" class="form-control">
                                        <span class="error-container danger w-100"></span>
                                    </div>
                                </div>

                                <div class="col-md-12 mb-4" id="range" style="display: none">
                                    <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                        <label>From</label>
                                        <input type="number" name="flyer_range_from" id="flyer_range_from" class="form-control">
                                        <span class="error-container danger w-100"></span>
                                    </div>

                                    <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                        <label>To</label>
                                        <input type="number" name="flyer_range_to" id="flyer_range_to" class="form-control">
                                        <span class="error-container danger w-100"></span>
                                    </div>
                                </div>

                                <div class="col-md-12 col-sm-12 col-xs-12" id="material-assignment-fields">


                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                        <label>AWB or CN Number</label>
                                        <input type="text" name="cn_number" id="cn_number" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-12 col-sm-12 col-xs-12">

                                    <div class="form-group">
                                        <a href="{{ url_secure('manage_client/material/assignment') }}">
                                            <button class="btn btn-danger" type="button">Cancel</button>
                                        </a>
                                        <button type="submit" class="btn btn-success">{{ (Request::segment(3) == 'edit') ? 'Update' : 'Submit' }}</button>
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
        const headers = {
            "Authorization": `Bearer ${token}`,
        };

        $("#material-form").validate({
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
                        var data = $('#material-form').serialize();
                        $.ajax({
                            url: '<?php echo api_url('manage_client/material/assignment/submit'); ?>',
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
                                    window.location.href = '<?php echo url_secure('/manage_client/material/assignment') ?>'
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

        const url = window.location.search;
        if (url) {
            const urlParams = new URLSearchParams(url);
            const id = atob(urlParams.get('id'));
            $.ajax({
                url: '<?php echo api_url('manage_client/material/assignment/edit'); ?>',
                method: 'GET',
                data: {ajax: true, id: id},
                headers: headers,
                dataType: 'json', // Set the expected data type to JSON
                beforeSend: function () {
                    $('.error-container').html('');
                },
                success: function (data) {
                    if (data && data.status == 1) {
                        editForm(data.data.material_assignment);
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
        }else{
            var material = document.getElementById('material');
            material.style.display = "none";
            $.ajax({
                url: '<?php echo api_url('manage_client/merchant/getPackingMaterial'); ?>',
                method: 'GET',
                data: {ajax: true},
                headers: headers,
                dataType: 'json', // Set the expected data type to JSON
                beforeSend: function () {
                    $('.error-container').html('');
                },
                success: function (data) {
                    if (data && data.status == 1) {
                        getMaterialForMaterialAssignment(data.data);
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
            function getMaterialForMaterialAssignment(packingMaterialItem){
                console.log(packingMaterialItem)
                var packingItemDiv = document.getElementById("material-assignment-fields");
                var packingItemContent = `<table border="1" cellpadding="0" cellspacing="0" style="width: 100%" id="fields-table">
                                        <thead>
                                        <tr>
                                            <th rowspan="2" class="text-center">Fields</th>
                                            <th rowspan="2" class="text-center">Quantity</th>
                                            <th colspan="2" class="text-center">Serial Number</th>
                                        </tr>
                                        <tr>
                                            <th class="text-center">From</th>
                                            <th class="text-center">To</th>
                                        </tr>
                                        </thead>
                                        <tbody >

                                        `;
                Object.keys(packingMaterialItem).forEach(function (index) {
                    var packingItemValue = packingMaterialItem[index];
                    var flyerFrom = '';
                    var flyerTo = '';
                    if(packingItemValue.material_name == 'Medium Flyer\r\n'){
                        flyerFrom = `<input type="number" class="form-control" name="flyer_range_from[]" value="0">`;
                        flyerTo = `<input type="number" class="form-control" name="flyer_range_to[]" value="0">`;
                    }
                    else if(packingItemValue.material_name == 'Large Flyer\r\n'){
                        flyerFrom = `<input type="number" class="form-control" name="flyer_range_from[]" value="0">`;
                        flyerTo = `<input type="number" class="form-control" name="flyer_range_to[]" value="0">`;
                    }
                    else if(packingItemValue.material_name == 'Small Flyer\r\n'){
                        flyerFrom = `<input type="number" class="form-control" name="flyer_range_from[]" value="0">`;
                        flyerTo = `<input type="number" class="form-control" name="flyer_range_to[]" value="0">`;
                    } else{
                        flyerFrom = `<input type="hidden" class="form-control" name="flyer_range_from[]" value="0">`;
                        flyerTo = `<input type="hidden" class="form-control" name="flyer_range_to[]" value="0">`;
                    }
                    var packingItemContent1 = `<tr>
                                            <th class="text-center"><input type="hidden" name="material_id[]" value="`+packingItemValue.id+`" class="form-control">`+packingItemValue.material_name+`</th>
                                            <td><input type="number" name="material_quantity[]" value="0" class="form-control"></td>
                                            <td><input type="hidden" name="material_name[]" value="`+packingItemValue.material_name+`" class="form-control">`+flyerFrom+`</td>
                                            <td>`+flyerTo+`</td>
                                        </tr>`;
                    packingItemContent += packingItemContent1;
                });

                var packingItemContent2 = '</tbody></table>';
                packingItemContent += packingItemContent2;
                packingItemDiv.innerHTML = packingItemContent;

            }
        }

        function editForm(data) {
            var keys = Object.keys(data);
            var values = Object.values(data);

            var material = document.getElementById('material');
            var range = document.getElementById('range');

            material.style.display = "block";

            if(data.flyer_range_from != 0 && data.flyer_range_to != 0){
                range.style.display = "block";
            }


            $(keys).each(function (index, element) {
                console.log(element);
                var input = $('input[name="' + element + '"], textarea[name="' + element + '"], select[name="' + element + '"]');
                if (input.is(':checkbox')) {
                    if (input.val() === values[index]) {
                        input.prop('checked', true);
                    }
                } else if (input.is('select')) {
                    if (data.merchant.city.id) {
                        option = new Option(data.merchant.city.city_name, data.merchant.city.id, true, true);
                        $('#city_id').append(option).trigger('change');
                    }
                    if (element === 'merchant_id' && data.merchant.id) {
                        option = new Option(data.merchant.merchant_name, data.merchant.id, true, true);
                        $('#merchant_id').append(option).trigger('change');
                    }
                    if (element === 'material_id' && data.material.id) {
                        option = new Option(data.material.material_name, data.material.id, true, true);
                        $('#material_id').append(option).trigger('change');
                    }
                    else {
                        input.val(values[index]);
                        input.trigger('change');
                    }
                }
                else if (input.is(':radio')) {
                    $(`input[name="${element}"][value=${values[index]}]`).trigger('click');
                } else {
                    if (element === 'id') {
                        input.prop('disabled', false);
                    }
                    input.val(values[index]);
                }
            });
        }

        $(document).ready(function() {

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

            $("#merchant_id").select2({
                placeholder: "Search By Client",
                minimumInputLength: 2, // Minimum characters before sending the AJAX request
                allowClear: true,
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

            $("#material_id").select2({
                placeholder: "Search By Material",
                // minimumInputLength: 2, // Minimum characters before sending the AJAX request
                allowClear: true,
                ajax: {
                    url: "{{ api_url('material_list') }}", // Replace with your actual server endpoint
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

        });

        function getClientByCity(){
            $("#merchant_id").select2({
                placeholder: "Search By Client",
                minimumInputLength: 2, // Minimum characters before sending the AJAX request
                allowClear: true,
                ajax: {
                    url: "{{ api_url('clients_list') }}?city_id="+$('#city_id').val(), // Replace with your actual server endpoint
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
