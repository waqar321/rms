@extends('Admin.layout.main')
@section('title')
    {{ (Request::segment(3) == 'edit') ? 'Edit' : 'Add' }} News
@endsection
@section('styles')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
@endsection

@section('content')
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Manage News</h3>
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
                            <form id="news_form" action="" novalidate="novalidate" data-parsley-validate
                                  class="form-horizontal form-label-left" method="post">
                                <input type="hidden" value="" disabled name="id">
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                    <div class="form-group">
                                        <label>News Title<span class="danger">*</span></label>
                                        <input data-rule-required="true" data-msg-required="This is required"
                                               id="news_title" class="form-control" type="text" name="news_title">
                                        <span class="error-container danger w-100"></span>
                                    </div>
                                </div>
                                <div class="col-md-8 col-sm-8 col-xs-12 mb-3">
{{--                                    <div class="form-group">--}}
{{--                                        <label>News Description</label>--}}
{{--                                        <div class="x_panel">--}}
{{--                                            <div class="x_content">--}}
{{--                                                <div id="alerts"></div>--}}
{{--                                                <div class="btn-toolbar editor" data-role="editor-toolbar"--}}
{{--                                                     data-target="#editor-one">--}}
{{--                                                    <div class="btn-group">--}}
{{--                                                        <a class="btn dropdown-toggle" data-toggle="dropdown"--}}
{{--                                                           title="Font"><i class="fa fa-font"></i><b class="caret"></b></a>--}}
{{--                                                        <ul class="dropdown-menu">--}}
{{--                                                        </ul>--}}
{{--                                                    </div>--}}

{{--                                                    <div class="btn-group">--}}
{{--                                                        <a class="btn dropdown-toggle" data-toggle="dropdown"--}}
{{--                                                           title="Font Size"><i class="fa fa-text-height"></i>&nbsp;<b--}}
{{--                                                                class="caret"></b></a>--}}
{{--                                                        <ul class="dropdown-menu">--}}
{{--                                                            <li>--}}
{{--                                                                <a data-edit="fontSize 5">--}}
{{--                                                                    <p style="font-size:17px">Huge</p>--}}
{{--                                                                </a>--}}
{{--                                                            </li>--}}
{{--                                                            <li>--}}
{{--                                                                <a data-edit="fontSize 3">--}}
{{--                                                                    <p style="font-size:14px">Normal</p>--}}
{{--                                                                </a>--}}
{{--                                                            </li>--}}
{{--                                                            <li>--}}
{{--                                                                <a data-edit="fontSize 1">--}}
{{--                                                                    <p style="font-size:11px">Small</p>--}}
{{--                                                                </a>--}}
{{--                                                            </li>--}}
{{--                                                        </ul>--}}
{{--                                                    </div>--}}

{{--                                                    <div class="btn-group">--}}
{{--                                                        <a class="btn" data-edit="bold" title="Bold (Ctrl/Cmd+B)"><i--}}
{{--                                                                class="fa fa-bold"></i></a>--}}
{{--                                                        <a class="btn" data-edit="italic" title="Italic (Ctrl/Cmd+I)"><i--}}
{{--                                                                class="fa fa-italic"></i></a>--}}
{{--                                                        <a class="btn" data-edit="strikethrough"--}}
{{--                                                           title="Strikethrough"><i class="fa fa-strikethrough"></i></a>--}}
{{--                                                        <a class="btn" data-edit="underline"--}}
{{--                                                           title="Underline (Ctrl/Cmd+U)"><i--}}
{{--                                                                class="fa fa-underline"></i></a>--}}
{{--                                                    </div>--}}

{{--                                                    <div class="btn-group">--}}
{{--                                                        <a class="btn" data-edit="insertunorderedlist"--}}
{{--                                                           title="Bullet list"><i class="fa fa-list-ul"></i></a>--}}
{{--                                                        <a class="btn" data-edit="insertorderedlist"--}}
{{--                                                           title="Number list"><i class="fa fa-list-ol"></i></a>--}}
{{--                                                        <a class="btn" data-edit="outdent"--}}
{{--                                                           title="Reduce indent (Shift+Tab)"><i--}}
{{--                                                                class="fa fa-dedent"></i></a>--}}
{{--                                                        <a class="btn" data-edit="indent" title="Indent (Tab)"><i--}}
{{--                                                                class="fa fa-indent"></i></a>--}}
{{--                                                    </div>--}}

{{--                                                    <div class="btn-group">--}}
{{--                                                        <a class="btn" data-edit="justifyleft"--}}
{{--                                                           title="Align Left (Ctrl/Cmd+L)"><i--}}
{{--                                                                class="fa fa-align-left"></i></a>--}}
{{--                                                        <a class="btn" data-edit="justifycenter"--}}
{{--                                                           title="Center (Ctrl/Cmd+E)"><i--}}
{{--                                                                class="fa fa-align-center"></i></a>--}}
{{--                                                        <a class="btn" data-edit="justifyright"--}}
{{--                                                           title="Align Right (Ctrl/Cmd+R)"><i--}}
{{--                                                                class="fa fa-align-right"></i></a>--}}
{{--                                                        <a class="btn" data-edit="justifyfull"--}}
{{--                                                           title="Justify (Ctrl/Cmd+J)"><i--}}
{{--                                                                class="fa fa-align-justify"></i></a>--}}
{{--                                                    </div>--}}

{{--                                                    <div class="btn-group">--}}
{{--                                                        <a class="btn dropdown-toggle" data-toggle="dropdown"--}}
{{--                                                           title="Hyperlink"><i class="fa fa-link"></i></a>--}}
{{--                                                        <div class="dropdown-menu input-append">--}}
{{--                                                            <input class="span2" placeholder="URL" type="text"--}}
{{--                                                                   data-edit="createLink"/>--}}
{{--                                                            <button class="btn" type="button">Add</button>--}}
{{--                                                        </div>--}}
{{--                                                        <a class="btn" data-edit="unlink" title="Remove Hyperlink"><i--}}
{{--                                                                class="fa fa-cut"></i></a>--}}
{{--                                                    </div>--}}

{{--                                                    <div class="btn-group">--}}
{{--                                                        <a class="btn" title="Insert picture (or just drag & drop)"--}}
{{--                                                           id="pictureBtn"><i class="fa fa-picture-o"></i></a>--}}
{{--                                                        <input type="file" data-role="magic-overlay"--}}
{{--                                                               data-target="#pictureBtn" data-edit="insertImage"/>--}}
{{--                                                    </div>--}}

{{--                                                    <div class="btn-group">--}}
{{--                                                        <a class="btn" data-edit="undo" title="Undo (Ctrl/Cmd+Z)"><i--}}
{{--                                                                class="fa fa-undo"></i></a>--}}
{{--                                                        <a class="btn" data-edit="redo" title="Redo (Ctrl/Cmd+Y)"><i--}}
{{--                                                                class="fa fa-repeat"></i></a>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}

{{--                                                <div id="editor-one" class="editor-wrapper"></div>--}}

{{--                                                <textarea name="news_content" id="news_content"--}}
{{--                                                          style="display:none;"></textarea>--}}
{{--                                                <span class="error-container danger w-100"></span>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
                                    <div id="summernote"></div>
                                    <textarea name="news_content" id="news_content" style="display:none;"></textarea>

                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                            <a href="<?php echo url_secure('manage/news/index') ?>">
                                                <button class="btn cancel-button btn-danger" type="button">Cancel</button>
                                            </a>
                                            <button type="submit" class="btn btn-success submit-and-update-button">{{ (Request::segment(3) == 'edit') ? 'Update' : 'Submit' }}</button>
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
                $('#news_content').val($(this).html());
            });

            $("#news_form").validate({
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
                            var data = $('#news_form').serialize();
                            $.ajax({
                                url: '<?php echo api_url('manage/news/submit'); ?>',
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
                                        window.location.href = '<?php echo url_secure('/manage/news/index') ?>'
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
                    url: '<?php echo api_url('manage/news/edit'); ?>',
                    method: 'GET',
                    data: {ajax: true, id: id},
                    headers: headers,
                    dataType: 'json', // Set the expected data type to JSON
                    beforeSend: function () {
                        $('.error-container').html('');
                    },
                    success: function (data) {
                        if (data && data.status == 1) {
                            editForm(data.data.news);
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
                var keys = Object.keys(data);
                var values = Object.values(data);
                $(keys).each(function (index, element) {
                    var input = $('input[name="' + element + '"], textarea[name="' + element + '"]');
                    if (input.is(':checkbox')) {
                        if (input.val() === values[index]) {
                            input.prop('checked', true);
                        }
                    } else if (input.is(':radio')) {
                        $(`input[name="${element}"][value=${values[index]}]`).trigger('click');
                    } else {
                        if (element === 'news_content') {
                            $('.note-editable').html(values[index]);
                        } else if (element === 'id') {
                            input.prop('disabled', false);
                        }
                        input.val(values[index]);
                    }
                });
            }


            editForm();


        </script>

    @endsection
