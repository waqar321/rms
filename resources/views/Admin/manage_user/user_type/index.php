<?= $this->extend('Admin/layout/main') ?>

<?= $this->section('styles') ?>
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
                            <h2>User Type <small>Listing</small></h2>
                            <div class="col-md-2 col-md-offset-8 text-right">
                                <a href="<?php echo base_url('manage_user/user_type/create') ?>"><button class="form-control btn btn-sm btn-primary">Add New User Type</button></a>
                            </div>
                            <div class="clearfix"></div>
                            <hr>
                            <div class="row">
                                <div class="col-md-3 col-sm-3 col-xs-12">
                                    <label class="control-label col-md-12 col-sm-12 col-xs-12">Status</label>
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <select class="form-control select2">
                                            <option>Status</option>
                                            <option value="">Status 1</option>
                                            <option value="">Status 2</option>
                                            <option value="">Status 3</option>
                                            <option value="">Status 4</option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="x_content">
                            <!-- <p class="text-muted font-13 m-b-30">
                              DataTables has most features enabled by default, so all you need to do to use it with your own tables is to call the construction function: <code>$().DataTable();</code>
                            </p> -->
                            <table id="datatable" class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>SR#</th>
                                    <th>SYS ID#</th>
                                    <th>User Type</th>
                                    <th>Date Created</th>
                                    <th>Action</th>
                                </tr>
                                </thead>


                                <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>1131454</td>
                                    <td>User Type</td>
                                    <td>16 Jun, 2023 10:16:00 AM</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td>1131454</td>
                                    <td>User Type</td>
                                    <td>16 Jun, 2023 10:16:00 AM</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td>1131454</td>
                                    <td>User Type</td>
                                    <td>16 Jun, 2023 10:16:00 AM</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td>1131454</td>
                                    <td>User Type</td>
                                    <td>16 Jun, 2023 10:16:00 AM</td>
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
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<?= $this->endSection() ?>