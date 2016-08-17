<?php

namespace TypiCMS\Modules\Bannerplaces\Repositories;

use Illuminate\Database\Eloquent\Model;
use TypiCMS\Modules\Core\Shells\Repositories\RepositoriesAbstract;

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
            ->order()
            ->get()
            ->first();

        return $bannerList;
    }
}
