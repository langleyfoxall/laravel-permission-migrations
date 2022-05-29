<?php

namespace LangleyFoxall\LaravelPermissionMigrations\Database\Migrations;

use Illuminate\Support\Facades\DB;

class AssignPermissionsMigration extends SpatiePermissionsMigration
{
    protected $rolePermissions = [];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach ($this->rolePermissions as $roleName => $permissions) {
            foreach ($permissions as $permissionName) {
                DB::table('role_has_permissions')->insert([
                    'permission_id' => $this->getPermissionIdFromName($permissionName),
                    'role_id' => $this->getRoleIdFromName($roleName),
                ]);
            }
        }

        $this->resetCache();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        foreach ($this->rolePermissions as $roleName => $permissions) {
            foreach ($permissions as $permissionName) {
                DB::table('role_has_permissions')->where([
                    'permission_id' => $this->getPermissionIdFromName($permissionName),
                    'role_id' => $this->getRoleIdFromName($roleName),
                ])->delete();
            }
        }

        $this->resetCache();
    }

    /**
     * Returns the ID of the role with the given name.
     *
     * @param $name
     * @return int
     */
    private function getRoleIdFromName($name): int
    {
        $role = DB::table('roles')->where('name', $name)->first();

        return $role->id;
    }

    /**
     * Returns the ID of the permission with the given name.
     *
     * @param $name
     * @return int
     */
    private function getPermissionIdFromName($name): int
    {
        $permission = DB::table('permissions')->where(['name' => $name])->first();

        return $permission->id;
    }
}