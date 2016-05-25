<?php

namespace TypiCMS\Modules\Bannerplaces\Composers;

use Illuminate\Contracts\View\View;
use Maatwebsite\Sidebar\SidebarGroup;
use Maatwebsite\Sidebar\SidebarItem;
use TypiCMS\Modules\Core\Composers\BaseSidebarViewComposer;

class SidebarViewComposer extends BaseSidebarViewComposer
{
    public function compose(View $view)
    {
        $view->sidebar->group(trans('global.menus.content'), function (SidebarGroup $group) {
            $group->addItem(trans('bannerplaces::global.name'), function (SidebarItem $item) {
                $item->icon = config('typicms.bannerplaces.sidebar.icon');
                $item->weight = config('typicms.bannerplaces.sidebar.weight');
                $item->route('admin.bannerplaces.index');
                $item->append('admin.bannerplaces.create');
                $item->authorize(
                    $this->auth->hasAccess('bannerplaces.index')
                );
            });
        });
    }
}
