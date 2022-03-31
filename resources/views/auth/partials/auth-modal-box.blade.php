<!-- Sign In Modal-->
<div class="modal fade" id="signInModal" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-lg modal-dialog-centered p-2 my-0 mx-auto" style="max-width: 950px;">
		<div class="modal-content bg-light border-light">
			<div class="modal-content">
				<div class="modal-body px-0 py-2 py-sm-0">
					<button class="btn-close btn-close-dark position-absolute top-0 end-0 mt-3 me-3" type="button" data-bs-dismiss="modal"></button>
					<div class="row mx-0 align-items-center">
						<div class="col-md-6 border-end-md border-dark p-4 p-sm-5">
							<h2 class="h3 text-dark mb-4 mb-sm-5">Hey there!<br>Welcome back.</h2>
							<img class="d-block mx-auto" src="{{ asset('storage/img/auth-modals/signin-dark.svg')}}" width="344" alt="Illustartion">
							{{-- <div class="text-dark mt-4 mt-sm-5"><span class="opacity-60">Don't have an account? </span><a class="text-dark open-model-btn" href="#" data-title=""  data-href="{{ url('signup-user') }}" data-bs-toggle="modal" data-bs-target="#authModalBox">Sign up here</a></div> --}}
							<div class="text-dark mt-4 mt-sm-5"><span class="opacity-60">Don't have an account? </span><a class="text-dark" href="#signUpModal" data-bs-toggle="modal" data-bs-dismiss="modal">Sign up here</a></div>
						</div>
						<div class="col-md-6 px-4 pt-2 pb-4 px-sm-5 pb-sm-5 pt-md-5">

							<form  autocomplete="off" id="loginForm">
								@csrf

                                <input class="is-sell-boat" id="isSellBoat" name="is_sell_boat" type="hidden" value="">
								<div class="mb-4">
									<label class="form-label text-dark mb-2" for="signInEmail">Email address</label>
									<input class="form-control form-control-dark" name="email" type="email" id="signInEmail" placeholder="Enter your email"  aria-label="email" value="{{ old('email') }}" autocomplete="off" required>
									<span class="email_error text-danger"></span>
								</div>

								<div class="mb-4">
									<div class="d-flex align-items-center justify-content-between mb-2">
										<label class="form-label text-dark mb-0" for="signInPassword">Password</label><a class="fs-sm text-dark" href="#resetModal" data-bs-toggle="modal" data-bs-dismiss="modal">Forgot password?</a>
									</div>
									<div class="password-toggle">
										<input class="form-control form-control-dark" name="password" type="password" id="signInPassword" placeholder="Enter password" aria-label="Password" value="{{ old('password') }}" autocomplete="off" required>
										<label class="password-toggle-btn" aria-label="Show/hide password">
											<input class="password-toggle-check" type="checkbox"><span class="password-toggle-indicator"></span>
										</label>
										<span class="password_error text-danger"></span>
									</div>
								</div>
								<button class="btn btn-primary btn-lg w-100" id="loginSubmit" type="submit">Sign in </button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Sign Up Modal-->
<div class="modal fade" id="signUpModal" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-lg modal-dialog-centered p-2 my-0 mx-auto" style="max-width: 950px;">
		<div class="modal-content bg-light border-light">
		<div class="modal-body px-0 py-2 py-sm-0">
			<button class="btn-close btn-close-dark position-absolute top-0 end-0 mt-3 me-3" type="button" data-bs-dismiss="modal"></button>
			<div class="row mx-0 align-items-center">
			<div class="col-md-6 border-end-md border-dark p-4 p-sm-5">
				<h2 class="h3 text-dark mb-4 mb-sm-5">Join Yacht Finder.<br>Get premium benefits:</h2>
				<ul class="list-unstyled mb-4 mb-sm-5">
				<li class="d-flex mb-2"><i class="fi-check-circle text-primary mt-1 me-2"></i><span class="text-dark">Add and sell your yacht</span></li>
				<li class="d-flex mb-2"><i class="fi-check-circle text-primary mt-1 me-2"></i><span class="text-dark">Easily manage your yachts</span></li>
				{{--<li class="d-flex mb-0"><i class="fi-check-circle text-primary mt-1 me-2"></i><span class="text-dark">Leave reviews</span></li> --}}
				</ul><img class="d-block mx-auto" src="{{ asset('storage/img/auth-modals/signup-dark.svg') }}" width="344" alt="Illustartion">
				<div class="text-dark mt-sm-4 pt-md-3"><span class="opacity-60">Already have an account? </span><a class="text-dark" href="#signInModal" data-bs-toggle="modal" data-bs-dismiss="modal">Sign in</a></div>
			</div>
			<div class="col-md-6 px-4 pt-2 pb-4 px-sm-5 pb-sm-5 pt-md-5">
				<form  id="signupForm"  autocomplete="off">
					<div class="mb-4">
						<label class="form-label text-dark signup-first-name" for="signupFirstName">First name</label>
						<input class="form-control form-control-dark" name="first_name" type="text" id="signupFirstName" placeholder="Enter your first name"  autocomplete="off">
						<span class="first_name_error text-danger"></span>
					</div>
					<div class="mb-4">
						<label class="form-label text-dark signup-last-name" for="signupLastName">Last name</label>
						<input class="form-control form-control-dark" name="last_name" type="text" id="signupLastName" placeholder="Enter your last name"  autocomplete="off">
						<span class="last_name_error text-danger"></span>
					</div>
					<div class="mb-4">
						<label class="form-label text-dark signup-contact-number" for="signupContactNumber">Mobile Number</label>
						<input class="form-control form-control-dark" name="contact_number" type="text" id="signupContactNumber" placeholder="Enter your mobile number"  autocomplete="off">
						<span class="contact_number_error text-danger"></span>
						<div class="form-text d-flex justify-content-end">
							Why do we need this?<i class="fi-alert-circle fs-sm text-primary ms-2" data-bs-toggle="tooltip" title="" data-bs-original-title="Your mobile phone# will be used for sending text messages when we find a matching vessel or a prospective buyer inquires." aria-label="Your mobile phone# will be used for sending text messages when we find a matching vessel or a prospective buyer inquires."></i>
						</div>
					</div>
					<div class="mb-4">
						<label class="form-label text-dark signup-email" for="signupEmail">Email address</label>
						<input class="form-control form-control-dark" type="email" name="email" id="signupEmail" placeholder="Enter your email" required  autocomplete="off">
						<span class="email_error text-danger"></span>
					</div>
					<div class="mb-4">
						<label class="form-label text-dark signup-password" for="signupPassword">Password <span class='fs-sm opacity-50'>min. 8 char</span></label>
						<div class="password-toggle">
							<input class="form-control form-control-dark" type="password" name="password" id="signupPassword"  placeholder="Enter your password" minlength="8" required  autocomplete="off">
							<span class="password_error text-danger"></span>
							<label class="password-toggle-btn" aria-label="Show/hide password">
								<input class="password-toggle-check" type="checkbox"><span class="password-toggle-indicator"></span>
							</label>
							</div>
					</div>
					<div class="mb-4">
						<label class="form-label text-dark " for="signupPasswordConfirm">Confirm password</label>
						<div class="password-toggle">
							<input class="form-control form-control-dark signup-password-confirmation"  placeholder="Confirm your password" name="password_confirmation" type="password" id="signupPasswordConfirm" minlength="8" required  autocomplete="off">
							<span class="password_confirmation_error text-danger"></span>
							<label class="password-toggle-btn" aria-label="Show/hide password">
								<input class="password-toggle-check" type="checkbox"><span class="password-toggle-indicator"></span>
							</label>
						</div>
					</div>
					{{-- <div class="form-check form-check-dark mb-4">
						<input class="form-check-input" type="checkbox" id="agree-to-terms" required>
						<label class="form-check-label" for="agree-to-terms"><span class='opacity-70'>By joining, I agree to the</span> <a href='#' class='text-dark'>Terms of use</a> <span class='opacity-70'>and</span> <a href='#' class='text-dark'>Privacy policy</a></label>
					</div> --}}
					<button class="btn btn-primary btn-lg w-100" id="signupSubmit"  type="submit">Sign up </button>
				</form>
			</div>
			</div>
		</div>
		</div>
	</div>
</div>


<!-- Forgot Password -->
<div class="modal fade" id="resetModal" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-lg modal-dialog-centered p-2 my-0 mx-auto" style="max-width: 950px;">
		<div class="modal-content bg-light border-light">
			<div class="modal-content">
				<div class="modal-body px-0 py-2 py-sm-0">
					<button class="btn-close btn-close-dark position-absolute top-0 end-0 mt-3 me-3" type="button" data-bs-dismiss="modal"></button>
					<div class="row mx-0 align-items-center">
						<div class="col-md-6 border-end-md border-dark p-4 p-sm-5">
							<h2 class="h3 text-dark mb-4 mb-sm-5">Hey there!<br>Forgot your password?</h2>
							<img class="d-block mx-auto" src="{{ asset('storage/img/auth-modals/signin-dark.svg')}}" width="344" alt="Illustartion">
							{{-- <div class="text-dark mt-4 mt-sm-5"><span class="opacity-60">Don't have an account? </span><a class="text-dark open-model-btn" href="#" data-title=""  data-href="{{ url('signup-user') }}" data-bs-toggle="modal" data-bs-target="#authModalBox">Sign up here</a></div> --}}
							<div class="text-dark mt-4 mt-sm-5"><span class="opacity-60">Don't have an account? </span><a class="text-dark" href="#signUpModal" data-bs-toggle="modal" data-bs-dismiss="modal">Sign up here</a></div>
						</div>
						<div class="col-md-6 px-4 pt-2 pb-4 px-sm-5 pb-sm-5 pt-md-5">

							<form id="resetForm">
								@csrf
								<div class="mb-4">
									<label class="form-label text-dark mb-2" for="resetEmail">Email address</label>
									<input class="form-control form-control-dark" name="email" type="email" id="resetEmail" placeholder="Enter your email"  aria-label="email" value="{{ old('email') }}" autocomplete="off" required>
									<span class="email_error text-danger"></span>
								</div>
								<button class="btn btn-primary btn-lg w-100" id="resetSubmit" type="submit">{{ __('Send Password Reset Link') }} </button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Cancel Subscription Confirmation -->
<div class="modal fade" id="cancelSubscriptionModal" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-lg modal-dialog-centered p-2 my-0 mx-auto" width="60%">
		<div class="modal-content bg-light border-light">
		<div class="modal-body px-0 py-2 py-sm-0">
			<div class="row mx-0 align-items-center">
				<div class="col-lg-12 col-xs-12 d-flex flex-column justify-content-center cancel-subscription-text">
					<h3 class="h3 text-dark d-flex justify-content-center">Are you sure?</h3>
					<h4 class="h4 text-dark d-flex justify-content-center text-wrap">You want to cancel your subscription.</h4>
				</div>
			</div>
			<div class="row mb-3">
				<div class="col-lg-12 col-xs-12 d-flex justify-content-center cancel-sub-btn-div">
					<a class="btn btn-dark mx-2" href="#cancelSubscriptionModal" data-bs-toggle="modal" data-bs-dismiss="modal">Cancel</a>
					<button type="button" class="btn btn-primary mx-2 confirm-cancellation-subscription" id="confirm-cancellation-subscription" data-subscription-name=""><span class="spinner-border spinner-border-sm me-2 cancel-spinner" role="status" aria-hidden="true" style="display: none;"></span>Yes</button>
				</div>
			</div>
		</div>
		</div>
	</div>
</div>

<!-- Delete listing Modal -->
<div class="modal fade" id="deleteListingModal" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-lg modal-dialog-centered p-2 my-0 mx-auto" width="60%">
		<div class="modal-content bg-light border-light">
		<div class="modal-body px-0 py-2 py-sm-0">
			<div class="row mx-0 align-items-center">
				<div class="col-lg-12 col-xs-12 d-flex flex-column justify-content-center delete-text">
					<h3 class="h3 text-dark d-flex justify-content-center">Are you sure?</h3>
					<h4 class="h4 text-dark d-flex justify-content-center">You want to delete your listing.</h4>
				</div>
			</div>
			<div class="row mb-3">
				<div class="col-lg-12 col-xs-12 d-flex justify-content-center delete-btn-div">
					<a class="btn btn-dark mx-2" href="#deleteListingModal" data-bs-toggle="modal" data-bs-dismiss="modal">Cancel</a>
					<button type="button" class="btn btn-primary mx-2 confirm-delete-listing" id="confirm-delete-listing" data-boat-uuid=""><span class="spinner-border spinner-border-sm me-2 delete-spinner" role="status" aria-hidden="true" style="display: none;"></span>Yes</button>
				</div>
			</div>
		</div>
		</div>
	</div>
</div>