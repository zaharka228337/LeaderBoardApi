<?php

namespace App\Exceptions;

use Exception;

/** Класс модели не существует. */
final class UndefinedModelClassException extends Exception
{
    public function __construct(string $className)
    {
        parent::__construct("Класс {$className} не расширяется классом Model.");
    }
}
