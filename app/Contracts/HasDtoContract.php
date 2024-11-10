<?php

namespace App\Contracts;

use App\Dto\DTO;

interface HasDtoContract
{
    /**
     * Кастит обьект в DTO.
     *
     * @return DTO
     */
    public function toDto(): DTO;
}
