<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Heroe extends Model
{
    use HasFactory, SoftDeletes;

    public $table = 'heroes';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
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
        static::creating(function (Heroe $model) {
            $model->created_by = auth()->user()->id;
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
        return $this->morphOne(Uploads::class, 'uploadsable')->where('type', 'heroe');
    }

    public function getImageUrlAttribute()
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
