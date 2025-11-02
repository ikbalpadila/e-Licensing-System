<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public const HOME = '/home'; // ← inilah yang dipanggil oleh RedirectIfAuthenticated

    public function boot(): void
    {
        //
    }
}
