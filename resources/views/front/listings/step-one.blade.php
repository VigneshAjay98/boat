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
                <div class="step {{ (request()->routeIs('step-one')) ? 'active' : '' }}">
                    <div class="step-progress"><span class="step-progress-start"></span><span class="step-progress-end"></span><span class="step-number">1</span></div>
                    <div class="step-label">Basic info</div>
                </div>
                <div class="step">
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
                @if(empty($basicInfo) || $basicInfo->payment_status=='unpaid')
                <div class="step">
                    <div class="step-progress"><span class="step-progress-start"></span><span class="step-progress-end"></span><span class="step-number">5</span></div>
                    <div class="step-label">Payment</div>
                </div>
                @endif
            </div>
        </div>
        <!-- Page title-->
        <div class="text-center pb-4 mb-3">
            <h1 class="h2 mb-4">Just the basics.</h1>
            <p class="mb-4">To get started we need just a bit about the vessel you are planning to sell.</p>
        </div>
        <!-- Step 1: Basic Info-->
        <form method="post" action="{{ route('step-one-submit') }}"  id="stepOneForm">
            @csrf
            <input type="hidden" name="boat_uuid" value={{ (!empty($basicInfo) && $basicInfo->payment_status=='paid') ? $basicInfo->uuid : '' }}>
            <div class="bg-light rounded-3 p-4 p-md-5 mb-3">
                <h2 class="h4 mb-4"><i class="fi-info-circle text-primary fs-5 mt-n1 me-2"></i>Basic info</h2>
                <div class="row mb-4 d-flex justify-content-start">
                    <label class="form-label text-dark" for="length">Boat Type <span class="text-danger">*</span></label>
                    {{-- <div class="col-lg-12 col-sm-6 mb-4 d-flex"> --}}
                        @if(!empty($basicInfo) && !empty($basicInfo->boat_type))
                            <div class="col-lg-2 col-xs-12">
                                <div class="form-check form-check-dark sell-Yatch-radio-card">
                                    <input class="form-check-input boat-type" type="radio" name="boat_type" id="Power" data-uuid="Power" value="Power" {{ ($basicInfo->boat_type=='Power') ? 'checked' : ((old('boat_type')=='Power') ? 'checked' : '') }}>
                                    <label class="form-check-label" for="Power">Power Boats</label>
                                </div>
                            </div>
                            <div class="col-lg-2 col-xs-12">
                                <div class="form-check form-check-dark sell-Yatch-radio-card">
                                    <input class="form-check-input boat-type" type="radio" name="boat_type" id="Sail" data-uuid="Sail" value="Sail" {{ ($basicInfo->boat_type=='Sail') ? 'checked' : ((old('boat_type')=='Sail') ? 'checked' : '') }}>
                                    <label class="form-check-label" for="Sail">Sailboats</label>
                                </div>
                            </div>
                            <div class="col-lg-2 col-xs-12">
                                <div class="form-check form-check-dark sell-Yatch-radio-card">
                                    <input class="form-check-input boat-type" type="radio" name="boat_type" id="personalWatercraft" data-uuid="Personal Watercraft" value="Personal Watercraft" {{ ($basicInfo->boat_type=='Personal Watercraft') ? 'checked' : ((old('boat_type')=='Personal Watercraft') ? 'checked' : '') }}>
                                    <label class="form-check-label" for="personalWatercraft">Personal Watercraft</label>
                                </div>
                            </div>
                        @else
                            <div class="col-lg-2 col-xs-12">
                                <div class="form-check form-check-dark sell-Yatch-radio-card">
                                    <input class="form-check-input boat-type" type="radio" name="boat_type" id="Power" data-uuid="Power" value="Power" checked>
                                    <label class="form-check-label" for="Power">Power Boats</label>
                                </div>
                            </div>
                            <div class="col-lg-2 col-xs-12">
                                <div class="form-check form-check-dark sell-Yatch-radio-card">
                                    <input class="form-check-input boat-type" type="radio" name="boat_type" id="boat_type" data-uuid="Sail" value="Sail" {{ (old('boat_type')=='Sail') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="Sail">Sailboats</label>
                                </div>
                            </div>
                            <div class="col-lg-2 col-xs-12">
                                <div class="form-check form-check-dark sell-Yatch-radio-card">
                                    <input class="form-check-input boat-type" type="radio" name="boat_type" id="personalWatercraft" data-uuid="Personal Watercraft" value="Personal Watercraft" {{ (old('boat_type')=='Personal Watercraft') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="personalWatercraft">Personal Watercraft</label>
                                </div>
                            </div>
                        @endif
                    {{-- </div> --}}
                </div>
                <div class="row">
                    <div class="col-sm-12 mb-3">
                        <label class="form-label text-dark" for="length">Yacht Condition <span class="text-danger">*</span></label>
                        <select class="form-select form-select-dark" id="boatCondition" name="boat_condition" required>
                            <option value="" selected disabled>-- Select Yacht Condition --</option>
                            @if(!empty($basicInfo) && !empty($basicInfo->boat_condition))
                                <option value="New" {{ ($basicInfo->boat_condition=='New') ? 'selected' : ((old('boat_condition')=='New') ? 'selected' : '') }}>New</option>
                                <option value="Used" {{ ($basicInfo->boat_condition=='Used') ? 'selected' : ((old('boat_condition')=='Used') ? 'selected' : '') }}>Used</option>
                                <option value="Salvage Title" {{ ($basicInfo->boat_condition=='Salvage Title') ? 'selected' : ((old('boat_condition')=='Salvage Title') ? 'selected' : '') }}>Salvage Title</option>
                            @else
                                <option value="New" {{ (old('boat_condition')=='New') ? 'selected' : '' }}>New</option>
                                <option value="Used" {{ (old('boat_condition')=='Used') ? 'selected' : '' }}>Used</option>
                                <option value="Salvage Title" {{ (old('boat_condition')=='Salvage Title') ? 'selected' : '' }}>Salvage Title</option>
                            @endif
                        </select>
                        @if ($errors->has('boat_condition'))
                            <div class="error text-danger">
                                {{ $errors->first('boat_condition') }}
                            </div>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 mb-3">
                        <label class="form-label text-dark" for="category">Category <span class="text-danger">*</span></label>
                        <select class="form-select form-select-dark" id="category" name="category" required>
                            <option value="" selected disabled>-- Select Category --</option>
                            @if(!empty($basicInfo) && !empty($basicInfo->category_id))
                                @foreach($selectedCategories as $category)
                                    <option value="{{ $category->uuid }}" {{ ($category->id==$basicInfo->category_id) ? 'selected' : ((old('category')==$category->uuid) ? 'selected' : '') }}>{{ $category->name }}</option>
                                @endforeach
                            @else
                                @foreach($firstCategories as $firstCategory)
                                    <option value="{{ $firstCategory->uuid }}" {{ (old('category')==$firstCategory->uuid) ? 'selected' : '' }}>{{ $firstCategory->name }}</option>
                                @endforeach
                            @endif
                        </select>
                        @if ($errors->has('category'))
                            <div class="error text-danger">
                                {{ $errors->first('category') }}
                            </div>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-xs-12 mb-4">
                        <label class="form-label" for="boatYear">Year <span class="text-danger">*</span></label>
                        <select class="form-select form-select-lg" id="boatYear" name="year" required>
                        @if(!empty($basicInfo) && !empty($basicInfo->year))
                            <option value="" disabled>-- Select Year --</option>
                        @else
                            <option value="" disabled selected>-- Select Year --</option>
                        @endif
                        @for ($year=\Carbon\Carbon::now()->format('Y')+2; $year >= 1950; $year--)
                            @if(!empty($basicInfo) && !empty($basicInfo->year))
                                <option value="{{ $year }}" {{ ($year == $basicInfo->year) ? 'selected' : '' }}>{{ $year }}</option>
                            @else
                                <option value="{{ $year }}" {{ (old('year')==$year) ? 'selected' : '' }}>{{ $year }}</option>
                            @endif
                        @endfor
                        </select>
                        @if ($errors->has('year'))
                            <div class="error text-danger">
                                {{ $errors->first('year') }}
                            </div>
                        @endif
                    </div>
                    <div class="col-lg-4 col-xs-12 mb-4 steps-form-select2">
                        <label class="form-label" for="selectBrand">Make <span class="text-danger">*</span></label>
                        <select class="form-select form-select-lg" id="selectBrand" name="brand" required>
                        @if(isset($brands))
                            @if(!empty($basicInfo) && !empty($basicInfo->brand_id))
                                <option value="" disabled>-- Select Make --</option>
                            @else
                                <option value="" disabled selected>-- Select Make --</option>
                            @endif
                            @foreach($brands as $brand)
                                @if(!empty($basicInfo) && !empty($basicInfo->brand_id))
                                    <option class="text-capitalize" value="{{ $brand->uuid }}" {{ ($brand->uuid == $basicInfo->brand->uuid) ? 'selected' : '' }}>{{ $brand->name }}</option>
                                @else
                                    <option class="text-capitalize" value="{{ $brand->uuid }}" {{ (old('select_brand')==$brand->uuid) ? 'selected' : '' }}>{{ $brand->name }}</option>
                                @endif
                            @endforeach
                        @endif
                        </select>
                        @if ($errors->has('brand'))
                            <div class="error text-danger">
                                {{ $errors->first('brand') }}
                            </div>
                        @endif
                    </div>
                    <div class="col-lg-4 col-xs-12 mb-4 steps-form-select2">
                        <label class="form-label" for="boatModel">Model <span class="text-danger">*</span></label>
                        @if(!empty($basicInfo) && !empty($basicInfo->model))
                            <select class="form-select form-select-lg boat-model " id="boatModel" name="brand_model" required="">
                                <option value="" disabled>-- Select Your Model --</option>
                            @foreach($basicInfo->brandModels as $model)
                                <option value="{{ $model->model_name }}" {{ ($model->model_name == $basicInfo->model) ? 'selected' : '' }}>{{ $model->model_name }}</option>
                            @endforeach
                            {{ $modelName = $basicInfo->model }}
                            @php
                                if(!$basicInfo->brandModels->contains('model_name', $basicInfo->model)){
                                    echo '<option value='.$modelName.' selected>'.$modelName.'</option>';
                                }
                            @endphp
                            </select>
                        @else
                            <select class="form-select form-select-lg boat-model" id="boatModel" name="brand_model" disabled required>
                                <option value="" disabled selected>-- Select Your Model --</option>
                            </select>
                        @endif
                        <span class="brand_model-error"></span>
                        @if ($errors->has('brand_model'))
                            <div class="error text-danger">
                                {{ $errors->first('brand_model') }}
                            </div>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 mb-3">
                        <label class="form-label text-dark" for="length">Length (ft) <span class="text-danger">*</span></label>
                        @if(!empty($basicInfo) && !empty($basicInfo->length))
                            <input class="form-control form-control-dark" type="number" id="length" name="length" placeholder="Length" value="{{ $basicInfo->length }}" required>
                        @else
                            <input class="form-control form-control-dark" type="number" id="length" name="length" placeholder="Length" value="{{ old('length') }}" required>
                        @endif
                        @if ($errors->has('length'))
                            <div class="error text-danger">
                                {{ $errors->first('length') }}
                            </div>
                        @endif
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label class="form-label text-dark" for="beamFeet">Beam (ft)</label>
                        @if(!empty($basicInfo) && !empty($basicInfo->otherInformation->beam_feet))
                            <input class="form-control form-control-dark" type="number" id="beam" name="beam" placeholder="Beam" value="{{ $basicInfo->otherInformation->beam_feet }}">
                        @else
                            <input class="form-control form-control-dark" type="number" id="beam" name="beam" placeholder="Beam" value="{{ old('beam') }}">
                        @endif
                        @if ($errors->has('beam'))
                            <div class="error text-danger">
                                {{ $errors->first('beam') }}
                            </div>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-xs-6 mb-3">
                        <label class="form-label text-dark" for="draft">Draft (ft) <span class="text-danger">*</span></label>
                        @if(!empty($basicInfo) && !empty($basicInfo->otherInformation->draft))
                            <input class="form-control form-control-dark" type="number" id="draft" name="draft" placeholder="Draft" value="{{ $basicInfo->otherInformation->draft }}" required>
                        @else
                            <input class="form-control form-control-dark" type="number" id="draft" name="draft" placeholder="Draft" value="{{ old('draft') }}" required>
                        @endif
                        @if ($errors->has('draft'))
                            <div class="error text-danger">
                                {{ $errors->first('draft') }}
                            </div>
                        @endif
                    </div>
                    <div class="col-lg-6 col-xs-6 mb-3">
                        <label class="form-label text-dark" for="bridgeClearance">Air Draft/Bridge Clearance (ft)</label>
                        @if(!empty($basicInfo) && !empty($basicInfo->otherInformation->bridge_clearance))
                            <input class="form-control form-control-dark" type="number" id="bridgeClearance" name="bridge_clearance" placeholder="Bridge Clearance" value="{{ $basicInfo->otherInformation->bridge_clearance }}">
                        @else
                            <input class="form-control form-control-dark" type="number" id="bridgeClearance" name="bridge_clearance" placeholder="Bridge Clearance" value="{{ old('bridge_clearance') }}">
                        @endif
                        @if ($errors->has('bridge_clearance'))
                            <div class="error text-danger">
                                {{ $errors->first('bridge_clearance') }}
                            </div>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-xs-6 mb-3">
                        <label class="form-label text-dark" for="price">Asking Price <span class="text-danger">*</span></label>
                        @if(!empty($basicInfo) && (!empty($basicInfo->price) || $basicInfo->price==0))
                            <input class="form-control form-control-dark" type="number" id="price" name="price" placeholder="Price" value="{{ $basicInfo->price }}" required>
                        @else
                            <input class="form-control form-control-dark" type="number" id="price" name="price" placeholder="Price" value="{{ old('price') }}" required>
                        @endif
                        @if ($errors->has('price'))
                            <div class="error text-danger">
                                {{ $errors->first('price') }}
                            </div>
                        @endif
                    </div>
                    <div class="col-lg-6 col-xs-6 mb-3">
                        <label class="form-label text-dark" for="currency">Currency <span class="text-danger">*</span></label>
                        <select class="form-select form-select-dark" id="currency" name="price_currency" required>
                            <option value="" selected disabled>-- Select Currency --</option>
                            @foreach(config('currency.CURRENCIES') as $currency)
                                @if(!empty($basicInfo) && !empty($basicInfo->price_currency))
                                    <option value="{{ $currency }}" {{ ($basicInfo->price_currency==$currency) ? 'selected' : ((old('price_currency')==$currency) ? 'selected' : (($currency=='USD') ? 'selected' : '')) }}>{{ $currency }}</option>
                                @else
                                    <option value="{{ $currency }}" {{ (old('price_currency')==$currency) ? 'selected' : (($currency=='USD') ? 'selected' : '') }}>{{ $currency }}</option>
                                @endif
                            @endforeach
                        </select>
                        @if ($errors->has('price_currency'))
                            <div class="error text-danger">
                                {{ $errors->first('price_currency') }}
                            </div>
                        @endif
                    </div>

                </div>
          
            <div class="d-flex flex-column justify-content-end flex-sm-row bg-light">
                @if(empty($basicInfo) || $basicInfo->payment_status=='unpaid')
                    <a href="{{ route('select-plan') }}" class="btn btn-secondary btn-lg d-block mb-2 me-2"><i class="fi-chevron-left fs-sm me-2"></i>PREVIOUS</a>
                @endif
                <button class="btn btn-dark btn-lg d-block mb-2 me-2" name="exit" value="1" type="submit">SAVE & EXIT</button>
                <button class="btn btn-primary btn-lg d-block mb-2 me-2" name="next" value="1" type="submit">SAVE & CONTINUE<i class="fi-chevron-right fs-sm ms-2"></i></button>

            </div>
        </form>
    </div>
</div>
@endsection
