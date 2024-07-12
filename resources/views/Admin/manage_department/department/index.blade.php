@extends('Admin.layout.main')

@push('styles')
    <style>
      
    </style>
@endpush 

@section('content')
        @if(request()->has('id'))
            <div>    
                <livewire:admin.department.index :ecom_department="$ecom_department"/>    
            </div>
        @else 
            <div>    
                <livewire:admin.department.index : />    
            </div>
        @endif
@endsection 


@push('scripts')

      <script>
             
             $(document).ready(function() 
             {

            });
        </script>

@endpush 