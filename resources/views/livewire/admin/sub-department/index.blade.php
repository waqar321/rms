@push('styles')

    <link href="{{ url_secure('build/css/livewire_components_action.css')}}" rel="stylesheet">
    <style>
        /* .select2-container{
            display: block!important;   
            width: 100%!important;
        } */
    </style>
@endpush 


        @if($MainTitle == 'SubDepartment')
            @php
                $JsMainTitle = $MainTitle;
                $MainTitle = preg_split('/(?=[A-Z])/', $MainTitle);
                $MainTitle = $MainTitle[1] . ' ' . $MainTitle[2];
            @endphp
        @endif
     

        @section('title') {{ $MainTitle }} Listing  @endsection

        <div class="right_col" role="main">
            <div class="">

                @include('Admin.partial.livewire.header')   

                @include('Admin.manage_department.sub_department.add') 

                @include('Admin.manage_department.sub_department.list') 

            </div>
        </div>
     
@push('scripts')

        <script>
                var ModuleName = '{!! $JsMainTitle !!}';
                $(document).ready(function()
                {
                    // alert(ModuleName);
                });

                // var ModuleName = '{!! $MainTitle !!}';

                document.addEventListener('livewire:submit', function () {
                    document.getElementById('imageInput').value = '';
                });
        </script>
        <script src="{{ url_secure('build/js/livewire_components_action.js')}}"></script>

@endpush 
