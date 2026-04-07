@extends('layouts.admin')

@section('content')
<div class="max-w-5xl">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Edit Property</h1>
        <p class="text-sm text-gray-500">Update property details.</p>
    </div>

    <div class="rounded-2xl bg-white p-6 shadow-sm border border-gray-100">
        <form action="{{ route('admin.properties.update', $property->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" name="name" value="{{ old('name', $property->name) }}"
                        class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700">Change Logo</label>
                    <input type="file" name="logo"
                        class="w-full rounded-xl border border-gray-300 bg-white px-3 py-2 text-sm">
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700">Developer</label>
                    <input type="text" name="developer" value="{{ old('developer', $property->developer) }}"
                        class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700">Location</label>
                    <input type="text" name="location" value="{{ old('location', $property->location) }}"
                        class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700">City</label>
                    <input type="text" name="city" value="{{ old('city', $property->city) }}"
                        class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700">Country</label>
                    <input type="text" name="country" value="{{ old('country', $property->country) }}"
                        class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700">Bedrooms</label>
                    <input type="text" name="bedrooms" value="{{ old('bedrooms', $property->bedrooms) }}"
                        class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700">Starting Price</label>
                    <input type="text" name="startingPrice" value="{{ old('startingPrice', $property->startingPrice) }}"
                        class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                </div>
            </div>

            @if($property->logo)
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700">Current Logo</label>
                    <img src="{{ asset('storage/' . $property->logo) }}" class="h-20 w-20 rounded-xl object-cover border">
                </div>
            @endif

            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">Amenities</label>
                <input type="text" name="amenities" value="{{ old('amenities', $property->amenities) }}"
                    class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500">
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">Add More Property Images</label>
                <input type="file" name="images[]" multiple
                    class="w-full rounded-xl border border-gray-300 bg-white px-3 py-2 text-sm">
                <p class="mt-1 text-xs text-gray-500">You can upload multiple new images</p>
                @error('images.*') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">Description</label>
                <textarea name="description" rows="5"
                    class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500">{{ old('description', $property->description) }}</textarea>
            </div>

            <div class="flex items-center gap-3">
                <button type="submit"
                    class="rounded-xl bg-blue-600 px-5 py-2.5 text-white hover:bg-blue-700">
                    Update Property
                </button>

                <a href="{{ route('admin.properties.list') }}"
                    class="rounded-xl bg-gray-200 px-5 py-2.5 text-gray-700 hover:bg-gray-300">
                    Cancel
                </a>
            </div>
        </form>
    </div>

     <!-- GALLERY SECTION OUTSIDE MAIN FORM -->
    @if($property->images->count())
        <div class="mt-6 rounded-2xl bg-white p-6 shadow-sm border border-gray-100">
            <label class="mb-4 block text-sm font-medium text-gray-700">Property Gallery</label>

            <div class="grid grid-cols-2 gap-4 md:grid-cols-4">
                @foreach($property->images as $img)
                    <div class="rounded-xl border p-2">
                        <img src="{{ asset('storage/' . $img->image) }}"
                             class="h-24 w-full rounded-lg object-cover">

                        <form action="{{ route('admin.properties.image.delete', $img->id) }}"
                              method="POST"
                              class="mt-2"
                              onsubmit="return confirm('Delete this image?')">
                            @csrf
                            <button type="submit"
                                class="w-full rounded-lg bg-red-600 px-3 py-2 text-sm text-white hover:bg-red-700">
                                Delete
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
