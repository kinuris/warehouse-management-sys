@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <div class="bg-white shadow-xl rounded-lg overflow-hidden">
            <div class="bg-gray-100 px-6 py-4 border-b border-gray-200">
                <h1 class="text-xl font-semibold text-gray-700">{{ __('Create New User Account') }}</h1>
                <p class="text-sm text-gray-600 mt-1">Fill in the details below to register a new user.</p>
            </div>

            <div class="p-6 md:p-8">
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="space-y-6">

                        {{-- Personal Information Section --}}
                        <fieldset class="border border-gray-300 p-4 rounded-md">
                            <legend class="text-lg font-medium text-gray-800 px-2">{{ __('Personal Information') }}</legend>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-4">
                                <!-- First Name -->
                                <div class="flex flex-col">
                                    <label for="first_name" class="text-sm font-medium text-gray-700 mb-1">{{ __('First Name') }}</label>
                                    <input id="first_name" type="text"
                                        class="form-input w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('first_name') border-red-500 @enderror px-4 py-2"
                                        name="first_name" value="{{ old('first_name') }}" required autofocus>
                                    @error('first_name')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Middle Name -->
                                <div class="flex flex-col">
                                    <label for="middle_name" class="text-sm font-medium text-gray-700 mb-1">{{ __('Middle Name') }}</label>
                                    <input id="middle_name" type="text"
                                        class="form-input w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('middle_name') border-red-500 @enderror px-4 py-2"
                                        name="middle_name" value="{{ old('middle_name') }}">
                                    @error('middle_name')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Last Name -->
                                <div class="flex flex-col">
                                    <label for="last_name" class="text-sm font-medium text-gray-700 mb-1">{{ __('Last Name') }}</label>
                                    <input id="last_name" type="text"
                                        class="form-input w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('last_name') border-red-500 @enderror px-4 py-2"
                                        name="last_name" value="{{ old('last_name') }}" required>
                                    @error('last_name')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </fieldset>

                        {{-- Contact Information Section --}}
                        <fieldset class="border border-gray-300 p-4 rounded-md">
                            <legend class="text-lg font-medium text-gray-800 px-2">{{ __('Contact Information') }}</legend>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                                <!-- Email -->
                                <div class="flex flex-col">
                                    <label for="email" class="text-sm font-medium text-gray-700 mb-1">{{ __('Email Address') }}</label>
                                    <input id="email" type="email"
                                        class="form-input w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('email') border-red-500 @enderror px-4 py-2"
                                        name="email" value="{{ old('email') }}" required>
                                    @error('email')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Phone -->
                                <div class="flex flex-col">
                                    <label for="phone" class="text-sm font-medium text-gray-700 mb-1">{{ __('Phone') }}</label>
                                    <input id="phone" type="tel"
                                        maxlength="11"
                                        class="form-input w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('phone') border-red-500 @enderror px-4 py-2"
                                        name="phone" value="{{ old('phone') }}" required>
                                    @error('phone')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </fieldset>

                        {{-- Account Details Section --}}
                        <fieldset class="border border-gray-300 p-4 rounded-md">
                            <legend class="text-lg font-medium text-gray-800 px-2">{{ __('Account Details') }}</legend>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-4">
                                <!-- Employee Role -->
                                <div class="flex flex-col md:col-span-1">
                                    <label for="employee_role_id" class="text-sm font-medium text-gray-700 mb-1">{{ __('Employee Role') }}</label>
                                    <select class="form-select w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 px-4 py-2"
                                        name="employee_role_id" id="employee_role_id" required>
                                        <option value="" disabled selected>Select a role</option>
                                        @foreach ($employee_roles as $role)
                                            @php($roleModel = \App\Models\EmployeeRole::query()->find($role->id))
                                            @if ($roleModel && $roleModel->name !== 'management')
                                                <option value="{{ $roleModel->id }}" {{ old('employee_role_id') == $roleModel->id ? 'selected' : '' }}>
                                                    {{ ucfirst($roleModel->name) }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @error('employee_role_id')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Password -->
                                <div class="flex flex-col md:col-span-1">
                                    <label for="password" class="text-sm font-medium text-gray-700 mb-1">{{ __('Password') }}</label>
                                    <input id="password" type="password"
                                        class="form-input w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('password') border-red-500 @enderror px-4 py-2"
                                        name="password" required autocomplete="new-password">
                                    @error('password')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Confirm Password -->
                                <div class="flex flex-col md:col-span-1">
                                    <label for="password-confirm" class="text-sm font-medium text-gray-700 mb-1">{{ __('Confirm Password') }}</label>
                                    <input id="password-confirm" type="password"
                                        class="form-input w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 px-4 py-2"
                                        name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>
                        </fieldset>

                        <!-- Submit Button -->
                        <div class="flex justify-end pt-4">
                            <button type="submit" class="px-6 py-2 bg-blue-600 text-white font-semibold rounded-md shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-150 ease-in-out">
                                {{ __('Register User') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
