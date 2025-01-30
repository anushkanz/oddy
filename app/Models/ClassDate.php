<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class ClassDate extends Model
{
    protected $collection = 'class_dates'; // MongoDB collection name
    protected $primaryKey = '_id'; // MongoDB primary key

    // Fields that can be mass-assigned
    protected $fillable = [
        'class_id',
        'class_date',
        'start_at',
        'end_at'
    ];

    // Timestamps
    public $timestamps = true;

    // Define the relationship with the User model
    public function classes()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }

    protected $casts = [
        'start_at' => 'datetime: H:i',
        'end_at' => 'datetime: H:i',
    ]; 
}
