<?php

namespace TypiCMS\Modules\Banners\Repositories;

use TypiCMS\Modules\Core\Shells\Repositories\CacheAbstractDecorator;
use TypiCMS\Modules\Core\Shells\Services\Cache\CacheInterface;
use Navigator;

class CacheDecorator extends CacheAbstractDecorator implements BannerInterface
{
    public function __construct(BannerInterface $repo, CacheInterface $cache)
    {
        $this->repo = $repo;
        $this->cache = $cache;
    }

    public function getByBannerPlace($bannerPlaceSlug)
    {
        $currentPage = Navigator::currentPage();
        if (!$currentPage) return [];

        $cacheKey = md5($this->cachePrefix().'Banners-getByBannerPlace-'.$bannerPlaceSlug.'-'.Navigator::currentPage()->id);

        if ($this->cache->has($cacheKey)) {
            return $this->cache->get($cacheKey);
        }

        // Item not cached, retrieve it
        $models = $this->repo->render($bannerPlaceSlug);

        // Store in cache for next request
        $this->cache->put($cacheKey, $models);

        return $models;
    }

    public function render($bannerPlaceSlug)
    {
        $currentPage = Navigator::currentPage();
        if (!$currentPage) return '';

        $cacheKey = md5($this->cachePrefix().'Banners-render-'.$bannerPlaceSlug.'-'.$currentPage->id);

        if ($this->cache->has($cacheKey)) {
            return $this->cache->get($cacheKey);
        }

        // Item not cached, retrieve it
        $html = $this->repo->render($bannerPlaceSlug);

        // Store in cache for next request
        $this->cache->put($cacheKey, $html);

        return $html;
    }

}
