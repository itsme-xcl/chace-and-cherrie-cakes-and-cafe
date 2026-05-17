<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /*
    |--------------------------------------------------------------------------
    | MASS ASSIGNMENT
    |--------------------------------------------------------------------------
    */
    protected $fillable = [
        'user_id',
        'product_id',

        // CUSTOMER
        'customer_name',
        'contact_number',
        'recipient_name',

        // CAKE (RELATIONS)
        'flavor_id',
        'size_id',
        'theme_id',

        // CUSTOMIZATION
        'addons',
        'frosting_type',
        'fondant_option',
        'tiers',

        'color_scheme',
        'design_description',
        'cake_image',

        // DELIVERY
        'delivery_date',
        'delivery_time',
        'delivery_method',
        'address',

        // PAYMENT
        'total_price',
        'down_payment',
        'payment_proof',
        'status',

        // STAFF
        'cashier_id'
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    public function user()
    {
        return $this->belongsTo(\App\Models\Customer::class, 'user_id');
    }
    // Flavor
    public function flavor()
    {
        return $this->belongsTo(CakeFlavor::class, 'flavor_id');
    }

    // Size
    public function size()
    {
        return $this->belongsTo(CakeSize::class, 'size_id');
    }

    // Theme
    public function themeRel()
    {
        return $this->belongsTo(CakeTheme::class, 'theme_id');
    }

    // Frosting
    public function frosting()
    {
       return $this->belongsTo(FrostingType::class, 'frosting_type');
    }

    // Fondant
    public function fondant()
    {
        return $this->belongsTo(FondantOption::class, 'fondant_option');
    }

    // Cashier (optional)
    public function cashier()
    {
        return $this->belongsTo(User::class, 'cashier_id');
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS (AUTO FORMAT FOR VIEW)
    |--------------------------------------------------------------------------
    */

    // Get Addon Names Automatically
    public function getAddonNamesAttribute()
    {
        if (!$this->addons) return [];

        $ids = explode(',', $this->addons);

        return CakeAddon::whereIn('id', $ids)
            ->pluck('name')
            ->toArray();
    }

    // Get Tier Label (1 Tier / 2 Tiers)
    public function getTiersLabelAttribute()
    {
        if (!$this->tiers) return null;

        return $this->tiers . ' Tier' . ($this->tiers > 1 ? 's' : '');
    }
}