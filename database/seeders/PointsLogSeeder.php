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
                    ->today()
                    ->create();

                PointLog::factory()
                    ->for($user)
                    ->count(7)
                    ->lastWeek()
                    ->create();

                PointLog::factory()
                    ->for($user)
                    ->count(23)
                    ->lastMonth()
                    ->create();
            });
    }
}
