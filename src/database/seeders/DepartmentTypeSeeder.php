<?php

namespace Database\Seeders;

use App\Models\DepartmentType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentTypeSeeder extends Seeder
{
    private static array $baseTypes = [
        'институт',
        'факультет',
        'кафедра',
        'лаборатория',
        'центр',
        'конструкторское бюро',
        'управление',
        'служба',
        'отдел',
        'группа',
        'сектор',
        'клуб',
        ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (self::$baseTypes as $baseType) {
            DepartmentType::create(['name' => $baseType]);
        }
    }
}
