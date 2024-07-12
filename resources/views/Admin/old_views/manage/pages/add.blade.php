@extends('Admin.layout.main')

@section('styles')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
<style>
    .note-editor{
        width: 100%;
        margin: 10px;
    }
</style>
@endsection
@section('title')
    {{ (Request::segment(3) == 'edit') ? 'Edit' : 'Add' }} Page
@endsection
@section('content')
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Manage Page</h3>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>{{ (Request::segment(3) == 'edit') ? 'Edit' : 'Add' }}</h2>
                            <ul class="nav navbar-right panel_toolbox justify-content-end">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <br/>
                            <form id="add_pages" action="" novalidate="novalidate" data-parsley-validate
                                  class="form-horizontal form-label-left" method="post">
                                <input type="hidden" value="" disabled name="id">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12 mb-3">
                                        <div class="form-group">
                                            <label>Page Type<span class="danger">*</span></label>
                                            <input type="radio" value="1" checked="checked" name="page_type"
                                                   class="page_type">&nbsp;Internal Page
                                            <input type="radio" value="2" name="page_type" class="page_type">&nbsp;External
                                            Link
                                        </div>
                                    </div>
                                    <div class="internal_page col-md-12" style="display: contents">
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <label>Page Name<span class="danger">*</span></label>
                                                <input id="admin_pages_name" data-rule-required="true"
                                                       data-msg-required="Page is required" class="form-control"
                                                       type="text" name="admin_pages_name">
                                                <span class="error-container danger w-100"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <label>Page Permalink<span class="danger">*</span></label>
                                                <input data-rule-required="true"
                                                       data-msg-required="Page Permalink is required"
                                                       id="admin_pages_permalink" class="form-control" type="text"
                                                       name="admin_pages_permalink">
                                                <span class="error-container danger w-100"></span>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <label>Page Title (will shown in head of page)</label>
                                                <input id="admin_pages_title" class="form-control"
                                                       type="text" name="admin_pages_title">
                                                <span class="error-container danger w-100"></span>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <label>Main Menu Order <span class="danger">*</span></label>
                                                <input data-rule-required="true" data-rule-min="0"
                                                       data-msg-required="This is required" id="admin_pages_order"
                                                       class="form-control" type="number"
                                                       name="admin_pages_order">
                                                <span class="error-container danger w-100"></span>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <label>Meta Keywords (Explode By ',')</label>
                                                <textarea id="meta_keywords" class="form-control"
                                                          type="text" name="meta_keywords"></textarea>
                                                <span class="error-container danger w-100"></span>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <label>Meta Description</label>
                                                <textarea id="meta_description" class="form-control"
                                                          type="text" name="meta_description"></textarea>
{{--                                                <input id="meta_description" class="form-control"--}}
{{--                                                       type="text" name="meta_description">--}}
                                                <span class="error-container danger w-100"></span>
                                            </div>
                                        </div>



                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <label>Menu Orientation<span class="required">*</span></label>
                                                <input id="admin_pages_main_menu" type="checkbox" value="1"
                                                       checked="checked" name="admin_pages_main_menu">&nbsp;Show in main menu
                                                <input id="admin_pages_footer_menu" type="checkbox" value="1"
                                                       name="admin_pages_footer_menu">&nbsp;Show in Footer menu
                                            </div>
                                        </div>

{{--                                        <div class="col-md-12 col-sm-12 col-xs-12">--}}
{{--                                            <div class="x_panel">--}}
{{--                                                <div class="x_title">--}}
{{--                                                    <h2>Page Body</h2>--}}
{{--                                                    <div class="clearfix"></div>--}}
{{--                                                </div>--}}
{{--                                                <div class="x_content">--}}
{{--                                                    <div id="alerts"></div>--}}
{{--                                                    <div class="btn-toolbar editor" data-role="editor-toolbar"--}}
{{--                                                         data-target="#editor-one">--}}
{{--                                                        <div class="btn-group">--}}
{{--                                                            <a class="btn dropdown-toggle" data-toggle="dropdown"--}}
{{--                                                               title="Font"><i class="fa fa-font"></i><b--}}
{{--                                                                    class="caret"></b></a>--}}
{{--                                                            <ul class="dropdown-menu">--}}
{{--                                                            </ul>--}}
{{--                                                        </div>--}}

