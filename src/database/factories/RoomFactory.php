<?php

namespace Database\Factories;

use App\Models\Building;
use App\Models\Department;
use App\Models\RoomType;
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
        $roomTypeId = RoomType::pluck('id');

        return [
            'name' => fake()->words(2, true),
            'number' => $roomNumberFirstDigit
                . $floor
                . fake()->randomNumber(2, true),
            'department_id' => $departmentId->random(),
            'room_type_id' => $roomTypeId->random(),
            'building_id' => $building->id,
            'floor' => $floor,
        ];
    }
}
