<?php

namespace TypiCMS\Modules\Banners\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use TypiCMS\Modules\Core\Facades\TypiCMS;
use TypiCMS\Modules\Core\Observers\FileObserver;
use TypiCMS\Modules\Core\Observers\SlugObserver;
use TypiCMS\Modules\Core\Services\Cache\LaravelCache;
use TypiCMS\Modules\Banners\Models\Banner;
use TypiCMS\Modules\Banners\Models\BannerTranslation;
use TypiCMS\Modules\Banners\Repositories\CacheDecorator;
use TypiCMS\Modules\Banners\Repositories\EloquentBanner;

class ModuleProvider extends ServiceProvider
{
    public function boot()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/config.php', 'typicms.banners'
        );

        $modules = $this->app['config']['typicms']['modules'];
        $this->app['config']->set('typicms.modules', array_merge(['banners' => ['linkable_to_page']], $modules));

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
            'TypiCMS\Modules\Banners\Facades\Facade'
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
        $app->register('TypiCMS\Modules\Banners\Providers\RouteServiceProvider');

        /*
         * Sidebar view composer
         */
        $app->view->composer('core::admin._sidebar', 'TypiCMS\Modules\Banners\Composers\SidebarViewComposer');

        /*
         * Add the page in the view.
         */
        $app->view->composer('banners::public.*', function ($view) {
            $view->page = TypiCMS::getPageLinkedToModule('banners');
        });

        $app->bind('TypiCMS\Modules\Banners\Repositories\BannerInterface', function (Application $app) {
            $repository = new EloquentBanner(new Banner());
            if (!config('typicms.cache')) {
                return $repository;
            }
            $laravelCache = new LaravelCache($app['cache'], 'banners', 10);

            return new CacheDecorator($repository, $laravelCache);
        });
    }
}
