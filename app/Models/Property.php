<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\PropertyImage;

class Property extends Model
{
    protected $guarded = [];

    protected $casts = [
        'payment_plan' => 'array',
        'brochure' => 'array',
        'is_upcoming' => 'boolean',
        'is_featured' => 'boolean',
    ];

    public function images()
    {
        return $this->hasMany(PropertyImage::class);
    }
}
