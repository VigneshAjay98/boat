@php
    $uri = $_SERVER['REQUEST_URI'];
    $uri = explode('/', $uri);
@endphp
@extends('layouts.front-layout')

@section('content')
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
                <div class="step {{ (request()->routeIs('step-three')) ? 'active' : '' }}">
                    <div class="step-progress"><span class="step-progress-start"></span><span class="step-progress-end"></span><span class="step-number">3</span></div>
                    <div class="step-label">Details 2</div>
                </div>
                <div class="step">
                    <div class="step-progress"><span class="step-progress-start"></span><span class="step-progress-end"></span><span class="step-number">4</span></div>
                    <div class="step-label">Photos & Location</div>
                </div>
                @if(empty($secondDetails) || $secondDetails->payment_status=='unpaid')
                <div class="step">
                    <div class="step-progress"><span class="step-progress-start"></span><span class="step-progress-end"></span><span class="step-number">5</span></div>
                    <div class="step-label">Payment</div>
                </div>
                @endif
              </div>
            </div>
            <!-- Page title-->
            <div class="text-center pb-4 mb-3">
                <h1 class="h2 mb-4">“It’s all in the Details (2 of 2)”</h1>
                <p class="mb-4">Continue adding details of the vessel.  Be as descriptive as you can with these fields. <br/> Our search system will use your text for keywords to search for prospective buyers.</p>
            </div>
            <!-- Step 2: Details-->
            <form method="post" action="{{ route('step-three-submit') }}" id="stepThreeForm">
            @csrf
                <input type="hidden" name="boat_uuid" value={{ (!empty($secondDetails) && $secondDetails->payment_status=='paid') ? $secondDetails->uuid : '' }}>
                <div class="bg-light rounded-3 p-4 p-md-5 mb-3">
                    <!-- <h2 class="h4 mb-4"><i class="fi-file-clean text-primary fs-4 mt-n1 me-2 pe-1"></i>Details 2</h2> -->
                    <div class="row">
                        <div class="col-lg-12 col-xs-12 mb-3">
                            <label class="form-label text-dark" for="generalDescription">General Description <span class="text-danger">*</span></label>
                            <textarea class="summernote" id="generalDescription" name="general_description" required>{{ (!empty($secondDetails) && !empty($secondDetails->general_description)) ? $secondDetails->general_description : old('general_description') }}</textarea>
                            <span class="general_description-error"></span>
                            @if ($errors->has('general_description'))
                                <div class="error text-danger">
                                    {{ $errors->first('general_description') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-xs-12 mb-3">
                            <label class="form-label text-dark" for="mechanicalEquipment">Mechanical Equipment</label>
                            @if(!empty($secondDetails) && !empty($secondDetails->otherInformation->mechanical_equipment))
                                <textarea class="summernote" id="mechanicalEquipment" name="mechanical_equipment">{{ $secondDetails->otherInformation->mechanical_equipment }}</textarea>
                            @else
                                <textarea class="summernote" id="mechanicalEquipment" name="mechanical_equipment">{{ old('mechanical_equipment') }}</textarea>
                            @endif
                            @if ($errors->has('mechanical_equipment'))
                                <div class="error text-danger">
                                    {{ $errors->first('mechanical_equipment') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-xs-12 mb-3">
                            <label class="form-label text-dark" for="deckHullEquipment">Deck & Hull Equipment</label>
                            @if(!empty($secondDetails) && !empty($secondDetails->otherInformation->deck_hull_equipment))
                                <textarea class="summernote" id="deckHullEquipment" name="deck_hull_equipment">{{ $secondDetails->otherInformation->deck_hull_equipment }}</textarea>
                            @else
                                <textarea class="summernote" id="deckHullEquipment" name="deck_hull_equipment">{{ old('duckHull_equipment') }}</textarea>
                            @endif
                            @if ($errors->has('deck_hull_equipment'))
                                <div class="error text-danger">
                                    {{ $errors->first('deck_hull_equipment') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-xs-12 mb-3">
                            <label class="form-label text-dark" for="navigationSystems">Navigation Systems</label>
                            @if(!empty($secondDetails) && !empty($secondDetails->otherInformation->navigation_systems))
                                <textarea class="summernote" id="navigationSystems" name="navigation_systems" >{{ $secondDetails->otherInformation->navigation_systems }}</textarea>
                            @else
                                <textarea class="summernote" id="navigationSystems" name="navigation_systems" >{{ old('navigation_systems') }}</textarea>
                            @endif
                            @if ($errors->has('navigation_systems'))
                                <div class="error text-danger">
                                    {{ $errors->first('navigation_systems') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-xs-12 mb-3">
                            <label class="form-label text-dark" for="additionalEquipment">Additional Equipment</label>
                            @if(!empty($secondDetails) && !empty($secondDetails->otherInformation->additional_equipment))
                                <textarea class="summernote" id="additionalEquipment" name="additional_equipment" >{{ $secondDetails->otherInformation->additional_equipment }}</textarea>
                            @else
                                <textarea class="summernote" id="additionalEquipment" name="additional_equipment">{{ old('additional_equipment') }}</textarea>
                            @endif
                            @if ($errors->has('additional_equipment'))
                                <div class="error text-danger">
                                    {{ $errors->first('additional_equipment') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <!-- Navigation-->
                <div class="d-flex flex-column justify-content-end flex-sm-row bg-light rounded-3 px-md-5">
                    <a href="{{ (!empty($secondDetails) && $secondDetails->payment_status=='paid') ? route('step-two', ['boat_uuid' => $secondDetails->uuid ]) : route('step-two') }}" class="btn btn-secondary btn-lg d-block mb-2 me-2"><i class="fi-chevron-left fs-sm me-2"></i>PREVIOUS</a>
                    <button class="btn btn-dark btn-lg d-block mb-2 me-2" name="exit" value="1" type="submit">SAVE & EXIT</button>
                    <button class="btn btn-primary btn-lg d-block mb-2 me-2" name="next" value="1" type="submit">SAVE & CONTINUE <i class="fi-chevron-right fs-sm ms-2"></i></button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
