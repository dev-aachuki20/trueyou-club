<?php

namespace App\Models;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Exceptions\HttpResponseException;

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

    protected static function boot()
    {
        parent::boot();
        static::creating(function (Blog $model) {
            $model->created_by = auth()->user()->id;
        });

        static::deleting(function ($model) {
            if ($model->blogImage) {
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
        return $this->morphOne(Uploads::class, 'uploadsable')->where('type', 'blog');
    }

    public function getImageUrlAttribute()
    {
        if ($this->blogImage) {
            return $this->blogImage->file_url;
        }
        return "";
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /*
    // Api For api
     public function getRouteKey()
    {
        return Str::slug($this->title) . '-' . encrypt($this->getAttribute('id'));
    }
 
    public function resolveRouteBinding($value, $field = null)
    {
        try{
            $id = last(explode('-', $value));
            $model = parent::resolveRouteBinding(decrypt($id), $field);

            return $model;
    
        } catch (DecryptException $e) {
            abort(404); // Invalid encrypted ID
        }
    } */

    public function getEncryptSlugAttribute()
    {
        return Str::slug($this->title) . '-' . encrypt($this->getAttribute('id'));
    }
}
