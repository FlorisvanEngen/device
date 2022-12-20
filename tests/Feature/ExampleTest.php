<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    // ? refresh database with an modal
    // use RefreshDatabase;

    /**
     * @test
     * A basic test example.
     *
     * @return void
     */
    public function the_application_returns_a_successful_response()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
