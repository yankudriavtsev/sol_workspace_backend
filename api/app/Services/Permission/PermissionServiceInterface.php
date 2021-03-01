<?php

namespace App\Services\Permission;

interface PermissionServiceInterface
{
    public function can(int $userId, string $permissionSlug): bool;
}
