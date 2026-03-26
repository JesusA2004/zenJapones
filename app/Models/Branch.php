<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model {

    protected $fillable = [
        'name',
        'slug',
        'phone',
        'whatsapp',
        'email',
        'address',
        'city',
        'state',
        'postal_code',
        'maps_url',
        'latitude',
        'longitude',
        'hours_text',
        'image_path',
        'description',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

}
