<?php

namespace TypiCMS\Modules\Banners\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;
use TypiCMS\Modules\Core\Facades\TypiCMS;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'TypiCMS\Modules\Banners\Http\Controllers';

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
             * Front office routes
             */
            if ($page = TypiCMS::getPageLinkedToModule('banners')) {
                $options = $page->private ? ['middleware' => 'auth'] : [];
                foreach (config('translatable.locales') as $lang) {
                    if ($page->translate($lang)->status && $uri = $page->uri($lang)) {
                        $router->get($uri, $options + ['as' => $lang.'.banners', 'uses' => 'PublicController@index']);
                        $router->get($uri.'/{slug}', $options + ['as' => $lang.'.banners.slug', 'uses' => 'PublicController@show']);
                    }
                }
            }

            /*
             * Admin routes
             */
            $router->get('admin/banners', ['as' => 'admin.banners.index', 'uses' => 'AdminController@index']);
            $router->get('admin/banners/create', ['as' => 'admin.banners.create', 'uses' => 'AdminController@create']);
            $router->get('admin/banners/{banner}/edit', ['as' => 'admin.banners.edit', 'uses' => 'AdminController@edit']);
            $router->post('admin/banners', ['as' => 'admin.banners.store', 'uses' => 'AdminController@store']);
            $router->put('admin/banners/{banner}', ['as' => 'admin.banners.update', 'uses' => 'AdminController@update']);
            $router->post('admin/banners/sort', ['as' => 'admin.banners.sort', 'uses' => 'AdminController@sort']);

            /*
             * API routes
             */
            $router->get('api/banners', ['as' => 'api.banners.index', 'uses' => 'ApiController@index']);
            $router->put('api/banners/{banner}', ['as' => 'api.banners.update', 'uses' => 'ApiController@update']);
            $router->delete('api/banners/{banner}', ['as' => 'api.banners.destroy', 'uses' => 'ApiController@destroy']);
        });
    }
}
