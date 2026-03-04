<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Colocation;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        return [
            'colocation_id' => Colocation::factory(),
            'name' => $this->faker->word(),
            'description' => $this->faker->sentence(),
        ];
    }
}
