@push('styles')
    <style>
        .form-group
        {
            margin-bottom: 12px !important;  
            /* waqar added */
        }
    </style>
@endpush 

@can('user_add') 
    <div class="row" id="DdddepartmentPanel" > 
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

                        <form wire:submit.prevent="saveUser">

                            @csrf
                                        
                            <!-- =========================== first_name ========================== -->
                            <!-- <div class="col-md-6 col-sm-6 col-xs-12" >
                                <div class="form-group">
                                    <label>First Name *</label>
                                    <input type="text" id="first_name" 
                                                        name="first_name"
                                                        class="form-control"
                                                        wire:model.defer="ecom_admin_user.first_name" wire:loading.class="opacity-25"
                                                        placeholder="Enter first name">
                                    <span class="error-container danger w-100"></span>
                                </div>
                            </div> -->
                            <!-- =========================== last_name ========================== -->
                            <!-- <div class="col-md-6 col-sm-6 col-xs-12" >
                                <div class="form-group">
                                    <label for="last_name">Last Name *    <?php 
                                        
                                        // echo "<pre>";
                                        // print_r($SelectedRolesIds);
                                        // echo "</pre>";
                                        // echo $ecom_admin_user->city_id;
                                    ?></label>

                                    <input type="text" id="last_name" 
                                                        name="last_name"
                                                        class="form-control"
                                                        wire:model.defer="ecom_admin_user.last_name" wire:loading.class="opacity-25"
                                                        placeholder="Enter last name">
                                                        
                                    <span class="error-container danger w-100"></span>
                                </div>
                            </div> -->
                            <!-- =========================== employee id ========================== -->
                            <div class="col-md-6 col-sm-6 col-xs-12" >
                                <div class="form-group">
                                    <label for="employee_id">Employee Code <span class="danger">*</span> </label>
                                    <input id="employee_id" wire:model.debounce.500ms="ecom_admin_user.employee_id" class="form-control" type="number"
                                            name="employee_id" placeholder="Please Enter Employee Code" required>
                                </div>
                            </div>
                            <!-- =========================== Replace First Name and Last Name and Added Name   ========================== -->
                            <div class="col-md-6 col-sm-6 col-xs-12" >
                                <div class="form-group">
                                    <label for="fullname">Name <span class="danger">*</span> </label>

                                    <input type="text" id="fullname" 
                                                        name="fullname"
                                                        class="form-control"
                                                        wire:model="ecom_admin_user.full_name" wire:loading.class="opacity-25"
                                                        placeholder="Please Enter Name" required>
                                                        
                                    <span class="error-container danger w-100"></span>
                                </div>
                            </div>
                            <!-- =========================== mobile ========================== -->
                            <div class="col-md-6 col-sm-6 col-xs-12" >
                                <div class="form-group">
                                    <label for="mobile">Mobile  </label>
                                    <input  class="form-control" 
                                            type="text" 
                                            id="mobile" 
                                            wire:model="ecom_admin_user.phone" wire:loading.class="opacity-25"
                                            placeholder="Enter mobile number" 
                                            >
                                    <span class="error-container danger w-100"></span>
                                </div>
                            </div>
                            <!-- =========================== username ========================== -->
                            <!-- <div class="col-md-6 col-sm-6 col-xs-12" >
                                <div class="form-group">
                                    <label for="username">User Name *</label>
                                    <input  class="form-control" 
                                            type="text" 
                                            id="username" 
                                            placeholder="Enter Username"
                                            wire:model.debounce.500ms="ecom_admin_user.username">
                                    <span class="error-container danger w-100"></span>
                                </div>
                            </div> -->
                            <!-- =========================== email ========================== -->
                            <div class="col-md-6 col-sm-6 col-xs-12" >
                                <div class="form-group">
                                    <label for="email">Primary Email <span class="danger">*</span></label>

                                    <input class="form-control" 
                                        type="email" 
                                        id="email" 
                                        wire:model.debounce.500ms="ecom_admin_user.email"  
                                        placeholder="Enter email address">
                                    <span class="error-container danger w-100"></span>
                                </div>
                            </div>
                            <!-- =========================== password ========================== -->
                            <div class="col-md-6 col-sm-6 col-xs-12" >
                                <div class="form-group">
                                    <label for="password">Password <span class="danger">*</span></label>

                                    <input id="password" class="form-control" 
                                                        type="password" 
                                                        autocomplete="off"
                                                        wire:model.defer="password" wire:loading.class="opacity-25"
                                                        placeholder="Enter password"
                                                        >
                                    <span class="error-container danger w-100"></span>
                                </div>
                            </div>
                            <!-- =========================== confirm password ========================== -->
                            <div class="col-md-6 col-sm-6 col-xs-12" >
                                <div class="form-group">
                                    <label for="password_confirmation">Confirm Password <span class="danger">*</span></label>

                                    <input id="password_confirmation" wire:model.debounce.500ms="confirm_password" class="form-control" type="password" placeholder="Enter Confirm password">
                                    <span class="error-container danger w-100"></span>
                                </div>
                            </div>
                            <!-- =========================== country ========================== -->
                            <!-- <div class="col-md-6 col-sm-6 col-xs-12" >
                                <div class="form-group" wire:ignore>
                                    <label>Country </label>
                                    <select class="select2 form-control Select2DropDown" data-table="ecom_country" data-table-field="id" data-id="country" name="country_id" id="country_id" required
                                            tabindex="-1"></select>
                                    <span class="error-container danger w-100"></span>
                                </div>
                            </div> -->
                            <!-- =========================== city ========================== -->
                            <div class="col-md-6 col-sm-6 col-xs-12" >
                                <div class="form-group" wire:ignore>
                                    <label>City <span class="danger">*</span></label>

                                    <select class="select2 form-control Select2DropDown" data-table="ecom_city" data-table-field="" data-id="city_id" name="city_id" id="city_id" 
                                            tabindex="-1">

                                            @if($this->ecom_admin_user->city)
                                                <option value="{{ $this->ecom_admin_user->city_id }}"> {{ $this->ecom_admin_user->city->city_name }} </option>
                                            @endif 
                                    </select>
                                    <span class="error-container danger w-100"></span>
                                </div>
                            </div>
                            <!-- =========================== gender ========================== -->
                            <div class="col-md-6 col-sm-6 col-xs-12" >
                                <div class="form-group">
                                    <label>Gender <span class="danger">*</span> </label>
                                    <select class="select2 form-control gender Select2DropDown" data-table="ecom_admin_user" data-table-field="" data-id="gender_id"  id="gender" tabindex="-1" required>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                    </select>
                                </div>
                            </div>
                            <!-- =========================== Roles ========================== -->
                            <div class="col-md-6 col-sm-6 col-xs-12" >
                                <div class="form-group" wire:ignore>
                                    <label>Role <span class="danger">*</span> </label>
                                    <select name="roles[]" id="roles" class="form-control select2 roles Select2DropDown multipleRoles" data-table="roles" data-table-field="role_id" data-id="roles" multiple="multiple" required>
                                        @foreach ($rolesLists as $id => $roles)
                                            <option value="{{ $id }}"
                                                {{ in_array($id, old('roles', [])) || (isset($ecom_admin_user) && $ecom_admin_user->roles->contains($id)) ? 'selected' : '' }}>
                                                {{ $roles }}
                                            </option>
                                        @endforeach
                                    </select>
                                    
                                    <span class="error-container danger w-100"></span>
                                </div>
                            </div>
                            
                            <div class="col-md-12 col-lg-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary"> {{ $update ? 'Update User' : 'Save User' }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endcan