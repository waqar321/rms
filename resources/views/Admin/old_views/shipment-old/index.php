<?= $this->extend('Admin/layout/main') ?>

<?= $this->section('styles') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<!-- page content -->
<div class="right_col" role="main">
    <div class="">

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <div class="col-md-6">
                            <h2>Shipment Listing<small></small></h2>
                        </div>
                        <div class="col-md-6" style="display: flex; justify-content: flex-end;">
                            <label class="control-label col-md-12 col-sm-12"></label>
                            <a class="btn btn-primary" href="<?php echo base_url('manage_client/shipment/add') ?>">Add</a>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-2 col-sm-2 col-xs-12">
                            <label class="control-label col-md-12 col-sm-12">Filter </label>
                            <div class="col-md-12 col-sm-12">
                                <select class="form-control">
                                    <option value="-1">Please Select</option>
                                    <option value="viewAll">View All</option>
                                    <option value="viewActive">Active</option>
                                    <option value="viewInactive">Inactive</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <label class="control-label col-md-12 col-sm-12">City </label>
                            <div class="col-md-12 col-sm-12">
                                <select class="form-control">
                                    <option value="1174">Abbaspur (a.k)</option>
                                    <option value="1">Abbottabad</option>
                                    <option value="924">Abdul hakim</option>
                                    <option value="119">Aboha</option>
                                    <option value="1261">Adda 46 chak s</option>
                                    <option value="1451">Adda aujla kala</option>
                                    <option value="1435">Adda pakhi more</option>
                                    <option value="336">Adda pensra</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <label class="control-label col-md-12 col-sm-12">Company </label>
                            <div class="col-md-12 col-sm-12">
                                <select id="country_id" name="country_id" class="form-control" >
                                    <option value="">- Select a Company -</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-12 mt-4" style="margin-top: 17px;">
                            <label class="control-label col-md-12 col-sm-12"></label>
                            <button type="submit" class="btn btn-primary">Filter</button>
                        </div>
                    </div>
                    <div class="x_content">
                        <table id="datatable" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>Sr #</th>
                                <th>System ID#</th>
                                <th>Company</th>
                                <th>Shipper Name</th>
                                <th>Shipper Phone</th>
                                <th>City</th>
                                <th>Date Created</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>1</td>
                                <td>52154</td>
                                <td>CN-1029</td>
                                <td>OR-5555</td>
                                <td>OR-5555</td>
                                <td>OR-5555</td>
                                <td>OR-5555</td>
                                <td >
                                    <a  title="Edit" class="fa fa-gear"></a>
                                </td>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>52154</td>
                                <td>CN-1029</td>
                                <td>OR-5555</td>
                                <td>OR-5555</td>
                                <td>OR-5555</td>
                                <td>OR-5555</td>
                                <td >
                                    <a  title="Edit" class="fa fa-gear"></a>
                                </td>
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

