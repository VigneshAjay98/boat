@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Options</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Options</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-12 col-md-12 col-xs-12">
            <div class="card">
                <div class="card-body">

                    <div class="d-flex justify-content-between mb-2">
                        <div>
                            <select class="form-select " id="select_option_type" aria-label="Select Option Type" name="select_option_type">
                                <option value="">All</option>
                                {{-- <option value="boat_type" {{ (@$option->option_type=='boat_type') ? 'selected' : '' }}>Boat Type</option> --}}
                                <option value="hull_material" {{ (@$option->option_type=='hull_material') ? 'selected' : '' }}>Hull Material</option>
                                <option value="boat_activity" {{ (@$option->option_type=='boat_activity') ? 'selected' : '' }}>Boat Activity</option>
                            </select>
                            <div class="error text-danger" id="select_option_type_error"> </div>
                        </div>
                        <a class="btn btn-success btn-sm mb-2 open-model-btn" data-href="{{  url('/admin/options/create') }}" data-title="Add new Option" data-bs-toggle="modal" data-bs-target="#boatModalBox">Add new Option</a>
                    </div>
                    <div class="table-responsive row">
                        <table class="table border-light col-12" id="optionsDatatable" data-ajax-url="{{ url('/admin/options-list') }}">
                            <thead class="table-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
