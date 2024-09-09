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

        @if($id != 0 )

            <div>    
                <livewire:admin.partials.sidebar-operation :id="$id"/>      
            </div>
        @else 
        
            <div>    
                <livewire:admin.partials.sidebar-operation :id="$id"/>    
            </div>
        @endif
@endsection 


@push('scripts')

      <script>
             
             $(document).ready(function() 
             {
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
                //     // $('.AddPanel').addClass('collapse');
                //     // $('#addStudentPanel').css('display', 'none'); 
                //     const urlParams = new URLSearchParams(url);
                //     const id = atob(urlParams.get('id'));           
                // }

            });
        </script>

@endpush 