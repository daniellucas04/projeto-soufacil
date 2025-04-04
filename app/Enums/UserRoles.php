<?php

namespace App\Enums;

enum UserRoles: string {
    case USER   = 'user';
    case ADMIN  = 'admin';
    case MASTER  = 'master';

    public function getBadge(): string
    {
        return match ($this) {
            self::USER => 'bg-gray-100 text-gray-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-sm border',
            self::ADMIN => 'bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-sm border',
            self::MASTER => 'bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-sm border',
        };
    }
}