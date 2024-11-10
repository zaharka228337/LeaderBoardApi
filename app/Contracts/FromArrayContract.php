<?php

namespace App\Contracts;

interface FromArrayContract
{
    /**
     * Создает обьект текущего класса из данных массива.
     *
     * @param array $data Массив данных.
     * @return $this Обьект текущего класса.
     */
    public function fromArray(array $data): static;
}
