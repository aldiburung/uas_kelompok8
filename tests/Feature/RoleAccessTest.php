<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RoleAccessTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // run migrations for test database
        $this->artisan('migrate');
    }

    public function test_keuangan_can_access_keuangan_and_reports()
    {
        $user = User::factory()->create(['role' => 'keuangan']);

        $this->actingAs($user)->get(route('keuangan.index'))->assertStatus(200);
        $this->actingAs($user)->get(route('reports.index'))->assertStatus(200);
        $this->actingAs($user)->get(route('barter.index'))->assertStatus(403);
    }

    public function test_barter_can_access_barter_and_requests()
    {
        $user = User::factory()->create(['role' => 'barter']);

        $this->actingAs($user)->get(route('barter.index'))->assertStatus(200);
        $this->actingAs($user)->get(route('barter-requests.index'))->assertStatus(200);
        $this->actingAs($user)->get(route('keuangan.index'))->assertStatus(403);
    }
}
