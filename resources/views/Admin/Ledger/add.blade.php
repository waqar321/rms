

<div class="row"> 
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            
            @include('Admin.partial.livewire.X_titles')   

            <div class="x_content {{ $Collapse  }}">

                @if ($errors->any())
                    @foreach ($errors->all() as $key => $error)

                        <div class="col-mb-12 col-lg-12">
                            <div class="alert alert-danger" style="font-size: 13.5px;">
                                {{ $error }} !!!
                            </div>
                        </div>    
                    @endforeach
                @endif

                <div class="col-mb-12 col-lg-12">

                    <form wire:submit.prevent="saveCategory">

                        @csrf
                        <!-- =========================== title ========================== -->
                        <div class="col-md-6 col-sm-6 col-xs-12" >
                            <div class="form-group" wire:ignore>
                                <label for="user_role">Select User Role</label>
                                <select class="form-control" id="user_role" name="user_role" required>
                                    <option value="">-- Choose Role --</option>
                                    <option value="customer">Customer</option>
                                    <option value="cashier">Cashier</option>
                                    <option value="boss">Boss</option>
                                    <option value="vendor">Vendor</option>
                                </select>
                                <span class="error-container danger w-100"></span>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12" wire:ignore>
                            <div class="form-group" id="cash_amount_section" >
                                <label for="cash_amount">Cash Amount</label>
                                <input type="number" class="form-control" id="cash_amount" name="amount" value="0.0" step="0.01">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12" >
                            <div class="form-group" wire:ignore>

                                <label for="payment_type">Payment Type</label>
                                <select class="form-control" id="payment_type" name="payment_type" required>
                                    <option value="">-- Select Payment Type --</option>
                                    <option value="cash">Cash</option>
                                    <option value="product_sold">Product Sold</option>
                                    <option value="product_bought">Product Bought</option>
                                </select>
                                <span class="error-container danger w-100"></span>
                            </div>
                        </div>


                        <div class="col-md-6 col-lg-6" wire:ignore>
                            <div class="form-group" id="vendor_item_section" >
                                <label>Item <span class="danger">*</span></label>
                                <select name="item_id" id="item_id" class="form-control">
                                    <option value="">-- Select Item --</option>
                                        @foreach($items as $item_id => $item_name)
                                            <option value="{{ $item_id }}">{{ $item_name }}</option>
                                        @endforeach 
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-6 col-xs-12" wire:ignore>
                            <div class="form-group" id="unit_price_section" >
                                <label for="unit_price">Unit Price</label>
                                <input type="number" class="form-control" id="unit_price" name="unit_price" step="0.01" value="0.0">
                                <span class="error-container danger w-100"></span>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12" wire:ignore>
                            <div class="form-group" id="unit_qty_section" >
                                <label for="unit_qty">Unit Qty</label>
                                <input type="number" class="form-control" id="unit_qty" name="unit_qty" min="0" max="100" step="1" value="0">

                                <!-- <input type="number" class="form-control" id="unit_qty" name="unit_qty" step="0.01" value="0.0"> -->
                                <span class="error-container danger w-100"></span>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12" wire:ignore>
                            <div class="form-group" id="total_amount_section" >
                                <label for="total_amount" class="mt-2">Total Amount</label>
                                <input type="text" class="form-control" id="total_amount" name="amount" value="0.0" readonly>
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-6 col-xs-12" >
                            <div class="form-group" wire:ignore>
                                <label for="details">Payment Details</label>
                                <textarea class="form-control" name="details" id="details" rows="2" required></textarea>
                                <span class="error-container danger w-100"></span>
                            </div>
                        </div>


                        <!-- <div class="mb-3 d-none" id="cashAmountSection">
                            <label for="cash_amount">Cash Amount</label>
                            <input type="number" class="form-control" id="cash_amount" name="amount" value="0.0" step="0.01">
                        </div> -->
                        
                        <div class="col-md-12 col-lg-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary"> {{ $Ledger->id ? 'Update Ledger' : 'Save Ledger' }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
