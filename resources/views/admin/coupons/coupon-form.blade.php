@extends('layouts.app')
@section('content')

<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">{{ (isset($coupon)) ? __('Edit Coupon') : __('Add New Coupon') }}</h4>
			<div class="page-title-right">
				<ol class="breadcrumb m-0">
					<li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Home</a></li>
					<li class="breadcrumb-item"><a href="{{ url('/admin/coupons') }}">Coupons</a></li>
					<li class="breadcrumb-item active">{{ (isset($coupon)) ? __('Edit Coupon') : __('Create Coupon') }}</li>
				</ol>
			</div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
	    <div class="clearfix">&nbsp;</div>
        @if(isset($coupon))
        <form method="POST" action="{{ url('/admin/coupons/'.$coupon->id) }}">
            <input name="_method" type="hidden" value="PUT">
            <input type="hidden" name="id" value="{{ $coupon->id }}">
        @else
        <form method="POST" action="{{  url('/admin/coupons') }}">
        @endif
            @csrf
            <div class="row">
                <div class="col-lg-12 col-xs-12">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control @error('code') is-invalid @enderror" id="code" name="code"  placeholder="Coupons Code" aria-label="Coupons Code" value="{{ (old('code')) ? old('code') : ((isset($coupon)) ? $coupon->code : '') }}">
                        <label for="code">Coupon Code</label>
                        @if ($errors->has('code'))
                        <div class="error text-danger">
                            {{ $errors->first('code') }}
                        </div>
                        @endif
                    </div>
                </div>
            </div>
             <div class="row">
                <div class="col-lg-6 col-xs-12">
                    <div class="form-floating mb-3">
                        <select class="form-select " id="type" aria-label="Select Coupon Type" name="type">
                            <option selected disabled>-- Select Coupon Type --</option>
                            <option value="percentage" {{ (old('type') == "percentage") ? 'selected' : ((isset($coupon) && $coupon->type == 'percentage') ? 'selected' : '') }}>Percentage</option>
                            <option value="fixed" {{ (old('type') == "fixed") ? 'selected' : ((isset($coupon) && $coupon->type == 'fixed') ? 'selected' : '') }}>Fixed</option>
                            <option value="free" {{ (old('type') == "free") ? 'selected' : ((isset($coupon) && $coupon->type == 'free') ? 'selected' : '') }}>Free</option>
                        </select>
                        <label for="type">Select Coupon Type</label>
                        @if ($errors->has('type'))
                        <div class="error text-danger">
                            {{ $errors->first('type') }}
                        </div>
                        @endif
                    </div>
                </div>

                <div class="col-lg-6 col-xs-12">
                    <div class="form-floating mb-3">
                        <input type="number" class="form-control @error('amount') is-invalid @enderror" id="amount" name="amount"  placeholder="Coupons Code" aria-label="Coupons Code" value="{{ (old('amount')) ? old('amount') : ((isset($coupon)) ? $coupon->amount : '') }}">
                        <label for="amount">Amount</label>
                        @if ($errors->has('amount'))
                            <div class="error text-danger">
                                {{ $errors->first('amount') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- <div class="row">
                <div class="col-lg-12 col-xs-12">
                    <div class="form-floating mb-3">
                        <input type="date" class="form-control @error('expiry_date') is-invalid @enderror" id="stripeCouponId" name="expiry_date"  placeholder="Expiry Date" aria-label="Expiry Date" value="{{ (old('expiry_date')) ? old('expiry_date') : ((isset($coupon)) ? $coupon->expiry_date : '') }}">
                        <label for="expiry_date">Expiry Date</label>
                        @if ($errors->has('expiry_date'))
                            <div class="error text-danger">
                                {{ $errors->first('expiry_date') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div> -->
            <div class="row">
                <div class="my-3">
                    <button type="submit" class="btn btn-success btn-lg float-end">Save</button>
                    <button class="btn btn-dark mx-2 btn-lg float-end" type="reset">Reset</button>
                </div>
            </div>
        </form>
	</div>
</div>
@endsection



