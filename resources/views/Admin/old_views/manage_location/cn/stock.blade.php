@extends('Admin.layout.main')

@section('styles')@endsection
<style>

button.form-control.filter {
    margin-top: 17px;
    height: 40px;
}

</style>
@section('title') CN Stock @endsection

@section('content')
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Manage CN</h3>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Stock</h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <br/>
                            <form id="cn_form" action="" novalidate="novalidate" data-parsley-validate
                                  class="form-horizontal form-label-left" method="post">
                                <input type="hidden" value="" disabled name="id">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label>City Name<span class="danger">*</span></label>
                                        <select data-rule-required="true" data-msg-required="This is required"
                                                name="city_id" id="city_id" class="form-control select2">
                                            <option value="">- Select a City -</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <button class="form-control btn-success filter" onclick="getCnStock()">Filter</button>
                                    </div>
                                </div>
                            </form>

                            <table id="datatable" class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>City</th>
                                    <th>Shipment Type</th>
                                    <th>CN Type</th>
                                    <th>Total CNs</th>
                                    <th>Total Hold CNs</th>
                                </tr>
                                </thead>
                                <tbody id="table-body">
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /page content -->
@endSection

@section('scripts')
    <script src="<?php echo url_secure('vendors/validate/jquery.validate.min.js') ?>" type="text/javascript"></script>
    <script src="<?php echo url_secure('vendors/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js') ?>"></script>
    <script>
        const token = getToken();
        const headers = {
            "Authorization": `Bearer ${token}`,
        };
        var table = $('#datatable').DataTable({
            paging: false,
            // Other DataTable options
        });

        function loadAjax(EditData = []) {
            $.ajax({
                url: '<?php echo api_url('manage_location/city/data_list'); ?>',
                method: 'GET',
                dataType: 'json', // Set the expected data type to JSON
                headers:headers,
                beforeSend: function () {
                    $('.error-container').html('');
                },
                success: function (data) {
                    var option = "";
                    $.each(data.cities, function (index, value) {
                        option += `<option value="${value.id}">${value.city_name}</option>`
                    });
                    $('#city_id').append(option);
                    if (EditData) {
                        editForm(EditData);
                    }
                },
                error: function (xhr, textStatus, errorThrown) {

                }
            });

            $.ajax({
                url: '<?php echo api_url('manage/shipment_type/get_services'); ?>',
                method: 'GET',
                dataType: 'json', // Set the expected data type to JSON
                headers:headers,
                beforeSend: function () {
                    $('.error-container').html('');
                },
                success: function (data) {
                    var option = "";
                    $.each(data.data, function (index, value) {
                        option += `<option value="${value.shipment_type_id}">${value.service_name}</option>`
                    });
                    $('#shipment_type_id').append(option);
                    if (EditData) {
                        editForm(EditData);
                    }
                },
                error: function (xhr, textStatus, errorThrown) {

                }
            });
        }

        function cn_change(val) {
            if (val == 1) {
                $('.cn_single').show();
                $('.cn_bulk').hide();
                $('#register_cert_no_start').attr('data-rule-required', 'false');
                $('#register_cert_no_end').attr('data-rule-required', 'false');
                $('#register_cert_no').attr('data-rule-required', 'true');
                $('#register_cert_no').val('');

            } else if (val == 2) {
                $('.cn_single').hide();
                $('.cn_bulk').show();
                $('#register_cert_no_start').attr('data-rule-required', 'true');
                $('#register_cert_no_end').attr('data-rule-required', 'true');
                $('#register_cert_no').attr('data-rule-required', 'false');
                $('#register_cert_no_start').val('');
                $('#register_cert_no_end').val('');
            }
        }

        $("#cn_form").validate({
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
                        var data = $('#cn_form').serialize();
                        $.ajax({
                            url: '<?php echo api_url('manage_location/cn/submit'); ?>',
                            method: 'POST',
                            data: data,
                            dataType: 'json', // Set the expected data type to JSON
                            headers:headers,
                            beforeSend: function () {
                                $('.error-container').html('');
                            },
                            success: function (data) {
                                if (data && data.status == 1) {
                                    Swal.fire({
                                        icon: 'success',
                                        text: 'Form has been submitted successfully',
                                        showConfirmButton: true,
                                        confirmButtonColor: '#ffca00',
                                    });
                                    window.location.href = '<?php echo url_secure('/manage_location/cn') ?>'
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
                url: '<?php echo api_url('manage_location/cn/edit'); ?>',
                method: 'GET',
                data: {ajax: true, id: id},
                dataType: 'json', // Set the expected data type to JSON
                headers:headers,
                beforeSend: function () {
                    $('.error-container').html('');
                },
                success: function (data) {
                    if (data && data.status == 1) {
                        loadAjax(data.data.cn);
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
        } else {
            loadAjax();
        }

        function editForm(data) {
            var keys = Object.keys(data);
            var values = Object.values(data);

            $(keys).each(function (index, element) {
                var input = $('input[name="' + element + '"], textarea[name="' + element + '"], select[name="' + element + '"]');
                if (input.is(':checkbox')) {
                    if (input.val() === values[index]) {
                        input.prop('checked', true);
                    }
                } else if (input.is('select')) {
                    input.val(values[index]);
                    input.trigger('change');
                } else if (input.is(':radio')) {
                    $(`input[name="${element}"][value=${values[index]}]`).trigger('click');
                } else {
                    if (element === 'id') {
                        input.prop('disabled', false);
                    }
                    input.val(values[index]);
                }
            });
        }

        function getCnStock(){
            cityID = $('#city_id').val();
            console.log(cityID);
            $.ajax({
                url: '<?php echo api_url('manage_location/cn/stock'); ?>?city_id='+cityID,
                method: 'GET',
                data: {ajax: true, city_id: cityID},
                dataType: 'json', // Set the expected data type to JSON
                headers:headers,
                beforeSend: function () {
                    $('.error-container').html('');
                },
                success: function (data) {
                    if (data && data.status == 1) {
                        $("#table-body").empty();
                        loadTable(data.data);
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

        function loadTable(data){

            var tableBody = $("#table-body");

            $.each(data, function (index, item) {
                var row = $("<tr>");
                row.append($("<td>").text(item.city_name));
                row.append($("<td>").text(item.shipment_type_name));
                row.append($("<td>").text(item.cn_type));
                row.append($("<td>").text(item.cn_count));
                row.append($("<td>").text(item.cn_hold_count));
                tableBody.append(row);
            });
        }

    </script>
    <script src="{{ url_secure('build/js/main.js')}}"></script>
@endSection
