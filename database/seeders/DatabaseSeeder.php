<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('companies')->insert([
            [
                'name' => 'WaterComponents',
                'logo' => 'img/watercomponents-logo.svg',
                'code' => '97846516854',
                'webpage_url' => 'https://google.com',
                'portal_url' => 'http://company.wmp.local',
                'address' => 'Kaunas, Lithuania',
                'email' => 'info@water.local',
                'phone' => '+370',
                'is_disabled' => false
            ],
            [
                'name' => 'Chemicals Ltd.',
                'logo' => 'img/chemicals-logo.svg',
                'code' => '97846516855',
                'webpage_url' => 'https://google.com',
                'portal_url' => 'http://wmp02.herokuapp.com',
                'address' => 'Kaunas, Lithuania',
                'email' => 'info@chemicals.local',
                'phone' => '+370',
                'is_disabled' => false
            ]
        ]);

        DB::table('users')->insert(
            [
                'name' => encrypt('Super Admin'),
                'email' => encrypt('admin@wmp.local'),
                'email_h' => hash('sha1', 'admin@wmp.local'),
                'role' => encrypt('superadmin'),
                'is_new' => 0,
                'password' => Hash::make('admin123'),
                'is_disabled' => 0,
            ]
        );
        DB::table('users')->insert(
            [
                'name' => encrypt('John Smith'),
                'email' => encrypt('info@water.local'),
                'email_h' => hash('sha1', 'info@water.local'),
                'role' => encrypt('admin'),
                'is_new' => 0,
                'password' => Hash::make('admin123'),
                'company_id' => '1',
                'is_disabled' => 0,
            ]
        );
        DB::table('users')->insert(
            [
                'name' => encrypt('Chemicals Ltd.'),
                'email' => encrypt('info@chemicals.local'),
                'email_h' => hash('sha1', 'info@chemicals.local'),
                'role' => encrypt('admin'),
                'is_new' => 0,
                'password' => Hash::make('admin123'),
                'company_id' => '2',
                'is_disabled' => 0,
            ]
        );
    }
}
