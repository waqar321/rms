
    @if($photo && ScanTempDirectory())
        @php
            try {
                $temporaryUrl = $photo->temporaryUrl();
            } catch (Exception $e) {
                $temporaryUrl = null;
            }   
        @endphp

        @if($temporaryUrl)
            @include('Admin.partial.livewire.imageshow', ['path' => $temporaryUrl, 'photo'=>true])
        @endif
        
    @elseif($ecom_course->course_image)
        @include('Admin.partial.livewire.imageshow', [
                                                'path' => "/storage/".str_replace('category-management', '', $ecom_course->course_image),
                                                'photo'=>false
                                            ])
    @else
        <label for="imageInput" style="padding-top: 30px;">Please upload image</label>
    @endif
