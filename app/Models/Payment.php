<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Payment extends Model
{
    protected $collection = 'payments'; // MongoDB collection name
    protected $primaryKey = '_id'; // MongoDB primary key

    // Fields that can be mass-assigned
    protected $fillable = [
        'booking_id',
        'amount',
        'payment_method',
        'status',
        'transaction_id',
        'transaction_return'
    ];

    // Timestamps
    public $timestamps = true;

    // Define the relationship with the Booking model
    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }

}
