<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent;

use App\Dto\UserToCreateDTO;
use App\Models\User;

/** Хранилище запросов к модели пользвателя. */
final class UserRepository extends ModelRepository
{
    /**
     * Создает пользователя.
     *
     * @param UserToCreateDTO $toCreateDTO Данные для создания пользователя.
     * @return User Модель созданного пользователя.
     */
    public function create(UserToCreateDTO $toCreateDTO): User
    {
        return $this->model::create([
            'username' => $toCreateDTO->username
        ]);
    }

    /**
     * Проверяет существует ли пользователь.
     *
     * @param int $userId Уникальный идентификатор пользователя.
     * @return bool True - существует, false - не существует.
     */
    public function exists(int $userId): bool
    {
        return $this->model::where('id', $userId)->exists();
    }

    /** @inheritDoc */
    protected function modelClass(): string
    {
        return User::class;
    }
}
