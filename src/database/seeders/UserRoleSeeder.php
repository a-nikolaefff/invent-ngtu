<?php

namespace Database\Seeders;

use App\Enums\UserRoleEnum;
use App\Models\UserRole;
use Illuminate\Database\Seeder;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (UserRoleEnum::cases() as $roleType) {
            UserRole::create(['name' => $roleType->value]);
        }
    }
}
