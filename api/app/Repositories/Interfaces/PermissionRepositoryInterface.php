<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface PermissionRepositoryInterface extends BaseInterface
{
    public function getRolePermissions(int $roleId): Collection;
}
