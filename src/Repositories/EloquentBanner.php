<?php

namespace TypiCMS\Modules\Banners\Repositories;

use Illuminate\Database\Eloquent\Model;
use TypiCMS\Modules\Core\Shells\Repositories\RepositoriesAbstract;
use Navigator;
use DB;
use View;

class EloquentBanner extends RepositoriesAbstract implements BannerInterface
{
    public function __construct(Model $model)
    {
        $this->model = $model;
    }


    public function getByBannerPlace($bannerPlaceSlug)
    {
        $currentPage = Navigator::currentPage();
        if (!$currentPage) return [];

        $banners = $this->make()
            ->join('bannerplaces', function($join) use ($bannerPlaceSlug) {
                $join->on('bannerplace_id', '=', 'bannerplaces.id')
                ->on('bannerplaces.slug', '=', DB::raw("'" . $bannerPlaceSlug."'"));
            })
            ->leftJoin('banner_page', function($join) use ($currentPage) {
                $pageId = $currentPage->id;
                $join->on('banners.id', '=', 'banner_id')
                ->on('page_id', '=', DB::raw($pageId));
            })
            ->where('all_pages', '=', DB::raw('(' . DB::getTablePrefix().'banner_page.banner_id is null)'))
            ->where('banner_translations.status', '=', 1)
            ->get()
            ->all();
        return $banners;

    }

    public function render($bannerPlaceSlug)
    {
        $banners = $this->getByBannerPlace($bannerPlaceSlug);
        $view = View::exists('banners::public._banners-' . $bannerPlaceSlug) ? 'banners::public._banners-' . $bannerPlaceSlug : 'banners::public._banners';
        return view($view, ['banners' => $banners]);
    }
}
