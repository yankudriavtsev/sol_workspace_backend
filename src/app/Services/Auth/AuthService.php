<?php

namespace App\Services\Auth;

use App\Models\User;
use App\Repositories\Interfaces\RoleRepositoryInterface;
use Illuminate\Contracts\Hashing\Hasher;
use App\Services\JWT\JwtServiceInterface;
use App\Services\Auth\Exceptions\InvalidUserException;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\Auth\Exceptions\InvalidCredentialsException;

class AuthService implements AuthServiceInterface
{
    private Hasher $hasher;
    private UserRepositoryInterface $userRepository;
    private RoleRepositoryInterface $roleRepository;
    private JwtServiceInterface $jwtService;

    public function __construct(
        Hasher $hasher,
        UserRepositoryInterface $userRepository,
        JwtServiceInterface $jwtService,
        RoleRepositoryInterface $roleRepository
    ) {
        $this->hasher = $hasher;
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
        $this->jwtService = $jwtService;
    }

    public function login(string $email, string $passowrd): array
    {
        /** @param \Models\User $user */
        $user = $this->userRepository->getOneByConditions(['email' => $email]);

        if (!$user) {
            throw new InvalidUserException('Invalid email');
        }

        if (!$this->hasher->check($passowrd, $user->password)) {
            throw new InvalidCredentialsException();
        }

        return $this->jwtService->make(['user_id' => $user->id]);
    }

    public function registerAdminUser(string $name, string $email, string $password): User
    {
        $role = $this->roleRepository->getOneByConditions(['slug' => $this->roleRepository::ADMIN_SLUG]);
        
        return $this->userRepository->create([
            'name' => $name,
            'email' => $email,
            'password' => $this->hasher->make($password),
            'role_id' => $role->id
        ]);
    }
}
