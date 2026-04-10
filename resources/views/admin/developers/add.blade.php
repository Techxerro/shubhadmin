@extends('layouts.admin')

@section('content')
<div class="max-w-4xl">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Add Developer</h1>
        <p class="text-sm text-gray-500">Create a new developer record.</p>
    </div>

    <div class="rounded-2xl bg-white p-6 shadow-sm border border-gray-100">
        <form action="{{ route('admin.developers.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">Name</label>
                <input
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                >
                @error('name')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">Description</label>
                <textarea
                    name="description"
                    rows="5"
                    class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                >{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">Image</label>
                <input
                    type="file"
                    name="image"
                    class="w-full rounded-xl border border-gray-300 bg-white px-3 py-2 text-sm"
                >
                @error('image')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center gap-3">
                <button type="submit" class="rounded-xl bg-blue-600 px-5 py-2.5 text-white hover:bg-blue-700">
                    Save Developer
                </button>

                <a href="{{ route('admin.developers.list') }}" class="rounded-xl bg-gray-200 px-5 py-2.5 text-gray-700 hover:bg-gray-300">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
