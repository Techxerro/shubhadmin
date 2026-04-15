<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Property;

class PropertyApiController extends Controller
{
    public function index()
    {
        $properties = Property::with('images')->latest()->get();

        $data = $properties->map(function ($property) {
            return [
                'id' => $property->id,
                'name' => $property->name,
                'logo' => $property->logo ? asset('storage/' . $property->logo) : null,
                'developer' => $property->developer,
                'location' => $property->location,
                'city' => $property->city,
                'country' => $property->country,
                'bedrooms' => $property->bedrooms,
                'startingPrice' => $property->startingPrice,
                'description' => $property->description,
                'amenities' => $property->amenities ? explode(',', $property->amenities) : [],
                'images' => $property->images->map(function ($img) {
                    return asset('storage/' . $img->image);
                }),
                'payment_plan' => $property->payment_plan ?? [],
                'master_plan_description' => $property->master_plan_description,
                'master_plan_image' => $property->master_plan_image ? asset('storage/' . $property->master_plan_image) : null,
                'prime_location_description' => $property->prime_location_description,
                'prime_location_highlight' => $property->prime_location_highlight,
                'prime_location_image' => $property->prime_location_image
                    ? asset('storage/' . $property->prime_location_image)
                    : null,
                'property_type' => $property->property_type,
                'brochures' => !empty($property->brochure)? collect($property->brochure)->map(function ($file) {
                        return asset('storage/' . $file);
                    }) : [],
                    'is_upcoming' => (bool) $property->is_upcoming,
            ];
        });

        return response()->json([
            'status' => true,
            'message' => 'Property list fetched successfully',
            'data' => $data,
        ]);
    }
}
