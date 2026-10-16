<?php

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

class OwnershipViolationException extends HttpException
{
    public function __construct(string $message = 'Anda tidak memiliki akses ke data ini.')
    {
        parent::__construct(403, $message);
    }
}
