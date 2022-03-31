@extends('layouts.front-layout')

@section('content')
<div class="container step-six-file-container mt-5 mb-md-4 py-5">
    <!-- Breadcrumb-->
    <nav class="mb-4 pt-md-3" aria-label="Breadcrumb">
        <ol class="breadcrumb breadcrumb-dark">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Password &amp; Security</li>
        </ol>
    </nav>
    <!-- Page content-->
    <div class="row">
        <!-- Sidebar-->
        @include('layouts.partials.front-sidebar')
        <!-- Content-->
        <div class="col-lg-8 col-md-7 mb-5">
            <h1 class="h2 text-dark">Password &amp; Security</h1>
            <p class="text-dark pt-1">Manage your password settings and secure your account.</p>
            <h2 class="h5 text-dark">Password</h2>
            <form class="pb-4" method="post" action="{{ route('update-password' )}}" autocomplete="off">
                @csrf
                <input name="_method" type="hidden" value="PUT">
                <input name="uuid" type="hidden" value="{{ $user->uuid }}">
                <div class="row align-items-end mb-2">
                    <div class="col-sm-6 mb-2">
                        <label class="form-label text-dark" for="accountPassword">Current password</label>
                        <div class="password-toggle">
                            <input class="form-control form-control-dark  @error('old_password') is-invalid @enderror" type="password" name="old_password" id="accountPassword" >
                            <label class="password-toggle-btn" aria-label="Show/hide password">
                                <input class="password-toggle-check" type="checkbox"><span class="password-toggle-indicator"></span>
                            </label>
                        </div>
                        @if ($errors->has('old_password'))
                            <div class="error text-danger">
                                {{ $errors->first('old_password') }}
                            </div>
                        @endif
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-6 mb-3">
                        <label class="form-label text-dark" for="accountPasswordNew">New password</label>
                        <div class="password-toggle">
                            <input class="form-control form-control-dark  @error('new_password') is-invalid @enderror" type="password" name="new_password" id="accountPasswordNew" >
                            <label class="password-toggle-btn" aria-label="Show/hide password">
                            <input class="password-toggle-check" type="checkbox"><span class="password-toggle-indicator"></span>
                            </label>
                        </div>
                        @if ($errors->has('new_password'))
                            <div class="error text-danger">
                                {{ $errors->first('new_password') }}
                            </div>
                        @endif
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label class="form-label text-dark" for="accountPasswordConfirm">Confirm password</label>
                        <div class="password-toggle">
                            <input class="form-control form-control-dark  @error('password_confirmation') is-invalid @enderror" type="password" name="password_confirmation"  id="accountPasswordConfirm" >
                            <label class="password-toggle-btn" aria-label="Show/hide password">
                            <input class="password-toggle-check" type="checkbox"><span class="password-toggle-indicator"></span>
                            </label>
                        </div>
                        @if ($errors->has('password_confirmation'))
                            <div class="error text-danger">
                                {{ $errors->first('password_confirmation') }}
                            </div>
                        @endif
                    </div>
                </div>
                <button class="btn btn-outline-primary" type="submit">Update password</button>
            </form>
        </div>
    </div>
</div>
@endsection
