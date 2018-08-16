<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $primaryKey = '__pk';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        '_fk_department',
        'first_name',
        'last_name',
        'age'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $casts = [
        '_fk_department' => 'integer',
        'first_name' => 'string',
        'last_name' => 'string',
        'age' => 'integer'
    ];
}
