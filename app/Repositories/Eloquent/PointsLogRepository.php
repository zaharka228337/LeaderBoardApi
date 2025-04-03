<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent;

use App\Dto\PointsToUserDTO;
use App\Enums\PeriodEnum;
use App\Models\PointLog;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/** Хранилище запросов к таблице с логами очков пользователей. */
final class PointsLogRepository extends ModelRepository
{
    /**
     * Создает в базе записи новых логов.
     *
     * @param Collection<PointsToUserDTO> $logs Коллекция очков пользователей.
     * @return void
     */
    public function createLogs(Collection $logs): void
    {
        $this->model->insert($logs->toArray());
    }

    /**
     * Возвращает топ-10 пользователей.
     *
     * @param PeriodEnum $period Период.
     * @return Collection Коллекция пользователей.
     */
    public function topTenUsers(PeriodEnum $period): Collection
    {
        return $this->model
            ->select('user_id', DB::raw('SUM(points) as total_points'))
            ->where('created_at', '>=', $period->datePeriod())
            ->groupBy('user_id')
            ->orderByDesc('total_points')
            ->limit(10)
            ->with('user:id,username')
            ->get()
            ->map(static function ($item, $index) {
                $item->position = $index + 1;

                return $item;
            });
    }

    /**
     * Возвращает место пользователя в рейтинге за указанный период.
     *
     * @param int $userID Идентификатор пользователя.
     * @param PeriodEnum $period Период.
     * @return int Место в рейтинге.
     */
    public function rank(int $userID, PeriodEnum $period): int
    {
        $rank = PointLog::selectRaw('RANK() OVER (ORDER BY SUM(points) DESC) AS user_rank')
            ->where('created_at', '>=', $period->datePeriod())
            ->groupBy('user_id')
            ->having('user_id', '=', $userID)
            ->value('user_rank');

        return $rank ? $rank + 1 : 0; // 0 - невозможно вычислить место пользователя, так как у него нет очков.
    }

    /**
     * Возвращает количество очков пользователя в рейтинге за указанный период.
     *
     * @param int $userId Идентификатор пользователя.
     * @param PeriodEnum $period Период.
     * @return int Количество очков.
     */
    public function score(int $userId, PeriodEnum $period): int
    {
        return (int) PointLog::where('user_id', $userId)
            ->where('created_at', '>=', $period->datePeriod())
            ->sum('points');
    }

    /** @inheritDoc */
    protected function modelClass(): string
    {
        return PointLog::class;
    }
}
