<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Finder | Car Finder | 404 Not Found</title>
    <!-- SEO Meta Tags-->
    <meta name="description" content="Finder - Directory &amp; Listings Bootstrap Template">
    <meta name="keywords" content="bootstrap, business, directory, listings, e-commerce, car dealer, city guide, real estate, job board, user account, multipurpose, ui kit, html5, css3, javascript, gallery, slider, touch">
    <meta name="author" content="Createx Studio">
    <!-- Viewport-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicon and Touch Icons-->
    <link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('front/img/logo.jpg') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('front/img/logo.jpg') }}">
    <link rel="manifest" href="site.webmanifest">
    <link rel="mask-icon" color="#5bbad5" href="safari-pinned-tab.svg">
    <meta name="msapplication-TileColor" content="#766df4">
    <meta name="theme-color" content="#ffffff">
    <!-- Page loading styles-->
    <style>
      .page-loading {
        position: fixed;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 100%;
        -webkit-transition: all .4s .2s ease-in-out;
        transition: all .4s .2s ease-in-out;
        background-color: #1f1b2d;
        opacity: 0;
        visibility: hidden;
        z-index: 9999;
      }
      .page-loading.active {
        opacity: 1;
        visibility: visible;
      }
      .page-loading-inner {
        position: absolute;
        top: 50%;
        left: 0;
        width: 100%;
        text-align: center;
        -webkit-transform: translateY(-50%);
        transform: translateY(-50%);
        -webkit-transition: opacity .2s ease-in-out;
        transition: opacity .2s ease-in-out;
        opacity: 0;
      }
      .page-loading.active > .page-loading-inner {
        opacity: 1;
      }
      .page-loading-inner > span {
        display: block;
        font-size: 1rem;
        font-weight: normal;
        color: #fff;;
      }
      .page-spinner {
        display: inline-block;
        width: 2.75rem;
        height: 2.75rem;
        margin-bottom: .75rem;
        vertical-align: text-bottom;
        border: .15em solid #9691a4;
        border-right-color: transparent;
        border-radius: 50%;
        -webkit-animation: spinner .75s linear infinite;
        animation: spinner .75s linear infinite;
      }
      @-webkit-keyframes spinner {
        100% {
          -webkit-transform: rotate(360deg);
          transform: rotate(360deg);
        }
      }
      @keyframes spinner {
        100% {
          -webkit-transform: rotate(360deg);
          transform: rotate(360deg);
        }
      }

    </style>
    <!-- Page loading scripts-->
    <script>
      (function () {
        window.onload = function () {
          var preloader = document.querySelector('.page-loading');
          preloader.classList.remove('active');
          setTimeout(function () {
            preloader.remove();
          }, 2000);
        };
      })();

    </script>
    <!-- Vendor Styles-->
    <link rel="stylesheet" media="screen" href="{{ asset('front/vendor/simplebar/dist/simplebar.min.css') }}"/>
    <!-- Main Theme Styles + Bootstrap-->
    <link rel="stylesheet" media="screen" href="{{ asset('front/css/theme.min.css') }}">
  </head>
  <!-- Body-->
  <body class="bg-dark">
    <!-- Page loading spinner-->
    <div class="page-loading active">
      <div class="page-loading-inner">
        <div class="page-spinner"></div><span>Loading...</span>
      </div>
    </div>
    <main class="page-wrapper">
      <!-- Page content-->
      <section class="d-flex align-items-center position-relative min-vh-100 py-5">
        <!-- Bg overlay--><span class="position-absolute top-50 start-50 translate-middle zindex-1 rounded-circle mt-sm-0 mt-n5" style="width: 50vw; height: 50vw; background-color: rgba(83, 74, 117, 0.3); filter: blur(6.4vw);"></span>
        <!-- Overlay content-->
        <div class="container d-flex justify-content-center position-relative zindex-5 text-center">
          <div class="col-lg-8 col-md-10 col-12 px-0">
            <h1 class="display-1 mb-lg-5 mb-4 text-light">Oops!</h1>
            <div class="ratio ratio-16x9 mx-auto mb-lg-5 mb-4 py-4" style="max-width: 556px;">
              <lottie-player class="py-4" src="{{ asset('front/json/animation-car-finder-404.json') }}" background="transparent" speed="1" loop autoplay></lottie-player>
            </div>
            <p class="h2 mb-lg-5 mb-4 pb-2 text-light">The requested page doesn’t exist</p><a class="btn btn-lg btn-primary w-sm-auto w-100 mb-3 me-sm-4"  href="{{ url('/') }}">Go to homepage</a><a class="btn btn-lg btn-outline-light w-sm-auto w-100 mb-3" href="{{ url('contact-us')}}">Contact us</a>
          </div>
        </div>
      </section>
    </main>
    <!-- Back to top button--><a class="btn-scroll-top" href="#top" data-scroll><span class="btn-scroll-top-tooltip text-muted fs-sm me-2">Top</span><i class="btn-scroll-top-icon fi-chevron-up">   </i></a>
    <!-- Vendor scrits: js libraries and plugins-->
    <script src="{{ asset('front/vendor/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('front/vendor/simplebar/dist/simplebar.min.js') }}"></script>
    <script src="{{ asset('front/vendor/smooth-scroll/dist/smooth-scroll.polyfills.min.js') }}"></script>
    <script src="{{ asset('front/vendor/@lottiefiles/lottie-player/dist/lottie-player.js') }}"></script>
    <!-- Main theme script-->
    <script src="{{ asset('front/js/theme.min.js') }}"></script>
  </body>
</html>