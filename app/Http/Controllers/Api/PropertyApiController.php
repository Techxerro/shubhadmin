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
            ];
        });

        return response()->json([
            'status' => true,
            'message' => 'Property list fetched successfully',
            'data' => $data,
        ]);
    }
}
