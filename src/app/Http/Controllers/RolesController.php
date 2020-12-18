<?php

namespace App\Http\Controllers;

use App\Http\Resources\RoleResource;
use App\Repositories\Interfaces\RoleRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;

class RolesController extends Controller
{
    private RoleRepositoryInterface $roleRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(RoleRepositoryInterface $roleRepostory)
    {
        $this->middleware('auth');

        $this->roleRepository = $roleRepostory;
    }

    public function list(): JsonResource
    {
        return RoleResource::collection($this->roleRepository->paginate());
    }
}
