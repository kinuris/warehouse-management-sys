<?php

namespace App\Http\Controllers;

use App\Models\EmployeeRole;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = User::getEmployees();

        return view('user.user-management')->with('users', $employees);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roles = EmployeeRole::all();

        return view('user.user-edit')
            ->with('user', $user)
            ->with('employee_roles', $roles);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user) {
        $validated = $request->validate([
            'first_name' => ['required'],
            'middle_name' => ['nullable'],
            'last_name' => ['required'],
            'employee_role_id' => ['required'],
            'email' => ['required', 'email'],
            'phone' => ['required', 'min:11', 'max:11'],
        ]);

        $user->update($validated);

        return redirect()->route('users')->with('message', 'User updated successfully');
    }

    public function delete(User $user)
    {
        return view('user.user-delete')->with('user', $user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->update(['is_suspended' => !$user->is_suspended]);

        return redirect()->route('users')->with('message', 'User suspended successfully');
    }
}
