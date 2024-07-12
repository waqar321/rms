@extends('Admin.layout.main')

@push('styles')

    <link href="{{ url_secure('build/css/livewire_components_action.css')}}" rel="stylesheet">
    <style>
        /* .select2-container{
            display: block!important;   
            width: 100%!important;
        } */
    </style>
@endpush 

@section('content')


        @section('title') aet Listing  @endsection

        <div class="right_col" role="main">
            <div class="">
                @livewire('product-form', [$product])
            </div>
        </div>


@endsection 
@push('scripts')

        <script>
                var ModuleName = 'test';
                document.addEventListener('livewire:submit', function () {
                    document.getElementById('imageInput').value = '';
                });
        </script>
        <script src="{{ url_secure('build/js/livewire_components_action.js')}}"></script>

@endpush 

