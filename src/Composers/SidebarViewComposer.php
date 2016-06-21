<?php

namespace TypiCMS\Modules\Banners\Composers;

use Illuminate\Contracts\View\View;
use Maatwebsite\Sidebar\SidebarGroup;
use Maatwebsite\Sidebar\SidebarItem;
use TypiCMS\Modules\Core\Composers\BaseSidebarViewComposer;

class SidebarViewComposer extends BaseSidebarViewComposer
{
    public function compose(View $view)
    {
        $view->sidebar->group(trans('global.menus.content'), function (SidebarGroup $group) {
            $group->addItem(trans('banners::global.name'), function (SidebarItem $item) {
                $item->icon = config('typicms.banners.sidebar.icon');
                $item->weight = config('typicms.banners.sidebar.weight');
                $item->route('admin.banners.index');
                $item->append('admin.banners.create');
                $item->authorize(
                    $this->auth->hasAccess('banners.index')
                );
            });
        });
    }
}
