<?php

namespace App\Enums;

enum ReceiptStatus: string {
    case PAID       = 'Paid';
    case PENDING    = 'Pending';

    public function getBadge(): string
    {
        return match ($this) {
            self::PENDING => 'bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-sm border',
            self::PAID => 'bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-sm border',
        };
    }
}