<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class MenuServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        view()->composer('*', function ($view) {
            if (\Illuminate\Support\Facades\Auth::guard('admin')->check()) {
                $user = \Illuminate\Support\Facades\Auth::guard('admin')->user();
                $groupIds = $user->groups->pluck('id')->toArray();

                // Fetch root menus that are allowed, with allowed children
                $menus = \App\Models\Menu::whereHas('groups', function($query) use ($groupIds) {
                        $query->whereIn('group_id', $groupIds);
                    })
                    ->whereNull('parent_id')
                    ->orderBy('order')
                    ->with(['children'])
                    ->get();

                // Transform to Tabler format
                $tablarMenu = $menus->map(function ($menu) {
                    $item = [
                        'text' => $menu->name,
                        'icon' => $menu->icon,
                        'url' => $menu->url ? url($menu->url) : '#',
                    ];

                    if ($menu->children->isNotEmpty()) {
                        $item['submenu'] = $menu->children->map(function ($child) {
                            return [
                                'text' => $child->name,
                                'icon' => $child->icon,
                                'url' => $child->url ? url($child->url) : '#',
                            ];
                        })->toArray();
                    }

                    return $item;
                })->toArray();

                \Illuminate\Support\Facades\Config::set('tablar.menu', $tablarMenu);
            }
        });
    }
}
