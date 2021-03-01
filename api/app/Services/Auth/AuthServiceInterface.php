<?php

namespace App\Services\Auth;

use App\Models\User;

interface AuthServiceInterface
{
    public function login(array $credentials): array;

    public function registerAdminUser(string $name, string $email, string $password): User;
}
