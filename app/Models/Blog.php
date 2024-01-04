<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model
{
    use SoftDeletes;

    public $table = 'blogs';

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

    protected static function boot () 
    {
        parent::boot();
        static::creating(function(Blog $model) {
            $model->created_by = auth()->user()->id;
        });   

        static::deleting(function ($model) {
            if($model->blogImage){
                $uploadImageId = $model->blogImage->id;
                deleteFile($uploadImageId);
            }
        });         
    }

    public function uploads()
    {
        return $this->morphMany(Uploads::class, 'uploadsable');
    }

    public function blogImage()
    {
        return $this->morphOne(Uploads::class, 'uploadsable')->where('type','blog');
    }

    public function getImageUrlAttribute()
    {
        if($this->blogImage){
            return $this->blogImage->file_url;
        }
        return "";
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

}
