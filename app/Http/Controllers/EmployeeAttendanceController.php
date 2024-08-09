<?php

namespace App\Http\Controllers;

use App\Models\EmployeeAttendance;
use App\Models\User;
use Illuminate\Http\Request;

class EmployeeAttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $scope = $request->query('scope', 'day');

        if ($scope == 'day') {
            $scope = 1;
        } else if ($scope == 'week') {
            $scope = 7;
        } else if ($scope == 'month') {
            $scope = 30;
        }

        $currentDate = date('Y-m-d');
        $newDate = date('Y-m-d', strtotime("-$scope days", strtotime($currentDate)));

        $attendance = EmployeeAttendance::query()
            ->where('date', '>=', $newDate)
            ->get();

        return view('attendance.employee-attendance-management')->with('attendance', $attendance);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $employees = User::getEmployees();

        return view('attendance.employee-attendance-add')->with('employees', $employees);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee' => ['required'],
            'date' => ['required', 'date'],
            'time-in' => ['required', 'date_format:H:i'],
        ]);

        $validated['employee_id'] = $validated['employee'];
        $validated['in_time'] = $validated['time-in'];

        EmployeeAttendance::query()->create($validated);

        return redirect(route('employee_attendance'))->with('message', 'Attendance record added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(EmployeeAttendance $employeeAttendance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EmployeeAttendance $employeeAttendance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EmployeeAttendance $employeeAttendance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EmployeeAttendance $employeeAttendance)
    {
        //
    }
}
