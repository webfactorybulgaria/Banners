<?php

namespace TypiCMS\Modules\Banners\Http\Controllers;

use Illuminate\Support\Facades\Request;
use TypiCMS\Modules\Core\Shells\Http\Controllers\BaseApiController;
use TypiCMS\Modules\Banners\Shells\Models\Banner;
use TypiCMS\Modules\Banners\Shells\Repositories\BannerInterface as Repository;

class ApiController extends BaseApiController
{

    /**
     *  Array of endpoints that do not require authorization
     *  
     */
    protected $publicEndpoints = [];

    public function __construct(Repository $repository)
    {
        parent::__construct($repository);
    }

    /**
     * List resources.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($builder = null)
    {
        $builder = $this->repository->getModel()->with('bannerplace');

        return parent::index($builder);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store()
    {
        $model = $this->repository->create(Request::all());
        $error = $model ? false : true;

        return response()->json([
            'error' => $error,
            'model' => $model,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  $model
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update()
    {
        $updated = $this->repository->update(Request::all());

        return response()->json([
            'error' => !$updated,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \TypiCMS\Modules\Banners\Shells\Models\Banner $banner
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Banner $banner)
    {
        $deleted = $this->repository->delete($banner);

        return response()->json([
            'error' => !$deleted,
        ]);
    }
}
