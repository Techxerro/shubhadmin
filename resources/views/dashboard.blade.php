@extends('layouts.admin')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Dashboard</h1>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">

        <div class="bg-blue-500 text-white p-5 rounded-lg shadow">
            <h2 class="text-lg">Total Properties</h2>
            {{-- <p class="text-3xl font-bold mt-2">{{ $totalProperties }}</p> --}}
        </div>

        <div class="bg-green-500 text-white p-5 rounded-lg shadow">
            <h2 class="text-lg">Active Listings</h2>
            {{-- <p class="text-3xl font-bold mt-2">{{ $totalProperties }}</p> --}}
        </div>

        <div class="bg-purple-500 text-white p-5 rounded-lg shadow">
            <h2 class="text-lg">New This Month</h2>
            {{-- <p class="text-3xl font-bold mt-2">{{ $latestProperties->count() }}</p> --}}
        </div>

    </div>

    <!-- Latest Properties -->
    <div>
        <h2 class="text-xl font-semibold mb-4">Latest Properties</h2>

        <div class="overflow-x-auto">
            <table class="w-full border border-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border px-4 py-2 text-left">#</th>
                        <th class="border px-4 py-2 text-left">Title</th>
                        <th class="border px-4 py-2 text-left">Location</th>
                        <th class="border px-4 py-2 text-left">Price</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- @forelse($latestProperties as $property)
                        <tr>
                            <td class="border px-4 py-2">{{ $property->id }}</td>
                            <td class="border px-4 py-2">{{ $property->title }}</td>
                            <td class="border px-4 py-2">{{ $property->location }}</td>
                            <td class="border px-4 py-2">{{ $property->price }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="border px-4 py-4 text-center text-gray-500">
                                No data found
                            </td>
                        </tr>
                    @endforelse --}}
                </tbody>
            </table>
        </div>
    </div>
@endsection
