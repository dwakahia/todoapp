<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{


    use RefreshDatabase, HasFactory;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_display_login_form()
    {
        $response = $this->get(route('login'));

        $response->assertSuccessful();
    }

    public function test_logs_user_in_with_correct_credentials()
    {
        // Given

        $user = User::factory()->create([
            'password' => bcrypt($password = 'random-password'),
            'photo' => 'pic-one.jpg'
        ]);

        // When
        $response = $this->post(route('login'), [
            'email' => $user->email,
            'password' => $password,
        ]);

        // Then
        $this->assertAuthenticatedAs($user);
    }

    public function test_will_not_login_user_with_wrong_password()
    {
        // Given
        $user =  User::factory()->create([
            'password' => bcrypt($password = 'random-password'),
            'photo' => 'pic-one.jpg'
        ]);

        // When
        $response = $this->from(route('login'))
            ->post(route('login'), [
                'email' => $user->email,
                'password' => 'wrong-password',
            ]);

        // Then
        $response->assertRedirect(route('login'));
        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_can_not_login_if_user_doesnt_exist()
    {
        // Given

        // When
        $response = $this->from(route('login'))
            ->post(route('login'), [
                'email' => 'doesnt-exist-email',
                'password' => 'wrong-password',
            ]);

        // Then
        $response->assertRedirect(route('login'));
        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }


    public function test_allows_user_to_logout()
    {
        // Given
        $user = User::factory()->create([
            'photo' => 'pic-one.jpg'
        ]);
        $this->be($user);

        // When
        $this->post(route('logout'));

        // Then
        $this->assertGuest();
    }
}
