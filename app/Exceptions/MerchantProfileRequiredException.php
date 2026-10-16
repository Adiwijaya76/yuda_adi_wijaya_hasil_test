<?php

namespace App\Exceptions;

use RuntimeException;

class MerchantProfileRequiredException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct(
            'Akun merchant belum memiliki profil perusahaan. Lengkapi profil terlebih dahulu.'
        );
    }
}
