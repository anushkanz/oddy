<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $collection = 'reviews'; // MongoDB collection name
    protected $primaryKey = '_id'; // MongoDB primary key

    // Fields that can be mass-assigned
    protected $fillable = [
        'user_id',
        'class_id',
        'rating',
        'comment',
    ];

    // Timestamps
    public $timestamps = true;

    // Define the relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Define the relationship with the Classes model
    public function classes()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }
}
