<?php

namespace TypiCMS\Modules\Bannerplaces\Repositories;

use TypiCMS\Modules\Core\Repositories\CacheAbstractDecorator;
use TypiCMS\Modules\Core\Services\Cache\CacheInterface;

class CacheDecorator extends CacheAbstractDecorator implements BannerplaceInterface
{
    public function __construct(BannerplaceInterface $repo, CacheInterface $cache)
    {
        $this->repo = $repo;
        $this->cache = $cache;
    }

    /**
     * Get all translated pages for a select/options.
     *
     * @return array
     */
    public function allForSelect()
    {

        $cacheKey = md5(config('app.locale').'allForSelect');

        if ($this->cache->has($cacheKey)) {
            return $this->cache->get($cacheKey);
        }

        // Item not cached, retrieve it
        $models = $this->repo->allForSelect();

        // Store in cache for next request
        $this->cache->put($cacheKey, $models);

        return $models;
    }

    /**
     * Get all translated pages for a select/options.
     *
     * @return array
     */
    public function getBannerPlace($bannerPlace)
    {

        $cacheKey = md5(config('app.locale').'getBannerPlace'.$bannerPlace);

        if ($this->cache->has($cacheKey)) {
            return $this->cache->get($cacheKey);
        }

        // Item not cached, retrieve it
        $models = $this->repo->getBannerPlace($bannerPlace);

        // Store in cache for next request
        $this->cache->put($cacheKey, $models);

        return $models;
    }

}
