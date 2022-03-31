@php
    $uri = $_SERVER['REQUEST_URI'];
    $uri = explode('/', $uri);
@endphp
<!-- Sidebar-->
<aside class="col-lg-4 col-md-5 pe-xl-4 mb-5">
    <!-- Account nav-->
    <div class="card card-body card-dark border-0 shadow-sm pb-1 me-lg-1" id="frontSideBar">
        <div class="d-flex d-md-block d-lg-flex align-items-start pt-lg-2 mb-4">
            <img class="rounded-circle profile-image-circle" src="{{ url(isset(Auth::user()->image) ? Auth::user()->image : '') }}"  alt="{{ Auth::user()->short_full_name ?? '' }}" onerror="this.onerror=null;this.src='{{ url('front/img/avatars/default-avatar.png') }}'">
            <div class="pt-md-2 pt-lg-0 ps-3 ps-md-0 ps-lg-3">
                <h2 class="fs-lg text-dark mb-0">{{ $user->full_name ?? ''}}</h2>
                <ul class="list-unstyled fs-sm mt-2 mb-0">
                    @if (isset($user->contact_number))
                        <li><a class="nav-link-dark fw-normal" href="tel:{{ $user->contact_number  ?? ''}}"><i class="fi-phone opacity-60 me-2"></i>{{ $user->contact_number  ?? ''}}</a></li>
                    @endif
                    @if (isset($user->email))
                        <li><a class="nav-link-dark fw-normal" href="mailto:{{ $user->email ?? ''}}"><i class="fi-mail opacity-60 me-2"></i>{{ $user->email ?? ''}}</a></li>
                    @endif
                </ul>
            </div>
        </div>
        <a class="btn btn-primary btn-lg w-100 mb-3" href="{{ route('select-plan') }}"><i class="fi-plus me-2"></i>Sell Your Yacht</a><a class="btn btn-outline-dark d-block d-md-none w-100 mb-3" href="#account-nav" data-bs-toggle="collapse"><i class="fi-align-justify me-2"></i>Menu</a>
        <div class="collapse d-md-block mt-3" id="account-nav">
            <div class="card-nav">
                <a class="card-nav-link {{ request()->routeIs('profile') ? 'active' : '' }}" href="{{ url('/profile') }}"><i class="fi-user me-2"></i>Personal Info</a>
                <a class="card-nav-link {{ request()->routeIs('security') ? 'active' : '' }}" href="{{ url('/security') }}"><i class="fi-lock me-2"></i>Password &amp; Security</a>
                <a class="card-nav-link {{ request()->routeIs('my-yachts') ? 'active' : '' }}" href="{{ url('/my-yachts') }}"><i class="fi-car me-2"></i>My Yachts</a>
                <a class="card-nav-link {{ request()->routeIs('favorite-yachts') ? 'active' : '' }}" href="{{ url('/favorite-yachts') }}"><i class="fi-heart me-2"></i>My Favorites</a>
                <a class="card-nav-link {{ request()->routeIs('blocked-yachts') ? 'active' : '' }}" href="{{ url('/blocked-yachts') }}"><i class="fi-alert-circle me-2"></i>My Blocked Yachts</a>
                <!-- <a class="card-nav-link {{ request()->routeIs('my-orders') ? 'active' : '' }}" href="{{ url('/my-orders') }}"><i class="fi-cart me-2"></i>My Orders</a> -->
                <a class="card-nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logOutForm').submit();"><i class="fi-logout me-2"></i>Sign Out</a>
                <form id="logOutForm" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>
    </div>
</aside>
