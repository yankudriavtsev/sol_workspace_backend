<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\RoleResource;
use App\Services\Role\RoleServiceInterface;
use App\Repositories\Interfaces\RoleRepositoryInterface;
use App\Services\Role\Exceptions\UneditableRoleException;

class RolesController extends Controller
{
    private RoleRepositoryInterface $roleRepository;
    protected RoleServiceInterface $roleService;

    public function __construct(RoleRepositoryInterface $roleRepostory, RoleServiceInterface $roleService)
    {
        $this->roleRepository = $roleRepostory;
        $this->roleService = $roleService;
    }

    public function list()
    {
        return RoleResource::collection($this->roleRepository->paginate());
    }

    public function show(int $roleId)
    {
        $role = $this->roleRepository->getById($roleId);

        if (!$role) {
            return response()->json(['message' => 'Not found'], 404);
        }

        return new RoleResource($this->roleRepository->getById($roleId));
    }

    public function create(Request $request)
    {
        $data = $this->validate(
            $request,
            [
                'name' => 'required|string',
                'slug' => 'required|string|unique:roles',
                'is_visible' => 'required|boolean'
            ]
        );

        return new RoleResource($this->roleRepository->create($data));
    }

    public function update(int $roleId, Request $request)
    {
        $role = $this->roleRepository->getById($roleId);

        if (!$role) {
            return response()->json(['message' => 'Not found'], 404);
        }

        $data = $this->validate(
            $request,
            [
                'name' => 'required|string',
                'slug' => 'required|string|unique:roles,slug,' . $role->id,
                'is_visible' => 'required|boolean'
            ]
        );

        try {
            return new RoleResource($this->roleService->updateRole($role, $data));
        } catch (UneditableRoleException $e) {
            return response()->json(['message' => 'You cannot edit this role'], 422);
        }
    }

    public function delete(int $roleId)
    {
        $role = $this->roleRepository->getById($roleId);

        if (!$role) {
            return response()->json(['message' => 'Not found'], 404);
        }

        try {
            $this->roleService->deleteRole($role);

            return response()->json(['message' => 'ok']);
        } catch (UneditableRoleException $e) {
            return response()->json(['message' => 'You cannot delete this role'], 422);
        }
    }
}
