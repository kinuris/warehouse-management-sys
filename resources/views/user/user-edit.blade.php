@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <h2 class="text-2xl font-semibold text-gray-800">{{ __('Edit Employee') }}</h2>
            </div>

            <div class="p-6">
                <form method="POST" action="{{ route('users_update', ['user' => $user->id]) }}" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 gap-6">
                        <div class="space-y-2">
                            <label for="first_name" class="text-sm font-medium text-gray-700">{{ __('First Name') }}</label>
                            <input id="first_name" type="text" value="{{ $user->first_name }}" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('first_name') border-red-500 @enderror" 
                                name="first_name" value="{{ old('first_name') }}" required>
                            @error('first_name')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="middle_name" class="text-sm font-medium text-gray-700">{{ __('Middle Name') }}</label>
                            <input id="middle_name" type="text" value="{{ $user->middle_name }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('middle_name') border-red-500 @enderror"
                                name="middle_name" value="{{ old('middle_name') }}" required>
                            @error('middle_name')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="last_name" class="text-sm font-medium text-gray-700">{{ __('Last Name') }}</label>
                            <input id="last_name" type="text" value="{{ $user->last_name }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('last_name') border-red-500 @enderror"
                                name="last_name" value="{{ old('last_name') }}" required>
                            @error('last_name')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="employee_role_id" class="text-sm font-medium text-gray-700">{{ __('Employee Role') }}</label>
                            <select name="employee_role_id" id="employee_role_id"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('employee_role_id') border-red-500 @enderror">
                                @foreach ($employee_roles as $role)
                                @php($role = \App\Models\EmployeeRole::query()->find($role->id))
                                @if ($role->name !== 'management')
                                <option {{ $role->id === $user->employee_role_id ? 'selected' : '' }} value="{{ $role->id }}">{{ ucfirst($role->name) }}</option>
                                @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="space-y-2">
                            <label for="email" class="text-sm font-medium text-gray-700">{{ __('Email Address') }}</label>
                            <input id="email" type="email" value="{{ $user->email }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('email') border-red-500 @enderror"
                                name="email" value="{{ old('email') }}" autocomplete="email">
                            @error('email')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="phone" class="text-sm font-medium text-gray-700">{{ __('Phone') }}</label>
                            <input id="phone" type="tel" value="{{ $user->phone }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('phone') border-red-500 @enderror"
                                name="phone" value="{{ old('phone') }}" required>
                            @error('phone')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                            {{ __('Save') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection