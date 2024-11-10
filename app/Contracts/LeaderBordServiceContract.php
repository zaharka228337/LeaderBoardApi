<?php

namespace App\Contracts;

use App\Dto\PointsToUserDTO;
use App\Enums\PeriodEnum;
use Illuminate\Support\Collection;
use Psr\SimpleCache\InvalidArgumentException;

/** Контракт сервиса доски лидеров. */
interface LeaderBordServiceContract
{
    /**
     * Добавляет новый лог присвоения очков пользователю.
     *
     * @param PointsToUserDTO $pointsLog Данные очков пользователя.
     * @return void
     * @throws InvalidArgumentException
     */
    public function addPointsToUser(PointsToUserDTO $pointsLog): void;

    /**
     * Получает топ-10 пользователей за указанный период.
     *
     * @param PeriodEnum $period Период.
     * @return Collection Пользователи.
     */
    public function topTen(PeriodEnum $period): Collection;

    /**
     * Возвращает место пользователя в рейтинге за указанный период.
     *
     * @param int $userID Идентификатор пользователя.
     * @param PeriodEnum $period Период.
     * @return int Место в рейтинге.
     */
    public function userRank(int $userID, PeriodEnum $period): int;

    /**
     * Возвращает количество очков пользователя в рейтинге за указанный период.
     *
     * @param int $userID Идентификатор пользователя.
     * @param PeriodEnum $period Период.
     * @return int Количество очков.
     */
    public function userScore(int $userID, PeriodEnum $period): int;
}
