@extends('layouts.app')
@section('content')

<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">{{ (isset($category)) ? __('Edit Category') : __('Add New Category') }}</h4>
			<div class="page-title-right">
				<ol class="breadcrumb m-0">
					<li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Home</a></li>
					<li class="breadcrumb-item"><a href="{{ url('/admin/categories') }}">Categories</a></li>
					<li class="breadcrumb-item active">{{ (isset($category)) ? __('Edit Category') : __('Create Category') }}</li>
				</ol>
			</div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
	<div class="clearfix">&nbsp;</div>
	    @if(isset($category))
		<form method="POST" action="{{ url('/admin/categories/'.$category->uuid) }}" enctype="multipart/form-data">
		<input name="_method" type="hidden" value="PUT">
		<input type="hidden" name="uuid" value="{{ $category->uuid }}">
		@else
		<form method="POST" action="{{  url('/admin/categories') }}" enctype="multipart/form-data">
		@endif
	    @csrf
        <div class="row">
            <div class="col-lg-12 col-xs-12">
            	<div class="form-floating mb-3">

					<input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"  placeholder="Category Name" aria-label="Category Name" value="{{ (old('name')) ? old('name') : ((isset($category)) ? $category->name : '') }}">
					<label for="name">Category Name</label>
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
					<select class="form-select " id="boat_type" aria-label="Select Category Type" name="boat_type">
						<option selected disabled>-- Select Boat Type --</option>
						<option value="Power" {{ (old('boat_type') == "Power") ? 'selected' : ((isset($category) && $category->boat_type == 'Power') ? 'selected' : '') }}>Power Boats</option>
						<option value="Sail" {{ (old('boat_type') == "Sail") ? 'selected' : ((isset($category) && $category->boat_type == 'Sail') ? 'selected' : '') }}>Sailboats</option>
						<option value="Personal Watercraft" {{ (old('boat_type') == "Personal Watercraft") ? 'selected' : ((isset($category) && $category->boat_type == 'Personal Watercraft') ? 'selected' : '') }}>Personal Watercraft</option>
					</select>
					<label for="boat_type">Boat Type</label>
					@if ($errors->has('boat_type'))
                    <div class="error text-danger">
                        {{ $errors->first('boat_type') }}
                    </div>
                    @endif
				</div>
            </div>

            <div class="col-lg-6 col-xs-12">
            	<div class="form-floating mb-3">
					<select class="form-select " id="activity" aria-label="Select Activity" name="activity">
							<option selected disabled>-- Select Activity --</option>
						@foreach($activities as $activity)
							<option class="text-capitalize" value="{{ $activity->uuid }}"{{(old('activity') == $activity->uuid) ? 'selected' : ((isset($category) && isset($category->activities->option_id) && $activity->id == $category->activities->option_id) ? 'selected' : '') }}>{{ $activity->name }}</option>
						@endforeach
					</select>
					<label for="activity">Activity</label>
					@if ($errors->has('activity'))
                    <div class="error text-danger">
                        {{ $errors->first('activity') }}
                    </div>
                    @endif
				</div>
            </div>
        </div>

        <div class="row">

        </div>

        <div class="row">
        	<div class="col-lg-12 col-xs-12">
                <div class="form-floating mb-3">
                    <textarea class="summernote" name="description" id="categoryDescription">{{ (old('description')) ? old('description') : ((isset($category)) ? $category->description : '' ) }}</textarea>
                    @if ($errors->has('description'))
                    <div class="error text-danger">
                        {{ $errors->first('description') }}
                    </div>
                    @endif
                </div>
            </div>
            <div class="col-lg-12 col-xs-12">
            	<div class="form-floating mb-3">
                    {{ $otherInformationDescription ?? '' }}
					<textarea class="form-control" id="other_information" name="other_information" placeholder="Other Information" style="height: 140px">{{ (old('other_information')) ? old('other_information') : ((isset($category)) ? $category->other_info : '' ) }}</textarea>
					<label for="floatingTextarea">Other Information</label>
					@if ($errors->has('other_information'))
                    <div class="error text-danger">
                        {{ $errors->first('other_information') }}
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




