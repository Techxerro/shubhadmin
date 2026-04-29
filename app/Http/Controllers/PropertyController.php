<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\PropertyImage;
use App\Services\FileUploadService;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    protected FileUploadService $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }

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
            $logoPath = $this->fileUploadService->upload($request->file('logo'), 'properties');
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
                $imagePath = $this->fileUploadService->upload($image, 'properties/gallery');

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
                return ! empty($item['key']) || ! empty($item['value']);
            })
            ->values()
            ->toArray();

        $logoPath = $property->logo;

        if ($request->hasFile('logo')) {
            if ($property->logo && $this->fileUploadService->exists($property->logo)) {
                $this->fileUploadService->delete($property->logo);
            }

            $logoPath = $this->fileUploadService->upload($request->file('logo'), 'properties');
        }

        $masterPlanImagePath = $property->master_plan_image;

        if ($request->hasFile('master_plan_image')) {
            if ($property->master_plan_image && $this->fileUploadService->exists($property->master_plan_image)) {
                $this->fileUploadService->delete($property->master_plan_image);
            }

            $masterPlanImagePath = $this->fileUploadService->upload($request->file('master_plan_image'), 'properties/master-plan');
        }

        $primeLocationImagePath = $property->prime_location_image;

        if ($request->hasFile('prime_location_image')) {

            if ($property->prime_location_image && $this->fileUploadService->exists($property->prime_location_image)) {

                $this->fileUploadService->delete($property->prime_location_image);
            }

            $primeLocationImagePath = $this->fileUploadService->upload($request->file('prime_location_image'), 'properties/prime-location');
        }

        $existingBrochures = $property->brochure ?? [];

        if ($request->hasFile('brochures')) {

            foreach ($request->file('brochures') as $file) {
                $path = $this->fileUploadService->upload($file, 'properties/brochures');
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
                $imagePath = $this->fileUploadService->upload($image, 'properties/gallery');

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

        if ($property->logo && $this->fileUploadService->exists($property->logo)) {
            $this->fileUploadService->delete($property->logo);
        }

        // Delete associated images
        foreach ($property->images as $img) {
            if ($img->image && $this->fileUploadService->exists($img->image)) {
                $this->fileUploadService->delete($img->image);
            }
        }

        $property->delete();

        return redirect()->route('admin.properties.list')->with('success', 'Property deleted successfully.');
    }

    public function deleteImage($id)
    {
        $image = PropertyImage::findOrFail($id);
        $propertyId = $image->property_id;

        if ($image->image && $this->fileUploadService->exists($image->image)) {
            $this->fileUploadService->delete($image->image);
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

            if ($this->fileUploadService->exists($brochures[$index])) {
                $this->fileUploadService->delete($brochures[$index]);
            }

            unset($brochures[$index]);

            $property->brochure = array_values($brochures);
            $property->save();
        }

        return back()->with('success', 'Brochure deleted successfully');
    }
}
