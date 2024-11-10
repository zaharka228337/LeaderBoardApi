<?php

declare(strict_types=1);

namespace App\Dto;

use Illuminate\Support\Carbon;

/** Очки, которые нужно добавить для пользователя. */
final readonly class PointsToUserDTO extends DTO
{
    /**
     * @param int $points Количество очков.
     * @param int $userId Идентификатор пользователя.
     * @param Carbon $updatedAt Временная метка обновления данных.
     * @param Carbon $createdAt Временная метка создания данных.
     */
    public function __construct(
        public int $points,
        public int $userId,
        public Carbon $updatedAt,
        public Carbon $createdAt,
    ) {}

    /** @inheritDoc */
    public function toArray(): array
    {
        return [
            'points'     => $this->points,
            'user_id'    => $this->userId,
            'updated_at' => $this->updatedAt,
            'created_at' => $this->createdAt,
        ];
    }
}
