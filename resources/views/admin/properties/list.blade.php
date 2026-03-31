@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Property List</h1>
            <p class="text-sm text-gray-500">Manage all properties here.</p>
        </div>

        <a href="{{ route('admin.properties.add') }}"
           class="rounded-xl bg-blue-600 px-5 py-2.5 text-white hover:bg-blue-700">
            Add Property
        </a>
    </div>

    <div class="overflow-hidden rounded-2xl bg-white shadow-sm border border-gray-100">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">#</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Logo</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Name</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Developer</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Location</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Bedrooms</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Starting Price</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Amenities</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Action</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100 bg-white">
                    @forelse($properties as $key => $property)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $properties->firstItem() + $key }}</td>
                            <td class="px-4 py-3">
                                @if($property->logo)
                                    <img src="{{ asset('storage/' . $property->logo) }}" class="h-12 w-12 rounded-lg object-cover border">
                                @else
                                    <span class="text-sm text-gray-400">N/A</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-sm font-medium text-gray-800">{{ $property->name }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $property->developer }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $property->location }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $property->bedrooms }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $property->startingPrice }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ \Illuminate\Support\Str::limit($property->amenities, 30) }}</td>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.properties.edit', $property->id) }}"
                                       class="rounded-lg bg-yellow-400 px-3 py-1.5 text-sm font-medium text-white hover:bg-yellow-500">
                                        Edit
                                    </a>

                                    <form action="{{ route('admin.properties.delete', $property->id) }}" method="POST"
                                          onsubmit="return confirm('Delete this property?')">
                                        @csrf
                                        <button type="submit"
                                            class="rounded-lg bg-red-600 px-3 py-1.5 text-sm font-medium text-white hover:bg-red-700">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-4 py-6 text-center text-sm text-gray-500">
                                No properties found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="border-t border-gray-100 px-4 py-4">
            {{ $properties->links() }}
        </div>
    </div>
</div>
@endsection
