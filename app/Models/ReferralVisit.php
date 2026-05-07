<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReferralVisit extends Model
{
    protected $fillable = [
        'sharer_id',
        'guest_ip',
        'user_agent',
    ];

    public function sharer()
    {
        return $this->belongsTo(ReferralSharer::class, 'sharer_id');
    }
}
