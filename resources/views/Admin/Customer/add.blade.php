

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
                                <label for="name">Customer Name *</label>

                                <input  id="name" 
                                        class="form-control" type="text" 
                                        name="name"
                                        data-rule-required="true" 
                                        data-msg-required="user name field is required"
                                        wire:model.debounce.500ms="Customers.name"
                                        placeholder="Enter Customer Name">
                                <span class="error-container danger w-100"></span>
                            </div>
                        </div>

                        <!-- Phone -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input id="phone" class="form-control" type="text" wire:model.defer="Customer.phone" placeholder="Enter Phone Number">
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input id="email" class="form-control" type="email" wire:model.defer="Customer.email" placeholder="Enter Email">
                            </div>
                        </div>

                        <!-- Address -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="address">Address</label>
                                <input id="address" class="form-control" type="text" wire:model.defer="Customer.address" placeholder="Enter Address">
                            </div>
                        </div>

                        <!-- City -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="city">City</label>
                                <input id="city" class="form-control" type="text" wire:model.defer="Customer.city" placeholder="Enter City">
                            </div>
                        </div>

                        <!-- CNIC -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="cnic">CNIC</label>
                                <input id="cnic" class="form-control" type="text" wire:model.defer="Customer.cnic" placeholder="Enter CNIC">
                            </div>
                        </div>

                        <!-- Gender -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="gender">Gender</label>
                                <select id="gender" class="form-control" wire:model.defer="Customer.gender">
                                    <option value="">-- Select Gender --</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                        </div>

                        <!-- Date of Birth -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="dob">Date of Birth</label>
                                <input id="dob" class="form-control" type="date" wire:model.defer="Customer.dob">
                            </div>
                        </div>

                        <!-- Total Spent -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="total_spent">Total Spent</label>
                                <input id="total_spent" class="form-control" type="number" step="0.01" wire:model.defer="Customer.total_spent" placeholder="0.00">
                            </div>
                        </div>

                        <!-- Visits -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="visits">Visits</label>
                                <input id="visits" class="form-control" type="number" wire:model.defer="Customer.visits" placeholder="0">
                            </div>
                        </div>

                        <!-- Is Active -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="is_active">Status</label>
                                <select id="is_active" class="form-control" wire:model.defer="Customer.is_active">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>
                        
                        
                        <div class="col-md-12 col-lg-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary"> {{ $Customer->id ? 'Update Unit Type' : 'Save Unit Type' }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
