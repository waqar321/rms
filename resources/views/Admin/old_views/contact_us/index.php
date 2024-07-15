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
                    <div class="x_content">
                        <span class="section">Contact Us</span>
                        <div class="col-md-12">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3620.1279524066845!2d67.06505437455452!3d24.85947914529831!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3eb33e9f1ba16539%3A0x5d6235c594ae1a75!2sLeopards%20Courier%20Services%20Head%20Office!5e0!3m2!1sen!2s!4v1687774127016!5m2!1sen!2s"
                                    width="1010" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>

                        <form class="form-horizontal form-label-left" novalidate>
                            <div class="col-md-12" style="margin-top: 50px;">
                                <h3 class="text-center">Contact Us</h3>
                                <p class="text-center">Please fill up the contact us form below and our representative will contact you shortly</p>
                                <div class="ln_solid"></div>
                                <div class="col-md-6">
                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Full Name <span class="required">*</span>
                                        </label>
                                        <div class="col-md-9 col-sm-9 col-xs-12">
                                            <input id="name" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" name="name" placeholder="both name(s) e.g Jon Doe" required="required" type="text">
                                        </div>
                                    </div>
                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email <span class="required">*</span>
                                        </label>
                                        <div class="col-md-9 col-sm-9 col-xs-12">
                                            <input type="email" id="email" name="email" required="required" class="form-control col-md-7 col-xs-12">
                                        </div>
                                    </div>

                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="number">Phone <span class="required">*</span>
                                        </label>
                                        <div class="col-md-9 col-sm-9 col-xs-12">
                                            <input type="number" id="number" name="number" required="required" data-validate-minmax="10,100" class="form-control col-md-7 col-xs-12">
                                        </div>
                                    </div>

                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="subject">Full Name <span class="required">*</span>
                                        </label>
                                        <div class="col-md-9 col-sm-9 col-xs-12">
                                            <input id="subject" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" name="subject" placeholder="both name(s) e.g Jon Doe" required="required" type="text">
                                        </div>
                                    </div>


                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">Message <span class="required">*</span>
                                        </label>
                                        <div class="col-md-9 col-sm-9 col-xs-12">
                                            <textarea id="textarea" required="required" name="textarea" class="form-control col-md-7 col-xs-12"></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-9 col-md-offset-3">
                                            <button type="submit" class="btn btn-primary">Cancel</button>
                                            <button id="send" type="submit" class="btn btn-success">Submit</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h3>Head Office</h3>
                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">Address:
                                        </label>
                                        <div class="col-md-9 col-sm-9 col-xs-12 text-areas-style">
                                            <p>19-F, Block 6, P.E.C.H.S. Karachi.</p>
                                        </div>
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">UAN:
                                        </label>
                                        <div class="col-md-9 col-sm-9 col-xs-12 text-areas-style">
                                            <p>(021) 111-300-786.</p>
                                        </div>
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">TEL:
                                        </label>
                                        <div class="col-md-9 col-sm-9 col-xs-12 text-areas-style">
                                            <p>(021) 4548041-43, 4532063.</p>
                                        </div>
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">FAX:
                                        </label>
                                        <div class="col-md-9 col-sm-9 col-xs-12 text-areas-style">
                                            <p>(+92) 21 4552376.</p>
                                        </div>
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">EMAIL:
                                        </label>
                                        <div class="col-md-9 col-sm-9 col-xs-12 text-areas-style">
                                            <p>karachi@leopardscourier.com.</p>
                                        </div>
                                    </div>

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
