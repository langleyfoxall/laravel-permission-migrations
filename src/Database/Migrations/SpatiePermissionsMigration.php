<?php

namespace LangleyFoxall\LaravelPermissionMigrations\Database\Migrations;

use Illuminate\Database\Migrations\Migration;

class SpatiePermissionsMigration extends Migration
{
    /**
     * Resets the internal permissions cache.
     */
    protected function resetCache(): void
    {
        app('cache')
            ->store(config('permission.cache.store') != 'default' ? config('permission.cache.store') : null)
            ->forget(config('permission.cache.key'));
    }
}