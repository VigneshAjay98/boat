@extends('layouts.front-layout')


@section('content')
<div class="d-flex mt-5 mb-md-4 py-5 container">
    <div class="d-flex w-100 justify-content-center align-self-center row">
        <div class="text-center">
            <h2>Register your account</h2>
            <!-- <img src="{{ url('storage/images/logo.png') }}"> -->
        </div>
        <div class="ms-4 ps-3 pe-3 pb-3 bg-body rounded  col-xs-10 col-sm-10 col-md-7 col-lg-6 col-xl-5 col-xxl-5">
            <form method="POST" action="{{ route('register') }}" autocomplete="off">
                @csrf
                <div class="card-body ">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control @error('first_name') is-invalid @enderror" id="first_name" name="first_name" placeholder="Email" aria-label="first_name" value="{{ old('first_name') }}" autocomplete="off">
                        <label for="first_name">{{ __('First Name') }}</label>
                        @if ($errors->has('first_name'))
                            <div class="error text-danger">
                                {{ $errors->first('first_name') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control @error('last_name') is-invalid @enderror" id="last_name" name="last_name" placeholder="Email" aria-label="last_name" value="{{ old('last_name') }}" autocomplete="off">
                        <label for="last_name">{{ __('Last Name') }}</label>
                        @if ($errors->has('last_name'))
                            <div class="error text-danger">
                                {{ $errors->first('last_name') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Email" aria-label="email" value="{{ old('email') }}" required autocomplete="off">
                        <label for="email">{{ __('Email') }}</label>
                        @if ($errors->has('email'))
                            <div class="error text-danger">
                                {{ $errors->first('email') }}
                            </div>
                        @endif
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control @error('contact_number') is-invalid @enderror"
                            id="contact_number" name="contact_number" placeholder="Mobile Number" aria-label="Mobile Number"
                            value="{{ old('contact_number') }}" autocomplete="off">
                        <label for="contact_number">Mobile Number</label>
                        @if ($errors->has('contact_number'))
                        <div class="error text-danger">
                            {{ $errors->first('contact_number') }}
                        </div>
                        @endif
                        <div class="form-text d-flex justify-content-end">
                            Why do we need this?<i class="fi-alert-circle fs-sm text-primary ms-2" data-bs-toggle="tooltip" title="" data-bs-original-title="Your mobile phone# will be used for sending text messages when we find a matching vessel or a prospective buyer inquires." aria-label="Your mobile phone# will be used for sending text messages when we find a matching vessel or a prospective buyer inquires."></i>
                        </div>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                            id="password" name="password" placeholder="Password" aria-label="Password"
                            value="{{ old('password') }}" required autocomplete="off">
                        <label for="password">Password</label>
                        @if ($errors->has('password'))
                        <div class="error text-danger">
                            {{ $errors->first('password') }}
                        </div>
                        @endif
                    </div>

                    <div class="form-floating mb-3">
                        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
                            id="password_confirmation" name="password_confirmation" placeholder="Confirm Password" aria-label="Confirm Password"
                            value="{{ old('password_confirmation') }}" required autocomplete="off">
                        <label for="password_confirmation">Confirm Password</label>
                        @if ($errors->has('password_confirmation'))
                        <div class="error text-danger">
                            {{ $errors->first('password_confirmation') }}
                        </div>
                        @endif
                    </div>

                    <div class="row">
                        <div class="d-grid d-md-flex justify-content-center">
                            <button type="submit" class="btn btn-success btn-md">{{ __('Register') }}</button>
                        </div>
                    </div>
                </div>
                <div class="d-grid d-flex justify-content-center">
                    <a class="btn btn-link" href="{{ route('login') }}">
                        {{ __('Already have an account?') }}
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
