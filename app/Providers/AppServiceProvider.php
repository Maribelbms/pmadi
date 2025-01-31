<?php

namespace App\Providers;

use App\Models\Estudiante;
use App\Models\Revicion;
use App\Observers\RevicionObserver;
use App\Models\UnidadEducativa;

use App\Observers\EstudianteObserver;
use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Estudiante::observe(EstudianteObserver::class);
        Revicion::observe(RevicionObserver::class);
    }
}
