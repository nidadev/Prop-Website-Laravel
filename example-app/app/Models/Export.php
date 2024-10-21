<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Export extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'file_name',
        'status',
        'created_at',
        'updated_at',
        'downloaded'
    ];
}
