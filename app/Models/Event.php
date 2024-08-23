<?php

namespace App\Models;

use App\Traits\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Event extends Model
{
    use HasFactory,SoftDeletes,Sluggable;

    public $table = 'events';
    
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'title',
        'slug',
        'description',
        'status',
        'created_by',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function (Event $model) {
            $model->slug = Str::slug($model->title) . '-' . bin2hex(random_bytes(10));
            $model->created_by = auth()->user()->id;
        });

        static::updating(function (Event $model) {
            $model->slug = Str::slug($model->title) . '-' . bin2hex(random_bytes(10));
        });

        static::deleting(function ($model) {
            if ($model->featuredImage) {
                $uploadImageId = $model->featuredImage->id;
                deleteFile($uploadImageId);
            }
        });
    }

    public function uploads()
    {
        return $this->morphMany(Uploads::class, 'uploadsable');
    }

    public function featuredImage()
    {
        return $this->morphOne(Uploads::class, 'uploadsable')->where('type', 'event');
    }

    public function getFeaturedImageUrlAttribute()
    {
        if ($this->featuredImage) {
            return $this->featuredImage->file_url;
        }
        return "";
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
