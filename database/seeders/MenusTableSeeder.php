<?php

namespace Ophim\Core\Database\Seeders;

use Backpack\Settings\app\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Ophim\Core\Models\Category;
use Ophim\Core\Models\Menu;
use Ophim\Core\Models\Region;
use Ophim\Core\Models\Theme;

class MenusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $homeMenu = Menu::firstOrCreate(['name' => 'Trang chủ', 'link' => '/']);
        $categoryGroup = Menu::firstOrCreate(['name' => 'Thể loại', 'link' => '#']);
        $categories = Category::all();
        foreach ($categories as $category) {
            Menu::updateOrCreate([
                'name' => $category->name,
            ], [
                'link' => '/the-loai/' . $category->slug,
                'parent_id' => $categoryGroup->id
            ]);
        }

        $regionGroup = Menu::firstOrCreate(['name' => 'Quốc gia', 'link' => '#']);
        $regions = Region::all();
        foreach ($regions as $region) {
            Menu::updateOrCreate([
                'name' => $region->name,
            ], [
                'link' => '/quoc-gia/' . $region->slug,
                'parent_id' => $regionGroup->id
            ]);
        }
    }
}
