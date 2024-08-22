@push('styles')
    <style>
        @keyframes blink {
            0% { opacity: 1; }
            50% { opacity: 0; }
            100% { opacity: 1; }
        }
        .blink {
            animation: blink 1s infinite;
            color: red !important;
        }
        .panel_toolbox 
        {
            min-width: 0px !important;
            margin-left: 10px !important;
        }

    </style>
@endpush

    <div class="x_title collapse-link">
        <div class="row">
            <div class="col-lg-6 text-left">
                <h2> 
                    {{ explode(" ", $pageTitle)[0] }}
                    
                    <span wire:init="pageLoaded" style="padding-left: 20px;">
                            @if(explode(" ", $pageTitle)[0] == 'CourseAlign' || explode(" ", $pageTitle)[0] == 'Notification')
                                @if(isset($total_employees) && $total_employees == 0)
                                    <label for=""> Feeding Data For Notification Sending... </label>
                                    <td colspan="18" class="text-center"> 
                                            <img style="height:70px;" src="{{ url_secure('build/images/transpatent_leopard.gif') }}" alt="Loading123!!">
                                    </td>
                                @endif 
                            @endif 
                    </span>
                    
                </h2>
            </div>
            <div class="col-lg-6 d-flex justify-content-end">
                @if(!$update)
                    <h2 class="blink"> 
                        Click To Create {{ explode(" ", $pageTitle)[0] }} 
                    </h2>
                @endif 
                <ul class="nav navbar-right panel_toolbox">
                    <li>
                        <a ><i class="fa fa-chevron-up" ></i></a>
                    </li>
                </ul>
            </div>
        </div> 
        
        <div class="clearfix"></div>
    </div>