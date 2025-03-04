<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Classes extends Model
{
    protected $collection = 'classes'; // MongoDB collection name
    protected $primaryKey = '_id'; // MongoDB primary key

    // Fields that can be mass-assigned
    protected $fillable = [
        'instructor_id',
        'title',
        'description',
        'category_id',
        'location_id',
        'duration',
        'duration_type',
        'price',
        'level',
        'photo_gallery'
    ];

    // Timestamps
    public $timestamps = true;

    // Define the relationship with the User model
    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    // Define the relationship with the Category model
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    // Define the relationship with the Location model
    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }

    protected $casts = [

    ];
}
