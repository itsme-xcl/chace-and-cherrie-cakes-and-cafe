<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CakeSize extends Model
{
    protected $fillable = [
        'name',
        'additional_price',
        'status',
    ];
}

