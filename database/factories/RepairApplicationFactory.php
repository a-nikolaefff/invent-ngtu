<?php

namespace Database\Factories;

use App\Enums\RepairApplicationStatusEnum;
use App\Models\Equipment;
use App\Models\RepairApplication;
use App\Models\RepairApplicationStatus;
use App\Models\User;
use Carbon\Carbon;
use Database\Helpers\FileLoader;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RepairApplication>
 */
class RepairApplicationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $verbs = [
            'Отремонтировать',
            'Провести обслуживание',
            'Устранить поломку',
            'Починить',
            'Восстановить',
        ];
        $randomVerb = fake()->randomElement($verbs);

        $status = RepairApplicationStatus::all()->random();

        return [
            'short_description' => $randomVerb.' '.fake()->words(2, true),
            'full_description' => $randomVerb.' '.fake()->words(6, true),
            'response' => fake()->words(6, true),
            'application_date' => Carbon::now(),
            'response_date' => $status->name
            !== RepairApplicationStatusEnum::Pending->value ?
                Carbon::now()::now()
                : null,
            'equipment_id' => Equipment::pluck('id')->random(),
            'repair_application_status_id' => $status->id,
            'user_id' => User::pluck('id')->random(),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (RepairApplication $application) {
            FileLoader::load(
                $application,
                'app/examples/equipment',
                'images'
            );
        }
        );
    }
}
