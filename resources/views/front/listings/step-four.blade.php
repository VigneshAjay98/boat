@php
    $uri = $_SERVER['REQUEST_URI'];
    $uri = explode('/', $uri);
@endphp
@extends('layouts.front-layout')

@section('content')
<!-- <style>
    .filepond--root.file-uploader {
        height:  800px !important;
    }
</style> -->
<div class="container step-one-file-container mt-5 mb-md-4 py-5">
<div class="row">
    <div class="col-lg-12 col-xl-12">
          <!-- Steps-->
            <div class="bg-light rounded-3 py-4 px-md-4 mb-3">
                <div class="steps pt-4 pb-1">
                    <div class="step active">
                        <div class="step-progress"><span class="step-progress-start"></span><span class="step-progress-end"></span><span class="step-number">1</span></div>
                        <div class="step-label">Basic info</div>
                    </div>
                <div class="step active">
                    <div class="step-progress"><span class="step-progress-start"></span><span class="step-progress-end"></span><span class="step-number">2</span></div>
                    <div class="step-label">Details</div>
                </div>
                <div class="step active">
                    <div class="step-progress"><span class="step-progress-start"></span><span class="step-progress-end"></span><span class="step-number">3</span></div>
                    <div class="step-label">Details 2</div>
                </div>
                <div class="step {{ (request()->routeIs('step-four')) ? 'active' : '' }}">
                    <div class="step-progress"><span class="step-progress-start"></span><span class="step-progress-end"></span><span class="step-number">4</span></div>
                    <div class="step-label">Photos & Location</div>
                </div>
                @if(empty($locationInfo) || $locationInfo->payment_status=='unpaid')
                <div class="step">
                    <div class="step-progress"><span class="step-progress-start"></span><span class="step-progress-end"></span><span class="step-number">5</span></div>
                    <div class="step-label">Payment</div>
                </div>
                @endif
              </div>
            </div>
            <!-- Page title-->
            <div class="text-center">
                <h1 class="h2 mb-4">“Photo Shoot”</h1>
                <p class="mb-4">Having at least a handful of photos gives your vessel a far better chance of selling.<br/> Photos of the bow, stern, port and starboard, along with any cabin and deck space is ideal.</p>
            </div>
            <!-- Step 2: Details-->
            <form method="post" action="{{ route('step-four-submit') }}" enctype="multipart/form-data" id="stepFourForm">
            @csrf
                <input type="hidden" name="boat_uuid" value={{ (!empty($locationInfo) && $locationInfo->payment_status=='paid') ? $locationInfo->uuid : '' }}>
                <div class="bg-light rounded-3 p-4 p-md-2 mb-3">
                    <!-- <h2 class="h4 mb-4"><i class="fi-map text-primary fs-4 mt-n1 me-2 pe-1"></i>Location</h2> -->
                    @php
                        $datamax = '';
                        $videomax = '';
                    @endphp
                    @if(!empty($locationInfo) && !empty($locationInfo->plan_id))
                        @if($locationInfo->plan->image_number != '')
                            @php
                                $datamax = 'data-max-files='.$locationInfo->plan->image_number;
                            @endphp
                        @endif
                        @if($locationInfo->plan->video_number != '')
                            @php
                                $videomax = 'data-max-files='.$locationInfo->plan->video_number;
                            @endphp
                        @endif
                    @endif
                    <div class="row mb-3 image-uploadDiv" data-images-allowed="{{ $locationInfo->plan->image_number }}">
                        <div class="alert alert-warning bg-faded-warning border-warning mb-4 d-none images-warning" role="alert">
                            <div class="d-flex"><i class="fi-alert-circle me-2 me-sm-3"></i>
                                <p class="fs-sm mb-1 warn-text">The number of images allowed is {{ $locationInfo->plan->image_number }}</p>
                            </div>
                        </div>
                        @if(!empty($locationInfo) && count($locationInfo->images) > 0)
                            <input class="file-uploader file-uploader-grid bg-faded-dark border-dark boat-images-uploader" type="file" multiple accept="image/png, image/jpeg, image/*" {{ $datamax }} name="image">
                            <input class="server-image" type="hidden" data-boat-uuid="{{ $locationInfo->uuid }}" required>
                        @else
                            <input class="file-uploader file-uploader-grid bg-faded-dark border-dark boat-images-uploader" type="file" multiple accept="image/png, image/jpeg, image/*" {{ $datamax }} data-label-idle="&lt;div class=&quot;btn btn-primary mb-3&quot;&gt;&lt;i class=&quot;fi-cloud-upload me-1&quot;&gt;&lt;/i&gt;Upload Images&lt;/div&gt;&lt;div class=&quot;text-dark opacity-70&quot;&gt;or drag them in&lt;/div&gt;" data-item-insert-location="after" name="image" required>
                        @endif
                        <span class="image-error"></span>
                    </div>
                    <div class="alert alert-warning bg-faded-warning border-warning mb-4 d-none videos-warning" role="alert">
                        <div class="d-flex"><i class="fi-alert-circle me-2 me-sm-3"></i>
                            <p class="fs-sm mb-1 warn-text">The number of videos allowed is {{ $locationInfo->plan->video_number }}</p>
                        </div>
                    </div>
                    @if(!empty($locationInfo) && ($locationInfo->plan->video_number !== 0) )
                        <div class="row mb-3 video-uploadDiv" data-videos-allowed="{{ $locationInfo->plan->video_number }}">
                            <p class="fw-bold">Video Upload</p>
                            @if(!empty($locationInfo) && count($locationInfo->videos) > 0)
                                <input class="file-uploader file-uploader-grid bg-faded-dark border-dark boat-videos-uploader" type="file" multiple accept="video/mp4,video/x-m4v,video/*" {{ $videomax }} >
                                <input class="server-video" type="hidden" data-boat-uuid="{{ $locationInfo->uuid }}">
                            @else
                                <input class="file-uploader file-uploader-grid bg-faded-dark border-dark boat-videos-uploader" type="file" multiple accept="video/mp4,video/x-m4v,video/*" {{ $videomax }} data-label-idle="&lt;div class=&quot;btn btn-primary mb-3&quot;&gt;&lt;i class=&quot;fi-cloud-upload me-1&quot;&gt;&lt;/i&gt;Upload Videos&lt;/div&gt;&lt;div class=&quot;text-dark opacity-70&quot;&gt;or drag them in&lt;/div&gt;">
                            @endif
                        </div>
                    @endif
                    <div class="clearfix">&nbsp;</div>
                    <div class="row">
                        <div class="col-lg-12 col-xs-12 mb-3">
                            <span class="fw-bold">Vessel Location</span>
                            <br/>
                            <span>Your vessels location should be as accurate as possible; we will use this to match buyers.</span>
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-xs-12 mb-3">
                            <label class="form-label text-dark" for="Country">Country <span class="text-danger">*</span></label>
                            <select class="form-select form-select-dark select-country" id="Country" name="country" required>
                                @if(!empty($locationInfo) && !empty($locationInfo->country))
                                    <option value="" disabled>-- Select Country --</option>
                                @else
                                    <option value="" disabled>-- Select Country --</option>
                                @endif
                                @foreach($countries as $country)
                                    @if(!empty($locationInfo) && !empty($locationInfo->country))
                                        <option class="text-capitalize" value="{{ $country->name }}" {{ ($country->name == $locationInfo->country) ? 'selected' : '' }}>{{ $country->name }}</option>
                                    @else
                                        <option class="text-capitalize" value="{{ $country->name }}" {{ ($country->name == "United States") ? 'selected' : '' }}>{{ $country->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                            @if ($errors->has('country'))
                                <div class="error text-danger">
                                    {{ $errors->first('country') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-xs-12 mb-3 steps-form-select2">
                            <label class="form-label text-dark" for="State">State/Province <span class="text-danger">*</span></label>
                            @if(!empty($locationInfo) && !empty($locationInfo->state))
                                <select class="form-select form-select-dark select-state " id="State" name="state" required>

                                    <option value="" disabled>-- Select State --</option>
                                @foreach($states as $state)
                                    <option class="text-capitalize" value="{{ $state->name }}" {{ ($state->name == $locationInfo->state) ? 'selected' : '' }}>{{ $state->name }}</option>
                                @endforeach
                                {{ $stateName = $locationInfo->state }}
                                @php
                                    if(!$states->contains('state', $locationInfo->state)){
                                        echo '<option value='.$stateName.' selected>'.$stateName.'</option>';
                                    }
                                @endphp
                                </select>
                            @else
                            <select class="form-select form-select-dark select-state" id="State" name="state" required>

                                <option value="" selected disabled>-- Select State --</option>
                                @foreach($states as $state)
                                    <option class="text-capitalize" value="{{ $state->name }}" {{ (old('state') == $state->name) ? 'selected' : '' }}>{{ $state->name }}</option>
                                @endforeach
                            </select>
                            @endif
                            <span class="state-error"></span>
                            @if ($errors->has('state'))
                                <div class="error text-danger">
                                    {{ $errors->first('state') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-xs-12 mb-3">
                            <label class="form-label text-dark" for="ZipCode">Zip Code <span class="text-danger">*</span></label>
                            @if(!empty($locationInfo) && !empty($locationInfo->zip_code))
                                <input class="form-control form-control-dark" type="text" id="ZipCode" name="zip_code" placeholder="Zip Code" value="{{ $locationInfo->zip_code }}" required>
                            @else
                                <input class="form-control form-control-dark" type="text" id="ZipCode" name="zip_code" placeholder="Zip Code" required>
                            @endif
                            @if ($errors->has('zip_code'))
                                <div class="error text-danger">
                                    {{ $errors->first('zip_code') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <!-- Navigation-->
                <div class="d-flex flex-column justify-content-end flex-sm-row bg-light rounded-3 px-md-5">
                    <a href="{{ (!empty($locationInfo) && $locationInfo->payment_status=='paid') ? route('step-three', ['boat_uuid' => $locationInfo->uuid ]) : route('step-three') }}" class="btn btn-secondary btn-lg d-block mb-2 me-2"><i class="fi-chevron-left fs-sm me-2"></i>PREVIOUS</a>
                    <button class="btn btn-dark btn-lg d-block mb-2 me-2" name="exit" value="1" type="submit">SAVE & EXIT</button>
                    <button class="btn btn-primary btn-lg d-block mb-2 me-2" name="next" value="1" type="submit">SAVE & CONTINUE<i class="fi-chevron-right fs-sm ms-2"></i></button>
                </div>
            </form>
    </div>
</div>
@endsection
