<?php

namespace App\Services\JWT;

use Firebase\JWT\JWT;
use Illuminate\Support\Carbon;
use Illuminate\Contracts\Config\Repository as ConfigRepository;
use App\Services\JWT\Exceptions\InvalidJwtConfigurationException;

class JwtService implements JwtServiceInterface
{
    private string $secret;
    private int $ttl;
    private int $refreshTtl;

    public function __construct(ConfigRepository $configRepository)
    {
        if (empty($configRepository->get('jwt.secret')) or
            !is_string($configRepository->get('jwt.secret'))
        ) {
            throw new InvalidJwtConfigurationException("Invalid JWT config parameter 'secret'");
        }

        if (!is_int($configRepository->get('jwt.ttl')) or
            $configRepository->get('jwt.ttl') < 1
        ) {
            throw new InvalidJwtConfigurationException("Invalid JWT config parameter 'ttl'");
        }

        if (!is_int($configRepository->get('jwt.refresh_ttl')) or
            $configRepository->get('jwt.refresh_ttl') < 1
        ) {
            throw new InvalidJwtConfigurationException('Invalid JWT config parameter "refresh_ttl"');
        }

        $this->secret = $configRepository->get('jwt.secret');
        $this->ttl = $configRepository->get('jwt.ttl');
        $this->refreshTtl = $configRepository->get('jwt.refresh_ttl');
    }

    public function make(array $payloadData): array
    {
        $tokenExp = Carbon::now('UTC')->addMinutes($this->ttl)->getTimestamp();
        $refreshTokenExp = Carbon::now('UTC')->addMinutes($this->refreshTtl)->getTimestamp();
        $payload = array_merge($payloadData, [
            'exp' => $tokenExp
        ]);
        $refreshPayload = array_merge($payloadData, [
            'exp' => $refreshTokenExp
        ]);

        return [
            'token' => new JwtToken(
                JWT::encode($payload, $this->secret),
                $tokenExp
            ),
            'refresh_token' => new JwtToken(
                JWT::encode($refreshPayload, $this->secret),
                $refreshTokenExp
            )
        ];
    }
}