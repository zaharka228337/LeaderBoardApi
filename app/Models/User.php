<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/** Модель пользователя. */
final class User extends Model
{
    use HasFactory;

    protected $fillable = ['username'];

    public function points(): HasMany
    {
        return $this->hasMany(PointLog::class);
    }
}
