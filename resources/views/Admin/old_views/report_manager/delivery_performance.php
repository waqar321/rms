<?= $this->extend('Admin/layout/main') ?>

<?= $this->section('styles') ?>

<style>
    /*  Delivery Performance report heading css  */
    .dpr-heading{
        text-align: center;
    }
</style>

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
                        <h2>Report Manager</h2>
                        <div class="clearfix"></div>
                        <hr>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <label class="control-label col-md-12 col-sm-12 col-xs-12">User Type</label>
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <select class="form-control">
                                            <option>User Type</option>
                                            <option value="">Client</option>
                                            <option value="">LCS Application User</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <label class="control-label col-md-12 col-sm-12 col-xs-12">Report Type</label>
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <select class="form-control">
                                            <option>Invoice Report</option>
                                            <option value="">Consignment Detail Report</option>
                                            <option value="">Summary Report</option>
                                            <option value="">Payment Received</option>
                                            <option value="">Return Shipment</option>
                                            <option value="">Pending Shipment</option>
                                            <option value="">Cancel Shipment</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <label class="control-label col-md-12 col-sm-12">Shipment Type</label>
                                    <div class="col-md-12 col-sm-12">
                                        <select class="form-control">
                                            <option>Cash On Delivery - COD</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <label class="control-label col-md-12 col-sm-12 col-xs-12">Origin City</label>
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <select class="form-control">
                                            <option>Karachi</option>
                                            <option value="">Islamabad</option>
                                            <option value="">Lahore</option>
                                            <option value="">Quetta</option>
                                            <option value="">Rawalpindi</option>
                                            <option value="">Abtabad</option>
                                            <option value="">Multan</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <label class="control-label col-md-12 col-sm-12 col-xs-12">Destination City</label>
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <select class="form-control">
                                            <option>Karachi</option>
                                            <option value="">Islamabad</option>
                                            <option value="">Lahore</option>
                                            <option value="">Quetta</option>
                                            <option value="">Rawalpindi</option>
                                            <option value="">Abtabad</option>
                                            <option value="">Multan</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <label class="control-label col-md-12 col-sm-12 col-xs-12">Client City</label>
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <select class="form-control">
                                            <option>Karachi</option>
                                            <option value="">Islamabad</option>
                                            <option value="">Lahore</option>
                                            <option value="">Quetta</option>
                                            <option value="">Rawalpindi</option>
                                            <option value="">Abtabad</option>
                                            <option value="">Multan</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <label class="control-label col-md-12 col-sm-12 col-xs-12">COD Zone</label>
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <select class="form-control">
                                            <option>All</option>
                                            <option value="">Zone 1</option>
                                            <option value="">Zone 2</option>
                                            <option value="">Zone 3</option>
                                            <option value="">Zone 4</option>
                                        </select>
                                    </div>
                                </div>

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
                                                    <span class="add-on input-group-addon"><i
                                                            class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                                                        <input type="text" style="width: 272px" name="reservation"
                                                               id="reservation" class="form-control"
                                                               value="01/01/2016 - 01/25/2016"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </form>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-12" style="margin-top: 3.5%">
                                    <div class="col-md-12 col-sm-12">
                                        <button type="button" class="btn btn-primary">Generate Report</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="x_content">
                        <div class="row dpr-heading">
                            <h3>Shipment Status Report Day wise</h3>
                        </div>
                        <table id="datatable-buttons" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th colspan="6" class="text-center">2023-07-09</th>
                            </tr>
                            <tr>
                                <th>Destination City</th>
                                <th>Delivered</th>
                                <th>Being Return</th>
                                <th>Return To Shipper</th>
                                <th>Under Process</th>
                                <th>Sub Total</th>
                            </tr>
                            <tr>
                                <th>Packets</th>
                                <th>Packets</th>
                                <th>Packets</th>
                                <th>Packets</th>
                                <th>Packets</th>
                                <th>Packets</th>
                            </tr>
                            </thead>


                            <tbody>
                            <tr>
                                <td>123</td>
                                <td>INV-123</td>
                                <td>INV-123</td>
                                <td>INV-123</td>
                                <td>INV-123</td>
                                <td>2023-02-25</td>
                            </tr>
                            <tr>
                                <td>321</td>
                                <td>INC-123</td>
                                <td>INC-123</td>
                                <td>INC-123</td>
                                <td>INC-123</td>
                                <td>2023-02-25</td>
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
