<?php

namespace LangleyFoxall\LaravelPermissionMigrations\Database\Migrations;

use Illuminate\Support\Facades\DB;

class RemovePermissionsMigration extends SpatiePermissionsMigration
{
    protected $permissionsToRemove = [];

    protected $guardName = 'web';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach ($this->permissionsToRemove as $permissionName) {
            DB::table('permissions')->where(['name' => $permissionName])->delete();
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
        $now = now();

        foreach ($this->permissionsToRemove as $permissionName) {
            DB::table('permissions')->insert([
                'name' => $permissionName,
                'guard_name' => $this->guardName,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        $this->resetCache();
    }
}