<?= $this->extend('Admin/layout/main') ?>

<?= $this->section('styles') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Add Shipper</h3>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Pages <small>Add Shipper</small></h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <br />
                            <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
                                <div class="form-group">
                                    <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Company </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select class="form-control">
                                            <option value="-1">- Please Select Company -</option>
                                            <option value="610281">BIN TAJ UNIQUE STORE</option>
                                            <option value="610282">COSMETICS</option>
                                            <option value="610283">ALI AND ALI ENTERPRISES</option>
                                            <option value="610284">GADGETS DUNYA</option>
                                            <option value="610241">SHOPNJOIN STORE</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">City </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select class="form-control">
                                            <option value="-1">- Please Select City -</option>
                                            <option value="1174">Abbaspur (a.k)</option>
                                            <option value="1">Abbottabad</option>
                                            <option value="924">Abdul hakim</option>
                                            <option value="119">Aboha</option>
                                            <option value="1261">Adda 46 chak s</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Shipper Name </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input class="form-control" >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Shipper Email </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input class="form-control" >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Shipper Phone </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input class="form-control" >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Shipper Address</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input class="form-control" >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12"></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input checked name="is_settlement" id="toggle-all" class="enableBankDetails" type="checkbox" style="margin-left: auto;">
                                        <strong>If you intend to settle your shippers separately, you can insert below mentioned details to facilitate your shippers.</strong>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Bank </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select name="bank_id" id="bank_id"  class="form-control">
                                            <option value="-1">- Select a Bank -</option>
                                            <option value="1">First Women Bank Limited</option>
                                            <option value="3">National Bank of Pakistan</option>
                                            <option value="4">The Bank of Punjab</option>
                                            <option value="5">SIND BANK LIMITED</option>
                                            <option value="6">BankIslami Pakistan Limited</option>
                                            <option value="7">ALBARAKA BANK (PAKISTAN) LIMITED</option>
                                            <option value="8">Burj Bank Limited</option>
                                            <option value="9">Meezan Bank Limited</option>
                                            <option value="10">Dubai Islamic Ban</option>
                                            <option value="11">SAMBA BANK LIMITED</option>
                                            <option value="12">JS Bank Limited</option>
                                            <option value="13">Allied Bank Limited</option>
                                            <option value="14">KASB Bank Limited</option>
                                            <option value="15">SUMMIT BANK LIMITED</option>
                                            <option value="16">MCB Bank Limited</option>
                                            <option value="17">Askari Bank Limited</option>
                                            <option value="18">NIB Bank Limited</option>
                                            <option value="19">Bank Alfalah Limited</option>
                                            <option value="20">SILK BANK LIMITED</option>
                                            <option value="21">Bank Al Habib Limited</option>
                                            <option value="22">Soneri Bank Limited</option>
                                            <option value="23">Standard Chartered Bank (Pakistan) Limited</option>
                                            <option value="24">Faysal Bank Limited</option>
                                            <option value="25">United Bank Limited</option>
                                            <option value="26">Habib Bank Limited</option>
                                            <option value="27">Habib Metropolitan Bank Limited</option>
                                            <option value="28">The Bank of Tokyo-Mitsubishi UFJ Limited - Pakistan Operations</option>
                                            <option value="29">Citibank N.A. - Pakistan Operations</option>
                                            <option value="30">HSBC Bank Middle East Limited ? Pakistan</option>
                                            <option value="31">Deutsche Bank AG - Pakistan Operations</option>
                                            <option value="32">Barclays Bank PLC</option>
                                            <option value="33">Oman International Bank S.A.O.G ? Pakistan Operations</option>
                                            <option value="34">INDUSTRIAL AND COMMERCIAL BANK OF CHINA LIMITED ? PAKISTAN BRANCHES</option>
                                            <option value="35">House Building Finance Corporation</option>
                                            <option value="36">Pakistan Kuwait Investment Company Limited</option>
                                            <option value="37">Pak Brunei investment Company Limited</option>
                                            <option value="38">Pak Oman Investment Company Limited</option>
                                            <option value="39">Pak Iran Joint Investment Company</option>
                                            <option value="40">Saudi Pak Industrial &amp; Agricultural Investment Company Limited</option>
                                            <option value="41">Pak Libya Holding Company Limited</option>
                                            <option value="42">PAK-China Investment Company Limited</option>
                                            <option value="43">Industrial Development Bank of Pakistan</option>
                                            <option value="44">The Punjab Provincial Cooperative Bank Ltd</option>
                                            <option value="45">SME Bank Limited</option>
                                            <option value="46">Zarai Taraqiati Bank Limited</option>
                                            <option value="47">Khushhali Bank Limited</option>
                                            <option value="48">U MICROFINANCE BANK LIMITED</option>
                                            <option value="49">NRSP MICROFINANCE BANK LIMITED</option>
                                            <option value="50">Tameer Micro Finance Bank Limited</option>
                                            <option value="51">Pak Oman Microfinance Bank Limited</option>
                                            <option value="52">The First Micro Finance Bank Limited</option>
                                            <option value="53">KASHF MICROFINANCE BANK LIMITED</option>
                                            <option value="54">APNA MICROFINANCE BANK LIMITED</option>
                                            <option value="55">WASEELA MICROFINANCE BANK LIMITED</option>
                                            <option value="56">ADVANS PAKISTAN MICROFINANCE BANK LIMITED</option>
                                            <option value="59">Faysal Bank</option>
                                            <option value="60">Al Baraka Bank</option>
                                            <option value="61">Habib Bank Limited</option>
                                            <option value="62">Cash</option>
                                            <option value="63">Finca Micro Bank</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Bank Account No.</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input class="form-control" id="bank_account_no">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="middle-name"  class="control-label col-md-3 col-sm-3 col-xs-12">Bank Account Title </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input class="form-control" id="bank_account_title" >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Bank Branch </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input class="form-control" id="bank_branch">
                                    </div>
                                </div>
                                <div class="ln_solid"></div>
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
<script>
    $(".enableBankDetails").on("click",function(){
        if($('.enableBankDetails').prop('checked')){
            $("#bank_id, #bank_account_no, #bank_account_title, #bank_branch").prop( "disabled", false );
        } else {

            $("#bank_account_no, #bank_account_title, #bank_branch").val("");

            $("#bank_id_td, #bank_account_no_td, #bank_account_title_td, #bank_branch_td").css("visibility", "hidden");
            $("#bank_id, #bank_account_no, #bank_account_title, #bank_branch").prop( "disabled", true );
        }
    });
</script>
<?= $this->endSection() ?>