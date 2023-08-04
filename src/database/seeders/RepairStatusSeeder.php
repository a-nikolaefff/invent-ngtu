<?php

namespace Database\Seeders;

use App\Enums\RepairStatusEnum;
use App\Enums\UserRoleEnum;
use App\Models\RepairStatus;
use App\Models\UserRole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RepairStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (RepairStatusEnum::cases() as $status) {
            RepairStatus::create(['name' => $status->value]);
        }
    }
}
