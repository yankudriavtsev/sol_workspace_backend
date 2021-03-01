<?php

namespace App\Services\Role\Exceptions;

use InvalidArgumentException;

class UneditableRoleException extends InvalidArgumentException
{
    public function __construct()
    {
        parent::__construct('You cannot edit this role');
    }
}
