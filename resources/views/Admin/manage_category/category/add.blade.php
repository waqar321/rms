

@can('course_category_add') 
<div class="row" id="addCategoryPanel" data-screen-permission-id="12"> 
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            @include('Admin.partial.livewire.X_titles')   
            <div class="x_content {{ $Collapse  }}">
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

                        <div class="col-md-6 col-lg-6 Categorylabel">
                            <div class="form-group">
                                <label>Category Name<span class="danger">*</span></label>
                                <input type="text" wire:model.debounce.500ms="ecom_category.name" id="name" placeholder="Please Enter Category" class="form-control">
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
                                <button type="submit" class="btn btn-primary"> {{ $update ? 'Update' : 'Save Category' }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endcan
