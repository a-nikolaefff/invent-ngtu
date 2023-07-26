<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\DepartmentType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    private static array $baseTypes
        = [
            [
                'name' => 'Учебно-научный институт радиоэлектроники и информационных технологий',
                'short_name' => 'ИРИТ',
                'department_type' => 'институт',
            ],
            [
                'name' => 'Кафедра "Графические информационные системы"',
                'short_name' => 'Кафедра ГИС',
                'department_type' => 'кафедра',
                'parent_department' => 'Учебно-научный институт радиоэлектроники и информационных технологий',
            ],
        ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (self::$baseTypes as $baseType) {
            Department::create([
                'name' => $baseType['name'],
                'short_name' => $baseType['short_name'],
                'department_type_id' => DepartmentType::where(
                    'name',
                    $baseType['department_type']
                )->value('id'),
                'parent_department_id' => isset($baseType['parent_department']) ? Department::where(
                    'name',
                    $baseType['parent_department']
                )->value('id') : null,
            ]);
        }
    }
}
