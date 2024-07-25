@if($photo && ScanTempDirectory())
    @include('Admin.partial.livewire.imageshow', ['path' => $photo->temporaryUrl()])
    
@elseif($ecom_category->image)
    @php
        $imageUrl = str_replace('category-management', '', $ecom_category->image_path);                                                    
    @endphp
    @include('Admin.partial.livewire.imageshow', ['path' => "/storage/".$imageUrl])
@else
    <label for="imageInput" style="padding-top: 30px;">Please upload image</label>
@endif 