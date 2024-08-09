<?php

namespace App\Http\Controllers;

use App\Models\EmployeeRole;
use App\Models\SystemRole;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function userLogin(Request $request)
    {
        $auth = auth()->attempt($request->only('email', 'password'));

        if ($auth) {
            return redirect('/');
        } else {
            return redirect('/login')->with('message', 'Invalid credentials');
        }
    }

    public function register()
    {
        $roles = EmployeeRole::all();

        return view('auth.register')->with('employee_roles', $roles);
    }

    public function userRegister(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required',
            'middle_name' => 'nullable',
            'last_name' => 'required',
            'email' => ['nullable', 'email', 'unique:users'],
            'phone' => ['required', 'unique:users'],
            'employee_role_id' => 'required',
            'password' => 'required',
        ]);

        $validated['password'] = bcrypt($validated['password']);

        $employee_role = SystemRole::query()->where('name', 'employee')->first();

        User::create(array_merge($validated, [
            'system_role_id' => $employee_role->id,
        ]));

        return back()->with('message', 'User created successfully');
    }

    public function logout() {
        auth()->logout();

        return redirect('/login');
    }
}
