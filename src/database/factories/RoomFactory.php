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
        $buildingId = Building::pluck('id');
        $departmentId = Department::pluck('id');
        $roomTypeId = RoomType::pluck('id');

        return [
            'name' => fake()->words(2, true),
            'number' => fake()->randomNumber(4, true),
            'department_id' => $departmentId->random(),
            'room_type_id' => $roomTypeId->random(),
            'building_id' => $buildingId->random(),
        ];
    }
}
