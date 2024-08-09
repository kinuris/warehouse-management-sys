@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-lg-flex justify-content-between">
        <h1>Employee Attendance Managment</h1>
        <form class="d-flex" action="{{ route('employee_attendance') }}">
            <input type="text" value="{{ request()->query('search') }}" name="search" id="search" placeholder="Search" class="form-control" style="min-width: 200px;">

            <select class="ms-2 form-select" name="scope" id="scope">
                <option value="day" {{ request()->query('scope') === 'day' ? 'selected' : '' }}>Last Day</option>
                <option value="week" {{ request()->query('scope') === 'week' ? 'selected' : '' }}>Last Week</option>
                <option value="month" {{ request()->query('scope') === 'month' ? 'selected' : '' }}>Last Month</option>
            </select>

            <input type="submit" value="Filter" class="btn btn-primary ms-2">
        </form>
    </div>
    <a href="{{ route('attendance_add') }}" class="btn btn-primary mt-3">
        Add Attendance Record
    </a>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <th>Employee ID</th>
                <th>Employee Name</th>
                <th>Date</th>
                <th>Status</th>
                <th>Check-in Time</th>
                <th>Check-out Time</th>
            </thead>
            <tbody>
                @foreach ($attendance as $record)
                @php($user = \App\Models\User::find($record->employee_id))
                <tr>
                    <td>{{ $user->internal_id }}</td>
                    <td>{{ $user->getFullname() }}</td>
                    <td>{{ $record->date }}</td>
                    <td>{{ $record->status }}</td>
                    <td>{{ $record->in_time }}</td>
                    {!! $record->out_time ? '<td>$record->out_time</td>' : '<td><a href="" class="btn btn-secondary">Add Timeout</a></td>' !!}
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection