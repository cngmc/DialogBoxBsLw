<?php
namespace Cngmc\DialogBoxBsLw;

class DialogBoxBsLwServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function boot(): void
    {
        if (!$this->isLivewireInstalled()) {
            $this->warnLivewireNotInstalled();
        }
        //$this->loadRoutesFrom(__DIR__ . '/../routes/test.php');

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'dialogboxbslw');
        // Example usage: return view('AlertBoxBsLw::welcome');
        \Illuminate\Support\Facades\Blade::component('dialogboxbslw::components.dialogbox', 'dialogbox');

        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/dialogboxbslw'),
        ], 'dialogboxbslw');
        //php artisan vendor:publish --tag=dialogboxbslw --force
    }

    public function register(): void
    {
        //$this->mergeConfigFrom(__DIR__ . '/../config/dialogboxbslw.php', 'dialogboxbslw');
    }

    private function isLivewireInstalled()
    {
        return class_exists(\Livewire\Livewire::class);
    }

    private function warnLivewireNotInstalled(): void
    {
        if ($this->app->runningInConsole()) {
            $this->app->terminating(function() {
                echo "\033[1;31mLivewire must be installed to use the DialogBoxBsLw package.\033[0m\n" . PHP_EOL;
            });
        }
    }
}
