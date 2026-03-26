<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model {

    protected $fillable = [
        'site_name',
        'site_tagline',
        'contact_email',
        'contact_phone',
        'whatsapp_number',
        'reservation_url',
        'billing_url',
        'privacy_content',
        'jobs_content',
        'menu_version',
        'last_published_at',
    ];

    protected $casts = [
        'last_published_at' => 'datetime',
    ];

}
