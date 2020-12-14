<?php

namespace App\Repositories\Interfaces;

interface UserRepositoryInterface extends BaseInterface
{
    public function adminExists(): bool;
}