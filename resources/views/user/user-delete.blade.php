@extends('layouts.app')

@section('content')
<div class="container">
    @if ($user->is_suspended)
    <h1 class="text-info">Allow Employee</h1>
    <h3 class="m-0 mt-5">{{ $user->internal_id }} ({{ $user->getFullname() }})</h3>
    <h6 class="text-secondary">Role: {{ \App\Models\EmployeeRole::find($user->employee_role_id)->name }}</h6>
    <a href="{{ route('users') }}" class="btn btn-secondary mt-3">Back</a>
    <a href="{{ route('users_destroy', ['user' => $user->id]) }}" class="btn btn-info mt-3">Allow</a>
    @else
    <h1 class="text-danger">Suspend Employee</h1>
    <h3 class="m-0 mt-5">{{ $user->internal_id }} ({{ $user->getFullname() }})</h3>
    <h6 class="text-secondary">Role: {{ \App\Models\EmployeeRole::find($user->employee_role_id)->name }}</h6>
    <a href="{{ route('users') }}" class="btn btn-secondary mt-3">Back</a>
    <a href="{{ route('users_destroy', ['user' => $user->id]) }}" class="btn btn-danger mt-3">Suspend</a>
    @endif
</div>
@endsection