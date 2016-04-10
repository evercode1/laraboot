@extends('layouts.master')

@section('title')

    <title>Marketing Images</title>

@endsection

@section('content')

    <div class="container">

        {!! Breadcrumb::withLinks(['Home' => '/',
                                   'marketing Images' =>
                                   '/marketing-image']) !!}

    <h1>Marketing Images</h1>

        <a href="/marketing-image/create">
            <button class="btn btn-primary">
                Create New Image
            </button>
        </a>

        @include('marketing-image.datatable')

    </div>

@endsection


@section('scripts')

     @include('marketing-image.datatable-script', [$thumbnailPath])

@endsection