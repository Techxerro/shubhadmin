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
        ]);

        $logoPath = $property->logo;

        if ($request->hasFile('logo')) {
            if ($property->logo && Storage::disk('public')->exists($property->logo)) {
                Storage::disk('public')->delete($property->logo);
            }

            $logoPath = $request->file('logo')->store('properties', 'public');
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

}
