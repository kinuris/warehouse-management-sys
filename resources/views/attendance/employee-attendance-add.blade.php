@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Add Attendance Record</h1>
    <form method="POST" action="{{ route('attendance_store') }}">
        @csrf

        <div class="form-floating">
            <select class="form-select" name="employee" id="employee">
                @foreach ($employees as $employee)
                <option value="{{ $employee->id }}">({{ $employee->internal_id }}) {{ $employee->getFullname() }}</option>
                @endforeach
            </select>
            <label class="form-label" for="employee">Employee</label>
        </div>

        <div class="d-flex mb-4 mt-3">
            <div class="form-floating" style="flex: 1">
                <input class="form-control @error('date') is-invalid @enderror" type="date" name="date" id="date" value="{{ old('date', date('Y-m-d')) }}">
                <label class="form-label" for="date">Date</label>
                @error('date')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mx-2"></div>
            <div class="form-floating" style="flex: 1">
                <input class="form-control @error('time-in') is-invalid @enderror" type="time" name="time-in" id="time-in" value="{{ old('time-in') }}">
                <label class="form-label" for="time-in">Time In</label>
                @error('time-in')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <input class="btn btn-primary" type="submit" value="Submit">
    </form>
</div>
@endsection