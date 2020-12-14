<?php

namespace App\Services\Auth;

use App\Models\User;

interface AuthServiceInterface
{
    public function login(string $mail, string $password);

    public function registerAdminUser(string $name, string $email, string $password): User;
}