<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\HostingStatus;

class Hosting extends Model
{
    protected $fillable = [
        'client_id',
        'domain_id',
        'provider',
        'plan_name',
        'ip_address',
        'username',
        'password',
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
        'status' => HostingStatus::class,
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function domain()
    {
        return $this->belongsTo(Domain::class);
    }
}
