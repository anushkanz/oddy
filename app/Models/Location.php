<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Location extends Model
{
    protected $collection = 'locations'; // MongoDB collection name
    protected $primaryKey = '_id'; // MongoDB primary key

    // Fields that can be mass-assigned
    protected $fillable = [
        'user_id',
        'name',
        'address',
        'city',
        'country',
        'latitude',
        'longitude'
    ];

    // Define the relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    // Timestamps
    public $timestamps = true;
}
