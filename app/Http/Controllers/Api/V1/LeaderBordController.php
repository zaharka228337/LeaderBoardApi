<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Contracts\LeaderBordServiceContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\PeriodRequest;
use App\Http\Requests\PointsToUserRequest;
use App\Http\Resources\TopUsersCollection;
use App\Repositories\Eloquent\UserRepository;
use Illuminate\Http\JsonResponse;
use Psr\SimpleCache\InvalidArgumentException;

final class LeaderBordController extends Controller
{
    public function __construct(
        private readonly LeaderBordServiceContract $leaderBordService,
        private readonly UserRepository $userRepository
    ) {}

    /**
     * Добавляет очки пользователю.
     *
     * @throws InvalidArgumentException
     */
    public function addPoints(PointsToUserRequest $request): JsonResponse
    {
        $this->leaderBordService->addPointsToUser($request->toDto());

        return response()->json(['message' => 'Очки успешно добавлены.']);
    }

    /**
     * Возвращает топ-10 пользовательского рейтинга.
     */
    public function top(PeriodRequest $request): TopUsersCollection
    {
        $period = $request->period();

        return TopUsersCollection::make(
            $this->leaderBordService->topTen($period),
            $period
        );
    }

    /**
     * Возвращает место пользователя в рейтинге.
     */
    public function rank(PeriodRequest $request, string $userId): JsonResponse
    {
        if (! $this->userRepository->exists((int) $userId)) {
            return response()->json(['message' => 'Пользователь не найден'], 404);
        }

        $period = $request->period();

        return response()->json([
            'user_id' => $userId,
            'period' => $period->value,
            'score' => $this->leaderBordService->userScore((int) $userId, $period),
            'rank' => $this->leaderBordService->userRank((int) $userId, $period),
        ]);
    }
}
