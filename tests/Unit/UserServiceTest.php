<?php

namespace Tests\Unit;

use App\Exceptions\UserErrorException;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_store_storesUserEncrypted()
    {
        $data = [
            'name' => 'John Smith',
            'email' => 'john@wmp.local',
        ];
        $request = new Request();
        $request->replace($data);

        $service = new UserService();
        $service->store($request);

        $this->assertDatabaseCount('users', 1);
        $this->assertDatabaseHas('users', ['email_h' => hash('sha1', 'john@wmp.local')]);
        $user = User::find(1);
        $this->assertEquals('John Smith', decrypt($user->getRawOriginal('name')));
    }

    public function test_update_updatesUserEncrypted()
    {
        $user = User::factory()->create(['id' => 1]);
        $data = ['name' => 'John Smith'];
        $request = new Request();
        $request->replace($data);

        $service = new UserService();
        $service->update($request, 1);

        $user = User::find(1);
        $this->assertEquals('John Smith', decrypt($user->getRawOriginal('name')));
    }

    public function test_changePassword_doesNotChangeToWeakPassword()
    {
        $user = User::factory()->create(['id' => 1]);
        $data = ['password' => 'pass'];
        $request = new Request();
        $request->replace($data);

        $this->expectException(UserErrorException::class);
        $this->actingAs($user);

        $service = new UserService();
        $service->changePassword($request);
    }

    public function test_changePassword_changesToStrongPassword()
    {
        $strongPassword = 's8vn1p9vwnu38f';
        $user = User::factory()->create(['id' => 1]);
        $data = ['password' => $strongPassword];
        $request = new Request();
        $request->replace($data);

        $this->actingAs($user);
        $service = new UserService();
        $service->changePassword($request);

        $user = User::find(1);
        $this->assertTrue(Hash::check($strongPassword, $user->password));
    }

    public function test_setAccessToken_setsAccessToken()
    {
        $user = User::factory()->create(['id' => 1]);

        $service = new UserService();
        $service->setAccessToken(1);

        $user = User::find(1);
        $this->assertNotEmpty($user->access_token);
    }

    public function test_disable_disablesUser()
    {
        User::factory()->count(5)->create();
        User::factory()->create(['id' => 100]);
        
        $service = new UserService();
        $service->disable(100);

        $this->assertDatabaseCount('users', 6);
        $this->assertDatabaseHas('users', [ 'id' => 100, 'is_disabled' => 1 ]);
    }
}
