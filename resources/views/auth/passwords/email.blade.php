@extends('layouts.front-layout')
@section('content')
<div class="d-flex vh-100  container">
    <div class="d-flex w-100 justify-content-center align-self-center row">
        <div class="text-center">
            <h2>{{ __('Reset Password') }}</h2>
            <!-- <img src="{{ url('storage/images/logo.png') }}"> -->
        </div>
        <div class="ms-4 p-3 bg-body rounded  col-xs-10 col-sm-10 col-md-7 col-lg-6 col-xl-5 col-xxl-5">
            <form method="POST" action="{{ route('password.email') }}" autocomplete="off">
                @csrf
                <div class="card-body ">
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                            name="email" placeholder="Email" aria-label="email" value="{{ old('email') }}" autocomplete="off">
                        <label for="email">{{ __('Email') }}</label>
                        @if ($errors->has('email'))
                            <div class="error text-danger">
                                {{ $errors->first('email') }}
                            </div>
                        @endif
                    </div>

                    <div class="row">
                        <div class="d-grid d-md-flex justify-content-center">
                            <button type="submit" class="btn btn-success btn-md">{{ __('Send Password Reset Link') }}</button>
                        </div>
                    </div>
                </div>
                <div class="d-grid d-flex justify-content-center">
                    @if (Route::has('login'))
                        <a class="btn btn-link" href="{{ route('login') }}">
                            {{ __('Back to login?') }}
                        </a>
                    @endif
                    <a class="btn btn-link" href="{{ route('register') }}">
                        {{ __('Not registered yet?') }}
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
