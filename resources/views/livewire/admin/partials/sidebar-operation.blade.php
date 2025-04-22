@push('styles')

    <link href="{{ url_secure('build/css/livewire_components_action.css')}}" rel="stylesheet">
    <link href="{{ url_secure('build/css/livewireSelect2.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{ url_secure('build/css/jquery_ui.css')}}">

        <style>

            /* .select2-container--default .select2-selection--multiple .select2-selection__choice { */
            .select2
            {
                background-color: #f0f8ff; 
                color: #000 !important; 
                /* border: 1px solid #aaa;  */
                width: 100% !important;
            }
            .select2-selection--multiple
            {
                min-height: 32px;
            }
            .select2-search__field
            {
                width: 300px !important;
                height: 26px !important;
                padding: 4px !important;
            }
            
            /* elect2-search--inline .select2-search__field */
        </style>
@endpush 

        @section('title') {{ $MainTitle }} Listing  @endsection

        <div class="right_col" role="main">
            <div class="">
            
                @include('Admin.partial.livewire.header')   
          
                @include('Admin.partial.sidebarFiles.add') 
                
                @include('Admin.partial.sidebarFiles.list') 


            </div>
        </div>
     
@push('scripts')

        <!-- ------------------- stack  scripts ------------------------ -->
           
        <script src="{{ url_secure('vendors/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js')}}"></script>
        <script src="{{ url_secure('vendors/validate/jquery.validate.min.js')}}"></script>
        <script src="{{ url_secure('build/js/main.js')}}"></script>
        <!-- <script src="{{ url_secure('vendors/select2/dist/js/select2.full.min.js')}}"></script> -->
        <script src="{{ url_secure('build/js/livewireSelect2.js')}}"></script>
        <!-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> -->
        <!-- ------------------- stack  scripts end  ------------------------ -->


            <script>

                    $(document).ready(function() 
                    {
                        // setTimeout(function () {
                        //     Livewire.restart();
                        // }, 100);
                        ApplyAllSelect2(); 
                    });
                    // var ModuleName = 'SidebarOperation';
                    var ModuleName = '{!! $MainTitle !!}';
                    // MainTitle
                    var readyToLoad = {!! json_encode($readyToLoad) !!};


                    // -------------------- send response that page is loaded, ----------------------
                    window.addEventListener('ResetDropDowns', event => 
                    {
                        $('.multiplePermissions').empty();
                    });
                    window.addEventListener('updateData', event => 
                    {

                    });

                    window.addEventListener('loadDropDownData', event => 
                    {                        
                        setTimeout(function () {
                        }, 1000);
                    });


                    $('.Select2DropDown').on('change', function(e) 
                    {      
                        if($(this).attr('data-id') === 'permission')
                        {
                            console.log('print permission');
                            const selectedValues = $(this).select2("val");
                            console.log('Selected Values:', selectedValues);
                            Livewire.emit('UpdatePermissionId', $(this).attr('data-id'), selectedValues);
                        }
                        else if($(this).attr('data-id') === 'parent_SideBar')
                        {
                            console.log('print permission');
                            const selectedValues = $(this).select2("val");
                            console.log('Selected Values:', selectedValues);
                            Livewire.emit('UpdateParentId', $(this).attr('data-id'), selectedValues);
                        }
                    });

                    function ApplyAllSelect2()
                    {
                        const token = getToken();
                        const headers = {
                            "Authorization": `Bearer ${token}`,
                        };
                    
                        // $('.multiplePermissions').select2();
                        // $('.multiplePermissions').select2();

                        window.initSelectCompanyDrop=()=>{
                            $('.multiplePermissions').select2({
                                placeholder: 'Please Select Permissions',
                                allowClear: true
                            });
                            $('.parent_SideBar').select2({
                                placeholder: 'Please Parent Menu',
                                allowClear: true
                            });
                        }
                        initSelectCompanyDrop();

                        window.livewire.on('select2', () => {
                            initSelectCompanyDrop();
                        });
                    }
                    
            </script>

@endpush 

