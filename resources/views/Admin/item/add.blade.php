

<div class="row"> 
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel" id="x_panel_id">
            
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

                <div class="col-mb-12 col-lg-12 testForm">

                    <form wire:submit.prevent="saveItem">

                        @csrf

                        <!-- =========================== title ========================== -->
                        <div class="col-md-6 col-sm-6 col-xs-12" >
                            <div class="form-group" wire:ignore>
                                <label for="title">Item *</label>

                                <input  id="title" 
                                        class="form-control" type="text" 
                                        name="title"
                                        data-rule-required="true" 
                                        data-msg-required="user name field is required"
                                        wire:model.debounce.500ms="Item.name"
                                        placeholder="Enter Item Name">
                                <span class="error-container danger w-100"></span>
                            </div>
                        </div>
                        
                        <!-- =========================== Category ========================== -->

                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group" wire:ignore>
                                <label for="category">Categories {{ $Item->category_id }} </label>
                                    <select name="category" id="category" 
                                                data-id="category" 
                                                data-table="region"
                                                data-table-field="category"
                                                class="form-control Select2DropDown categoryClass">
                                                
                                            <!-- <option value="" disabled selected style="color: #131212 !important">Select Region </option>  -->
                                            @foreach($categories as $id => $category)     
                                                    <option value="{{ $category->id }}" {{ $category->id == $Item_category_id ? 'selected' : '' }}>
                                                        {{ $category->name }} {{ $Item->category_id }} 
                                                    </option>   
                                            @endforeach  
                                    </select>
                            </div>
                        </div>
                        
                         <!-- =========================== Description ========================== -->

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea id="description" class="form-control"
                                    wire:model.defer="Item.description"
                                    placeholder="Enter item description..."></textarea>
                            </div>
                        </div>


                        <!-- =========================== Unit ========================== -->
                        <!-- <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="unit">Unit</label>
                                <select id="unit" class="form-control" wire:model.defer="Item.unit">
                                    <option value="pcs">Pieces</option>
                                    <option value="plate">Plate</option>
                                    <option value="bottle">Bottle</option>
                                    <option value="glass">Glass</option>
                                </select>
                            </div>
                        </div> -->
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group" wire:ignore>
                                <label for="unittype">Unit Types</label>
                                    <select name="unittype" id="unittype" 
                                                data-id="unittype" 
                                                data-table="region"
                                                data-table-field="unittype"
                                                class="form-control Select2DropDown unittypeClass"
                                                >
                                                
                                                <!-- <option value="" disabled selected style="color: #131212 !important">Select Region </option>  -->
                                            @foreach($unitTypes as $id => $UnitType)     
                                                    <option value="{{ $UnitType->id }}" >
                                                        {{ $UnitType->name }} 
                                                    </option>                           
                                               
                                            @endforeach  
                                    </select>
                            </div>
                        </div>

                        <!-- =========================== Image ========================== -->
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="image">Image</label>
                                <input id="image" class="form-control" type="file"
                                    wire:model="photo" />
                                <small class="form-text text-muted">Optional - Upload item image</small>
                            </div>
                        </div>
                        <!-- =========================== Availability ========================== -->

                        <!-- <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="is_available">Is Available</label>
                                <select id="is_available" class="form-control" wire:model.defer="Item.is_available">
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                        </div> -->
                        
                        
                        <!-- =========================== Price ========================== -->
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="price">Selling Price *</label>
                                <input id="price" class="form-control" type="number" step="0.01"
                                    data-rule-required="true"
                                    data-msg-required="Selling price is required"
                                    wire:model.defer="Item.price"
                                    placeholder="e.g., 299.99" />
                            </div>
                        </div>

                        <!-- =========================== Cost Price ========================== -->
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="cost_price">Cost Price</label>
                                <input id="cost_price" class="form-control" type="number" step="0.01"
                                    wire:model.defer="Item.cost_price"
                                    placeholder="Optional - for profit calculation" />
                            </div>
                        </div>

                        <!-- =========================== Stock Quantity ========================== -->
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="stock_quantity">Stock Quantity</label>
                                <input id="stock_quantity" class="form-control" type="number"
                                    wire:model.defer="Item.stock_quantity"
                                    placeholder="Leave blank if not tracked" />
                            </div>
                        </div>
                        <!-- =========================== Order ========================== -->
                            <div class="col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label for="order">Order <span class="danger">*</span></label>
                                    <input type="number" wire:model.debounce.500ms="Item.order" id="order" placeholder="Enter the order" class="form-control">
                                </div>
                            </div>
                        <!-- =========================== Order ========================== -->
                    



                        
                        <div class="col-md-12 col-lg-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary"> {{ $Item->id ? 'Update Item' : 'Save Item' }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
