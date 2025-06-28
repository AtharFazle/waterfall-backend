<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = [
        'file_path',
        'file_name',
        'order',
        'title',
        'description',
        'is_active',
    ];
}
