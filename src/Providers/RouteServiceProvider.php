<?php

namespace TypiCMS\Modules\Bannerplaces\Providers;

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
    protected $namespace = 'TypiCMS\Modules\Bannerplaces\Http\Controllers';

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
            if ($page = TypiCMS::getPageLinkedToModule('bannerplaces')) {
                $options = $page->private ? ['middleware' => 'auth'] : [];
                foreach (config('translatable.locales') as $lang) {
                    if ($page->translate($lang)->status && $uri = $page->uri($lang)) {
                        $router->get($uri, $options + ['as' => $lang.'.bannerplaces', 'uses' => 'PublicController@index']);
                        $router->get($uri.'/{slug}', $options + ['as' => $lang.'.bannerplaces.slug', 'uses' => 'PublicController@show']);
                    }
                }
            }

            /*
             * Admin routes
             */
            $router->get('admin/bannerplaces', ['as' => 'admin.bannerplaces.index', 'uses' => 'AdminController@index']);
            $router->get('admin/bannerplaces/create', ['as' => 'admin.bannerplaces.create', 'uses' => 'AdminController@create']);
            $router->get('admin/bannerplaces/{bannerplace}/edit', ['as' => 'admin.bannerplaces.edit', 'uses' => 'AdminController@edit']);
            $router->post('admin/bannerplaces', ['as' => 'admin.bannerplaces.store', 'uses' => 'AdminController@store']);
            $router->put('admin/bannerplaces/{bannerplace}', ['as' => 'admin.bannerplaces.update', 'uses' => 'AdminController@update']);

            /*
             * API routes
             */
            $router->get('api/bannerplaces', ['as' => 'api.bannerplaces.index', 'uses' => 'ApiController@index']);
            $router->put('api/bannerplaces/{bannerplace}', ['as' => 'api.bannerplaces.update', 'uses' => 'ApiController@update']);
            $router->delete('api/bannerplaces/{bannerplace}', ['as' => 'api.bannerplaces.destroy', 'uses' => 'ApiController@destroy']);
        });
    }
}
