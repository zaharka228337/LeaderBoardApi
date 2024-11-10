<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Contracts\HasDtoContract;
use App\Dto\PointsToUserDTO;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Carbon;

final class PointsToUserRequest extends FormRequest implements HasDtoContract
{
    protected $stopOnFirstFailure = true;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'points' => ['required', 'integer', 'between:1,10000'],
            'user_id' => ['required', 'integer', 'exists:users,id'],
        ];
    }

    /** @inheritDoc */
    public function messages(): array
    {
        return [
            'user_id.*' => 'Пользователь не найден.',
            'points.required'  => 'Некорректные параметры запроса.',
            'points.between' => 'Значение :input атрибута :attribute не в диапазоне :min - :max.',
            'points.integer' => 'Атрибут :attribute должен быть целочисленным.',
        ];
    }

    /** @inheritDoc */
    protected function failedValidation(Validator $validator): void
    {
        $errorMessage = $validator->errors()->first();

        $statusCode = match ($errorMessage) {
            'Некорректные параметры запроса.' => 400,
            'Пользователь не найден.' => 404,
            default => 422,
        };

        throw new HttpResponseException(response()->json([
            'message' => $errorMessage,
        ], $statusCode));
    }

    /** @inheritDoc */
    public function validationData(): array
    {
        return array_merge($this->all(), [
            'user_id' => $this->route('userId'),
        ]);
    }

    /** @inheritDoc */
    public function toDto(): PointsToUserDTO
    {
        return new PointsToUserDTO(
            (int) $this->input('points'),
            (int) $this->route('userId'),
            Carbon::now(),
            Carbon::now()
        );
    }
}
