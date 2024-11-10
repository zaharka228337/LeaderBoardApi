<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\PeriodEnum;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

/** Период времени для подсчёта рейтинга. */
final class PeriodRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;

    public function rules(): array
    {
        return [
            'period' => ['required'],
        ];
    }

    /** @inheritDoc */
    public function messages(): array
    {
        return [
            'period.required' => 'Некорректные параметры запроса.',
        ];
    }

    /** @inheritDoc */
    protected function failedValidation(Validator $validator): void
    {
        $errorMessage = $validator->errors()->first('period');

        $statusCode = match ($errorMessage) {
            'Некорректные параметры запроса.' => 400,
            default => 422,
        };

        throw new HttpResponseException(response()->json([
            'message' => $errorMessage,
        ], $statusCode));
    }

    /**
     * Возвращает провалидированные период.
     *
     * @return PeriodEnum Экземпляр периода.
     */
    public function period(): PeriodEnum
    {
        $period = $this->input('period');

        if (!in_array($period, array_column(PeriodEnum::cases(), 'value'))) {
            return PeriodEnum::DAY;
        }

        return PeriodEnum::from($period);
    }
}
