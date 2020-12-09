<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Repositories\Interfaces\RoleRepositoryInterface;

class RolesSeeder extends Seeder
{
    private RoleRepositoryInterface $roleRpository;

    public function __construct(RoleRepositoryInterface $roleRpository)
    {
        $this->roleRpository = $roleRpository;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            ['name' => 'Admin', 'slug' => 'admin'],
            ['name' => 'Project Manager', 'slug' => 'project_manager'],
            ['name' => 'Developer', 'slug' => 'developer'],
            ['name' => 'Support', 'slug' => 'support'],
        ];

        foreach ($roles as $role) {
            $this->roleRpository->updateOrCreate($role, $role);
        }
    }
}
