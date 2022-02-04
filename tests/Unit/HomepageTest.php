<?php

namespace Tests\Unit;

use Tests\TestCase;

class HomepageTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_homepage()
    {
        $response = $this->get('/');

        $response->assertStatus(200);

        $response->assertSee('Tasks');
    }
}
