@extends('layouts.app')

@section('content')
<div class="container">
    <h1>User Management</h1>
    <a href="{{ route('register') }}" class="btn btn-primary mt-3">Add Employee</a>
    <div class="table-responsive">
        <table class="table mt-3">
            <thead>
                <th>Employee ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Actions</th>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{ $user->internal_id }}</td>
                    <td>{{ $user->getFullname() }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->phone }}</td>
                    <td>
                        <div class="btn-group">
                            <a href="{{ route('users_edit', ['user' => $user->id]) }}" class="btn btn-success">Edit</a>
                            <a href="{{ route('users_delete', ['user' => $user->id]) }}" class="btn btn-danger">Suspend</a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection