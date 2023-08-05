<?php

namespace Database\Seeders;

use App\Models\RepairApplication;
use Illuminate\Database\Seeder;

class RepairApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RepairApplication::factory()->count(10)->create();
    }
}
