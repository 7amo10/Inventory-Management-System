<?php

namespace App\Enums;

enum SupplierType: string
{
    case DISTRIBUTOR = 'distributor';
    case WHOLESALER = 'wholesaler';
    case PRODUCER = 'producer';
    case RETAIL = 'retail';

    public function label(): string
    {
        return match ($this) {
            self::DISTRIBUTOR => __('Distributor'),
            self::WHOLESALER => __('Wholesaler'),
            self::PRODUCER => __('Producer'),
            self::RETAIL => __('Retail'),
        };
    }
}

