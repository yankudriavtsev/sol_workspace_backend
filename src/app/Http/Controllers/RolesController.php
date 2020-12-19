<?php

namespace App\Http\Controllers;

use App\Http\Resources\RoleResource;
use App\Repositories\Interfaces\RoleRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;

class RolesController extends Controller
{
    private RoleRepositoryInterface $roleRepository;

    public function __construct(RoleRepositoryInterface $roleRepostory)
    {
        $this->roleRepository = $roleRepostory;
    }

    public function list(): JsonResource
    {
        return RoleResource::collection($this->roleRepository->paginate());
    }
}
