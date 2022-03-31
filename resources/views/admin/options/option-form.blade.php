@if(@$option)
<form method="PUT" action="{{ url('/admin/options/'.$option->uuid) }}" id="optionForm">
<input name="_method" type="hidden" value="PUT">
<input type="hidden" name="uuid" value="{{ $option->uuid }}">
@else
<form method="POST" action="{{  url('/admin/options') }}" id="optionForm">
@endif
    @csrf
    <div class="form-floating mb-3">
        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"  placeholder="Option Name" aria-label="Option Name" value="{{ (@$option) ? $option->name : old('name') }}">
        <label for="name">Option Name</label>
        <div class="error text-danger" id="name_error"> </div>
    </div>

	<div class="form-floating mb-3">
        <select class="form-select " id="option_type" aria-label="Select Option Type" name="option_type">
            <option value="" disabled selected>-- Select Option Type --</option>
            {{-- <option value="boat_type" {{ (@$option->option_type=='boat_type') ? 'selected' : '' }}>Boat Type</option> --}}
            <option value="hull_material" {{ (@$option->option_type=='hull_material') ? 'selected' : '' }}>Hull Material</option>
            <option value="boat_activity" {{ (@$option->option_type=='boat_activity') ? 'selected' : '' }}>Boat Activity</option>
        </select>
        <label for="option_type">Option Type</label>
        <div class="error text-danger" id="option_type_error"> </div>
    </div>

    <div>
        <button class="btn btn-success mx-2 btn-lg float-end save-data" type="submit">Save</button>
        <button class="btn btn-dark btn-lg float-end" type="reset">Reset</button>
    </div>

</form>
