<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', static function (Blueprint $table): void {
            $table->id();
            $table->string('username')
                ->unique()
                ->index()
                ->comment('Имя пользователя');
            $table->timestamps();
        });

        Schema::create('points_logs', static function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')
                ->comment('Пользователь')
                ->index()
                ->references('id')
                ->cascadeOnDelete()
                ->on('users');
            $table->unsignedSmallInteger('points')
                ->comment('Очки');
            $table->timestamps();

            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('points_logs');
        Schema::dropIfExists('users');
    }
};
