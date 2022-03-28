<?php

namespace Tests\Unit;

use App\Models\Company;
use App\Services\CompanyService;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\Request;
use Tests\TestCase;

class CompanyServiceTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_all_returnsEnabledCompanies()
    {
        Company::factory()->count(5)->create();
        $disabledCompany = Company::factory()->create([ 'is_disabled' => 1 ]);

        $companyService = new CompanyService();
        $result = $companyService->all();

        $this->assertCount(5, $result);
        $this->assertNotContains($disabledCompany, $result);
    }

    public function test_store_storesCompany()
    {
        $data = [
            'name' => 'Test', 
            'code' => 'Code', 
            'webpage_url' => 'https://wmp.local',
            'portal_url' => 'https://portal.wmp.local',
            'address' => 'Test Address',
            'email' => 'email@wmp.local',
            'phone' => '+370',
        ];
        $request = new Request();
        $request->replace($data);
        
        $companyService = new CompanyService();
        $companyService->store($request);

        $this->assertDatabaseCount('companies', 1);
        $this->assertDatabaseHas('companies', [ 'name' => 'Test' ]);
    }

    public function test_update_updatesCompany()
    {
        Company::factory()->count(5)->create();
        Company::factory()->create([
            'id' => 100
        ]);
        $data = [
            'name' => 'New Name', 
            'code' => 'Code', 
            'webpage_url' => 'https://wmp.local',
            'portal_url' => 'https://portal.wmp.local',
            'address' => 'Test Address',
            'email' => 'email@wmp.local',
            'phone' => '+370',
        ];
        $request = new Request();
        $request->replace($data);
        
        $companyService = new CompanyService();
        $companyService->update($request, 100);

        $this->assertDatabaseCount('companies', 6);
        $this->assertDatabaseHas('companies', [ 'name' => 'New Name' ]);
    }

    public function test_disable_disablesCompany()
    {
        Company::factory()->count(5)->create();
        Company::factory()->create([
            'id' => 100
        ]);
        
        $companyService = new CompanyService();
        $companyService->disable(100);

        $this->assertDatabaseCount('companies', 6);
        $this->assertDatabaseHas('companies', [ 'id' => 100, 'is_disabled' => 1 ]);
    }
}
