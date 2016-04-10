@extends('layouts.master')

@section('title')

    <title>Create a Marketing Image</title>

@endsection

@section('content')

    <div class="container">

    {!! Breadcrumb::withLinks(['Home' => '/',
                               'Markeing Images' => '/marketing-image',
                               'Create']) !!}

    <h2>Create a New Marketing Image</h2>

    <hr/>

    @include('errors.list')

        {!! Form::open(['url' => '/marketing-image',
                        'class' => 'form',
                        'files' => true]) !!}


    <!-- image_name Form Input -->

    <div class="form-group">

         {!! Form::label('image_name', 'Image Name') !!}
         {!! Form::text('image_name', null,
             ['class' => 'form-control']) !!}

    </div>

        <!-- is_active Form Input -->

        <div class="form-group">
            {!! Form::label('is_active', 'Is Active:') !!} <br>
            {!! Form::checkbox('is_active') !!}
        </div>

        <!-- is_featured Form Input -->

        <div class="form-group">
            {!! Form::label('is_featured', 'Is Featured:') !!}<br>
            {!! Form::checkbox('is_featured') !!}
        </div>

        <!-- image_weight Form Input -->

        <div class="form-group">
            {!! Form::label('image_weight', 'Image Weight') !!}<br>
            {!! Form::number('image_weight', 100) !!}
        </div>

        <!-- form field for file -->
        <div class="form-group">
        {!! Form::label('image', 'Primary Image') !!}
        {!! Form::file('image', null,
            ['required', 'class'=>'form-control']) !!}
        </div>

    <div class="form-group baseMargin">

    {!! Form::submit('Upload Marketing Image',
        ['class'=>'btn btn-primary']) !!}

    </div>

          {!! Form::close() !!}

    </div>

@endsection