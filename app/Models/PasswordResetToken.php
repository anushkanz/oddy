<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class PasswordResetToken extends Model
{
    protected $collection = 'password_reset_tokens'; // MongoDB collection name
    protected $primaryKey = '_id'; // MongoDB primary key

    // Fields that can be mass-assigned
    protected $fillable = [
        'email',
        'token'
    ];

    public $timestamps = true;
}
