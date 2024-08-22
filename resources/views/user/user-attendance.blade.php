@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Attendance ({{ $user->internal_id }})</h1>
    <p class="text-muted">Employee Name: <b>{{ $user->getFullname() }}</b></p>

    <a class="btn btn-secondary" href="{{ route('users') }}">Back</a>

    <div class="container mt-5">
        <div id="calendar"></div>
    </div>
</div>
@endsection

@section('script')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const calendarEl = document.getElementById('calendar');
        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            events: [
                <?php
                $records = $user->getAttendanceRecords(); 

                foreach ($records as $record) {
                    $status = $record->getStatus();

                    echo "{ title: '$status', start: '$record->date' },";
                    echo "\n";
                }
                ?>
            ],
        });

        calendar.render();
    })
</script>
@endsection