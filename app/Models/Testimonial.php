<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Testimonial extends Model
{
    use SoftDeletes;
    protected $fillable = ['customer_name', 'customer_designation', 'content', 'rating', 'avatar_path', 'is_approved'];

    protected $casts = [
        'is_approved' => 'boolean',
    ];
}
