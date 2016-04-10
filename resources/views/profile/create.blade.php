@extends('layouts.master')

@section('title')

    <title>Create a Profile</title>

@endsection

@section('content')

    <div class="container">

        {!! Breadcrumb::withLinks(['Home' => '/', 'Profile' => '/profile', 'Create']) !!}

        <h2>Create a New Profile</h2>

        <hr/>

        @include('errors.list')

        {!! Form::open(array('url' => '/profile', 'class' => 'form')) !!}

        <!-- first_name Form Input -->
        <div class="form-group">
            {!! Form::label('first_name', 'First Name') !!}
            {!! Form::text('first_name', null, ['class' => 'form-control']) !!}
        </div>

        <!-- last_name Form Input -->
        <div class="form-group">
            {!! Form::label('last_name', 'Last Name') !!}
            {!! Form::text('last_name', null, ['class' => 'form-control']) !!}
        </div>

        <!-- Gender Form Input -->
        <div class="form-group">
            {!! Form::label('gender', 'Gender') !!}
            <br>
            {!! Form::select('gender', [1 => 'Male', 0 => 'Female'], null, ['placeholder' => 'choose one...']); !!}
        </div>

        <!-- Birthdate Form Input -->
        <div class="form-group">
            {!! Form::label('birthdate', 'Birthdate') !!}
        </div>
        <div class="form-group">
            {!!  Form::date('birthdate', \Carbon\Carbon::now()) !!}
        </div>

        <div class="form-group">

            {!! Form::submit('Create Profile', ['class'=>'btn btn-primary']) !!}

        </div>

        {!! Form::close() !!}

    </div>

@endsection