<?php

namespace TypiCMS\Modules\Banners\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use TypiCMS\Modules\Core\Shells\Facades\TypiCMS;
use TypiCMS\Modules\Core\Shells\Observers\FileObserver;
use TypiCMS\Modules\Core\Shells\Observers\SlugObserver;
use TypiCMS\Modules\Core\Shells\Services\Cache\LaravelCache;
use TypiCMS\Modules\Banners\Shells\Models\Banner;
use TypiCMS\Modules\Banners\Shells\Models\BannerTranslation;
use TypiCMS\Modules\Banners\Shells\Repositories\CacheDecorator;
use TypiCMS\Modules\Banners\Shells\Repositories\EloquentBanner;

class ModuleProvider extends ServiceProvider
{
    public function boot()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/config.php', 'typicms.banners'
        );

        $modules = $this->app['config']['typicms']['modules'];

        $this->app['config']->set('typicms.modules', array_merge(['banners' => []], $modules));

        $this->loadViewsFrom(__DIR__.'/../resources/views/', 'banners');
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'banners');

        $this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/banners'),
        ], 'views');
        $this->publishes([
            __DIR__.'/../database' => base_path('database'),
        ], 'migrations');

        AliasLoader::getInstance()->alias(
            'Banners',
            'TypiCMS\Modules\Banners\Shells\Facades\Facade'
        );

        // Observers
        Banner::observe(new FileObserver());
    }

    public function register()
    {
        $app = $this->app;

        /*
         * Register route service provider
         */
        $app->register('TypiCMS\Modules\Banners\Shells\Providers\RouteServiceProvider');

        /*
         * Sidebar view composer
         */
        $app->view->composer('core::admin._sidebar', 'TypiCMS\Modules\Banners\Shells\Composers\SidebarViewComposer');

        /*
         * Add the page in the view.
         */
        $app->view->composer('banners::public.*', function ($view) {
            $view->page = TypiCMS::getPageLinkedToModule('banners');
        });

        $app->bind('TypiCMS\Modules\Banners\Shells\Repositories\BannerInterface', function (Application $app) {
            $repository = new EloquentBanner(new Banner());
            if (!config('typicms.cache')) {
                return $repository;
            }
            $laravelCache = new LaravelCache($app['cache'], 'banners', 10);

            return new CacheDecorator($repository, $laravelCache);
        });

        $this->registerSubModules();
    }
    /**
     * Register core modules.
     *
     * @return void
     */
    protected function registerSubModules()
    {
        $app = $this->app;
        $app->register(\TypiCMS\Modules\Bannerplaces\Shells\Providers\ModuleProvider::class);
    }
}
