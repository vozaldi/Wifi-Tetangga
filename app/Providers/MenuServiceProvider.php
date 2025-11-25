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
                
                // Get all allowed menu IDs from user's groups
                $allowedMenuIds = $user->groups->flatMap(function ($group) {
                    return $group->menus->pluck('id');
                })->unique();

                // Fetch root menus that are allowed, with allowed children
                $menus = \App\Models\Menu::whereIn('id', $allowedMenuIds)
                    ->whereNull('parent_id')
                    ->orderBy('order')
                    ->with(['children' => function ($query) use ($allowedMenuIds) {
                        $query->whereIn('id', $allowedMenuIds)->orderBy('order');
                    }])
                    ->get();

                // Transform to Tabler format
                $tablarMenu = $menus->map(function ($menu) {
                    $item = [
                        'text' => $menu->name,
                        'icon' => $menu->icon,
                        'url' => $menu->url ? route($menu->url) : '#',
                    ];

                    if ($menu->children->isNotEmpty()) {
                        $item['submenu'] = $menu->children->map(function ($child) {
                            return [
                                'text' => $child->name,
                                'icon' => $child->icon,
                                'url' => $child->url ? route($child->url) : '#',
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
