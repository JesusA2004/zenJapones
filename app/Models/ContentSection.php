<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContentSection extends Model {

    protected $fillable = [
        'key',
        'title',
        'subtitle',
        'content',
        'image_path',
        'extra_json',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'extra_json' => 'array',
    ];

}
