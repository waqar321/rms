@if($video && ScanTempDirectory())
    <!-- <label for="video" style="padding-top: 30px;">Video uploaded locally </label> -->
    <label for="video" style="padding-top: 16px;"> 
        <a class="btn btn-danger" href="{{ $video->temporaryUrl() }}" target="_blank">Preview Before Upload</a>
        <!-- <button type="button" wire:click="removeVideo()" class="btn btn-danger mt-2">Remove Video</button>  -->
    </label>
       
@elseif($ecom_course->local_video)
    <label for="video" style="padding-top: 16px;"> 
        <a class="btn btn-danger" href="{{ asset('storage/' . $ecom_course->local_video) }}" target="_blank">Preview Video</a>
    </label>
    <!-- <button type="button" wire:click="removeVideo()" class="btn btn-danger mt-2">Remove Video</button>  -->
    <!-- <label for="video" style="padding-top: 30px;">Video found in db </label> -->
@else
    <label for="video" style="padding-top: 30px;">Please upload Video</label>
@endif