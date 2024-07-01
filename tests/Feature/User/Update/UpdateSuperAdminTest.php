<?php

namespace tests\Feature\User\Update;

use App\Enums\UserRoleEnum;
use App\Http\Middleware\VerifyCsrfToken;
use App\Models\User;
use App\Models\UserRole;
use Database\Seeders\DepartmentSeeder;
use Database\Seeders\UserRoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateSuperAdminTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_super_administrator_cannot_be_updated_by_super_administrator(
    ): void
    {
        $this->withoutMiddleware(VerifyCsrfToken::class);
        $this->seed([UserRoleSeeder::class, DepartmentSeeder::class]);

        $superAdminRoleId = UserRole::where(
            'name',
            UserRoleEnum::SuperAdmin->value
        )->value('id');
        $superAdmin = User::factory()->create(['role_id' => $superAdminRoleId]);

        $response = $this
            ->actingAs($superAdmin)
            ->put('/users/' . $superAdmin->id);

        $response->assertStatus(403);
    }

    public function test_super_administrator_cannot_be_updated_by_administrator(
    ): void
    {
        $this->withoutMiddleware(VerifyCsrfToken::class);
        $this->seed([UserRoleSeeder::class, DepartmentSeeder::class]);

        $adminRoleId = UserRole::where(
            'name',
            UserRoleEnum::Admin->value
        )->value('id');
        $admin = User::factory()->create(['role_id' => $adminRoleId]);

        $superAdminRoleId = UserRole::where(
            'name',
            UserRoleEnum::SuperAdmin->value
        )->value('id');
        $superAdmin = User::factory()->create(['role_id' => $superAdminRoleId]);

        $response = $this
            ->actingAs($admin)
            ->put('/users/' . $superAdmin->id);

        $response->assertStatus(403);
    }

    public function test_super_administrator_cannot_be_updated_by_supply_and_repair_specialist(
    ): void
    {
        $this->withoutMiddleware(VerifyCsrfToken::class);
        $this->seed([UserRoleSeeder::class, DepartmentSeeder::class]);

        $specialistRoleId = UserRole::where(
            'name',
            UserRoleEnum::SupplyAndRepairSpecialist->value
        )->value('id');
        $specialist = User::factory()->create(['role_id' => $specialistRoleId]);

        $superAdminRoleId = UserRole::where(
            'name',
            UserRoleEnum::SuperAdmin->value
        )->value('id');
        $superAdmin = User::factory()->create(['role_id' => $superAdminRoleId]);

        $response = $this
            ->actingAs($specialist)
            ->put('/users/' . $superAdmin->id);

        $response->assertStatus(403);
    }

    public function test_super_administrator_cannot_be_updated_by_employee(
    ): void
    {
        $this->withoutMiddleware(VerifyCsrfToken::class);
        $this->seed([UserRoleSeeder::class, DepartmentSeeder::class]);

        $employeeRoleId = UserRole::where(
            'name',
            UserRoleEnum::Employee->value
        )->value('id');
        $employee = User::factory()->create(['role_id' => $employeeRoleId]);

        $superAdminRoleId = UserRole::where(
            'name',
            UserRoleEnum::SuperAdmin->value
        )->value('id');
        $superAdmin = User::factory()->create(['role_id' => $superAdminRoleId]);

        $response = $this
            ->actingAs($employee)
            ->put('/users/' . $superAdmin->id);

        $response->assertStatus(403);
    }

    public function test_super_administrator_cannot_be_updated_by_guest(
    ): void
    {
        $this->withoutMiddleware(VerifyCsrfToken::class);
        $this->seed([UserRoleSeeder::class, DepartmentSeeder::class]);

        $superAdminRoleId = UserRole::where(
            'name',
            UserRoleEnum::SuperAdmin->value
        )->value('id');
        $superAdmin = User::factory()->create(['role_id' => $superAdminRoleId]);

        $response = $this->put('/users/' . $superAdmin->id);

        $response->assertRedirect('/login');
    }
}
