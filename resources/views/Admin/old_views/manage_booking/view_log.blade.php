<style>
    button.close {
        margin: -45px 0 0 0 !important;
    }
</style>
<div class="container">
        <div class="row">
            <table class="table table-bordered">
                <thead>
                  <tr style="background-color: #D8D8D8;">
                    <td align="center">Activity Date</td>
                    <td align="center">User</td>
                    <td align="center">Remarks</td>
                  </tr>
                </thead>
                <tbody id="track-rid">
                    @if (count($booked_packetObj) > 0)
                        @foreach ($booked_packetObj as $booked_packetObj)
                            @if ($booked_packetObj['packet_status'] != 'DL')
                                <tr >
                                    <td align="center">
                                        {{ date('M j, Y H:i:s A', strtotime($booked_packetObj['created_at'])) }}
                                    </td>
                                    <td align="center">
                                        {{ $booked_packetObj['first_name'] }} {{ $booked_packetObj['last_name'] }} ({{ $booked_packetObj['username'] }}) | {{$booked_packetObj['email']}}
                                    </td>
                                    <td align="center">
                                        {{ $booked_packetObj['remark_text'] }}
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    @else
                        <tr >
                            <td align="center">
                                No Data Found
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
</div>
