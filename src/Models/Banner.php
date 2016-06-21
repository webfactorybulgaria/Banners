<?php

namespace TypiCMS\Modules\Banners\Models;

use Dimsav\Translatable\Translatable;
use Laracasts\Presenter\PresentableTrait;
use TypiCMS\Modules\Core\Models\Base;
use TypiCMS\Modules\History\Traits\Historable;
use TypiCMS\Modules\Bannerplaces\Models\Bannerplace;
use TypiCMS\Modules\Pages\Models\Page;

class Banner extends Base
{
    use Historable;
    use PresentableTrait;
    use Translatable;

    protected $presenter = 'TypiCMS\Modules\Banners\Presenters\ModulePresenter';

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
        'show_on_pages',
        // Translatable columns
        'title',
        'link',
        'status',
        'summary',
        'body',
        // banner_page table connection
        'page_id',
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

    protected $appends = ['status', 'title', 'thumb'];

    /**
     * Columns that are file.
     *
     * @var array
     */
    public $attachments = [
    ];

    /**
     * The banners belong to a bannerplace
     */
    public function bannerplace()
    {
        return $this->belongsTo(Bannerplace::class)->with('translations');
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
