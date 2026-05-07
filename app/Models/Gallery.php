<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gallery extends Model
{
    use SoftDeletes;
    
    protected static function boot()
    {
        parent::boot();
        
        static::deleting(function ($gallery) {
            // Soft delete all related images when the gallery is soft deleted
            $gallery->images()->delete();
        });
    }

    protected $fillable = ['category_id', 'title', 'slug', 'badge', 'description', 'artisan_note', 'new_arrival'];

    public function images()
    {
        return $this->hasMany(GalleryImage::class)->orderBy('sort_order', 'asc');
    }

    public function primaryImage()
    {
        return $this->hasOne(GalleryImage::class)->ofMany('sort_order', 'min');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
