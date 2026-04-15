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
    ];

    public function images()
    {
        return $this->hasMany(PropertyImage::class);
    }
}
