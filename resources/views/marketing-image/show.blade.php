@extends('layouts.master')

@section('title')

<title>{{ $marketingImage->image_name }}</title>

@endsection

@section('content')


<div class="container">

{!! Breadcrumb::withLinks(['Home'   => '/',
 'marketing images' => '/marketing-image',
 "$marketingImage->image_name.$marketingImage->image_extension"
 ]) !!}

<div>

    <h1>{{ $marketingImage->image_name }} Marketing Image</h1>

</div>

    <div>

        <div class="pull-left baseMargin">

    <a href="/marketing-image/{{ $marketingImage->id }}/edit">

    <button type="button" class="btn btn-primary">Edit Image</button></a>

        </div>

    <!-- Table -->
    <table class="table table-striped">


        <tr>

            <th>Thumbnail</th>

        </tr>

        <tr>

            <td>

<img src="{{ $thumbnailPath . $marketingImage->image_name
                                              . '.' .
                                              $marketingImage->image_extension
                                              . '?'. 'time='. time() }}">

            </td>

        </tr>

        <tr>

            <th>Active?</th>

        </tr>

        <tr>

<td>{{ $marketingImage->showActiveStatus($marketingImage->is_active) }}</td>

        </tr>

        <tr>

            <th>Featured?</th>

        </tr>

        <tr>

<td>{{ $marketingImage->showFeaturedStatus($marketingImage->is_featured) }}</td>

        </tr>

        <tr>

            <th>Image Weight</th>

        </tr>

        <tr>

            <td>{{ $marketingImage->image_weight }}</td>

        </tr>

        <tr>

            <th>Primary Image</th>


        </tr>

        <tr>

            <td>

<img src="{{ $imagePath . $marketingImage->image_name
                             . '.' .
                             $marketingImage->image_extension
                             . '?'. 'time='. time() }}">

            </td>

    </table>

    <div class="pull-left baseMargin">

    <div class="form-group">

         {!! Form::model($marketingImage, ['route' => ['marketing-image.destroy',
                                                        $marketingImage->id],
                                           'method' => 'DELETE',
                                           'class' => 'form']
                                            ) !!}

         {!! Form::submit('Delete', ['class'=>'btn btn-danger',
                          'Onclick' => 'return ConfirmDelete();']) !!}

    </div>

         {!! Form::close() !!}

    </div>

    </div>

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