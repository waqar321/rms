<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en" xml:lang="en">
    <head>
        <title>Manage Dispatch Report</title>
        <style type="text/css">
            @media print {
                @page {
                    margin: 0;
                }
                body {
                    margin: 0.8cm;
                    font-size: 11px;
                }
            }
            body{
                font-size: 11px;
            }

        </style>

        <style>
            .page-break {
                page-break-after: always;
            }
        </style>
    </head>
    <body style="">
        @for($i = 0; $i< count($copyType);$i++)
            <table width="100%" border="0" cellspacing="0" cellpadding="5" style="font-family:Arial, Helvetica, sans-serif; border-bottom:1px solid #999999; border-top:1px solid #999999;">
                <tr>
                    <td colspan="2" align="center"><h3><?php echo $copyType[$i]; ?></h3></td>
                </tr>
                <tr>
                    <?php
                    $emailFound = true; // Set this to true when email is found, or false when email is not found
                    if (app()->environment('local')) {
                        $imageSrc = url_secure('build/images/logo/logo-removebg-preview.png');
                    } else {
                        $imageSrc = public_path('build/images/logo/logo-removebg-preview.png');
                    }
                    ?>


                    <td width="50%">
                        <img src="<?php echo $imageSrc; ?>" height="80"/>
                    </td>
                    <td>
                        <table width="100%" cellspacing="0" cellpadding="5">
                            <tr>
                                <td colspan="2"><strong>Booked Packets Summary Report</strong> </td>
                            </tr>
                            <tr>
                                <td>Pickup Date</td>
                                <td><?php echo $data[0]['courier_pickup_date']; ?></td>
                            </tr>
                            <tr>
                                <td>Printed On</td>
                                <td><?php echo date("d/m/Y"); ?></td>
                            </tr>
                            <tr>
                                <td>Challan# </td>
                                <td><?php echo $data[0]['pickup_batch_id']; ?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <table width="100%" border="0" cellspacing="0" cellpadding="5" style="font-family:Arial, Helvetica, sans-serif;">
                <tr>
                    <td>Client</td>
                    <td>
                        <p>
                            <strong>Acc #</strong> {{$data[0]['merchant_account_no']}}<br />
                            <strong>Company Name:</strong>&nbsp;{{$data[0]['merchant_name']}}
                        </p>
                    </td>
                </tr>
                <tr>
                    <td>Handed Over To:</td>
                    <td>
                        <p><strong>Code:</strong>  {{$data[0]['courier_name']}} <br />
                            <strong>Name:</strong> {{$data[0]['courier_code']}}&nbsp;
                        </p>
                    </td>
                </tr>
            </table>
            <table width="100%" border="1" cellspacing="0" cellpadding="5" style="font-family:Arial, Helvetica, sans-serif;">
                <tr>
                    <td><strong>Sr.</strong></td>
                    <td><strong>CN #</strong></td>
                    <td><strong>Destination</strong></td>
                    <td><strong>Shipper Name</strong></td>
                    <td><strong>No. of pieces</strong></td>
                    <td><strong>Consignee Name</strong></td>
                    <td><strong>Order Id</strong></td>
                    <td><strong>Weight</strong></td>
                    <td><strong>COD Amount</strong></td>
                    <!--<td><strong>Remarks</strong></td>-->
                </tr>
                <?php
                $counter = 1;
                $numPieces = 0;
                $numPackets = 0;
                $total_cod_amount = 0;

                foreach ($data as $row) {

                    $numPieces = $numPieces + $row['booked_packet_no_piece'];
                    $numPackets = $numPackets + 1;
                    $total_cod_amount += $row['booked_packet_collect_amount'];
                    ?>
                    <tr>
                        <td><?php echo $counter; ?></td>
                        <td><?php echo $row['track_number']; ?></td>
                        <td><?php echo $row['destination_city']; ?></td>
                        <td><?php echo $row['merchant_name']; ?></td>
                        <td><?php echo $row['booked_packet_no_piece']; ?></td>
                        <td><?php echo $row['consignment_name']; ?></td>
                        <td><?php echo $row['booked_packet_order_id']; ?></td>
                        <td><?php echo $row['booked_packet_weight']; ?></td>
                        <td><?php  echo ($row['booked_packet_collect_amount'] >= 30000) ? "<b>{$row['booked_packet_collect_amount']}</b>" : $row['booked_packet_collect_amount']; ?></td>
                        <!--<td><?//= $row['booked_packet_comments']; ?></td>-->
                    </tr>
                    <?php
                    $counter++;
                }
                ?>
                <tr>
                    <td colspan="9"><strong>Total No. Of Pieces:</strong> <?php echo $numPieces; ?></td>
                </tr>
                <tr>
                    <td colspan="9"><strong>Total No. Of Packets:</strong> <?php echo $numPackets; ?></td>
                </tr>
                <tr>
                    <td colspan="9"><strong>Total COD Amount:</strong> <?php echo $total_cod_amount; ?></td>
                </tr>
            </table>
            <table width="100%" border="0" cellspacing="0" cellpadding="5" style="font-family:Arial, Helvetica, sans-serif;">
                <tr>
                    <td height="100" colspan="2">&nbsp;</td>
                </tr>
                <tr>
                    <td width="50">Client Signature: ____________________________</td>
                    <td width="50">Booking Staff Signature: ____________________________</td>
                </tr>
                <tr>
                    <td height="30" colspan="2">&nbsp;</td>
                </tr>
            </table>
            @if(count($copyType) -1 != $i)
            <div class="page-break"></div>
            @endif
        @endfor
    </body>
</html>
