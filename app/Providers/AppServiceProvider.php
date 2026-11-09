<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // E.2 - Simulasi HTTPS (aktif bila FORCE_HTTPS=true di .env)
        if (env('FORCE_HTTPS', false)) {
            URL::forceScheme('https');
        }

        // E.3 - Hanya admin yang boleh menghapus data mahasiswa
        Gate::define('delete-mahasiswa', fn($user) => $user->role === 'admin');
    }
}
