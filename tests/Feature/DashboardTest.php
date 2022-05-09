<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\TestUtils;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_is_displayed_for_admin()
    {
        $response = $this->actingAs(TestUtils::setupAdmin())->get('/dashboard');
        $response->assertStatus(200);
    }

    public function test_dashboard_is_displayed_for_superadmin()
    {
        $response = $this->actingAs(TestUtils::setupSuperadmin())->get('/dashboard');
        $response->assertStatus(200);
    }
}
