<?php

namespace LangleyFoxall\LaravelPermissionMigrations\Database\Migrations;

use Illuminate\Support\Facades\DB;

class AddPermissionsMigration extends SpatiePermissionsMigration
{
    protected $permissionsToAdd = [];

    protected $guardName = 'web';

    protected $tableName;

    public function __construct()
    {
        $this->tableName = config('permission.table_names.permissions', 'permissions');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $now = now();

        foreach ($this->permissionsToAdd as $permissionName) {
            DB::table($this->tableName)->insert([
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
            DB::table($this->tableName)->where(['name' => $permissionName])->delete();
        }

        $this->resetCache();
    }
}