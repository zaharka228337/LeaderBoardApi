<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\LeaderBordServiceContract;
use App\Dto\PointsToUserDTO;
use App\Enums\PeriodEnum;
use App\Repositories\Cache\LeaderBordCacheRepository;
use App\Repositories\Eloquent\PointsLogRepository;
use Illuminate\Support\Collection;

/** Сервис работы доски лидеров. */
final readonly class LeaderBordService implements LeaderBordServiceContract
{
    public function __construct(
        private LeaderBordCacheRepository $leaderBordCacheRepository,
        private PointsLogRepository $pointsLogRepository
    ) {}

    /** @inheritDoc */
    public function addPointsToUser(PointsToUserDTO $pointsLog): void
    {
        $this->leaderBordCacheRepository->setPointsToUsers(
            $this->leaderBordCacheRepository
                ->getPointsToUsers()
                ->add($pointsLog)
        );
    }

    /** @inheritDoc */
    public function topTen(PeriodEnum $period): Collection
    {
        return $this->leaderBordCacheRepository->rememberTopUsersByPeriod(
            $period,
            fn (): Collection => $this->pointsLogRepository->topTenUsers($period)
        );
    }

    /** @inheritDoc */
    public function userRank(int $userID, PeriodEnum $period): int
    {
        return $this->pointsLogRepository->rank($userID, $period);
    }

    /** @inheritDoc */
    public function userScore(int $userID, PeriodEnum $period): int
    {
        return $this->pointsLogRepository->score($userID, $period);
    }
}
