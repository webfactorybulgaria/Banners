<?php

namespace TypiCMS\Modules\Bannerplaces\Facades;

use Illuminate\Support\Facades\Facade as MainFacade;

class Facade extends MainFacade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'TypiCMS\Modules\Bannerplaces\Shells\Repositories\BannerplaceInterface';
    }
}
