<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('auth:clear-resets')->daily();
Schedule::command('cache:prune-stale-tags')->daily();
Schedule::command('model:prune')->daily();
Schedule::command('sanctum:prune-expired')->daily();
Schedule::command('telescope:prune')->daily();
Schedule::command('activitylog:clean')->daily();

Schedule::command('backup:clean')->daily()->at('01:00');
Schedule::command('backup:run')->daily()->at('01:30');

Schedule::command('health:check')->everyMinute();
Schedule::command('health:queue-check-heartbeat')->everyMinute();
Schedule::command('health:schedule-check-heartbeat')->everyMinute();
