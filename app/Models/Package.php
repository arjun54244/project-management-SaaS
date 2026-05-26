<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Subscription;

class Package extends Model
{
    protected $fillable = [
        'name',
        'duration_months',
        'base_price',
        'description',
        'status',
    ];

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function services()
    {
        return $this->belongsToMany(Service::class)
            ->withPivot('quantity')
            ->withTimestamps();
    }
}
