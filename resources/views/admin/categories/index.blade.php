@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Categories</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Categories</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-12 col-md-12 col-xs-12">
            <div class="card">
                <div class="card-body">

                    <div class="d-flex justify-content-end">
                        <a href="{{  url('/admin/categories/create') }}" class="btn btn-success btn-sm mb-2" data-title="Add New Category">Add new Category</a>
                    </div>
                    <div class="table-responsive row">
                        <table class="table  border-light col-12" id="categoriesDatatable" data-ajax-url="{{ url('/admin/categories-list') }}">
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
