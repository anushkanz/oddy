<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class InstructorQuaification extends Model
{
    protected $collection = 'instructor_qualifications'; // MongoDB collection name
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
