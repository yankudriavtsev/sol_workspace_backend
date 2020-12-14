<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Repositories\Interfaces\RoleRepositoryInterface;

class RolesSeeder extends Seeder
{
    private RoleRepositoryInterface $roleRepository;

    public function __construct(RoleRepositoryInterface $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            ['name' => 'Administrator', 'slug' => 'admin'],
            ['name' => 'Project Manager', 'slug' => 'project_manager'],
            ['name' => 'Developer', 'slug' => 'developer'],
            ['name' => 'Support', 'slug' => 'support'],
        ];

        foreach ($roles as $role) {
            $this->roleRepository->updateOrCreate($role, $role);
        }
    }
}
