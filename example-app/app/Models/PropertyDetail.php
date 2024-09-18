<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'property_id',
        'state',
        'county',
        'zipcode',
        'apn'
    ];
}
