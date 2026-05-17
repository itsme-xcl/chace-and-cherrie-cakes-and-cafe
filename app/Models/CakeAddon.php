<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CakeAddon extends Model
{
    protected $fillable = [
    'name',
    'additional_price',
    'status',
];

}
