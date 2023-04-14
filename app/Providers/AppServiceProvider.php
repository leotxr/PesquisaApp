<?php

namespace App\Providers;

use App\Http\Controllers\GetDadosClienteController;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        $requisicoes = (new GetDadosClienteController);

        view()->share('requisicoes', $requisicoes);

    }
}
