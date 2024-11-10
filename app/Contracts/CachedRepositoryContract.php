<?php

declare(strict_types=1);

namespace App\Contracts;

interface CachedRepositoryContract
{
    /**
     * Чистит кеш хранилища.
     *
     * @return bool Очистился ли кеш.
     */
    public function clearCache(): bool;
}
