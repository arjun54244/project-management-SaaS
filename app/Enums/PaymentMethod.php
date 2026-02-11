<?php

namespace App\Enums;

enum PaymentMethod: string
{
    case Cash = 'cash';
    case UPI = 'upi';
    case Cheque = 'cheque';
    case BankTransfer = 'bank_transfer';
    case Other = 'other';

    public function label(): string
    {
        return match ($this) {
            self::Cash => 'Cash',
            self::UPI => 'UPI',
            self::Cheque => 'Cheque',
            self::BankTransfer => 'Bank Transfer',
            self::Other => 'Other',
        };
    }

    public function requiresReference(): bool
    {
        return match ($this) {
            self::Cash => false,
            self::UPI => true,
            self::Cheque => true,
            self::BankTransfer => true,
            self::Other => false,
        };
    }
}
