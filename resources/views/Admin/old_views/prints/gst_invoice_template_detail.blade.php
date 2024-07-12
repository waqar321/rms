<?php
if($invoice_type== 'Excel'){
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=Finance-gst-invoice-$report_type-report.xls");
    header("Pragma: no-cache");
    header("Expires: 0");
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en" xml:lang="en">
    <head>
        <title>Invoice {{$report_type}}</title>
        <style type="text/css">
            @media print {
                @page { margin: 0; }
                body { margin: 0.8cm; font-size: 9px;}
            }
            @media screen {
                font-size: 9px;
            }
            body {
            transform: scale(1);
            transform-origin: 0 0;
        }
    th{
        font-size:10px;
    }
    td{
        font-size:10px;
    }
        </style>
    </head>
    <body>

        <table width="100%" border="0" cellspacing="0" cellpadding="5" style="font-family:Arial, Helvetica, sans-serif;">
            <tr>
                <td colspan="8" align="right" valign="middle" style="color:#CCCCCC; border-bottom:1px solid #999999;">
                    <h1 style="padding:0px; margin:0px;"> 
                        INVOICE {{strtoupper($report_type)}}
                    </h1>
                </td>
            </tr>
            <tr>
                <td width="50%" colspan="7" align="left" valign="middle" style="border-bottom:1px solid #999999;">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <?php
                            if (app()->environment('local')) {
                                $imageSrc = url_secure('build/images/small_logo.png');
                            } else {
                                $imageSrc = public_path('build/images/small_logo.png');
                            }
                            ?>
                            <td width="50%"><img src="<?php echo $imageSrc ?>" height="60"/></td>
                            <td align="center">
                                
                            </td>
                        </tr>
                    </table>
                </td>
                
                <td width="50%" align="right" valign="top" style="border-bottom:1px solid #999999;">
                    <table width="74%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td><strong>Printed on:</strong></td>
                            <td>{{date('d/m/Y'); }}</td>
                        </tr>
                        <tr>
                            <td><strong>Payment Date:</strong></td>

                            <td>{{date('d/m/Y', strtotime($invoiceMasterDetails['created_at']));}}</td>
                        </tr>
                        <tr>
                            <td><strong>Invoice No.:</strong></td>
                            <td>{{$invoiceMasterDetails['invoice_number']}}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <br/>
        <?php 
        $dateArray = array();
        $min_date = $max_date = time();
       
        if (count($bookedPackets) > 0) {
            foreach ($bookedPackets as $booked_packetObj) { 
                // dd($booked_packetObj);
                $dateArray[] = strtotime($booked_packetObj->booked_packet_date);
            } 
            $min_date = min($dateArray); 
            $max_date = max($dateArray);
        }
        ?>
        <table width="100%" border="1" bordercolor="#CDDDDD" cellspacing="0" cellpadding="5" style="border-collapse:collapse; font-family:Arial, Helvetica, sans-serif; border-collapse:collapse; border-color: #CDDDDD;">
            <tr bgcolor="#E7EFEF">
                <td width="50%" style="background:#E7EFEF"><strong>TO</strong></td>
                <td width="50%" style="background:#E7EFEF"><strong>INVOICE INFORMATION</strong></td>
            </tr>
            <tr>
                <td width='50%' valign="top">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td style="width: 80px;"><b>COMPANY NAME:</b></td>
                            <td colspan="3">{{strtoupper($invoiceMasterDetails['merchant_name']);}}</td>
                        </tr>
                        
                        <tr>
                            <td><b>PHONE:</b></td>
                            <td style="text-align:left">{{$invoiceMasterDetails['merchant_phone'];}}</td>
                        </tr>

                        
                        <tr>
                            <td><b>EMAIL:</b></td>
                            <td colspan="3">{{$invoiceMasterDetails['merchant_email'];}}</td>
                        </tr>
                       
                        <tr>
                            <td><b>ADDRESS:</b></td>
                            <td colspan="3">{{strtoupper($invoiceMasterDetails['merchant_address1']);}}</td>
                        </tr>

                        <tr>
                            <td><b>LOCATION:</b></td>
                            <td colspan="3">
                                @if($invoiceMasterDetails['city_name'] != '') 
                                {{strtoupper($invoiceMasterDetails['city_name']);}}
                                @endif
                                Pakistan
                            </td>
                        </tr>
                    </table>
                </td>
                <td width='50%' valign="top" style="border-right: 1px solid; border-bottom: 1px solid;">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td><b>INVOICE NO.:</b></td>
                            <td style="text-align:left">{{$invoiceMasterDetails['invoice_number']}}</td>
                        </tr>
                        <tr>
                            <td><b>INVOICE DATE:</b></td>
                            <td colspan="3">{{date('d/m/Y', strtotime($invoiceMasterDetails['created_at']))}}</td>
                        </tr>
                        <tr>
                            <td><b>AMOUNT:</b></td>
                            <td colspan="3">PKR {{ number_format($invoiceMasterDetails['net_amount'], 2); }}</td>
                        </tr>
                        <tr>
                            <td colspan="5"><b>FROM:</b>&nbsp;{{ date('d/m/Y',$min_date) }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>TO:</b>&nbsp;{{  date('d/m/Y',$max_date) }}&nbsp;</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <br />
        @if ($report_type == 'detail')
            <table width="100%" border="1" bordercolor="#CDDDDD" cellspacing="0" cellpadding="5" style="border-collapse:collapse; font-family:Arial, Helvetica, sans-serif; border-collapse:collapse;">
                <tr bgcolor="#E7EFEF">
                    <td  align="left" valign="top" bgcolor="#E7EFEF"><strong>Sr#</strong></td>
                    <td  align="left" valign="top" bgcolor="#E7EFEF"><strong>CN#</strong></td>
                    <td  align="left" valign="top" bgcolor="#E7EFEF"><strong>Order Id</strong></td>
                    <td  align="left" valign="top" bgcolor="#E7EFEF"><strong>Booking Date</strong></td>
                    <td  align="left" valign="top" bgcolor="#E7EFEF"><strong>Destination</strong></td>
                    <td  align="left" valign="top" bgcolor="#E7EFEF"><strong>Shipment Type</strong></td>
                    <td  align="left" valign="top" bgcolor="#E7EFEF"><strong>Zone</strong></td>
                    <td  align="left" valign="top" bgcolor="#E7EFEF"><strong>Wieght</strong></td>
                    <td  align="left" valign="top" bgcolor="#E7EFEF"><strong>Charges (PKR)</strong></td>
                </tr>
                @php $vendor_pickup_charges = 0;@endphp
                @if (count($bookedPackets) > 0)
                    @php $sr = 1;@endphp
                    @foreach ($bookedPackets as $booked_packetObj)
                        @php 
                            $vendor_pickup_charges = $vendor_pickup_charges + $booked_packetObj->vendor_pickup_charges; 
                        @endphp
                        <tr>
                            <td align="left" valign="top">
                                {{$sr}}&nbsp;
                                @if ($booked_packetObj->booked_packet_status == 10 || $booked_packetObj->booked_packet_status == 12)
                                    Delivered
                                @elseif ($booked_packetObj->booked_packet_status == 7)
                                    Return
                                @endif
                            </td>
                            <td align="left" valign="top">{{$booked_packetObj->booked_packet_cn;}}</td>
                            <td align="left" valign="top">{{$booked_packetObj->booked_packet_order_id;}}</td>
                            <td align="left" valign="top">{{date('j M, Y', strtotime($booked_packetObj->booked_packet_date)); }}</td>
                            <td align="left" valign="top">{{$booked_packetObj->city_name;}}</td>
                            <td align="left" valign="top">{{$booked_packetObj->shipment_type_name;}}</td>
                            <td align="left" valign="top">
                            @if($booked_packetObj->zone_name== 'D')
                            Other Province
                            @elseif($booked_packetObj->zone_name== 'S')
                            Same Province
                            @else
                            Same City
                            @endif
                            </td>
                            <td align="left" valign="top">
                            @php
                                $weightArray = [$booked_packetObj->booked_packet_weight,$booked_packetObj->arival_dispatch_weight];
                            @endphp
                            {{number_format((float) max($weightArray) / 1000, 2); }} 
                            Kg.</td>
                            <td align="left" valign="top">
                            {{$booked_packetObj->packet_charges}}
                            </td>
                           
                        </tr>
                        @php $sr++; @endphp
                    @endforeach
                    <tr>
                        <td align="left" colspan="6"><strong>Grand Total</strong></td>
                        <td align="left">&nbsp;</td>
                        <td align="left">&nbsp;</td>
                        <td align="left">{{number_format($invoiceMasterDetails['gross_total'], 2);}}</td>
                    </tr>
                @else
                    <tr>
                        <td align="center" valign="top" colspan="7">No Record Found.</td>
                    </tr>
                @endif
            </table>
            <br />
        @endif
        @php 
            $gross_invoice = '0.00';
        @endphp

        <table width="100%" border="0" cellspacing="0" cellpadding="5" style="font-family:Arial, Helvetica, sans-serif;">
            <tr>
                <td width="35%" colspan="2" align="left"><h3><u><i>FREIGHT CHARGES</i></u></h3></td>
                <td width="30%">&nbsp;</td>
            </tr>
            <tr>
                <td align="right"><b>Net Freight Charges</b></td>
                <td align="right">{{number_format($invoiceMasterDetails['gross_total'], 2);}}</td>
                <td align="center">&nbsp;</td>
            </tr>
            <tr>
                <td align="right"><b>Fuel Surcharge </b></td>
                <td align="right">
                    +   0.00
                </td>
                <td colspan="3">&nbsp;</td>
            </tr>
            <tr>
                <td style="border-bottom: 1px solid silver;" align="right"><b>Fuel Factor</b></td>
                <td style="border-bottom: 1px solid silver;" align="right">
                    + 0.00
                </td>
                <td colspan="3">&nbsp;</td>
            </tr>
            <tr>
                <td align="right"><b>Net Amount</b></td>
                <td align="right">
                    0.00
                </td>
                <td align="center">&nbsp;</td>
                <td width="35%" colspan="2" align="left"><h3><u><i>PAYABLE</i></u></h3></td>
            </tr>
            <tr>
                <td align="right"><b>G.S.T.</b></td>
                <td align="right">
                    + 0.00
                </td>
                <td align="center">&nbsp;</td>
                <td align="right"><b>Amount Payable</b></td>
                <td align="right">{{number_format($invoiceMasterDetails['invoice_total'], 2);}}</td>
            </tr>

            <tr>
                <td style="border-bottom: 1px solid silver;" align="right"><b>Gross Freight Charges</b></td>
                <td style="border-bottom: 1px solid silver;" align="right">
                    {{ number_format($gross_invoice, 2); }}
                </td>
                <td align="center">&nbsp;</td>
            </tr>
        </table>
        <table width="100%" border="0" cellspacing="0" cellpadding="5" style="font-family:Arial, Helvetica, sans-serif;">
            <tr>
                <td colspan="5">
                    <hr style="width: 100%; color: #E7EFEF;"/>
                </td>
            </tr>
        </table>
    </body>
</html>