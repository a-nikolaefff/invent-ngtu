<?php

namespace Tests\Feature\Auth;

use App\Enums\UserRoleEnum;
use App\Http\Middleware\VerifyCsrfToken;
use App\Models\User;
use App\Models\UserRole;
use Database\Seeders\DepartmentSeeder;
use Database\Seeders\UserRoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PasswordConfirmationTest extends TestCase
{
    use RefreshDatabase;

    public function test_confirm_password_screen_can_be_rendered(): void
    {
        $this->seed([UserRoleSeeder::class, DepartmentSeeder::class]);

        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/confirm-password');

        $response->assertStatus(200);
    }

    public function test_password_can_be_confirmed(): void
    {
        $this->withoutMiddleware(VerifyCsrfToken::class);
        $this->seed([UserRoleSeeder::class, DepartmentSeeder::class]);
        $employeeRoleId = UserRole::where('name', UserRoleEnum::Employee->value)
            ->value('id');

        $user = User::factory()->create(['role_id' => $employeeRoleId ]);

        $response = $this->actingAs($user)->post('/confirm-password', [
            'password' => 'password',
        ]);

        $response->assertRedirect();
        $response->assertSessionHasNoErrors();
    }

    public function test_password_is_not_confirmed_with_invalid_password(): void
    {
        $this->withoutMiddleware(VerifyCsrfToken::class);
        $this->seed([UserRoleSeeder::class, DepartmentSeeder::class]);

        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/confirm-password', [
            'password' => 'wrong-password',
        ]);

        $response->assertSessionHasErrors();
    }
}
