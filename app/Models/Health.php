<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Health extends Model
{
    use HasFactory, SoftDeletes;
    public $table = 'healths';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'title',
        'slug',
        'content',
        'publish_date',
        'status',
        'created_by',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function (Health $model) {
            $model->created_by = auth()->user()->id;
        });

        static::deleting(function ($model) {
            if ($model->healthImage) {
                $uploadImageId = $model->healthImage->id;
                deleteFile($uploadImageId);
            }
        });
    }

    public function uploads()
    {
        return $this->morphMany(Uploads::class, 'uploadsable');
    }

    public function healthImage()
    {
        return $this->morphOne(Uploads::class, 'uploadsable')->where('type', 'health');
    }

    public function getImageUrlAttribute()
    {
        if ($this->healthImage) {
            return $this->healthImage->file_url;
        }
        return "";
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
