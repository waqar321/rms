<?= $this->extend('Admin/layout/main') ?>

<?= $this->section('styles') ?>

    <style>
        .container h1{
            color: #fff;
            text-align: center;
        }

        details{
            background-color: #303030;
            color: #fff;
            font-size: 1.5rem;
        }

        summary {
            padding: .5em 1.3rem;
            list-style: none;
            display: flex;
            justify-content: space-between;
            transition: height 1s ease;
        }

        summary::-webkit-details-marker {
            display: none;
        }

        summary:after{
            content: "\002B";
        }

        details[open] summary {
            border-bottom: 1px solid #aaa;
            margin-bottom: .5em;
        }

        details[open] summary:after{
            content: "\00D7";
        }

        details[open] div{
            padding: .5em 1em;
        }

        .rights-section{
            margin-top: 5%;
        }

        .rights-section details{
            background-color: #ffcb05;
            color: black;
            margin-top: 1%;
        }
    </style>

<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Add User Type</h3>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>User Type <small>Add User Type</small></h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
                                <div class="form-group col-md-6">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="user_type_name">User Type Name *
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" id="user_type_name" name="user_type_name" required="required" class="form-control col-md-7 col-xs-12">
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">User Type * </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select class="select2 form-control" tabindex="-1">
                                            <option>User Type</option>
                                            <option value="AK">user type 1</option>
                                            <option value="HI">User Type 2</option>
                                        </select>
                                    </div>
                                </div>

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
<?= $this->endSection() ?>