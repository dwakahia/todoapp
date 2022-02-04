<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class LoginRedirection extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_login_redirection()
    {
        $response = $this->get('/home');

        $response->assertStatus(302); //redirected to login
    }
}
