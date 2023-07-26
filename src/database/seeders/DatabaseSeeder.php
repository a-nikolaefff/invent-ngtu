<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Department;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $seeders = [
            UserRoleSeeder::class,
            SuperAdminSeeder::class,
            DepartmentTypeSeeder::class,
            BuildingTypeSeeder::class,
            RoomTypeSeeder::class,
            EquipmentTypeSeeder::class,
            DepartmentSeeder::class,
        ];
        $appEnv = config('app.env');
        if($appEnv === 'development') {
            $seeders[] = UserSeeder::class;
        }
        $this->call($seeders);
    }
}
