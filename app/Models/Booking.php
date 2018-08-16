<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $primaryKey = '__pk';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
            '_fk_property',
            'start_date',
            'end_date',
        ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $casts = [
            '_fk_property' => 'integer',
            'start_date' => 'datetime',
            'end_date' => 'datetime',
        ];
}
