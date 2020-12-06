<?php

namespace App\Services\Auth;

interface AuthServiceInterface
{
    public function login(string $mail, string $password);
}