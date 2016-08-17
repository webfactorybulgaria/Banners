<?php

namespace TypiCMS\Modules\Banners\Http\Controllers;

use TypiCMS\Modules\Core\Shells\Http\Controllers\BaseAdminController;
use TypiCMS\Modules\Banners\Shells\Http\Requests\FormRequest;
use TypiCMS\Modules\Banners\Shells\Models\Banner;
use TypiCMS\Modules\Banners\Shells\Repositories\BannerInterface;
use TypiCMS\Modules\Bannerplaces\Shells\Models\Bannerplace;

class AdminController extends BaseAdminController
{
    public function __construct(BannerInterface $banner)
    {
        parent::__construct($banner);
    }

    /**
     * List models.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $bannerplaces = Bannerplace::all();
        app('JavaScript')->put('options.bannerplaces', $bannerplaces);

        return view('banners::admin.index');
    }

    /**
     * Create form for a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $model = $this->repository->getModel();

        return view('banners::admin.create')
            ->with(compact('model'));
    }

    /**
     * Edit form for the specified resource.
     *
     * @param \TypiCMS\Modules\Banners\Shells\Models\Banner $banner
     *
     * @return \Illuminate\View\View
     */
    public function edit(Banner $banner)
    {
        return view('banners::admin.edit')
            ->with(['model' => $banner]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \TypiCMS\Modules\Banners\Shells\Http\Requests\FormRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(FormRequest $request)
    {
        $banner = $this->repository->create($request->all(), ['pages']);

        return $this->redirect($request, $banner);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \TypiCMS\Modules\Banners\Shells\Models\Banner            $banner
     * @param \TypiCMS\Modules\Banners\Shells\Http\Requests\FormRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Banner $banner, FormRequest $request)
    {
        $this->repository->update($request->all(), ['pages']);

        return $this->redirect($request, $banner);
    }
}
