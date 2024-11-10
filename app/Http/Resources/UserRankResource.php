<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** Ресурс пользователя в рейтинге. */
final class UserRankResource extends JsonResource
{
    /**
     * Сериализация ресурса в массив.
     *
     * @param Request $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        return [
            'position' => $this->position,
            'user_id' => $this->user_id,
            'username' => $this->user->username,
            'score' => (int) $this->total_points,
        ];
    }
}
