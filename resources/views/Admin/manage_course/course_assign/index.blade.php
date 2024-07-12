@extends('Admin.layout.main')

@push('styles')
    <style>
      

    </style>
@endpush 

@section('content')

        @if(request()->has('id'))
            <div>    
                <livewire:admin.course-assign.index :ecom_course_assign="$ecom_course_assign" />    
            </div>
        @else 
            <div>    
                <livewire:admin.course-assign.index />    
            </div>
        @endif
@endsection 


@push('scripts')


      <script>
             
             $(document).ready(function() 
             {
                // ApplyAllSelect2();
                // console.log('select2 applied ');
                // $('.select2').select2();  


                // $('#addStudentPanel').css('display', 'none'); 

                
                // const url = window.location.search;
                // if (!url) 
                // {

                //     const urlParams = new URLSearchParams(url);
                //     const id = atob(urlParams.get('id'));           
                // }

            });

        
        </script>
  
@endpush



