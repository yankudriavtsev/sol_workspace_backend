<?php

namespace App\Services\Role;

use App\Models\Role;
use App\Services\Role\RoleServiceInterface;
use App\Repositories\Interfaces\RoleRepositoryInterface;
use App\Services\Role\Exceptions\UneditableRoleException;

class RoleService implements RoleServiceInterface
{
    private RoleRepositoryInterface $roleRepository;

    public function __construct(RoleRepositoryInterface $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function updateRole(Role $role, array $data): Role
    {
        if (!$role->is_editable) {
            throw new UneditableRoleException();
        }

        $this->roleRepository->update($role->id, $data);

        return $this->roleRepository->getById($role->id);
    }

    public function deleteRole(Role $role): void
    {
        if (!$role->is_editable) {
            throw new UneditableRoleException();
        }

        $this->roleRepository->deleteByConditions(['id' => $role->id]);
    }
}
