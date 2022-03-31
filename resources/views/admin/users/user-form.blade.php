@extends('layouts.app')
@section('content')

<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">{{ (@$user) ? __('Edit User') : __('Add New User') }}</h4>
			<div class="page-title-right">
				<ol class="breadcrumb m-0">
					<li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Home</a></li>
					<li class="breadcrumb-item"><a href="{{ url('/admin/users') }}">Users</a></li>
					<li class="breadcrumb-item active">{{ (@$user) ? __('Edit User') : __('Create User') }}</li>
				</ol>
			</div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
<div class="clearfix">&nbsp;</div>
    @if(@$user)
	<form method="post" action="{{ url('/admin/users/'.$user->uuid) }}" enctype="multipart/form-data" autocomplete="off">
	    <input name="_method" type="hidden" value="PUT">
	<input name="uuid" type="hidden" value="{{ $user->uuid }}">
	@else
	<form method="post" action="{{  url('/admin/users') }}" enctype="multipart/form-data">
	@endif
    @csrf
    <div class="row">
        <div class="col-lg-10 col-xs-12">
            <!-- left area -->
            <div class="row">
                <div class="col">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control @error('first_name') is-invalid @enderror" id="first_name" name=" first_name" value="{{ (@$user) ? $user->first_name : old('first_name') }}" placeholder="First Name" aria-label="First Name">
                        <label for="first_name">First Name</label>
                        @if ($errors->has('first_name'))
                        <div class="error text-danger">
                            {{ $errors->first('first_name') }}
                        </div>
                        @endif
                    </div>
                </div>

                <div class="col">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control @error('last_name') is-invalid @enderror" id="last_name" name="last_name" value="{{ (@$user) ? $user->last_name : old('last_name') }}" placeholder="Last Name" aria-label="Last Name">
                        <label for="last_name">Last Name</label>
                        @if ($errors->has('last_name'))
                        <div class="error text-danger">
                            {{ $errors->first('last_name') }}
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control @error('contact_number') is-invalid @enderror" id="contact_number" name="contact_number" value="{{ (@$user) ? $user->contact_number : old('contact_number') }}" placeholder="Contact Number" aria-label="Contact Number">
                <label for="contact_number">Contact Number</label>
                @if ($errors->has('contact_number'))
                <div class="error text-danger">
                    {{ $errors->first('contact_number') }}
                </div>
                @endif
            </div>
            <div class="row">
                <div class="col">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address" value="{{ (@$user) ? $user->address : old('address') }}" placeholder="Address" aria-label="Address">
                        <label for="address">Address</label>
                        @if ($errors->has('address'))
                        <div class="error text-danger">
                            {{ $errors->first('address') }}
                        </div>
                        @endif
                    </div>
                </div>

                <div class="col">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control @error('city') is-invalid @enderror" id="city" name="city" value="{{ (@$user) ? $user->city : old('city') }}" placeholder="City" aria-label="City">
                        <label for="city">City</label>
                        @if ($errors->has('city'))
                        <div class="error text-danger">
                            {{ $errors->first('city') }}
                        </div>
                        @endif
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control @error('state') is-invalid @enderror" id="state" name="state" value="{{ (@$user) ? $user->state : old('state') }}" placeholder="State" aria-label="State">
                        <label for="state">State</label>
                        @if ($errors->has('state'))
                        <div class="error text-danger">
                            {{ $errors->first('state') }}
                        </div>
                        @endif
                    </div>
                </div>

                <div class="col">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control @error('country') is-invalid @enderror" id="country" name="country" value="{{ (@$user) ? $user->country : old('country') }}" placeholder="country" aria-label="country">
                        <label for="country">Country</label>
                        @if ($errors->has('country'))
                        <div class="error text-danger">
                            {{ $errors->first('country') }}
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="form-floating mb-3">
                <input type="text" class="form-control @error('zip_code') is-invalid @enderror" id="zip_code" name="zip_code" value="{{ (@$user) ? $user->zip_code : old('zip_code') }}" placeholder="Zipcode" aria-label="Zipcode">
                <label for="zip_code">Zipcode</label>
                @if ($errors->has('zip_code'))
                <div class="error text-danger">
                    {{ $errors->first('zip_code') }}
                </div>
                @endif
            </div>
            <div class="form-floating mb-3">
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ (@$user) ? $user->email : old('email') }}" placeholder="Email" aria-label="Email" autocomplete="off">
                <label for="email">Email</label>
                @if ($errors->has('email'))
                <div class="error text-danger">
                    {{ $errors->first('email') }}
                </div>
                @endif
            </div>
            <div class="row">
                <div class="col">
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" value="" placeholder="Password" aria-label="Password" autocomplete="new-password">
                        <label for="password">Password</label>
                        @if ($errors->has('password'))
                        <div class="error text-danger">
                            {{ $errors->first('password') }}
                        </div>
                        @endif
                    </div>
                </div>
                <div class="col">
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation" value="" placeholder="Password" aria-label="Password Confirmation">
                        <label for="password_confirmation">Confirm Password</label>
                        @if ($errors->has('password_confirmation'))
                        <div class="error text-danger">
                            {{ $errors->first('password_confirmation') }}
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- left area end-->
        </div>
        <div class="col-lg-2 col-xs-12 text-center">
            <img src="{{ (@$user && @$user->image) ? asset($user->image) : asset('/storage/images/default-user-image.png') }}" class="bg-light avatar avatar-128 rounded-circle align-content-center" alt="" id="previewImage" onerror="this.onerror=null;this.src='{{ asset('/storage/img/avatars/default-avatar.png') }}'">
            <input class="form-control form-control-lg" type='file' id="getFile" style="display:none" name="image">
            <div class="clearfix">&nbsp;</div>

            <button type="button" class="btn btn-primary btn-sm btn-rounded mb-3" onclick="document.getElementById('getFile').click()">
                <span class="btn-label"><i class="bi bi-upload"></i></span>
                Upload Profile Image
            </button>

        </div>
    </div>
    <div class="row">

        <div class="my-3">
            <button type="submit" class="btn btn-success btn-lg float-end">Save</button>
            {{-- <button class="btn btn-dark mx-2 btn-lg float-end reset-user" input-image="" data-image="{{ (@$user) ? asset($user->image) : '' }}" default-image="{{ asset('/storage/img/avatars/default-avatar.png') }}" type="reset">Reset</button> --}}
        </div>
    </div>
</form>
</div>
</div>
@endsection
