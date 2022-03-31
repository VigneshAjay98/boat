<!-- Footer-->
  <footer class="footer bg-dark pt-5">
    <!-- <div class="border-bottom border-light py-4">
      <div class="container d-sm-flex align-items-center justify-content-between"><a class="d-inline-block" href="real-estate-home.html"><img src="/front/img/logo.jpg" width="116" alt="logo"></a>
        <div class="d-flex pt-3 pt-sm-0">
          <div class="dropdown ms-n3">
            <button class="btn btn-light btn-link btn-sm dropdown-toggle fw-normal py-2" type="button" data-bs-toggle="dropdown"><i class="fi-globe me-2"></i>Eng</button>
            <div class="dropdown-menu dropdown-menu-dark w-100"><a class="dropdown-item" href="javascript:0;">Deutsch</a><a class="dropdown-item" href="javascript:0;">Français</a><a class="dropdown-item" href="javascript:0;">Español</a></div>
          </div>
          <div class="dropdown">
            <button class="btn btn-light btn-link btn-sm dropdown-toggle fw-normal py-2 pe-0" type="button" data-bs-toggle="dropdown"><i class="fi-map-pin me-2"></i>New York</button>
            <div class="dropdown-menu dropdown-menu-dark dropdown-menu-sm-end" style="min-width: 7.5rem;"><a class="dropdown-item" href="javascript:0;">Chicago</a><a class="dropdown-item" href="javascript:0;">Dallas</a><a class="dropdown-item" href="javascript:0;">Los Angeles</a><a class="dropdown-item" href="javascript:0;">San Diego</a></div>
          </div>
        </div>
      </div>
    </div> -->
    <div class="container pt-4 pb-3 pt-lg-5 pb-lg-4">
      <div class="row pt-2 pt-lg-0">
        <div class="col-lg-3 pb-2 mb-4">
            <img src="/front/img/logo.jpg" width="116" alt="logo"></a>
          <!-- <h3 class="h5 text-light mb-2">Subscribe to our newsletter</h3>
          <p class="fs-sm text-light opacity-70">Don’t miss any relevant offers!</p>
          <form class="form-group form-group-light w-100">
            <div class="input-group input-group-sm"><span class="input-group-text"> <i class="fi-mail"></i></span>
              <input class="form-control" type="text" placeholder="Your email">
            </div>
            <button class="btn btn-primary btn-icon btn-sm" type="button"><i class="fi-send"></i></button>
          </form> -->
        </div>
        <div class="col-lg-2 col-md-3 col-sm-6 offset-xl-1 mb-2 mb-sm-4">
          <h3 class="fs-base text-light">Buying &amp; Selling</h3>
          <ul class="list-unstyled fs-sm">
            <li><a class="nav-link-light" href="{{ route('explore-yachts') }}">Find a yacht</a></li>
            <li><a class="nav-link-light sell-boats" @if (isset(Auth::user()->id)) href="{{ route('select-plan') }}" @else href="#signInModal" data-bs-toggle="modal" @endif data-user-logged={{ isset(Auth::user()->id)? true : false }} >Sell your yacht</a></li>
          </ul>
        </div>
        <div class="col-lg-2 col-md-3 col-sm-6 mb-2 mb-sm-4">
          <h3 class="fs-base text-light">About</h3>
          <ul class="list-unstyled fs-sm">
            <li><a class="nav-link-light" href="{{ url('about-us') }}">About Finder</a></li>
            <li><a class="nav-link-light" href="{{ url('contact-us') }}">Contact us</a></li>
            <li><a class="nav-link-light" href="javascript:0;">FAQs &amp; support</a></li>
          </ul>
        </div>
        <div class="col-lg-2 col-md-3 col-sm-6 mb-2 mb-sm-4">
          <h3 class="fs-base text-light">Profile</h3>
          <ul class="list-unstyled fs-sm">
            <li><a class="nav-link-light" href="{{ route('profile') }}">My account</a></li>
            <li><a class="nav-link-light" href="{{ route('my-yachts') }}">My Yachts</a></li>
          </ul>
        </div>
        <div class="col-xl-2 col-lg-3 col-sm-6 col-md-3 mb-2 mb-sm-4"><a class="d-flex align-items-center text-decoration-none mb-2" href="tel:4065550120"><i class="fi-device-mobile me-2"></i><span class="text-light">(855) 55-YACHT</span></a><a class="d-flex align-items-center text-decoration-none mb-2" href="mailto:example@email.com"><i class="fi-mail me-2"></i><span class="text-light">support@yachtfindr.com</span></a>
          <div class="d-flex flex-wrap pt-4"><a class="btn btn-icon btn-translucent-light btn-xs rounded-circle mb-2 me-2" href="javascript:0;"><i class="fi-facebook"></i></a><a class="btn btn-icon btn-translucent-light btn-xs rounded-circle mb-2 me-2" href="javascript:0;"><i class="fi-twitter"></i></a><a class="btn btn-icon btn-translucent-light btn-xs rounded-circle mb-2 me-2" href="javascript:0;"><i class="fi-telegram"></i></a><a class="btn btn-icon btn-translucent-light btn-xs rounded-circle mb-2" href="javascript:0;"><i class="fi-messenger"></i></a></div>
        </div>
      </div>
    </div>
    <div class="container d-lg-flex align-items-center justify-content-between fs-sm pb-3">
    <div class="d-flex flex-wrap justify-content-center order-lg-2 mb-3"><a class="nav-link nav-link-light fw-normal" href="javascript:0;">Terms of use</a><a class="nav-link nav-link-light fw-normal" href="javascript:0;">Privacy policy</a>
        {{-- <a class="nav-link nav-link-light fw-normal" href="javascript:0;">Accessibility statement</a><a class="nav-link nav-link-light fw-normal pe-0" href="javascript:0;">Interest based ads</a> --}}
    </div>
      <p class="text-center text-lg-start order-lg-1 mb-lg-0"><span class="text-light opacity-50">&copy;{{ date('Y') }} YachtFindr, All rights reserved.</span></p>
    </div>
  </footer>
      <button class="btn btn-primary btn-sm w-100 rounded-0 fixed-bottom d-lg-none" id="filterButton" type="button" data-bs-toggle="offcanvas" data-bs-target="#filters-sidebar"><i class="fi-filter me-2"></i>Filters</button>

  <!-- Back to top button--><a class="btn-scroll-top" href="#top" data-scroll><span class="btn-scroll-top-tooltip text-muted fs-sm me-2">Top</span><i class="btn-scroll-top-icon fi-chevron-up">   </i></a>

   <!-- Back to top button--><a class="btn-scroll-top" href="#top" data-scroll><span class="btn-scroll-top-tooltip text-muted fs-sm me-2">Top</span><i class="btn-scroll-top-icon fi-chevron-up">   </i></a>
    <!-- Vendor scrits: js libraries and plugins-->
    <script src="{{ asset('/js/front-libraries.js') }}"></script>
    <!-- Main theme script-->
    <script src="{{ asset('/front/js/theme.min.js') }}"></script>
     <!-- Stripe Integration -->
    <!-- <script src="https://js.stripe.com/v3/"></script> -->

    <!-- Custom Scripts -->
    <script>
        var base_url = "{{url('/')}}";
    </script>
    <!-- <script src="{{ asset('/front/js/payment.js') }}" defer></script> -->
    <script src="{{ asset('/front/js/front-common.js') }}" defer></script>

    <!-- Lodding function -->
    <script>
        (function () {
            window.onload = function () {
                var preloader = document.querySelector('.page-loading');
                preloader.classList.remove('active');
                setTimeout(function () {
                    preloader.remove();
                }, 100);
            };
        })();
    </script>

    <!-- Toastr function to append toastr message -->
    @if(Session::has('toastr.alerts'))
        <script async >
            function checkForFashMessage() {
                // This code to stop spinner
                var preloader = document.querySelector('.page-loading');
                preloader.classList.remove('active');
                setTimeout(function () {
                    preloader.remove();
                }, 1000);

                // This code to initialize toastr
                toastr.options = {
                    closeButton: true,
                    progressBar: true,
                    showMethod: 'slideDown',
                    // timeOut: 4000
                };

                // Appending message of toastr
                @foreach(Session::get('toastr.alerts') as $alert)
                    toastr.{{ $alert['type'] }}('{{ $alert['message'] }}' @if( ! empty($alert['title'])), '{{ $alert['title'] }}' @endif);
                @endforeach
            };
            window.onload = checkForFashMessage;
        </script>
    @endif
    @if(!Auth::user() && Session::has('show_login_modal'))
        <script>
            var signInModal = new bootstrap.Modal(document.getElementById('signInModal'), {
                keyboard: false
            });
            var modalToggle = document.getElementById('signInModal') // relatedTarget
            signInModal.show(modalToggle)
        </script>
    @endif
    @if(!Auth::user() && Session::has('show_register_modal'))
        <script>
            var signUnModal = new bootstrap.Modal(document.getElementById('signUpModal'), {
                keyboard: false
            });
            var modalToggle = document.getElementById('signUpModal') // relatedTarget
            signUnModal.show(modalToggle)
        </script>
    @endif
    @if(!Auth::user() && Session::has('show_forgot_password_modal'))
        <script>
            var forgetPasswordModal = new bootstrap.Modal(document.getElementById('resetModal'), {
                keyboard: false
            });
            var modalToggle = document.getElementById('resetModal') // relatedTarget
            forgetPasswordModal.show(modalToggle)
        </script>
    @endif
