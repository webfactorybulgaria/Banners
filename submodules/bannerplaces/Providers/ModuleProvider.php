<?php

namespace TypiCMS\Modules\Bannerplaces\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use TypiCMS\Modules\Core\Shells\Facades\TypiCMS;
use TypiCMS\Modules\Core\Shells\Observers\FileObserver;
use TypiCMS\Modules\Core\Shells\Observers\SlugObserver;
use TypiCMS\Modules\Core\Shells\Services\Cache\LaravelCache;
use TypiCMS\Modules\Bannerplaces\Shells\Models\Bannerplace;
use TypiCMS\Modules\Bannerplaces\Shells\Repositories\CacheDecorator;
use TypiCMS\Modules\Bannerplaces\Shells\Repositories\EloquentBannerplace;

class ModuleProvider extends ServiceProvider
{
    public function boot()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/config.php', 'typicms.bannerplaces'
        );

        $modules = $this->app['config']['typicms']['modules'];
        $this->app['config']->set('typicms.modules', array_merge(['bannerplaces' => ['linkable_to_page']], $modules));

        $this->loadViewsFrom(__DIR__.'/../resources/views/', 'bannerplaces');
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'bannerplaces');

        $this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/bannerplaces'),
        ], 'views');
        $this->publishes([
            __DIR__.'/../database' => base_path('database'),
        ], 'migrations');

        AliasLoader::getInstance()->alias(
            'Bannerplaces',
            'TypiCMS\Modules\Bannerplaces\Shells\Facades\Facade'
        );

        // Observers
        Bannerplace::observe(new SlugObserver());
    }

    public function register()
    {
        $app = $this->app;

        /*
         * Register route service provider
         */
        $app->register('TypiCMS\Modules\Bannerplaces\Shells\Providers\RouteServiceProvider');

        /*
         * Sidebar view composer
         */
        $app->view->composer('core::admin._sidebar', 'TypiCMS\Modules\Bannerplaces\Shells\Composers\SidebarViewComposer');

        /*
         * Add the page in the view.
         */
        $app->view->composer('bannerplaces::public.*', function ($view) {
            $view->page = TypiCMS::getPageLinkedToModule('bannerplaces');
        });

        $app->bind('TypiCMS\Modules\Bannerplaces\Shells\Repositories\BannerplaceInterface', function (Application $app) {
            $repository = new EloquentBannerplace(new Bannerplace());
            if (!config('typicms.cache')) {
                return $repository;
            }
            $laravelCache = new LaravelCache($app['cache'], 'bannerplaces', 10);

            return new CacheDecorator($repository, $laravelCache);
        });
    }
}
