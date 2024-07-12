@extends('Admin.layout.main')

@push('styles')
    <style>
  


    </style>
@endpush 

@section('content')


            <div>    
                <livewire:admin.notification.index />    
            </div>

@endsection


@push('scripts')


    <script>
        
        $(document).ready(function() 
        {
            
        });

    </script>

@endpush