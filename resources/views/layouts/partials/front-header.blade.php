<!-- Navbar-->
<header class="navbar navbar-expand-lg navbar-light fixed-top shadow" data-scroll-header>
  	<div class="container">
		<a class="navbar-brand me-3 me-xl-4" href="{{ url('/') }}">
			<img class="d-block" src="{{ asset('front/img/logo.jpg') }}" width="116" alt="Finder">
		</a>
		<button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		@guest
            <!--Login Desktop View-->
			<a class="btn sign-in-btn btn-sm d-none d-lg-block order-lg-4 user-sign-in" style="color:black;" href="#signInModal" data-bs-toggle="modal"><i class="fi-user me-3"></i>Sign in</a>
		@else
            <!--Auth User Desktop View-->
			<div class="dropdown d-none d-lg-block order-lg-5 my-n2 me-2">
				<a class="d-block py-2" href="{{ route('profile') }}">
					<img class="rounded-circle profile-image-circle" src="{{ asset(Auth::user()->image) }}"  alt="{{ Auth::user()->full_name ?? Auth::user()->email }}" onerror="this.onerror=null;this.src='{{ asset("/front/img/avatars/default-avatar.png") }}'">
				</a>
				<div class="dropdown-menu dropdown-menu-dark dropdown-menu-end">
					<div class="d-flex align-items-start border-bottom border-light px-3 py-1 mb-2" style="width: 16rem;"><img class="rounded-circle" src="{{ asset(Auth::user()->image) }}" width="48" alt="{{ Auth::user()->full_name }}" onerror="this.onerror=null;this.src='{{ asset("/front/img/avatars/default-avatar.png") }}'">
						<div class="ps-2">
				            @if (Auth::user()->full_name != ' ')
				                <h6 class="fs-base text-light mb-0">{{ Auth::user()->full_name }}</h6>
                                <div class="fs-xs py-2">
                                    @if(isset(Auth::user()->contact_number))
                                        {{ Auth::user()->contact_number ?? '' }}
                                        <br>
                                    @endif
                                        {{ Auth::user()->email }}
                                </div>
                            @else
                                <h6 class="fs-base text-light mb-0">{{ Auth::user()->email }}</h6>
                                <div class="fs-xs py-2">{{ Auth::user()->contact_number }}</div>
                            @endif
						</div>
					</div>
                    @if(Auth::user()->role == 'user')
                        <a class="dropdown-item" href="{{ route('profile') }}"><i class="fi-user me-2"></i>Personal Info</a>
                        <a class="dropdown-item" href="{{ route('security') }}"><i class="fi-lock me-2"></i>Password &amp; Security</a>
                        <a class="dropdown-item" href="{{ url('/my-yachts') }}"><i class="fi-car me-2"></i>My Yachts</a>
                        <a class="dropdown-item" href="{{ url('/favorite-yachts') }}"><i class="fi-heart me-2"></i>My Favorites</a>
			        @endif
                    @if(Auth::user()->role == 'admin')
                        <a class="dropdown-item" href="{{ route('profile') }}"><i class="fi-user me-2"></i>Admin Panel</a>
                    @endif
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        {{ __('Sign Out') }}
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                    </form>
				</div>
			</div>
		@endguest

        <!--Sell Your boat Desktop View-->
		<a class="btn btn-primary btn-sm ms-2 order-lg-4 sell-boats mt-2"  @if (isset(Auth::user()->id)) href="{{ route('select-plan') }}" @else href="#signInModal" data-bs-toggle="modal" @endif data-user-logged={{ isset(Auth::user()->id)? true : false }}><i class="fi-plus me-2"></i>Sell Your Yacht</a>

        <!-- Currency Code Desktop View-->

        @php
            $currancyInformation = config('yatchfindr.defaults.CURRENCY_CODES') ?? [];
        @endphp
        @if (!empty($currancyInformation) && isset($currancyInformation))
            @php
                $countryName = session('USER_COUNTRY') ?? 'United States';
                $currentCountryData = $currancyInformation[$countryName];
                unset($currancyInformation[$countryName]);
            @endphp
            <div class="nav-item dropdown  order-lg-4  d-sm-none d-none d-md-block d-lg-block d-xl-block me-1">
                <a class="nav-link dropdown-toggle" href="javascript:0;" id="dropdown09" data-bs-toggle="dropdown" aria-expanded="false">
                    <span class="fi fi-{{ $currentCountryData['flag_code'] }} default-country" data-name="{{ $countryName }}" data-code="{{ session('USER_CURRENCY') ?? 'USD' }}"> </span> {{ session('USER_CURRENCY') ?? 'USD' }}
                </a>
                <div class="dropdown-menu" aria-labelledby="dropdown09">
                    @foreach($currancyInformation as $key => $value)
                        <a class="dropdown-item set-country" href="javascript:0;" data-name="{{ $key }}" data-code="{{ $value['currency_code'] ?? '' }}" id="{{ $value['flag_code'] ?? '' }}"><span class="fi fi-{{ $value['flag_code'] ?? '' }}"> </span>  {{ $value['currency_code'] ?? '' }}</a>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Navbar Mobile View-->
        <div class="collapse navbar-collapse order-lg-3" id="navbarNav">
			<ul class="navbar-nav navbar-nav-scroll" style="max-height: 35rem;">
				<li class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}"><a class="nav-link" href="{{ url('/') }}">Home</a></li>
				@auth
                    <li class="nav-item d-lg-none"><a class="nav-link" href="{{ route('profile') }}">Personal Info</a></li>
                    <li class="nav-item d-lg-none"><a class="nav-link" href="{{ route('security') }}">Password &amp; Security</a></li>
                    <li class="nav-item d-lg-none"><a class="nav-link" href="{{ url('/my-yachts') }}">My Yachts</a></li>
                    <li class="nav-item d-lg-none"><a class="nav-link" href="{{ url('/favorite-yachts') }}">My Favorites</a></li>
                @endauth
                <li class="nav-item {{ request()->routeIs('explore-yachts') ? 'active' : '' }}"><a class="nav-link" href="{{url('explore/yachts')}}">Explore Yachts</a></li>
				<li class="nav-item {{ request()->routeIs('explore-brands') ? 'active' : '' }}"><a class="nav-link" href="{{ url('explore/brands') }}">Brands</a></li>
				<!-- <li class="nav-item {{ request()->routeIs('explore-categories') ? 'active' : '' }}"><a class="nav-link" href="{{url('explore/categories')}}">Explore Categories</a></li> -->
				<li class="nav-item {{ request()->routeIs('about-us') ? 'active' : '' }}"><a class="nav-link" href="{{ url('/pages/about-us') }}">About Us</a></li>
				</li>

                <!-- Currency code Mobile View-->
                @php
                    $currancyInformation = config('yatchfindr.defaults.CURRENCY_CODES') ?? [];
                @endphp

                @if (!empty($currancyInformation) && isset($currancyInformation))
                    @php
                        $countryName = session('USER_COUNTRY') ?? 'United States';
                        $currentCountryData = $currancyInformation[$countryName];
                        unset($currancyInformation[$countryName]);
                    @endphp
                    <li class="nav-item dropdown order-lg-6 d-sm-block d-xs-block d-md-none d-lg-none d-xl-none d-xxl-none">
                        <a class="nav-link dropdown-toggle" href="#" id="scrollCountryDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="fi fi-{{ $currentCountryData['flag_code'] }} default-country" data-name="{{ $countryName }}" data-code="{{ session('USER_CURRENCY') ?? 'USD' }}"> </span>  {{ session('USER_CURRENCY') ?? 'USD' }}
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="scrollCountryDropdown">
                            @foreach($currancyInformation as $key => $value)
                                <li><a class="dropdown-item set-country" href="javascript:0;" data-name="{{ $key }}" data-code="{{ $value['currency_code'] ?? '' }}" id="{{ $value['flag_code'] ?? '' }}"><span class="fi fi-{{ $value['flag_code'] ?? '' }}"> </span>  {{ $value['currency_code'] ?? '' }}</a></li>
                            @endforeach
                        </ul>
                    </li>
                @endif

                <!-- Sign In Mobile View-->
                @guest
				    <li class="nav-item d-lg-none user-sign-in"><a class="nav-link" href="#signInModal" data-bs-toggle="modal"><i class="fi-user me-2"></i>Sign in</a></li>
                @else
                <!--Log Out Mobile View-->
                    <li class="nav-item d-lg-none">
                        <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Sign Out
                        </a>
                    </li>
                @endguest
            </ul>
		</div>
  	</div>
</header>
