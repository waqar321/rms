<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <title>GST Inv. Summary-<?= $invoiceSummary['invoice_number']; ?></title>
    </head>
    <body style="font-size: 12px; font-family: Helvetica, Arial ;">
        <div style="position: relative; width: 100%;">

            <div class="header" style="position: relative; width: 100%; height: 160px; margin: 2px;float: left;">

<!--                <div class="logo" style="position: relative; width: 50%;float: left;">
                    <img src="<?= base_url(); ?>assets/pages/img/small_logo.png" />
                </div>
                <div class="heading" style="position: relative; width: 40%;float: right;">
                    <h1 style="position: relative; text-align: right;top: 40px; right: 25px; font-size: 50px;">
                        <span>INVOICE</span>
                        <br>
                        <small style="float: right; text-align: right;font-size: 14px;">Summary</small>
                    </h1>
                </div>-->

            </div>

            <div class="clientDetails" style="display: inline-block; position: relative; width: 100%;float: left;">
                <ul style="list-style: none;float: left;width: 600px;">
                    <li style="padding: 3px 0;">
                        <div style="display: inline-block;width: 80px; font-weight: bold;float: left;">Account No.</div>
                        <div style="display: inline-block;margin-left: 5px;"> <?= $invoiceSummary['company_account_no']; ?></div>
                    </li>
                    <li style="padding: 3px 0;">
                        <div style="display: inline-block;width: 80px; font-weight: bold;float: left;">Name</div>
                        <div style="display: inline-block;margin-left: 5px;"> <?= $invoiceSummary['company_name_eng']; ?></div>
                    </li>
                    <li style="padding: 3px 0;">
                        <div style="display: inline-block;width: 80px; font-weight: bold;float: left;">NTN</div>
                        <div style="display: inline-block;margin-left: 5px;"> <?= ($invoiceSummary['company_ntn'] == '' ? 'N/A' : $invoiceSummary['company_ntn']); ?></div>
                    </li>
                    <li style="padding: 3px 0;">
                        <div style="display: inline-block;width: 80px; font-weight: bold;float: left;">Address</div>
                        <div style="display: inline-block;margin-left: 5px; width: 500px;"> <?= ucwords(strtolower($invoiceSummary['company_address'])); ?></div>
                    </li>
                    <li style="padding: 3px 0;">
                        <div style="display: inline-block;width: 80px; font-weight: bold;float: left;">State</div>
                        <div style="display: inline-block;margin-left: 5px;"> <?= ucfirst($invoiceSummary['state_name_eng']); ?></div>
                    </li>
                </ul>

                <ul style="list-style: none; position: relative; width: 250px;float: right;">
                    <li style="padding: 3px 0;">
                        <div style="display: inline-block;width: 130px; font-weight: bold;float: left;">Sale Tax Invoice No.</div>
                        <div style="display: inline-block;margin-left: 5px;"><?= $invoiceSummary['invoice_number']; ?></div>
                    </li>
                    <li style="padding: 3px 0;">
                        <div style="display: inline-block;width: 130px; font-weight: bold;float: left;">Invoice Date</div>
                        <div style="display: inline-block;margin-left: 5px;"><?= date('d / m / Y', strtotime($invoiceSummary['invoice_date'])); ?></div>
                    </li>
                </ul>
            </div>

            <hr style="border-color: #e7ecf1;">

            <div class="body" style="width: 100%; position: relative; float: left;">
                <ul style="list-style: none; width: 60%; margin: 0 auto;">
                    <li style="padding: 8px 5px;">
                        <div style="display: inline-block;width: 45%; font-weight: bold;float: left;">Invoice Total</div>
                        <div style="text-align: right; display: inline-block; width: 45%;"><?= $invoiceSummary['invoice_total']; ?></div>
                    </li>
                    <li style="padding: 8px 5px;">
                        <div style="display: inline-block;width: 45%; font-weight: bold;float: left;">Fuel Surcharge</div>
                        <div style="text-align: right; display: inline-block; width: 45%;"><?= $invoiceSummary['fuel_surcharge']; ?></div>
                    </li>
                    <li style="padding: 8px 5px;">
                        <div style="display: inline-block;width: 45%; font-weight: bold;float: left;">Net Amount</div>
                        <div style="text-align: right; display: inline-block; width: 45%;"><?= $invoiceSummary['net_amount']; ?></div>
                    </li>
                    <li style="padding: 8px 5px;">
                        <div style="display: inline-block;width: 45%; font-weight: bold;float: left;">Sales Tax</div>
                        <div style="text-align: right; display: inline-block; width: 45%;"><?= number_format(($invoiceSummary['net_amount'] * $invoiceSummary['state_tax']) / 100, 2); ?></div>
                    </li>
                    <li style="padding: 8px 5px;">
                        <div style="display: inline-block;width: 45%; font-weight: bold;float: left;">Gross Total</div>
                        <div style="text-align: right; display: inline-block; width: 45%;"><?= $invoiceSummary['gross_total']; ?></div>
                    </li>
                </ul>

                <div class="amount-in-words" style="width: 60%;position: relative;margin: 10px 0 10px 181px;border: 1px solid #e7ecf1;padding: 5px 8px;display: inline-block;">
                    <div style="width:20%; padding: 8px 5px; display: inline-block; float: left; font-weight: bold;">Amount In Words</div>
                    <div style="width:75%; padding: 8px 5px; display: inline-block; float: right;"> <?= $this->numbertowords->convert_number(ceil($invoiceSummary['gross_total'])); ?> Rupees Only.</div>
                </div>

                <div class="note" style="width: 60%;margin: 15px auto;background: #e7ecf1;font-weight: bold;position: relative;clear: both;padding: 10px">
                    <code>Payment should be made via cross cheque in favour of Leopards Courier Services Pvt. Ltd.</code>
<!--                    <code>Payment should be made via cross cheque in favour of Leopards Courier Services Pvt. Ltd. Leopards is exempted from Income Tax deduction U/S 153(1) of income tax ordinance 2001.</code>-->
                </div>
            </div>


<!--            <div class="footer" style="position: relative;left: 5px;margin-top: 335px;width: 100%;">

                <hr style="border-color: #e7ecf1; border: 2px;">

                <div style="width: 17%;float: left;">
                    <div style="text-align: left; float: left;font-weight: bold;text-align: center;">Sales Tax Reg. #</div>
                    <div style="text-align: left;text-align: center;">12-00-9808-001-91</div>
                </div>
                <div style="text-align: center; width: 65%; float: left;margin-top: 7px;">This is also considered as Sales Tax Invoice U/S 23 Of Sales Tax Act, 1990.</div>
                <div style="width: 17%;float: left;margin-top: 0px;">
                    <div style="font-weight: bold;float: left;text-align: center;">N.T.N #</div>
                    <div style="text-align: center;">14-05-2824502-4</div>
                </div>

            </div>-->

<!--            <div style="text-align: left; width: 100%;margin-top: 12px;">
                <small>Note: This is system generated invoice hence does not need any signature / stamp.</small>
            </div>-->
        </div>
    </body>
</html>