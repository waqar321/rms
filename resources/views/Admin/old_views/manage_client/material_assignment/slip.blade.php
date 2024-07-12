<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <title>Print Assigned Materials Slip</title>
    <style>
        body {
            margin-top: 0px;
        }

        .main_wrapper {
            border: 1px solid #000;
            display: table;
            margin: 0 auto;
            padding: 10px 15px;
        }

        .clear {
            clear: both;
        }

        .logo_wrapper {
            width: 15%;
            float: left;
        }

        .logo_wrapper img {
            width: 100%;
        }

        .heading_wrapper {
            width: 80%;
            float: right;
        }

        .heading_wrapper h3 {
            line-height: 20px;
            margin-left: 11%;
            padding-left: 18px;
        }

        .main_wrapper .document_for {
            text-align: left;
            margin-left: 30%;
        }

        .main_wrapper table {
            width: 100%;
            border-collapse: collapse;
        }

        .client_info_wrapper p {
            margin: 5px 0;
        }

        .receiver_wrapper {
            margin-top: 65px;
        }

        .receiver_name {
            float: left;
            border-top: 1px solid #000;
            width: 250px;
            text-align: center;
            margin-bottom: 14px;
        }

        .receiver_sign {
            float: right;
            border-top: 1px solid #000;
            width: 200px;
            text-align: center;
            margin-bottom: 14px;
        }

        .material {
            padding-left: 15px;
        }

        .range, .qty {
            text-align: center;
        }

        .main_wrapper.client_copy .document_for {
            text-align: left;
            margin-left: 28%;
        }
    </style>
</head>
<body>
<div class="main_wrapper lcs_copy" style="width: 100%">

    <div class="logo_wrapper">
        <img src="<?php echo url_secure('build/images/logo/logo-removebg-preview.png'); ?>">
    </div>

    <div class="heading_wrapper">
        <div class="document_for">LCS Copy</div>
        <h3>COD PACKAGING MATERIAL</h3>
    </div>

    <div class="clear"></div>

    <div class="client_info_wrapper">
        <p><b>Date:</b></p>
        <p><b>Client account No.: </b> {{$client_details->merchant_account_no}} </p>
        <p><b>Client Name:</b> {{$client_details->merchant_name}}</p>
        <p><b>AWB or CN:</b> {{$cn_number[0]}}</p>
    </div>

    <table border="1">
        <thead>
        <tr>
            <th rowspan="2">Packaging Material</th>
            <th>Serial No.</th>
            <th rowspan="2">Quantity</th>
        </tr>
        <tr>
            <th>To - From</th>
        </tr>
        </thead>
        <tbody>
        @foreach($materialData as $key => $material)
            <tr>
                <td class="material">{{ $material->material_name }}</td>
                <td class="range">
                    <?php
                    $find_key = array_search($material->id, $materialId);
                    ?>
                    @if(in_array($material->id, $materialId))
                        {{ $flyer_range_from[$find_key] }} --- {{ $flyer_range_to[$find_key] }}
                    @else
                        ---
                    @endif
                </td>
                <td class="qty">
                    @if(in_array($material->id, $materialId))
                        {{ $material_quantity[$find_key] }}
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="receiver_wrapper" style="margin-bottom: 15px;">
        <div class="receiver_name">Receiver Name</div>
        <div class="receiver_sign">Receiver Sign</div>
    </div>

</div>
<br/>
<br/>
<br/>
<div class="main_wrapper client_copy" style="width: 100%">

    <div class="logo_wrapper">
        <img src="<?php echo url_secure('build/images/logo/logo-removebg-preview.png'); ?>">
    </div>

    <div class="heading_wrapper">
        <div class="document_for">Client Copy</div>
        <h3>COD PACKAGING MATERIAL</h3>
    </div>

    <div class="clear"></div>

    <div class="client_info_wrapper">
        <p><b>Date:</b></p>
        <p><b>Client account No.: </b> {{$client_details->merchant_account_no}} </p>
        <p><b>Client Name:</b> {{$client_details->merchant_name}}</p>
        <p><b>AWB or CN:</b> {{$cn_number[0]}}</p>
    </div>

    <table border="1">
        <thead>
        <tr>
            <th rowspan="2">Packaging Material</th>
            <th>Serial No.</th>
            <th rowspan="2">Quantity</th>
        </tr>
        <tr>
            <th>To - From</th>
        </tr>
        </thead>
        <tbody>
        @foreach($materialData as $key => $material)
            <tr>
                <td class="material">{{ $material->material_name }}</td>
                <td class="range">
                    <?php
                    $find_key = array_search($material->id, $materialId);
                    ?>
                    @if(in_array($material->id, $materialId))
                        {{ $flyer_range_from[$find_key] }} --- {{ $flyer_range_to[$find_key] }}
                    @else
                       ---
                    @endif
                </td>
                <td class="qty">
                    @if(in_array($material->id, $materialId))
                        {{ $material_quantity[$find_key] }}
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="receiver_wrapper" style="margin-bottom: 15px;">
        <div class="receiver_name">Receiver Name</div>
        <div class="receiver_sign">Receiver Sign</div>
    </div>

</div>
</body>
</html>

