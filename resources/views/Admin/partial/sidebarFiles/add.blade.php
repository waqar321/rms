@push('styles')

    <link href="http://127.0.0.1:8000/vendors/select2/dist/css/select2.min.css" rel="stylesheet">

    <style>
        
        .selectFieldToCentre{
            text-align: center;"
            /* height: 100px; */
        }
        .TitleElement
        {
            width: 90% !important;
        }
        .BodyElement
        {
            width: 193% !important;
        }
        .CkEditorCSSLabel
        {
            padding-left: 10px;
        }
        .CkEditorCSS
        {
            width: 94%;
            margin-left: 9px;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered 
        {
            color: #999 !important;
            line-height: 28px;
        }
        .LabelLoader {
            display: flex;
            align-items: center;
        }
        .LabelLoader label {
            margin-right: 10px; /* Adjust the spacing between label and image if needed */
        }
        .LabelLoader img {
            vertical-align: middle;
        }


    </style>
    
        <!-- 
            <style>

                /* Set height for label and file input field */
                label, input[type="file"] {
                    height: 100%;
                    display: flex;
                    align-items: center; /* Vertically center content */
                }
            </style> 
        -->
@endpush

@can('sidebar_operation_add') 

<div class="row" id="DdddepartmentPanel" data-screen-permission-id="22"> 
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel" >
            
            @include('Admin.partial.livewire.X_titles')   

            <div class="x_content {{ $Collapse  }}">

                @foreach ($errors->all() as $key => $error)
                    @if($error != 'idNames' && $error != 'classNames')
                        <div class="col-mb-12 col-lg-12">
                            <div class="alert alert-danger" style="font-size: 13.5px;">
                                {{ $error }} !!!
                            </div>
                        </div>  
                    @endif   
                @endforeach
               

                <div class="col-mb-12 col-lg-12">
                    <form wire:submit.prevent="SaveSidebar">

                        @csrf

                        <!-- =========================== Parent Menu ========================== -->
                         
                        <div class="col-md-6 col-sm-6 col-xs-12" >
                            <div class="form-group" >
                                <label>Parent Sidebar<span class="danger">*</span></label>                            
                               
                                <select 
                                            wire:ignore 
                                            id="parent_SideBar" 
                                            data-id="parent_SideBar" 
                                            class="form-control select2 Select2DropDown parent_SideBar">

                                    @foreach ($parent_SideBars as $id => $parent_SideBar)
                                        <option value="{{ $parent_SideBar->id }}" 
                                            {{ isset($SideBar) && $SideBar->parent_id == $parent_SideBar->id ? 'selected' : '' }}>
                                            {{ $parent_SideBar->title }} 
                                        </option>
                                    @endforeach
                                    
                                </select>
                                <span class="error-container danger w-100"></span>
                            </div>
                        </div>
                                      
                        <div class="col-md-6 col-lg-6">
                            <div class="form-group">
                                <label for="title">Title <span class="danger">*</span></label>
                                <input type="text" wire:model.debounce.500ms="SideBar.title" id="title" placeholder="Enter the title" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-6">
                            <div class="form-group">
                                <label for="icon">Icon Name 
                                        <span> 
                                            Get Suitable Icon: <a href="https://lab.artlung.com/font-awesome-sample/" target="__blank"class="blink"> Click Me </a>
                                            Replace using format fa fa-class 
                                        </span>
                                </label>
                                <input type="text" wire:model.debounce.500ms="SideBar.icon" id="icon" placeholder="Enter the icon name" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-6">
                            <div class="form-group">
                                <label for="url">URL / Route <span class="danger">*</span></label>
                                <input type="text" wire:model.debounce.500ms="SideBar.url" id="url" placeholder="Enter the URL or route" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-6">
                            <div class="form-group">
                                <label for="idNames">ID Names <span class="danger">*</span></label>
                                <input type="text" wire:model.debounce.500ms="IdNames" id="idNames" placeholder="Enter the ID names" class="form-control">
                                @error('IdNames') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-6">
                            <div class="form-group">
                                <label for="classNames">Class Names<span class="danger">*</span></label>
                                <input type="text" wire:model.debounce.500ms="ClassNames" id="classNames" placeholder="Enter the class names" class="form-control">
                                @error('IdNames') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-6">
                            <div class="form-group">
                                <label for="order">Order <span class="danger">*</span></label>
                                <input type="number" wire:model.debounce.500ms="SideBar.order" id="order" placeholder="Enter the order" class="form-control">
                            </div>
                        </div>
                        
                        <!-- =========================== Permissions ========================== -->

                        <div class="col-md-6 col-sm-6 col-xs-12" >
                            <div class="form-group">
                                <label for="permissions">Select Permission*
                                        <!-- <span class="btn btn-info btn-xs select-all">Select all</span>
                                        <span class="btn btn-info btn-xs deselect-all">Deselect all</span> -->
                                </label>
                                <select 
                                        wire:ignore 
                                        name="permissions[]" 
                                        id="selected_permission" 
                                        data-id="permission" 
                                        class="form-control select2 permissions Select2DropDown multiplePermissions">

                                    @foreach ($permissionLists as $id => $permissions)
                                        <option value="{{ $id }}"
                                            {{ isset($SideBar) && $SideBar->permission_id == $id ? 'selected' : '' }}>
                                            {{ $permissions }} 
                                        </option>
                                    @endforeach  

                                </select>
                                <span class="error-container danger w-100"></span>
                            </div>
                        </div>
                        
              
                        <div class="col-md-12 col-lg-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary"> {{ $update ? 'Update Sidebar' : 'Save Sidebar' }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endcan


@push('scripts')

<script>

    
        // $('.HRDepartment').select2({
        //     placeholder: 'Please Select Department',
        //         allowClear: true
        // });

        // parent_SideBar
        // selected_permission

</script>
@endpush 