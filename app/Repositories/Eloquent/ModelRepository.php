<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent;

use App\Exceptions\UndefinedClassException;
use App\Exceptions\UndefinedModelClassException;
use Exception;
use Illuminate\Database\Eloquent\Model;

/** Абстрактное хранилище. */
abstract class ModelRepository
{
    /** @var Model Инстанс модели. */
    protected Model $model;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $modelClass = $this->modelClass();

        if (! class_exists($modelClass)) {
            throw new UndefinedClassException($modelClass);
        }

        if (! is_subclass_of($modelClass, Model::class)) {
            throw new UndefinedModelClassException($modelClass);
        }

        $this->model = app($modelClass);
    }

    /**
     * Необходимо вернуть класс модели, которую нужно использовать в для запросов хранилища.
     */
    abstract protected function modelClass(): string;
}
