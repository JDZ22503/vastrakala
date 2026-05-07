<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GalleryImage extends Model
{
    use SoftDeletes;

    protected $fillable = ['gallery_id', 'image_path', 'sort_order'];

    public function gallery()
    {
        return $this->belongsTo(Gallery::class);
    }
}
