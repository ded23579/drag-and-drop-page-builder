<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ReactGrapesJSProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
        // Publish React integration assets
        $this->publishes([
            resource_path('js/components') => public_path('js/components'),
            resource_path('js/pages') => public_path('js/pages'),
        ], 'react-components');
        
        // Add React integration assets to Vite configuration if needed
        if (file_exists(public_path('build/manifest.json'))) {
            // This would be used if integrating with Laravel Vite
        }
    }
}