<?php

namespace App\Enums;

use Illuminate\Support\Carbon;

/** Период времени для подсчета рейтинга. */
enum PeriodEnum: string
{
    /** День. */
    case DAY = 'day';

    /** Неделя. */
    case WEEK = 'week';

    /** Месяц. */
    case MONTH = 'month';

    /**
     * Возвращает период в формате объекта Carbon.
     *
     * @return Carbon
     */
    public function datePeriod(): Carbon
    {
        return match ($this) {
            self::DAY => Carbon::now()->startOfDay(),
            self::WEEK => Carbon::now()->startOfWeek(),
            self::MONTH => Carbon::now()->startOfMonth(),
        };
    }
}
