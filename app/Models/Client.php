<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'company_name',
        'gst_number',
        'gst_enabled',
        'address',
        'dob',
        'status',
    ];

    protected $casts = [
        'dob' => 'date',
        'gst_enabled' => 'boolean',
    ];

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function domains()
    {
        return $this->hasMany(Domain::class);
    }

    public function hostings()
    {
        return $this->hasMany(Hosting::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}
