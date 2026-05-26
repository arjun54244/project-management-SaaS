<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'name',
        'description',
        'base_price',
        'status',
    ];

    protected $casts = [
        'base_price' => 'decimal:2',
    ];

    public function packages()
    {
        return $this->belongsToMany(Package::class)
            ->withPivot('quantity')
            ->withTimestamps();
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
