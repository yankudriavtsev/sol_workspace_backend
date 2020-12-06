<?php

namespace App\Services\Auth;

use Illuminate\Contracts\Hashing\Hasher;
use App\Services\JWT\JwtServiceInterface;
use App\Services\Auth\Exceptions\InvalidUserException;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\Auth\Exceptions\InvalidCredentialsException;

class AuthService implements AuthServiceInterface
{
    private Hasher $hasher;
    private UserRepositoryInterface $userRepository;
    private JwtServiceInterface $jwtService;

    public function __construct(
        Hasher $hasher,
        UserRepositoryInterface $userRepository,
        JwtServiceInterface $jwtService
    ) {
        $this->hasher = $hasher;
        $this->userRepository = $userRepository;
        $this->jwtService = $jwtService;
    }

    public function login(string $email, string $passowrd)
    {
        /** @param \Models\User $user */
        $user = $this->userRepository->getOneByConditions(['email' => $email]);

        if (!$user) {
            throw new InvalidUserException('Invalid email');
        }

        if (!$this->hasher->check($passowrd, $user->password)) {
            throw new InvalidCredentialsException();
        }

        return $this->jwtService->make(['useer_id' => $user->id]);
    }
}
