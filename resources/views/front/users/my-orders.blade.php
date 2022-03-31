@extends('layouts.front-layout')

@section('content')
    <div class="container step-four-file-container mt-5 mb-md-4 py-5">
        <!-- Breadcrumb-->
        <nav class="mb-4 pt-md-3" aria-label="Breadcrumb">
            <ol class="breadcrumb breadcrumb-dark">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">My Orders</li>
            </ol>
        </nav>
        <!-- Page content-->
        <div class="row">
            @include('layouts.partials.front-sidebar')
            <!-- Content-->
            <div class="col-lg-8 col-xs-12 mb-5">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h1 class="h2 text-dark mb-0">My Orders</h1>
                </div>
                <!-- Item-->
                <div class="row justify-content-center">
                    <div class="col-lg-12 col-xs-12">
                        <div class="card">
                            <div class="card-body">
                                <table class="table table-sm border-light" id="myOrdersDatatable" data-ajax-url="{{ route('my-orders-list') }}">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Invoice ID</th>
                                            <th>Order Date</th>
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
    </div>
@endsection
