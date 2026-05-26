<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\SubscriptionStatus;
use App\Models\Client;
use App\Models\Package;
use App\Models\Invoice;

class Subscription extends Model
{
    protected $fillable = [
        'client_id',
        'package_id',
        'parent_subscription_id',
        'start_date',
        'end_date',
        'price_before_discount',
        'discount_type',
        'discount_value',
        'final_price',
        'status',
        'cancelled_at',
        'cancellation_reason',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'cancelled_at' => 'datetime',
        'price_before_discount' => 'decimal:2',
        'discount_value' => 'decimal:2',
        'final_price' => 'decimal:2',
        'status' => SubscriptionStatus::class,
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', SubscriptionStatus::Active);
    }

    public function parent()
    {
        return $this->belongsTo(Subscription::class, 'parent_subscription_id');
    }

    public function renewals()
    {
        return $this->hasMany(Subscription::class, 'parent_subscription_id');
    }

    public function hasInvoices(): bool
    {
        return $this->invoices()->exists();
    }

    public function subscriptionServices()
    {
        return $this->hasMany(SubscriptionService::class);
    }
}
