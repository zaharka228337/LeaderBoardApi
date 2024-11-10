<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/** Модель логов очков пользователей. */
final class PointLog extends Model
{
    use HasFactory;

    protected $table = 'points_logs';

    protected $fillable = [
        'user_id', 'points', 'updated_at', 'created_at'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
