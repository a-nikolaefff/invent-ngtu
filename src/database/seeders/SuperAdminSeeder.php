<?php

namespace Database\Seeders;

use App\Enums\UserRoleEnum;
use App\Models\Department;
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
        $informationSystemsDepartmentId = Department::where(
            'name',
            'Отдел информационных систем'
        )->value('id');

        User::create([
            'name' => config('admin.name'),
            'email' => config('admin.email'),
            'password' => Hash::make(config('admin.password')),
            'role_id' => UserRole::getRole(UserRoleEnum::SuperAdmin)->value(
                'id'
            ),
            'department_id' => $informationSystemsDepartmentId,
            'post' => 'инженер-программист',
            'email_verified_at' => date('Y-m-d H:i:s')
        ]);
    }
}
