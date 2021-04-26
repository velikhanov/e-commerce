<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Http\ViewComposers\NavigationComposer;
use App\Http\ViewComposers\UsersPersonalDataComposer;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer(
            'inc.catalog', NavigationComposer::class
        );
        View::composer(
            'auth.inc.header', UsersPersonalDataComposer::class
        );
    }
}
