<?php

namespace TypiCMS\Modules\Bannerplaces\Http\Controllers;

use TypiCMS\Modules\Core\Shells\Http\Controllers\BaseAdminController;
use TypiCMS\Modules\Bannerplaces\Shells\Http\Requests\FormRequest;
use TypiCMS\Modules\Bannerplaces\Shells\Models\Bannerplace;
use TypiCMS\Modules\Bannerplaces\Shells\Repositories\BannerplaceInterface;

class AdminController extends BaseAdminController
{
    public function __construct(BannerplaceInterface $bannerplace)
    {
        parent::__construct($bannerplace);
    }

    /**
     * List models.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('bannerplaces::admin.index');
    }

    /**
     * Create form for a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $model = $this->repository->getModel();

        return view('bannerplaces::admin.create')
            ->with(compact('model'));
    }

    /**
     * Edit form for the specified resource.
     *
     * @param \TypiCMS\Modules\Bannerplaces\Shells\Models\Bannerplace $bannerplace
     *
     * @return \Illuminate\View\View
     */
    public function edit(Bannerplace $bannerplace)
    {
        return view('bannerplaces::admin.edit')
            ->with(['model' => $bannerplace]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \TypiCMS\Modules\Bannerplaces\Shells\Http\Requests\FormRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(FormRequest $request)
    {
        $bannerplace = $this->repository->create($request->all());

        return $this->redirect($request, $bannerplace);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \TypiCMS\Modules\Bannerplaces\Shells\Models\Bannerplace            $bannerplace
     * @param \TypiCMS\Modules\Bannerplaces\Shells\Http\Requests\FormRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Bannerplace $bannerplace, FormRequest $request)
    {
        $this->repository->update($request->all());

        return $this->redirect($request, $bannerplace);
    }
}
