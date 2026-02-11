<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubscriptionService extends Model
{
    protected $fillable = [
        'subscription_id',
        'service_name',
        'service_price',
        'quantity',
    ];

    protected $casts = [
        'service_price' => 'decimal:2',
    ];

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }

    public function getLineTotalAttribute()
    {
        return $this->service_price * $this->quantity;
    }
}
