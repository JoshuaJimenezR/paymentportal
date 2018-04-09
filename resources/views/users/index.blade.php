@extends('layouts.portal')

@section('content')
    <div class="row">
        <div class="col-md-9">
            <h1>Users</h1>
        </div>
        <div class="col-md-3">
            <a href="/users/create" class="btn btn-primary pull-right">Create</a>
        </div>
    </div>

    <div>
        <table class="table table-striped">
            <thead>
                <th>Username</th>
                <th>Email</th>
                <th>BIN</th>
                <th>Roles</th>
                <th>Actions</th>
            </thead>
            <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->username }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->alias }}</td>
                    <td>
                        @foreach($user->roles as $role)
                            {{ $role->name }}
                        @endforeach
                    </td>
                    <td><a href="/users/{{ $user->id }}/edit">Edit</a></td>
                </tr>
            @endforeach

            </tbody>
        </table>
    </div>

    {{ $users->links() }}


@endsection
