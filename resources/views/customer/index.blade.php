@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4">
        <h1 class="text-2xl font-bold mb-4">Customer Management</h1>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <div class="mb-4">
            <a href="{{ route('customer.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Add New Customer
            </a>
        </div>

        <div class="bg-white shadow-md rounded my-6">
            <table class="min-w-full table-auto">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-xs leading-4 font-semibold text-gray-600 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-xs leading-4 font-semibold text-gray-600 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-xs leading-4 font-semibold text-gray-600 uppercase tracking-wider">Phone</th>
                        <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-xs leading-4 font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @forelse ($customers as $customer)
                        <tr>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-500">{{ $customer->name }}</td>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-500">{{ $customer->email ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-500">{{ $customer->phone ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-500 text-sm leading-5">
                                <a href="{{ route('customer.show', $customer) }}" class="text-blue-600 hover:text-blue-900 mr-2">View</a>
                                <a href="{{ route('customer.edit', $customer) }}" class="text-indigo-600 hover:text-indigo-900 mr-2">Edit</a>
                                <form action="{{ route('customer.destroy', $customer) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 whitespace-no-wrap border-b border-gray-500 text-center">No customers found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
         <div class="mt-4">
            {{ $customers->links() }} {{-- Pagination links --}}
        </div>
    </div>
@endsection
