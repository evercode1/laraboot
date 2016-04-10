@extends('layouts.master')

@section('title')

<title>Edit Your User Settings</title>

@endsection

@section('content')

<div class="container">

    {!! Breadcrumb::withLinks(['Home' => '/', 'Settings' => '/settings', $user->name]) !!}


    <div class="pull-right">

        <a href="/password/email">

            <button type="button" class="btn btn-lg btn-primary">


                Reset Password

            </button>

        </a>

    </div>

    <h1>Update {{ $user->name }}</h1>

    <hr/>


    @include('errors.list')


    {!! Form::model($user, ['route' => ['userUpdate', $user->id],
    'method' => 'POST',
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
        {!! Form::label('is_subscribed', 'Get Newsletter?') !!}
        <br>

        {!! Form::select('is_subscribed', [1 => 'Yes', 0 => 'No'], null,
        ['placeholder' => 'choose one...']); !!}

    </div>

    <div class="form-group">

        {!! Form::submit('Update User Settings', ['class'=>'btn btn-primary']) !!}

    </div>

    {!! Form::close() !!}

</div>

@endsection