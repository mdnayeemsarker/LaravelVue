<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Upload extends Model
{
    use HasFactory;
    protected $fillable = [
        'file_original_name',
        'file_name',
        'user_id',
        'file_size',
        'extension',
        'type',
        'external_link',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
