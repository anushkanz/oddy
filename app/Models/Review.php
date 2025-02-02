<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Review extends Model
{
    protected $collection = 'reviews'; // MongoDB collection name
    protected $primaryKey = '_id'; // MongoDB primary key

    // Fields that can be mass-assigned
    protected $fillable = [
        'receiver_id',
        'reviewer_id',
        'class_id',
        'rating',
        'comment',
    ];

    // Timestamps
    public $timestamps = true;

    // Define the relationship with the User model
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }

    // Define the relationship with the Classes model
    public function classes()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }
}
