@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white shadow-lg rounded-lg">
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                <h1 class="text-2xl font-semibold text-gray-800">{{ __('Register') }}</h1>
            </div>

            <div class="p-6">
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="space-y-6">
                        <!-- First Name -->
                        <div class="flex flex-col">
                            <label for="first_name" class="text-sm font-medium text-gray-700 mb-1">{{ __('First Name') }}</label>
                            <input id="first_name" type="text" 
                                class="form-input w-full rounded-md border-2 border-gray-300 p-2 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 @error('first_name') border-red-500 @enderror"
                                name="first_name" value="{{ old('first_name') }}" required autofocus>
                            @error('first_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Middle Name -->
                        <div class="flex flex-col">
                            <label for="middle_name" class="text-sm font-medium text-gray-700 mb-1">{{ __('Middle Name') }}</label>
                            <input id="middle_name" type="text" 
                                class="form-input w-full rounded-md border-2 border-gray-300 p-2 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 @error('middle_name') border-red-500 @enderror"
                                name="middle_name" value="{{ old('middle_name') }}" required>
                            @error('middle_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Last Name -->
                        <div class="flex flex-col">
                            <label for="last_name" class="text-sm font-medium text-gray-700 mb-1">{{ __('Last Name') }}</label>
                            <input id="last_name" type="text" 
                                class="form-input w-full rounded-md border-2 border-gray-300 p-2 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 @error('last_name') border-red-500 @enderror"
                                name="last_name" value="{{ old('last_name') }}" required>
                            @error('last_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Employee Role -->
                        <div class="flex flex-col">
                            <label for="employee_role_id" class="text-sm font-medium text-gray-700 mb-1">{{ __('Employee Role') }}</label>
                            <select class="form-select w-full rounded-md border-2 border-gray-300 p-2 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                                name="employee_role_id" id="employee_role_id">
                                @foreach ($employee_roles as $role)
                                    @php($role = \App\Models\EmployeeRole::query()->find($role->id))
                                    @if ($role->name !== 'management')
                                        <option value="{{ $role->id }}">{{ ucfirst($role->name) }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <!-- Email -->
                        <div class="flex flex-col">
                            <label for="email" class="text-sm font-medium text-gray-700 mb-1">{{ __('Email Address') }}</label>
                            <input id="email" type="email" 
                                class="form-input w-full rounded-md border-2 border-gray-300 p-2 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 @error('email') border-red-500 @enderror"
                                name="email" value="{{ old('email') }}" required>
                            @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div class="flex flex-col">
                            <label for="phone" class="text-sm font-medium text-gray-700 mb-1">{{ __('Phone') }}</label>
                            <input id="phone" type="tel" 
                                maxlength="11"
                                class="form-input w-full rounded-md border-2 border-gray-300 p-2 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 @error('phone') border-red-500 @enderror"
                                name="phone" value="{{ old('phone') }}" required>
                            @error('phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="flex flex-col">
                            <label for="password" class="text-sm font-medium text-gray-700 mb-1">{{ __('Password') }}</label>
                            <input id="password" type="password" 
                                class="form-input w-full rounded-md border-2 border-gray-300 p-2 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 @error('password') border-red-500 @enderror"
                                name="password" required>
                            @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="flex flex-col">
                            <label for="password-confirm" class="text-sm font-medium text-gray-700 mb-1">{{ __('Confirm Password') }}</label>
                            <input id="password-confirm" type="password" 
                                class="form-input w-full rounded-md border-2 border-gray-300 p-2 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                                name="password_confirmation" required>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end">
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                                {{ __('Register') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
