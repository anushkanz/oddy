<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Instructors extends Model
{
    protected $collection = 'instructors'; // MongoDB collection name
    protected $primaryKey = '_id'; // MongoDB primary key

    // Fields that can be mass-assigned
    protected $fillable = [
        'user_id',
        'name',
        'bio',
        'skills',
        'profile_picture',
    ];

    // Define the relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
