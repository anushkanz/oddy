<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class InstructorQulification extends Model
{
    protected $collection = 'instructors_qulification'; // MongoDB collection name
    protected $primaryKey = '_id'; // MongoDB primary key

    // Fields that can be mass-assigned
    protected $fillable = [
        'instructor_id',
        'title',
        'description',
        'photo_gallery',
    ];

    // Define the relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }
}
