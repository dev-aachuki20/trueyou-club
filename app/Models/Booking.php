<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{

    public $table = 'bookings';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'user_details' => 'json',
        'bookingable_details'=>'json',
    ];

    protected $fillable = [
        'user_id',
        'user_details',
        'bookingable',
        'bookingable_details',
        'booking_number',
        'type',
        'created_at',
        'updated_at',
    ];

    public function bookingable()
    {
        return $this->morphTo();
    }
}
