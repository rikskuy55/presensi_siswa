<?php

use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\GuruMiddleware;
use App\Http\Middleware\IsWaliKelas;
use App\Http\Middleware\KepalaSekolahMiddleware;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Middleware\SiswaMiddleware;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Daftarkan middleware baru
        $middleware->alias([
            'role' => RoleMiddleware::class,
            'admin' => AdminMiddleware::class,
            'siswa' => SiswaMiddleware::class,
            'kepala_sekolah' => KepalaSekolahMiddleware::class,
            'isWaliKelas' => IsWaliKelas::class,
            'guru' => GuruMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->withSchedule(function (Schedule $schedule) {
        $schedule->command('app:update-alpa-status')
        ->dailyAt('20:05')
        ->evenInMaintenanceMode();
    })->create();
