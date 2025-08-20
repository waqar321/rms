<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Receipt</title>
    <style>
        @media print
        {
            @page {
                size: 58mm auto; /* width fixed, height auto */
                margin: 0; /* no margin */
            }
            body {
                margin: 0;
                padding: 0;
            }
        }

        body {
            width: 58mm;
            font-family: 'Courier New', monospace;
            font-size: 12px;
            margin: 0 auto;
            padding: 0;
        }
        .receipt {
            padding: 10px;
        }
        .center {
            text-align: center;
        }
        .bold {
            font-weight: bold;
        }
        /* .item-row {
            display: flex;
            justify-content: space-between;
            border-bottom: 1px dashed #000;
            padding: 4px 0;
        } */
         .item-row {
            display: flex;
            align-items: center;
            border-bottom: 1px dashed #000;
            padding: 4px 0;
            font-size: 11px;
        }
        .item-row > div:nth-child(2) {
            white-space: normal;     /* allow wrapping */
            overflow: visible;
            text-overflow: unset;    /* remove ellipsis */
            white-space: break-word;  /* break long words if needed */
        }
        .total {
            margin-top: 10px;
            margin-left: 10px
            font-size: 14px;
            font-weight: bold;
        }
        .thankyou {
            margin-top: 10px;
            text-align: center;
        }
        img.profile_img {
            width: 100%;
            height: auto; /* auto instead of 100% for better aspect ratio */
        }

    </style>
</head>
<body onload="window.print()">
    <div class="receipt">
        <div class="center bold">
            <!-- ABASEEN RESTAURANT -->
            <img src="<?php echo url_secure('build/images/abaseen_logo.png'); ?>" alt="..." style="width: 100%; height: 100%" class="profile_img" >

        </div>
        <div class="center">
            <p>
                Address: Plot #138, Sector 9A,<br>
                Opposite to Abid Sweet, Baldia Town, Karachi<br>
                <!-- Email: waqarmughal707@gmail.com<br> -->
                Phone: 0300-2400523
            </p>
        </div>

        <div class="bold" style="border-bottom: 1px dashed #000; margin: 10px 0;">

            {{-- &nbsp;&nbsp;-
            &nbsp;&nbsp;Item
            &nbsp;&nbsp;&nbsp;Qty
            &nbsp;&nbsp;&nbsp;Subtotal --}}

            <table>
                <th style="width: 20%; text-align: right;">
                    Image
                </th>
                <th style="width: 40%; text-align: left;">
                     ItemName
                </th>
                <th style="width: 18%; text-align: left;">
                     Price
                </th>
                <th style="width: 6%; text-align: center;">
                     Qty
                </th>
                <th style="width: 18%; text-align: right;">
                     Total
                </th>
            </table>
            {{-- <div style="width: 20%;">
                -
            </div>
            <div style="width: 40%; padding-left: 5px; line-height: 12px;">
                Item
            </div>
            <div style="width: 15%; text-align:center;">
                Qty
            </div>
            <div style="width: 15%; text-align:right;">
                Subtotal
            </div> --}}
        </div>

        @foreach($cart as $item)

            <div class="item-row">
                <div style="width: 20%;">
                    <img src="{{ asset('storage/' . $item['image_path']) }}"
                                                                            alt="{{ $item['name'] }}"
                                                                            class="img-thumbnail"
                                                                            style="height: 35px; width: 35px; object-fit: cover;  border-radius: 3px;">
                </div>
                <div style="width: 40%; padding-left: 5px; line-height: 12px;">{{ $item['name'] }}</div>
                <div style="width: 18%; text-align:left;">{{ number_format($item['subtotal'] / $item['qty'],0) }}</div>
                <div style="width: 6%; text-align:center;">{{ $item['qty'] }}</div>
                <div style="width: 18%; text-align:right;">{{ number_format($item['subtotal'], 0) }}</div>
                {{-- <div style="width: 10%; text-align:right;">{{ number_format($item['subtotal'], 2) }}</div> --}}
            </div>

        @endforeach

        <div class="total item-row">
            <div>Total Bill: </div>
            <div style="text-align:right;">{{ number_format(collect($cart)->sum('subtotal'), 2) }}</div>
        </div>

        <div class="thankyou">
            Thank you to taste our decilous items!
        </div>
    </div>
</body>
</html>
