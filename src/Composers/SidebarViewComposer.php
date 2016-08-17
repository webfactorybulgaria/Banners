<?php

namespace TypiCMS\Modules\Banners\Composers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Sidebar\SidebarGroup;
use Maatwebsite\Sidebar\SidebarItem;

class SidebarViewComposer
{
    public function compose(View $view)
    {
        $view->sidebar->group(trans('global.menus.content'), function (SidebarGroup $group) {
            $group->addItem(trans('banners::global.name'), function (SidebarItem $item) {
                $item->id = 'banners';
                $item->icon = config('typicms.banners.sidebar.icon');
                $item->weight = config('typicms.banners.sidebar.weight');
                $item->route('admin::index-banners');
                $item->append('admin::create-banner');
                $item->authorize(
                    Gate::allows('index-banners')
                );
            });
        });
    }
}
