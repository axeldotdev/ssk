<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Spatie\CpuLoadHealthCheck\CpuLoadCheck;
use Spatie\Health\Checks\Checks\CacheCheck;
use Spatie\Health\Checks\Checks\DatabaseCheck;
use Spatie\Health\Checks\Checks\DatabaseConnectionCountCheck;
use Spatie\Health\Checks\Checks\DatabaseSizeCheck;
use Spatie\Health\Checks\Checks\DatabaseTableSizeCheck;
use Spatie\Health\Checks\Checks\DebugModeCheck;
use Spatie\Health\Checks\Checks\HorizonCheck;
use Spatie\Health\Checks\Checks\MeiliSearchCheck;
use Spatie\Health\Checks\Checks\OptimizedAppCheck;
use Spatie\Health\Checks\Checks\QueueCheck;
use Spatie\Health\Checks\Checks\RedisCheck;
use Spatie\Health\Checks\Checks\RedisMemoryUsageCheck;
use Spatie\Health\Checks\Checks\ScheduleCheck;
use Spatie\Health\Checks\Checks\UsedDiskSpaceCheck;
use Spatie\Health\Facades\Health;

class HealthServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Gate::define('viewHealth', function (User $user) {
            return str($user->email)->endsWith('@orvea.io');
        });

        Health::checks([
            ...$this->serverChecks(),
            ...$this->databaseChecks(),
            ...$this->processChecks(),
        ]);
    }

    public function serverChecks(): array
    {
        return [
            CpuLoadCheck::new()
                ->failWhenLoadIsHigherInTheLast5Minutes(2.0)
                ->failWhenLoadIsHigherInTheLast15Minutes(1.5),
            UsedDiskSpaceCheck::new()
                ->warnWhenUsedSpaceIsAbovePercentage(60)
                ->failWhenUsedSpaceIsAbovePercentage(80),
        ];
    }

    public function databaseChecks(): array
    {
        return [
            DatabaseCheck::new(),
            DatabaseConnectionCountCheck::new()
                ->warnWhenMoreConnectionsThan(50)
                ->failWhenMoreConnectionsThan(100),
            DatabaseSizeCheck::new()
                ->failWhenSizeAboveGb(5.0),
            DatabaseTableSizeCheck::new()
                ->table('activity_log', maxSizeInMb: 1_000)
                ->table('health_check_result_history_items', maxSizeInMb: 1_000)
                ->table('pulse_aggregates', maxSizeInMb: 1_000)
                ->table('telescope_entries', maxSizeInMb: 1_000)
                ->table('pulse_entries', maxSizeInMb: 1_000),
        ];
    }

    public function processChecks(): array
    {
        return [
            CacheCheck::new(),
            OptimizedAppCheck::new(),
            DebugModeCheck::new(),
            RedisCheck::new(),
            RedisMemoryUsageCheck::new()->failWhenAboveMb(1000),
            QueueCheck::new(),
            HorizonCheck::new(),
            ScheduleCheck::new(),
            MeiliSearchCheck::new(),
        ];
    }
}
