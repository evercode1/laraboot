@extends('layouts.master')

@section('title')

    <title>Edit a Widget</title>

@endsection

@section('content')

    <div class="container">

        {!! Breadcrumb::withLinks(['Home' => '/', 'Widgets' => '/widget', $widget->widget_name]) !!}

        <h1>Update</h1>

        <hr/>

        @include('errors.list')

        {!! Form::model($widget, ['route' => ['widget.update', $widget->id],
        'method' => 'PATCH',
        'class' => 'form',
        ]) !!}

        <!-- widget_name Form Input -->

        <div class="form-group">

            {!! Form::label('widget_name', 'Widget Name') !!}
            {!! Form::text('widget_name', null, ['class' => 'form-control']) !!}

        </div>

        <div class="form-group">

            {!! Form::submit('Update Widget', ['class'=>'btn btn-primary']) !!}

        </div>

        {!! Form::close() !!}

    </div>

@endsection