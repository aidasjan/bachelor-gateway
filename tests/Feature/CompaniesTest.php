<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\TestUtils;

class CompaniesTest extends TestCase
{
    use RefreshDatabase;

    public function test_companies_are_displayed()
    {
        Company::factory()->count(5)->create();
        $disabledCompany = Company::factory()->create([ 'is_disabled' => 1 ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $data = $response->getOriginalContent()->getData();
        $this->assertCount(5, $data['companies']);
        $this->assertNotContains($disabledCompany, $data['companies']);
    }

    public function test_company_is_stored()
    {
        $payload = [
            'name' => 'Test', 
            'code' => 'Code', 
            'webpage_url' => 'https://wmp.local',
            'portal_url' => 'https://portal.wmp.local',
            'address' => 'Test Address',
            'email' => 'email@wmp.local',
            'phone' => '+370',
        ];
        
        $response = $this->actingAs(TestUtils::setupSuperadmin())->post('/companies', $payload);

        $response->assertStatus(302);
        $this->assertDatabaseCount('companies', 1);
        $this->assertDatabaseHas('companies', [ 'name' => 'Test' ]);
    }

    public function test_edit_has_company_data()
    {
        $company = Company::factory()->create([
            'id' => 100
        ]);
        
        $response = $this->actingAs(TestUtils::setupSuperadmin())->get('/companies/100/edit');

        $response->assertStatus(200);
        $data = $response->getOriginalContent()->getData();
        $this->assertEquals($company->name, $data['company']->name);
    }

    public function test_company_is_updated()
    {
        Company::factory()->count(5)->create();
        Company::factory()->create([
            'id' => 100
        ]);
        $payload = [
            'name' => 'New Name', 
            'code' => 'Code', 
            'webpage_url' => 'https://wmp.local',
            'portal_url' => 'https://portal.wmp.local',
            'address' => 'Test Address',
            'email' => 'email@wmp.local',
            'phone' => '+370',
        ];
        
        $response = $this->actingAs(TestUtils::setupSuperadmin())->put('/companies/100', $payload);

        $response->assertStatus(302);
        $this->assertDatabaseCount('companies', 6);
        $this->assertDatabaseHas('companies', [ 'name' => 'New Name' ]);
    }

    public function test_company_is_disabled()
    {
        Company::factory()->count(5)->create();
        Company::factory()->create([
            'id' => 100
        ]);
        
        $response = $this->actingAs(TestUtils::setupSuperadmin())->delete('/companies/100');

        $response->assertStatus(302);
        $this->assertDatabaseCount('companies', 6);
        $this->assertDatabaseHas('companies', [ 'id' => 100, 'is_disabled' => 1 ]);
    }

    public function test_sets_access_token()
    {
        $user = User::factory()->create(['id' => 1]);

        $response = $this->actingAs($user)->get('/');

        $response->assertStatus(200);
        $data = $response->getOriginalContent()->getData();
        $this->assertNotEmpty($data['accessToken']);
    }
}
