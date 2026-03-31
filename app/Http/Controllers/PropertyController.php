<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class PropertyController extends Controller
{
    public function list()
    {
        $properties = Property::latest()->paginate(10);
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
            'startingPrice' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'amenities' => 'nullable|string',
        ]);

        $logoPath = null;

        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('properties', 'public');
        }

        Property::create([
            'name' => $request->name,
            'logo' => $logoPath,
            'developer' => $request->developer,
            'location' => $request->location,
            'bedrooms' => $request->bedrooms,
            'startingPrice' => $request->startingPrice,
            'description' => $request->description,
            'amenities' => $request->amenities,
        ]);

        return redirect()->route('admin.properties.list')->with('success', 'Property added successfully.');
    }

    public function edit($id)
    {
        $property = Property::findOrFail($id);
        return view('admin.properties.edit', compact('property'));
    }

    public function update(Request $request, $id)
    {
        $property = Property::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'developer' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'bedrooms' => 'nullable|string|max:255',
            'startingPrice' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'amenities' => 'nullable|string',
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
            'bedrooms' => $request->bedrooms,
            'startingPrice' => $request->startingPrice,
            'description' => $request->description,
            'amenities' => $request->amenities,
        ]);

        return redirect()->route('admin.properties.list')->with('success', 'Property updated successfully.');
    }

    public function delete($id)
    {
        $property = Property::findOrFail($id);

        if ($property->logo && Storage::disk('public')->exists($property->logo)) {
            Storage::disk('public')->delete($property->logo);
        }

        $property->delete();

        return redirect()->route('admin.properties.list')->with('success', 'Property deleted successfully.');
    }

}
