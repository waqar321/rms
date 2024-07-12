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
                            <h2>{{ (Request::segment(3) == 'edit') ? 'Edit' : 'Add' }} Sub Category </h2>
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

                                    <div class="row">
                                        <h4 class="location-detail col-md-12 col-sm-12 col-xs-12">
                                            <b>Sub Category Detail :</b>
                                            <hr class="mb-1 mt-1">
                                        </h4>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <label>Parent Category</label>
                                                <select name="parent_category" id="parent_category"
                                                        class="form-control select2">
                                                    <option value="">- Select a Parent Category -</option>

                                                </select>
                                                <span class="error-container danger w-100"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <label>Sub Category Name<span class="danger">*</span></label>
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
                    // console.log('all list');
                    // console.log(data);
                    // console.log('edit data');
                    // console.log(EditData.parent_id);

                    var option1 = "";
                    var option2 = "";
                    var option3 = "";
                    var option4 = "";
                    var option5 = "";
                    var option6 = "";

                    $.each(data.categories, function (index, value) 
                    {
                        
                        if (value.parent_id == null) 
                        {
                            // console.log(value.id);
                            // console.log('db ' + typeof value.parent_id);
                            // console.log('selected ' + typeof EditData.parent_id);

                            if (value.id === EditData.parent_id)
                            {
                                // console.log('db_parent_category' + value.parent_id + ' and this is current category parent_id ' +  EditData.parent_id);
                                option1 += `<option value="${value.id}" selected>${value.name}</option>`;
                            } 
                            else
                            {
                                option1 += `<option value="${value.id}">${value.name}</option>`
                            }
                        }
                    });

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
                    $('#parent_category').append(option1);
                    // $('#city_via').append(option2);
                    // $('#state_id').append(option3);
                    // $('#zone_id').append(option4);
                    // $('#overland_zone_id').append(option5);
                    // $('#parent_category').append(option6);

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
            submitHandler: function (form, event) 
            {
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
                    if (result.isConfirmed) 
                    {
                        var data = $('#category_form').serialize();
                       
                        $.ajax({
                            url: '<?php echo api_url('category-management/sub_category/submit'); ?>',
                            method: 'POST',
                            data: data,
                            headers: headers011,
                            dataType: 'json',   // Set the expected data type to JSON
                            beforeSend: function () {
                                $('.error-container').html('');
                            },
                            success: function (data) 
                            {
                                // console.log(data);

                                if (data && data.status == 1) 
                                {
                                    Swal.fire({
                                        icon: 'success',
                                        text: 'Form has been submitted successfully',
                                        showConfirmButton: true,
                                        confirmButtonColor: '#ffca00',
                                    });

                                     window.location.href = '<?php echo url_secure('/category-management/sub_category') ?>'
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
            // console.log(id);

            $.ajax({
                url: '<?php echo api_url('category-management/sub_category/edit'); ?>',
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
            // console.log(keys);
            
            $(keys).each(function (index, element) 
            {
                // console.log(index);
                // console.log(element);

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
