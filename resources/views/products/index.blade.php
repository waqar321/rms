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

            <a href="{{ route('products.create') }}?design=bootstrap" class="btn btn-primary">Create</a>

                <table class="table mt-4">
                    <thead>
                        <tr>
                            <th class="col">
                            <blockquote><h3><a href="https://www.google.com"><i><strong>Asim Product descriptionawdawd</strong></i></a></h3></blockquote>
                            </th>
                            <th class="col"></th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($products as $product)
                            <tr class="bg-white">
                                <td>
                                    {{ $product->name }}
                                </td>
                                <td>
                                    <a href="{{ route('products.edit', $product) }}?design=bootstrap" class="btn btn-primary">Edit</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

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





