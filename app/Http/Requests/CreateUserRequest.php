<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Contracts\HasDtoContract;
use App\Dto\UserToCreateDTO;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

final class CreateUserRequest extends FormRequest implements HasDtoContract
{
    protected $stopOnFirstFailure = true;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'username' => ['required', 'unique:users,username', 'max:50', 'min:3', 'regex:/^[a-zA-Z0-9_]+$/']
        ];
    }

    /** @inheritDoc */
    public function messages(): array
    {
        return [
            'username.required' => 'Некорректные параметры запроса.',
            'username.unique'   => 'Пользователь с таким именем уже существует.',
            'username.min'      => 'Атрибут :attribute должен содержать более 3 символов.',
            'username.max'      => 'Атрибут :attribute должен содержать менее 50 символов.',
            'username.regex'    => 'Атрибут :attribute должен состоять только из латинских букв, цифр и нижнего подчёркивания.',
        ];
    }

    /** @inheritDoc */
    protected function failedValidation(Validator $validator): void
    {
        $errorMessage = $validator->errors()->first('username');

        $statusCode = match ($errorMessage) {
            'Некорректные параметры запроса.' => 400,
            'Пользователь с таким именем уже существует.' => 409,
            default => 422,
        };

        throw new HttpResponseException(response()->json([
            'message' => $errorMessage,
        ], $statusCode));
    }

    /** @inheritDoc */
    public function toDto(): UserToCreateDTO
    {
        return new UserToCreateDTO($this->input('username'));
    }
}
