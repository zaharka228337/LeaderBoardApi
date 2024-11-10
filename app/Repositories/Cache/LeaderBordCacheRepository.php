<?php

declare(strict_types=1);

namespace App\Repositories\Cache;

use App\Dto\PointsToUserDTO;
use App\Enums\PeriodEnum;
use Closure;
use Illuminate\Support\Collection;
use Psr\SimpleCache\InvalidArgumentException;

/** Кеш-хранилище доски лидеров. */
final class LeaderBordCacheRepository extends TaggedCacheRepository
{
    public array $tags = ['LeaderBord'];

    /** @var string Ключ очков пользователей в кеше. */
    private const string POINTS_TO_USERS = 'points_to_users';

    /**
     * Возвращает данные переданного ключа из кеша.
     *
     * @return Collection<PointsToUserDTO>
     */
    public function getPointsToUsers(): Collection
    {
        return $this->cache->get(self::POINTS_TO_USERS) ?? collect();
    }

    /**
     * Добавляет в кеш очки пользователя.
     *
     * @param Collection<PointsToUserDTO> $pointsToUsers
     * @return bool
     * @throws InvalidArgumentException
     */
    public function setPointsToUsers(Collection $pointsToUsers): bool
    {
        return $this->cache->set(self::POINTS_TO_USERS, $pointsToUsers);
    }

    /**
     * Ищет в хранилище кеша топ-10 пользователей за период.
     *
     * @param PeriodEnum $period Период.
     * @param Closure $closure Действие, которое необходимо выполнить, если в кеше не нашелся ключ.
     * @return Collection Топ-10 пользователей.
     */
    public function rememberTopUsersByPeriod(PeriodEnum $period, Closure $closure): Collection
    {
        return $this->cache->remember(
            "top_per:{$period->value}",
            now()->addMinute(),
            $closure
        );
    }
}
