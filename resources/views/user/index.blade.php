@extends('layouts.master')

@section('title')

    <title>The User Page</title>

@endsection

@section('content')

    <div class="container">

        {!! Breadcrumb::withLinks(['Home' => '/', 'Users' => '/user']) !!}

        <h1>Users</h1>

        @include('user.datatable')

    </div>

@endsection

@section('scripts')

    @include('user.datatable-script')

@endsection