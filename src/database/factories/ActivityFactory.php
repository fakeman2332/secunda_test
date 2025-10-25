<?php

namespace Database\Factories;

use App\Models\Activity;
use Illuminate\Database\Eloquent\Factories\Factory;

class ActivityFactory extends Factory
{
    protected $model = Activity::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->words(2, true),
            'parent_id' => null, // По умолчанию создаем корневой элемент
        ];
    }

    public function withChildren(int $count = 2, int $depth = 1): Factory
    {
        return $this->afterCreating(function (Activity $parent) use ($count, $depth) {
            if ($depth <= 0) {
                return;
            }

            Activity::factory($count)
                ->state(function (array $attributes) use ($parent) {
                    return ['parent_id' => $parent->id];
                })
                ->withChildren($count, $depth - 1)
                ->create();
        });
    }
}
