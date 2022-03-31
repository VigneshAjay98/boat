@extends('layouts.front-layout')
@section('content')
	<!-- Breadcrumb-->
    <div class="container mt-5 py-5">
        <!-- Breadcrumb-->
        <nav class="mb-3 pt-md-3" aria-label="Breadcrumb">
            <ol class="breadcrumb breadcrumb-dark">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Categories</li>
            </ol>
        </nav>

        <div class="d-sm-flex align-items-end align-items-md-center	justify-content-between	position-relative mb-4"	style="z-index:	1025;">
            <div class="me-3">
                <h1	class="h2 text-dark"> Browse All Categories</h1>
            </div>
        </div>
        @if (!empty($categoriesList) && (count($categoriesList) > 0) && isset($categoriesList))
            <div class="container border border-0 bg-light mb-5">
                @foreach ($categoriesList as $categoryList)
                    <a href="javascript:0;" class="p-2 btn btn-link character-link" data-character="{{ $categoryList->uuid }}">{{ $categoryList->name }}</a>
                @endforeach
            </div>
        @endif

        @if (!empty($categoriesData) && (count($categoriesData) > 0) && isset($categoriesData))
            <div class="card card-dark border border-0 card-body px-4 mb-2">
                @foreach ($categoriesData as $key => $categoryData)
                    <hr/>
                    @php
                        $setId = (isset($categoryData['uuid']) &&  key_exists('uuid', $categoryData)) ? $categoryData['uuid']: '';
                    @endphp
                    <div class="me-3 mt-3 mb-3" id="{{ $setId }}">
                        @php
                            $setName = (isset($categoryData['name']) &&  key_exists('name', $categoryData)) ? $categoryData['name']: '';
                        @endphp
                        <h1	class="h4 text-dark	mb-md-0"> {{ $setName ?? '' }}</h1>
                    </div>
                    <div class="row">
                        @foreach ($categoryData['list'] as $category)
                            <div class="col-md-2 col-sm-6 px-2">
                                @php
                                    $setCategorySlug = (isset($category['slug']) &&  key_exists('slug', $category)) ? $category['slug']: '';
                                    $setCategoryName = (isset($category['name']) &&  key_exists('name', $category)) ? $category['name']: '';
                                @endphp
                                <a href="{{ url('explore/category/'.($setCategorySlug ?? ''))}}" class="p-2 btn btn-link badge text-wrap  lh-sm">
                                    {{ $setCategoryName ?? '' }}
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
