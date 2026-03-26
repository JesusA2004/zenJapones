<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuPublication extends Model {

    protected $fillable = [
        'version_number',
        'published_by',
        'notes',
    ];

    public function user() {
        return $this->belongsTo(User::class, 'published_by');
    }

}
