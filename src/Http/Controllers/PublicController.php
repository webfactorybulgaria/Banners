<?php

namespace TypiCMS\Modules\Banners\Http\Controllers;

use TypiCMS\Modules\Core\Http\Controllers\BasePublicController;
use TypiCMS\Modules\Banners\Repositories\BannerInterface;

class PublicController extends BasePublicController
{
    public function __construct(BannerInterface $banner)
    {
        parent::__construct($banner);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $models = $this->repository->all();

        return view('banners::public.index')
            ->with(compact('models'));
    }

    /**
     * Show news.
     *
     * @return \Illuminate\View\View
     */
    public function show($slug)
    {
        $model = $this->repository->bySlug($slug);

        return view('banners::public.show')
            ->with(compact('model'));
    }
}
