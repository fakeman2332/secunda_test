<?php

namespace Database\Factories;

use App\Models\Building;
use Illuminate\Database\Eloquent\Factories\Factory;

class BuildingFactory extends Factory
{
    protected $model = Building::class;

    public function definition(): array
    {
        return [
            'address' => $this->faker->address(),
            'latitude' => $this->faker->latitude(),
            'longitude' => $this->faker->longitude(),
        ];
    }
}
