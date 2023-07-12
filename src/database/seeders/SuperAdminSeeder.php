<?php

namespace Database\Seeders;

use App\Enums\UserRoleEnum;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => config('admin.name'),
            'email' => config('admin.email'),
            'password' => Hash::make(config('admin.password')),
            'role_id' => UserRole::getRole(UserRoleEnum::SuperAdmin)->value('id'),
            'email_verified_at' => date('Y-m-d H:i:s')
        ]);
    }
}
