@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Add Timeout</h1>
    <form action="{{ route('attendance_store_timeout', ['attendance' => $attendance->id]) }}" method="post">
        @csrf
        <div class="form-floating" style="flex: 1">
            <input class="form-control" type="time" name="time-out" id="time-out">
            <label class="form-label" for="time-out">Time Out</label>
        </div>

        <input class="mt-4 btn btn-primary" type="submit" value="Add Timeout">
    </form>
</div>
@endsection