<?php

namespace Database\Seeders;

use App\Models\RepairType;
use Illuminate\Database\Seeder;

class RepairTypeSeeder extends Seeder
{
    private static array $baseTypes = [
        'плановый',
        'срочный',
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (self::$baseTypes as $baseType) {
            RepairType::create(['name' => $baseType]);
        }
    }
}
