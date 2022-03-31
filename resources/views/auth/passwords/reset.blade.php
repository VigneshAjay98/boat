@extends('layouts.front-layout')


@section('content')
<div class="d-flex vh-100  container">
    <div class="d-flex w-100 justify-content-center align-self-center row">
        <div class="text-center">
            <h2>{{ __('Reset Password') }}</h2>
            <!-- <img src="{{ url('storage/images/logo.png') }}"> -->
            @if ($errors->has('user_verified'))
                <div class="error text-danger">
                    {{ $errors->first('user_verified') }}
                </div>
            @endif
        </div>
        <div class="ms-4 p-3 bg-body rounded  col-xs-10 col-sm-10 col-md-7 col-lg-6 col-xl-5 col-xxl-5">
            <form method="POST"  action="{{ route('password.update') }}" autocomplete="off">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <div class="card-body ">
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                            name="email" placeholder="Email" aria-label="email"  value="{{ $email ?? old('email') }}" required autocomplete="off" autofocus readonly>
                        <label for="email">{{ __('Email') }}</label>
                        @if ($errors->has('email'))
                            <div class="error text-danger">
                                {{ $errors->first('email') }}
                            </div>
                        @endif
                    </div>

                    <div class="form-floating mb-3">
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                            id="password" name="password" placeholder="Password" aria-label="Password"
                            value="{{ old('password') }}" autocomplete="off" required>
                        <label for="password">Password</label>
                        @if ($errors->has('password'))
                        <div class="error text-danger">
                            {{ $errors->first('password') }}
                        </div>
                        @endif
                    </div>

                    <div class="form-floating mb-3">
                        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
                            id="password-confirm" name="password_confirmation" placeholder="Confirm Password" aria-label="Confirm Password"
                            value="{{ old('password_confirmation') }}" autocomplete="off" required>
                        <label for="password-confirm">{{ __('Confirm Password') }}</label>
                        @if ($errors->has('password_confirmation'))
                        <div class="error text-danger">
                            {{ $errors->first('password_confirmation') }}
                        </div>
                        @endif
                    </div>

                    <div class="row">
                        <div class="d-grid d-md-flex justify-content-center">
                            <button type="submit" class="btn btn-success btn-md">{{ __('Reset Password') }}</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
