@if(@$brand)
    <form method="post" action="{{ url('/admin/brands/'.$brand->uuid) }}" autocomplete="off" id="optionForm">
    <input name="_method" type="hidden" value="PUT">
    <input name="uuid" type="hidden" value="{{ $brand->uuid }}">
@else
    <form method="post" action="{{  url('/admin/brands') }}" id="optionForm">
@endif
    @csrf
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="form-floating mb-3">
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Brand Name" name="name"  aria-label="Brand Name" value="{{ (isset($brand)) ? $brand->name : old('name') }}">
                <label for="name">Name</label>
                <div class="error text-danger" id="name_error"></div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="form-floating mb-3">
                <textarea type="text" class="form-control @error('description') is-invalid @enderror" id="description" name="description" placeholder="Description" aria-label="Description" style="height: 100px">{{ (isset($brand)) ? $brand->description : old('description') }}</textarea>
                <label for="description">Description</label>
                <div class="error text-danger" id="description_error"></div>
            </div>
        </div>
    </div>
    <div class="row">
        <div>
            <button class="btn btn-success mx-2 btn-lg save-data float-end" type="submit">Save</button>
            <button class="btn btn-dark btn-lg float-end" type="reset">Reset</button>
        </div>
    </div>
</form>

