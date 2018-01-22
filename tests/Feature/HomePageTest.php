<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HomePageTest extends TestCase
{
    /** @test */
    public function see_login_form_on_homepage()
    {
        $response = $this->get('/');
        $response->assertViewIs('welcome');
    }
}
