@extends('layouts.app')
@section('content')

<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">{{ (isset($plan)) ? __('Edit Plan') : __('Add New Plan') }}</h4>
			<div class="page-title-right">
				<ol class="breadcrumb m-0">
					<li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Home</a></li>
					<li class="breadcrumb-item"><a href="{{ url('/admin/plans') }}">Plans</a></li>
					<li class="breadcrumb-item active">{{ (isset($plan)) ? __('Edit Plan') : __('Create Plan') }}</li>
				</ol>
			</div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
	    <div class="clearfix">&nbsp;</div>
        @if(isset($plan))
        <form method="POST" action="{{ url('/admin/plans/'.$plan->uuid) }}">
            <input name="_method" type="hidden" value="PUT">
            <input type="hidden" name="uuid" value="{{ $plan->uuid }}">
        @else
        <form method="POST" action="{{  url('/admin/plans') }}">
        @endif
            @csrf
            <div class="row">
                <div class="col-lg-12 col-xs-12">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"  placeholder="Plans Name" aria-label="Plans Name" value="{{ (old('name')) ? old('name') : ((isset($plan)) ? $plan->name : '') }}">
                        <label for="name">Plan Name</label>
                        @if ($errors->has('name'))
                        <div class="error text-danger">
                            {{ $errors->first('name') }}
                        </div>
                        @endif
                    </div>
                </div>
            </div>
             <div class="row">
                <div class="col-lg-6 col-xs-12">
                    <div class="form-floating mb-3">
                        <input type="number" class="form-control @error('price') is-invalid @enderror" id="price" name="price"  placeholder="Plans Name" aria-label="Plans Name" value="{{ (old('price')) ? old('price') : ((isset($plan)) ? $plan->price : '') }}">
                        <label for="price">Plan Price</label>
                        @if ($errors->has('price'))
                        <div class="error text-danger">
                            {{ $errors->first('price') }}
                        </div>
                        @endif
                    </div>
                </div>

                <div class="col-lg-6 col-xs-12">
                    <div class="form-floating mb-3">
                        <input type="number" class="form-control @error('duration_weeks') is-invalid @enderror" id="duration_weeks" name="duration_weeks"  placeholder="Duration In Weeks" aria-label="Duration In Weeks" value="{{ (old('duration_weeks')) ? old('duration_weeks') : ((isset($plan)) ? $plan->duration_weeks : '') }}">
                        <label for="duration_weeks">Duration in weeks</label>
                        @if ($errors->has('duration_weeks'))
                            <div class="error text-danger">
                                {{ $errors->first('duration_weeks') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-lg-6 col-xs-12">
                    <div class="form-floating mb-3">
                        <input type="number" class="form-control @error('image_number') is-invalid @enderror" id="image_number" name="image_number"  placeholder="Number Of Images " aria-label="Number Of Images " value="{{ (old('image_number')) ? old('image_number') : ((isset($plan)) ? $plan->image_number : '') }}">
                        <label for="image_number">Number Of Images </label>
                        @if ($errors->has('image_number'))
                        <div class="error text-danger">
                            {{ $errors->first('image_number') }}
                        </div>
                        @endif
                    </div>
                </div>
                <div class="col-lg-6 col-xs-12">
                    <div class="form-floating mb-3">
                            <input type="number" class="form-control @error('video_number') is-invalid @enderror" id="video_number" name="video_number"  placeholder="Number Of Images " aria-label="Number Of Videos " value="{{ (old('video_number')) ? old('video_number') : ((isset($plan)) ? $plan->video_number : '') }}">
                            <label for="video_number">Number Of Videos </label>
                            @if ($errors->has('video_number'))
                            <div class="error text-danger">
                                {{ $errors->first('video_number') }}
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



