<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <title>Print Air Ways Bills</title>

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
        table th{
            font-size: 14px;
        }
        table td{
            font-size: 14px;
        }
        .address-cell {
            word-wrap: break-word;
            max-width: 300px; /* Adjust the max width as needed */
        }
        .center-span {
            text-align: center;
            display: block; /* This ensures the span takes the full width */
            margin: 0 auto; /* This centers the span horizontally */
        }
    </style>
</head>
<body>
<?php
$count_page= 0;
?>
@for ($j = 0; $j < count($data); $j++)
    <?php $booked_packetObj = $data[$j];
    $booked_packetObj['shipper_copy_count'] = 1;
    $booked_packetObj['account_copy_count'] = 1;
    $booked_packetObj['label_count'] = 1;
    $letter_type = 'label';
    $label_top = "padding-top: 0px; padding-bottom:100px;";
    $finish = 0;
    ?>

    @for ($loop = 1; $loop <= $booked_packetObj['booked_packet_no_piece']; $loop++)
        <?php
        if($loop == $booked_packetObj['booked_packet_no_piece']){
            $finish = 1;
        }else{
            $finish = 0;
        }
        $count_page++;
        ?>

        @if ($letter_type == 'shipper' && $booked_packetObj['shipper_copy_count'] > 1)
            <div style="z-index: -1; position: absolute; left: 0; right: 0; margin: 0 auto; color: #F2F2F2; font-size: 80px; line-height: 250px;">
                DUPLICATE - {{ $booked_packetObj['shipper_copy_count'] - 1 }}
            </div>
        @elseif ($letter_type == 'account' && $booked_packetObj['account_copy_count'] > 1)
            <div style="z-index: -1; position: absolute; left: 0; right: 0; margin: 0 auto; color: #F2F2F2; font-size: 80px; line-height: 250px;">
                DUPLICATE - {{ $booked_packetObj['account_copy_count'] - 1 }}
            </div>
        @elseif ($letter_type == 'label' && $booked_packetObj['label_count'] > 1)
            <div style="z-index: -1; position: absolute; left: 0; right: 0; margin: 0 auto; color: #F2F2F2; font-size: 80px; line-height: 250px;">
                DUPLICATE - {{ $booked_packetObj['label_count'] - 1 }}
            </div>
        @endif

        <div style="position: relative; {{ $label_top }}">
            <div style="z-index: 1; position: relative;margin-top: 0px">
                <table width="100%" border="0" cellspacing="0" cellpadding="2" style="font-family:Tahoma, Geneva, sans-serif; font-size:16px;">
                    <tr>
                        <?php
                        $emailFound = true; // Set this to true when email is found, or false when email is not found
                        if (app()->environment('local')) {
                            $imageSrc = url_secure('build/images/small_logo.png');
                        } else {
                            $imageSrc = public_path('build/images/small_logo.png');
                        }
                        ?>
                        <td align="left" valign="middle" style="padding: 2px 3px;">
                            <img src="{{ $imageSrc}}" height="80"/>
                        </td>
                        <th valign="middle" >&nbsp;&nbsp;</th>
                        <th valign="middle" align="center" >
                            @if ($booked_packetObj['shipment_type_id'] == 10)
                                <h1>{{ $booked_packetObj['shipment_type_name'] }}</h1>
                            @elseif ($booked_packetObj['shipment_type_id'] == 3)
                                <h1>{{ $booked_packetObj['shipment_type_name'] }}</h1>
                            @elseif ($booked_packetObj['shipment_type_id'] == 2)
                                <h1>ECONOMY</h1>
                            @endif
                            (COD PARCEL)
                        </th>
                        <th valign="middle" align="left" >&nbsp;&nbsp;</th>
                        <th valign="middle" align="right">Handle with care</th>
                    </tr>
                </table>

                <table width="100%" border="1" cellspacing="0" cellpadding="2" style=";border-collapse: collapse; font-family:Tahoma, Geneva, sans-serif; font-size:13px;margin-left: 0px;width: 100%;  border: 2px solid #000000;">
                    <thead>
                    <tr>
                        <th align="center" style="padding: 10px 0px; font-size: 12px; border: 2px solid #000000;">Consignee / Shipper Information</th>
                        <th align="center" style="padding: 10px 0px; font-size: 12px;width: 200px; border: 2px solid #000000;">Consignment Information</th>
                        <th align="center" style="padding: 10px 0px; font-size: 12px;width: 200px; border: 2px solid #000000;">Shipment Information</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td align="center" valign="top" width="39%" style=" border: 2px solid #000000;">
                            <table valign="top" border="0" width="100%" cellspacing="0" cellpadding="2" style="margin-top: 3px; font-size: 13px;">
                                <tr>
                                    <th align="center" colspan="2">Consignee Information
                                        <hr style="margin-top: 7px;margin-bottom: 0px; border-top: 0px solid #000;"/>
                                        <hr style="margin-top: 0px;margin-bottom: 10px; border-top: 0px solid #000;"/>
                                    </th>
                                </tr>
                                <tr>
                                    <th align="left" style="width:75px;">Name :</th>
                                    <td align="left">
                                        {{ $booked_packetObj['consignment_name'] }}
                                    </td>
                                </tr>
                                <tr>
                                    <th align="left" style="width:75px; vertical-align: top;">Address :</th>
                                    <td align="left" class="address-cell">
                                        <?php
                                        $address = ($booked_packetObj['consignment_address'] != '' ? str_replace(["\r", "\n", "\t", ",", "  "], ["", "", "", ", ", " "], trim($booked_packetObj['consignment_address'])) : 'N/A');
                                        $maxLength = 40; // Maximum characters per line
                                        echo $address;
                                        // Iterate over the address and insert line breaks
                                        //                                        for ($i = 0; $i < strlen($address); $i += $maxLength) {
                                        //                                            echo substr($address, $i, $maxLength) . "<br>";
                                        //                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th align="left" style="width:75px;">Contact #:</th>
                                    <td align="left">
                                        {{ $booked_packetObj['consignment_phone'] }}
                                        @if ($booked_packetObj['consignment_phone_two'])
                                            , {{ $booked_packetObj['consignment_phone_two'] }}
                                        @endif
                                        @if ($booked_packetObj['consignment_phone_three'])
                                            , {{ $booked_packetObj['consignment_phone_three'] }}
                                        @endif
                                    </td>
                                </tr>
                            </table>
                            <table valign="bottom" border="0" width="100%" cellspacing="0" cellpadding="2" style="margin-top: 3px; font-size: 13px;">
                                <tr>
                                    <th align="center" colspan="2">
                                        <hr style="margin-top: 7px;margin-bottom: 0px; border-top: 0px solid #000;" />
                                        <hr style="margin-top: 0px;margin-bottom: 7px; border-top: 0px solid #000;" />
                                        Shipper Information
                                        <hr style="margin-top: 7px;margin-bottom: 0px; border-top: 0px solid #000;" />
                                        <hr style="margin-top: 0px;margin-bottom: 7px; border-top: 0px solid #000;" />
                                    </th>
                                </tr>
                                <tr>
                                    <th align="left" style="width:75px;">AC / Name :</th>
                                    <td align="left">{{ !empty($booked_packetObj['shipper_account_no']) ? $booked_packetObj['shipper_account_no'] : $booked_packetObj['merchant_account_no'] }} / {{ strtoupper($booked_packetObj['shipper_name']) }}</td>
                                </tr>
                                <tr>
                                    <th align="left" style="width:75px;">Address :</th>
                                    <td align="left"  class="address-cell">{{ strtoupper($booked_packetObj['shipper_address1']) }}</td>
                                </tr>
                                <tr>
                                    <th align="left" style="width:75px;">Contact # :</th>
                                    <td align="left">{{ $booked_packetObj['shipper_phone'] }}</td>
                                </tr>
                                @if (!empty($booked_packetObj['return_address']))
                                    <tr>
                                        <th align="left" style="width:75px; vertical-align: top;">Return Address :</th>
                                        <td align="left" class="address-cell">
                                            <?php
                                            $return_address = ($booked_packetObj['return_address'] != '' ? str_replace(["\r", "\n", "\t", ",", "  "], ["", "", "", ", ", " "], trim($booked_packetObj['return_address'])) : 'N/A');
                                            $maxLength = 40; // Maximum characters per line
                                            echo $return_address;
                                            // Iterate over the address and insert line breaks
                                            //                                            for ($i = 0; $i < strlen($return_address); $i += $maxLength) {
                                            //                                                echo substr($return_address, $i, $maxLength) . "<br>";
                                            //                                            }
                                            //                                            ?>
                                        </td>
                                    </tr>
                                @endif

                            </table>
                        </td>
                        <td align="center" valign="top" width="30%" style=" border: 2px solid #000000;">
                            <table border="0" width="100%" cellspacing="0" cellpadding="2" >
                                <tr>
                                    <td align="center" colspan="2">
                                        <table>
                                            <tr>
                                                <td>
                                                    <div style="text-align: center">
                                                        <?php echo generate_qr_code($booked_packetObj['track_number'] . ',' . $booked_packetObj['destination_city_id'] . ',' . $booked_packetObj['booked_packet_collect_amount'],'style="width:220px;height:200px"') ?>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <?php echo generate_barcode_image(urlencode($booked_packetObj['track_number']),'style="width:220px;height:50px"') ?> <br/>
                                                    <span class="center-span" style="letter-spacing: 8px; font-size: 18px;">{{ $booked_packetObj['track_number'] }}</span>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr><td colspan="2"><hr style="margin-top: 3px;margin-bottom: 3px; border-top: 0px solid #000;"/></td></tr>
                                <tr>
                                    <td align="left" style="font-size: 13px; font-weight: bold;">Tracking No:</td>
                                    <td align="left" style="font-size: 13px; font-weight: bold;">&nbsp;{{ $booked_packetObj['track_number_short'] }}</td>
                                </tr>
                                <tr><td colspan="2"><hr style="margin-top: 3px;margin-bottom: 5px; border-top: 0px solid #000;"/></td></tr>
                                <tr>
                                    <td align="left" style="font-size: 13px; font-weight: bold;">Destination :</td>
                                    <td align="left" style="font-size: 13px; font-weight: bold;">&nbsp;{{ strtoupper($booked_packetObj['destination_city']) }}</td>
                                </tr>
                            </table>
                        </td>
                        <td align="center" valign="top" width="31%">
                            <table border="0" width="100%" cellspacing="0" cellpadding="2" style="margin-top: 5px;">
                                <tr>
                                    <th align="left" style="margin-bottom: 5px;margin-top: 5px;">Pieces :</th>
                                    <td align="left" style="margin-bottom: 5px;margin-top: 5px;">&nbsp;<strong>{{ $booked_packetObj['booked_packet_no_piece'] . " PCS  (" . $loop . "/" . $booked_packetObj['booked_packet_no_piece'] . ")" }}</strong></td>
                                </tr>
                                <tr><td colspan="2"><hr color="#fff" style="margin-top: 2px;margin-bottom: 2px; border-top: 0px solid #000;"></td></tr>
                                <tr>
                                    <th align="left" style="margin-bottom: 5px;margin-top: 5px;">Weight :</th>
                                    <td align="left" style="margin-bottom: 5px;margin-top: 5px;">&nbsp;{{ number_format($booked_packetObj['booked_packet_weight'], 2) }}&nbsp;(Grams)</td>
                                </tr>
                                <tr><td colspan="2"><hr color="#fff" style="margin-top: 2px;margin-bottom: 2px; border-top: 0px solid #000;"></td></tr>
                                <tr>
                                    <th align="left" style="margin-bottom: 5px;margin-top: 5px;">COD Amount :</th>
                                    <td align="left" style="margin-bottom: 5px;margin-top: 5px;">
                                        <?php echo generate_barcode_image($booked_packetObj['booked_packet_collect_amount'],'style="width:100px;height:25px"')
                                        ?> <br/>
                                        <span style="letter-spacing: 2px; font-size: 12px;">PKR&nbsp;{{ number_format($booked_packetObj['booked_packet_collect_amount'], 2) }}</span>
                                    </td>
                                </tr>
                                <tr><td colspan="2"><hr color="#fff" style="margin-top: 2px;margin-bottom: 2px; border-top: 0px solid #000;"></td></tr>
                                <tr>
                                    <th align="left" style="margin-bottom: 5px;margin-top: 5px;">Order ID :</th>
                                    <td align="left" style="margin-bottom: 5px;margin-top: 5px;"><br/>&nbsp;{{ $booked_packetObj['booked_packet_order_id'] }}</td>
                                </tr>
                                <tr><td colspan="2"><hr color="#fff" style="margin-top: 2px;margin-bottom: 2px; border-top: 0px solid #000;"></td></tr>
                                <tr>
                                    <th align="left" style="margin-bottom: 5px;margin-top: 5px;">Origin :</th>
                                    <td align="left" style="margin-bottom: 5px;margin-top: 5px;">&nbsp;{{ strtoupper($booked_packetObj['origin_city']) }}</td>
                                </tr>
                                <tr><td colspan="2"><hr color="#fff" style="margin-top: 2px;margin-bottom: 2px; border-top: 0px solid #000;"></td></tr>
                                <tr>
                                    <th align="left">Booking Date :</th>
                                    <td align="left">&nbsp;{{ $booked_packetObj['booked_packet_date'] }}</td>
                                </tr>
                                <tr>
                                    <th align="left" colspan="2">
                                        <hr style="margin-top: 7px;margin-bottom: 7px; border-top: 0px solid #000;"/>
                                        Remarks :-
                                        <hr style="margin-top: 7px;margin-bottom: 7px; border-top: 0px solid #000;"/>
                                    </th>
                                </tr>
                                <tr>
                                    <td colspan="2" align="left" class="address-cell">&nbsp;
                                        <?php
                                        $booked_packet_comments = ($booked_packetObj['booked_packet_comments'] != '' ? str_replace(["\r", "\n", "\t", ",", "  "], ["", "", "", ", ", " "], trim($booked_packetObj['booked_packet_comments'])) : 'N/A');
                                        $maxLength = 30; // Maximum characters per line
                                        echo $booked_packet_comments;
                                        // Iterate over the address and insert line breaks
                                        //                                        for ($i = 0; $i < strlen($booked_packet_comments); $i += $maxLength) {
                                        //                                            echo substr($booked_packet_comments, $i, $maxLength) . "<br>";
                                        //                                        }
                                        ?>
                                    </td>
                                </tr>
                            </table>
                        </td>

                    </tr>
                    </tbody>
                </table>

                <table width="100%" border="0" style="font-size: 11px; border-collapse: collapse;">
                    <tr>
                        <td align="left" width="39%">Website: http://www.leopardscourier.com</td>
                        <td align="center" width="30%">UAN: 111 300 786</td>
                        <td align="right" width="31%">User : {{ (request()->user()->id ? request()->user()->id : $booked_packetObj['admin_user_id']) }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <?php
        if (!isset($print_single_label)) {
            if ($count_page == 2) {
                $count_page = 0;
                if($j != count($data) - 1 || $finish == 0){
                    echo '<div class="page-break"></div>';
                }
            }
        }else{
//            echo $j . " " .  count($data);
            if ($count_page == 1) {
                $count_page = 0;
                if($j != count($data) - 1 || $finish == 0){
                    echo '<div class="page-break"></div>';
                }
            }
        }
        ?>

    @endfor
@endfor
@if(count($copyType) > 0)
    <div class="page-break"></div>
@endif
@for($i = 0; $i< count($copyType);$i++)
    <table width="100%" border="0" cellspacing="0" cellpadding="5" style="font-family:Arial, Helvetica, sans-serif; border-bottom:1px solid #999999; border-top:1px solid #999999;">
        <tr>
            <td colspan="2" align="center"><h3><?php echo $copyType[$i]; ?></h3></td>
        </tr>
        <tr>
            <?php

            $emailFound = true; // Set this to true when email is found, or false when email is not found
            if (app()->environment('local')) {
                $imageSrc2 = url_secure('build/images/logo/logo-removebg-preview.png');
            } else {
                $imageSrc2 = public_path('build/images/logo/logo-removebg-preview.png');
            }

            ?>
            <td width="50%">
                <img src="<?php echo $imageSrc2 ?>" height="80"/>
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
