<?php

namespace TypiCMS\Modules\Banners\Http\Controllers;

use TypiCMS\Modules\Core\Http\Controllers\BaseAdminController;
use TypiCMS\Modules\Banners\Http\Requests\FormRequest;
use TypiCMS\Modules\Banners\Models\Banner;
use TypiCMS\Modules\Banners\Repositories\BannerInterface;
use JavaScript;

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
        $module = $this->repository->getTable();
        $title = trans($module.'::global.name');
        $models = $this->repository->all(['bannerplace'], true);
        JavaScript::put('models', $models);

        return view('core::admin.index')
            ->with(compact('title', 'module', 'models'));
    }

    /**
     * Create form for a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $model = $this->repository->getModel();

        return view('core::admin.create')
            ->with(compact('model'));
    }

    /**
     * Edit form for the specified resource.
     *
     * @param \TypiCMS\Modules\Banners\Models\Banner $banner
     *
     * @return \Illuminate\View\View
     */
    public function edit(Banner $banner)
    {
        return view('core::admin.edit')
            ->with(['model' => $banner]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \TypiCMS\Modules\Banners\Http\Requests\FormRequest $request
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
     * @param \TypiCMS\Modules\Banners\Models\Banner            $banner
     * @param \TypiCMS\Modules\Banners\Http\Requests\FormRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Banner $banner, FormRequest $request)
    {
        $this->repository->update($request->all(), ['pages']);

        return $this->redirect($request, $banner);
    }
}
