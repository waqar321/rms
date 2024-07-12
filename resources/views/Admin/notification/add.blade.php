
@php 
    if ($errors->any())
    {
        $this->ErrorLoaded(); 
        //echo '123';
    }
@endphp 

@can('create_notification')
    
    <div class="row">  
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                <h2> {{ $pageTitle }} 

                    <span wire:init="pageLoaded" style="padding-left: 20px;">
                            @if($total_employees == 0)
                                <label for=""> Feeding Data For Notification Sending... </label>
                                <td colspan="18" class="text-center"> 
                                        <img style="height:70px;" src="{{ url_secure('build/images/transpatent_leopard.gif') }}" alt="Loading123!!">
                                </td>
                            @endif 
                    </span>

                </h2>
                    <ul class="nav navbar-right panel_toolbox justify-content-end">
                        <li>
                            <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                    </ul> 
                    <div class="clearfix"></div>
                </div>

                <div class="x_content {{ $Collapse  }}">

                    @foreach ($errors->all() as $key => $error)
                        @if (strpos($error, 'CSV For') !== false)
                            @if (strpos($error, 'Valid IDs') !== false)
      
                                <div class="col-mb-12 col-lg-12">   
                                    <div class="alert alert-success" style="font-size: 13.5px;">
                                        {{ $error }} 
                                    </div>
                                </div>    
                            @else 

                                <div class="col-mb-12 col-lg-12">   
                                    <div class="alert alert-danger" style="font-size: 13.5px;">
                                        {{ $error }}
                                    </div>
                                </div>    
                            @endif 
                        @else        
           
                            <div class="col-mb-12 col-lg-12">   
                                <div class="alert alert-danger" style="font-size: 13.5px;">
                                    {{ $error }} !!!
                                </div>
                            </div>    
                        @endif
                    @endforeach

                    @error('csv_file')
                    <!-- <div class="alert alert-danger" style="font-size: 13.5px;">
                        {{ $message }}
                    </div> -->
                    @enderror
                    

                    <div class="col-mb-12 col-lg-12" >
                        <form>

                            @csrf

                            @include('Admin.partial.livewire.select2Elements', ['Component' => 'notification'])
                                                    
                            <!-- ========================= Title ======================================= -->
                            
                            <div class="col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Notification Title <span class="danger">*</span></label>
                                    <input type="text" wire:model='ecom_notification.title' class="form-control TitleElement" placeholder="Enter Text Title">
                                </div>
                            </div>

                            <!-- ========================= Body Message ======================================= -->
                            
                                <div class="form-group" >
                                    <label for="description" class="col-form-label text-md-right CkEditorCSSLabel">
                                        Message 
                                    </label> 
                                    <div class="CkEditorCSS" wire:ignore>
                                            <textarea id="NotificationMessage"></textarea>
                                    </div>
                                    @error('ecom_notification.messagebody')
                                        <span style="font-size: 11px; color: #e3342f">{{ $message }}</span>
                                    @enderror
                                </div>
                                    <!-- {!!  $ecom_notification->messagebody !!}  -->
                                    <!-- <div class="col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label>Notification Message Body <span class="danger">*</span></label>
                                            <textarea  wire:model='ecom_notification.messagebody' class="form-control BodyElement"  placeholder="Enter Text Message"></textarea>
                                        </div>
                                    </div> -->

                            <div class="col-md-12 col-lg-12">
                                <div class="form-group">
                                    <button type="submit" id="SendFormRequest" data-component="SendNotification" class="btn btn-primary"> {{ $update ? 'Update' : 'Save' }} </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
@endcan