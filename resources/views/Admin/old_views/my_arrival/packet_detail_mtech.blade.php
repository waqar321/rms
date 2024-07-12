<div style="overflow-x: hidden;" id="bgSetter">
    <h1 id="print_a" style="margin-bottom: 5px; font-size: 14px; font-weight: bold; width: 100%; text-align: center;">
        <button  style="float: right; margin-right: 40px;" onclick="printView($('#bgSetter').html())">
            <img src="{{ url_secure('build/images/print.png') }}" width="24" title="Print">
        </button>
    </h1>
    <div class="container">
        <div class="row">

            @if(request()->is_admin == 1)
                <div class="col-md-4 text-center">
                    <p class="mb-0" align="left"><strong>Tracking #:</strong>{{ $booked_packetObj['tracking_detail']['booked_packet_cn']}}</p>
                    <p class="mb-0" align="left"><strong>Shipper Name :</strong> <?php if ($booked_packetObj['tracking_detail']['shipper_name'] != '') { ?><?php echo $booked_packetObj['tracking_detail']['shipper_name']; ?><?php } else { ?>N/A<?php } ?></p>
                    <p class="mb-0" align="left"><strong>Shipper Address :</strong> <?php if ($booked_packetObj['tracking_detail']['shipper_address'] != '') { ?><?php echo $booked_packetObj['tracking_detail']['shipper_address']; ?><?php } else { ?>N/A<?php } ?></p>
                </div>
                <div class="col-md-4 text-center">
                    <div class="corier_van">
                        <p class="mb-0" align="center">({{ $booked_packetObj['tracking_detail']['booked_packet_status_message']}})</p>
                    </div>
                </div>
                <div class="col-md-4 text-center">
                    <p class="mb-0" align="left"><strong>Reference # / Order ID:</strong>{{ $booked_packetObj['tracking_detail']['booked_packet_order_id']}}</p>
                    <p class="mb-0" align="left"><strong>Consignee Name :</strong> <?php if ($booked_packetObj['tracking_detail']['consignment_name'] != '') { ?><?php echo $booked_packetObj['tracking_detail']['consignment_name']; ?><?php } else { ?>N/A<?php } ?></p>
                    <p class="mb-0" align="left"><strong>Consignee Address :</strong><br> <?php if ($booked_packetObj['tracking_detail']['consignment_address'] != '') { ?><?php echo $booked_packetObj['tracking_detail']['consignment_address']; ?><?php } else { ?>N/A<?php } ?></p>
                </div>
            @else
                <div class="col-md-4 text-center">
                    <p class="mb-2">From</p>
                    <h1 class="mb-0">{{ $booked_packetObj['tracking_detail']['origin_city_name'] }}</h1>
                </div>
                <div class="col-md-4 text-center">
                    <div class="corier_van">
                        <p class="mb-0">{{ $booked_packetObj['tracking_detail']['booked_packet_status_message']}}</p>
                    </div>
                </div>
                <div class="col-md-4 text-center">
                    <p class="mb-2">To</p>
                    <h1 class="mb-0">{{ $booked_packetObj['tracking_detail']['destination_city_name'] }}</h1>
                </div>
            @endif
        </div>
    </div>

    <div class="mt-3"></div>

    <div class="container">
        <div class="row">
            <table class="table table-bordered">
                @if(request()->is_admin == 1)
                    <tbody>
                    <tr>
                        <td  align="right"><b>Payment Received:</b></td>
                        <td>
                            @if ($booked_packetObj['tracking_detail']['payment_received'] == '1')
                            Yes
                           @else
                            No
                           @endif

                        </td>
                        <td  align="right"><b>Payment Made to Client:</b></td>
                        <td >
                            @if ($booked_packetObj['tracking_detail']['is_paid'] == '1')
                            Yes
                            @else
                            No
                            @endif
                        </td>
                        <td align="right"><b>No. of Pieces:</b></td>
                        <td>{{$booked_packetObj['tracking_detail']['booked_packet_no_piece']}}</td>
                    </tr>
                    <tr>
                        <td align="right"><b>Deposit Slip No:</b></td>
                        <td> {{$booked_packetObj['tracking_detail']['deposit_slip_no']}} </td>
                        <td align="right">   <b>Cheque Number:</b></td>
                        <td>{{$booked_packetObj['tracking_detail']['invoice_cheque_no']}}</td>
                        <td align="right"><b>Packet Weight:</b></td>
                        <td> <?php if ($booked_packetObj['tracking_detail']['booked_packet_weight'] != '') { ?><?php echo number_format(max($booked_packetObj['tracking_detail']['booked_packet_weight'], $booked_packetObj['tracking_detail']['booked_packet_vol_weight_cal'], $booked_packetObj['tracking_detail']['arival_dispatch_weight']) / 1000, 3); ?> (Kgs)<?php } else { ?>N/A<?php } ?></td>
                    </tr>
                    <tr>
                        <td align="right">  <b>Deposit Amount:</b></td>
                        <td> {{$booked_packetObj['tracking_detail']['amount']}} </td>
                        <td align="right"><b>Cheque Date:</b></td>
                        <td>{{$booked_packetObj['tracking_detail']['invoice_cheque_date']}}</td>
                        <td align="right"><b>COD Amount:</b></td>
                        <td>     PKR <?php echo number_format($booked_packetObj['tracking_detail']['booked_packet_collect_amount'], 2); ?></td>
                    </tr>
                    <tr>
                        <td align="right"><b>Batch No:</b></td>
                        <td>{{$booked_packetObj['tracking_detail']['batch_no']}}</td>
                        <td align="right"><b></b></td>
                        <td></td>
                        <td align="right"><b>Invoice: Charges:</b></td>
                        <td>{{$booked_packetObj['tracking_detail']['packet_charges']}}</td>

                    </tr>
                    <tr>
                        <td align="right"><b>Branch Name:</b></td>
                        <td>{{$booked_packetObj['tracking_detail']['branch_name']}}</td>
                        <td align="right"><b></b></td>
                        <td></td>
                        <td align="right"><b></b></td>
                        <td></td>

                    </tr>
                    <tr>
                        <td align="right"><b>Credit Date:</b></td>
                        <td>{{$booked_packetObj['tracking_detail']['date_credit']}}</td>
                        <td align="right"><b></b></td>
                        <td></td>
                        <td align="right"><b></b></td>
                        <td></td>

                    </tr>
                    </tbody>
                @else

                    <tbody>
                    <tr>
                        <td width="20%" align="right"><b>Tracking #:</b></td>
                        <td width="30%">{{$booked_packetObj['tracking_detail']['booked_packet_cn']}}</td>
                        <td width="20%" align="right"><b>Reference # / Order ID:</b></td>
                        <td width="30%">{{$booked_packetObj['tracking_detail']['booked_packet_order_id']}}</td>
                    </tr>
                    <tr>
                        <td align="right"><b>No. of Pieces:</b></td>
                        <td>{{$booked_packetObj['tracking_detail']['booked_packet_no_piece']}}</td>
                        <td align="right"><b>Packet Weight:</b></td>
                        <td> <?php if ($booked_packetObj['tracking_detail']['booked_packet_weight'] != '') { ?><?php echo number_format(max($booked_packetObj['tracking_detail']['booked_packet_weight'], $booked_packetObj['tracking_detail']['booked_packet_vol_weight_cal'], $booked_packetObj['tracking_detail']['arival_dispatch_weight']) / 1000, 3); ?> (Kgs)<?php } else { ?>N/A<?php } ?></td>
                    </tr>
                    <tr>
                        <td align="right"><b>Shipper Name:</b></td>
                        <td>   <?php if ($booked_packetObj['tracking_detail']['shipper_name'] != '') { ?><?php echo $booked_packetObj['tracking_detail']['shipper_name']; ?><?php } else { ?>N/A<?php } ?></td>
                        <td align="right"><b>Consignee Name:</b></td>
                        <td><?php if ($booked_packetObj['tracking_detail']['consignment_name'] != '') { ?><?php echo $booked_packetObj['tracking_detail']['consignment_name']; ?><?php } else { ?>N/A<?php } ?></td>
                    </tr>
                    <tr>
                        <td align="right"><b>Shipper Address:</b></td>
                        <td> <?php if ($booked_packetObj['tracking_detail']['shipper_address'] != '') { ?><?php echo $booked_packetObj['tracking_detail']['shipper_address']; ?><?php } else { ?>N/A<?php } ?></td>
                        <td align="right"><b>Consignee Address:</b></td>
                        <td class="limited"><?php if ($booked_packetObj['tracking_detail']['consignment_address'] != '') { ?><?php echo $booked_packetObj['tracking_detail']['consignment_address']; ?><?php } else { ?>N/A<?php } ?></td>
                    </tr>
                    </tbody>
               @endif
            </table>
        </div>
    </div>

    <div class="container">
        <div class="row" style="overflow-y: scroll">
            <table class="table table-bordered">
                <thead>
                  <tr style="background-color: #D8D8D8;">
                    <td  align="center">
                        Activity Date
                    </td>
                    <td  align="center">
                        Status
                    </td>
                     @if (request()->is_admin == 1)
                    <td align="center">
                        Courier Code
                    </td>
                    <td align="center" >
                        Courier Name
                    </td>
                    @endif
                </tr>
                </thead>
                <tbody id="track-rid">
                    @if (count($booked_packetObj['journey']) > 0)
                        @php $bookedPacket = $booked_packetObj; @endphp
                        @foreach ($booked_packetObj['journey'] as $booked_packetObj)
                            @if ($booked_packetObj['packet_status'] != 'DL')
                                <tr >
                                    <td align="center">
                                        {{ date('M j, Y H:i:s A', strtotime($booked_packetObj['activity_date'])) }}
                                    </td>
                                    <td align="center">
                                        {{ $booked_packetObj['packet_status'] }}
                                    </td>
                                    @if (request()->is_admin == 1)
                                            <td align="center">
                                                @if ($booked_packetObj['courier_id'] && $booked_packetObj['courier_name'])
                                                    {{ $booked_packetObj['courier_id'] }}
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td align="center">
                                                @if ($booked_packetObj['courier_id'] && $booked_packetObj['courier_name'])
                                                    {{ $booked_packetObj['courier_name'] }}
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                    @endif
                                </tr>
                            @endif
                        @endforeach
                        @php $booked_packetObj = $bookedPacket; @endphp
                        <tr >
                            <td align="center">
                                {{ date('M j, Y H:i:s A', strtotime($booked_packetObj['tracking_detail']['date_created'])) }}
                            </td>
                            <td align="center">
                                Posted for Consignment Booking at {{ strtoupper($booked_packetObj['tracking_detail']['origin_city']) }}
                            </td>
                            @if (request()->is_admin == 1)
                                    <td align="center">
                                        N/A
                                    </td>
                                    <td align="center">
                                        N/A
                                    </td>
                            @endif
                        </tr>
                    @else
                        <tr >
                            <td align="center">
                                {{ date('M j, Y H:i:s A', strtotime($booked_packetObj['tracking_detail']['created_at'])) }}
                            </td>
                            <td align="center">
                                Posted for Consignment Booking at {{ strtoupper($booked_packetObj['tracking_detail']['origin_city_name']) }}
                            </td>
                            @if (request()->is_admin == 1)
                                <td align="center">
                                    N/A
                                </td>
                                <td align="center">
                                    N/A
                                </td>
                            @endif
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

</div>
