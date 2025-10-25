<?php

namespace Database\Factories;

use App\Models\Activity;
use App\Models\Building;
use App\Models\Company;
use App\Models\Phone;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    protected $model = Company::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->company(),
            'building_id' => Building::factory(),
        ];
    }
}
