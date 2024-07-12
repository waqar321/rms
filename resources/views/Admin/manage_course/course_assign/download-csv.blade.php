@if($update)
    @if($ecom_course_assign->upload_csv)

        <div class="col-md-6 col-lg-6">
             
        </div>
        <div class="col-md-6 col-lg-6">
            <a href="{{ asset('/storage/'.$ecom_course_assign->upload_csv) }}" class="btn btn-info" download>Download CSV to Update</a>
        </div>

    @endif 
@endif 
