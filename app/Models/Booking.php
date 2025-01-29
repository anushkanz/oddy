<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $collection = 'bookings'; // MongoDB collection name
    protected $primaryKey = '_id'; // MongoDB primary key

    // Fields that can be mass-assigned
    protected $fillable = [
        'user_id',
        'class_id',
        'payment_id',
        'status',
        'booking_date',
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

    // Define the relationship with the Payment model
    public function payment()
    {
        return $this->belongsTo(Payment::class, 'payment_id');
    }

    protected $casts = [
        'booking_date' => 'datetime:Y-m-d',
    ];
}
