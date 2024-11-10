<?php

namespace App\Exceptions;

use Exception;

/** Класс не существует. */
final class UndefinedClassException extends Exception
{
    public function __construct(string $className)
    {
        parent::__construct("Класс {$className} не существует.");
    }
}
