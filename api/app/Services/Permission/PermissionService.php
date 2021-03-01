<?php

namespace App\Services\Permission;

use App\Repositories\Interfaces\PermissionRepositoryInterface;
use Illuminate\Contracts\Cache\Repository;

class PermissionService implements PermissionServiceInterface
{
    private Repository $cache;
    private PermissionRepositoryInterface $permissionRepository;

    public function __construct(Repository $cache, PermissionRepositoryInterface $permissionRepository)
    {
        $this->cache = $cache;
        $this->permissionRepository = $permissionRepository;
    }

    public function can(int $roleId, string $permissionSlug): bool
    {
        $rolePermissions = $this->cache->get("permissions.{$roleId}");

        if ($rolePermissions === null) {
            $this->cacheRolePermissions($roleId);

            return $this->can($roleId, $permissionSlug);
        }

        return in_array($permissionSlug, json_decode($rolePermissions));
    }

    protected function cacheRolePermissions(int $roleId): void
    {
        $rolePermissions = $this->permissionRepository->getRolePermissions($roleId)->pluck('slug')->toArray();

        $this->cache->put("permissions.{$roleId}", json_encode($rolePermissions));
    }
}
