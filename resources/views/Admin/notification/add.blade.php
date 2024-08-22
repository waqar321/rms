
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
                
                @include('Admin.partial.livewire.X_titles')   

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
                            
                                <!-- <div class="form-group" >
                                    <label for="description" class="col-form-label text-md-right CkEditorCSSLabel">
                                        Message 
                                    </label> 
                                    <div class="CkEditorCSS" wire:ignore>
                                            <textarea id="NotificationMessage"></textarea>
                                    </div>
                                    @error('ecom_notification.messagebody')
                                        <span style="font-size: 11px; color: #e3342f">{{ $message }}</span>
                                    @enderror
                                </div> -->

                                    <!-- {!!  $ecom_notification->messagebody !!}  -->
                                    <!-- <div class="col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label>Notification Message Body <span class="danger">*</span></label>
                                            <textarea  wire:model='ecom_notification.messagebody' class="form-control BodyElement"  placeholder="Enter Text Message"></textarea>
                                        </div>
                                    </div> -->
                            <!-- ========================= Body Message ======================================= -->

                            <div class="form-group" wire:ignore>
                                <label for="description" class="col-form-label text-md-right">
                                    Notificatin Content
                                </label>
                                <input id="x" type="hidden" name="content" value="{{ $content }}">
                                <!-- <input id="x" wire:model.debounce.500ms="ecom_notification.messagebody" type="hidden" name="content"> -->

                                <trix-editor class="trix-content" input="x"></trix-editor>

                                @error('content')
                                    <span style="font-size: 11px; color: #e3342f">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <!-- ========================= Body Message ======================================= -->

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