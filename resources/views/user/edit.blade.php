@extends('layouts.master')

@section('title')

    <title>Edit a User</title>

@endsection

@section('content')

    <div class="container">

        {!! Breadcrumb::withLinks(['Home' => '/', 'User' => "/user/$user->id/edit", $user->name]) !!}

        <h1>Update {{ $user->name }}</h1>


        <hr/>

        @include('errors.list')


        {!! Form::model($user, ['route' => ['user.update', $user->id],
        'method' => 'PATCH',
        'class' => 'form',
        ]) !!}

        <!-- widget_name Form Input -->

        <div class="form-group">
            {!! Form::label('name', 'User Name') !!}
            {!! Form::text('name', null, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('email', 'Email') !!}
            {!! Form::email('email', null, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group">

            {!! Form::label('is_subscribed', 'Newsletter?') !!}

            <br>

            {!! Form::select('is_subscribed', [1 => 'Yes', 0 => 'No'], null,
            ['placeholder' => 'choose one...']); !!}

        </div>

        <div class="form-group">

            {!! Form::label('is_admin', 'Is Admin?') !!}

            <br>
            {!! Form::select('is_admin', [1 => 'Yes', 0 => 'No'], null,
            ['placeholder' => 'choose one...']); !!}

        </div>

        <div class="form-group">

            {!! Form::label('status_id', 'Status') !!}

            <br>

            {!! Form::select('status_id', [10 => 'Active', 7 => 'Inactive'], null ) !!}

        </div>

        <div class="form-group">

            {!! Form::submit('Update User', ['class'=>'btn btn-primary']) !!}

        </div>

        {!! Form::close() !!}

    </div>

@endsection