@extends('layouts.master')

@section('title')

    <title>Edit a Marketing Image</title>

@endsection

@section('content')

    <div class="container">

        {!! Breadcrumb::withLinks(['Home' => '/',
                                   'Marketing Images' => '/marketing-image',
                                   'Edit']) !!}

<h1>Edit {{ $marketingImage->image_name
            . '.' .
            $marketingImage->image_extension }}</h1>

        <hr/>

        @include('errors.list')

        <div>


        {!! Form::model($marketingImage, ['route' => ['marketing-image.destroy',
                                                       $marketingImage->id],
                                          'method' => 'DELETE',
                                          'class' => 'form']
                ) !!}

            Note: name of image cannot be changed.  If you wish to change the name,
            then {!! Form::submit('Delete', array('class'=>'btn btn-default',
            'Onclick' => 'return ConfirmDelete();')) !!} and create a new photo.

            {!! Form::close() !!}





        </div>


        <br>

        {!! Form::model($marketingImage, ['route' => ['marketing-image.update',
                                                       $marketingImage->id],
                                          'method' => 'PATCH',
                                          'class' => 'form',
                                          'files' => true]
                ) !!}

        <!-- image name no input -->
        <div>


       <h4>{{ $marketingImage->image_name
              . '.' .
              $marketingImage->image_extension }} </h4>



        </div>

        <div class="baseMargin">

            <img src="{{ $thumbnailPath . $marketingImage->image_name
                                              . '.' .
                                              $marketingImage->image_extension
                                              . '?'. 'time='. time() }}">

        </div>

        <!-- is_active Form Input -->

        <div class="form-group">

            {!! Form::label('is_active', 'Is Active:') !!} <br>
            {!! Form::checkbox('is_active') !!}

        </div>

        <!-- is_featured Form Input -->

        <div class="form-group">

            {!! Form::label('is_featured', 'Is Featured:') !!} <br>
            {!! Form::checkbox('is_featured') !!}

        </div>

        <!-- image_weight Form Input -->

        <div class="form-group">
            {!! Form::label('image_weight', 'Image Weight') !!}<br>
            {!! Form::number('image_weight', $marketingImage->image_weight) !!}
        </div>

        <!-- form field for file -->

        <div class="form-group">

        {!! Form::label('image', 'Change Primary Image') !!}
        {!! Form::file('image', null, ['required', 'class'=>'form-control']) !!}

        </div>

        <div class="form-group baseMargin">

        {!! Form::submit('Make Your Edit', ['class'=>'btn btn-primary']) !!}


        </div>

        {!! Form::close() !!}

    </div>

@endsection

@section('scripts')

    <script>

        function ConfirmDelete()
        {
            var x = confirm("Are you sure you want to delete?");
            if (x)
                return true;
            else
                return false;
        }

    </script>

@endsection