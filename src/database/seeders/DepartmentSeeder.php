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
            // Учебно-научный институт радиоэлектроники и информационных технологий
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
            [
                'name' => 'Кафедра "Вычислительные системы и технологии"',
                'short_name' => 'Кафедра ВСТ',
                'department_type' => 'кафедра',
                'parent_department' => 'Учебно-научный институт радиоэлектроники и информационных технологий',
            ],

            // Управление информатизации
            [
                'name' => 'Управление информатизации',
                'department_type' => 'управление',
            ],
            [
                'name' => 'Информационно-вычислительный центр',
                'short_name' => 'ИВЦ',
                'department_type' => 'центр',
                'parent_department' => 'Управление информатизации',
            ],
            [
                'name' => 'Отдел связи и телекоммуникаций',
                'department_type' => 'отдел',
                'parent_department' => 'Информационно-вычислительный центр',
            ],
            [
                'name' => 'Отдел информационных систем',
                'department_type' => 'отдел',
                'parent_department' => 'Управление информатизации',
            ],
            [
                'name' => 'Отдел автоматизации бухгалтерской деятельности',
                'department_type' => 'отдел',
                'parent_department' => 'Управление информатизации',
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
                'short_name' => $baseType['short_name'] ?? null,
                'department_type_id' => DepartmentType::where(
                    'name',
                    $baseType['department_type']
                )->value('id'),
                'parent_department_id' => isset($baseType['parent_department'])
                    ? Department::where(
                        'name',
                        $baseType['parent_department']
                    )->value('id') : null,
            ]);
        }
    }
}
