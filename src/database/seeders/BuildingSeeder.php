<?php

namespace Database\Seeders;

use App\Models\Building;
use App\Models\BuildingType;
use Database\Helpers\FileLoader;
use Illuminate\Database\Seeder;

class BuildingSeeder extends Seeder
{
    private static array $baseBuildings
        = [
            [
                'name' => 'Учебный корпус №1',
                'address' => 'гор. Нижний Новгород, ул. Минина, 24, корп. 1',
                'building_type' => 'учебный корпус',
                'floor_amount' => '3',
                'images' => 'educational_building_1',
            ],
            [
                'name' => 'Учебный корпус №2',
                'address' => 'гор. Нижний Новгород, ул. Минина, 28Б',
                'building_type' => 'учебный корпус',
                'floor_amount' => '3',
                'images' => 'educational_building_2',
            ],
            [
                'name' => 'Учебный корпус №3',
                'address' => 'гор. Нижний Новгород, ул. Минина, 28А',
                'building_type' => 'учебный корпус',
                'floor_amount' => '3',
                'images' => 'educational_building_3',
            ],
            [
                'name' => 'Учебный корпус №4',
                'address' => 'гор. Нижний Новгород, ул. Минина, 28В',
                'building_type' => 'учебный корпус',
                'floor_amount' => '4',
                'images' => 'educational_building_4',
            ],
            [
                'name' => 'Учебный корпус №5',
                'address' => 'гор. Нижний Новгород, ул. Минина, 28Л',
                'building_type' => 'учебный корпус',
                'floor_amount' => '4',
                'images' => 'educational_building_5',
            ],
            [
                'name' => 'Учебный корпус №6',
                'address' => 'гор. Нижний Новгород, Казанское шоссе, 12кб',
                'building_type' => 'учебный корпус',
                'floor_amount' => '5',
                'images' => 'educational_building_6',
            ],
            [
                'name' => 'Общежитие №1',
                'address' => 'гор. Нижний Новгород, проспект Гагарина, д. 1',
                'building_type' => 'общежитие',
                'floor_amount' => '5',
                'images' => 'dormitory_1',
            ],
            [
                'name' => 'Общежитие №2',
                'address' => 'гор. Нижний Новгород, проспект Гагарина, д. 2',
                'building_type' => 'общежитие',
                'floor_amount' => '3',
                'images' => 'dormitory_2',
            ],
            [
                'name' => 'Общежитие №3',
                'address' => 'гор. Нижний Новгород, ул. Красносельская, д. 17',
                'building_type' => 'общежитие',
                'floor_amount' => '5',
                'images' => 'dormitory_3',
            ],
            [
                'name' => 'Общежитие №4',
                'address' => 'гор. Нижний Новгород, ул. Кулибина, д. 2',
                'building_type' => 'общежитие',
                'floor_amount' => '9',
                'images' => 'dormitory_4',
            ],
            [
                'name' => 'Общежитие №5',
                'address' => 'гор. Нижний Новгород, Казанское шоссе, д. 12б',
                'building_type' => 'общежитие',
                'floor_amount' => '9',
                'images' => 'dormitory_5',
            ],
            [
                'name' => 'Общежитие №6',
                'address' => 'гор. Нижний Новгород, Казанское шоссе, д. 12, корп. 5',
                'building_type' => 'общежитие',
                'floor_amount' => '15',
                'images' => 'dormitory_6',
            ],
            [
                'name' => 'Столовая "Студпит"',
                'address' => 'гор. Нижний Новгород, ул. Провиантская, 2',
                'building_type' => 'столовая',
                'floor_amount' => '2',
                'images' => 'dining_room_studpit',
            ],
        ];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (self::$baseBuildings as $baseBuilding) {
            $building = Building::create([
                'name' => $baseBuilding['name'],
                'address' => $baseBuilding['address'],
                'floor_amount' => $baseBuilding['floor_amount'],
                'building_type_id' => BuildingType::where(
                    'name',
                    $baseBuilding['building_type']
                )->value('id'),
            ]);

            FileLoader::load(
                $building,
                'app/public/examples/buildings/' . $baseBuilding['images'],
                'images'
            );
        }
    }
}
