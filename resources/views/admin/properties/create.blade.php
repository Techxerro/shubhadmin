@extends('layouts.admin')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Add Property</h1>

    <form action="{{ route('properties.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label class="block mb-1 font-medium">Title</label>
            <input type="text" name="title" class="w-full border rounded px-3 py-2" value="{{ old('title') }}">
            @error('title') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block mb-1 font-medium">Location</label>
            <input type="text" name="location" class="w-full border rounded px-3 py-2" value="{{ old('location') }}">
        </div>

        <div>
            <label class="block mb-1 font-medium">Price</label>
            <input type="number" step="0.01" name="price" class="w-full border rounded px-3 py-2" value="{{ old('price') }}">
        </div>

        <div>
            <label class="block mb-1 font-medium">Description</label>
            <textarea name="description" class="w-full border rounded px-3 py-2" rows="4">{{ old('description') }}</textarea>
        </div>

        <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700">
            Save Property
        </button>
    </form>
@endsection
