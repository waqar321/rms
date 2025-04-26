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

                    @include('Admin.Ledger.add') 
                    @include('Admin.Ledger.list') 
                    

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
        var item_price = 0;
        var item_qty = 0;

        $(document).ready(function() 
        {
            // setTimeout(function () {
            //     Livewire.restart();
            // }, 100);
            ApplyAllSelect2(); 

            $('#vendor_item_section').addClass('d-none');
            $('#unit_price_section').addClass('d-none');
            $('#cash_amount_section').addClass('d-none');
            $('#unit_qty_section').addClass('d-none');
            $('#total_amount_section').addClass('d-none');

            $('#cash_amount').on('input', function () 
            {
                    // alert('awdawd');
                    // return false;

                    updateTotal();
            });
    
            // $('#cash_amount').on('input', updateTotal);
    
            // $('#cash_amount').on('change', function () 
            // {
            //     updateTotal();
            // });
    
            $('#unit_qty').on('input', function ()
            {
                item_qty = $(this).val();
                // alert(item_qty);
                updateTotal();
            });

            $('#item_id').on('change', function ()
            {
                // const selectedValues = $(this).select2("val");
                const selectedValues = $(this).val();
                Livewire.emit('getItemAmount', selectedValues);  // Emit the event with the selected item ID
                // alert(selectedValues);
            });
            window.addEventListener('item_price', event => 
            {
                item_price = event.detail.item_price;
                updateTotal();
            });
            $('#payment_type').on('change', function () 
            {
                let type = $(this).val();

                if (type === 'cash') 
                {
                    $('#cash_amount_section').removeClass('d-none');
                    $('#unit_price_section').addClass('d-none');
                    $('#total_amount_section').removeClass('d-none');
                } 
                else if (type === 'product_bought') 
                {
                    // $('#cash_amount_section').removeClass('d-none');
                    $('#vendor_item_section').removeClass('d-none');
                    $('#unit_price_section').removeClass('d-none');
                    // $('#unit_price_section').addattr('readonly');
                    $('#unit_qty_section').removeClass('d-none');
                    $('#total_amount_section').removeClass('d-none');
                    // alert('awd');                    
                    updateTotal();
                } 
                // else if (type === 'product_sold') 
                // {
                //     $('#productSection').removeClass('d-none');
                //     $('#cashAmountSection').addClass('d-none');
                //     updateTotal();
                // } 
                // else 
                // {
                //     $('#productSection').addClass('d-none');
                //     $('#cashAmountSection').addClass('d-none');
                // }
            });

            function updateTotal() 
            {
                let total_amount=0;

                if(item_price!=0)
                {
                    // alert(item_qty);

                    $('#unit_price').val(item_price);
                    // item_qty = $('#unit_qty').val();
                    total_amount = item_qty * item_price;
                    // alert(item_price);
                    // alert(item_qty);
                }
                else
                {
                    total_amount = parseFloat($('#cash_amount').val()) || 0;
                }
                
                $('#total_amount').val((total_amount).toFixed(2));
                // let unit_price = parseFloat($('#unit_price').val()) || 0;
                // let unit_qty = parseFloat($('#unit_qty').val()) || 0;
                // $('#total_amount').val((qty * unit).toFixed(2));
            }
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