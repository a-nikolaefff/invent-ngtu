<?php

namespace Database\Seeders;

use App\Models\EquipmentType;
use Illuminate\Database\Seeder;

class EquipmentTypeSeeder extends Seeder
{
    private static array $baseTypes = [
        'компьютер',
        'проектор',
        'принтер',
        'сканер',
        'видеоаппаратура',
        'аудиоаппаратура',
        'лабораторное оборудование',
        'кондиционер',
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (self::$baseTypes as $baseType) {
            EquipmentType::create(['name' => $baseType]);
        }
    }
}
