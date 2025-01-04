@extends('layouts.app')

@section('content')
<div class="container">
    <img src="{{ asset('assets/gradient.jpg') }}" style="position: fixed; left: 0; z-index: -1; top: 0; width: 100%; height: 100vh; opacity: 0.2; object-fit: cover;" alt="Background">
    <h1 class="text-3xl font-bold">User Management</h1>

    <div class="my-5"></div>

    <a href="{{ route('register') }}" class="p-2 bg-blue-600 text-white rounded">Add Employee</a>
    <div class="min-w-full mt-8">
        <table class="w-full">
            <thead>
                <th class="border border-gray-700 py-2 px-4 text-sm text-gray-800">Employee ID</th>
                <th class="border border-gray-700 py-2 px-4 text-sm text-gray-800">Name</th>
                <th class="border border-gray-700 py-2 px-4 text-sm text-gray-800">Email</th>
                <th class="border border-gray-700 py-2 px-4 text-sm text-gray-800">Phone</th>
                <!-- <th>Status (Today)</th> -->
                <th class="border border-gray-700 py-2 px-4 text-sm text-gray-800">Actions</th>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td class="{{ $user->is_suspended ? 'text-red-500 line-through' : '' }} border border-gray-700 py-2 px-4 text-sm text-gray-800">{{ $user->is_suspended ? '(Suspended) ' : '' }}{{ $user->internal_id }}</td>
                    <td class="{{ $user->is_suspended ? 'text-red-500 line-through' : '' }} border border-gray-700 py-2 px-4 text-sm text-gray-800">{{ $user->getFullname() }}</td>
                    <td class="border border-gray-700 py-2 px-4 text-sm text-gray-800">{{ $user->email }}</td>
                    <td class="border border-gray-700 py-2 px-4 text-sm text-gray-800">{{ $user->phone }}</td>
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
                    <td class="border border-gray-700 py-1 px-4 text-sm text-gray-800">
                        <div class="flex gap-2 justify-center">
                            <!-- <a href="{{ route('users_attendance', ['user' => $user->id]) }}" class="btn btn-primary">Attendance</a> -->
                            <a href="{{ route('users_edit', ['user' => $user->id]) }}" class="p-2 text-white bg-green-500 rounded">Edit</a>
                            @if ($user->is_suspended)
                            <a href="{{ route('users_delete', ['user' => $user->id]) }}" class="p-2 text-white bg-blue-400 rounded">Allow</a>
                            @else
                            <a href="{{ route('users_delete', ['user' => $user->id]) }}" class="p-2 text-white bg-red-600 rounded">Suspend</a>
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