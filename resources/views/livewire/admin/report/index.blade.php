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

                    {{-- @include('Admin.report.add') --}}
                    @include('Admin.report.list')


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

        $(document).ready(function()
        {
            // setTimeout(function () {
            //     Livewire.restart();
            // }, 100);
            ApplyAllSelect2();
        });
        var ModuleName = '{!! $JsMainTitle !!}';
        var readyToLoad = {!! json_encode($readyToLoad) !!};


        // -------------------- send response that page is loaded, ----------------------
        window.addEventListener('ResetDropDowns', event =>
        {
            $('.multiplePermissions').empty();
            // $("#city_id").empty();
            // $("#country_id").empty();
            // ApplyAllSelect2();
            // Livewire.emit('LoadDataNow');
        });
        window.addEventListener('updateData', event =>
        {

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
            if($(this).attr('data-id') === 'permissions')
            {
                console.log('print permissions');
                const selectedValues = $(this).select2("val");
                console.log('Selected Values:', selectedValues);
                Livewire.emit('UpdatePermissionIds', $(this).attr('data-id'), selectedValues);
            }
        });

        function ApplyAllSelect2()
        {
            const token = getToken();
            const headers = {
                "Authorization": `Bearer ${token}`,
            };

            $('.multiplePermissions').select2();

            window.initSelectCompanyDrop=()=>{
                $('.multiplePermissions').select2({
                    placeholder: 'Please Select Permissions',
                    allowClear: true
                });
            }
            initSelectCompanyDrop();

            window.livewire.on('select2', () => {
                initSelectCompanyDrop();
            });
        }


        window.addEventListener('ItemCategoryUpdated', event =>
        {
            console.log(event.detail);

            if(event.detail.value == false)
            {
                Swal.fire({
                    icon: 'sucess',
                    title: 'Category updated Successfully',
                    text: event.detail.messsage,
                });
            }
            else
            {
                Livewire.emit('saveCourseAlignEvent');
            }
        });


    </script>

    <!-- <script src="{{ url_secure('build/js/LivewireDropDownSelect2.js')}}"></script> -->


@endpush
