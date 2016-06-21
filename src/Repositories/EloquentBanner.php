<?php

namespace TypiCMS\Modules\Banners\Repositories;

use Illuminate\Database\Eloquent\Model;
use TypiCMS\Modules\Core\Repositories\RepositoriesAbstract;

class EloquentBanner extends RepositoriesAbstract implements BannerInterface
{
    public function __construct(Model $model)
    {
        $this->model = $model;
    }
}
