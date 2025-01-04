@extends('layouts.app')

@section('content')
<div class="container">
    <img src="{{ asset('assets/gradient.jpg') }}" style="position: fixed; left: 0; z-index: -1; top: 0; width: 100%; height: 100vh; opacity: 0.2; object-fit: cover;" alt="Background">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="text-3xl font-bold">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="flex flex-col mt-4">
                            <label for="first_name" class="col-md-4 col-form-label text-md-end">{{ __('First Name') }}:</label>

                            <div class="col-md-6">
                                <input id="first_name" type="text" class="p-1.5 rounded border border-black @error('first_name') text-red-500 @enderror" name="first_name" value="{{ old('first_name') }}" required autofocus>

                                @error('first_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="flex flex-col mt-4">
                            <label for="middle_name" class="col-md-4 col-form-label text-md-end">{{ __('Middle Name') }}:</label>

                            <div class="col-md-6">
                                <input id="middle_name" type="text" class="p-1.5 rounded border border-black @error('middle_name') text-red-500 @enderror" name="middle_name" value="{{ old('middle_name') }}" required autofocus>

                                @error('middle_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="flex flex-col mt-4">
                            <label for="last_name" class="col-md-4 col-form-label text-md-end">{{ __('Last Name') }}:</label>

                            <div class="col-md-6">
                                <input id="last_name" type="text" class="p-1.5 rounded border border-black @error('last_name') text-red-500 @enderror" name="last_name" value="{{ old('last_name') }}" required autofocus>

                                @error('last_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="flex flex-col mt-4">
                            <label for="employee_role_id" class="col-md-4 col-form-label text-md-end">{{ __('Employee Role') }}:</label>

                            <div class="col-md-6">
                                <select class="p-1.5 rounded border border-black @error('employee_role_id') text-red-500 @enderror" name="employee_role_id" id="employee_role_id">
                                    @foreach ($employee_roles as $role)
                                    @php($role = \App\Models\EmployeeRole::query()->find($role->id))
                                    @if ($role->name !== 'management')
                                    <option value="{{ $role->id }}">{{ ucfirst($role->name) }}</option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="flex flex-col mt-4">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}:</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="p-1.5 rounded border border-black @error('email') text-red-500 @enderror" name="email" value="{{ old('email') }}" autocomplete="email">

                                @error('email')
                                <span class="text-sm text-red-500 font-medium" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="flex flex-col mt-4">
                            <label for="phone" class="col-md-4 col-form-label text-md-end">{{ __('Phone') }}:</label>

                            <div class="col-md-6">
                                <input id="phone" type="tel" class="p-1.5 rounded border border-black @error('phone') text-red-500 @enderror" name="phone" value="{{ old('phone') }}" required>

                                @error('phone')
                                <span class="text-sm text-red-500 font-medium" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="flex flex-col mt-4">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}:</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="p-1.5 rounded border border-black @error('password') text-red-500 @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="flex flex-col mt-4">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}:</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="p-1.5 rounded border border-black" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="mt-4">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="p-2 rounded bg-blue-600 text-white">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection