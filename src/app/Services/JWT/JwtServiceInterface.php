<?php

namespace App\Services\JWT;

interface JwtServiceInterface
{
    const TOKEN_TYPE_ACCESS  = 'access';
    const TOKEN_TYPE_REFRESH = 'refresh';

    public function make(array $payloadData): array;
}