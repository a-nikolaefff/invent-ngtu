<?php

namespace Database\Seeders;

use App\Enums\RepairStatusEnum;
use App\Models\RepairStatus;
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
