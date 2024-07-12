<!DOCTYPE html>
<html lang="en">

<head>
        
    @include('Admin.layout.head')
    @livewireStyles 
    @stack('styles')
    @stack('LinkscriptsAtTop')
    @yield('styles')

</head>

<body class="nav-md">
<div id="leopard_loader" class="leopard_loader">
    <img src="{{ url_secure('build/images/transpatent_leopard.gif') }}" alt="Loading...">
</div>
<audio id="audio_success" autostart="false">
    <source src="{{url_secure('sound/success3.mp3')}}" type="audio/ogg">
    <source src="{{url_secure('sound/success_sound.mp3')}}" type="audio/mpeg">
    Your browser does not support the audio element.
</audio>
<audio id="audio_error" autostart="false">
    <source src="{{url_secure('sound/error2.mp3')}}" type="audio/ogg">
    <source src="{{url_secure('sound/error2.mp3')}}" type="audio/mpeg">
    Your browser does not support the audio element.
</audio>
<div class="container body">
    <div class="main_container">


        <!-- sidebar menu -->
        <div>    
            <livewire:admin.partials.sidebar/>    
        </div>
        <!-- sidebar menu end -->
    
    
        <!-- sidebar menu -->
        <div>    
            <livewire:admin.notification.token-check/>    
        </div>
        <!-- sidebar menu end -->

        


        <!-- sidebar -->
            <!-- import side here -->
        <!-- end sidebar -->
        <!-- top navigation -->
        @include('Admin.layout.header')                
        <!-- /top navigation -->

        <!-- page content -->
         @yield('content')

        <!-- /page content -->
        <div class="modal fade" id="packet_detail" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog " style="max-width: 75rem;">
                <div class="modal-content">
                    <div class="modal-header">
                        <p class="modal-title text-center" id="exampleModalLabel"><span style="font-weight: bold; font-size: 18px;">Tracking Info</span></p>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="packet_body" style="height:auto">

                    </div>
                    <!-- <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div> -->
                </div>
            </div>
        </div>
        <div class="modal fade bd-example-modal-lg" id="client_view" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <p class="modal-title" id="exampleModalLabel">Client Info</p>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="client_body" style="height:auto">

                        <h1 id="print_a" style="margin-bottom: 5px; font-size: 14px; font-weight: bold; width: 100%; text-align: center;">
                            <button  style="float: right; margin-right: 40px;" onclick="printView($('#bgSetter').html())">
                                <img src="{{ url_secure('build/images/print.png') }}" width="24" title="Print">
                            </button>
                        </h1>

                        <div style="overflow-x: hidden;" id="bgSetter">
                            <div class="mt-3"></div>

                            <div class="container">
                                <div class="row">
                                    <table class="table table-bordered">
                                        <tbody>
                                        <tr>
                                            <td width="20%" align="right"><b>Merchant Name:</b></td>
                                            <td width="30%" id="data_merchant_name"></td>
                                            <td width="20%" align="right"><b>Phone#</b></td>
                                            <td width="30%" id="data_merchant_phone"></td>
                                        </tr>
                                        <tr>
                                            <td width="20%" align="right"><b>Email:</b></td>
                                            <td width="30%" id="data_merchant_email"></td>
                                            <td width="20%" align="right"><b>Account No</b></td>
                                            <td width="30%" id="data_merchant_account_no"></td>

                                        </tr>
                                        <tr>
                                            <td width="20%" align="right"><b>Account Opening Date:</b></td>
                                            <td width="30%" id="data_merchant_account_opening_date"></td>
                                            <td width="20%" align="right"><b>Address:</b></td>
                                            <td width="30%" id="data_merchant_address1"></td>

                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>


                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- footer content -->
        @include('Admin.layout.footer')
        <!-- /footer content -->
    </div>
</div>


@include('Admin.layout.script')
@livewireScripts    
<!-- <script src="{{ url_secure('build/js/livewire/livewire-sortable.js')}}"></script> -->
<script src="https://cdn.jsdelivr.net/gh/livewire/sortable@v0.x.x/dist/livewire-sortable.js"></script>

@stack('scripts')
@yield('scripts')


</body>
</html>
