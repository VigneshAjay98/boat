@extends('layouts.app')

@section('content')
<div class="container">

	<div class="row">
		<div class="col-12">
			<div class="page-title-box d-sm-flex align-items-center justify-content-between">
				<h4 class="mb-sm-0 font-size-18">Brands</h4>
				<div class="page-title-right">
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Home</a></li>
						<li class="breadcrumb-item active">Brands</li>
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
						<button data-href="{{ url('/admin/brands/create') }}" class="btn btn-success btn-sm mb-2 open-model-btn" data-title="Add new brand" data-bs-toggle="modal" data-bs-target="#boatModalBox">Add new Brand</button>
					</div>
                    <div class="table-responsive row">
                        <table class="table border-light col-12" id="brandsDatatable" data-ajax-url="{{ url('/admin/brands-list') }}">
                            <thead class="table-light">
                                <tr>
                                    <th>Brand Name</th>
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
