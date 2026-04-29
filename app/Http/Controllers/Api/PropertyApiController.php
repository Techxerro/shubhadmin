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
                'logo' => $property->logo ? asset($property->logo) : null,
                'developer' => $property->developer,
                'location' => $property->location,
                'city' => $property->city,
                'country' => $property->country,
                'bedrooms' => $property->bedrooms,
                'startingPrice' => $property->startingPrice,
                'description' => $property->description,
                'amenities' => $property->amenities ? explode(',', $property->amenities) : [],
                'images' => $property->images->map(function ($img) {
                    return asset($img->image);
                }),
                'payment_plan' => $property->payment_plan ?? [],
                'master_plan_description' => $property->master_plan_description,
                'master_plan_image' => $property->master_plan_image ? asset($property->master_plan_image) : null,
                'prime_location_description' => $property->prime_location_description,
                'prime_location_highlight' => $property->prime_location_highlight,
                'prime_location_image' => $property->prime_location_image
                    ? asset($property->prime_location_image)
                    : null,
                'property_type' => $property->property_type,
                'brochures' => ! empty($property->brochure) ? collect($property->brochure)->map(function ($file) {
                    return asset($file);
                }) : [],
                'is_upcoming' => (bool) $property->is_upcoming,
                'is_featured' => (bool) $property->is_featured,
            ];
        });

        return response()->json([
            'status' => true,
            'message' => 'Property list fetched successfully',
            'data' => $data,
        ]);
    }

    public function featured()
    {
        $properties = Property::with('images')
            ->where('is_featured', 1)
            ->latest()
            ->get();

        $data = $properties->map(function ($property) {
            return [
                'id' => $property->id,
                'name' => $property->name,
                'logo' => $property->logo ? asset($property->logo) : null,
                'developer' => $property->developer,
                'location' => $property->location,
                'city' => $property->city,
                'country' => $property->country,
                'bedrooms' => $property->bedrooms,
                'startingPrice' => $property->startingPrice,
                'description' => $property->description,
                'amenities' => $property->amenities ? explode(',', $property->amenities) : [],

                'images' => $property->images->map(function ($img) {
                    return asset($img->image);
                }),

                // brochures (JSON field)
                'brochures' => ! empty($property->brochure)
                    ? collect($property->brochure)->map(function ($file) {
                        return asset($file);
                    })
                    : [],

                'payment_plan' => $property->payment_plan ?? [],
                'master_plan_description' => $property->master_plan_description,
                'master_plan_image' => $property->master_plan_image
                    ? asset($property->master_plan_image)
                    : null,

                'prime_location_description' => $property->prime_location_description,
                'prime_location_highlight' => $property->prime_location_highlight,
                'prime_location_image' => $property->prime_location_image
                    ? asset($property->prime_location_image)
                    : null,

                'property_type' => $property->property_type,
                'is_featured' => (bool) $property->is_featured,
                'is_upcoming' => (bool) $property->is_upcoming,
            ];
        });

        return response()->json([
            'status' => true,
            'message' => 'Featured properties fetched successfully',
            'data' => $data,
        ]);
    }
}
