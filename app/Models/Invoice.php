<?php

namespace App\Models;

use App\Enums\PaymentStatus;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'client_id',
        'subscription_id',
        'invoice_number',
        'invoice_date',
        'due_date',
        'subtotal',
        'discount',
        'tax',
        'total_amount',
        'payment_status',
        'payment_method',
    ];

    protected $casts = [
        'invoice_date' => 'date',
        'due_date' => 'date',
        'subtotal' => 'decimal:2',
        'discount' => 'decimal:2',
        'tax' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'payment_status' => PaymentStatus::class,
        'payment_method' => \App\Enums\PaymentMethod::class,
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }

    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function getPaidAmountAttribute()
    {
        return $this->payments()->sum('amount');
    }

    public function getBalanceAttribute()
    {
        return max(0, $this->total_amount - $this->paid_amount);
    }

    public function recalculateStatus()
    {
        $totalPaid = $this->payments()->sum('amount');
        $totalAmount = (float) $this->total_amount;

        if ($totalPaid >= $totalAmount) {
            $this->payment_status = PaymentStatus::Paid;
        } elseif ($totalPaid > 0) {
            $this->payment_status = PaymentStatus::Partial;
        } else {
            $this->payment_status = PaymentStatus::Unpaid;
        }

        // Update the payment method to the latest one used
        $latestPayment = $this->payments()->latest('paid_at')->first();
        if ($latestPayment) {
            $this->payment_method = $latestPayment->payment_method;
        }

        $this->save();

        return $this->payment_status;
    }

    public function isFullyPaid(): bool
    {
        return $this->paid_amount >= $this->total_amount;
    }

    public function isPartiallyPaid(): bool
    {
        return $this->paid_amount > 0 && $this->paid_amount < $this->total_amount;
    }
}
