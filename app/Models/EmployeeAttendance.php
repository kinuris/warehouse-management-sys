<?php

namespace App\Models;

use DateTime;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeAttendance extends Model
{
    use HasFactory;

    protected $table = 'employee_attendance';

    protected $fillable = [
        'employee_id',
        'date',
        'in_time',
        'out_time',
    ];

    public function getStatusType()
    {
        if (!User::find($this->employee_id)->isSysRole('employee')) {
            throw new Exception('User is not an employee');
        }

        $current = date_create('now')->format('Y-m-d');
        $attendance = date_create($this->date)->format('Y-m-d');

        $isSameDay = $current === $attendance;

        if ($isSameDay && !$this->out_time) {
            return 'present';
        } else if (($isSameDay && $this->out_time) || (!$isSameDay && $this->out_time)) {
            return 'finished';
        } else if (!$isSameDay && !$this->out_time) {
            return 'no-timeout';
        }
    }

    public function getStatus()
    {
        if (!User::find($this->employee_id)->isSysRole('employee')) {
            throw new Exception('User is not an employee');
        }

        $current = date_create('now')->format('Y-m-d');
        $attendance = date_create($this->date)->format('Y-m-d');

        $isSameDay = $current === $attendance;

        if ($isSameDay && !$this->out_time) {
            return 'Present';
        } else if (($isSameDay && $this->out_time) || (!$isSameDay && $this->out_time)) {
            $seconds = strtotime($this->out_time) - strtotime($this->in_time);

            $hours = floor($seconds / 3600);
            $minutes = floor(($seconds % 3600) / 60);

            return 'Finished Duty (' . $hours . ' hrs, ' . $minutes . ' mins)';
        } else if (!$isSameDay && !$this->out_time) {
            return 'No Timeout';
        }
    }

    public function getStatusColor()
    {
        if (!User::find($this->employee_id)->isSysRole('employee')) {
            throw new Exception('User is not an employee');
        }

        $current = date_create('now')->format('Y-m-d');
        $attendance = date_create($this->date)->format('Y-m-d');

        $isSameDay = $current === $attendance;

        if ($isSameDay && !$this->out_time) {
            return 'primary';
        } else if (($isSameDay && $this->out_time) || (!$isSameDay && $this->out_time)) {
            return 'success';
        } else if (!$isSameDay && !$this->out_time) {
            return 'danger';
        }
    }

    public function isPast()
    {
        $current = date_create('now')->format('Y-m-d');
        $attendance = date_create($this->date)->format('Y-m-d');

        return $current > $attendance;
    }
}
