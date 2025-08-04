<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\Passport;
use Filament\Support\Facades\FilamentAsset;
use Filament\Support\Assets\Css;
use Illuminate\Support\Facades\Vite;
use Livewire\Livewire;

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
        Route::middleware('api')
            ->prefix('api')
            ->group(base_path('routes/api.php'));

        Passport::loadKeysFrom(__DIR__.'/../secrets/oauth');
        Passport::enablePasswordGrant();
        FilamentAsset::register([
            Css::make('global-styles', Vite::asset('resources/css/filament-custom.scss')),
        ]);
    }
}
