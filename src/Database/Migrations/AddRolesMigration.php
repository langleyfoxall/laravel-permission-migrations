<?php

namespace LangleyFoxall\LaravelPermissionMigrations\Database\Migrations;

use Illuminate\Support\Facades\DB;

class AddRolesMigration extends SpatiePermissionsMigration
{
    protected $rolesToAdd = [];

    protected $guardName = 'web';

    protected $tableName;

    public function __construct()
    {
        $this->tableName = config('permission.table_names.roles', 'roles');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $now = now();

        foreach ($this->rolesToAdd as $role) {
            DB::table($this->tableName)->insert([
                'name' => $role,
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
        foreach ($this->rolesToAdd as $role) {
            DB::table($this->tableName)->where(['name' => $role])->delete();
        }

        $this->resetCache();
    }
}