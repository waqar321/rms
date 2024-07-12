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
                        <h2>Api Packet Data</h2>
                        <div class="clearfix"></div>
                        <hr>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <label class="control-label col-md-12 col-sm-12 col-xs-12">Client</label>
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <select class="form-control">
                                            <option value="">Client 1</option>
                                            <option value="">Client 2</option>
                                            <option value="">Client 3</option>
                                            <option value="">Client 4</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 ">
                                    <label style="margin-left: 11px;">Date</label>
                                    <form class="form-horizontal">
                                        <fieldset>
                                            <div class="control-group">
                                                <div class="controls">
                                                    <div class="input-prepend input-group" style="margin-left: 11px;">
                                                        <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                                                        <input type="text" style="width: 272px" name="reservation" id="reservation" class="form-control" value="01/01/2016 - 01/25/2016" />
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </form>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-12" style="margin-top: 3.5%">
                                    <div class="col-md-12 col-sm-12">
                                        <button type="button" class="btn btn-primary">Filter</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="x_content">

                        <table id="datatable-buttons" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>Sr #</th>
                                <th>CN #</th>
                                <th>Shipment Type</th>
                                <th>To</th>
                                <th>From</th>
                                <th>Shipper Name</th>
                                <th>Consignee Name</th>
                                <th>Consignee Phone</th>
                                <th>Consignee Address</th>
                                <th>COD Amount (PKR)</th>
                                <th>Booking Status</th>
                                <th>Error Message</th>
                                <th>Date Created</th>
                            </tr>
                            </thead>


                            <tbody>
                            <tr>
                                <td>1</td>
                                <td>CN-6546</td>
                                <td>Over Night</td>
                                <td>2011/04/25</td>
                                <td>2011/04/25</td>
                                <td>Bilal Qureshi</td>
                                <td>Ahmed Idrees</td>
                                <td>06512365432</td>
                                <td>address 1</td>
                                <td>5000</td>
                                <td>Pending</td>
                                <td>Error Message</td>
                                <td>2011/04/25</td>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>CN-6546</td>
                                <td>Over Night</td>
                                <td>2011/04/25</td>
                                <td>2011/04/25</td>
                                <td>Bilal Qureshi</td>
                                <td>Ahmed Idrees</td>
                                <td>06512365432</td>
                                <td>address 1</td>
                                <td>5000</td>
                                <td>Pending</td>
                                <td>Error Message</td>
                                <td>2011/04/25</td>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>CN-6546</td>
                                <td>Over Night</td>
                                <td>2011/04/25</td>
                                <td>2011/04/25</td>
                                <td>Bilal Qureshi</td>
                                <td>Ahmed Idrees</td>
                                <td>06512365432</td>
                                <td>address 1</td>
                                <td>5000</td>
                                <td>Pending</td>
                                <td>Error Message</td>
                                <td>2011/04/25</td>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>CN-6546</td>
                                <td>Over Night</td>
                                <td>2011/04/25</td>
                                <td>2011/04/25</td>
                                <td>Bilal Qureshi</td>
                                <td>Ahmed Idrees</td>
                                <td>06512365432</td>
                                <td>address 1</td>
                                <td>5000</td>
                                <td>Pending</td>
                                <td>Error Message</td>
                                <td>2011/04/25</td>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>CN-6546</td>
                                <td>Over Night</td>
                                <td>2011/04/25</td>
                                <td>2011/04/25</td>
                                <td>Bilal Qureshi</td>
                                <td>Ahmed Idrees</td>
                                <td>06512365432</td>
                                <td>address 1</td>
                                <td>5000</td>
                                <td>Pending</td>
                                <td>Error Message</td>
                                <td>2011/04/25</td>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>CN-6546</td>
                                <td>Over Night</td>
                                <td>2011/04/25</td>
                                <td>2011/04/25</td>
                                <td>Bilal Qureshi</td>
                                <td>Ahmed Idrees</td>
                                <td>06512365432</td>
                                <td>address 1</td>
                                <td>5000</td>
                                <td>Pending</td>
                                <td>Error Message</td>
                                <td>2011/04/25</td>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>CN-6546</td>
                                <td>Over Night</td>
                                <td>2011/04/25</td>
                                <td>2011/04/25</td>
                                <td>Bilal Qureshi</td>
                                <td>Ahmed Idrees</td>
                                <td>06512365432</td>
                                <td>address 1</td>
                                <td>5000</td>
                                <td>Pending</td>
                                <td>Error Message</td>
                                <td>2011/04/25</td>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>CN-6546</td>
                                <td>Over Night</td>
                                <td>2011/04/25</td>
                                <td>2011/04/25</td>
                                <td>Bilal Qureshi</td>
                                <td>Ahmed Idrees</td>
                                <td>06512365432</td>
                                <td>address 1</td>
                                <td>5000</td>
                                <td>Pending</td>
                                <td>Error Message</td>
                                <td>2011/04/25</td>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>CN-6546</td>
                                <td>Over Night</td>
                                <td>2011/04/25</td>
                                <td>2011/04/25</td>
                                <td>Bilal Qureshi</td>
                                <td>Ahmed Idrees</td>
                                <td>06512365432</td>
                                <td>address 1</td>
                                <td>5000</td>
                                <td>Pending</td>
                                <td>Error Message</td>
                                <td>2011/04/25</td>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>CN-6546</td>
                                <td>Over Night</td>
                                <td>2011/04/25</td>
                                <td>2011/04/25</td>
                                <td>Bilal Qureshi</td>
                                <td>Ahmed Idrees</td>
                                <td>06512365432</td>
                                <td>address 1</td>
                                <td>5000</td>
                                <td>Pending</td>
                                <td>Error Message</td>
                                <td>2011/04/25</td>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>CN-6546</td>
                                <td>Over Night</td>
                                <td>2011/04/25</td>
                                <td>2011/04/25</td>
                                <td>Bilal Qureshi</td>
                                <td>Ahmed Idrees</td>
                                <td>06512365432</td>
                                <td>address 1</td>
                                <td>5000</td>
                                <td>Pending</td>
                                <td>Error Message</td>
                                <td>2011/04/25</td>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>CN-6546</td>
                                <td>Over Night</td>
                                <td>2011/04/25</td>
                                <td>2011/04/25</td>
                                <td>Bilal Qureshi</td>
                                <td>Ahmed Idrees</td>
                                <td>06512365432</td>
                                <td>address 1</td>
                                <td>5000</td>
                                <td>Pending</td>
                                <td>Error Message</td>
                                <td>2011/04/25</td>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>CN-6546</td>
                                <td>Over Night</td>
                                <td>2011/04/25</td>
                                <td>2011/04/25</td>
                                <td>Bilal Qureshi</td>
                                <td>Ahmed Idrees</td>
                                <td>06512365432</td>
                                <td>address 1</td>
                                <td>5000</td>
                                <td>Pending</td>
                                <td>Error Message</td>
                                <td>2011/04/25</td>
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
