<?php

namespace Tests;

use App\Models\User;

class TestUtils
{
    public static function setupSuperadmin()
    {
        return User::factory()->create(['id' => 1, 'role' => encrypt('superadmin')]);
    }

    public static function setupAdmin()
    {
        return User::factory()->create(['id' => 1, 'role' => encrypt('admin')]);
    }
}
