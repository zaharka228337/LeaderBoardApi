<?php

namespace App\Enums;

/** Подключение для очередей. */
enum OnConnectionEnum: string
{
    case REDIS = 'redis';
}
