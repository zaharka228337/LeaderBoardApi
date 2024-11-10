<?php

namespace Database\Factories;

use App\Models\PointLog;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

final class PointLogFactory extends Factory
{
    protected $model = PointLog::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'points' => $this->faker->numberBetween(1, 10000),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    public function today(): PointLogFactory
    {
        return $this->state([
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function lastWeek(): PointLogFactory
    {
        return $this->state(function () {
            return [
                'created_at' => now()->subDays(rand(1, 7)),
                'updated_at' => now()->subDays(rand(1, 7)),
            ];
        });
    }

    public function lastMonth(): PointLogFactory
    {
        return $this->state(function () {
            return [
                'created_at' => now()->subDays(rand(8, 30)),
                'updated_at' => now()->subDays(rand(8, 30)),
            ];
        });
    }
}
