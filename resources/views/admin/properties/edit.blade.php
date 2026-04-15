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
                    <label class="mb-2 block text-sm font-medium text-gray-700">Property Type</label>

                    <select name="property_type"
                        class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500">

                        <option value="">Select Type</option>

                        <option value="off_plan"
                            {{ old('property_type', $property->property_type) == 'off_plan' ? 'selected' : '' }}>
                            Off Plan
                        </option>

                        <option value="buy"
                            {{ old('property_type', $property->property_type) == 'buy' ? 'selected' : '' }}>
                            Buy
                        </option>

                        <option value="rent"
                            {{ old('property_type', $property->property_type) == 'rent' ? 'selected' : '' }}>
                            Rent
                        </option>

                    </select>
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700">Is Upcoming?</label>

                    <select name="is_upcoming"
                        class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500">

                        <option value="0"
                            {{ old('is_upcoming', $property->is_upcoming) == 0 ? 'selected' : '' }}>
                            No
                        </option>

                        <option value="1"
                            {{ old('is_upcoming', $property->is_upcoming) == 1 ? 'selected' : '' }}>
                            Yes (Upcoming)
                        </option>

                    </select>
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
                <label class="mb-2 block text-sm font-medium text-gray-700">Upload Brochures (PDF)</label>

                <input type="file" name="brochures[]" multiple
                    class="w-full rounded-xl border border-gray-300 bg-white px-3 py-2 text-sm">

                <p class="mt-1 text-xs text-gray-500">You can upload multiple PDF brochures</p>

                @error('brochures.*')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">Description</label>
                <textarea name="description" rows="5"
                    class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500">{{ old('description', $property->description) }}</textarea>
            </div>
            <div class="rounded-2xl border border-gray-200 p-5 space-y-5">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Master Plan</h3>
                    <p class="text-sm text-gray-500">Add master plan description and image.</p>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700">Master Plan Description</label>
                    <textarea
                        name="master_plan_description"
                        rows="5"
                        class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                    >{{ old('master_plan_description', $property->master_plan_description) }}</textarea>
                    @error('master_plan_description')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700">Master Plan Image</label>
                    <input
                        type="file"
                        name="master_plan_image"
                        class="w-full rounded-xl border border-gray-300 bg-white px-3 py-2 text-sm"
                    >
                    @error('master_plan_image')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                @if($property->master_plan_image)
                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-700">Current Master Plan Image</label>
                        <img
                            src="{{ asset('storage/' . $property->master_plan_image) }}"
                            class="max-h-64 rounded-xl border object-cover"
                        >
                    </div>
                @endif
            </div>

            <div class="rounded-2xl border border-gray-200 p-5 space-y-5">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Prime Location</h3>
                    <p class="text-sm text-gray-500">Add prime location details.</p>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700">Description</label>
                    <textarea
                        name="prime_location_description"
                        rows="4"
                        class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                    >{{ old('prime_location_description', $property->prime_location_description) }}</textarea>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700">Highlight</label>
                    <input
                        type="text"
                        name="prime_location_highlight"
                        value="{{ old('prime_location_highlight', $property->prime_location_highlight) }}"
                        class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                    >
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700">Image</label>
                    <input
                        type="file"
                        name="prime_location_image"
                        class="w-full rounded-xl border border-gray-300 bg-white px-3 py-2 text-sm"
                    >
                </div>

                @if($property->prime_location_image)
                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-700">Current Image</label>
                        <img
                            src="{{ asset('storage/' . $property->prime_location_image) }}"
                            class="max-h-64 rounded-xl border object-cover"
                        >
                    </div>
                @endif
            </div>


            @php
    $paymentPlanOld = old('payment_plan', $property->payment_plan ?? []);
    $paymentPlanOld = is_array($paymentPlanOld) && count($paymentPlanOld)
        ? $paymentPlanOld
        : [['key' => '', 'value' => '']];
@endphp

<div
    x-data='{
        plans: @json($paymentPlanOld)
    }'
    class="space-y-4"
>
    <div>
        <label class="mb-2 block text-sm font-medium text-gray-700">Payment Plan</label>
        <p class="text-xs text-gray-500">Add payment plan rows like Down Payment = 10%</p>
    </div>

            <template x-for="(plan, index) in plans" :key="index">
                <div class="grid grid-cols-1 gap-3 md:grid-cols-12">
                    <div class="md:col-span-5">
                        <input
                            type="text"
                            :name="`payment_plan[${index}][key]`"
                            x-model="plan.key"
                            placeholder="Key e.g. Down Payment"
                            class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                        >
                    </div>

                    <div class="md:col-span-5">
                        <input
                            type="text"
                            :name="`payment_plan[${index}][value]`"
                            x-model="plan.value"
                            placeholder="Value e.g. 10%"
                            class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                        >
                    </div>

                    <div class="md:col-span-2">
                        <button
                            type="button"
                            @click="plans.splice(index, 1)"
                            class="w-full rounded-xl bg-red-600 px-4 py-2.5 text-white hover:bg-red-700"
                        >
                            Remove
                        </button>
                    </div>
                </div>
            </template>

            <div class="flex gap-3">
                <button
                    type="button"
                    @click="plans.push({ key: '', value: '' })"
                    class="rounded-xl bg-gray-800 px-4 py-2.5 text-white hover:bg-gray-900"
                >
                    Add Row
                </button>
            </div>

            @error('payment_plan')
                <p class="text-sm text-red-500">{{ $message }}</p>
            @enderror
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
    @if(!empty($property->brochure))
        <div class="mt-6 rounded-2xl bg-white p-6 shadow-sm border border-gray-100">
            <label class="mb-4 block text-sm font-medium text-gray-700">Property Brochures</label>

            <div class="space-y-3">
                @foreach($property->brochure as $index => $file)
                    <div class="flex items-center justify-between rounded-lg border p-3">

                        <a href="{{ asset('storage/'.$file) }}" target="_blank"
                        class="text-blue-600 hover:underline">
                            📄 View Brochure {{ $index + 1 }}
                        </a>

                        <form action="{{ route('admin.properties.deleteBrochure', [$property->id, $index]) }}"
                            method="POST"
                            onsubmit="return confirm('Delete this brochure?')">
                            @csrf

                            <button type="submit"
                                class="rounded-lg bg-red-600 px-3 py-1 text-sm text-white hover:bg-red-700">
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
