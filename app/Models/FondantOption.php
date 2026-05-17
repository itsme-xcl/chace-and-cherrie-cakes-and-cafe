<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FondantOption extends Model
{
    protected $fillable = [
        'name',
        'additional_price',
        'status'
    ];
}