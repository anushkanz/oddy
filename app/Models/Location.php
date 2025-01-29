<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Location extends Model
{
    protected $collection = 'locations'; // MongoDB collection name
    protected $primaryKey = '_id'; // MongoDB primary key

    // Fields that can be mass-assigned
    protected $fillable = [
        'name',
        'address',
        'city',
        'country',
        'latitude',
        'longitude'
    ];

    // Timestamps
    public $timestamps = true;
}
