<?php

namespace TypiCMS\Modules\Bannerplaces\Models;

use TypiCMS\Modules\Core\Models\BaseTranslation;

class BannerplaceTranslation extends BaseTranslation
{
    /**
     * get the parent model.
     */
    public function owner()
    {
        return $this->belongsTo('TypiCMS\Modules\Bannerplaces\Models\Bannerplace', 'bannerplace_id');
    }
}
