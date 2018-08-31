<?php

namespace Alacrity\Responses\Providers;

use Illuminate\Support\ServiceProvider;

class ResponseServiceProvider extends ServiceProvider
{
	 /**
     * Register bindings in the container.
     */
    public function register()
    {
    	$this->mergeConfigFrom(__DIR__ . '/../../config/response.php', 'response');
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
    	if ($this->app->runningInConsole()) {
            $this->offerPublishing();
        }
    }

     /**
     * Setup the resource publishing groups.
     */
    protected function offerPublishing()
    {
        $this->publishes([
            __DIR__ . '/../config/resource.php' => config_path('resource.php'),
        ], 'resource');
    }
}
