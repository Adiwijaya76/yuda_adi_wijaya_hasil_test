<?php

namespace App\Exceptions;

use RuntimeException;

class MenuUnavailableException extends RuntimeException
{
    public function __construct(public readonly string $menuName)
    {
        parent::__construct(
            "Menu \"{$menuName}\" tidak tersedia untuk dipesan."
        );
    }
}
