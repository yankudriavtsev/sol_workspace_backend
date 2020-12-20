<?php

namespace App\Services\Role;

use App\Models\Role;

interface RoleServiceInterface
{
    public function updateRole(Role $role, array $data): Role;

    public function deleteRole(Role $role): void;
}
