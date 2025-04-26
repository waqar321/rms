@can('permission_add')
<div class="row">
    <div class="col-md-12">
        <div class="x_panel">

            @include('Admin.partial.livewire.X_titles')

            <div class="x_content {{ $Collapse }}">
                @if ($errors->any())
                    @foreach ($errors->all() as $key => $error)
                        <div class="col-12">
                            <div class="alert alert-danger">{{ $error }} !!!</div>
                        </div>
                    @endforeach
                @endif

                {{-- Product Selection --}}
                    <div class="row mb-3">
                        @foreach($categories as $category)
                            <div class="col-auto mb-2">
                                <button 
                                    wire:click="selectCategory({{ $category->id }})"
                                    class="btn {{ $selectedCategory == $category->id ? 'btn-primary' : 'btn-outline-primary' }}">
                                    {{ $category->name }}
                                </button>
                            </div>
                        @endforeach
                    </div>
       

                {{-- Product Selection --}}
                
                <div class="row mb-4">
                    <!-- <h4>Select Items</h4> -->
                    @foreach($items as $item)
                        @if($selectedCategory == $item->Category->id)

                            @php
                                $isSelected = isset($cart[$item->id]);
                            @endphp
                            
                            <div class="col-md-2 col-sm-3 mb-3">
                                <div class="card text-center {{ $isSelected ? 'bg-success text-white' : '' }}" style="cursor:pointer;" wire:click="addItem({{ $item->id }})">
                                    <div class="card-body p-2">
                                        {{-- Item Image --}}
                                        <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}" class="img-fluid mb-2" style="max-height: 80px; object-fit: cover;">
                                        <h3 class="card-title mb-1">{{ $item->name }}</h3>
                                        <small class="text-muted">Rs. {{ number_format($item->price) }}</small>
                                    </div>
                                </div>
                            </div>
                        @endif 
                    @endforeach

                    <?php  
                        // echo "<pre>";
                        //     print_r($cart);
                        // echo "<pre>";
                    ?>  

                </div>

                <div class="mt-3">
                        <button wire:click="showVendorBill" class="btn btn-warning w-100" style="font-size: 30px">
                            Vendor Bill
                        </button>

                        @if($showVendorDropdown)
                            <div class="mt-3">
                                <label for="vendorSelect" style="font-size: 25px"><strong>Select Vendor:</strong></label>
                                <select wire:model="selectedVendor" id="vendorSelect" class="form-control">
                                    <option value="">-- Choose Vendor --</option>
                                    @foreach($vendors as $vendor)
                                        <option value="{{ $vendor->id }}">{{ $vendor->name }}</option>
                                    @endforeach
                                </select>

                                @error('selectedVendor') 
                                    <div class="text-danger mt-1">{{ $message }}</div> 
                                @enderror

                                <button wire:click="addToVendorLedger" class="btn btn-primary mt-2 w-100" style="font-size: 30px">
                                    Add to Vendor Ledger
                                </button>
                            </div>
                        @endif
                    </div>


                {{-- Cart & Calculation --}}
                 <div class="row mt-4">
                    <div class="col-md-8">
                        <!-- <h4>Cart</h4>    -->
                        <table class="table table-bordered table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Image</th>
                                    <th>Item</th>
                                    <th>Qty</th>
                                    <th>Price</th>
                                    <th>Subtotal</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                @forelse($cart as $index => $cartItem)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td> <img src="{{ asset('storage/' . $cartItem['image_path']) }}" alt="{{ $cartItem['name'] }}" class="img-fluid mb-2" style="max-height: 80px; object-fit: cover;"></td>
                                        <td style='font-size: 25px'>{{ $cartItem['name'] }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-sm btn-secondary" wire:click="decreaseQty({{ $cartItem['id'] }})">-</button>
                                                <button type="button" class="btn btn-sm btn-light" disabled>{{ $cartItem['qty'] }}</button>
                                                <button type="button" class="btn btn-sm btn-secondary" wire:click="increaseQty({{ $cartItem['id'] }})">+</button>
                                            </div>
                                        </td>
                                        <td style='font-size: 25px'>Rs. {{ number_format($cartItem['price']) }}</td>
                                        <td style='font-size: 25px'>Rs. {{ number_format($cartItem['price'] * $cartItem['qty']) }}</td>
                                        <td>
                                            <button class="btn btn-danger btn-sm" wire:click="removeItem({{ $cartItem['id'] }})">x</button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="6" class="text-center text-muted">No items selected.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="col-md-4">
                        <h4>Summary</h4>
                        <div class="card p-3 shadow-sm">
                            <p style='font-size: 25px'><strong>Total Items:</strong> {{ $totalItems }}</p>
                            <p style='font-size: 25px'><strong>Subtotal:</strong> Rs. {{ number_format($subtotal) }}</p>
                            <p style='font-size: 25px'><strong>Tax (0%):</strong> Rs. 0</p>
                            <h3><strong>Total:</strong> Rs. {{ number_format($subtotal) }}</h3>
                            <hr>
                            <!-- <button wire:click="checkout" class="btn btn-success w-100">Checkout</button> -->
                            <button style='font-size: 25px' wire:click="printOut" class="btn btn-success w-100">Print Slip</button>
                        </div>
                    </div>
                </div> 

            </div>
        </div>
    </div>
</div>
@endcan
