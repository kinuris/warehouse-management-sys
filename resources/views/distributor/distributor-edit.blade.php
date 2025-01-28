@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-2xl">
    <div class="bg-white p-8 rounded-lg shadow-lg">
        <h1 class="text-3xl font-bold text-gray-800 mb-6 border-b pb-4">Edit Distributor Details</h1>

        <form action="{{ route('distributor.update', $distributor->id) }}" method="POST">
            @csrf
            <div class="grid gap-6">
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Company Name</label>
                    <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-blue-500" id="name" name="name" value="{{ $distributor->name }}" required>
                </div>

                <div class="mb-4">
                    <label for="authority_name" class="block text-gray-700 text-sm font-bold mb-2">Authority Name</label>
                    <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-blue-500" id="authority_name" name="authority_name" value="{{ $distributor->authority_name }}" required>
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email Address</label>
                    <input type="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-blue-500" id="email" name="email" value="{{ $distributor->email }}" required>
                </div>

                <div class="mb-6">
                    <label for="phone" class="block text-gray-700 text-sm font-bold mb-2">Contact Number</label>
                    <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-blue-500" id="phone" name="contact_number" value="{{ $distributor->contact_number }}" required>
                </div>

                <div class="flex items-center justify-end">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg focus:outline-none focus:shadow-outline transition duration-300">
                        Update Distributor
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection