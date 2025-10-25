<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Building;
use App\Models\Company;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        Activity::factory(10)
            ->withChildren(count: 2, depth: 2)
            ->create();

        Activity::factory(2)->create();

        $activities = Activity::all();

        Company::factory()
            ->hasPhones(3)
            ->recycle($activities)
            ->hasAttached($activities->random(4))
            ->create([
                'name' => "ООО “Рога и Копыта”",
                'building_id' => Building::create([
                    'address' => 'Блюхера, 32/1',
                    'latitude' => 33,
                    'longitude' => 44,
                ]),
            ]);

        Company::factory(5)
            ->recycle($activities)
            ->hasPhones(2)
            ->hasAttached($activities->random(rand(0, 4)))
            ->create();
    }
}
