<?= $this->extend('Admin/layout/main') ?>

<?= $this->section('styles') ?>

<style>
    .field-icon {
        float: right;
        margin-top: -25px;
        position: relative;
        z-index: 2;
        margin-right: 5px;
    }
</style>

<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Admin Settings</h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <form class="form-horizontal" method="" action="">
                                <div class="form-group col-md-8">
                                    <label class="col-md-4 control-label">Email</label>
                                    <div class="col-md-8">
                                        <input type="email" class="form-control" name="email" id="email" placeholder="Enter Email Address">
<!--                                        <span class="fa fa-eye field-icon" id="email-icon" onclick="editFunction('email', 'email-icon')"></span>-->
                                    </div>
                                </div>
                                <div class="form-group col-md-8">
                                    <label class="col-md-4 control-label">Phone</label>
                                    <div class="col-md-8">
                                        <input type="number" class="form-control" name="phone" id="phone" placeholder="Enter Phone Number">
<!--                                        <span class="fa fa-eye field-icon" id="email-icon" onclick="editFunction('phone', 'phone-icon')"></span>-->
                                    </div>
                                </div>
                                <div class="form-group col-md-8">
                                    <label class="col-md-4 control-label">Head Office Map [iframe 492x266]</label>
                                    <div class="col-md-8">
                                        <textarea class="form-control" name="iframe" id="iframe"></textarea>
