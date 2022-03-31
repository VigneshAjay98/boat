@extends('layouts.app')

@section('content')
<div class="container">

	<div class="row">
		<div class="col-12">
			<div class="page-title-box d-sm-flex align-items-center justify-content-between">
				<h4 class="mb-sm-0 font-size-18">Plan Addons</h4>
				<div class="page-title-right">
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Home</a></li>
						<li class="breadcrumb-item active">Plan Addons</li>
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
                        <a href="{{  url('/admin/plan-addons/create') }}" class="btn btn-success btn-sm mb-2" data-title="Add New Plan Addons">Add new Plan Addons</a>
                    </div>
                    <div class="table-responsive row">
                        <table class="table border-light col-12" id="planAddonsDatatable" data-ajax-url="{{ url('/admin/plan-addons-list') }}">
                            <thead class="table-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Plan Name</th>
                                    <th>Addon Cost</th>
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
