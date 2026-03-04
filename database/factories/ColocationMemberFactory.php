<?php

namespace Database\Factories;

use App\Models\ColocationMember;
use App\Models\Colocation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ColocationMemberFactory extends Factory
{
    protected $model = ColocationMember::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'colocation_id' => Colocation::factory(),
            'role' => $this->faker->randomElement(['Member', 'Owner']),
            'left_at' => null,
        ];
    }
}
