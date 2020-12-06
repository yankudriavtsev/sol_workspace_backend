<?php

namespace App\Services\JWT;

interface JwtServiceInterface
{
    public function make(array $payloadData): array;
}