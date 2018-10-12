<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function check_redirect_to_dashboard()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get('/');
        $response->assertRedirect('/dashboard');
    }

    /** @test */
    public function get_dashboard_page()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get('/dashboard');
        $response->assertViewIs('dashboard');
    }

    /** @test */
    public function check_unauthed_request_to_dashboard_redirects_to_login()
    {
        $response = $this->get('/dashboard');
        $response->assertRedirect('/login');
    }
}
