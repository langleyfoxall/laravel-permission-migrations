<?php

namespace LangleyFoxall\LaravelPermissionMigrations\Database\Migrations;

use Illuminate\Support\Facades\DB;

class RemoveRolesMigration extends SpatiePermissionsMigration
{
    /**
     * @var array An array of strings of each role that should
     * be removed when running this migration.
     */
    protected $rolesToRemove = [];

    /**
     * @var string The auth guard that the roles being removed
     * are assigned to. Used in migrate:rollback
     */
    protected $guardName = 'web';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach ($this->rolesToRemove as $role) {
            DB::table('roles')->where(['name' => $role])->delete();
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

        foreach ($this->rolesToRemove as $role) {
            DB::table('roles')->insert([
                'name' => $role,
                'guard_name' => $this->guardName,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        $this->resetCache();
    }
}