<?php

namespace TypiCMS\Modules\Bannerplaces\Models;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Builder;
use Laracasts\Presenter\PresentableTrait;
use TypiCMS\Modules\Core\Models\Base;
use TypiCMS\Modules\History\Traits\Historable;
use TypiCMS\Modules\Banners\Models\Banner;


class Bannerplace extends Base
{
    use Historable;
    use PresentableTrait;
    use Translatable;

    protected $presenter = 'TypiCMS\Modules\Bannerplaces\Presenters\ModulePresenter';

    /**
     * Declare any properties that should be hidden from JSON Serialization.
     *
     * @var array
     */
    protected $hidden = [];

    protected $fillable = [
        // Translatable columns
        'title',
        'slug',
        'status',
    ];

    /**
     * Translatable model configs.
     *
     * @var array
     */
    public $translatedAttributes = [
        'title',
        'slug',
        'status',
    ];

    protected $appends = ['status', 'title'];

    /**
     * Columns that are file.
     *
     * @var array
     */
    public $attachments = [
    ];

    public function banners()
    {
        return $this->hasMany(Banner::class, 'bannerplace_id')
            ->with('translations')
            ->orderBy('position','asc');
    }

    public function bannersByPage()
    {
        return $this->hasMany(Banner::class, 'bannerplace_id')
            ->with('translations')
            // ->with('frontPages')
            ->has('frontPages')
            ->orderBy('position','asc');
    }

}
