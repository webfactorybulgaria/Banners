<?php

namespace TypiCMS\Modules\Bannerplaces\Composers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Sidebar\SidebarGroup;
use Maatwebsite\Sidebar\SidebarItem;

class SidebarViewComposer
{
    public function compose(View $view)
    {
        $view->sidebar->group(trans('global.menus.content'), function (SidebarGroup $group) {
            $group->addItem(trans('bannerplaces::global.name'), function (SidebarItem $item) {
                $item->id = 'bannerplaces';
                $item->icon = config('typicms.bannerplaces.sidebar.icon');
                $item->weight = config('typicms.bannerplaces.sidebar.weight');
                $item->route('admin::index-bannerplaces');
                $item->append('admin::create-bannerplace');
                $item->authorize(
                    Gate::allows('index-bannerplaces')
                );
            });
        });
    }
}
