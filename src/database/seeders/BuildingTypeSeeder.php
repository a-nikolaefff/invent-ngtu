<?php

namespace Database\Seeders;

use App\Models\BuildingType;
use Illuminate\Database\Seeder;

class BuildingTypeSeeder extends Seeder
{
    private static array $baseTypes = [
        'учебный корпус',
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (self::$baseTypes as $baseType) {
            BuildingType::create(['name' => $baseType]);
        }
    }
}
