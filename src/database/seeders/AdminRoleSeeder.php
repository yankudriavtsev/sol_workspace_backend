<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Repositories\Interfaces\RoleRepositoryInterface;

class AdminRoleSeeder extends Seeder
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
        $this->roleRepository->updateOrCreate(
            ['name' => 'Administrator', 'slug' => 'admin'],
            ['name' => 'Administrator', 'slug' => 'admin']
        );
    }
}
