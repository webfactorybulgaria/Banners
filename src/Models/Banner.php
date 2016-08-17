<?php

namespace TypiCMS\Modules\Banners\Models;

use TypiCMS\Modules\Core\Shells\Traits\Translatable;
use Laracasts\Presenter\PresentableTrait;
use TypiCMS\Modules\Core\Shells\Models\Base;
use TypiCMS\Modules\History\Shells\Traits\Historable;
use TypiCMS\Modules\Bannerplaces\Shells\Models\Bannerplace;
use TypiCMS\Modules\Pages\Shells\Models\Page;

class Banner extends Base
{
    use Historable;
    use PresentableTrait;
    use Translatable;

    protected $presenter = 'TypiCMS\Modules\Banners\Shells\Presenters\ModulePresenter';

    /**
     * Declare any properties that should be hidden from JSON Serialization.
     *
     * @var array
     */
    protected $hidden = [];

    protected $fillable = [
        'image',
        'bannerplace_id',
        'position',
        'all_pages',
        // Translatable columns
        'title',
        'link',
        'status',
        'summary',
        'body',
        // banner_page table connection
        //'page_id',
    ];

    /**
     * Translatable model configs.
     *
     * @var array
     */
    public $translatedAttributes = [
        'title',
        'link',
        'status',
        'summary',
        'body',
    ];

    protected $appends = ['thumb'];

    /**
     * Append thumb attribute.
     *
     * @return string
     */
    public function getThumbAttribute()
    {
        return $this->present()->thumbSrc(200);
    }

    /**
     * The banners belong to a bannerplace
     */
    public function bannerplace()
    {
        return $this->belongsTo(Bannerplace::class);
    }

    /**
     * The banners belong to many pages
     */
    public function pages()
    {
        return $this->belongsToMany(Page::class);
    }

    /**
     * The banners belong to many pages
     */
    public function frontPages()
    {
        $page = app('public.navigator')->currentPage()->id;
        return $this->belongsToMany(Page::class)->where('page_id', '=', $page);
    }
}
