<?php

namespace App\Services\JWT;

use Illuminate\Support\Carbon;

class JwtToken
{
    public string $token;
    public string $exp;

    public function __construct(string $token, int $exp)
    {
        $this->token = $token;
        $this->exp = Carbon::parse($exp, 'UTC')->format(Carbon::ISO8601);
    }
}