@extends('layouts.front-layout')

@section('content')
    @php
    $defaultConfigPlan =  config('yatchfindr.defaults.DEFAULT_PLAN_ID');
    $planCost = 0;
    $planUuid = '';

    @endphp
    <div class="container mt-5 mb-md-4 py-5">
        <!-- Title + Breadcrumb-->
        <nav class="mb-3 pt-md-3" aria-label="Breadcrumb">
            <ol class="breadcrumb breadcrumb-dark">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="javascript:0;">Sell Your Yacht</a></li>
                <li class="breadcrumb-item active" aria-current="page">Plans</li>
            </ol>
        </nav>
        <h1 class="h2 text-dark mb-4">Plans</h1>
        <h2 class="h3 text-dark pb-2 mb-4">Choose your perfect plan</h2>
        <div class="row">

            @foreach($plans as $plan)
                @php
                    if($plan->id== $defaultConfigPlan){
                        $planCost = $plan->price;
                        $planUuid = $plan->uuid;
                    }
                @endphp
            <div class="col-md-4 mb-4">
                <div class="card card-dark border-dark plan-card" style="min-height: 332px;">
                    <div class="card-body">
                        <h2 class="h5 text-dark fw-normal text-center py-1 mb-0 text-capitalize">{{ $plan->name }}</h2>
                        <div class="d-flex align-items-end justify-content-center mb-4">
                            <div class="h1 text-dark mb-0">${{ $plan->price }}</div>
                        </div>
                        <ul class="list-unstyled d-block mb-0 mx-1" style="max-width: 16rem;">
                            <li class="d-flex"><i class="fi-clock fs-sm mt-1 me-2"></i><span class="text-dark">{{ $plan->duration_weeks }}&nbsp;weeks</span></li>
                            <li class="d-flex"><i class="fi-camera-plus fs-sm mt-1 me-2"></i><span class="text-dark">
                            @if(empty($plan->image_number))
                                {{ 'Unlimited Photos' }}
                            @elseif($plan->image_number > 1)
                                {{ $plan->image_number.' photos'}}
                            @else
                                {{ $plan->image_number.' photo'}}
                            @endif
                            </span></li>
                            @if($plan->video_number !== 0)
                                <li class="d-flex"><i class="fi-video fs-sm mt-1 me-2"></i><span class="text-dark">
                                @if(empty($plan->video_number))
                                    {{ 'Unlimited Videos' }}
                                @elseif($plan->video_number > 1)
                                    {{ $plan->video_number.' videos'}}
                                @else
                                    {{ $plan->video_number.' video'}}
                                @endif
                                </span></li>
                            @endif
                        </ul>
                    </div>
                    <div class="card-footer py-2 border-0">
                        <div class="border-top border-dark text-center pt-4 pb-3 plan-select" data-uuid="{{ $plan->uuid }}" data-price="{{ $plan->price }}" data-ajax-url="{{ url('/') }}"><a class="btn {{ ($plan->id== $defaultConfigPlan) ? 'btn-primary' : 'btn-outline-dark' }} plan-btn">Choose plan</a></div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <form method="post" action="{{ route('select-plan') }}" id="planForm">
            @csrf
        <input type="hidden" id="is_coupon_valid" name="is_coupon_valid" value="false">
            <div class="addOns-list">
                @php
                    $totalAddOnCost = 0;
                    $idCount = 0;
                @endphp

                @if(count($planAddOns) > 0 )
                    
                    @foreach($planAddOns as $planAddOn)
                            <div class="card card-dark card-hover card-body px-4 mb-2">
                                <div class="form-check form-check-dark">
                                    <input class="form-check-input addOn-check" type="checkbox" data-addon-uuid="{{ $planAddOn->uuid }}" data-addon-cost="{{ $planAddOn->addon_cost }}" id="addOn{{ ++$idCount }}">
                                    <label class="form-check-label d-sm-flex align-items-center justify-content-between" for="addOn{{ $idCount }}"><span class="d-block px-1"><span class="d-block h6 text-dark mb-2">{{ $planAddOn->addon_name }}</span></span><span class="d-block h4 text-dark mb-0">${{ $planAddOn->addon_cost }}</span></label>
                                </div>
                            </div>
                            @php
                                $planCost = $planAddOn->plan->price;
                                $planUuid = $planAddOn->plan->uuid;
                            @endphp
                    @endforeach
                @endif
            </div>
            <input type="hidden" class="real_cost" value="{{ $planCost }}">
            <input type="hidden" id="default_selected_plan" name="default_selected_plan" value="{{ $planCost }}">
            <input type="hidden" id="default_addon_selected" name="default_addon_selected" value="0">
            <input type="hidden" id="default_coupon_selected" name="default_coupon_selected" value="0">
            
            
            <input type="hidden" class="discount_value" id="discount_value" value="">
            <input name="overall_cost" type="hidden" value="{{ sprintf('%0.2f', $planCost) }}">
            <input class="plan-uuid" name="plan_uuid" type="hidden" value="{{ $planUuid }}">
            <!-- <div class="discount-calculation-div">
            </div> -->
            <div class="clearfix">&nbsp;</div>
             <div class="row mb-1 coupon-label-div">
                <div class="d-flex flex-column justify-content-between flex-sm-row">
                    <label class="form-check-label fw-bold apply-coupon-msg" for="coupon_code">Apply Coupon Code!</label>
                    <label class="form-check-label fw-bold d-none coupon-applied-msg" for="coupon_code">Coupon Applied!</label>
                </div>
            </div>
            <div class="row">
                <div class="row planForm-last">
                    <div class="col-lg-5 col-xs-12 mb-3">
                        <div class="input-group" id="coupon_code_section">
                            <span class="input-group-text">
                                <i class="fi-alert-circle text-warning coupon-warning-icon"></i>
                                <i class="fi-check text-success d-none coupon-success-icon"></i>
                            </span>
                            <input type="text" class="form-control" placeholder="Coupon Code" id="coupon_code" name="coupon_code" autocomplete="off" autocorrect="off" value="{{ old('coupon_code') }}">
                            <button type="button" class="btn btn-outline-primary d-block coupon-verify-btn">
                                <span class="spinner-border spinner-border-sm me-2 d-none coupon-spinner" role="status" aria-hidden="true"></span>VERIFY
                            </button>
                            <!-- <button type="button" class="btn btn-outline-primary d-block d-none remove-coupon">
                                <span class="fi-x"></span>
                            </button> -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" id="subTotalAmountLabelDiv">
                <div class="text-dark text-end">Sub Total : $<span class="subTotalAmountLabel">{{ sprintf('%0.2f', $planCost) }}<span></div>
            </div>
            <div class="row" id="discountAmountLabelDiv">
                <div class="text-dark text-end">Discount : $<span class="discountAmountLabel">{{ sprintf('%0.2f', 0) }}<span></div>
            </div>

            <div class="row">
                <div class="h4 text-dark text-end">Total: $<span class="show-overallCost">{{ sprintf('%0.2f', $planCost) }}<span></div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-xs-12 d-flex flex-column align-self-right justify-content-end flex-sm-row">
                    <button class="btn btn-primary btn-lg mb-2 me-2 submit-plan" type="submit">Submit</button> 
                </div>
            </div>
        </form>
    </div>

@endsection
