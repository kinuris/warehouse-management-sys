@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">Reports & Analytics</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Sales Report Card -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden transition-all duration-300 hover:shadow-lg border border-gray-200">
            <div class="p-6">
                <div class="flex items-center mb-4">
                    <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-800">Sales Performance Report</h2>
                </div>
                
                <p class="text-gray-600 mb-6">Generate detailed sales reports with revenue, profit analysis, and top-performing products for any date range.</p>
                
                <form class="mb-4" action="{{ route('report.generate') }}">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                        <div class="col-span-1">
                            <label for="start" class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                            <input type="date" id="start" name="start" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        </div>
                        <div class="col-span-1">
                            <label for="end" class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                            <input type="date" id="end" name="end" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        </div>
                        <div class="col-span-1 flex items-end">
                            <button type="submit" class="w-full py-2 px-4 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md shadow-sm transition duration-150 ease-in-out">
                                Generate Report
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Inventory Report Card -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden transition-all duration-300 hover:shadow-lg border border-gray-200">
            <div class="p-6">
                <div class="flex items-center mb-4">
                    <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-800">Inventory Status Report</h2>
                </div>
                
                <p class="text-gray-600 mb-6">View comprehensive inventory status including stock levels, values, low stock alerts, and category-based analysis.</p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <div class="col-span-1">
                        <a href="{{ route('reports.inventory') }}" class="block w-full py-2 px-4 text-center bg-green-600 hover:bg-green-700 text-white font-medium rounded-md shadow-sm transition duration-150 ease-in-out">
                            View Full Report
                        </a>
                    </div>
                    <div class="col-span-1">
                        <a href="{{ route('reports.inventory') }}?low_stock=1" class="block w-full py-2 px-4 text-center bg-red-600 hover:bg-red-700 text-white font-medium rounded-md shadow-sm transition duration-150 ease-in-out">
                            Low Stock Only
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- More Report Types can be added here -->
</div>
@endsection