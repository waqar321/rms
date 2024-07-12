<?php
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=Dispatch-report-{$data[0]['pickup_batch_id']}.xls");
header('Access-Control-Allow-Origin: *');  // CORS header
header("Content-Description: File Transfer");
header("Pragma: no-cache");
header("Expires: 0");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="5" style="font-family:Arial, Helvetica, sans-serif; border-bottom:1px solid #999999; border-top:1px solid #999999;">
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2" align="center"><h3>Dispatch Report</h3></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
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
        <td width="80%" colspan="2">
            <img src="<?php echo $imageSrc; ?>" height="80"/>
        </td>
        <td>&nbsp;</td>
        <td>
            <table width="100%" cellspacing="0" cellpadding="5">
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td colspan="2"><strong>Booked Packets Summary Report</strong> </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>Pickup Date</td>
                    <td>{{ $data[0]['courier_pickup_date'] }}</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>Printed On</td>
                    <td>{{ date("d/m/Y") }}</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>Challan #</td>
                    <td>{{ $data[0]['pickup_batch_id'] }}</td>
                </tr>
            </table>
        </td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="5" style="font-family:Arial, Helvetica, sans-serif;">
    <tr>
        <td><strong>Client</strong></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>
            <p>
                <strong>Acc #</strong> {{ $data[0]['merchant_account_no'] }}<br />
                <strong>Company Name:</strong>&nbsp;{{ $data[0]['merchant_name'] }}
            </p>
        </td>
    </tr>
    <tr>
        <td><strong>Handed Over To:</strong></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>
            <p><strong>Code:</strong>{{ $data[0]['courier_code'] }}<br />
                <strong>Name</strong>&nbsp; {{ $data[0]['courier_name'] }}
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
        <td><strong>Remarks</strong></td>
    </tr>
    @php
    $counter = 1;
    $numPieces = 0;
    $numPackets = 0;
    $total_cod_amount = 0;
    @endphp

    @foreach ($data as $row)
    @php
    $numPieces += $row['booked_packet_no_piece'];
    $numPackets += 1;
    $total_cod_amount += $row['booked_packet_collect_amount'];
    @endphp

    <tr>
        <td>{{ $counter }}</td>
        <td>{{ $row['track_number'] }}</td>
        <td>{{ $row['destination_city'] }}</td>
        <td>{{ $row['merchant_name'] }}</td>
        <td>{{ $row['booked_packet_no_piece'] }}</td>
        <td>{{ $row['consignment_name'] }}</td>
        <td>{{ $row['booked_packet_order_id'] }}</td>
        <td>{{ (!empty($row['loadsheet_weight']) ? $row['loadsheet_weight'] : $row['booked_packet_weight']) }}</td>
        <td>{!! ($row['booked_packet_collect_amount'] >= 30000) ? "<b>{$row['booked_packet_collect_amount']}</b>" : $row['booked_packet_collect_amount'] !!}</td>
        <td>{{ $row['booked_packet_comments'] }}</td>
    </tr>
    @php
    $counter++;
    @endphp
    @endforeach

    <tr>
        <td colspan="2"><strong>Total No. Of Pieces:</strong></td>
        <td colspan="1">{{ $numPieces }}</td>
        <td colspan="7">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="2"><strong>Total No. Of Packets:</strong></td>
        <td colspan="1">{{ $numPackets }}</td>
        <td colspan="7">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="2"><strong>Total COD Amount:</strong></td>
        <td colspan="1">{{ $total_cod_amount }}</td>
        <td colspan="7">&nbsp;</td>
    </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="5" style="font-family:Arial, Helvetica, sans-serif;">
    <tr>
        <td height="100" colspan="12">&nbsp;</td>
    </tr>
    <tr>
        <td width="50" colspan="4">Client Signature: ____________________________</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td width="50" colspan="4">Booking Staff Signature: ____________________________</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td height="30" colspan="12">&nbsp;</td>
    </tr>
</table>
</body>
</html>
