<?php

namespace App\Models;
use MongoDB\Laravel\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $collection = 'users'; // MongoDB collection name
    protected $primaryKey = '_id'; // MongoDB primary key

    // Fields that can be mass-assigned
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'status',
        'photo_gallery',
        'role',
    ];

    // Fields to be hidden (e.g., password)
    protected $hidden = [
        'password',
    ];

    // Timestamps
    public $timestamps = true;
}