<?php

namespace Yasiao\Breadcrumb;

use Illuminate\Support\ServiceProvider;

class BreadcrumbServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * config file path.
     *
     * @var string
     */
    private $config = __DIR__ . '/../config/breadcrumbs.php';

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            $this->config => config_path('breadcrumb')
        ], 'breadcrumb');

        require config('breadcrumb.breadcrumb-file');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom($this->config, 'breadcrumb');
        $this->loadViewsFrom(__DIR__ . '/../view', 'breadcrumb');

        $this->app->singleton(Breadcrumb::class, function ($app) {
            $breadcrumb = new Breadcrumb();
            $breadcrumb->setTemplate(config('breadcrumb.default-template'));

            return $breadcrumb;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [Breadcrumb::class];
    }
}