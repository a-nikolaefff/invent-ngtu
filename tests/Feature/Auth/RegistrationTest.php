<?php

namespace Tests\Feature\Auth;

use Anhskohbo\NoCaptcha\Facades\NoCaptcha;
use App\Http\Middleware\VerifyCsrfToken;
use App\Models\Department;
use App\Providers\RouteServiceProvider;
use Database\Seeders\DepartmentSeeder;
use Database\Seeders\UserRoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register(): void
    {
        $this->withoutMiddleware(VerifyCsrfToken::class);
        $this->seed([UserRoleSeeder::class, DepartmentSeeder::class]);

        // prevent validation error on captcha
        NoCaptcha::shouldReceive('verifyResponse')
            ->once()
            ->andReturn(true);

        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'department_id' => Department::pluck('id')->random(),
            'post' => fake()->word,
            'g-recaptcha-response' => '1',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
    }
}
