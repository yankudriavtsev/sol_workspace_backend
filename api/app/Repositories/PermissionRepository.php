<?php

namespace App\Repositories;

use App\Models\Permission;
use App\Repositories\Interfaces\PermissionRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class PermissionRepository extends BaseRepository implements PermissionRepositoryInterface
{
    public function getModel(): string
    {
        return Permission::class;
    }

    public function getRolePermissions(int $roleId): Collection
    {
        return ($this->getModel())::whereHas('roles', function ($query) use ($roleId) {
            return $query->where('role_id', $roleId);
        })->get();
    }
}
