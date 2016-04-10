@extends('layouts.master')

@section('title')

    <title>

        {{ $profile->first_name . ' ' . $profile->last_name }}

    </title>

@endsection

@section('content')

    <div class="container">

        @if(Auth::user()->isAdmin())

            {!! Breadcrumb::withLinks(['Home' => '/', 'Profile' => '/profile',
            $profile->first_name. ' ' . $profile->last_name => $profile->id]) !!}

        @else

            {!! Breadcrumb::withLinks(['Home' => '/', $profile->first_name. ' ' .
            $profile->last_name ]) !!}

        @endif

        <div>
            <h1>Profile:  {{ $profile->first_name. ' ' . $profile->last_name }}</h1>
        </div>

        <div>
            <div class="baseMargin">
                <a href="/profile/{{ $profile->id }}/edit">
                    <button type="button" class="btn btn-lg btn-primary">

                        Update

                    </button>
                </a>
            </div>

            <div class="panel panel-default">
                <!-- Default panel contents -->
                <div class="panel-heading"></div>
                <div class="panel-body ">

                </div>

                <!-- Table -->
                <table class="table table-striped">
                    <tr>

                        <th>Id</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Username</th>
                        <th>Gender</th>
                        <th>Birthdate</th>
                        <th>Delete</th>

                    </tr>

                    <tr>

                        <td>{{ $profile->id }} </td>
                        <td> <a href="/profile/{{ $profile->id }}/edit">{{ $profile->first_name }}</a></td>
                        <td> <a href="/profile/{{ $profile->id }}/edit">{{ $profile->last_name }}</a></td>

                        @if(Auth::user()->isAdmin())

                            <td><a href="/user/{{ $user->id }}">{{ $user->name }}</a></td>

                        @else

                            <td><a href="/settings">{{ $user->name }}</a></td>

                        @endif

                        <td>{{ $profile->showGender($profile->gender) }}</td>
                        <td>{{ $profile->showBirthdate($profile->birthdate) }}</td>
                        <td>{!! Form::model($profile, ['route' => ['profile.destroy', $profile->id],
                            'method' => 'DELETE'
                            ]) !!}

                            <div class="form-group">

                                {!! Form::submit('Delete', ['class'=>'btn btn-danger',
                                'Onclick' => 'return ConfirmDelete();']) !!}

                            </div>

                            {!! Form::close() !!}</td>

                    </tr>

                </table>

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