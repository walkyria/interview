<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $primaryKey = '__pk';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        '_fk_location',
        'property_name',
        'near_beach',
        'accepts_pets',
        'sleeps',
        'beds'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $casts = [
        '_fk_location' => 'integer',
        'property_name' => 'string',
        'near_beach' => 'boolean',
        'accepts_pets' => 'boolean',
        'sleeps' => 'integer',
        'beds' => 'integer'
    ];
}
