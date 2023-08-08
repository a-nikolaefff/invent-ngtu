<?php

namespace Database\Seeders;

use App\Models\BuildingType;
use App\Models\RoomType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoomTypeSeeder extends Seeder
{
    private static array $baseTypes = [
        'аудитория',
        'лекционный зал',
        'компьютерный класс',
        'деканат',
        'лаборатория',
        'кабинет',
        'туалет',
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (self::$baseTypes as $baseType) {
            RoomType::create(['name' => $baseType]);
        }
    }
}
