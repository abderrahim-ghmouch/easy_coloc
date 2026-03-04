<?php

namespace Database\Factories;

use App\Models\InvitationToken;
use App\Models\Colocation;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class InvitationTokenFactory extends Factory
{
    protected $model = InvitationToken::class;

    public function definition(): array
    {
        return [
            'email' => $this->faker->safeEmail(),
            'token' => Str::uuid()->toString(),
            'expires_at' => now()->addDays(7),
            'colocation_id' => Colocation::factory(),
            'used_at' => null,
        ];
    }
}
