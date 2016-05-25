<?php

namespace TypiCMS\Modules\Bannerplaces\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use TypiCMS\Modules\Core\Repositories\RepositoriesAbstract;

class EloquentBannerplace extends RepositoriesAbstract implements BannerplaceInterface
{
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function allForSelect()
    {
        $bannerplaces = $this->make()
            ->order()
            ->get()
            ->pluck('title', 'id')
            ->all();

        return [0 => ''] + $bannerplaces;
    }

    public function getBannerPlace($bannerPlace)
    {
        $bannerList = $this->make()
            ->whereHas(
            'translations',
            function(Builder $query) use ($bannerPlace) {
                $query->where('slug', $bannerPlace);
                $query->where('status', 1);
                $query->where('locale', config('app.locale'));
            })
            ->order()
            ->get()
            ->first();

        return $bannerList;
    }
}
