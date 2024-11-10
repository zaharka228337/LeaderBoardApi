<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('users:synchronize-points')
    ->everyFifteenSeconds()
    ->onOneServer()
    ->runInBackground()
    ->withoutOverlapping();

