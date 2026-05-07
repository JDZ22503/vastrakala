<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VisitorLog extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'ip_address',
        'user_agent',
        'device',
        'os',
        'browser',
        'url',
        'method',
        'visited_at',
    ];
}
