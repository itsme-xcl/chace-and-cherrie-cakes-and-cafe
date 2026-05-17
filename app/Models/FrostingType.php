<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FrostingType extends Model
{
    protected $fillable = [
        'name',
        'additional_price',
        'status'
    ];
}