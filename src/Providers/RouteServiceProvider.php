<?php

namespace TypiCMS\Modules\Banners\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;
use TypiCMS\Modules\Core\Shells\Facades\TypiCMS;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'TypiCMS\Modules\Banners\Shells\Http\Controllers';

    /**
     * Define the routes for the application.
     *
     * @param \Illuminate\Routing\Router $router
     *
     * @return void
     */
    public function map(Router $router)
    {
        $router->group(['namespace' => $this->namespace], function (Router $router) {

            /*
             * Admin routes
             */
            $router->get('admin/banners', 'AdminController@index')->name('admin::index-banners');
            $router->get('admin/banners/create', 'AdminController@create')->name('admin::create-banner');
            $router->get('admin/banners/{banner}/edit', 'AdminController@edit')->name('admin::edit-banner');
            $router->post('admin/banners', 'AdminController@store')->name('admin::store-banner');
            $router->put('admin/banners/{banner}', 'AdminController@update')->name('admin::update-banner');

            /*
             * API routes
             */
            $router->get('api/banners', 'ApiController@index')->name('api::index-banners');
            $router->put('api/banners/{banner}', 'ApiController@update')->name('api::update-banner');
            $router->delete('api/banners/{banner}', 'ApiController@destroy')->name('api::destroy-banner');

        });
    }
}
