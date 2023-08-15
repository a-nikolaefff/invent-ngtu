<?php

namespace tests\Feature\User;

use App\Enums\UserRoleEnum;
use App\Models\User;
use App\Models\UserRole;
use Database\Seeders\DepartmentSeeder;
use Database\Seeders\UserRoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DisplayUserListTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_list_of_users_can_be_shown_to_super_administrator(
    ): void
    {
        $this->seed([UserRoleSeeder::class, DepartmentSeeder::class]);

        $superAdminRoleId = UserRole::where(
            'name',
            UserRoleEnum::SuperAdmin->value
        )->value('id');
        $user = User::factory()->create(['role_id' => $superAdminRoleId]);

        $response = $this
            ->actingAs($user)
            ->get('/users');

        $response->assertStatus(200);
    }

    public function test_list_of_users_can_be_shown_to_administrator(
    ): void
    {
        $this->seed([UserRoleSeeder::class, DepartmentSeeder::class]);

        $adminRoleId = UserRole::where(
            'name',
            UserRoleEnum::Admin->value
        )->value('id');
        $user = User::factory()->create(['role_id' => $adminRoleId]);

        $response = $this
            ->actingAs($user)
            ->get('/users');

        $response->assertStatus(200);
    }

    public function test_list_of_users_cannot_be_shown_to_supply_and_repair_specialist(
    ): void
    {
        $this->seed([UserRoleSeeder::class, DepartmentSeeder::class]);

        $specialistRoleId = UserRole::where(
            'name',
            UserRoleEnum::SupplyAndRepairSpecialist->value
        )->value('id');
        $user = User::factory()->create(['role_id' => $specialistRoleId]);

        $response = $this
            ->actingAs($user)
            ->get('/users');

        $response->assertStatus(403);
    }

    public function test_list_of_users_cannot_be_shown_to_employee(
    ): void
    {
        $this->seed([UserRoleSeeder::class, DepartmentSeeder::class]);

        $employeeRoleId = UserRole::where(
            'name',
            UserRoleEnum::Employee->value
        )->value('id');
        $user = User::factory()->create(['role_id' => $employeeRoleId]);

        $response = $this
            ->actingAs($user)
            ->get('/users');

        $response->assertStatus(403);
    }

    public function test_list_of_users_cannot_be_shown_to_guest(
    ): void
    {
        $response = $this->get('/users');

        $response->assertRedirect('/login');
    }
}
