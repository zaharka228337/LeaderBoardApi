<?php

declare(strict_types=1);

namespace App\Dto;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use JsonSerializable;
use UnitEnum;

abstract readonly class DTO implements Arrayable, Jsonable, JsonSerializable
{
    /** @inheritDoc */
    public function toArray(): array
    {
        $vars = get_object_vars($this);
        $exposed = [];

        foreach ($vars as $key => $value) {
            if ($value instanceof Arrayable) {
                $exposed[$key] = $value->toArray();
            }
            elseif ($value instanceof UnitEnum) {
                $exposed[$key] = $value->value;
            }
            else {
                $exposed[$key] = $value;
            }
        }

        return $exposed;
    }

    /** @inheritDoc */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    /** @inheritDoc */
    public function toJson($options = 0): false|string
    {
        return json_encode($this->toArray(), $options);
    }
}
