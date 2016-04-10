@extends('layouts.master')

@section('title')

    <title>The Profiles Page</title>

@endsection


@section('content')

    <div class="container">

        {!! Breadcrumb::withLinks(['Home' => '/', 'Profiles' => '/profile']) !!}

        <h1>Profiles</h1>

        @include('profile.datatable')

    </div>

@endsection

@section('scripts')

    @include('profile.datatable-script')

@endsection