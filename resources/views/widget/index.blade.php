@extends('layouts.master')

@section('title')

    <title>The Widget Page</title>

@endsection

@section('content')

    <div class="container">

        {!! Breadcrumb::withLinks(['Home' => '/', 'Widgets' => '/widget']) !!}

        <h1>Widgets</h1>

        @include('widget.datatable')

    </div>

@endsection

@section('scripts')

    @include('widget.datatable-script')

@endsection