<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Client;
use App\Models\Hosting;
use App\Enums\DomainStatus;

class Domain extends Model
{
    protected $fillable = [
        'client_id',
        'name',
        'registrar',
        'purchase_date',
        'expiry_date',
        'renewal_price',
        'status',
        'notes',
    ];

    protected $casts = [
        'purchase_date' => 'date',
        'expiry_date' => 'date',
        'renewal_price' => 'decimal:2',
        'status' => DomainStatus::class,
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function hosting()
    {
        return $this->hasOne(Hosting::class);
    }
}