<!--                                        <input id="password" type="password" class="form-control" name="password" value="secret" >-->
<!--                                        <span class="fa fa-eye field-icon" id="password-icon" onclick="editFunction('password', 'password-icon')"></span>-->
                                    </div>
                                </div>
                                <div class="form-group col-md-8">
                                    <label class="col-md-4 control-label">Delivery api logging flag</label>
                                    <div class="col-md-8">
                                        <input type="number" class="form-control" name="delivery_api_logging_flag" id="delivery_api_logging_flag">
                                    </div>
                                </div>
                                <div class="form-group col-md-8">
                                    <label class="col-md-4 control-label">admin_booked_packet_import_file</label>
                                    <div class="col-md-8">
                                        <input type="number" class="form-control" name="admin_booked_packet_import_file" id="admin_booked_packet_import_file">
                                    </div>
                                </div>
                                <div class="form-group col-md-8">
                                    <label class="col-md-4 control-label">commission_cron_date</label>
                                    <div class="col-md-8">
                                        <input type="number" class="form-control" name="commission_cron_date" id="commission_cron_date">
                                    </div>
                                </div>
                                <div class="form-group col-md-8">
                                    <label class="col-md-4 control-label">Commission Amount</label>
                                    <div class="col-md-8">
                                        <input type="number" class="form-control" name="Commission_Amount" id="Commission_Amount">
                                    </div>
                                </div>
                                <div class="form-group col-md-8">
                                    <label class="col-md-4 control-label">Pick Up Open Time (hh:mm:ss)</label>
                                    <div class="col-md-8">
                                        <input type="number" class="form-control" name="pickup_open_time" id="pickup_open_time">
                                    </div>
                                </div>
                                <div class="form-group col-md-8">
                                    <label class="col-md-4 control-label">Pick Up Close Time (hh:mm:ss)</label>
                                    <div class="col-md-8">
                                        <input type="number" class="form-control" name="pickup_close_time" id="pickup_close_time">
                                    </div>
                                </div>
                                <div class="form-group col-md-8">
                                    <label class="col-md-4 control-label">Head Office Map [Embedded Link]*</label>
                                    <div class="col-md-8">
                                        <input type="number" class="form-control" name="pickup_close_time" id="pickup_close_time">
                                    </div>
                                </div>
                                <div class="form-group col-md-8">
                                    <label class="col-md-4 control-label">Enable Send Email</label>
                                    <div class="col-md-8">
                                        <input type="checkbox" class="email-send" name="enable_send_email" id="enable_send_email">yes
                                        <input type="checkbox" class="email-send" name="enable_send_email" id="enable_send_email">no
                                    </div>
                                </div>
                                <div class="form-group col-md-8">
                                    <label class="col-md-4 control-label">Commissionable Months</label>
                                    <div class="col-md-8">
                                        <input type="number" class="form-control" name="commissionable_months" id="commissionable_months">
                                    </div>
                                </div>
                                <div class="form-group col-md-8">
                                    <label class="col-md-4 control-label">Include Saturday</label>
                                    <div class="col-md-8">
                                        <input type="number" class="form-control" name="include_saturday" id="include_saturday">
                                    </div>
                                </div>
                                <div class="form-group col-md-8">
                                    <label class="col-md-4 control-label">sms_logging_flag</label>
                                    <div class="col-md-8">
                                        <input type="number" class="form-control" name="sms_logging_flag" id="sms_logging_flag">
                                    </div>
                                </div>
                                <div class="form-group col-md-8">
                                    <label class="col-md-4 control-label">api_logging_flag</label>
                                    <div class="col-md-8">
                                        <input type="number" class="form-control" name="api_logging_flag" id="api_logging_flag">
                                    </div>
                                </div>
                                <div class="form-group col-md-8">
                                    <label class="col-md-4 control-label">arrival_api_last_from_date</label>
                                    <div class="col-md-8">
                                        <input type="number" class="form-control" name="arrival_api_last_from_date" id="arrival_api_last_from_date">
                                    </div>
                                </div>
                                <div class="form-group col-md-8">
                                    <label class="col-md-4 control-label">arrival_api_key</label>
                                    <div class="col-md-8">
                                        <input type="number" class="form-control" name="arrival_api_key" id="arrival_api_key">
                                    </div>
                                </div>
                                <div class="form-group col-md-8">
                                    <label class="col-md-4 control-label">arrival_api_secret_key</label>
                                    <div class="col-md-8">
                                        <input type="number" class="form-control" name="arrival_api_secret_key" id="arrival_api_secret_key">
                                    </div>
                                </div>
                                <div class="form-group col-md-8">
                                    <label class="col-md-4 control-label">arrival_api_records_limit</label>
                                    <div class="col-md-8">
                                        <input type="number" class="form-control" name="arrival_api_records_limit" id="arrival_api_records_limit">
                                    </div>
                                </div>
                                <div class="form-group col-md-8">
                                    <label class="col-md-4 control-label">code_error_reporting</label>
                                    <div class="col-md-8">
                                        <input type="number" class="form-control" name="code_error_reporting" id="code_error_reporting">
                                    </div>
                                </div>
                                <div class="form-group col-md-8">
                                    <label class="col-md-4 control-label">admin_notification_emails</label>
                                    <div class="col-md-8">
                                        <input type="number" class="form-control" name="admin_notification_emails" id="admin_notification_emails">
                                    </div>
                                </div>
                                <div class="form-group col-md-8">
                                    <label class="col-md-4 control-label">arrival_api_last_record_id</label>
                                    <div class="col-md-8">
                                        <input type="number" class="form-control" name="arrival_api_last_record_id" id="arrival_api_last_record_id">
                                    </div>
                                </div>
                                <div class="form-group col-md-8">
                                    <label class="col-md-4 control-label">delete_invoice_rights_ids</label>
                                    <div class="col-md-8">
                                        <input type="number" class="form-control" name="delete_invoice_rights_ids" id="delete_invoice_rights_ids">
                                    </div>
                                </div>
                                <div class="form-group col-md-8">
                                    <label class="col-md-4 control-label">delivery_status_cron_is_running</label>
                                    <div class="col-md-8">
                                        <input type="number" class="form-control" name="delivery_status_cron_is_running" id="delivery_status_cron_is_running">
                                    </div>
                                </div>
                                <div class="form-group col-md-8">
                                    <label class="col-md-4 control-label">delivery_status_cron_logging_flag</label>
                                    <div class="col-md-8">
                                        <input type="number" class="form-control" name="delivery_status_cron_logging_flag" id="delivery_status_cron_logging_flag">
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
<script>
    function editFunction(inputId, iconId){
        var emailInput = document.getElementById(inputId);
        var icon = document.getElementById(iconId);

        if(emailInput.disabled === true){
            icon.classList.remove("fa-eye");
            icon.classList.add("fa-close");
            emailInput.disabled = false;
        }else{
            icon.classList.remove("fa-close");
            icon.classList.add("fa-eye");
            emailInput.disabled = true;
        }
    }
</script>
<?= $this->endSection() ?>