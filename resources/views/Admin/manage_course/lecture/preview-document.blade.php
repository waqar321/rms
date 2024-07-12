@if($document && ScanTempDirectory())


    <label for="document" style="padding-top: 16px;"> 
        <a class="btn btn-danger" href="{{ $document->temporaryUrl() }}" target="_blank">Preview Before Upload</a>
    </label>

@elseif($ecom_lecture->local_document)
    <label for="document" style="padding-top: 16px;;"> 
        <a class="btn btn-danger" href="{{ asset('storage/' . $ecom_lecture->local_document) }}" target="_blank">Preview Document</a>

    </label>
@else
    <label for="imageInput" style="padding-top: 30px;">Please upload document</label>
@endif