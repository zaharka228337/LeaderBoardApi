<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Dto\UserToCreateDTO;
use App\Enums\OnConnectionEnum;
use App\Enums\OnQueueEnum;
use App\Repositories\Eloquent\UserRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldBeUnique;

/** Отправялет в очередь задачу на создание нового пользователя. */
final class CreateUser implements ShouldQueue, ShouldBeUnique
{
    use Queueable;
    use InteractsWithQueue;

    public function __construct(protected UserToCreateDTO $userToCreateDTO,)
    {
        $this->onQueue(OnQueueEnum::USER_CREATE);
        $this->onConnection(OnConnectionEnum::REDIS);
    }

    public function handle(UserRepository $userRepository): void
    {
        $userRepository->create($this->userToCreateDTO);
    }

    /** Уникальное имя задания. */
    public function uniqueId(): string
    {
        return $this->userToCreateDTO->username;
    }
}
