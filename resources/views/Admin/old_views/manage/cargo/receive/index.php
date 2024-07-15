@extends('Admin.layout.main')

@section('styles')
@endsection

@section('content')
<!-- page content -->
<div class="right_col" role="main">
    <div class="">

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <div class="col-md-6">
                            <h2>Receivable Cargo Booking Listing<small></small></h2>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <label class="control-label col-md-12 col-sm-12">Filter </label>
                            <div class="col-md-12 col-sm-12">
                                <select class="form-control">
                                    <option value="-1">Please Select</option>
                                    <option value="viewAll">View All</option>
                                    <option value="viewActive">Received</option>
                                    <option value="viewInactive">Not Received</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <label class="control-label col-md-12 col-sm-12">Origin City</label>
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
                        <div class="col-md-3 col-sm-3 col-xs-12 mt-4" style="margin-top: 17px;">
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
                                <th>Created By</th>
                                <th>AWB / No</th>
                                <th>Remarks</th>
                                <th>Origin</th>
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
@endsection

@section('scripts')
@endsection

