<?php

namespace Database\Seeders;

use App\Models\PointLog;
use App\Models\User;
use Illuminate\Database\Seeder;

final class PointsLogSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()
            ->count(100)
            ->create()
            ->each(static function ($user): void {
                PointLog::factory()
                    ->for($user)
                    ->count(10)
                    ->today()
                    ->create();

                PointLog::factory()
                    ->for($user)
                    ->count(25)
                    ->lastWeek()
                    ->create();

                PointLog::factory()
                    ->for($user)
                    ->count(120)
                    ->lastMonth()
                    ->create();
            });
    }
}
