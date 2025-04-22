


@can('role_add') 
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

                    <form wire:submit.prevent="saveRole">

                        @csrf

                        <!-- =========================== title ========================== -->
                        <div class="col-md-6 col-sm-6 col-xs-12" >
                            <div class="form-group" wire:ignore>
                                <label for="title">Role Title *</label>

                                <input  id="title" 
                                        class="form-control" type="text" 
                                        name="title"
                                        data-rule-required="true" 
                                        data-msg-required="user name field is required"
                                        wire:model.debounce.500ms="role.title"
                                        placeholder="Enter Role Title">
                                <span class="error-container danger w-100"></span>
                            </div>
                        </div>
                        
                        <!-- =========================== Permissions ========================== -->
                        <div class="col-md-6 col-sm-6 col-xs-12" >
                            <div class="form-group" wire:ignore>
                                <label for="permissions">Permissions*
                                        <!-- <span class="btn btn-info btn-xs select-all">Select all</span>
                                        <span class="btn btn-info btn-xs deselect-all">Deselect all</span> -->
                                </label>
                                <select name="permissions[]" id="permissions" class="form-control select2 permissions Select2DropDown multiplePermissions" data-table="permissions" data-table-field="permissions_id" data-id="permissions" multiple="multiple" >
                                    @foreach ($permissionLists as $id => $permissions)
                                        <option value="{{ $id }}"
                                            {{ in_array($id, old('permissions', [])) || (isset($role) && $role->permissions->contains($id)) ? 'selected' : '' }}>
                                            {{ $permissions }} 
                                        </option>
                                    @endforeach
                                </select>
                                <span class="error-container danger w-100"></span>
                            </div>
                        </div>
                        
                        <div class="col-md-12 col-lg-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary"> {{ $update ? 'Update Role' : 'Save Role' }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endcan