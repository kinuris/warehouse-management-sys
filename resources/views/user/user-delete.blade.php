@extends('layouts.app')

@section('content')
<div class="container">
    @if ($user->is_suspended)
    <h1 class="text-3xl font-bold text-blue-400">Allow Employee</h1>
    <h3 class="m-0 mt-5">{{ $user->internal_id }} ({{ $user->getFullname() }})</h3>
    <h6 class="text-secondary">Role: {{ \App\Models\EmployeeRole::find($user->employee_role_id)->name }}</h6>

    <div class="my-5"></div>

    <a href="{{ route('users') }}" class="p-2 bg-gray-500 rounded text-white">Back</a>
    <a href="{{ route('users_destroy', ['user' => $user->id]) }}" class="p-2 bg-blue-400 rounded text-white">Allow</a>
    @else
    <h1 class="text-3xl font-bold text-red-600">Suspend Employee</h1>
    <h3 class="mt-5">{{ $user->internal_id }} ({{ $user->getFullname() }})</h3>
    <h6 class="text-secondary">Role: {{ \App\Models\EmployeeRole::find($user->employee_role_id)->name }}</h6>

    <div class="my-5"></div>

    <a href="{{ route('users') }}" class="p-2 bg-gray-500 rounded text-white">Back</a>
    <a href="{{ route('users_destroy', ['user' => $user->id]) }}" class="p-2 bg-red-600 rounded text-white">Suspend</a>
    @endif
</div>
@endsection