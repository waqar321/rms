<?= $this->extend('Admin/layout/main') ?>

<?= $this->section('styles') ?>
<style>
    .label-alignment{
        text-align: left!important;
        padding: 0px;
    }
    .packet-list-cn{
        padding: 0px;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Verify Bank Transaction</h3>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <br/>
                        <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">


                            <div class="input-group col-md-6 api-key-input">
                                <label class="control-label">Packet CN # </label>
                                <input type="text" class="form-control">
                                <span class="input-group-btn">
                                        <button type="button" class="btn btn-primary" style="margin-top: 47%">Add</button>
                                    </span>
                            </div>
                            <div class="item form-group">
                                <label class="control-label col-md-12 col-sm-3 col-xs-12 label-alignment" for="return_address">Packet CN # list (0)
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12 packet-list-cn">
                                    <textarea id="return_address" required="required" name="return_address" class="form-control col-md-7 col-xs-12"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-3 col-sm-6 col-xs-12">
                                    <button type="submit" class="btn btn-success">Search</button>
                                    <button class="btn btn-primary" type="button">Select All</button>
                                    <button class="btn btn-danger" type="button">Delete</button>
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
<?= $this->endSection() ?>
