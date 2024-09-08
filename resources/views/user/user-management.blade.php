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
                <!-- <th>Status (Today)</th> -->
                <th>Actions</th>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td class="{{ $user->is_suspended ? 'text-danger text-decoration-line-through' : '' }}">{{ $user->is_suspended ? '(Suspended) ' : '' }}{{ $user->internal_id }}</td>
                    <td class="{{ $user->is_suspended ? 'text-danger text-decoration-line-through' : '' }}">{{ $user->getFullname() }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->phone }}</td>
                    {{-- @php($recent = $user->mostRecentAttendance())
                    @if(!$recent)
                    <td class="text-muted">(No Records) <span class="text-danger">No Sign-in</span></td>
                    @elseif($recent->getStatusType() === 'present')
                    <td class="text-success">Working</td>
                    @elseif ($recent->getStatusType() === 'absent')
                    <td class="text-danger">No Sign-in</td>
                    @elseif ($recent->getStatusType() === 'finished' && !$recent->isPast())
                    <td class="text-primary">Finished</td>
                    @else
                    <td class="text-danger">No Sign-in</td>
                    @endif --}}
                    <td>
                        <div class="btn-group">
                            <!-- <a href="{{ route('users_attendance', ['user' => $user->id]) }}" class="btn btn-primary">Attendance</a> -->
                            <a href="{{ route('users_edit', ['user' => $user->id]) }}" class="btn btn-success">Edit</a>
                            @if ($user->is_suspended)
                            <a href="{{ route('users_delete', ['user' => $user->id]) }}" class="btn btn-info">Allow</a>
                            @else
                            <a href="{{ route('users_delete', ['user' => $user->id]) }}" class="btn btn-danger">Suspend</a>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection