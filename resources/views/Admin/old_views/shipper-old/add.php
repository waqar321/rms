<?= $this->extend('Admin/layout/main') ?>

<?= $this->section('styles') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<!-- page content -->
<div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Add Shipper</h3>
              </div>


            </div>
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Shipper <small>Add Shipper</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <!-- <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                         <ul class="dropdown-menu" role="menu">
                          <li><a href="#">Settings 1</a>
                          </li>
                          <li><a href="#">Settings 2</a>
                          </li>
                        </ul>
                      </li> -->

                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />
                    <form id="shipper_form" action="" novalidate="novalidate" data-parsley-validate class="form-horizontal form-label-left" method="post">

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Select City</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select class="select2 form-control" tabindex="-1" name="city_id" data-rule-required="true"  data-msg-required="city field is required">
                              <option value="">- Select a City -</option>
                              <?php foreach($cities as $city){ ?>
                                  <option value="<?php echo $city['id']; ?>"><?php echo $city['city_name']; ?></option>
                              <?php } ?>
                          </select>
                            <span class="error-container danger w-100"></span>
                        </div>
                      </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Select Merchant</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select class="select2 form-control" tabindex="-1" name="parent_id" id="parent_id">
                                    <option value="">- Select a Merchant -</option>
                                    <?php foreach($merchants as $merchant){ ?>
                                        <option value="<?php echo $merchant['id']; ?>"><?php echo $merchant['merchant_name']; ?></option>
                                    <?php } ?>
                                </select>
                                <span class="error-container danger w-100"></span>
                            </div>
                        </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name" name="merchant_name">Shipper Name <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" id="merchant_name" name="merchant_name" data-rule-required="true"  data-msg-required="merchant name is required"  class="form-control col-md-7 col-xs-12">
                            <span class="error-container danger w-100"></span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Shipper Email</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="merchant_email" class="form-control col-md-7 col-xs-12" type="text" name="merchant_email">
                            <span class="error-container danger w-100"></span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Shipper Phone</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="merchant_phone" class="form-control col-md-7 col-xs-12" type="text" name="merchant_phone">
                            <span class="error-container danger w-100"></span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Shipper Address</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="merchant_address1" class="form-control col-md-7 col-xs-12" type="text" name="merchant_address1">
                            <span class="error-container danger w-100"></span>
                        </div>
                      </div>
                        <div class="form-group">
                            <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Settle Your Shipper</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input  type="checkbox" id="is_settlement" value="1"   name="is_settlement"> If you intend to settle your shippers separately, you can insert below mentioned details to facilitate your shippers.
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Select Bank  <span class="danger">*</span></label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select   name="bank_id" id="bank_id" class="form-control select2 bank">
                                    <option value="">- Select a Bank -</option>
                                    <?php foreach($banks as $val) {?>
                                        <option value="<?php echo $val['id'] ?>"><?php echo $val['bank_name'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Bank Account No. <span class="danger">*</span></label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="bank_ac_no" class="form-control col-md-7 col-xs-12 bank" type="text" name="bank_ac_no">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Bank Account Tittle <span class="danger">*</span></label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="bank_ac_title" class="form-control col-md-7 col-xs-12 bank" type="text" name="bank_ac_title">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Bank Branch  <span class="danger">*</span></label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input  id="bank_branch" class="form-control col-md-7 col-xs-12 bank" type="text" name="bank_branch">
                            </div>
                        </div>
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          <button class="btn btn-primary" type="button">Cancel</button>
                          <button type="submit" class="btn btn-success">Submit</button>
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
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="<?php echo base_url('vendors') ?>/validate/jquery.validate.min.js" type="text/javascript"></script>
<script>
    $('.bank').attr('disabled','disabled');
    $('body').on('click','#is_settlement', function(){
        if ($(this).is(':checked')) {
            $('.bank').removeAttr('disabled');
        }else{
            $('.bank').attr('disabled','disabled');
        }
    });
    $('body').on('keyup change','#editor-one', function(){
        $('#news_content').val($(this).html());
    });

    $("#shipper_form").validate({
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
                    var data = $('#shipper_form').serialize();
                    $.ajax({
                        url: '<?php echo base_url('/client/shipper/submit'); ?>',
                        method: 'POST',
                        data:data,
                        dataType: 'json', // Set the expected data type to JSON
                        beforeSend: function(){
                            $('.error-container').html('');
                        },
                        success: function(data) {
                            if (data && data.status == 1) {
                                Swal.fire(
                                    'Saved!',
                                    'Form has been submitted successfully',
                                    'success'
                                );
                                window.location.href = '<?php echo base_url('/client/shipper/index') ?>'
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

    function editForm() {
        var keys = <?php echo json_encode(array_keys(isset($shipper) ? $shipper  :[]))?>;
        var values = <?php echo json_encode(array_values(isset($shipper) ? $shipper : []))?>;
        $(keys).each(function(index, element) {
            var input = $('input[name="' + element + '"], textarea[name="' + element + '"]');
            if (input.is(':checkbox')) {
                if (input.val() === values[index]) {
                    input.prop('checked', true);
                }
            }
            else if(input.is(':radio')){
                $(`input[name="${element}"][value=${values[index]}]`).trigger('click');
            }
            else if(input.is('select')){
                input.val(values[index]);
                input.trigger('change');
            }
            else{
                if(element === 'news_content'){
                    $('#editor-one').html(values[index]);
                }
                else if(element === 'id'){
                    input.prop('disabled',false);
                }
                input.val(values[index]);
            }
        });
    }

    <?php if(isset($shipper['id']))  { ?>
    editForm();
    <?php } ?>

</script>

<?= $this->endSection() ?>
