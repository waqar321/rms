<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Ckeditor in Livewire</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        .ck-editor__editable_inline {
            min-height: 200px;
        }
    </style>
    @livewireStyles
</head>
<body>
    <div id="app">
        <main class="py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header"><h3>Ckeditor in Livewire: Bootstrap Version</h3></div>

                            <div class="card-body">
                                @if (session()->has('message'))
                                    <div class="alert alert-info">
                                        {{ session('message') }}
                                    </div>
                                @endif

                                @yield('content')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    @livewireScripts
    @stack('scripts')
</body>
</html>