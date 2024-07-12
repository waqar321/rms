@extends('Admin.layout.main')
@section('styles')
    <style>
        .section-heading {
            background-color: #3E3E3E;
            padding: 5px 10px;
            color: #fff;
            margin-bottom: 5px;
        }
    </style>
@endsection
@section('title') Permissions @endsection
@section('content')

    <div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Manage Permissions</h3>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2 id="role-name-heading"> </h2>
                        <ul class="nav navbar-right panel_toolbox justify-content-end">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <form id="permission-form" action="" novalidate="novalidate" data-parsley-validate class="form-horizontal form-label-left" method="POST">
                            @csrf
                            <input type="hidden" name="role_id" id="role_id" value="">
{{--                            <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target=".multi-collapse" aria-expanded="false" aria-controls="multiCollapseExample1 multiCollapseExample2">Toggle both elements</button>--}}
{{--                            <div class="row">--}}
{{--                                <div class="col">--}}
{{--                                    <div class="collapse multi-collapse" id="multiCollapseExample1">--}}
{{--                                        <div class="card card-body">--}}
{{--                                            Some placeholder content for the first collapse component of this multi-collapse example. This panel is hidden by default but revealed when the user activates the relevant trigger.--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="col">--}}
{{--                                    <div class="collapse multi-collapse" id="multiCollapseExample2">--}}
{{--                                        <div class="card card-body">--}}
{{--                                            Some placeholder content for the second collapse component of this multi-collapse example. This panel is hidden by default but revealed when the user activates the relevant trigger.--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div id="accordion">--}}
{{--                                <div class="card">--}}
{{--                                    <div class="card-header p-0 pt-1" id="headingOne">--}}
{{--                                        <h5 class="mb-0">--}}
{{--                                            <button type="button" class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">--}}
{{--                                                Manage--}}
{{--                                            </button>--}}
{{--                                        </h5>--}}
{{--                                    </div>--}}

{{--                                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne">--}}
{{--                                        <div class="card-body">--}}
{{--                                            <div class="card">--}}
{{--                                                <div class="card-header p-0 pt-1" id="headingTwo">--}}
{{--                                                    <h5 class="mb-0">--}}
{{--                                                        <button type="button" class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">--}}
{{--                                                            Pages--}}
{{--                                                        </button>--}}
{{--                                                    </h5>--}}
{{--                                                </div>--}}
{{--                                                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">--}}
{{--                                                    <div class="card-body">--}}
{{--                                                        <div class="col-md-2 col-sm-2 from-input-col">--}}
{{--                                                            <div class="form-group">--}}
{{--                                                                <input type="checkbox" name="screen_permission_id[]" value="1">--}}
{{--                                                                <label class="control-label">View</label>--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
                            <div id="permissions-div" class="col-md-12">

                            </div>
                            <div class="row">
                                <div class="col-sm-12 text-left from-input-col mt-4">
                                    <hr>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary" id="save"> Update </button>
                                        <a href="{{ url_secure('manage_user/roles/index') }}"  class="btn btn-danger" id="cancel"> Cancel </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script src="<?php echo url_secure('vendors/validate/jquery.validate.min.js') ?>" type="text/javascript"></script>
    <script>

        const token = getToken();
        const headers = {
            "Authorization": `Bearer ${token}`,
        };
        $("#permission-form").validate({
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
                        var data = $('#permission-form').serialize();
                        $.ajax({
                            url: '<?php echo api_url('manage_user/roles/permission/submit'); ?>',
                            method: 'POST',
                            data:data,
                            headers:headers,
                            dataType: 'json', // Set the expected data type to JSON
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
                                    window.location.href = '<?php echo url_secure('/manage_user/roles/index') ?>'
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

        const url = window.location.search;
        
        if(url) 
        {
            const urlParams = new URLSearchParams(url);
            const id = atob(urlParams.get('id'));
 
            $.ajax({
                url: '<?php echo api_url('manage_user/roles/permission'); ?>',
                method: 'GET',
                data: {ajax: true, id: id},
                headers: headers,
                dataType: 'json', // Set the expected data type to JSON
                beforeSend: function () {
                    $('.error-container').html('');
                },
                success: function (data) 
                {
                    console.log('permissions');
                    console.log(data);
                    // return false;

                    if (data && data.status == 1) {
                        document.getElementById('role_id').value = data.data.role.id;
                        document.getElementById('role-name-heading').innerHTML = data.data.role.role_name+' Role<small> Permissions</small>';
                        permissionsList(data.data);
                        // editForm(data.data.ecom_module_permissions);
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

        function permissionsList(modules){

            var ecom_module_permissions = modules.ecom_module_permissions;

            var selected_permissions_module = ecom_module_permissions.map(function(item) {
                return item.module_id;
            });
            var selected_permissions_sub_module = ecom_module_permissions.map(function(item) {
                return item.sub_module_id;
            });
            var selected_permissions = ecom_module_permissions.map(function(item) {
                return item.screen_permission_id;
            });

            var container = document.getElementById("permissions-div");
            var permissionContent='';

            Object.keys(modules.permissions_list).forEach(function(index) {
                var perModule = modules.permissions_list[index];
                var selectedModule = (selected_permissions_module.includes(perModule.id)) ? 'checked' : '' ;
                var permissionContent = `<div class="col-md-12"><p class="section-heading">`+perModule.module_name+` <input type="checkbox" ${selectedModule} id="module-id-`+perModule.id+`" onclick="moduleChecked(`+perModule.id+`)"><i class="fa fa-chevron-down float-right" data-toggle="collapse" data-target="#collapseOne`+perModule.id+`"></i></p></div>`;

                Object.keys(perModule.sub_module).forEach(function(array) {
                    var perSubModule = perModule.sub_module[array];
                    var selectedSubModule = (selected_permissions_sub_module.includes(perSubModule.id)) ? 'checked' : '' ;
                    var subPermissionContent = `<div class="col-md-10 offset-1"><p class="section-heading">`+perSubModule.sub_module_name+` <input type="checkbox" ${selectedSubModule} id="sub-module-id-`+perSubModule.id+`" data-module-id-permission="`+perModule.id+`" name="`+perModule.module_name+`" onclick="subModuleChecked(`+perSubModule.id+`)"></p></div>`;
                    permissionContent += subPermissionContent;

                    Object.keys(perSubModule.submodule_screen).forEach(function(key) {
                        var perSubModuleScreen = perSubModule.submodule_screen[key];
                        var selected = (selected_permissions.includes(perSubModuleScreen.id)) ? 'checked' : '' ;
                        var subPermissionScreenContent = `<div class="col-md-2 offset-1 col-sm-2 from-input-col collapse hide" id="collapseOne`+perModule.id+`">
                                                            <div class="form-group">
                                                                <input type="checkbox" data-module-id-permission="`+perModule.id+`" data-sub-module-id-permission="`+perSubModule.id+`" name="screen_permission_id[]" ${selected}  value="`+perSubModuleScreen.id+`">
                                                                <label class="control-label">`+perSubModuleScreen.name+`</label>
                                                            </div>
                                                        </div>`;
                            permissionContent += subPermissionScreenContent;
                    });
                });
                container.innerHTML += permissionContent;
            });
        }


        function moduleChecked(moduleId){
            // console.log(ModuleName);
            var checkbox = document.getElementById("module-id-"+moduleId);
            var modulesIdsAttr = document.querySelectorAll('[data-module-id-permission]');
            modulesIdsAttr.forEach(function(checkedModules) {
                var module_id = checkedModules.getAttribute("data-module-id-permission");
                var input = $('input[type="checkbox"][name="screen_permission_id[]"][data-module-id-permission="'+moduleId+'"]');
                var input2 = $('input[type="checkbox"][data-module-id-permission="'+moduleId+'"]');
                if (checkbox.checked) {
                    if(module_id == moduleId){
                        input.prop('checked', true);
                        input2.prop('checked', true);
                    }
                } else {
                    input.prop('checked', false);
                    input2.prop('checked', false);
                }
            });
        }

        function subModuleChecked(subModuleId){
            var checkbox = document.getElementById("sub-module-id-"+subModuleId);
            var subModulesIdsAttr = document.querySelectorAll('[data-sub-module-id-permission]');
            subModulesIdsAttr.forEach(function(checkedSubModules) {
                var sub_module_id = checkedSubModules.getAttribute("data-sub-module-id-permission");
                var input = $('input[type="checkbox"][name="screen_permission_id[]"][data-sub-module-id-permission="'+subModuleId+'"]');
                if (checkbox.checked) {
                    if(sub_module_id == subModuleId){
                        input.prop('checked', true);
                    }
                } else {
                    input.prop('checked', false);
                }
            });
        }
    </script>

@endsection
