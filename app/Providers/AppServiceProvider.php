<?php

namespace App\Providers;

use App\Contracts\LeaderBordServiceContract;
use App\Services\LeaderBordService;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

final class AppServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public $bindings = [
        LeaderBordServiceContract::class => LeaderBordService::class
    ];

    /** @inheritDoc */
    public function register(): void
    {
        if (! app()->isProduction()) {
            Model::shouldBeStrict();
        }
    }

    public function boot(): void
    {
        //
    }

    /** @inheritDoc */
    public function provides(): array
    {
        return [
            LeaderBordServiceContract::class
        ];
    }
}
