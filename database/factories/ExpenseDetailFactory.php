<?php

namespace Database\Factories;

use App\Models\ExpenseDetail;
use App\Models\Expense;
use App\Models\ColocationMember;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExpenseDetailFactory extends Factory
{
    protected $model = ExpenseDetail::class;

    public function definition(): array
    {
        return [
            'expense_id' => Expense::factory(),
            'debtor_member_id' => ColocationMember::factory(),
            'amount' => $this->faker->randomFloat(2, 5, 200),
            'status' => 'PENDING',
        ];
    }
}
