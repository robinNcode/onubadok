<?php namespace Robinncode\Onubadok;


use Illuminate\Support\ServiceProvider;
use Robinncode\Onubadok\Commands\ControllerPublish;
use Robinncode\Onubadok\Commands\OnubadokCommands;

class OnubadokServiceProvider extends ServiceProvider {

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                OnubadokCommands::class,
                ControllerPublish::class
            ]);
        }
    }

}
