<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Invoice;

class InvoiceItem extends Model
{
    protected $fillable = [
        'invoice_id',
        'item_type',
        'item_id',
        'description',
        'qty',
        'price',
        'total',
    ];

    public function package()
    {
        return $this->belongsTo(Package::class, 'item_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'item_id');
    }

    protected $casts = [
        'qty' => 'integer',
        'price' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
