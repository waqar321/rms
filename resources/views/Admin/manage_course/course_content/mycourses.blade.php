@extends('Admin.layout.main')

@push('styles')
    <style>
        .close_form
        {
            float: right;
            margin-top: 10px;
        }
        .add_student
        {
            float: right;
            margin-top: 10px;
        }
        .custom-margin-bottom {
            margin-bottom: 1% !important;
        }
    </style>
@endpush 

@section('content')
        <div>    
            <livewire:admin.course-content.my-course />    
        </div>
@endsection 


@push('scripts')

      <script>
             
             $(document).ready(function() 
             {
                // $('#addStudentPanel').css('display', 'none'); 

                $('.add_student').css('display', 'block');
                $('.add_student').addClass('btn btn-primary float-end custom-margin-bottom');
                $('.add_student').text('Add Student');
                
                $('.close_form').css('display', 'none');
                $('.close_form').addClass('btn btn-primary float-end custom-margin-bottom');
                $('.close_form').css('background-color', 'red'); 
                $('.close_form').text('Close Form');
                
                // const url = window.location.search;
                // if (!url) 
                // {

                //     const urlParams = new URLSearchParams(url);
                //     const id = atob(urlParams.get('id'));           
                // }

            });
        </script>

@endpush 