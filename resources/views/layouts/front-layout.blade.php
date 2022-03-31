<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- SEO Meta Tags-->
    <meta name="description" content="List your yacht on Yacht Findr">
    <meta name="keywords" content="Yacht, boat">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('front/img/logo.jpg') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('front/img/logo.jpg') }}">
    <link rel="mask-icon" color="#5bbad5" href="safari-pinned-tab.svg">
    <meta name="msapplication-TileColor" content="#766df4">
    <meta name="theme-color" content="#ffffff">
    <link rel="stylesheet" media="screen" href="{{ asset('front/front_assets/simplebar/dist/simplebar.min.css') }}"/>
    <link rel="stylesheet" media="screen" href="{{ asset('front/front_assets/tiny-slider/dist/tiny-slider.css') }}"/>
    <link rel="stylesheet" media="screen" href="{{ asset('front/front_assets/nouislider/dist/nouislider.min.css') }}"/>
    <link rel="stylesheet" media="screen" href="{{ asset('front/front_assets/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css') }}"/>
    <link rel="stylesheet" media="screen" href="{{ asset('front/front_assets/filepond/dist/filepond.min.css') }}"/>
    <link rel="stylesheet" media="screen" href="{{ asset('front/front_assets/lightgallery.js/dist/css/lightgallery.min.css') }}"/>
    <link href="{{ asset('front/css/theme.min.css') }}" rel="stylesheet" media="screen" >
    <link rel="stylesheet" media="screen" href="{{ asset('front/front_assets/toastr/dist/toastr.min.css') }}"/>
    <link href="{{ asset('front/front_assets/summernote/dist/summernote.min.css') }}" rel="stylesheet">
    <link href="{{ asset('front/front_assets/select2-4.1.0/dist/css/select2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('front/front_assets/DataTables/DataTables-1.11.3/css/jquery.dataTables.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('front/front_assets/fontawesome-free-6.0.0-beta3-web/css/all.min.css') }}" rel="stylesheet" />
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" /> -->
    <link rel="stylesheet" media="screen" href="{{ asset('front/front_assets/flag-icons-main/css/flag-icons.min.css') }}"/>
    <link rel="stylesheet"  href="{{ asset('css/front.css') }}"/>
  </head>
<body>
    <div class="page-loading active">
      <div class="page-loading-inner">
        <div class="page-spinner"></div><span>Loading...</span>
      </div>
    </div>
    <main class="page-wrapper">
            <div class="page-loading active d-none" id="loader">
                <div class="page-loading-inner">
                    <div class="page-spinner"></div><span>Loading...</span>
                </div>
            </div>
        @include('layouts.partials.front-header')
        @yield('content')
        @include('auth.partials.auth-modal-box')
    </main>
        @include('layouts.partials.front-footer')


</body>
</html>
