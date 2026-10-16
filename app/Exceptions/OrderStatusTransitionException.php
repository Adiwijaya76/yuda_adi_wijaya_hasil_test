<?php

namespace App\Exceptions;

use RuntimeException;

class OrderStatusTransitionException extends RuntimeException
{
    public function __construct(
        public readonly string $from,
        public readonly string $to,
    ) {
        parent::__construct(
            "Perubahan status pesanan dari \"{$from}\" ke \"{$to}\" tidak diizinkan."
        );
    }
}
