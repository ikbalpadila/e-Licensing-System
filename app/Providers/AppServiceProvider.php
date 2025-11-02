<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Contracts\PermitApplicationRepositoryInterface;
use App\Repositories\Eloquent\PermitApplicationRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Binding Repository Interface ke Implementasinya
        $this->app->bind(
            PermitApplicationRepositoryInterface::class,
            PermitApplicationRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Jika nanti perlu inisialisasi tambahan (misal observer, policy, dll)
        // bisa diletakkan di sini.
    }
}
