<?php

namespace TypiCMS\Modules\Bannerplaces\Providers;

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
    protected $namespace = 'TypiCMS\Modules\Bannerplaces\Shells\Http\Controllers';

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
            $router->get('admin/bannerplaces', 'AdminController@index')->name('admin::index-bannerplaces');
            $router->get('admin/bannerplaces/create', 'AdminController@create')->name('admin::create-bannerplace');
            $router->get('admin/bannerplaces/{bannerplace}/edit', 'AdminController@edit')->name('admin::edit-bannerplace');
            $router->post('admin/bannerplaces', 'AdminController@store')->name('admin::store-bannerplace');
            $router->put('admin/bannerplaces/{bannerplace}', 'AdminController@update')->name('admin::update-bannerplace');

            /*
             * API routes
             */
            $router->get('api/bannerplaces', 'ApiController@index')->name('api::index-bannerplaces');
            $router->put('api/bannerplaces/{bannerplace}', 'ApiController@update')->name('api::update-bannerplace');
            $router->delete('api/bannerplaces/{bannerplace}', 'ApiController@destroy')->name('api::destroy-bannerplace');
        });
    }
}
