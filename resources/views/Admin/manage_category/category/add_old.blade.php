@extends('Admin.layout.main')

@section('styles')@endsection

@section('title') {{ (Request::segment(3) == 'edit') ? 'Edit' : 'Add' }} Category @endsection

@section('content')

    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Manage Categories</h3>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>{{ (Request::segment(3) == 'edit') ? 'Edit' : 'Add' }} Category </h2>
                            <ul class="nav navbar-right panel_toolbox justify-content-end">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">

                            <br/>
                            <form id="category_form" action="" novalidate="novalidate" data-parsley-validate
                                  class="form-horizontal form-label-left" method="post">
                                <input type="hidden" value="" disabled name="id">

                                <!-- <div class="row">
                                    <h4 class="location-detail col-md-12 col-sm-12 col-xs-12">
                                        <b>Category Detail :</b>
                                        <hr class="mb-1 mt-1">
                                    </h4>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label>Country<span class="danger">*</span></label>
                                            <select data-rule-required="true" data-msg-required="This is required"
                                                    name="country_id" id="country_id" class="form-control select2">
                                                <option value="">- Select a Country -</option>
                                            </select>
                                            <span class="error-container danger w-100"></span>
                                        </div>
                                    </div> 
                                     <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label>State<span class="danger">*</span></label>
                                            <select data-rule-required="true" data-msg-required="This is required"
                                                    name="state_id" id="state_id" class="form-control select2">
                                                <option value="">- Select a State -</option>
                                            </select>
                                            <span class="error-container danger w-100"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <h4 class="location-detail col-md-12 col-sm-12 col-xs-12">
                                        <b>City Detail :</b>
                                        <hr class="mb-1 mt-1">
                                    </h4>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label>Select City Via</label>
                                            <select name="city_via" id="city_via" class="form-control select2">
                                                <option value="">- Select a City -</option>
                                                <option value="0">Self</option>
                                            </select>
                                            <span class="error-container danger w-100"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label>City Name<span class="danger">*</span></label>
                                            <input data-rule-required="true" data-msg-required="This is required"
                                                   name="city_name" id="city_name" class="form-control">
                                            <span class="error-container danger w-100"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label>City Abbr<span class="danger">*</span></label>
                                            <input data-rule-required="true" data-msg-required="This is required"
                                                   name="city_abbr" id="city_abbr" class="form-control">
                                            <span class="error-container danger w-100"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12">

                                        <div class="form-group ">
                                            <label>COD Email<span class="danger">*</span></label>
                                            <input data-rule-required="true" data-msg-required="This is required"
                                                   name="city_email" id="city_email" class="form-control">
                                            <span class="error-container danger w-100"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <h4 class="location-detail col-md-12 col-sm-12 col-xs-12">
                                        <b>Zone Detail (Optional) :</b>
                                        <hr class="mb-1 mt-1">
                                    </h4>
                                    <div class="col-md-6 col-sm-6 col-xs-12">

                                        <div class="form-group ">
                                            <label>COD Zone
                                            </label>
                                            <select name="zone_id" id="zone_id" class="form-control select2">
                                                <option value="">- Select a COD Zone -</option>

                                            </select>
                                            <span class="error-container danger w-100"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12">

                                        <div class="form-group ">
                                            <label>Overland Zone</label>
                                            <select name="overland_zone_id" id="overland_zone_id"
                                                    class="form-control select2">
                                                <option value="">- Select Overland Zone -</option>

                                            </select>
                                            <span class="error-container danger w-100"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12">

                                        <div class="form-group">
                                            <label>Detain Zone</label>
                                            <select name="color_zone_id" id="color_zone_id"
                                                    class="form-control select2">
                                                <option value="">- Select a Detain Zone -</option>

                                            </select>
                                            <span class="error-container danger w-100"></span>
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <h4 class="location-detail col-md-12 col-sm-12 col-xs-12">
                                        <b>Availability :</b>
                                        <hr class="mb-1 mt-1">
                                    </h4>
                                    <div class="col-md-3 col-sm-3 col-xs-12">

                                        <div class="form-group">
                                            <label>Allow as Origin
                                            </label>
                                            <input type="checkbox" value="1" id="origin_allow" name="origin_allow">
                                            <span class="error-container danger w-100"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-3 col-xs-12">

                                        <div class="form-group">
                                            <label>Allow as Destination</label>
                                            <input value="1" type="checkbox" id="destination_allow"
                                                   name="destination_allow">
                                            <span class="error-container danger w-100"></span>
                                        </div>
                                    </div>
                                </div> -->

                                <div class="row">
                                    <h4 class="location-detail col-md-12 col-sm-12 col-xs-12">
                                        <b>Category Detail :</b>
                                        <hr class="mb-1 mt-1">
                                    </h4>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label>Category Name<span class="danger">*</span></label>
                                            <input data-rule-required="true" data-msg-required="This is required"
                                                   name="name" id="name" class="form-control">
                                            <span class="error-container danger w-100"></span>
                                        </div>
                                    </div>
                                        <!-- Add input for category image -->
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label>Category Image</label>
                                            <input type="file" name="category_image" id="category_image" class="form-control">
                                            <span class="error-container danger w-100"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <a href="<?php echo url_secure('manage_location/city') ?>">
                                            <button class="btn btn-danger cancel-button" type="button">Cancel</button>
                                        </a>
                                        <button type="submit"
                                                class="btn btn-success submit-and-update-button">{{ (Request::segment(3) == 'edit') ? 'Update' : 'Submit' }}</button>
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

