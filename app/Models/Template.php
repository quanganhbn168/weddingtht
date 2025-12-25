<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    protected $fillable = [
        'name',
        'view_path',
        'type',
        'thumbnail_url',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
