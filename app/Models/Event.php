<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model {

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'description',
        'image_path',
        'start_at',
        'end_at',
        'location',
        'cta_text',
        'cta_url',
        'is_published',
        'sort_order',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'start_at' => 'datetime',
        'end_at' => 'datetime',
    ];

}
