<?php

namespace App\Services\Auth;

use App\Models\User;
use Illuminate\Contracts\Hashing\Hasher;
use App\Repositories\Interfaces\RoleRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\Auth\Exceptions\InvalidCredentialsException;

class AuthService implements AuthServiceInterface
{
    private Hasher $hasher;
    private UserRepositoryInterface $userRepository;
    private RoleRepositoryInterface $roleRepository;

    public function __construct(
        Hasher $hasher,
        UserRepositoryInterface $userRepository,
        RoleRepositoryInterface $roleRepository
    ) {
        $this->hasher = $hasher;
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
    }

    public function login(array $credentials): array
    {
        $token = auth()->attempt($credentials);

        if (!$token) {
            throw new InvalidCredentialsException();
        }

        return [
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ];
    }

    // TODO move to another service
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
