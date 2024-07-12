@push('styles')
        <!-- ------------------- stack  styles ------------------------ -->
        <link href="{{ url_secure('vendors/multi_select/jquery.multiselect.css')}}" rel="stylesheet"/>
        <!-- <link href="{{ url_secure('vendors/select2/dist/css/select2.min.css')}}" rel="stylesheet"> -->
        <link href="{{ url_secure('vendors/sweet_alert/sweetalert2.min.css')}}"  rel="stylesheet"/>
        <link href="{{ url_secure('build/css/livewire_components_action.css')}}" rel="stylesheet">
        
        <link href="{{ url_secure('build/css/livewireSelect2.css')}}" rel="stylesheet">
        <!-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> -->
        
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

    @php
        $JsMainTitle = $MainTitle;
        $MainTitle = preg_split('/(?=[A-Z])/', $MainTitle);
        $MainTitle = $MainTitle[1] . ' ' . $MainTitle[2];
    @endphp
    
    @section('title') {{ $MainTitle }} Listing  @endsection

        <div class="right_col" role="main">
            <div class="">

                    @include('Admin.partial.livewire.header')         

                    @include('Admin.UserManagement.User.add') 

                    @include('Admin.UserManagement.User.list')  

            </div>
        </div>

       
      
@push('scripts')
       
       <script src="{{ url_secure('build/js/livewire_components_action.js')}}"></script>

        <!-- ------------------- stack  scripts ------------------------ -->
           
        <script src="{{ url_secure('vendors/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js')}}"></script>
        <script src="{{ url_secure('vendors/validate/jquery.validate.min.js')}}"></script>
        <script src="{{ url_secure('build/js/main.js')}}"></script>
        <!-- <script src="{{ url_secure('vendors/select2/dist/js/select2.full.min.js')}}"></script> -->
        <script src="{{ url_secure('build/js/livewireSelect2.js')}}"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
           <!-- ------------------- stack  scripts end  ------------------------ -->

    <script>


        // document.addEventListener('DOMContentLoaded', function () {
        //     setTimeout(function () {
        //         Livewire.restart();
        //     }, 100);
        // });

        // document.addEventListener('DOMContentLoaded', function () {
        //     setTimeout(function () {
        //         let username = document.getElementById('username');
        //         Livewire.hook('element.updated', () => {
        //             // Ensures Livewire re-binds to the input after the initial delay
        //             username.addEventListener('input', function () {
        //                 @this.set('ecom_admin_user.username', username.value);
        //             });
        //         });

        //         // Manually trigger input event to update Livewire model
        //         let event = new Event('input', { bubbles: true });
        //         username.dispatchEvent(event);
        //     }, 500); // Adjust the delay as needed
        // });
        

        $(document).ready(function() 
        {
            ApplyAllSelect2(); 
        });
        var ModuleName = '{!! $JsMainTitle !!}';
        var readyToLoad = {!! json_encode($readyToLoad) !!};
        var GetEmployeeDataRoute = "{{ route('get.EmployeeData') }}";
    
        // -------------------- send response that page is loaded, ----------------------
        window.addEventListener('ResetDropDowns', event => 
        {
            $('.multipleRoles').empty();
            $("#city_id").empty();
            $("#country_id").empty();
            // ApplyAllSelect2();
            // Livewire.emit('LoadDataNow');                          
        });
        window.addEventListener('loadDropDownData', event => 
        {
            
            // alert($('#username').val());

            setTimeout(function () {
                // $('#first_name').val('');
                // $('#last_name').val('');
                // $('#mobile').val('');
                // $('#username').val(' ');
                // $('#email').val('');
                // $('#password').val('');
                // $('#password_confirmation').val('');
                // alert($('#username').val());
            }, 1000);
            // ApplyAllSelect2();
            // Livewire.emit('LoadDataNow');                          
        });

        $('.Select2DropDown').on('change', function(e) 
        {      
            if($(this).attr('data-id') === 'roles')
            {
                console.log('print roles');
                const selectedValues = $(this).select2("val");
                console.log('Selected Values:', selectedValues);
                Livewire.emit('UpdateRoleIds', $(this).attr('data-id'), selectedValues);
            }
            if($(this).attr('data-id') === 'city_id')
            {
                console.log('print city');
                const CtiyValues = $('#city_id').val();
                console.log('Selected city:', CtiyValues);
                Livewire.emit('UpdateCityID', $(this).attr('data-id'), CtiyValues);
                // Livewire.emit('UpdateCityID')
            }
            if($(this).attr('data-id') === 'country')
            {
                Livewire.emit('UpdateCountryID', $(this).attr('data-id'), $(this).select2("val"))
            }
            if($(this).attr('data-id') === "gender_id")
            {
                Livewire.emit('UpdateGenderID', $(this).attr('data-id'), $(this).select2("val"))
            }

            // console.log('select field ' + $(this).attr('data-id'));
            // console.log('select value ' + $(this).select2("val"));

        });

        function ApplyAllSelect2()
        {
            const token = getToken();
            const headers = {
                "Authorization": `Bearer ${token}`,
            };
          
            $('.multipleRoles').select2();

            window.initSelectCompanyDrop=()=>
            {
                $('.multipleRoles').select2({
                    placeholder: 'Please Select Roles',
                    allowClear: true
                });

                $('.gender').select2({
                    placeholder: 'Please Select Gender',
                    allowClear: true
                });

                $("#city_id").select2({
                    placeholder: "Search City",
                    minimumInputLength: 2,      // Minimum characters before sending the AJAX request
                    allowClear: true,
                    ajax: {
                        url: "{{ api_url('get_cities') }}", // Replace with your actual server endpoint
                        dataType: "json",
                        delay: 250, // Delay before sending the request in milliseconds
                        headers: headers,
                        processResults: function (data) {
                            return {
                                results: data.map(function (item) {
                                    return {
                                        id: item.id,
                                        text: item.label // 'text' property is required by Select2
                                    };
                                })
                            };
                        },
                        cache: true // Enable caching of AJAX results
                    }
                });

                $("#country_id").select2({
                    placeholder: "Search Country",
                    minimumInputLength: 2, // Minimum characters before sending the AJAX request
                    allowClear: true,
                    ajax: {
                        url: "{{ api_url('get_countries') }}", // Replace with your actual server endpoint
                        dataType: "json",
                        delay: 250, // Delay before sending the request in milliseconds
                        headers: headers,
                        processResults: function (data) {
                            return {
                                results: data.map(function (item) {
                                    return {
                                        id: item.id,
                                        text: item.label // 'text' property is required by Select2
                                    };
                                })
                            };
                        },
                        cache: true // Enable caching of AJAX results
                    }
                });
            }
            initSelectCompanyDrop();

            window.livewire.on('select2', () => {
                initSelectCompanyDrop();
            });
        }
    </script>
    
    <!-- <script src="{{ url_secure('build/js/LivewireDropDownSelect2.js')}}"></script> -->


@endpush