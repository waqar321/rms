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
                            <h2>Manage Allowed Clients in Additional Half KG<small></small></h2>
                        </div>
                        <!--                        <div class="col-md-6" style="display: flex; justify-content: flex-end;">-->
                        <!--                            <label class="control-label col-md-12 col-sm-12"></label>-->
                        <!--                            <a class="btn btn-primary" href="--><?php //echo base_url('manage/shipment_type/add') ?><!--">Add</a>-->
                        <!--                        </div>-->
                        <div class="clearfix"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <label class="control-label col-md-12 col-sm-12">Client </label>
                            <div class="col-md-12 col-sm-12">
                                <select name="company_id" class="form-control" id="company_id">
                                    <option value="-1">- Select a Client -</option>
                                    <option value="603611">558125 - (BONA PAPA NANA MOMSE) ANA &amp; BATLA INDUSTRIES</option>
                                    <option value="597732">203555 - (CPH) CUSTOM PRINTING HUB</option>
                                    <option value="589251">551353 - (DANIX) (TAJ MARBLES)</option>
                                    <option value="602345">557185 - (E4U) EVERY THINGS FOR YOU</option>
                                    <option value="587926">550341 - (LUXURY LINGERIE)</option>
                                </select>

                            </div>
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-12 mt-4" style="margin-top: 17px;">
                            <label class="control-label col-md-12 col-sm-12"></label>
                            <button type="submit" class="btn btn-primary">Add</button>
                        </div>
                    </div>
                    <div class="x_content">
                        <table id="datatable" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>Sr #</th>
                                <th>Company Account No.</th>
                                <th>Company Name</th>
                                <th>Created At</th>
                                <th>Added By</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>1</td>
                                <td>2747</td>
                                <td>JADE E SERVICES PAKISTAN (PVT) LTD</td>
                                <td>2020-10-06 05:41:06</td>
                                <td>EHSAN COD KHI. (ACCOUNTS DEPT)</td>
                                <td><a href="javascript:void(0);" class="delete_client" id="241">Delete</a></td>
                            </tr>
                            <tr class="alternate-row">
                                <td>2</td>
                                <td>056441</td>
                                <td>UNIQUE COLLECTION</td>
                                <td>2020-04-24 16:39:31</td>
                                <td>FAHAD SHAKIL</td>
                                <td><a href="javascript:void(0);" class="delete_client" id="240">Delete</a></td>
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

