<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Enums\PeriodEnum;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

/** Топ рейтинга пользователей. */
final class TopUsersCollection extends ResourceCollection
{
    public function __construct($resource, private readonly PeriodEnum $period)
    {
        parent::__construct($resource);
    }

    /** @inheritDoc */
    public function toArray(Request $request): array
    {
        return [
            'message' => 'Запрос выполнен успешно.',
            'period' => $this->period->value,
            'top' => UserRankResource::collection($this->collection),
        ];
    }
}
