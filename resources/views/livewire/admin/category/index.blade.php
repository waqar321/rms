@push('styles')

    <link href="{{ url_secure('build/css/livewire_components_action.css')}}" rel="stylesheet">
    <style>
        /* .select2-container{
            display: block!important;   
            width: 100%!important;
        } */
    </style>
@endpush 

        @section('title') {{ $MainTitle }} Listing  @endsection

        <div class="right_col" role="main">
            <div class="">

                @include('Admin.partial.livewire.header')                

                @include('Admin.manage_category.category.add')      

                @include('Admin.manage_category.category.list') 

            </div>
        </div>
     
@push('scripts')

        <script>
                var ModuleName = '{!! $MainTitle !!}';
                document.addEventListener('livewire:submit', function () {
                    document.getElementById('imageInput').value = '';
                });
        </script>
        <script src="{{ url_secure('build/js/livewire_components_action.js')}}"></script>

@endpush 
