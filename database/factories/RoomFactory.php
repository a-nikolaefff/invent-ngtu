<?php

namespace Database\Factories;

use App\Models\Building;
use App\Models\Department;
use App\Models\Room;
use App\Models\RoomType;
use Database\Helpers\FileLoader;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Room>
 */
class RoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $building = Building::all()->random();
        $floor = fake()->numberBetween(0, $building->floor_amount);
        $roomNumberFirstDigit = $building->id < 7 ? $building->id : '';

        $departmentId = Department::pluck('id');
        $roomType = RoomType::all()->random();

        $roomNameFirstLetterUpper = mb_strtoupper(mb_substr($roomType->name, 0, 1, 'UTF-8'), 'UTF-8');
        $roomName = $roomNameFirstLetterUpper.mb_substr($roomType->name, 1, null, 'UTF-8');

        return [
            'name' => $roomName.' '.fake()->words(2, true),
            'number' => $roomNumberFirstDigit
                .$floor
                .fake()->randomNumber(2, true),
            'department_id' => $departmentId->random(),
            'room_type_id' => $roomType->id,
            'building_id' => $building->id,
            'floor' => $floor,
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Room $room) {
            FileLoader::load(
                $room,
                'app/examples/rooms',
                'images'
            );
        }
        );
    }
}
