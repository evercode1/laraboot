@extends('layouts.master')

@section('title')
    <title>{{ $user->name }}</title>
@endsection

@section('content')
    <div class="container">

        {!! Breadcrumb::withLinks(['Home' => '/', 'Users' => '/user',
        $user->name => $user->id]) !!}

        <br>

        <h1>User:  {{ $user->name }}</h1>

        <div class="baseMargin">

            <a href="/user/{{ $user->id }}/edit">

                <button type="button" class="btn btn-lg btn-primary">

                    Update

                </button>

            </a>

        </div>

        <div class="panel panel-default">
            <!-- Default panel contents -->
            <div class="panel-heading"></div>
            <div class="panel-body">

            </div>

            <!-- Table -->
            <table class="table table-striped">
                <tr>

                    <th>Id</th>
                    <th>Name</th>
                    <th>Profile</th>
                    <th>Email</th>
                    <th>News?</th>
                    <th>Admin?</th>
                    <th>Status</th>
                    <th>Created</th>

                </tr>

                <tr>
                    <td>{{ $user->id }} </td>

                    <td> <a href="/user/{{ $user->id }}/edit">
                            {{ $user->name }}</a></td>

                    @if (isset($profile->id))

                        <td> <a href="/profile/{{ $profile->id }}">
                                Profile</a></td>
                    @else

                        <td>Profile</td>

                    @endif

                    <td>{{ $user->email }}</td>
                    <td>{{ $user->showNewsletterStatusOf($user) }}</td>
                    <td>{{ $user->showAdminStatusOf($user) }}</td>
                    <td>{{ $user->showStatusOf($user) }}</td>
                    <td>{{ $user->showDateCreated($user->created_at) }}</td>

                </tr>

            </table>

        </div>

        {!! Form::model($user, ['route' => ['user.destroy', $user->id],
        'method' => 'DELETE'
        ]) !!}
        <div class="form-group">

            <div class="baseMargin">

                {!! Form::submit('Delete', ['class'=>'btn btn-danger pull-right',
                'Onclick' => 'return ConfirmDelete();']) !!}

            </div>

            {!! Form::close() !!}

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