@extends('layouts.front-layout')

@section('content')

<div class="container step-five-file-container mt-5 mb-md-4 py-5">
    <!-- Breadcrumb-->
    <nav class="mb-4 pt-md-3" aria-label="Breadcrumb">
        <ol class="breadcrumb breadcrumb-dark">
            <li class="breadcrumb-item"><a href="{{ url('/')}}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Personal Info</li>
        </ol>
    </nav>
    <!-- Page content-->
    <div class="row">
        <!-- Sidebar-->
        @include('layouts.partials.front-sidebar')
        <!-- Content-->
        <div class="col-lg-8 col-md-7 mb-5">
            <h1 class="h2 text-dark">Personal Info</h1>
            <form  method="post" action="{{ route('update-profile' )}}" enctype="multipart/form-data" autocomplete="off">
                @csrf
                <input name="_method" type="hidden" value="PUT">
                <input name="uuid" type="hidden" value="{{ $user->uuid }}">
                <input name="redirect_url" type="hidden" value="/profile">
                <div class="row pt-2">
                    <div class="col-lg-9 col-md-12 col-sm-8 mb-2 mb-m-4">
                        <div class="border border-dark rounded-3 p-3 mb-4" id="personalInfo">
                            <!-- First Name-->
                            <div class="border-bottom border-dark pb-3 mb-3">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="pe-2 opacity-70">
                                        <label class="form-label fw-bold text-dark">First name</label>
                                        <div class="text-dark" id="firstNameValue"> {{ $user->first_name ?? '' }}</div>
                                    </div>
                                    <div class="me-n3" data-bs-toggle="tooltip" title="Edit"><a class="nav-link nav-link-dark py-0" href="#firstNameCollapse" data-bs-toggle="collapse"><i class="fi-edit"></i></a></div>
                                </div>

                                <div class="collapse" id="firstNameCollapse" data-value=" {{ $user->first_name ?? '' }}" data-bs-parent="#personalInfo">
                                    <input class="form-control form-control-dark mt-3" type="text" data-bs-binded-element="#firstNameValue" data-bs-unset-value="Not specified" name="first_name" value="{{ old('first_name') ?? $user->first_name ?? ''  }}">
                                </div>
                                @if ($errors->has('first_name'))
                                    <div class="error text-danger">
                                        {{ $errors->first('first_name') }}
                                    </div>
                                @endif
                            </div>

                            <!-- Last Name-->
                            <div class="border-bottom border-dark pb-3 mb-3">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="pe-2 opacity-70">
                                        <label class="form-label fw-bold text-dark">Last name</label>
                                        <div class="text-dark" id="lastNameValue"> {{ $user->last_name ?? ''  }}</div>
                                    </div>
                                    <div class="me-n3" data-bs-toggle="tooltip" title="Edit"><a class="nav-link nav-link-dark py-0" href="#lastNameCollapse" data-bs-toggle="collapse"><i class="fi-edit"></i></a></div>
                                </div>
                                <div class="collapse" id="lastNameCollapse" data-value="{{ $user->last_name ?? '' }}" data-bs-parent="#personalInfo">
                                    <input class="form-control form-control-dark mt-3" type="text" data-bs-binded-element="#lastNameValue" data-bs-unset-value="Not specified" name="last_name" value="{{ old('last_name') ?? $user->last_name ?? ''  }}">
                                </div>
                                @if ($errors->has('last_name'))
                                    <div class="error text-danger">
                                        {{ $errors->first('last_name') }}
                                    </div>
                                @endif
                            </div>

                            <!-- Phone number-->
                            <div class="border-bottom border-dark pb-3 mb-3">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="pe-2 opacity-70">
                                        <label class="form-label fw-bold text-dark">Phone number</label>
                                        <div class="text-dark" id="contactNumberValue">{{ $user->contact_number ?? ''  }}</div>
                                    </div>
                                    <div class="me-n3" data-bs-toggle="tooltip" title="Edit"><a class="nav-link nav-link-dark py-0" href="#contactNumberCollapse" data-bs-toggle="collapse"><i class="fi-edit"></i></a></div>
                                </div>
                                <div class="collapse" id="contactNumberCollapse" data-value=" {{ $user->contact_number ?? '' }}" data-bs-parent="#personalInfo">
                                    <input class="form-control form-control-dark mt-3" type="text" data-bs-binded-element="#contactNumberValue" data-bs-unset-value="Not specified" name="contact_number" value="{{ old('contact_number') ?? $user->contact_number ?? ''  }}">
                                </div>
                                @if ($errors->has('contact_number'))
                                    <div class="error text-danger">
                                        {{ $errors->first('contact_number') }}
                                    </div>
                                @endif
                            </div>

                            <!-- Email-->
                            <div class="border-bottom border-dark pb-3 mb-3">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="pe-2 opacity-70">
                                        <label class="form-label fw-bold text-dark">Email</label>
                                        <div class="text-dark" id="email-value">{{ $user->email ?? ''  }}</div>
                                    </div>
                                </div>
                                <input type="hidden" name="email" value="{{ old('email') ?? $user->email ?? ''  }}">
                                @if ($errors->has('email'))
                                    <div class="error text-danger">
                                        {{ $errors->first('email') }}
                                    </div>
                                @endif
                            </div>

                            <!-- Address-->
                            <div class="border-bottom border-dark pb-3 mb-3">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="pe-2 opacity-70">
                                        <label class="form-label fw-bold text-dark">Address</label>
                                        <div class="text-dark" id="addressValue">{{ $user->address ?? ''  }}</div>
                                    </div>
                                    <div class="me-n3" data-bs-toggle="tooltip" title="Edit"><a class="nav-link nav-link-dark py-0" href="#addressCollapse" data-bs-toggle="collapse"><i class="fi-edit"></i></a></div>
                                </div>
                                <div class="collapse" id="addressCollapse" data-bs-parent="#personalInfo">
                                    <textarea class="form-control form-control-dark mt-3" type="text" data-bs-binded-element="#addressValue" data-bs-unset-value="Not specified" placeholder="Enter address" name="address"  rows="3">{{ old('address') ??  $user->address ?? '' }}</textarea>
                                </div>
                                @if ($errors->has('address'))
                                    <div class="error text-danger">
                                        {{ $errors->first('address') }}
                                    </div>
                                @endif
                            </div>
                            <!-- Country-->
                            <div class="border-bottom border-dark pb-3 mb-3">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="pe-2 opacity-70">
                                        <label class="form-label fw-bold text-dark">Country</label>
                                        <div class="text-dark" id="countryValue">{{ $user->country ?? ''  }}</div>
                                    </div>
                                    <div class="me-n3" data-bs-toggle="tooltip" title="Edit"><a class="nav-link nav-link-dark py-0" href="#countryCollapse" data-bs-toggle="collapse"><i class="fi-edit"></i></a></div>
                                </div>
                                <div class="collapse mt-2" id="countryCollapse" data-bs-parent="#personalInfo">
                                    <select class="form-select form-select-dark w-100 filter select-country" id="userProfileCountrySelect" data-bs-binded-element="#countryValue" data-bs-unset-value="Not specified" placeholder="Enter country" name="country">
                                        <option value="" disabled selected >Select Country</option>
                                        @foreach($countries as $country)
                                            @php
                                                $isSelected = '';
                                                if(isset($user->country)){
                                                    $isSelected = ($country->name == $user->country) ? 'selected' : '';
                                                }
                                            @endphp
                                            <option value="{{ $country->name }}" {{ $isSelected }}>{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @if ($errors->has('country'))
                                    <div class="error text-danger">
                                        {{ $errors->first('country') }}
                                    </div>
                                @endif
                            </div>

                            <!-- State-->
                            <div class="border-bottom border-dark pb-3 mb-3" id="clientStateId" data-state = "{{ $user->state ?? ''  }}">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="pe-2 opacity-70">
                                        <label class="form-label fw-bold text-dark">State</label>
                                        <div class="text-dark profile-state-value" id="stateValue">{{ $user->state ?? ''  }}</div>
                                    </div>
                                    <div class="me-n3" data-bs-toggle="tooltip" title="Edit"><a class="nav-link nav-link-dark py-0" href="#stateCollapse" data-bs-toggle="collapse"><i class="fi-edit"></i></a></div>
                                </div>
                                <div class="collapse mt-2  user-profile-select2" id="stateCollapse" data-bs-parent="#personalInfo">
                                    <select class="form-select form-select-dark filter select-state"  id="userProfileStateSelect" data-bs-binded-element="#stateValue" data-bs-unset-value="Not specified" style="width: 100% !important" placeholder="Select state" name="state">
                                        <option value="" disabled selected >Select State</option>
                                            @if(isset($states) && count($states) > 0)
                                                @foreach($states as $state)
                                                    @php
                                                        $isSelected = ($state->name == $user->state) ? 'selected' : '';
                                                    @endphp
                                                    <option value="{{ $state->name }}" {{ $isSelected }}>{{ $state->name }}</option>
                                                @endforeach
                                            @endif
                                    </select>
                                </div>
                                @if ($errors->has('state'))
                                    <div class="error text-danger">
                                        {{ $errors->first('state') }}
                                    </div>
                                @endif
                            </div>

                            <!-- City-->
                            <div class="border-bottom border-dark pb-3 mb-3">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="pe-2 opacity-70">
                                        <label class="form-label fw-bold text-dark">City</label>
                                        <div class="text-dark" id="cityValue">{{ $user->city ?? ''  }}</div>
                                    </div>
                                    <div class="me-n3" data-bs-toggle="tooltip" title="Edit"><a class="nav-link nav-link-dark py-0" href="#cityCollapse" data-bs-toggle="collapse"><i class="fi-edit"></i></a></div>
                                </div>
                                <div class="collapse" id="cityCollapse" data-bs-parent="#personalInfo">
                                    <input class="form-control form-control-dark mt-3" type="text" data-bs-binded-element="#cityValue" data-bs-unset-value="Not specified" placeholder="Enter city"  name="city" value={{ old('city') ??  $user->city ?? '' }}>
                                </div>
                                @if ($errors->has('city'))
                                    <div class="error text-danger">
                                        {{ $errors->first('city') }}
                                    </div>
                                @endif
                            </div>

                            <!-- Zip Code-->
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="pe-2 opacity-70">
                                    <label class="form-label fw-bold text-dark">Zip code</label>
                                    <div class="text-dark" id="zipcodeValue">{{ $user->zip_code ?? ''  }}</div>
                                </div>
                                <div class="me-n3" data-bs-toggle="tooltip" title="Edit"><a class="nav-link nav-link-dark py-0" href="#zipcodeCollapse" data-bs-toggle="collapse"><i class="fi-edit"></i></a></div>
                            </div>
                            <div class="collapse" id="zipcodeCollapse" data-bs-parent="#personalInfo">
                                <input class="form-control form-control-dark mt-3" type="text" data-bs-binded-element="#zipcodeValue" data-bs-unset-value="Not specified" placeholder="Enter zipcode" name="zip_code" value={{ old('zip_code') ??  $user->zip_code ?? '' }}>
                            </div>
                            @if ($errors->has('zip_code'))
                                <div class="error text-danger">
                                    {{ $errors->first('zip_code') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-12 col-sm-4 mb-4">
                        <input class="file-uploader border-dark bg-faded-dark profile-upload" type="file" accept="image/png, image/jpeg" data-label-idle="&lt;i class=&quot;d-inline-block fi-camera-plus fs-2 text-dark text-muted mb-2&quot;&gt;&lt;/i&gt;&lt;br&gt;&lt;span class=&quot;fw-bold text-dark opacity-70&quot;&gt;Change picture&lt;/span&gt;" data-style-panel-layout="compact" data-image-preview-height="160" data-image-crop-aspect-ratio="1:1" data-image-resize-target-width="200" data-image-resize-target-height="200" name="upload_image">
                    </div>
                    <input type="hidden" name="image" id="newFile">

                </div>

            <!-- Action buttons-->
            <div class="row">
                <div class="col-lg-9">
                <div class="d-flex align-items-center justify-content-end pb-1">
                    <button class="btn btn-primary" type="submit">Save changes</button>
                    {{-- <button class="btn btn-link btn-dark btn-sm px-0" type="button"><i class="fi-trash me-2"></i>Delete account</button> --}}
                </div>
                </div>
            </div>
        </form>
        </div>
    </div>
</div>
@endsection
