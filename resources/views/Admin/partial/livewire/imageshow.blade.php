<!-- <div class="col-md-6 col-lg-6">

</div>
<div class="col-md-6 col-lg-6"> -->
    <!-- <div class="form-group"> -->
        <label style="padding-top: 8px;">

            @if(isset($ecom_category))
                <img src="{{ $path }}" style="width: 70px; height: 45px;" class="me-4 selected-photo" data-category-id="{{$ecom_category->id }}" alt="Selected Image">
            @endif

            @if(isset($ecom_course))
                <img src="{{ $path }}" style="width: 70px; height: 45px;" class="me-4 selected-photo" data-category-id="{{$ecom_course->id }}" alt="Selected Image">
            @endif
            @if(isset($Setting))
                <img src="{{ $path }}" style="width: 70px; height: 45px;" class="me-4 selected-photo" data-category-id="{{$Setting->id }}" alt="Selected Image">
            @endif

            <button type="button" wire:click="removeImage()" class="btn btn-danger mt-2">Remove Image</button>
        </label>
    <!-- </div> -->
<!-- </div> -->
