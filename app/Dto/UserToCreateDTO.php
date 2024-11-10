<?php

declare(strict_types=1);

namespace App\Dto;

/** Новый пользователь, которого необходимо создать. */
final readonly class UserToCreateDTO extends DTO
{
    /**
     * @param string $username Имя пользователя.
     */
    public function __construct(
        public string $username
    ) {}
}
