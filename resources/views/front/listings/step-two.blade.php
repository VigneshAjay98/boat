@php
    $uri = $_SERVER['REQUEST_URI'];
    $uri = explode('/', $uri);
@endphp
@extends('layouts.front-layout')

@section('content')
<form method="post" action="{{ route('step-two-submit') }}" id="stepTwoForm" novalidate>
@csrf
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
                <div class="step {{ (request()->routeIs('step-two')) ? 'active' : '' }}">
                    <div class="step-progress"><span class="step-progress-start"></span><span class="step-progress-end"></span><span class="step-number">2</span></div>
                    <div class="step-label">Details</div>
                </div>
                <div class="step">
                    <div class="step-progress"><span class="step-progress-start"></span><span class="step-progress-end"></span><span class="step-number">3</span></div>
                    <div class="step-label">Details 2</div>
                </div>
                <div class="step">
                    <div class="step-progress"><span class="step-progress-start"></span><span class="step-progress-end"></span><span class="step-number">4</span></div>
                    <div class="step-label">Photos & Location</div>
                </div>
                @if(empty($details) ||  $details->payment_status=='unpaid')
                <div class="step">
                    <div class="step-progress"><span class="step-progress-start"></span><span class="step-progress-end"></span><span class="step-number">5</span></div>
                    <div class="step-label">Payment</div>
                </div>
                @endif
            </div>
            </div>
            <!-- Page title-->
            <div class="text-center pb-4 mb-3">
                <h1 class="h2 mb-4">“It’s all in the Details (1 of 2)”</h1>
                <p class="mb-4">Now, let’s get down to the details; this will help us match your vessel to prospective buyers. <br/> Enter as many details as possible to create the best listing.</p>
            </div>
            <!-- Step 2: Details-->

            <div class="bg-light">
                <!-- <h2 class="h4 mb-4"><i class="fi-file text-primary fs-4 mt-n1 me-2 pe-1"></i>Details</h2> -->
                <div class="row well">
                    <h2 class="h2 mb-4">Engines</h2>
                    @if(count($details->engines) > 0)
                        @php
                            $sectionCount = 0;
                        @endphp
                        @foreach($details->engines as $key => $engine)
                            @php
                                $sectionCount++;
                                if($key==0) {
                                    $asterisk = '<span class="text-danger">*</span>';
                                }else {
                                    $asterisk = '';
                                }
                            @endphp
                            <div id="engineSection{{ $sectionCount }}" class="engineSection pb-2">
                                <div class="row">
                                    <div class="d-flex justify-content-between">
                                        <h6 class="h6 mb-4">Engine&nbsp;<span id="engineCount">{{ $sectionCount }}</span></h6>
                                        <button class="btn btn-outline-danger btn-icon del-engine {{ (count($details->engines) > 1) ? '' : 'd-none' }} mb-3 me-2" type="button" id="delEngine"><i class="fi-trash"></i></button>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6 col-xs-6 mb-3">
                                        <label class="form-label text-dark" for="engineType{{ $sectionCount }}">Engine Type&nbsp;{!! $asterisk !!}</label>
                                        <select class="form-select form-select-dark select-engine" id="engineType{{ $sectionCount }}" name="engine_type{{ $sectionCount }}" required>
                                            <option value=" " selected disabled>-- Select Engine Type --</option>
                                            <option value="electric" {{ ($engine->engine_type=='electric') ? 'selected' : ((old('engine_type1')=="electric") ? 'selected' : '') }}>Electric</option>
                                            <option value="inboard" {{ ($engine->engine_type=='inboard') ? 'selected' : ((old('engine_type1')=="inboard") ? 'selected' : '') }}>Inboard</option>
                                            <option value="outboard" {{ ($engine->engine_type=='outboard') ? 'selected' : ((old('engine_type1')=="outboard") ? 'selected' : '') }}>Outboard</option>
                                            <option value="other" {{ ($engine->engine_type=='other') ? 'selected' : ((old('engine_type1')=="other") ? 'selected' : '') }}>Other</option>
                                        </select>
                                        @if ($sectionCount==1 && $errors->has('engine_type1'))
                                            <div class="error text-danger">
                                                {{ $errors->first('engine_type1') }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-lg-6 col-xs-6 mb-3">
                                        <label class="form-label text-dark" for="fuelType{{ $sectionCount }}">Fuel Type&nbsp;{!! $asterisk !!}</label>
                                        <select class="form-select form-select-dark select-fuel" id="fuelType{{ $sectionCount }}" name="fuel_type{{ $sectionCount }}" required>
                                            <option value=" " selected disabled>-- Select Fuel Type --</option>
                                            <option value="diesel" {{ ($engine->fuel_type=='diesel') ? 'selected' : ((old('fuel_type1')=="diesel") ? 'selected' : '') }}>Diesel</option>
                                            <option value="electric" {{ ($engine->fuel_type=='electric') ? 'selected' : ((old('fuel_type1')=="electric") ? 'selected' : '') }}>Electric</option>
                                            <option value="gasoline" {{ ($engine->fuel_type=='gasoline') ? 'selected' : ((old('fuel_type1')=="gasoline") ? 'selected' : '') }}>Gasoline</option>
                                            <option value="lpg" {{ ($engine->fuel_type=='lpg') ? 'selected' : ((old('fuel_type1')=="lpg") ? 'selected' : '') }}>LPG</option>
                                            <option value="other" {{ ($engine->fuel_type=='other') ? 'selected' : ((old('fuel_type1')=="other") ? 'selected' : '') }}>Other</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-xs-6 mb-3">
                                        <label class="form-label text-dark" for="engineMake{{ $sectionCount }}">Engine Make&nbsp;{!! $asterisk !!}</label>
                                        <input class="form-control form-control-dark" type="text" id="engineMake{{ $sectionCount }}" name="make{{ $sectionCount }}" value="{{ $engine->make }}" placeholder="Engine Make" autocomplete="off" autocorrect="off" required>
                                    </div>
                                    <div class="col-lg-6 col-xs-6 mb-3">
                                        <label class="form-label text-dark" for="engineModel{{ $sectionCount }}">Engine Model&nbsp;{!! $asterisk !!}</label>
                                        <input class="form-control form-control-dark" type="text" id="engineModel{{ $sectionCount }}" name="model{{ $sectionCount }}" value="{{ $engine->model }}" placeholder="Engine Model" autocomplete="off" autocorrect="off" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-xs-6 mb-3">
                                        <label class="form-label text-dark" for="horsePower{{ $sectionCount }}">Horse Power (hp)&nbsp;{!! $asterisk !!}</label>
                                        <input class="form-control form-control-dark" type="number" id="horsePower{{ $sectionCount }}" name="horse_power{{ $sectionCount }}" value="{{ $engine->horse_power }}" placeholder="Horse power" required>
                                    </div>
                                    <div class="col-lg-6 col-xs-6 mb-3">
                                        <label class="form-label text-dark" for="engineHours{{ $sectionCount }}">Engine Hours&nbsp;{!! $asterisk !!}</label>
                                        <input class="form-control form-control-dark engine-hours" type="number" id="engineHours{{ $sectionCount }}" name="engine_hours{{ $sectionCount }}" value="{{ $engine->engine_hours }}" placeholder="Engine Hours" required>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div id="engineSection1" class="engineSection pb-2">
                            <div class="row">
                                <div class="d-flex justify-content-between">
                                    <h6 class="h6 mb-4">Engine&nbsp;<span id="engineCount">1</span></h6>
                                    <button class="btn btn-outline-danger btn-icon del-engine d-none mb-3 me-2" type="button" id="delEngine"><i class="fi-trash"></i></button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-xs-6 mb-3">
                                    <label class="form-label text-dark" for="engineType1">Engine Type&nbsp;<span class="text-danger">*</span></label>
                                    <select class="form-select form-select-dark select-engine" id="engineType1" name="engine_type1" required>
                                        <option value=" " selected disabled>-- Select Engine Type --</option>
                                        <option value="electric" {{ (old('engine_type1')=="electric") ? 'selected' : '' }}>Electric</option>
                                        <option value="inboard" {{ (old('engine_type1')=="inboard") ? 'selected' : '' }}>Inboard</option>
                                        <option value="outboard" {{ (old('engine_type1')=="outboard") ? 'selected' : '' }}>Outboard</option>
                                        <option value="other" {{ (old('engine_type1')=="other") ? 'selected' : '' }}>Other</option>
                                    </select>
                                    @if ($errors->has('engine_type1'))
                                        <div class="error text-danger">
                                            {{ $errors->first('engine_type1') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="col-lg-6 col-xs-6 mb-3">
                                    <label class="form-label text-dark" for="fuelType1">Fuel Type&nbsp;<span class="text-danger">*</span></label>
                                    <select class="form-select form-select-dark select-fuel" id="fuelType1" name="fuel_type1" required>
                                        <option value=" " selected disabled>-- Select Fuel Type --</option>
                                        <option value="diesel" {{ (old('fuel_type1')=="diesel") ? 'selected' : '' }}>Diesel</option>
                                        <option value="electric" {{ (old('fuel_type1')=="electric") ? 'selected' : '' }}>Electric</option>
                                        <option value="gasoline" {{ (old('fuel_type1')=="gasoline") ? 'selected' : '' }}>Gasoline</option>
                                        <option value="lpg" {{ (old('fuel_type1')=="lpg") ? 'selected' : '' }}>LPG</option>
                                        <option value="other" {{ (old('fuel_type1')=="other") ? 'selected' : '' }}>Other</option>
                                    </select>
                                    @if ($errors->has('fuel_type1'))
                                        <div class="error text-danger">
                                            {{ $errors->first('fuel_type1') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-xs-6 mb-3">
                                    <label class="form-label text-dark" for="engineMake1">Engine Make&nbsp;<span class="text-danger">*</span></label>
                                    <input class="form-control form-control-dark engine-make" type="text" id="engineMake1" name="make1" placeholder="Engine Make" autocomplete="off" autocorrect="off" value="{{ old('make1') }}" required>
                                    @if ($errors->has('make1'))
                                        <div class="error text-danger">
                                            {{ $errors->first('make1') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="col-lg-6 col-xs-6 mb-3">
                                    <label class="form-label text-dark" for="engineModel1">Engine Model&nbsp;<span class="text-danger">*</span></label>
                                    <input class="form-control form-control-dark engine-model" type="text" id="engineModel1" name="model1" placeholder="Engine Model" autocomplete="off" autocorrect="off" value="{{ old('model1') }}" required>
                                    @if ($errors->has('model1'))
                                        <div class="error text-danger">
                                            {{ $errors->first('model1') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-xs-6 mb-3">
                                    <label class="form-label text-dark" for="horsePower1">Horse power (hp)&nbsp;<span class="text-danger">*</span></label>
                                    <input class="form-control form-control-dark engine-horse-power" type="number" id="horsePower1" name="horse_power1" placeholder="Horse power" value="{{ old('horse_power1') }}" required>
                                    @if ($errors->has('horse_power1'))
                                        <div class="error text-danger">
                                            {{ $errors->first('horse_power1') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="col-lg-6 col-xs-6 mb-3">
                                    <label class="form-label text-dark engine-hours" for="engineHours1">Engine Hours&nbsp;<span class="text-danger">*</span></label>
                                    <input class="form-control form-control-dark engine-hours" type="number" id="engineHours1" name="engine_hours1" placeholder="Engine Hours" value="{{ old('engine_hours1') }}" required>
                                    @if ($errors->has('engine_hours1'))
                                        <div class="error text-danger">
                                            {{ $errors->first('engine_hours1') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="row mx-4 mx-md-0">
                        <div class="col-lg-12 col-xs-12 d-flex justify-content-end">
                            <a class="btn btn-primary btn-sm ms-2 float-end" href="javascript:void(0)" id="addNewEngine"><i class="fi-plus me-2"></i>ADD ANOTHER</a>
                            <a class="btn btn-primary btn-sm ms-2" href="javascript:void(0)" id="addEngine"><i class="fi-plus me-2"></i>DUPLICATE</a>
                        </div>
                    </div>
                </div>
                <div class="clearfix">&nbsp;</div>
                <div class="row">
                    <div class="col-sm-12 mb-3">
                        <label class="form-label text-dark" for="hullMaterial">Hull Type <span class="text-danger">*</span></label>
                        <select class="form-select form-select-dark" id="hullMaterial" name="hull_material" required>
                                <option value="" selected disabled>-- Select Hull Material --</option>
                            @foreach($hull_materials as $hull_material)
                                @if(!empty($details) && !empty($details->hull_material))
                                    <option class="text-capitalize" value="{{ $hull_material->name }}" {{ ($hull_material->name==$details->hull_material) ? 'selected' : '' }}>{{ $hull_material->name }}</option>
                                @else
                                    <option class="text-capitalize" value="{{ $hull_material->name }}" {{ (old('hull_material')==$hull_material->name) ? 'selected' : '' }}>{{ $hull_material->name }}</option>
                                @endif
                            @endforeach
                        </select>
                        <span id="hullMaterial-error" class="d-none error">Hull Type is required.</span>
                        @if ($errors->has('hull_material'))
                            <div class="error text-danger">
                                {{ $errors->first('hull_material') }}
                            </div>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-xs-6 mb-3">
                        <div class="form-check form-check-dark">
                            @if(!empty($details) && !empty($details->otherInformation->anchor_type))
                                <input class="form-check-input anchor-check" type="checkbox" id="anchorCheck" name="anchor_check" checked>
                            @else
                                <input class="form-check-input anchor-check" type="checkbox" id="anchorCheck" name="anchor_check">
                            @endif
                            <label class="form-check-label" for="anchorCheck">Windlass/Anchor</label>
                            @if ($errors->has('anchor_check'))
                                <div class="error text-danger">
                                    {{ $errors->first('anchor_check') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-12 col-xs-12 mb-3 {{ (!empty($details) && !empty($details->otherInformation->anchor_type)) ? '' : 'd-none' }} anchor-type">
                        <label class="form-label text-dark" for="anchorType">Anchor Type <span class="text-danger">*</span></label>
                        <select class="form-select form-select-dark select-anchor" id="anchorType" name="anchor_type">
                            <option value="" selected disabled>-- Select Anchor Type --</option>
                            @if(!empty($details) && !empty($details->otherInformation->anchor_type))
                                <option value="Windlass" {{ ($details->otherInformation->anchor_type=='Windlass') ? 'selected' : '' }}>Windlass</option>
                                <option value="Fluke" {{ ($details->otherInformation->anchor_type=='Fluke') ? 'selected' : '' }}>Fluke</option>
                                <option value="Plow" {{ ($details->otherInformation->anchor_type=='Plow') ? 'selected' : '' }}>Plow</option>
                                <option value="Other" {{ ($details->otherInformation->anchor_type=='Other') ? 'selected' : '' }}>Other</option>
                            @else
                                <option value="Windlass" {{ (old('anchor_type')=='Windlass') ? 'selected' : '' }}>Windlass</option>
                                <option value="Fluke" {{ (old('anchor_type')=='Fluke') ? 'selected' : '' }}>Fluke</option>
                                <option value="Plow" {{ (old('anchor_type')=='Plow') ? 'selected' : '' }}>Plow</option>
                                <option value="Other" {{ (old('anchor_type')=='Other') ? 'selected' : '' }}>Other</option>
                            @endif
                        </select>
                        <!-- <span id="anchorType-error" class="d-none error">Anchor Type is required.</span> -->
                        @if ($errors->has('anchor_type'))
                            <div class="error text-danger">
                                {{ $errors->first('anchor_type') }}
                            </div>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-xs-6 mb-3">
                        <div class="form-check form-check-dark">
                            @if(!empty($details) && !empty($details->otherInformation->head))
                                <input class="form-check-input head-check" type="checkbox" id="headCheck" name="head_check" checked>
                            @else
                                <input class="form-check-input head-check" type="checkbox" id="headCheck" name="head_check">
                            @endif
                            <label class="form-check-label" for="headCheck">Head</label>
                            @if ($errors->has('head_check'))
                                <div class="error text-danger">
                                    {{ $errors->first('head_check') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-12 col-xs-12 mb-3 {{ (!empty($details) && !empty($details->otherInformation->head)) ? '' : 'd-none' }} head-section">
                        <label class="form-label text-dark" for="head">Head Count</label>
                        @if(!empty($details) && !empty($details->otherInformation->head))
                            <input class="form-control form-control-dark" type="number" id="head" name="head" placeholder="Head" autocomplete="off" autocorrect="off" value="{{ $details->otherInformation->head }}">
                        @else
                            <input class="form-control form-control-dark" type="number" id="head" name="head" placeholder="Head" autocomplete="off" autocorrect="off" value="{{ old('head') }}">
                        @endif
                        @if ($errors->has('head'))
                            <div class="error text-danger">
                                {{ $errors->first('head') }}
                            </div>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-xs-6 mb-3">
                        <label class="form-label text-dark" for="fuelCapacity">Fuel Capacity (GAL) <span class="text-danger">*</span></label>
                        @if(!empty($details) && !empty($details->otherInformation->fuel_capacity))
                            <input class="form-control form-control-dark" type="number" id="fuelCapacity" name="fuel_capacity" value="{{ $details->otherInformation->fuel_capacity }}" placeholder="Fuel Capacity">
                        @else
                            <input class="form-control form-control-dark" type="number" id="fuelCapacity" name="fuel_capacity" value="{{ old('fuel_capacity') }}" placeholder="Fuel Capacity">
                        @endif
                        <span id="fuelCapacity-error" class="d-none error">Fuel Capacity is required.</span>
                        @if ($errors->has('fuel_capacity'))
                            <div class="error text-danger">
                                {{ $errors->first('fuel_capacity') }}
                            </div>
                        @endif
                    </div>
                    <div class="col-lg-6 col-xs-6 mb-3">
                        <label class="form-label text-dark" for="tank">Tanks</label>
                        @if(!empty($details) && !empty($details->otherInformation->tanks))
                            <input class="form-control form-control-dark" type="number" id="tank" name="tank" min="1" value="{{ $details->otherInformation->tanks }}" placeholder="Tanks">
                        @else
                            <input class="form-control form-control-dark" type="number" id="tank" name="tank" min="1" value="{{ old('tank') }}" placeholder="Tanks">
                        @endif
                        <span id="tank-error" class="d-none error">Fuel Capacity is required.</span>
                        @if ($errors->has('tank'))
                            <div class="error text-danger">
                                {{ $errors->first('tank') }}
                            </div>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-xs-6 mb-3">
                        <label class="form-label text-dark" for="freshWater">Fresh Water (GAL)</label>
                        @if(!empty($details) && !empty($details->otherInformation->fresh_water))
                            <input class="form-control form-control-dark" type="number" id="freshWater" name="fresh_water" value="{{ $details->otherInformation->fresh_water }}" placeholder="Fresh Water">
                        @else
                            <input class="form-control form-control-dark" type="number" id="freshWater" name="fresh_water" value="{{ old('fresh_water') }}" placeholder="Fresh Water">
                        @endif
                        @if ($errors->has('fresh_water'))
                            <div class="error text-danger">
                                {{ $errors->first('fresh_water') }}
                            </div>
                        @endif
                    </div>
                    <div class="col-lg-6 col-xs-6 mb-3">
                        <label class="form-label text-dark" for="holding">Holding (GAL)</label>
                        @if(!empty($details) && !empty($details->otherInformation->holding))
                            <input class="form-control form-control-dark" type="number" id="holding" name="holding" value="{{ $details->otherInformation->holding }}" placeholder="Holding">
                        @else
                            <input class="form-control form-control-dark" type="number" id="holding" name="holding" value="{{ old('holding') }}" placeholder="Holding">
                        @endif
                        @if ($errors->has('holding'))
                            <div class="error text-danger">
                                {{ $errors->first('holding') }}
                            </div>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-xs-6 mb-3">
                        <label class="form-label text-dark" for="cruisingSpeed">Cruising Speed </label>
                        @if(!empty($details) && !empty($details->otherInformation->cruising_speed))
                            <input class="form-control form-control-dark" type="number" id="cruisingSpeed" name="cruising_speed" value="{{ $details->otherInformation->cruising_speed }}" placeholder="Cruising Speed">
                        @else
                            <input class="form-control form-control-dark" type="number" id="cruisingSpeed" name="cruising_speed" value="{{ old('cruising_speed') }}" placeholder="Cruising Speed">
                        @endif
                        @if ($errors->has('cruising_speed'))
                            <div class="error text-danger">
                                {{ $errors->first('cruising_speed') }}
                            </div>
                        @endif
                    </div>
                    <div class="col-lg-6 col-xs-6 mb-3">
                        <label class="form-label text-dark" for="maxSpeed">Max Speed</label>
                        @if(!empty($details) && !empty($details->otherInformation->max_speed))
                            <input class="form-control form-control-dark" type="number" id="maxSpeed" name="max_speed" value="{{ $details->otherInformation->max_speed }}" placeholder="Max Speed">
                        @else
                            <input class="form-control form-control-dark" type="number" id="maxSpeed" name="max_speed" value="{{ old('max_speed') }}" placeholder="Max Speed">
                        @endif
                        @if ($errors->has('max_speed'))
                            <div class="error text-danger">
                                {{ $errors->first('max_speed') }}
                            </div>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-xs-12 mb-3">
                        <label class="form-label text-dark" for="loa">LOA (ft)</label>
                        @if(!empty($details) && !empty($details->otherInformation->LOA))
                            <input class="form-control form-control-dark" type="number" id="loa" name="loa" value="{{ $details->otherInformation->LOA }}" placeholder="LOA">
                        @else
                            <input class="form-control form-control-dark" type="number" id="loa" name="loa" value="{{ old('loa') }}" placeholder="LOA">
                        @endif
                        @if ($errors->has('loa'))
                            <div class="error text-danger">
                                {{ $errors->first('loa') }}
                            </div>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-xs-12 mb-3">
                        <label class="form-label text-dark" for="hullId">Hull ID</label>
                        @if($details && $details->otherInformation  && !empty($details->otherInformation['12_digit_HIN']))
                            <input class="form-control form-control-dark" type="text" id="hullId" name="hull_id" maxlength="12" value="{{ $details->otherInformation['12_digit_HIN'] }}" placeholder="12 Digit HIN" autocomplete="off" autocorrect="off">
                        @else
                            <input class="form-control form-control-dark" type="text" id="hullId" name="hull_id"  maxlength="12" value="{{ old('hull_id') }}" placeholder="12 Digit HIN" autocomplete="off" autocorrect="off">
                        @endif
                        @if ($errors->has('hull_id'))
                            <div class="error text-danger">
                                {{ $errors->first('hull_id') }}
                            </div>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-xs-12 mb-3">
                        <label class="form-label text-dark" for="boatName">Vessel Name</label>
                        @if(!empty($details) && !empty($details->boat_name))
                            <input class="form-control form-control-dark" type="text" id="boatName" name="boat_name" value="{{ $details->boat_name }}" placeholder="Vessel Name">
                        @else
                            <input class="form-control form-control-dark" type="text" id="boatName" name="boat_name" value="{{ old('boat_name') }}" placeholder="Vessel Name">
                        @endif
                        @if ($errors->has('boat_name'))
                            <div class="error text-danger">
                                {{ $errors->first('boat_name') }}
                            </div>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-xs-12 mb-3">
                        <label class="form-label text-dark" for="designer">Designer</label>
                        @if(!empty($details) && !empty($details->otherInformation->designer))
                            <input class="form-control form-control-dark" type="text" id="designer" name="designer" placeholder="Designer" autocomplete="off" autocorrect="off" value="{{ $details->otherInformation->designer }}">
                        @else
                            <input class="form-control form-control-dark" type="text" id="designer" name="designer" placeholder="Designer" autocomplete="off" autocorrect="off" value="{{ old('designer') }}">
                        @endif
                        @if ($errors->has('designer'))
                            <div class="error text-danger">
                                {{ $errors->first('designer') }}
                            </div>
                        @endif
                    </div>
                </div>
                @php
                    $electricalSystemConfig = config('yatchfindr.defaults.ELECTRICAL_SYSTEM');
                    $electricalSystem = $details->otherInformation->electrical_system;
                @endphp
                <div class="row  mb-3">
                    <div class="col-sm-12 mb-3">
                        <label class="form-label text-dark" for="electrical_system">Electrical System</label>
                    </div>
                    
                    
                    @if(!empty($details) && !empty($details->otherInformation->electrical_system))
                        @php
                            $electricalSystemsStored = explode(",", $details->otherInformation->electrical_system);
                        @endphp
                        @foreach($electricalSystemConfig as $key => $electricalConfig)
                            <div class="col-sm-2">
                                <div class="form-check form-check-dark">
                                    @php
                                        $ischecked = '';
                                        if(in_array($electricalConfig, $electricalSystemsStored)) {
                                            $ischecked = 'checked';
                                        }
                                    @endphp
                                    <input class="form-check-input" type="checkbox" id="electrical_system" name="electrical_system[]" {{ $ischecked }} value="{{ $electricalConfig }}">
                                  <label class="form-check-label">{{ $electricalConfig }}</label>
                                </div>
                            </div>
                        @endforeach
                    @else
                        @foreach($electricalSystemConfig as $electricalConfig)
                            <div class="col-sm-2">
                                <div class="form-check form-check-dark">
                                  <input class="form-check-input" type="checkbox" id="electrical_system" name="electrical_system[]" value="{{ $electricalConfig }}">
                                  <label class="form-check-label">{{ $electricalConfig }}</label>
                                </div>
                            </div>
                        @endforeach
                    @endif

                  <!-- <div class="col-sm-2">
                        <div class="form-check form-check-dark">
                          <input class="form-check-input" type="checkbox" id="electrical_system" name="electrical_system[]" value="110 VAC">
                          <label class="form-check-label">110 VAC</label>
                        </div>
                  </div>
                  <div class="col-sm-2">
                        <div class="form-check form-check-dark">
                          <input class="form-check-input" type="checkbox" id="electrical_system" name="electrical_system[]" value="220 VAC">
                          <label class="form-check-label">220 VAC</label>
                        </div>
                  </div> -->

                </div>
                {{-- <div class="row">
                    <div class="col-sm-12 mb-3">
                        <label class="form-label text-dark" for="electrical_system">Electrical System</label>
                        <select class="form-select form-select-dark select-electrical-system" id="electrical_system" name="electrical_system">
                            <option value=" " selected disabled>-- Select Electrical System --</option>
                            @if(!empty($details) && !empty($details->otherInformation->electrical_system))
                                <option value="12 VDC" {{ ($details->otherInformation->electrical_system=='12 VDC') ? 'selected' : '' }}>12 VDC</option>
                                <option value="110 VAC" {{ ($details->otherInformation->electrical_system=='110 VAC') ? 'selected' : '' }}>110 VAC</option>
                                <option value="220 VAC" {{ ($details->otherInformation->electrical_system=='220 VAC') ? 'selected' : '' }}>220 VAC</option>
                            @else
                                <option value="12 VDC" {{ (old('electrical_system')=='12 VDC') ? 'selected' : '' }}>12 VDC</option>
                                <option value="110 VAC" {{ (old('electrical_system')=='110 VAC') ? 'selected' : '' }}>110 VAC</option>
                                <option value="220 VAC" {{ (old('electrical_system')=='220 VAC') ? 'selected' : '' }}>220 VAC</option>
                            @endif
                        </select>
                        @if ($errors->has('electrical_system'))
                            <div class="error text-danger">
                                {{ $errors->first('electrical_system') }}
                            </div>
                        @endif
                    </div>
                </div> --}}
                <div class="row">
                    <div class="col-lg-6 col-xs-6 mb-3">
                        <div class="form-check form-check-dark">
                            @if(!empty($details) && !empty($details->otherInformation->generator_fuel_type))
                                <input class="form-check-input generator-check" type="checkbox" id="generatorCheck" name="generator_check" checked>
                            @else
                                <input class="form-check-input generator-check" type="checkbox" id="generatorCheck" name="generator_check">
                            @endif
                            <label class="form-check-label fw-bold" for="generatorCheck">Generator</label>
                            @if ($errors->has('generator_check'))
                                <div class="error text-danger">
                                    {{ $errors->first('generator_check') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="{{ (!empty($details) && !empty($details->otherInformation->generator_fuel_type)) ? '' : 'd-none' }} generator-section">
                    <div class="row">
                        <div class="col-lg-4 col-xs-12 mb-3">
                            <label class="form-label text-dark" for="generator_fuel_type">Fuel Type <span class="text-danger">*</span></label>
                            <select class="form-select form-select-dark" id="generator_fuel_type" name="generator_fuel_type">
                                <option value="" selected disabled>-- Select Fuel Type --</option>
                                @if(!empty($details) && !empty($details->otherInformation->generator_fuel_type))
                                    <option value="gas" {{ ($details->otherInformation->generator_fuel_type=='gas') ? 'selected' : '' }}>Gas</option>
                                    <option value="diesel" {{ ($details->otherInformation->generator_fuel_type=='diesel') ? 'selected' : '' }}>Diesel</option>
                                    <option value="inverter" {{ ($details->otherInformation->generator_fuel_type=='inverter') ? 'selected' : '' }}>Inverter</option>
                                @else
                                    <option value="gas" {{ (old('generator_fuel_type')=='gas') ? 'selected' : '' }}>Gas</option>
                                    <option value="diesel" {{ (old('generator_fuel_type')=='diesel') ? 'selected' : '' }}>Diesel</option>
                                    <option value="inverter" {{ (old('generator_fuel_type')=='inverter') ? 'selected' : '' }}>Inverter</option>
                                @endif
                            </select>
                            <span id="generator_fuel_type-error" class="d-none error">Generator Fuel Type is required.</span>
                            @if ($errors->has('generator_fuel_type'))
                                <div class="error text-danger">
                                    {{ $errors->first('generator_fuel_type') }}
                                </div>
                            @endif
                        </div>
                        <div class="col-lg-4 col-xs-12 mb-3">
                            <label class="form-label text-dark" for="generator_size">Generator Size (kW) <span class="text-danger">*</span></label>
                            @if(!empty($details) && !empty($details->otherInformation->generator_size))
                                <input class="form-control form-control-dark" type="number" id="generator_size" name="generator_size" placeholder="Generator Size" autocomplete="off" autocorrect="off" value="{{ $details->otherInformation->generator_size }}">
                            @else
                                <input class="form-control form-control-dark" type="number" id="generator_size" name="generator_size" placeholder="Generator Size" autocomplete="off" autocorrect="off" value="{{ old('generator_size') }}">
                            @endif
                            <span id="generator_size-error" class="d-none error">Generator Size is required.</span>
                            @if ($errors->has('generator_size'))
                                <div class="error text-danger">
                                    {{ $errors->first('generator_size') }}
                                </div>
                            @endif
                        </div>
                        <div class="col-lg-4 col-xs-12  mb-3">
                            <label class="form-label text-dark" for="generator_hours">Hours <span class="text-danger">*</span></label>
                            @if(!empty($details) && !empty($details->otherInformation->generator_hours))
                                <input class="form-control form-control-dark" type="number" id="generator_hours" name="generator_hours" placeholder="Hours" autocomplete="off" autocorrect="off" value="{{ $details->otherInformation->generator_hours }}">
                            @else
                                <input class="form-control form-control-dark" type="number" id="generator_hours" name="generator_hours" placeholder="Hours" autocomplete="off" autocorrect="off" value="{{ old('generator_hours') }}">
                            @endif
                            <span id="generator_hours-error" class="d-none error">Generator Hours is required.</span>
                            @if ($errors->has('generator_hours'))
                                <div class="error text-danger">
                                    {{ $errors->first('generator_hours') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-xs-6 mb-3">
                        <div class="form-check form-check-dark">
                            @if(!empty($details) && !empty($details->otherInformation->cabin_berths))
                                <input class="form-check-input cabin-check" type="checkbox" id="cabinCheck" name="cabin_check" checked>
                            @else
                                <input class="form-check-input cabin-check" type="checkbox" id="cabinCheck" name="cabin_check">
                            @endif
                            <label class="form-check-label fw-bold" for="cabinCheck">Cabin</label>
                            @if ($errors->has('generator_check'))
                                <div class="error text-danger">
                                    {{ $errors->first('generator_check') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row {{ (!empty($details) && !empty($details->otherInformation->cabin_berths)) ? '' : 'd-none' }} cabin-section">
                    <div class="col-sm-12 mb-3">
                        <label class="form-label text-dark" for="berths">Number of Berths <span class="text-danger">*</span></label>
                        @if(!empty($details) && !empty($details->otherInformation->cabin_berths))
                            <input class="form-control form-control-dark" type="number" id="berths" name="cabin_berths" placeholder="Berths" autocomplete="off" autocorrect="off" value="{{ $details->otherInformation->cabin_berths }}">
                        @else
                            <input class="form-control form-control-dark" type="number" id="berths" name="cabin_berths" placeholder="Berths" autocomplete="off" autocorrect="off" value="{{ old('cabin_berths') }}">
                        @endif
                        <span id="berths-error" class="d-none error">Berths is required.</span>
                        @if ($errors->has('cabin_berths'))
                            <div class="error text-danger">
                                {{ $errors->first('cabin_berths') }}
                            </div>
                        @endif
                    </div>
                    <div class="col-lg-12 col-xs-12 mb-3 cabin-description-section">
                        <label class="form-label text-dark" for="cabinDescription">Cabin Description <span class="text-danger">*</span></label>
                        @if(!empty($details) && !empty($details->otherInformation->cabin_description))
                            <textarea class="summernote" id="cabinDescription" name="cabin_description">{{ $details->otherInformation->cabin_description }}</textarea>
                        @else
                            <textarea class="summernote" id="cabinDescription" name="cabin_description">{{ old('cabin_description') }}</textarea>
                        @endif
                        <span class="cabin_description-error"></span>
                        @if ($errors->has('cabin_description'))
                            <div class="error text-danger">
                                {{ $errors->first('cabin_description') }}
                            </div>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-xs-6 mb-3">
                        <div class="form-check form-check-dark">
                            @if(!empty($details) && !empty($details->otherInformation->galley_description))
                                <input class="form-check-input galley-check" type="checkbox" id="galleyCheck" name="galley_check" checked>
                            @else
                                <input class="form-check-input galley-check" type="checkbox" id="galleyCheck" name="galley_check">
                            @endif
                            <label class="form-check-label fw-bold" for="galleyCheck">Galley</label>
                            @if ($errors->has('galley_check'))
                                <div class="error text-danger">
                                    {{ $errors->first('galley_check') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row {{ (!empty($details) && !empty($details->otherInformation->galley_description)) ? '' : 'd-none' }} galley-section">
                    <div class="col-lg-12 col-xs-12 mb-3">
                        <label class="form-label text-dark" for="galleyDescription">Galley Description <span class="text-danger">*</span></label>
                        @if(!empty($details) && !empty($details->otherInformation->galley_description))
                            <textarea class="summernote" id="galleyDescription" name="galley_description">{{ $details->otherInformation->galley_description }}</textarea>
                        @else
                            <textarea class="summernote" id="galleyDescription" name="galley_description">{{ old('galley_description') }}</textarea>
                        @endif
                        <span class="galley_description-error"></span>
                        @if ($errors->has('galley_description'))
                            <div class="error text-danger">
                                {{ $errors->first('galley_description') }}
                            </div>
                        @endif
                    </div>
                </div>
                <input type="hidden" name="boat_uuid" value={{ (!empty($details) && $details->payment_status=='paid') ? $details->uuid : '' }}>
            </div>


        </div>
    </div>
    <!-- Navigation-->
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex flex-column justify-content-end flex-sm-row bg-light">
                <a href="{{ (!empty($details) && $details->payment_status=='paid') ? route('step-one', ['boat_uuid' => $details->uuid ]) : route('step-one') }}" class="btn btn-secondary btn-lg d-block mb-2 me-2"><i class="fi-chevron-left fs-sm"></i>PREVIOUS</a>
                <button class="btn btn-dark btn-lg d-block mb-2  me-2" name="exit" value="1" type="submit">SAVE & EXIT</button>
                <button class="btn btn-primary btn-lg d-block mb-2 " name="next" value="1" type="submit">SAVE & CONTINUE <i class="fi-chevron-right fs-sm ms-2"></i></button>
            </div>
        </div>
    </div>
    <!-- Navigation-->
</div>


</form>
@endsection
