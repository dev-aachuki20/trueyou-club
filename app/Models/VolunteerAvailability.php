<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class VolunteerAvailability extends Model
{
    use SoftDeletes;

    public $table = 'volunteer_availabilities';
    
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'date',
    ];

    protected $fillable = [
        'event_id',
        'volunteer_id',
        'date',
        'start_time',
        'end_time',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function (Event $model) {
            $model->user_id = auth()->user()->id;
        });

    }

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
