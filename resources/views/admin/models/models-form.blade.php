@if(@$model)
    <form method="post" action="{{ url('/admin/models/'.$model->uuid) }}" autocomplete="off" id="optionForm">
    <input name="_method" type="hidden" value="PUT">
    <input name="uuid" type="hidden" value="{{ $model->uuid }}">
@else
    <form method="post" action="{{  url('/admin/models') }}" id="optionForm">
@endif
    @csrf
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="form-floating mb-3">
                <input type="text" class="form-control @error('model_name') is-invalid @enderror" id="model_name" name="model_name" placeholder="Brand Name" aria-label="Brand Name" value="{{ (isset($model)) ? $model->model_name : old('model_name') }}">
                <label for="model_name">Name</label>
                <div class="error text-danger " id = "model_name_error"></div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="form-floating mb-3">
                {{-- <textarea type="text" class="form-control @error('description') is-invalid @enderror" id="description" name="description" placeholder="Description" aria-label="Description">{{ (@$model) ? $model->description : old('description') }}</textarea> --}}
                <select class="form-select" id="brand_slug" aria-label="Select Brand" name="brand_slug" value="">
                    <option value=""  selected disabled>Select Brand</option>
                    @foreach ($brands as $brand)
                        <option value="{{ $brand->slug }}" {{ (!empty($model) && isset($model->brand->slug)) ? ( ($model->brand->slug == $brand->slug) ? 'selected': '' ) : ((old('brand_slug') == $brand->slug) ? 'selected': '' )}}>{{ $brand->name }}</option>
                    @endforeach
                </select>
                <label for="brand_slug">Select Brand</label>
                <div class="error text-danger" id="brand_slug_error"></div>
            </div>
        </div>
    </div>
    <div>
        <button class="btn btn-success mx-2 btn-lg float-end save-data" type="submit">Save</button>
        <button class="btn btn-dark btn-lg float-end" type="reset">Reset</button>
    </div>
    </div>
</form>
