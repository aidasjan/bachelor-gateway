<?php

namespace Tests\Unit;

use App\Mail\PasswordResetMail;
use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;
use Tests\TestUtils;

class UsersTest extends TestCase
{
    use RefreshDatabase;

    public function test_users_are_displayed()
    {
        $superadmin = TestUtils::setupSuperadmin();
        User::factory()->count(5)->create();

        $response = $this->actingAs($superadmin)->get('/users');

        $response->assertStatus(200);
        $data = $response->getOriginalContent()->getData();
        $this->assertCount(6, $data['users']);
    }

    public function test_create_user_companies_are_displayed()
    {
        Company::factory()->count(5)->create();

        $response = $this->actingAs(TestUtils::setupSuperadmin())->get('/users/create');

        $response->assertStatus(200);
        $data = $response->getOriginalContent()->getData();
        $this->assertCount(5, $data['companies']);
    }

    public function test_user_is_stored_and_encrypted()
    {
        $payload = [
            'name' => 'John Smith',
            'email' => 'john@wmp.local',
            'company_id' => 1,
        ];

        $this->actingAs(TestUtils::setupSuperadmin())->post('/users', $payload);

        $this->assertDatabaseCount('users', 2);
        $this->assertDatabaseHas('users', ['email_h' => hash('sha1', 'john@wmp.local')]);
        $user = User::find(2);
        $this->assertEquals('John Smith', decrypt($user->getRawOriginal('name')));
    }

    public function test_user_is_updated_and_encrypted()
    {
        $user = User::factory()->create(['id' => 100]);
        $payload = ['name' => 'John Smith'];

        $this->actingAs(TestUtils::setupSuperadmin())->put('/users/100', $payload);

        $user = User::find(100);
        $this->assertEquals('John Smith', decrypt($user->getRawOriginal('name')));
    }

    public function test_weak_password_is_not_accepted_to_change()
    {
        $weakPassword = 'password';
        $user = User::factory()->create(['id' => 1]);
        $payload = ['password' => $weakPassword, 'password_confirmation' => $weakPassword];

        $this->actingAs($user)->post('/password', $payload);

        $user = User::find(1);
        $this->assertFalse(Hash::check($weakPassword, $user->password));
    }

    public function test_strong_password_is_accepted_to_change()
    {
        $strongPassword = 's8vn1p9vwnu38f';
        $user = User::factory()->create(['id' => 1]);
        $payload = ['password' => $strongPassword, 'password_confirmation' => $strongPassword];

        $this->actingAs($user)->post('/password', $payload);

        $user = User::find(1);
        $this->assertTrue(Hash::check($strongPassword, $user->password));
    }

    public function test_user_is_disabled()
    {
        User::factory()->create(['id' => 100]);
        
        $this->actingAs(TestUtils::setupSuperadmin())->delete('/users/100');

        $this->assertDatabaseCount('users', 2);
        $this->assertDatabaseHas('users', [ 'id' => 100, 'is_disabled' => 1 ]);
    }

    public function test_password_reset_mail_is_sent()
    {
        Mail::fake();
        $user = User::factory()->create(['id' => 100]);
        $payload = ['email' => decrypt($user->getRawOriginal('email'))];
        
        $this->actingAs($user)->post('/passwordresetrequest', $payload);

        Mail::assertSent(PasswordResetMail::class);
    }

    public function test_password_reset_user_is_logged_in_with_valid_token()
    {
        User::factory()->create([
            'password_reset_token' => 'validpasswordresettoken', 
            'password_reset_date' => now()
        ]);
        
        $result = $this->get('/passwordreset/validpasswordresettoken');

        $result->assertStatus(302);
        $this->assertTrue(Auth::check());
    }
}
