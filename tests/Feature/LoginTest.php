<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_is_logged_in()
    {
        User::factory()->create([
            'email' => encrypt('user@wmp.local'), 
            'email_h' => hash('sha1', 'user@wmp.local'),
            'password' => Hash::make('password123')
        ]);
        $payload = [
            'email' => 'user@wmp.local',
            'password' => 'password123',
        ];

        $this->post('/login', $payload);

        $this->assertTrue(Auth::check());
    }

    public function test_user_is_not_logged_in_with_incorrect_password()
    {
        User::factory()->create([
            'email' => encrypt('user@wmp.local'), 
            'email_h' => hash('sha1', 'user@wmp.local'),
            'password' => Hash::make('password123')
        ]);
        $payload = [
            'email' => 'user@wmp.local',
            'password' => 'incorrect',
        ];

        $this->post('/login', $payload);

        $this->assertFalse(Auth::check());
    }
}
