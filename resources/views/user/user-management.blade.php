@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-3xl font-bold">User Management</h1>

    <div class="my-5"></div>

    <a href="{{ route('register') }}" class="p-2 bg-blue-600 text-white rounded">Add Employee</a>
    <div class="min-w-full mt-8">
        <div class="overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-left">
            <thead class="bg-gray-50">
                <tr>
                <th class="px-6 py-4 text-sm font-semibold text-gray-700">Employee ID</th>
                <th class="px-6 py-4 text-sm font-semibold text-gray-700">Name</th>
                <th class="px-6 py-4 text-sm font-semibold text-gray-700">Email</th>
                <th class="px-6 py-4 text-sm font-semibold text-gray-700">Phone</th>
                <th class="px-6 py-4 text-sm font-semibold text-gray-700">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($users as $user)
                <tr class="hover:bg-gray-50 transition-colors duration-200">
                <td class="px-6 py-4 whitespace-nowrap {{ $user->is_suspended ? 'text-red-500 line-through' : 'text-gray-700' }}">
                    {{ $user->is_suspended ? '(Suspended) ' : '' }}{{ $user->internal_id }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap {{ $user->is_suspended ? 'text-red-500 line-through' : 'text-gray-700' }}">
                    {{ $user->getFullname() }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $user->email }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $user->phone }}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center space-x-3">
                    <a href="{{ route('users_edit', ['user' => $user->id]) }}" 
                       class="px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                        Edit
                    </a>
                    @if ($user->is_suspended)
                    <a href="{{ route('users_delete', ['user' => $user->id]) }}" 
                       class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        Allow
                    </a>
                    @else
                    <a href="{{ route('users_delete', ['user' => $user->id]) }}" 
                       class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                        Suspend
                    </a>
                    @endif
                    </div>
                </td>
                </tr>
                @endforeach
            </tbody>
            </table>
        </div>
    </div>
</div>
@endsection