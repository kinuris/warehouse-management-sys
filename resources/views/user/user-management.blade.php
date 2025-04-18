@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8"> {{-- Added padding and centering --}}
    <h1 class="text-3xl font-bold mb-6">User Management</h1> {{-- Added margin-bottom --}}

    {{-- Add Employee Button --}}
    <div class="mb-6"> {{-- Added margin for spacing --}}
        <a href="{{ route('register') }}"
           class="inline-block px-4 py-2 bg-blue-600 text-white font-medium rounded shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
            Add Employee
        </a>
    </div>

    {{-- User Table --}}
    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Employee ID
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Name
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Email
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Phone
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($users as $user) {{-- Use forelse for empty state --}}
                    <tr class="hover:bg-gray-50 transition-colors duration-150 ease-in-out">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium {{ $user->is_suspended ? 'text-red-500 line-through' : 'text-gray-900' }}">
                            {{ $user->is_suspended ? '(Suspended) ' : '' }}{{ $user->internal_id }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm {{ $user->is_suspended ? 'text-red-500 line-through' : 'text-gray-900' }}">
                            {{ $user->getFullname() }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            {{ $user->email }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            {{ $user->phone }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center space-x-3">
                                {{-- Edit Action --}}
                                <a href="{{ route('users_edit', ['user' => $user->id]) }}"
                                   class="px-3 py-1 text-xs font-semibold text-white bg-green-600 rounded-md shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                                    Edit
                                </a>

                                {{-- Suspend/Allow Action --}}
                                @if ($user->is_suspended)
                                <a href="{{ route('users_delete', ['user' => $user->id]) }}"
                                   class="px-3 py-1 text-xs font-semibold text-white bg-blue-600 rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                    Allow
                                </a>
                                @else
                                <a href="{{ route('users_delete', ['user' => $user->id]) }}"
                                   class="px-3 py-1 text-xs font-semibold text-white bg-red-600 rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                                    Suspend
                                </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                            No users found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    {{-- Consider adding pagination if the user list can grow large --}}
    {{-- <div class="mt-6">
        {{ $users->links() }}
    </div> --}}
</div>
@endsection