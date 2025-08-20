@can('permission_add')
<div class="row">
    <div class="col-md-12">
        <div class="x_panel">

            @include('Admin.partial.livewire.X_titles')

            <div class="x_content {{ $Collapse }}"  wire:ignore>
                @if ($errors->any())
                    @foreach ($errors->all() as $key => $error)
                        <div class="col-12">
                            <div class="alert alert-danger">{{ $error }} !!!</div>
                        </div>
                    @endforeach
                @endif


                {{-- Product categories --}}
                <div id="categories" class="row mb-3"></div>

                {{-- Products --}}
                <div id ="items" class="row mb-4"></div>

                <div class="mt-3">
                            <button id="add-to-bill" class="btn btn-warning w-100" style="font-size:30px">
                                Add To Bill
                            </button>

                        <div id="vendor-container" class="mt-3" style="display:none;">
                            <label for="user-select" style="font-size:25px"><strong>Select User:</strong></label>
                            <select id="user-select" class="form-control" style="font-size:18px;">
                            <option value="">-- Choose User --</option>
                            @foreach($users as $listing_user_id => $username)
                                <option value="{{ $listing_user_id }}">{{ $username }}</option>
                            @endforeach
                            </select>
                            <div id="vendor-error" class="text-danger mt-1" style="display:none;">Please select a user</div>
                            {{-- <button id="confirm-vendor" class="btn btn-primary mt-2 w-100" style="font-size:30px">
                            Confirm & Print
                            </button> --}}
                        </div>
                        </div>
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
                            <tbody id="cart-body">
                                <!-- rows will be injected here -->
                            </tbody>
                        </table>
                    </div>

                    <div class="col-md-4">
                        <h4>Summary</h4>
                        <div class="card p-3 shadow-sm" id="summary">
                            <p style="font-size:25px">
                            <strong>Total Items:</strong>
                            <span id="summary-total-items">0</span>
                            </p>
                            <p style="font-size:25px">
                            <strong>Subtotal:</strong> Rs.
                            <span id="summary-subtotal">0</span>
                            </p>
                            <p style="font-size:25px">
                            <strong>Tax (0%):</strong> Rs.
                            <span id="summary-tax">0</span>
                            </p>
                            <h3 style="font-size:25px">
                            <strong>Total:</strong> Rs.
                            <span id="summary-total">0</span>
                            </h3>
                            <hr>
                            <button id="print-slip" class="btn btn-success w-100" style="font-size:25px">
                            Print Slip
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endcan


