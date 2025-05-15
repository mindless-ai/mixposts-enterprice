<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class MixpostServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        $this->loadViewsFrom(resource_path('js/vendor/mixpost'), 'mixpost');
    }
}
