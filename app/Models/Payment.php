<?php

namespace App\Models;

use App\Enums\PaymentMethod;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'invoice_id',
        'amount',
        'payment_method',
        'transaction_reference',
        'paid_at',
        'notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'payment_method' => PaymentMethod::class,
        'paid_at' => 'datetime',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    /**
     * Prevent updates to payments (immutable)
     */
    public static function boot()
    {
        parent::boot();

        static::updating(function ($payment) {
            throw new \Exception('Payments are immutable and cannot be updated. Create a new payment or refund instead.');
        });
    }
}
