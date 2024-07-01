<?php

namespace Database\Seeders;

use App\Enums\RepairApplicationStatusEnum;
use App\Models\RepairApplicationStatus;
use Illuminate\Database\Seeder;

class RepairApplicationStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (RepairApplicationStatusEnum::cases() as $status) {
            RepairApplicationStatus::create(['name' => $status->value]);
        }
    }
}
