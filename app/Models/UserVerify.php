<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class UserVerify extends Model
{
    
    public $table = "users_verify";
    use HasFactory, Notifiable;

    /**
     * Write code on Method
     *
     * @return response()
     */

    protected $fillable = [
        'user_id',
        'token',
    ];


    /**
     * Write code on Method
     *
     * @return response()
     */

    public function user() {
            return $this->belongsTo(User::class, 'user_id');
        }
}
