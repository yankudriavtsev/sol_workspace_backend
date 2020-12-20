<?php

use Illuminate\Database\Migrations\Migration;

class CreatePermissionsForRoleEntity extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::table('permissions')->insert(
            [
                [
                    'name' => 'View roles',
                    'slug' => 'roles.view',
                    'section' => 'roles',
                ],
                [
                    'name' => 'Manage roles',
                    'slug' => 'roles.manage',
                    'section' => 'roles',
                ]
            ]
        );

        $newPermissions = \DB::table('permissions')->where('section', 'roles')->get();
        $adminRole = \DB::table('roles')->where('slug', 'admin')->first();

        foreach ($newPermissions as $permission) {
            \DB::table('permission_role')->insert([
                'permission_id' => $permission->id,
                'role_id' => $adminRole->id
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::table('permissions')->where('section', 'roles')->delete();
    }
}