@endSection

@section('scripts')
    <script src="<?php echo url_secure('vendors') ?>/validate/jquery.validate.min.js" type="text/javascript"></script>
    <script>

        var token = getToken();

        var headers011 = {
            "Authorization": `Bearer ${token}`,
        };

        function loadAjax(EditData = []) 
        {
         
            $.ajax({
                url: '<?php echo api_url('category-management/category/data_list'); ?>',
                method: 'GET',
                headers: headers011,
                dataType: 'json', // Set the expected data type to JSON
                beforeSend: function () {
                    $('.error-container').html('');
                },
                success: function (data) 
                {
                    console.log(data);

                    var option1 = "";
                    var option2 = "";
                    var option3 = "";
                    var option4 = "";
                    var option5 = "";
                    var option6 = "";

                    // $.each(data.countries, function (index, value) {
                    //     option1 += `<option value="${value.id}">${value.country_name}</option>`
                    // });

                    // $.each(data.cities, function (index, value) {
                    //     option2 += `<option value="${value.id}">${value.city_name}</option>`
                    // });

                    // $.each(data.states, function (index, value) {
                    //     option3 += `<option value="${value.id}">${value.state_name}</option>`
                    // });

                    // $.each(data.zones, function (index, value) {
                    //     option4 += `<option value="${value.id}">${value.zone_name}</option>`
                    // });

                    // $.each(data.overland_zones, function (index, value) {
                    //     option5 += `<option value="${value.id}">${value.overland_zone_name}</option>`
                    // });

                    // $.each(data.color_zones, function (index, value) {
                    //     option6 += `<option value="${value.id}">${value.color_zone_name}</option>`
                    // });

                    // $('#country_id').append(option1);
                    // $('#city_via').append(option2);
                    // $('#state_id').append(option3);
                    // $('#zone_id').append(option4);
                    // $('#overland_zone_id').append(option5);
                    // $('#color_zone_id').append(option6);

                    if (EditData) 
                    {
                        editForm(EditData);
                    }
                },
                error: function (xhr, textStatus, errorThrown) {

                }
            });
        }

        $("#category_form").validate({
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
                }).then((result) => 
                {
                    if (result.isConfirmed) 
                    {
                        var data = $('#category_form').serialize();
                        console.log(data);
                        return false;
                       
                        $.ajax({
                            url: '<?php echo api_url('category-management/category/submit'); ?>',
                            method: 'POST',
                            data: data,
                            headers: headers011,
                            dataType: 'json',   // Set the expected data type to JSON
                            beforeSend: function () {
                                $('.error-container').html('');
                            },
                            success: function (data) 
                            {
                                console.log(data);

                                if (data && data.status == 1) 
                                {
                                    Swal.fire({
                                        icon: 'success',
                                        text: 'Form has been submitted successfully',
                                        showConfirmButton: true,
                                        confirmButtonColor: '#ffca00',
                                    });

                                     window.location.href = '<?php echo url_secure('/category-management/category') ?>'
                                }
                                else 
                                {
                                    var errors = (data.errors) ? data.errors : {};
                                    if (Object.keys(errors).length > 0) 
                                    {
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
        if (url) 
        {
            const urlParams = new URLSearchParams(url);
            const id = atob(urlParams.get('id'));
            console.log(id);

            $.ajax({
                url: '<?php echo api_url('category-management/category/edit'); ?>',
                method: 'GET',
                data: {ajax: true, id: id},
                headers: headers011,
                dataType: 'json',               // Set the expected data type to JSON
                beforeSend: function () {
                    $('.error-container').html('');
                },
                success: function (data) {
                    if (data && data.status == 1)
                    {
                        loadAjax(data.data.category);
                    }
                    else
                    {
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
        else 
        {
            loadAjax();
        }

        function editForm(data) 
        {
            // console.log('edit');
            // console.table(data);
            // return false;

            var keys = Object.keys(data);
            var values = Object.values(data);
            console.log(keys);
            
            $(keys).each(function (index, element) 
            {
                console.log(index);
                console.log(element);

                var input = $('input[name="' + element + '"], textarea[name="' + element + '"], select[name="' + element + '"]');

                if (input.is(':checkbox')) 
                {
                    if (input.val() === values[index]) {
                        input.prop('checked', true);
                    }
                }
                else if (input.is('select'))
                {
                    input.val(values[index]);
                    input.trigger('change');
                }
                else if (input.is(':radio')) 
                {
                    $(`input[name="${element}"][value=${values[index]}]`).trigger('click');
                }
                else
                {
                    if (element === 'id')
                    {
                        input.prop('disabled', false);
                    }
                    input.val(values[index]);
                }
            });
        }

    </script>
    <script src="{{ url_secure('build/js/main.js')}}"></script>
@endSection
