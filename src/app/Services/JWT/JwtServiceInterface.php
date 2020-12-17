<?php

namespace App\Services\JWT;

interface JwtServiceInterface
{
    const TOKEN_TYPE_ACCESS  = 'access';
    const TOKEN_TYPE_REFRESH = 'refresh';

    public function make(array $payloadData): array;

    /**
     * Decode JWT token
     *
     * @param string $token JWT token
     * 
     * @return object JWT payload
     * 
     * @throws UnexpectedValueException     Provided JWT was invalid
     * @throws SignatureInvalidException    Provided JWT was invalid because the signature verification failed
     * @throws BeforeValidException         Provided JWT is trying to be used before it's eligible as defined by 'nbf'
     * @throws BeforeValidException         Provided JWT is trying to be used before it's been created as defined by 'iat'
     * @throws ExpiredException             Provided JWT has since expired, as defined by the 'exp' claim
     */
    public function decode(string $token): object;
}