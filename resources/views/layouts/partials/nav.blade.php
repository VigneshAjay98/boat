<nav class="navbar navbar-expand-lg navbar-light bg-white shadow">
  	<div class="container">
	  <a class="navbar-brand" href="{{ url('/admin/dashboard') }}">
	  	<img src="{{url('images/yatch-logo.png')}}">
	  </a>
		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarText">
			<ul class="navbar-nav me-auto mb-2 mb-lg-0">
				@if(Auth()->check())
					@if(Auth()->user()->role=='admin')
						<li class="nav-item">
							<a class="nav-link fw-bold" href="{{ url('/admin/users') }}">{{ __('Users') }}</a>
						</li>
						<li class="nav-item">
							<a class="nav-link fw-bold" href="{{ url('/admin/options') }}">{{ __('Options') }}</a>
						</li>
						<li class="nav-item">
							<a class="nav-link fw-bold" href="{{ url('/admin/categories') }}">{{ __('Categories') }}</a>
						</li>
						<li class="nav-item">
							<a class="nav-link fw-bold" href="{{ url('/admin/brands') }}">{{ __('Brands') }}</a>
						</li>
						<li class="nav-item">
							<a class="nav-link fw-bold" href="{{ url('/admin/models') }}">{{ __('Models') }}</a>
						</li>
                        <li class="nav-item">
							<a class="nav-link fw-bold" href="{{ url('/admin/coupons') }}">{{ __('Coupons') }}</a>
						</li>
                        <li class="nav-item">
							<a class="nav-link fw-bold" href="{{ url('/admin/plans') }}">{{ __('Plans') }}</a>
						</li>
                        <li class="nav-item">
							<a class="nav-link fw-bold" href="{{ url('/admin/plan-addons') }}">{{ __('Plan Addons') }}</a>
						</li>
					@endif
				@endif
			</ul>
			<ul class="navbar-nav ml-auto">
			<!-- Authentication Links -->
			@guest
            <!-- For guest user -->
			@else
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
					{{ Auth::user()->full_name }}
					</a>
					<ul class="dropdown-menu" aria-labelledby="navbarDropdown">
						<li>
							<a class="dropdown-item" href="{{ route('me') }}">
								{{ __('Profile') }}
							</a>
						</li>
						<li>
							<a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
								{{ __('Logout') }}
							</a>

							<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
								@csrf
							</form>
						</li>
					</ul>
				</li>
			@endguest
			</ul>
		</div>
  	</div>
</nav>
