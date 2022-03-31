@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Users</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Users</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-12 col-md-12 col-xs-12">
            <div class="card">
                <div class="card-body">
                    {{-- <div class="d-flex justify-content-between mb-2">
                        <div>
                            <select class="form-select " id="selectUserRole" aria-label="Select User Role" name="select_user_role">
                                <option value="admin">Admin</option>
                                <option value="user">Users</option>
                                <option value="" >All</option>
                            </select>
                            <div class="error text-danger" id="selectUserRoleError"> </div>
                        </div>
                    </div> --}}
                    <div class="d-flex justify-content-end">
                        <a href="{{ url('admin/users/create') }}" class="btn btn-success btn-sm mb-2">Add new User</a>
                    </div>
                    <div class="table-responsive row">
                        <table class="table border-light col-12" id="usersDatatable" data-ajax-url="{{ url('/admin/users-list') }}">
                            <thead class="table-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
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
