<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReferralSharer extends Model
{
    protected $fillable = [
        'browser_id',
        'ip_address',
        'referral_code',
        'reward_code',
        'is_used',
        'admin_note',
        'used_at',
        'target_count',
        'is_completed',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'used_at' => 'datetime',
        'is_used' => 'boolean',
        'is_completed' => 'boolean',
    ];

    public function visits()
    {
        return $this->hasMany(ReferralVisit::class, 'sharer_id');
    }
}
