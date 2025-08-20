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
        .item-row {
            display: flex;
            justify-content: space-between;
            border-bottom: 1px dashed #000;
            padding: 4px 0;
        }
        .total {
            margin-top: 10px;
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

        <div class="bold" style="border-bottom: 1px dashed #000; margin: 10px 0;">Item&nbsp;&nbsp;&nbsp;Qty&nbsp;&nbsp;&nbsp;Subtotal</div>

        @foreach($row_receipt->receiptItems as $receiptItem)

            <div class="item-row">
                {{-- <div style="width: 20%;">
                    <img src="{{ asset('storage/' . $receiptItem->item['image_path']) }}"
                                                                            alt="$receiptItem->item['name']"
                                                                            class="img-thumbnail"
                                                                            style="height: 35px; object-fit: cover;">
                </div> --}}
                <div style="width: 40%;">{{ $receiptItem->item['name'] }}</div>
                <div style="width: 15%; text-align:center;">{{ $receiptItem->item_qty }}</div>
                <div style="width: 15%; text-align:right;">{{ number_format($receiptItem->item_price, 2) }}</div>
            </div>
        @endforeach

        <div class="total item-row">
            <div>Total</div>
            <div style="text-align:right;">{{ number_format($row_receipt->receiptItems->sum('item_sub_total')) }}</div>
        </div>

        <div class="thankyou">
            Thank you to taste our decilous items!
        </div>
    </div>
</body>
</html>
