<?php

namespace Database\Seeders;

use App\Models\Building;
use App\Models\BuildingType;
use Illuminate\Database\Seeder;

class BuildingSeeder extends Seeder
{
    private static array $baseTypes
        = [
            [
                'name' => 'Учебный корпус №1',
                'address' => 'гор. Нижний Новгород, ул. Минина, 24, корп. 1',
                'building_type' => 'учебный корпус',
            ],
            [
                'name' => 'Учебный корпус №2',
                'address' => 'гор. Нижний Новгород, ул. Минина, 28Б',
                'building_type' => 'учебный корпус',
            ],
            [
                'name' => 'Учебный корпус №3',
                'address' => 'гор. Нижний Новгород, ул. Минина, 28А',
                'building_type' => 'учебный корпус',
            ],
            [
                'name' => 'Учебный корпус №4',
                'address' => 'гор. Нижний Новгород, ул. Минина, 28В',
                'building_type' => 'учебный корпус',
            ],
            [
                'name' => 'Учебный корпус №5',
                'address' => 'гор. Нижний Новгород, ул. Минина, 28Л',
                'building_type' => 'учебный корпус',
            ],
            [
                'name' => 'Учебный корпус №6',
                'address' => 'гор. Нижний Новгород, Казанское шоссе, 12кб',
                'building_type' => 'учебный корпус',
            ],
            [
                'name' => 'Общежитие №1',
                'address' => 'гор. Нижний Новгород, проспект Гагарина, д. 1',
                'building_type' => 'общежитие',
            ],
            [
                'name' => 'Общежитие №2',
                'address' => 'гор. Нижний Новгород, проспект Гагарина, д. 2',
                'building_type' => 'общежитие',
            ],
            [
                'name' => 'Общежитие №3',
                'address' => 'гор. Нижний Новгород, ул. Красносельская, д. 17',
                'building_type' => 'общежитие',
            ],
            [
                'name' => 'Общежитие №4',
                'address' => 'гор. Нижний Новгород, ул. Кулибина, д. 2',
                'building_type' => 'общежитие',
            ],
            [
                'name' => 'Общежитие №5',
                'address' => 'гор. Нижний Новгород, Казанское шоссе, д. 12б',
                'building_type' => 'общежитие',
            ],
            [
                'name' => 'Общежитие №6',
                'address' => 'гор. Нижний Новгород, Казанское шоссе, д. 12, корп. 5',
                'building_type' => 'общежитие',
            ],
            [
                'name' => 'Спортивно-оздоровительный лагерь "Ждановец"',
                'address' => 'Нижегородская обл., Городецкий район, д. Федурино',
                'building_type' => 'спортивно-оздоровительный лагерь',
            ],
            [
                'name' => 'Столовая "Студпит"',
                'address' => 'гор. Нижний Новгород, ул. Провиантская, 2',
                'building_type' => 'столовая',
            ],
        ];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (self::$baseTypes as $baseType) {
            Building::create([
                'name' => $baseType['name'],
                'address' => $baseType['address'] ,
                'building_type_id' => BuildingType::where(
                    'name',
                    $baseType['building_type']
                )->value('id'),
            ]);
        }
    }
}
