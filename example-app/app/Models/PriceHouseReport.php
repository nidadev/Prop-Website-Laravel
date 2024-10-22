<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceHouseReport extends Model
{
    use HasFactory;
    protected $fillable = [
        'state',
        'county_name',
        'sts',
        'de',
        //'data',
        'price',
        'mainval',
    ];
}