<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\RoleRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function getModel(): string
    {
        return User::class;
    }

    public function adminExists(): bool
    {
        return ($this->getModel())::whereHas('role', function(Builder $query) {
            $query->where('slug', RoleRepositoryInterface::ADMIN_SLUG);
        })->exists();
    }
}
