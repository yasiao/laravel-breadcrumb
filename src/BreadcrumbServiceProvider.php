<?php

namespace Yasiao\Breadcrumb;

use Illuminate\Contracts\Foundation\Application;
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
    private $config = null;

    /**
     * BreadcrumbServiceProvider constructor.
     *
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        parent::__construct($app);

        $this->config = dirname(__DIR__) . '/config/breadcrumb.php';
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            $this->config => config_path('breadcrumb.php')
        ], 'breadcrumb');

        if (!$this->checkBreadcrumbFileExist()) {
            throw new FileNotFoundException('The Breadcrumb file is not found in ' . config('breadcrumb.breadcrumb-file-path'));
        }

        require config('breadcrumb.breadcrumb-file-path');
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
     * Check the breadcrumb file already exist.
     *
     * @return bool
     */
    private function checkBreadcrumbFileExist()
    {
        return file_exists(config('breadcrumb.breadcrumb-file-path'));
    }
}