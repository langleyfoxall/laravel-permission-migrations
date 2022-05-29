<?php

namespace LangleyFoxall\LaravelPermissionMigrations\Database\Migrations;

use Illuminate\Support\Facades\DB;

class AddPermissionsMigration extends SpatiePermissionsMigration
{
    protected $permissionsToAdd = [];

    protected $guardName = 'web';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $now = now();

        foreach ($this->permissionsToAdd as $permissionName) {
            DB::table('permissions')->insert([
                'name' => $permissionName,
                'guard_name' => $this->guardName,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
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
        foreach ($this->permissionsToAdd as $permissionName) {
            DB::table('permissions')->where(['name' => $permissionName])->delete();
        }

        $this->resetCache();
    }
}