{{--                                                        <div class="btn-group">--}}
{{--                                                            <a class="btn dropdown-toggle" data-toggle="dropdown"--}}
{{--                                                               title="Font Size"><i class="fa fa-text-height"></i>&nbsp;<b--}}
{{--                                                                    class="caret"></b></a>--}}
{{--                                                            <ul class="dropdown-menu">--}}
{{--                                                                <li>--}}
{{--                                                                    <a data-edit="fontSize 5">--}}
{{--                                                                        <p style="font-size:17px">Huge</p>--}}
{{--                                                                    </a>--}}
{{--                                                                </li>--}}
{{--                                                                <li>--}}
{{--                                                                    <a data-edit="fontSize 3">--}}
{{--                                                                        <p style="font-size:14px">Normal</p>--}}
{{--                                                                    </a>--}}
{{--                                                                </li>--}}
{{--                                                                <li>--}}
{{--                                                                    <a data-edit="fontSize 1">--}}
{{--                                                                        <p style="font-size:11px">Small</p>--}}
{{--                                                                    </a>--}}
{{--                                                                </li>--}}
{{--                                                            </ul>--}}
{{--                                                        </div>--}}

{{--                                                        <div class="btn-group">--}}
{{--                                                            <a class="btn" data-edit="bold" title="Bold (Ctrl/Cmd+B)"><i--}}
{{--                                                                    class="fa fa-bold"></i></a>--}}
{{--                                                            <a class="btn" data-edit="italic"--}}
{{--                                                               title="Italic (Ctrl/Cmd+I)"><i class="fa fa-italic"></i></a>--}}
{{--                                                            <a class="btn" data-edit="strikethrough"--}}
{{--                                                               title="Strikethrough"><i class="fa fa-strikethrough"></i></a>--}}
{{--                                                            <a class="btn" data-edit="underline"--}}
{{--                                                               title="Underline (Ctrl/Cmd+U)"><i--}}
{{--                                                                    class="fa fa-underline"></i></a>--}}
{{--                                                        </div>--}}

{{--                                                        <div class="btn-group">--}}
{{--                                                            <a class="btn" data-edit="insertunorderedlist"--}}
{{--                                                               title="Bullet list"><i class="fa fa-list-ul"></i></a>--}}
{{--                                                            <a class="btn" data-edit="insertorderedlist"--}}
{{--                                                               title="Number list"><i class="fa fa-list-ol"></i></a>--}}
{{--                                                            <a class="btn" data-edit="outdent"--}}
{{--                                                               title="Reduce indent (Shift+Tab)"><i--}}
{{--                                                                    class="fa fa-dedent"></i></a>--}}
{{--                                                            <a class="btn" data-edit="indent" title="Indent (Tab)"><i--}}
{{--                                                                    class="fa fa-indent"></i></a>--}}
{{--                                                        </div>--}}

{{--                                                        <div class="btn-group">--}}
{{--                                                            <a class="btn" data-edit="justifyleft"--}}
{{--                                                               title="Align Left (Ctrl/Cmd+L)"><i--}}
{{--                                                                    class="fa fa-align-left"></i></a>--}}
{{--                                                            <a class="btn" data-edit="justifycenter"--}}
{{--                                                               title="Center (Ctrl/Cmd+E)"><i--}}
{{--                                                                    class="fa fa-align-center"></i></a>--}}
{{--                                                            <a class="btn" data-edit="justifyright"--}}
{{--                                                               title="Align Right (Ctrl/Cmd+R)"><i--}}
{{--                                                                    class="fa fa-align-right"></i></a>--}}
{{--                                                            <a class="btn" data-edit="justifyfull"--}}
{{--                                                               title="Justify (Ctrl/Cmd+J)"><i--}}
{{--                                                                    class="fa fa-align-justify"></i></a>--}}
{{--                                                        </div>--}}

{{--                                                        <div class="btn-group">--}}
{{--                                                            <a class="btn dropdown-toggle" data-toggle="dropdown"--}}
{{--                                                               title="Hyperlink"><i class="fa fa-link"></i></a>--}}
{{--                                                            <div class="dropdown-menu input-append">--}}
{{--                                                                <input class="span2" placeholder="URL" type="text"--}}
{{--                                                                       data-edit="createLink"/>--}}
{{--                                                                <button class="btn" type="button">Add</button>--}}
{{--                                                            </div>--}}
{{--                                                            <a class="btn" data-edit="unlink"--}}
{{--                                                               title="Remove Hyperlink"><i class="fa fa-cut"></i></a>--}}
{{--                                                        </div>--}}

{{--                                                        <div class="btn-group">--}}
{{--                                                            <a class="btn" title="Insert picture (or just drag & drop)"--}}
{{--                                                               id="pictureBtn"><i class="fa fa-picture-o"></i></a>--}}
{{--                                                            <input type="file" data-role="magic-overlay"--}}
{{--                                                                   data-target="#pictureBtn" data-edit="insertImage"/>--}}
{{--                                                        </div>--}}

