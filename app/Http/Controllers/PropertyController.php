<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\PropertyImage;

class PropertyController extends Controller
{
    public function list()
    {
        $properties = Property::with('images')->latest()->paginate(10);
        return view('admin.properties.list', compact('properties'));
    }

    public function add()
    {
        return view('admin.properties.add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'developer' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'bedrooms' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'startingPrice' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'amenities' => 'nullable|string',
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'property_type' => 'required|in:off_plan,buy,rent',
            'is_upcoming' => 'required|boolean',
        ]);

        $logoPath = null;

        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('properties', 'public');
        }

         $property = Property::create([
            'name' => $request->name,
            'logo' => $logoPath,
            'developer' => $request->developer,
            'location' => $request->location,
            'city' => $request->city,
            'country' => $request->country,
            'bedrooms' => $request->bedrooms,
            'startingPrice' => $request->startingPrice,
            'description' => $request->description,
            'amenities' => $request->amenities,
            'property_type' => $request->property_type,
            'is_upcoming' => $request->is_upcoming,
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePath = $image->store('properties/gallery', 'public');

                PropertyImage::create([
                    'property_id' => $property->id,
                    'image' => $imagePath,
                ]);
            }
        }

        return redirect()->route('admin.properties.list')->with('success', 'Property added successfully.');
    }

    public function edit($id)
    {
        $property = Property::with('images')->findOrFail($id);
        return view('admin.properties.edit', compact('property'));
    }

    public function update(Request $request, $id)
    {
        $property = Property::with('images')->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'developer' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'bedrooms' => 'nullable|string|max:255',
            'startingPrice' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'amenities' => 'nullable|string',
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'payment_plan' => 'nullable|array',
            'payment_plan.*.key' => 'nullable|string|max:255',
            'payment_plan.*.value' => 'nullable|string|max:255',
            'master_plan_description' => 'nullable|string',
            'master_plan_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'prime_location_description' => 'nullable|string',
            'prime_location_highlight' => 'nullable|string|max:255',
            'prime_location_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'brochures.*' => 'nullable|mimes:pdf|max:5120',
            'is_upcoming' => 'boolean',
            'is_featured' => 'boolean',
        ]);

        $paymentPlan = collect($request->payment_plan ?? [])
        ->filter(function ($item) {
            return !empty($item['key']) || !empty($item['value']);
        })
        ->values()
        ->toArray();

        $logoPath = $property->logo;

        if ($request->hasFile('logo')) {
            if ($property->logo && Storage::disk('public')->exists($property->logo)) {
                Storage::disk('public')->delete($property->logo);
            }

            $logoPath = $request->file('logo')->store('properties', 'public');
        }

        $masterPlanImagePath = $property->master_plan_image;

        if ($request->hasFile('master_plan_image')) {
            if ($property->master_plan_image && Storage::disk('public')->exists($property->master_plan_image)) {
                Storage::disk('public')->delete($property->master_plan_image);
            }

            $masterPlanImagePath = $request->file('master_plan_image')->store('properties/master-plan', 'public');
        }

        $primeLocationImagePath = $property->prime_location_image;

        if ($request->hasFile('prime_location_image')) {

            if ($property->prime_location_image && Storage::disk('public')->exists($property->prime_location_image)) {

                Storage::disk('public')->delete($property->prime_location_image);
            }

            $primeLocationImagePath = $request->file('prime_location_image')
                ->store('properties/prime-location', 'public');
        }

        $existingBrochures = $property->brochure ?? [];

        if ($request->hasFile('brochures')) {

            foreach ($request->file('brochures') as $file) {
                $path = $file->store('properties/brochures', 'public');
                $existingBrochures[] = $path;
            }
        }

        $property->update([
            'name' => $request->name,
            'logo' => $logoPath,
            'developer' => $request->developer,
            'location' => $request->location,
            'city' => $request->city,
            'country' => $request->country,
            'bedrooms' => $request->bedrooms,
            'startingPrice' => $request->startingPrice,
            'description' => $request->description,
            'amenities' => $request->amenities,
            'payment_plan' => $paymentPlan,
            'master_plan_description' => $request->master_plan_description,
            'master_plan_image' => $masterPlanImagePath,
            'prime_location_description' => $request->prime_location_description,
            'prime_location_highlight' => $request->prime_location_highlight,
            'prime_location_image' => $primeLocationImagePath,
            'property_type' => $request->property_type,
            'brochure' => $existingBrochures,
            'is_upcoming' => $request->is_upcoming,
            'is_featured' => $request->is_featured,
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePath = $image->store('properties/gallery', 'public');

                PropertyImage::create([
                    'property_id' => $property->id,
                    'image' => $imagePath,
                ]);
            }
        }

        return redirect()->route('admin.properties.list')->with('success', 'Property updated successfully.');
    }

    public function delete($id)
    {
        $property = Property::with('images')->findOrFail($id);

        if ($property->logo && Storage::disk('public')->exists($property->logo)) {
            Storage::disk('public')->delete($property->logo);
        }

        // Delete associated images
        foreach ($property->images as $img) {
            if ($img->image && Storage::disk('public')->exists($img->image)) {
                Storage::disk('public')->delete($img->image);
            }
        }

        $property->delete();

        return redirect()->route('admin.properties.list')->with('success', 'Property deleted successfully.');
    }

    public function deleteImage($id)
    {
        $image = PropertyImage::findOrFail($id);
        $propertyId = $image->property_id;

        if ($image->image && Storage::disk('public')->exists($image->image)) {
            Storage::disk('public')->delete($image->image);
        }

        $image->delete();

        return redirect()
        ->route('admin.properties.edit', $propertyId)
        ->with('success', 'Image deleted successfully.');
    }

    public function deleteBrochure($id, $index)
    {
        $property = Property::findOrFail($id);

        $brochures = $property->brochure ?? [];

        if (isset($brochures[$index])) {

            if (Storage::disk('public')->exists($brochures[$index])) {
                Storage::disk('public')->delete($brochures[$index]);
            }

            unset($brochures[$index]);

            $property->brochure = array_values($brochures);
            $property->save();
        }

        return back()->with('success', 'Brochure deleted successfully');
    }

}
