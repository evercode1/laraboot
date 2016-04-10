@extends('layouts.master')

@section('title')

    <title>Create a Widget</title>

@endsection

@section('content')

    <div class="container">

        {!! Breadcrumb::withLinks(['Home' => '/', 'Widgets' => '/widget', 'Create']) !!}

        <h2>Create a New Widget</h2>

        <hr/>

        @include('errors.list')

        {!! Form::open(array('url' => '/widget', 'class' => 'form')) !!}

        <!-- widget_name Form Input -->

        <div class="form-group">

            {!! Form::label('widget_name', 'Widget Name') !!}
            {!! Form::text('widget_name', null, ['class' => 'form-control']) !!}

        </div>

        <div class="form-group">

            {!! Form::submit('Create Widget', ['class'=>'btn btn-primary']) !!}

        </div>

        {!! Form::close() !!}

    </div>

@endsection