{{--                                                        <div class="btn-group">--}}
{{--                                                            <a class="btn" data-edit="undo" title="Undo (Ctrl/Cmd+Z)"><i--}}
{{--                                                                    class="fa fa-undo"></i></a>--}}
{{--                                                            <a class="btn" data-edit="redo" title="Redo (Ctrl/Cmd+Y)"><i--}}
{{--                                                                    class="fa fa-repeat"></i></a>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}

{{--                                                    <div id="editor-one" class="editor-wrapper"></div>--}}

{{--                                                    <textarea name="admin_pages_body" id="admin_pages_body"--}}
{{--                                                              style="display:none;"></textarea>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
                                        <div id="summernote" class="col-md-12"></div>
                                        <textarea name="admin_pages_body" id="admin_pages_body" style="display:none;"></textarea>

                                        </div>
                                        <div class="external_page col-md-12" style="display: none;">
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <div class="form-group">
                                                    <label>Page Name<span class="danger">*</span></label>
                                                    <input data-rule-required="true" data-msg-required="This is required" id="admin_pages_name_e" class="form-control"
                                                        type="text" name="admin_pages_name" disabled>
                                                    <span class="error-container danger w-100"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <div class="form-group">
                                                    <label>External Url<span class="danger">*</span></label>
                                                    <input data-rule-required="true" data-msg-required="This is required"
                                                           id="admin_pages_url" class="form-control"
                                                           type="text" name="admin_pages_url" disabled>
                                                    <span class="error-container danger w-100"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <a href="<?php echo url_secure('manage/pages/index') ?>">
                                                    <button class="btn btn-danger cancel-button" type="button">Cancel</button>
                                                </a>
                                                <button type="submit" class="btn btn-success submit-and-update-button">{{ (Request::segment(3) == 'edit') ? 'Update' : 'Submit' }}</button>
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
        <!-- /page content -->
    @endsection

    @section('scripts')

        <script src="{{ url_secure('vendors/summer_note/js/summernote.min.js')}}"></script>
        <script src="<?php echo url_secure('vendors') ?>/validate/jquery.validate.min.js" type="text/javascript"></script>
        <script>
            $('#summernote').summernote({
                placeholder: '',
                tabsize: 2,
                height: 100
            });
        </script>
        <script>
            const token = getToken();
            const headers = {
                "Authorization": `Bearer ${token}`,
            };

            $('body').on('keyup change', '.note-editable', function () {
                $('#admin_pages_body').val($(this).html());
            });
            $('.page_type').change(function () {
                if ($('.page_type:checked').val() == '1') {
                    $('.internal_page').show();
                    $('.external_page').hide();
                    $('.external_page input').val('').prop('disabled', true);

                    $('.internal_page input').val('').prop('disabled', false);
                    $('.internal_page textarea').val('').prop('disabled', false);
                } else if ($('.page_type:checked').val() == '2') {
                    $('.internal_page').hide();
                    $('.external_page').show();
                    $('.internal_page input').val('').prop('disabled', true);
                    $('.internal_page textarea').val('').prop('disabled', true);

                    $('.external_page input').val('').prop('disabled', false);
                }
            });

            $("#add_pages").validate({
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
                           $('.note-editable').trigger('change');
                            var data = $('#add_pages').serialize();
                            $.ajax({
                                url: '<?php echo api_url('manage/pages/submit'); ?>',
                                method: 'POST',
                                data: data,
                                headers: headers,
                                dataType: 'json', // Set the expected data type to JSON
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
                                        window.location.href = '<?php echo url_secure('manage/pages/index') ?>'
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
                    url: '<?php echo api_url('manage/pages/edit'); ?>',
                    method: 'GET',
                    data: {ajax: true, id: id},
                    dataType: 'json', // Set the expected data type to JSON
                    headers: headers,
                    beforeSend: function () {
                        $('.error-container').html('');
                    },
                    success: function (data) {
                        if (data && data.status == 1) {
                            editForm(data.data.admin_pages);
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

            function editForm(data) {
                var admin_pages_keys = Object.keys(data);
                var admin_pages_values = Object.values(data);
                $(admin_pages_keys).each(function (index, element) {
                    var input = $('input[name="' + element + '"], textarea[name="' + element + '"]');
                    if (input.is(':checkbox')) {
                        if (input.val() === admin_pages_values[index]) {
                            input.prop('checked', true);
                        }
                    } else if (input.is(':radio')) {
                        $(`input[name="${element}"][value=${admin_pages_values[index]}]`).trigger('click');
                    } else {
                        if (element === 'admin_pages_body') {
                            $('.note-editable').html(admin_pages_values[index]);
                        } else if (element === 'id') {
                            input.prop('disabled', false);
                        }
                        input.val(admin_pages_values[index]);
                    }
                });
            }


        </script>
    @endsection
