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
            /* =========================================================== */

                * {
                    box-sizing: border-box;
                }

                body {
                    font-family: Arial, sans-serif;
                    /* display: flex; */
                    /* justify-content: center; */
                    /* align-items: center; */
                    min-height: 100vh;
                    margin: 0;
                    background-color: #f0f0f0;
                }

                .quantity {
                    display: flex;
                    /* border: 2px solid #3498db; */
                    border-radius: 4px;
                    overflow: hidden;
                    /* box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); */
                }

                .quantity button {
                    background-color: #3498db;
                    color: #fff;
                    border: none;
                    cursor: pointer;
                    font-size: 20px;
                    width: 30px;
                    height: auto;
                    text-align: center;
                    transition: background-color 0.2s;
                }

                .quantity button:hover {
                    background-color: #2980b9;
                }

                .input-box {
                    width: 40px;
                    text-align: center;
                    border: none;
                    padding: 8px 10px;
                    font-size: 16px;
                    outline: none;
                }

                /* Hide the number input spin buttons */
                .input-box::-webkit-inner-spin-button,
                .input-box::-webkit-outer-spin-button {
                -webkit-appearance: none;
                margin: 0;
                }

                .input-box[type="number"] {
                -moz-appearance: textfield;
                }


            /* =========================================================== */
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

                    @include('Admin.pos.add')
                    @include('Admin.pos.list')


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

        var ModuleName = '{!! $JsMainTitle !!}';
        var readyToLoad = {!! json_encode($readyToLoad) !!};

        var categories = {!! json_encode($categories) !!};
        var items = {!! json_encode($items) !!};
        var selectedItems = [];
        var currentCategory = null;
        var cartQty       = {};
        var cartitemPrice       = {};
        var add_to_bill_clicked = false;

        $(document).ready(function()
        {
            ApplyAllSelect2();
            updateCatgories();
            // $('#categories .category-btn').first().click();
            // // 3 Initial load: pick first category, It triggers this event handler you defined earlier
            // var firstCat = $('#categories .category-btn').first();
            // if (firstCat.length)
            // {
            //     firstCat.click();
            // }

            $(function()
            {
                // INITIAL LOAD: click first category to bootstrap
                $('#categories .category-btn').first().click();
            });

            // 4. since tigger clicked, a click event is occured on class .category-btn, delegate click handler as before
            $('#categories').on('click', '.category-btn', function()
            {
                var id = +$(this).data('id');           // Get category ID: This gets the data-id attribute of the clicked .item-card. The + sign converts the value to a number.

                $('#categories .category-btn').removeClass('btn-primary').addClass('btn-outline-primary');

                $(this).removeClass('btn-outline-primary').addClass('btn-primary');
                // Render items
                renderItems(id);
            });
            // when an item is clicked in items grid (from previous code)
            $('#items').on('click', '.item-card', function()
            // $(document).on('input', '.item-card', function()
            {
                var id = +$(this).data('id');   // Get item ID: This gets the data-id attribute of the clicked .item-card. The + sign converts the value to a number.
                var price = +$(this).data('price');   // Get item ID: This gets the data-id attribute of the clicked .item-card. The + sign converts the value to a number.
                // alert(id);
                // toggle selection
                var idx = selectedItems.indexOf(id);   //This checks if the item id is already in the array selectedItems.

                if (idx === -1)                         // If not found, indexOf() returns -1
                {
                    selectedItems.push(id);        // { 2 }       // item id 2
                    cartQty[id] = 1;               // {"2": 1}    // item id 2 and qty 1
                    cartitemPrice[id] = price;               // {"2": 1}    // item id 2 and qty 1
                }
                else
                {
                    selectedItems.splice(idx,1);
                    delete cartQty[id];
                    delete cartitemPrice[id];
                }
                renderItems(currentCategory);
                renderCart();
            })
            // When the quantity input changes
            // $(document).on('input', '.qty-input', function()
            $('#cart-body').on('change', '.qty-input', function()
            {
                // alert('qty-input change click event');
                // console.log('qty');

                var $tr = $(this).closest('tr');
                var id  = +$tr.data('id');
                var val = parseInt($(this).val(), 10);

                if (isNaN(val) || val < 1)
                {
                    val = 1;
                    $(this).val(val);
                }

                // update your qty store and re-render
                cartQty[id] = val;
                renderCart();
            });


            // When the quantity input changes
            $('#cart-body').on('change', '.item-price', function()
            {
                var $tr = $(this).closest('tr');
                var update_item_price = parseInt($(this).val(), 10);
                var id  = +$tr.data('id');
                var real_item_price  = +$tr.data('price');

                if (isNaN(update_item_price) || update_item_price < 1)
                {
                    update_item_price = real_item_price;
                    $(this).val(update_item_price);
                }

                // update your qty store and re-render
                cartitemPrice[id] = update_item_price;
                renderCart();
            });
            // quantity controls
            $('#cart-body').on('click', '.inc-qty', function()
            {
                //   alert('inc-qty');

                var $tr = $(this).closest('tr');
                var id  = +$tr.data('id');
                cartQty[id] = (cartQty[id] || 1) + 1;
                renderCart();
            });
            $('#cart-body').on('click', '.dec-qty', function()
            {
                var $tr = $(this).closest('tr');
                var id  = +$tr.data('id');
                cartQty[id] = Math.max(1, (cartQty[id] || 1) - 1);
                renderCart();
            });
            // remove button
            $('#cart-body').on('click', '.remove-item', function(){
                var $tr = $(this).closest('tr');
                var id  = +$tr.data('id');
                var idx = selectedItems.indexOf(id);
                if (idx !== -1) {
                selectedItems.splice(idx,1);
                delete cartQty[id];
                delete cartitemPrice[id];
                }
                // also remove highlight from items grid
                $(`#items .item-card[data-id="${id}"]`).removeClass('bg-success text-white');
                renderCart();
            });
            // 1) “Add To Bill” click: validate items then show vendor dropdown
            $('#add-to-bill').on('click', function()
            {
                if (selectedItems.length === 0)
                {
                    Swal.fire('Error','Please select items to add to bill','error');
                    return;
                }

                add_to_bill_clicked = true;


                $('#vendor-error').hide();
                $('#vendor-container').slideDown();
            });
            // 2) Confirm vendor click: validate vendor, then send full payload
            $('#confirm-vendor').on('click', function()
            {
                var userId = $('#user-select').val();
                if (! userId)
                {
                    $('#vendor-error').show();
                    return;
                }

                // build payload: items, quantities, and vendor/user_id
                var payload = {
                _token: '{{ csrf_token() }}',
                items: selectedItems,
                qty:   cartQty,
                user_id: userId
                };

                $.post('/pos/save-cart', payload)
                .done(function(){
                    // open print in new tab
                    window.open('/pos/print', '_blank');
                })
                .fail(function(){
                    Swal.fire('Error','Failed to save bill','error');
                });
            });

            // hook up the Print Slip button
            $('#summary').on('click', '#print-slip', function()
            {
                // alert('awdawd');
                // return false;

                if (selectedItems.length === 0)
                {
                    Swal.fire('Error', 'No items to print', 'error');
                    return;
                }
                else if(add_to_bill_clicked == true)
                {
                    var userId = $('#user-select').val();
                    if (! userId)
                    {
                        $('#vendor-error').show();
                        return;
                    }
                }
                //    console.log(selectedItems);
                //    console.log(cartQty);
                //    console.log(cartitemPrice);
                // inside your “Print Slip” handler:

                $.ajax({
                url: '/pos/save-cart-receipt', //waqar
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    items: selectedItems,
                    qty: cartQty,
                    pricing: cartitemPrice,
                    user_id: $('#user-select').val()
                },
                success: function()
                {
                        // Open the receipt in a new tab
                    window.open('/pos/print', '_blank');
                        // Refresh the current page
                        // location.reload();
                        ResetData();
                },
                error: function(){
                    Swal.fire('Error','Failed to save cart','error');
                }
                });
            });

            function ResetData()
            {
                selectedItems = [];
                currentCategory = null;
                cartQty = {};
                cartitemPrice = {};
                add_to_bill_clicked = false;

                renderItems();      // re-render items
                renderCart();       // clear the cart
                updateSummary();    // if you have summary section
                updateCatgories();  // re-render category buttons

                var firstCat = $('#categories .category-btn').first();
                if (firstCat.length)
                {
                    firstCat.click();
                }
                Livewire.emit('ResetData');
            }
            // 1️⃣ Render items for a given category
            function renderItems(categoryId)
            {
                currentCategory = categoryId;
                $('#items').empty();

                items.filter(item => +item.category_id === +categoryId)
                .forEach(item => {
                    var isSelected = selectedItems.includes(item.id);
                    var $col = $(`
                    <div class="col-md-2 col-sm-3 mb-3">
                        <div class="card text-center ${isSelected ? 'bg-success text-white' : ''} item-card"
                            data-id="${item.id}" data-price="${item.price}"
                            style="cursor:pointer;">
                        <div class="card-body p-2">
                            <img src="/storage/${item.image_path}"
                                class="img-fluid mb-2"
                                style="max-height:80px; object-fit:cover;">
                            <h5 class="mb-1">${item.name}</h5>
                            <small>Rs. ${parseFloat(item.price).toLocaleString()}</small>
                        </div>
                        </div>
                    </div>
                    `);
                    $('#items').append($col);
                });
            }

            function renderCart()
            {
                var $tb = $('#cart-body').empty();

                if (selectedItems.length === 0)
                {
                    return $tb.append(
                        '<tr><td colspan="7" class="text-center text-muted">No items selected</td></tr>'
                    );
                }

                selectedItems.forEach(function(id, idx)
                {
                    var item = items.find(i => +i.id === +id);
                    if (!item) return;
                    var qty  = cartQty[id] || 1;

                    // if (!cartQty[id]) cartQty[id] = 1;
                    // Ensure qty and price exist before calculating subtotal
                    if (!cartQty[id]) cartQty[id] = 1;
                    if (!cartitemPrice[id]) cartitemPrice[id] = item.price;


                    // var price = parseFloat(item.price);
                    // var subtotal = price * qty;
                    var qty = cartQty[id];
                    var itemPrice  = cartitemPrice[id] || 1;
                    var subtotal = itemPrice * qty;


                    var $row = $(`
                        <tr data-id="${id}">
                        <td>${idx + 1}</td>
                        <td>
                            <img src="/storage/${item.image_path}"
                                style="max-height:80px;object-fit:cover;"
                                class="img-fluid">
                        </td>
                        <td style="font-size:25px">${item.name}</td>
                        <td>
                            <div class="quantity">
                                <button class="minus dec-qty" aria-label="Decrease">&minus;</button>
                                <input type="number" class="input-box qty-input" value="${qty}" min="1">
                                <button class="plus inc-qty" aria-label="Increase">&plus;</button>
                            </div>

                        </td>
                        <td data-price="${item.price}" style="font-size:25px">
                            <input type="number"
                                    class="form-control form-control-sm item-price"
                                    style="width:80px;display:inline-block;text-align:center;"
                                    value="${itemPrice}">
                        </td>

                        <td style="font-size:25px">${subtotal.toLocaleString()}</td>
                        <td>
                            <button class="btn btn-danger btn-sm remove-item">x</button>
                        </td>
                        </tr>
                    `);
                    $tb.append($row);
                });

                updateSummary();
            }

            // recalculates and updates the summary panel
            function updateCatgories()
            {
                // 1. empty the container (in case there’s old content)
                $('#categories').empty();

                // 2. build & append buttons
                categories.forEach(function(cat)
                {
                    // only active ones?
                    if (cat.is_active) {
                    var $btn = $(`
                        <div class="col-auto mb-2">
                        <button
                            data-id="${cat.id}"
                            class="btn btn-outline-primary category-btn">
                            ${cat.name}
                        </button>
                        </div>
                    `);
                    $('#categories').append($btn);
                    }
                });
            }
            function updateSummary()
            {
                var totalItems = selectedItems.reduce(function(sum, id)
                {
                    return sum + (cartQty[id] || 1);
                }, 0);

                var subtotal = selectedItems.reduce(function(sum, id)
                {
                    var item = items.find(i => +i.id === +id);
                    var qty  = cartQty[id] || 1;
                    var itemPrice  = cartitemPrice[id] || 1;
                    return sum + (parseFloat(itemPrice) * qty);
                }, 0);

                // tax is always zero in this example
                var tax = 0;
                var total = subtotal + tax;

                $('#summary-total-items').text(totalItems);
                $('#summary-subtotal').text(subtotal.toLocaleString());
                $('#summary-tax').text(tax.toLocaleString());
                $('#summary-total').text(total.toLocaleString());
            }
        });



        // -------------------- send response that page is loaded, ----------------------
                // window.addEventListener('ResetDropDowns', event =>
                // {
                //     $('.multiplePermissions').empty();
                // });
                 window.addEventListener('open-new-tab', event =>
                 {
                     const url = event.detail.url;
                     window.open(url, '_blank');
                    //   alert(url);
                    //  return false;
                 });
                // window.addEventListener('updateData', event =>
                // {

                // });
                // window.addEventListener('loadDropDownData', event =>
                // {

                //     // alert($('#username').val());

                //     setTimeout(function () {
                //         // $('#first_name').val('');
                //         // $('#last_name').val('');
                //         // $('#mobile').val('');
                //         // $('#username').val(' ');
                //         // $('#email').val('');
                //         // $('#password').val('');
                //         // $('#password_confirmation').val('');
                //         // alert($('#username').val());
                //     }, 1000);
                //     // ApplyAllSelect2();
                //     // Livewire.emit('LoadDataNow');
                // });


                // $('#vendor_id').on('change', function(e)
                // {
                //     alert('awdawd');
                // });

                $(document).on('change', '.Select2DropDown', function (e)
                {
                    // alert('awdawd');
                    const selectedValues = $(this).select2("val");
                    // console.log('Selected Values:', selectedValues);
                    Livewire.emit('UpdateVendorId', $(this).attr('data-id'), selectedValues);
                });

                $('.Select2DropDown').on('change', function(e)
                {
                    // alert('awdawd');
                    // if($(this).attr('data-id') === 'permissions')
                    // {
                    //     console.log('print permissions');
                        const selectedValues = $(this).select2("val");
                        // console.log('Selected Values:', selectedValues);
                        Livewire.emit('UpdatePermissionIds', $(this).attr('data-id'), selectedValues);
                    // }
                });

                function ApplyAllSelect2()
                {
                    const token = getToken();

                    const headers = {
                        "Authorization": `Bearer ${token}`,
                    };

                    $('.multiplePermissions').select2();
                    $('.Select2DropDown').select2();
                    $('#user-select').select2();

                    window.initSelectCompanyDrop=()=>
                    {
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
                window.addEventListener('cart_empty', event =>
                {
                    Swal.fire({
                        icon: 'Error',
                        title: 'No Item Selected',
                        text: 'please select items to add into bill!!',
                    });
                });
                window.addEventListener('no_user_error', event =>
                {
                    Swal.fire({
                        icon: 'Error',
                        title: 'No User Selected',
                        text: 'please select User!!',
                    });
                });
                window.addEventListener('show_users', event =>
                {
                    $('.Select2DropDown').select2();

                    // alert('awd');
                    // Swal.fire({
                    //     icon: 'Error',
                    //     title: 'No Item Selected',
                    //     text: 'please select items to print!!',
                    // });
                });
                window.addEventListener('no_item_selected', event =>
                {
                    Swal.fire({
                        icon: 'Error',
                        title: 'No Item Selected',
                        text: 'please select items to print!!',
                    });
                });
                window.addEventListener('deleted_scene', event =>
                {
                    const id = event.detail.category.id;

                    Swal.fire({
                        icon: 'success',
                        title: 'Receipt Deleted Successfully!',
                        text: `The Receipt ${id} has been deleted.`,
                    });
                })
                window.addEventListener('UnitTypeUpdated', event =>
                {
                    Swal.fire({
                        icon: 'sucess',
                        title: 'Unit Type updated Successfully',
                        text: event.detail.messsage,
                    });

                    // if(event.detail.value == false)
                    // {
                    //     Swal.fire({
                    //         icon: 'sucess',
                    //         title: 'Unit Type updated Successfully',
                    //         text: event.detail.messsage,
                    //     });
                    // }
                    // else
                    // {
                    //     Livewire.emit('saveCourseAlignEvent');
                    // }
                });


    </script>

    <!-- <script src="{{ url_secure('build/js/LivewireDropDownSelect2.js')}}"></script> -->


@endpush
