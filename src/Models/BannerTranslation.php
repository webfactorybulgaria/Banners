<?php

namespace TypiCMS\Modules\Banners\Models;

use TypiCMS\Modules\Core\Shells\Models\BaseTranslation;

class BannerTranslation extends BaseTranslation
{
    /**
     * get the parent model.
     */
    public function owner()
    {
        return $this->belongsTo('TypiCMS\Modules\Banners\Shells\Models\Banner', 'banner_id')->withoutGlobalScopes();
    }
}
