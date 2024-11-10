<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Repositories\Cache\LeaderBordCacheRepository;
use App\Repositories\Eloquent\PointsLogRepository;
use Illuminate\Console\Command;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand('users:synchronize-points', 'Синхронизирует очки пользователей из кеша в базе данных')]
final class SynchronizePoints extends Command
{
    // Не в конструкторе, чтобы каждый раз, когда поднимается ядро консоли, не создавались лишние зависимости.
    public function handle(LeaderBordCacheRepository $leaderBordCacheRepository, PointsLogRepository $pointsRepository): int
    {
        $logs = $leaderBordCacheRepository->getPointsToUsers();

        if (! $logs->isEmpty()) {
            $pointsRepository->createLogs($logs);
            $leaderBordCacheRepository->clearCache();
        }

        return self::SUCCESS;
    }
}
