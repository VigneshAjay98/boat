<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">


</head>
<body>
    <div id="app">
        @include('layouts.partials.nav')
        <div class="container mb-4">
        <main class="py-4">
            @yield('content')

            @include('layouts.partials.modal-box')
        </main>
    </div>
    </div>
    <script>
        var base_url = "{{url('/')}}";
    </script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/all.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

    @if(Session::has('toastr.alerts'))
        <script async >
            function checkForFashMessage() {
                    toastr.options = {
                        closeButton: true,
                        progressBar: true,
                        showMethod: 'slideDown',
                        // timeOut: 4000
                    };

                    @foreach(Session::get('toastr.alerts') as $alert)
                        toastr.{{ $alert['type'] }}('{{ $alert['message'] }}' @if( ! empty($alert['title'])), '{{ $alert['title'] }}' @endif);
                    @endforeach
            };

            window.onload = checkForFashMessage;
        </script>
    @endif


</body>
</html>
