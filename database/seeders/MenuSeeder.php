<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $menus = [
            ['name' => 'Dashboard', 'url' => '/admin/dashboard', 'icon' => 'ti ti-dashboard', 'order' => 1],
            ['name' => 'Cabang', 'url' => '/admin/branch', 'icon' => 'ti ti-building', 'order' => 2],
            [
                'name' => 'Master Data', 'icon' => 'ti ti-database', 'order' => 3,
                'children' => [
                    ['name' => 'Produk', 'url' => '/admin/data/product', 'icon' => 'ti ti-box', 'order' => 1],
                    ['name' => 'Varian', 'url' => '/admin/data/variant', 'icon' => 'ti ti-versions', 'order' => 2],
                ]
            ],
            [
                'name' => 'Produk', 'icon' => 'ti ti-package', 'order' => 4,
                'children' => [
                    ['name' => 'Produk per Cabang', 'url' => '/admin/data/branch-product', 'icon' => 'ti ti-building-store', 'order' => 1],
                ]
            ],
            ['name' => 'Invoice', 'url' => '/admin/invoice', 'icon' => 'ti ti-file-invoice', 'order' => 5],
            ['name' => 'User', 'url' => '/admin/user', 'icon' => 'ti ti-users', 'order' => 6],
            ['name' => 'Pengaturan', 'url' => '/admin/setting', 'icon' => 'ti ti-settings', 'order' => 7],
        ];

        foreach ($menus as $menuData) {
            $children = $menuData['children'] ?? [];
            unset($menuData['children']);

            $menu = \App\Models\Menu::create($menuData);

            foreach ($children as $childData) {
                $childData['parent_id'] = $menu->id;
                \App\Models\Menu::create($childData);
            }
        }
    }
}
