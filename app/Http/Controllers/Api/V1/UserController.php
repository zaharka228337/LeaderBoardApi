<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Jobs\CreateUser;
use Illuminate\Http\JsonResponse;

final class UserController extends Controller
{
    /**
     * Создание нового пользователя с уникальным именем.
     */
    public function store(CreateUserRequest $request): JsonResponse
    {
        CreateUser::dispatch($request->toDto());

        return response()->json(['message' => 'Пользователь успешно создан.'], 201);
    }
}
