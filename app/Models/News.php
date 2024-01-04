<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class News extends Model
{
    use SoftDeletes;

    public $table = 'news';

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
        static::creating(function(News $model) {
            $model->created_by = auth()->user()->id;
        });   

        static::deleting(function ($model) {
            if($model->newsImage){
                $uploadImageId = $model->newsImage->id;
                deleteFile($uploadImageId);
            }
        });         
    }

    public function uploads()
    {
        return $this->morphMany(Uploads::class, 'uploadsable');
    }

    public function newsImage()
    {
        return $this->morphOne(Uploads::class, 'uploadsable')->where('type','news');
    }

    public function getImageUrlAttribute()
    {
        if($this->newsImage){
            return $this->newsImage->file_url;
        }
        return "";
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

}
