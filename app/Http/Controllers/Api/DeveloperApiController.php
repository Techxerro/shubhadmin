<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Developer;

class DeveloperApiController extends Controller
{
    public function index()
    {
        $developers = Developer::latest()->get();

        $data = $developers->map(function ($developer) {
            return [
                'id' => $developer->id,
                'name' => $developer->name,
                'description' => $developer->description,
                'image' => $developer->image ? asset('storage/' . $developer->image) : null,
                'created_at' => $developer->created_at,
                'updated_at' => $developer->updated_at,
                'is_featured' => (bool) $developer->is_featured,
            ];
        });

        return response()->json([
            'status' => true,
            'message' => 'Developer list fetched successfully',
            'data' => $data,
        ]);
    }

    public function featured()
    {
        $developers = Developer::where('is_featured', 1)->latest()->get();

        $data = $developers->map(function ($dev) {
            return [
                'id' => $dev->id,
                'name' => $dev->name,
                'description' => $dev->description,
                'image' => $dev->image ? asset('storage/' . $dev->image) : null,
                'is_featured' => (bool) $dev->is_featured,
            ];
        });

        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }


}
