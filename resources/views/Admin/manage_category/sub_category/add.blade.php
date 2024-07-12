 
 

 @can('course_sub_category_add') 

<div class="row" id="addCategoryPanel" data-screen-permission-id="17"> 
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            @include('Admin.partial.livewire.X_titles')   
            <div class="x_content {{ $Collapse  }}">
                <!-- Form for creating a Category -->

                @foreach ($errors->all() as $key => $error)
                    <div class="col-mb-12 col-lg-12">
                        <div class="alert alert-danger" style="font-size: 13.5px;">
                            {{ $error }} !!!
                        </div>
                    </div>    
                @endforeach

                <div class="col-mb-12 col-lg-12">
                    <form wire:submit.prevent="saveCategory">

                        @csrf

                        <div class="col-md-6 col-lg-6" wire:ignore.self>
                            <div class="form-group">
                                <label>Parent Category<span class="danger">*</span></label>
                                <select wire:model="ecom_category.parent_id" name="parent_category" id="parent_category" class="form-control">
                                    <!-- <option value="{{ $ecom_category->parent_id ?? '' }}"  {{ $ecom_category->parent_id ? 'selected' : '' }}>{{ $ecom_category->parentCategory->name ?? '- Select a Parent Category -' }}  </option> -->
                                    <!-- @foreach($parent_categories as  $parent_category)
                                        <option value="{{ $parent_category->id }}">{{ $parent_category->name }} </option>
                                    @endforeach  -->

                                    @if($update && $ecom_category->parent_id)
                                            <option value="{{ $ecom_category->parent_id ?? '' }}">  {{ $ecom_category->parent_id ? 'selected' : '' }}>{{ $ecom_category->parentCategory->name ?? '- Select a Parent Category -' }}  </option>                                                    
                                            <option disabled>───────────</option>                                                  
                                        @else
                                            <option value="">-- choose Parent Category --</option>
                                            <option disabled>───────────</option>   
                                        @endif

                                        @foreach($parent_categories as $parent_category)                    
                                                <option value="{{ $parent_category->id }}">{{ $parent_category->name }} </option>
                                        @endforeach 


                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6 ">
                            <div class="form-group">
                                <label>Sub Category Name<span class="danger">*</span></label>
                                <input type="text" wire:model.debounce.500ms="ecom_category.name" id="name" placeholder="Enter Sub Category" class="form-control">
                                <!-- @error('name') <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span> @enderror -->
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6">
                            <div class="row">
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="video">Upload Image</label>
                                        <input type="file" wire:model="photo" id="imageInput" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        @include('Admin.manage_category.category.image')  
                                    </div>
                                </div>
                            </div>
                        </div> 
                        <!-- <div class="col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Category Image</label>
                                    <input type="file" wire:model="photo" id="imageInput"  class="form-control">
                            </div>
                        </div>
                     -->


                        <div class="col-md-12 col-lg-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endcan
