<?php

namespace LangleyFoxall\LaravelPermissionMigrations\Database\Migrations;

use Illuminate\Support\Facades\DB;

class AddRolesMigration extends SpatiePermissionsMigration
{
    protected $rolesToAdd = [];

    protected $guardName = 'web';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $now = now();

        foreach ($this->rolesToAdd as $role) {
            DB::table('roles')->insert([
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
            DB::table('roles')->where(['name' => $role])->delete();
        }

        $this->resetCache();
    }
}