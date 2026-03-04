<?php

namespace Database\Factories;

use App\Models\Expense;
use App\Models\Category;
use App\Models\ColocationMember;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExpenseFactory extends Factory
{
    protected $model = Expense::class;

    public function definition(): array
    {
        return [
            'category_id' => Category::factory(),
            'creator_member_id' => ColocationMember::factory(),
            'title' => $this->faker->sentence(3),
            'amount' => $this->faker->randomFloat(2, 5, 500),
        ];
    }
}
