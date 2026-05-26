<?php

namespace App\Enums;

enum DomainStatus: string
{
    case Active = 'active';
    case Expired = 'expired';
    case Pending = 'pending';
    case Transferred = 'transferred';

    public function label(): string
    {
        return match ($this) {
            self::Active => 'Active',
            self::Expired => 'Expired',
            self::Pending => 'Pending',
            self::Transferred => 'Transferred',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Active => 'emerald',
            self::Expired => 'red',
            self::Pending => 'amber',
            self::Transferred => 'zinc',
        };
    }
}
