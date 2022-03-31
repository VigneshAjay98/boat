@extends('layouts.app')
@section('content')

<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">{{ (isset($addon)) ? __('Edit Plan Addon') : __('Add New Plan Addon') }}</h4>
			<div class="page-title-right">
				<ol class="breadcrumb m-0">
					<li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Home</a></li>
					<li class="breadcrumb-item"><a href="{{ url('/admin/plan-addons') }}">Plan Addons</a></li>
					<li class="breadcrumb-item active">{{ (isset($addon)) ? __('Edit Plan') : __('Create Plan Addon') }}</li>
				</ol>
			</div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
	    <div class="clearfix">&nbsp;</div>
        @if(isset($addon))
        <form method="POST" action="{{ url('/admin/plan-addons/'.$addon->uuid) }}">
            <input name="_method" type="hidden" value="PUT">
            <input type="hidden" name="uuid" value="{{ $addon->uuid }}">
        @else
        <form method="POST" action="{{  url('/admin/plan-addons') }}">
        @endif
            @csrf

            <div class="row">
                <div class="col-lg-12 col-xs-12">
                    <div class="form-floating mb-3">
                        <select class="form-select " id="plan_id" aria-label="Select Plan" name="plan_id">
                            <option selected disabled>-- Select Select Plan --</option>
                            @foreach ($plans as $plan )
                                <option value="{{ $plan->id }}" {{ (old('plan_id') == $plan->id) ? 'selected' : ((isset($addon) && $addon->plan_id == $plan->id) ? 'selected' : '') }}>{{ $plan->name }}</option>
                            @endforeach
                        </select>
                        <label for="plan_id">Select Plan</label>
                        @if ($errors->has('plan_id'))
                        <div class="error text-danger">
                            {{ $errors->first('plan_id') }}
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6  col-xs-12">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control @error('addon_name') is-invalid @enderror" id="addon_name" name="addon_name"  placeholder="Plan Addon Name" aria-label="Plans Addon Name" value="{{ (old('addon_name')) ? old('addon_name') : ((isset($addon)) ? $addon->addon_name : '') }}">
                        <label for="addon_name">Plan Addon Name</label>
                        @if ($errors->has('addon_name'))
                        <div class="error text-danger">
                            {{ $errors->first('addon_name') }}
                        </div>
                        @endif
                    </div>
                </div>
                <div class="col-lg-6 col-xs-12">
                    <div class="form-floating mb-3">
                        <input type="number" class="form-control @error('addon_cost') is-invalid @enderror" id="addon_cost" name="addon_cost"  placeholder="Plans Name" aria-label="Plans Name" value="{{ (old('addon_cost')) ? old('addon_cost') : ((isset($addon)) ? $addon->addon_cost : '') }}">
                        <label for="addon_cost">Plan Addon Cost</label>
                        @if ($errors->has('addon_cost'))
                        <div class="error text-danger">
                            {{ $errors->first('addon_cost') }}
                        </div>
                        @endif
                    </div>
                </div>
            </div>
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



